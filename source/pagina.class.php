<?php

define ('_LOG_BORDER_COLOR',"#1e69a2");
define ('_OPERACAO_OBJETO_RECUPERAR',4); // STATUS DE LOG CRIADO EM 15/05/2007
define ('_OPERACAO_OBJETO_REMOVER',3);
define ('_OPERACAO_OBJETO_EDITAR',2);
define ('_OPERACAO_OBJETO_CRIAR',1);
	
$_OPERACAO_OBJETO = array('','Criar','Editar','Apagar','Recuperar');

class Pagina
{
		
	public $_db;
	public $_adminobjeto;
	public $_objeto;
	public $_usuario;
	public $_parser;
	public $_administracao;
	public $_log;
	public $cod_objeto;
	public $inicio;
	public $TempoDeExecucao;

	function __construct(&$_db, $cod_objeto=_ROOT)
	{
		$this->cod_objeto = $cod_objeto;
		$this->_db = $_db;
		$this->_adminobjeto = new AdminObjeto();
		$this->_objeto = new Objeto($this, $cod_objeto);
		$this->_usuario = new Usuario($this);
		$this->_parser = new Parse();
		$this->_rss = new Rss();
		$this->inicio = $this->getmicrotime();
	}
		
	function getmicrotime()
	{
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
	}

	function IncluirAdmin()
	{
		include ('administracao.class.php');
		include ('classelog.class.php');
		include ('index2.class.php');
		$this->_administracao = new Administracao($this);
		$this->_log = new ClasseLog($this);
	}

