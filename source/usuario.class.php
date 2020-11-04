<?php

class Usuario
{
	public $perfil = array (
			_PERFIL_ADMINISTRADOR => 'Administrador',
			_PERFIL_EDITOR => 'Editor',
			_PERFIL_AUTOR => 'Autor',
			_PERFIL_RESTRITO => 'Restrito'
			);
	public $cod_objeto;
	public $usuario;
	public $cod_cookie;
	public $browser_ver;
	public $is_explorer;
	public $action;
	public $inicio_secao;
		
	function Usuario(&$_page)
	{
		if (!isset($_SESSION['perfil']) || !is_array($_SESSION['perfil']))
			$this->CarregarInfoPerfis($_page);
			
		if (isset($_SESSION['usuario']['cod_usuario']))
			$this->PegaPerfil($_page);
		else
		{
			$this->cod_perfil=_PERFIL_DEFAULT;
			$_SESSION['usuario']['perfil'] = _PERFIL_DEFAULT;
		}
			
	}
		
	function EstaLogado($nivelInferior=NULL)
	{
		//echo ">>>".$_SESSION['usuario']['perfil'];
		if ($nivelInferior && isset($_SESSION['usuario']['perfil'])) {
			if ($_SESSION['usuario']['perfil'] > $nivelInferior)
				return null;
			else 
				return is_array($_SESSION['usuario']);
		}
		else 
			return (isset($_SESSION['usuario']) && is_array($_SESSION['usuario']));
	}

	function EstaLogadoMilitarizado()
	{
		if (($this->EstaLogado(_PERFIL_EDITOR)) || ($_SESSION['usuario']['perfil'] == _PERFIL_MILITARIZADO))
			return is_array($_SESSION['usuario']);
		else 
			return null;
	}

	function Login(&$_page, $usuario, $senha)
	{
		$usuario = str_replace("'","",$usuario);
		$senha = str_replace("'","",$senha);
		
		$sql = "select cod_usuario, 
			nome,
			email,
			chefia,
			secao,
			ramal,
			data_atualizacao 
			from usuario 
			where valido=1 
			and login='$usuario' 
			and senha='".md5($senha)."'";

		$rs = $_page->_db->ExecSQL($sql);
		if ($rs->_numOfRows>0){
			if((int)$rs->fields['data_atualizacao'] < (int)date("Ymd")) {
				return false;
			} else {
				$_SESSION["usuario"] = $rs->fields;
				
				$data_validade = strftime("%Y%m%d", strtotime("+6 month"));
				$sql = "update usuario set data_atualizacao = ".ConverteData($data_validade,16)." where cod_usuario = ".$_SESSION["usuario"]["cod_usuario"];
				$rs2 = $_page->_db->ExecSQL($sql);
				
				$this->Carregar($_page);
				return true;
			}
		} else {
			$_SESSION['usuario']="";
		}

		return false;
	}
		
	function Logout()
	{
		$cod_objeto=_ROOT;
		$_SESSION['usuario'] = "";
		$_SESSION['perfil'] = "";
	}
		
	function Carregar(&$_page)
	{
		$this->CarregarDireitos($_page);
		$this->CarregarInfoPerfis($_page);
		$this->PegaPerfil($_page);
	}

	function CarregarDireitos(&$_page)
	{
		$sql = "select cod_objeto, 
		cod_perfil 
		from 
		usuarioxobjetoxperfil 
		where 
		cod_usuario=".$_SESSION['usuario']['cod_usuario'];
		$rs = $_page->_db->ExecSQL($sql);
		while ($row = $rs->FetchRow()) {
			$_SESSION['usuario']['direitos'][$row['cod_objeto']] = $row['cod_perfil'];
		}
	}

	function CarregarInfoPerfis(&$_page)
	{
		$sql = "select cod_perfil,
		acao,
		script,
		donooupublicado,
		sopublicado,
		sodono,
		naomenu,
		ordem 
		from 
		infoperfil 
		order by ordem";

		$_SESSION['perfil']=array();

		$rs = $_page->_db->ExecSQL($sql);
		while ($rs->FetchRow()){
			$_SESSION['perfil'][$rs->fields['cod_perfil']][]=$rs->fields;
		}
		
		for ($f = 1; $f < count($_SESSION['perfil']); $f++)
		{
			$_SESSION['perfil'][$f] = array_merge($_SESSION['perfil'][$f], $_SESSION['perfil'][_PERFIL_DEFAULT]);
		}
		
	}
		
	function PegaPerfil(&$_page)
	{
		if (!$_page->_objeto->Valor($_page, 'cod_objeto')) return false;
		$caminho[]=$_page->_objeto->Valor($_page, 'cod_objeto');
		$caminho = array_merge($caminho, array_reverse($_page->_objeto->CaminhoObjeto));
		foreach ($caminho as $cod_objeto)
		{
			if (isset($_SESSION['usuario']['direitos'][$cod_objeto]))
			{
				$this->cod_perfil = $_SESSION['usuario']['direitos'][$cod_objeto];
				$_SESSION['usuario']['perfil'] = $this->cod_perfil;
				return $this->cod_perfil;
			}
		}
		$this->cod_perfil=0;
		return false;
	}
		