	function Executar($acao,$incluirheader=false, $irpararaiz=false)
	{
		if (strpos($acao,"/do/")!==false)
		{
			if ($this->_usuario->PodeExecutar($this, $acao))
			{
				$this->IncluirAdmin();
				$tmpArrPerfilObjeto = $this->_administracao->PegaDireitosDoUsuario($this, $_SESSION['usuario']['cod_usuario']);
				
				//Avalia se e alguma operacao com a pilha
				if ($acao=='/do/copy')
				{
					$this->_administracao->CopiarObjetoParaPilha($this, $cod_objeto);
					$acao = '/content/view';
					return true;
				}
				elseif ($acao=='/do/paste')
				{
					if ($this->_objeto->PodeTerFilhos())
					{
						$this->_administracao->MoverObjeto($this, -1,$cod_objeto);
						$acao = '/content/view';
					}
					return true;
				}
				elseif ($acao=='/do/pastecopy')
				{
					if ($this->_objeto->PodeTerFilhos())
					{
						$this->_administracao->DuplicarObjeto($this, -1,$cod_objeto);
						$acao = '/content/view';
					}
					return true;
				}
				// Fim dos testes sobre operacoes com a pilha

				if (!strpos($acao,'_post') && !isset($_GET["naoincluirheader"]))
				{
					include("header_publicare.php");
				}
				$path = split("/",$acao);
				$acaoSistema=$path[count($path)-1];
				
				if (strpos($acaoSistema,'.php')!==false){
					include ('manage/'.$acaoSistema);
				}
				else{
					include ('manage/'.$acaoSistema.'.php');
				}

				if (!strpos($acao,'_post'))
				{
					include ("footer_publicare.php");
				}
			}
			else
			{
				$this->ExibirMensagemProibido($acao);
			}
			
//			$this->TempoDeExecucao=$this->getmicrotime()-$this->inicio;
//			echo ">>> TEMPO DE EXECUCAO: ".$this->TempoDeExecucao." <<<";
			return true;
		}

		if ($irpararaiz)
		{
			$this->_objeto = new Objeto($this, _ROOT);
		}

		if (isset($ucode))
		{
			$sql = "Select cod_objeto from unlock_table where cod_unlock=".$ucode;
			$rs = $this->_db->ExecSQL($sql);
			$unlock=false;
			if ($row = $rs->FetchRow())
			{
				if ($row['cod_objeto']==$cod_objeto)
				{
					$sql = "delete from unlock_table where cod_unlock=".$ucode;
					$this->_db->ExecSQL($sql);
					$unlock=true;
				}
			}
		}
		
		if (($this->_usuario->PodeExecutar($this, $acao)) || (isset($unlock)))
		{
			//Inclui Classe Administracao ou Cria entrada no Log de Acesso
			if ($acao!="/content/view")
			{
				$this->IncluirAdmin();
			}
			else
			{
				if ($this->_objeto->Valor($this, 'apagado'))
				{
					$this->ExibirMensagemProibido($acao);
					return false;
				}
//				$this->AdicionarEntradaLog();
			}
				
			//Inclui o prefixo da classe para ajudar na decisao de qual include deve ser usado
			switch ($acao)
			{
				case "/manage/edit":
					break;
				case "/content/view":
					$acaoCompleta = $acao."_".$this->_objeto->metadados['prefixoclasse'];
					break;
				default:
					$acaoCompleta = $acao;
					break;
			}

			$path = split("/",$acao);
			$acaoSistema=$path[count($path)-1];

			switch ($acao)
			{
				case "/manage/edit":
					$incluirheader = false;
					if (file_exists($_SERVER['DOCUMENT_ROOT'].$acaoCompleta.".php"))
					{
						$incluir[0] = $_SERVER['DOCUMENT_ROOT'].$acaoCompleta.".php";
						$incluir[1] = 0;
					}
					else
					{
						$incluir[0] = _dirManage.$acaoSistema.'_basic.php';
						$incluir[1] = 0;
					}
					break;					
				case "/manage/new":
					$incluirheader = false;
					$incluir[0] = $acaoSistema.'.php';
					$incluir[1] = 0;
					break;
					
				case "/content/view":
					if (isset($_GET["naoincluirheader"])) 
					{
						$incluirheader = false;
						$header_admin = true;
					}
					else $incluirheader = true;
					$tmpScriptAtual = $this->_objeto->metadados['script_exibir'];
					
			//Configurado um script para exibicao
					if ((isset($_GET['execview'])) && (!preg_match("/_protegido.*/",$tmpScriptAtual))){
						
						if (file_exists($_SERVER['DOCUMENT_ROOT']."/html/skin/".$this->_objeto->metadados['prefixopele']."/view_".$_GET['execview'].".php"))
						{
							$incluir[0] = $_SERVER['DOCUMENT_ROOT']."/html/skin/".$this->_objeto->metadados['prefixopele']."/view_".$_GET['execview'].".php";
							$incluir[1] = 1;
							break;
						}
						elseif (file_exists($_SERVER['DOCUMENT_ROOT']."/html/skin/".$this->_objeto->metadados['prefixopele']."/view_".$_GET['execview'].".pbl"))
						{
							$incluir[0] = $_SERVER['DOCUMENT_ROOT']."/html/skin/".$this->_objeto->metadados['prefixopele']."/view_".$_GET['execview'].".pbl";
							$incluir[1] = 1;
							break;
						} 
						
						
						if (file_exists($_SERVER['DOCUMENT_ROOT']."/html/template/view_".$_GET['execview'].".php"))
						{
							$incluir[0] = $_SERVER['DOCUMENT_ROOT']."/html/template/view_".$_GET['execview'].".php";
							$incluir[1] = 1;
							break;
						}
						elseif (file_exists($_SERVER['DOCUMENT_ROOT']."/html/template/view_".$_GET['execview'].".pbl"))
						{
							$incluir[0] = $_SERVER['DOCUMENT_ROOT']."/html/template/view_".$_GET['execview'].".pbl";
							$incluir[1] = 1;
							break;
						}
					}

					if ($this->_objeto->metadados['script_exibir'] && file_exists($_SERVER['DOCUMENT_ROOT'].$this->_objeto->metadados['script_exibir']))
					{
						$incluir[0] = $_SERVER['DOCUMENT_ROOT'].$this->_objeto->metadados['script_exibir'];
						$incluir[1] = 1;
						break;
					}

			//Nao esta configurado um script para exibicao - Existe um skin?
					if ($this->_objeto->metadados['cod_pele'])
					{

						if (file_exists($_SERVER['DOCUMENT_ROOT']."/html/skin/".$this->_objeto->metadados['prefixopele']."/view_".$this->_objeto->metadados['prefixoclasse'].".php"))
						{
							$incluir[0] = $_SERVER['DOCUMENT_ROOT']."/html/skin/".$this->_objeto->metadados['prefixopele']."/view_".$this->_objeto->metadados['prefixoclasse'].".php";
							$incluir[1] = 1;
							break;
							//Script de pele incluido - Finalizar
						}
						elseif (file_exists($_SERVER['DOCUMENT_ROOT']."/html/skin/".$this->_objeto->metadados['prefixopele']."/view_".$this->_objeto->metadados['prefixoclasse'].".pbl"))
						{
							$incluir[0] = $_SERVER['DOCUMENT_ROOT']."/html/skin/".$this->_objeto->metadados['prefixopele']."/view_".$this->_objeto->metadados['prefixoclasse'].".pbl";
							$incluir[1] = 1;
							break;
							//Script de pele incluido - Finalizar
						}
					}
						
			//Nao esta configurado uma skin. Incluir arquivos padrao
					if (file_exists($_SERVER['DOCUMENT_ROOT']."/html/template/view_".$this->_objeto->metadados['prefixoclasse'].".php"))
					{
						$incluir[0] = $_SERVER['DOCUMENT_ROOT']."/html/template/view_".$this->_objeto->metadados['prefixoclasse'].".php";
						$incluir[1] = 1;
					}
					elseif (file_exists($_SERVER['DOCUMENT_ROOT']."/html/template/view_".$this->_objeto->metadados['prefixoclasse'].".pbl"))
					{
						$incluir[0] = $_SERVER['DOCUMENT_ROOT']."/html/template/view_".$this->_objeto->metadados['prefixoclasse'].".pbl";
						$incluir[1] = 1;
					}
					elseif (file_exists($_SERVER['DOCUMENT_ROOT']."/html/template/view_basic.php"))
					{
						$incluir[0] = $_SERVER['DOCUMENT_ROOT']."/html/template/view_basic.php";
						$incluir[1] = 1;
					}
					elseif (file_exists($_SERVER['DOCUMENT_ROOT']."/html/template/view_basic.pbl"))
					{
						$incluir[0] = $_SERVER['DOCUMENT_ROOT']."/html/template/view_basic.pbl";
						$incluir[1] = 1;
						
					}
					else 
					{
						echo "<span class=\"txtErro\">N&atilde;o foram encontrados os arquivos de SCRIPT DE EXIBI&Ccedil;&Atilde;O.</span>";
					}
					break;
					
				case "/html/objects/search_result":
					$incluirheader = true;
					$incluir[0] = $_SERVER['DOCUMENT_ROOT']."$acaoCompleta.php";
					$incluir[1] = 1;
					break;
				default:
//					exit();
					$incluirheader = false;
					if (file_exists($_SERVER['DOCUMENT_ROOT']."$acaoCompleta.php"))
					{
						$incluir[0] = $_SERVER['DOCUMENT_ROOT']."$acaoCompleta.php";
						$incluir[1] = 0;
					}
					elseif (file_exists($_SERVER['DOCUMENT_ROOT']."$acaoCompleta.pbl"))
					{
						$incluir[0] = $_SERVER['DOCUMENT_ROOT']."$acaoCompleta.pbl";
						$incluir[1] = 0;
					}
					else
					{
						if (preg_match('|\/manage\/(.*?)_.*|is', $acao, $matches))
						{
							if (file_exists(_dirManage.$matches[1].'_basic.php'))
							{
								$incluir[0] = $matches[1].'_basic.php';
								$incluir[1] = 0;
							}
							else
							{
								$incluir[0] = $matches[1].'_basic.pbl';
								$incluir[1] = 0;
							}
						}
						else
						{
							if (file_exists($acaoSistema.'.php'))
							{
								$incluir[0] = $acaoSistema.'.php';
								$incluir[1] = 0;
							}
							else
							{
								$incluir[0] = $acaoSistema.'.pbl';
								$incluir[1] = 0;
							}
						}
					}
					break;
					
			}
			
			//Determina a escolha do Header e do Footer

			//Esta definido um skin?
			if ($this->_objeto->metadados['cod_pele'])
			{
				if (file_exists($_SERVER['DOCUMENT_ROOT']."/html/skin/".$this->_objeto->metadados['prefixopele']."/header.php"))
				{
					$header=$_SERVER['DOCUMENT_ROOT']."/html/skin/".$this->_objeto->metadados['prefixopele']."/header.php";
				}
				elseif (file_exists($_SERVER['DOCUMENT_ROOT']."/html/skin/".$this->_objeto->metadados['prefixopele']."/header.pbl"))
				{
					$header=$_SERVER['DOCUMENT_ROOT']."/html/skin/".$this->_objeto->metadados['prefixopele']."/header.pbl";
				}
				elseif (file_exists($_SERVER['DOCUMENT_ROOT']."/html/template/basic_header.php"))
				{
					$header=$_SERVER['DOCUMENT_ROOT']."/html/template/basic_header.php";
				}
				else
				{
					$header=$_SERVER['DOCUMENT_ROOT']."/html/template/basic_header.pbl";
				}

				if (file_exists($_SERVER['DOCUMENT_ROOT']."/html/skin/".$this->_objeto->metadados['prefixopele']."/footer.php"))
				{
					$footer= $_SERVER['DOCUMENT_ROOT']."/html/skin/".$this->_objeto->metadados['prefixopele']."/footer.php";
				}
				elseif (file_exists($_SERVER['DOCUMENT_ROOT']."/html/skin/".$this->_objeto->metadados['prefixopele']."/footer.pbl"))
				{
					$footer= $_SERVER['DOCUMENT_ROOT']."/html/skin/".$this->_objeto->metadados['prefixopele']."/footer.pbl";
				}
				elseif (file_exists($_SERVER['DOCUMENT_ROOT']."/html/template/basic_footer.php"))
				{
					$footer= $_SERVER['DOCUMENT_ROOT']."/html/template/basic_footer.php";
				}
				else
				{
					$footer= $_SERVER['DOCUMENT_ROOT']."/html/template/basic_footer.pbl";
				}
			}
			else
			{
				if (file_exists($_SERVER['DOCUMENT_ROOT']."/html/template/basic_header.php"))
				{
					$header = $_SERVER['DOCUMENT_ROOT']."/html/template/basic_header.php";
				}
				else
				{
					$header = $_SERVER['DOCUMENT_ROOT']."/html/template/basic_header.pbl";
				}
				if (file_exists($_SERVER['DOCUMENT_ROOT']."/html/template/basic_footer.php"))
				{
					$footer = $_SERVER['DOCUMENT_ROOT']."/html/template/basic_footer.php";
				}
				else
				{
					$footer = $_SERVER['DOCUMENT_ROOT']."/html/template/basic_footer.pbl";
				}
				
			}
//$incluirheader=false;
			if ($incluirheader)
			{
//				echo "> header: ".$header;
				$this->_parser->Start($header);
				echo "\n<!-- http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."-->\n";
				echo "\n<!-- ".substr($incluir[0], strrpos($incluir[0],'/'))." -->";
				echo "\n<!-- robot_contents -->\n";
			}
			else 
			{
				if (!$header_admin)
					include ("header_publicare.php");
					
			}

			if (isset($act) && $act == "/content/view")
			{
				$this->_parser->Start($incluir[0]);
			}
			else
			{
				if (!$incluir[1]) include($incluir[0]);
				else $this->_parser->Start($incluir[0]);
			}

			if ($incluirheader)
			{
				echo "\n<!-- /robot_contents -->\n";
				$this->_parser->Start($footer);
			}
			else
			{
				include ("footer_publicare.php");
			}
		}
		else
		{
			$this->ExibirMensagemProibido($acao);
		}

//		$this->TempoDeExecucao=$this->getmicrotime()-$this->inicio;
//		echo ">>> TEMPO DE EXECUCAO: ".$this->TempoDeExecucao." <<<";
	}

	function AdicionarAviso($txt,$fatal=false)
	{
		$this->avisos[]=$txt;
		if ($fatal)
		{
			foreach ($this->avisos as $aviso)
			{
				echo $aviso.'<br>';
				exit;
			}
		}
	}

	function ExibirMensagemProibido($acao)
	{
		if (file_exists($_SERVER['DOCUMENT_ROOT']."/html/template/error404.php"))
		{
			include($_SERVER['DOCUMENT_ROOT']."/html/template/error404.php");
		}
		else
		{
			include($_SERVER['DOCUMENT_ROOT']."/html/template/error404.pbl");
		}
	}

	function AdicionarEntradaLog()
	{

		global $cod_cookie,$cod_robo;

		$choice_network = strpos($_SERVER['REMOTE_ADDR'],'.');
		if ($cod_cookie)
		{
			// linhas removidas para resolver bug - Diogo Corazolla - 09/07/2007
			//if ($_SESSION['usuario']['cod_usuario'])
				//$choice_network = $choice_network + 10;
				
			$tabela = 'logacesso_'.date('Y_m');
			$sql = "insert into $tabela (cod_cookie, cod_usuario,cod_objeto,estampa) values
			($cod_cookie,".$choice_network.",".$this->cod_objeto.",". ConverteData(time(),15).")";
			
			$this->db->RegisterError(0);
			$this->db->ExecSQL($sql);
			$this->db->RegisterError(2);
			if ($this->db->Error())
			{
				if (preg_match("/table .* does(n't| not) exist/is",$this->db->Error()))
				{
					$this->db->CreateLogTable($tabela);
					$this->db->ExecSQL($sql);
				}
			}
		}
		
		else
		{
			//$sql = "insert into logrobo (cod_robo,cod_objeto,estampa) values
			//($cod_robo+0,".$this->cod_objeto.",". ConverteData(time(),15).")";
			//$this->db->ExecSQL($sql);
		}
		
	}
	