	function PodeExecutar(&$_page, $script)
	{
		//Administrador Pode Tudo
		if ($this->cod_perfil==_PERFIL_ADMINISTRADOR)
		{
			switch($script){
				case '/do/delete':
					if ($_page->_objeto->Valor($_page, "objetosistema"))
						return false;
					break;
			} // switch
			return true;
		}
			
		if (is_array($_SESSION['perfil'][$this->cod_perfil]))
		{
			foreach ($_SESSION['perfil'][$this->cod_perfil] as $perfil)
			{
				if (!$perfil['script']) continue;
				$preg = "%".$perfil['script']."%is";
				
				if (preg_match($preg,$script))
				{
					if ($perfil['donooupublicado'])
					{
						
						//Testar se o usuario e dono do objeto ou se o objeto esta publicado
						if (!($_page->_objeto->metadados['cod_usuario']==$_SESSION['usuario']['cod_usuario']) && !($_page->_objeto->Publicado())){
							return false;
						}
					}
					if ($perfil['sopublicado'])
					{
						//Testar se o objeto esta publicado
						if (!$_page->_objeto->Publicado())
						{
							return false;
						}
					}
					if ($perfil['sodono'])
					{
						//Testar se o usuario e dono do objeto
						if ($_page->_objeto->metadados['cod_usuario']!=$_SESSION['usuario']['cod_usuario'])
						{
							return false;
						}
					}
					return true;
				}
			}
		}
		return false;
	}

	function ContaPendencias(&$_page)
	{
		//$sql = 'select count(*) as contador from pendencia where cod_usuario='.$_SESSION['usuario']["cod_usuario"];
		$sql = "select count(*) as contador from pendencia";
		$rs = $_page->_db->ExecSQL($sql);
		$row = $rs->fields;
		return $row['contador'];
	}

	function ContaRejeitados(&$_page)
	{
		$sql = "select count(*) as contador 
		from objeto 
		where cod_usuario=".$_SESSION['usuario']["cod_usuario"]. " 
		and cod_status="._STATUS_REJEITADO." 
		and apagado=0";
		$rs = $_page->_db->ExecSQL($sql);
		$row = $rs->fields;
		return $row['contador'];
	}

	function Menu(&$_page)
	{
		//if (!is_array($this->acao))
		{
			foreach ($_SESSION['perfil'][$this->cod_perfil] as $perfil)
			{
				if ($perfil['naomenu']==0	)
				{
					
					$ok=true;
					if ($perfil['donooupublicado'])
					{
						//Testar se o usuario e dono do objeto
						if (!($_page->_objeto->metadados['cod_usuario']==$_SESSION['usuario']['cod_usuario']) && !($_page->_objeto->Publicado()))
						$ok=false;
					}
					if ($perfil['sopublicado'])
					{
						//Testar se o objeto esta publicado
						if (!$_page->_objeto->Publicado())
						$ok=false;
					}
					if ($perfil['sodono'])
					{
						//Testar se o objeto est� publicado
						if ($_page->_objeto->metadados['cod_usuario']!=$_SESSION['usuario']['cod_usuario'])
						$ok=false;
					}
					if ($ok)
					{
						$this->acao[]=array
						 (
							'ordem' => $perfil['ordem'],
							'acao' => $perfil['acao'],
							'script'=> preg_replace("|[.*?]|is","",$perfil['script'])
						);	
					}
				}
			}
			
				
			$this->acao = $this->Filtrar($_page, $this->acao);
			foreach ($this->acao as $key=>$item)
			{
				$this->ordenacao[]=$item['ordem'];
				$this->scripts[]=$item['script'];
				$this->textos[]=$item['acao'];
			}
		}
		array_multisort($this->acao,$this->textos,$this->ordenacao);
		
		return $this->acao;
	}

	function PodeApagar(&$_page)
	{
		if (!is_array ($this->scripts))
			$this->Menu($_page);
		if (in_array('/do/delete',$this->scripts))
			return true;
		else
			return false;
	}
		
	function Filtrar (&$_page, $acao)
	{
		foreach ($acao as $item)
		{
			switch ($item['script'])
			{
				case '/manage/create':
					if ($_page->_objeto->PodeTerFilhos())
					{
						$out[]=$item;
					}
					break;
				case '/login/index':
					break;
				case '/do/recuperar_objeto':
					if ($_page->_objeto->Valor($_page, "apagado"))
						$out[]=$item;
					break;	
				case '/do/delete':
					if (($_page->_objeto->Valor($_page, "cod_objeto")!=_ROOT) && (!$_page->_objeto->Valor($_page, "apagado")))
						$out[]=$item;
					break;
				case '/manage/new':
					if ($_page->_objeto->Valor($_page, "temfilhos"))
						$out[]=$item;
					break;
				case '/do/publicar':
					if ($_page->_objeto->Valor($_page, "cod_status")!=_STATUS_PUBLICADO)
						$out[]=$item;
					break;
				case '/do/rejeitar':
					if ($_page->_objeto->Valor($_page, 'cod_objeto')!=_ROOT)
					{
					 	if (($_page->_objeto->Valor($_page, "cod_status")==_STATUS_SUBMETIDO) || ($_page->_objeto->Valor($_page, "cod_status")==_STATUS_PUBLICADO))
							$out[]=$item;
					}
					break;
				case '/do/submeter':
					if (($_page->_objeto->Valor($_page, "cod_status")==_STATUS_PRIVADO) || ($_page->_objeto->Valor($_page, "cod_status")==_STATUS_REJEITADO))
						$out[]=$item;
					break;
				case '/do/pendentes':
					$conta=$this->ContaPendencias($_page);
					if ($conta)
					{
						//$item['acao']=$conta .' objeto(s) para aprova��o';
						$item['acao'] = 'Objetos para aprova&ccedil;&atilde;o';
						$out[]=$item;
					}
					break;
				case '/do/rejeitados':
					$conta=$this->ContaRejeitados($_page);
					if ($conta)
					{
						$item['acao']=$conta.' objeto(s) para revis&atilde;o';
						$out[]=$item;
					}
					break;
				default:
					$out[]=$item;
			}
		}
			return $out;
	}
		
}
?>