	function BoxPublicareTop($titulo,$botoes='')
	{
		global $titulo;
		
		$cols = 0;

		if ($botoes=='')
		{
			$botoes='exibir,voltar';
		}
		if (!is_array($botoes))
		{
			$botoes=explode(",",$botoes);
		}
		
		echo '
		<TABLE WIDTH="550" BORDER="0" CELLPADDING="0" CELLSPACING="0" background="/html/imagens/portalimages/form_top_bg.png">
		<TR>
			<TD width="100%"><img border=0 src="/html/imagens/portalimages/form_'.$titulo.'_top.png" ALT=""></td>';

		
		if (in_array('exibir',$botoes))
		{
			$cols++;
			echo '
			<td><a class="ABranco" href="/index.php/content/view/'.$this->_objeto->Valor($this, "cod_objeto").'.html"><img border=0 src="/html/imagens/portalimages/button_exibir.png" ALT="Exibir Objeto"</a></td>';
		}
		
		if (in_array('pai',$botoes))
		{
			if ($this->_objeto->Valor($this, "cod_objeto")!=_ROOT)
			{
				$cols++;
				echo '
			<td><a class="ABranco" href="/index.php/do/list_content/<? echo $this->objeto->Valor($this, "cod_pai")?>.html"><img border=0 src="/html/imagens/portalimages/button_parent.png" ALT="Listar Conte&uacute;do do Pai"</a></td>';
			}
		}

		if (in_array('voltar',$botoes))
		{
			$cols++;
			echo '<TD><a href="#" onclick="history.back()"><img border=0 src="/html/imagens/portalimages/button_back.png" ALT="Voltar"></a></TD>';
		}

		echo '
		</TR>
		<TR>
			<TD colspan="'.($cols+1).'" background="/html/imagens/portalimages/form_top_02.png">
				<img align="top" src="/html/imagens/portalimages/neutro.png" width=75 height=31><font class="pblFormTextTitle">'.$this->_objeto->Valor($this, "titulo").'</font></td>
		</TR>
	</table>
	<table width="550" border="0" cellpadding="3" cellspacing="0" background="/html/imagens/portalimages/form_bg.png">
	<tr>
		<td>';
	}

	function BoxPublicareBottom()
	{
?>
		</td>
	</tr>
	</table>
	<img src="/html/imagens/portalimages/form_bottom.png">
<?
	}

	function BoxSimplesTop()
	{
?>
		<img src="/html/imagens/portalimages/form_top_fio.png"><table width="550" border="0" cellpadding="4" cellspacing="2" background="/html/imagens/portalimages/form_bg.png">
		<tr>
			<td class="pblFormTitle">
<?
	}

	function BoxSimplesBottom()
	{
		BoxPublicareBottom();
	}
		
}
?>