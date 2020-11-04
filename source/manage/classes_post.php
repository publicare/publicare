<?
global $_page;

	//var_dump($_POST);
	if (isset($_POST['apagar']))
	{
		$_page->_administracao->ApagarClasse($_page, $_POST['cod_classe']);
		$cod_classe=0;
	}

	if ($_POST['submit'])
	{
		$limite=100;
		$out=array();

		for ($f=0;$f<$limite;$f++)
		{
			$nomevar="prop_".$f."_nome";
//			echo "<BR>$nomevar : ".$$nomevar.":<BR>";
			if ($_POST[$nomevar])
			{
				$prop=array();
				$prop['nome']=strtolower($_POST[$nomevar]);
				$atualvar="prop_".$f."_nomeatual";
				$prop['nomeatual']=strtolower($_POST[$atualvar]);
				$tipovar="prop_".$f."_cod_tipodado";
				$prop['cod_tipodado']=$_POST[$tipovar];
				$refvar="prop_".$f."_cod_referencia_classe";
				$prop['cod_referencia_classe']=$_POST[$refvar];
				$campovar="prop_".$f."_campo_ref";
				$prop['campo_ref']=$_POST[$campovar];
				$posicaovar="prop_".$f."_posicao";
				$prop['posicao']=$_POST[$posicaovar];
				$posicaovar="prop_".$f."_obrigatorio";
				$prop['obrigatorio']=$_POST[$posicaovar];
				$posicaovar="prop_".$f."_seguranca";
				$prop['seguranca']=$_POST[$posicaovar];
				$posicaovar="prop_".$f."_descricao";
				$prop['descricao']=$_POST[$posicaovar];
				$posicaovar="prop_".$f."_rotulo";
				$prop['rotulo']=$_POST[$posicaovar];
				$posicaovar="prop_".$f."_valorpadrao";
				$prop['valorpadrao']=$_POST[$posicaovar];
				$posicaovar="prop_".$f."_bolean_1";
				$prop['rot1booleano']=$_POST[$posicaovar];
				$posicaovar="prop_".$f."_bolean_2";
				$prop['rot2booleano']=$_POST[$posicaovar];
				
				if ($prop['nomeatual'])
					$out[$prop['nomeatual']]=$prop;
				else
					$out[]=$prop;
			}
		}
		
		//Edi��o de Uma Classe Existente
		if ($_POST['cod_classe'])
		{
			$classinfo=$_page->_administracao->PegaInfoDaClasse($_page, $_POST['cod_classe']);

			if ($_POST['prefixo']=='')
			{
				$prefixo=$_POST['old_prefixo'];
				$temfilhos=$_POST['old_temfilhos'];
			}
			
			foreach ($classinfo['prop'] as $atual)
			{
				if (is_array($out[$atual['nome']]))
				{
					//Propriedade J� Existe
//					echo "Encontrado ".$atual['nome'].'<BR>';
				}
				else
				{
					//Propriedade apagada
//					echo "Apagado ".$atual['nome'].'<BR>';
					$_page->_administracao->ApagarPropriedadeDaClasse($_page, $_POST['cod_classe'], $atual['nome']);
				}
			}

			
			//Edi��o da Classe
			if (!isset($_POST['temfilhos']))
				$_POST['temfilhos']=$_POST['old_temfilhos'];
			if (!isset($_POST['indexar']))
				$_POST['indexar']=$_POST['old_indexar'];
			if (!isset($_POST['prefixo']))
				$_POST['prefixo']=$_POST['old_prefixo'];

			$sql = "update classe 
			set nome='".$_POST['nome']."',
			prefixo='".$_POST['prefixo']."',
			descricao='".$_POST['descricao']."',
			temfilhos='".$_POST['temfilhos']."', 
			indexar='".$_POST['indexar']."' 
			where cod_classe=".$_POST['cod_classe'];
			$_page->_db->ExecSQL($sql);
			$cod_classe=$_POST['cod_classe'];

		}
		else
		{
			$campos=array();
			$campos['nome']=$_POST['nome'];
			$campos['prefixo']=$_POST['prefixo'];
			$campos['descricao']=$_POST['descricao'];
			$campos['temfilhos']=$_POST['temfilhos'];
			$campos['indexar']=$_POST['indexar'];
			$_POST['cod_classe']=$_page->_db->Insert('classe',$campos);
			$cod_classe=$_POST['cod_classe'];
		}

		//var_dump($out);

		foreach ($out as $novo)
		{
			if ($classinfo['prop'][$novo['nome']]['cod_propriedade'])
			{	
				//Atualizando dados da Propriedade
				if (($novo['nomeatual']) && ($novo['rotulo']))
				{
					$_page->_administracao->AtualizarDadosDaPropriedade ($_page, $classinfo['prop'][$novo['nome']]['cod_propriedade'],
					array ('nome'=>$novo['nomeatual'],
							'rotulo'=>$novo['rotulo'],
							'descricao'=>$novo['descricao'],
							'obrigatorio'=>$novo['obrigatorio'],
							'seguranca'=>$novo['seguranca'],
							'valorpadrao'=>trim($novo['valorpadrao']),
							'rot1booleano'=>trim($novo['rot1booleano']),
							'rot2booleano'=>trim($novo['rot2booleano']),
							'posicao'=>$novo['posicao']));
				}
			}
			else
			{
			 	//Acrescentando nova Propriedade
				$_page->_administracao->AcrescentarPropriedadeAClasse($_page, $_POST['cod_classe'], $novo);
			}
			//$_page->Administracao->AtualizarInfoDaPropriedade($_POST['cod_classe'],$novo);
		}

		
		

		//Apaga as informa��es sobre onde pode ser criado
		$sql = "delete from classexfilhos where cod_classe=".$_POST['cod_classe']." or cod_classe_filho=".$cod_classe;
		$_page->_db->ExecSQL($sql);


		if (($_POST['cod_classe']) && ($_POST['temfilhos']))
		{
			if (is_array($_POST['podeconter']))
			{
				foreach ($_POST['podeconter'] as $codigo)
				{
					$sql = "insert into classexfilhos values(".$cod_classe.",$codigo)";
					$_page->_db->ExecSQL($sql);
				}

			}
		}
		elseif($_POST['old_temfilhos'])
		{
			if (is_array($_POST['podeconter']))
			{
				foreach ($_POST['podeconter'] as $codigo)
				{
					$sql = "insert into classexfilhos values(".$cod_classe.",$codigo)";
					$_page->_db->ExecSQL($sql);
				}

			}
		}


		if (is_array($_POST['criadoem']))
		{
			foreach ($_POST['criadoem'] as $codigo)
			{
				$sql = "select cod_classe from classexfilhos where cod_classe=$codigo and cod_classe_filho=".$cod_classe;
				$rs = $_page->_db->ExecSQL($sql);
				$row = $rs->FetchRow();
				if (!$row['cod_classe'])
				{
					$sql = "insert into classexfilhos values($codigo,".$cod_classe.")";
					$_page->_db->ExecSQL($sql);
				}
			}
		}

		//Inclus�o de objetos que podem conter a classe
         if ($_POST['incluirObjeto'])
		{
			if (is_numeric($_POST['incluirObjeto']))
			{
				$sql = "select cod_objeto from objeto where cod_objeto=".$_POST['incluirObjeto'];
			}
			else
			{
				$sql = "select cod_objeto from objeto where titulo='".$_POST['incluirObjeto']."'";
			}
           $rs =  $this->_db->ExecSQL($sql);
			if ($row = $rs->FetchRow())
			{
				$_POST['objetos'][]=$row['cod_objeto'];
			}
			else
			{
				$MsgObjeto = 'Objeto '.$_POST['incluirObjeto'].' inv�lido.';
			}
		}
		$_page->_administracao->AlterarListaDeObjetosQueContemClasse($_page, $_POST['cod_classe'], $_POST['objetos']);

	}

	if (isset($_POST["apagar_icone"]) && $_POST["apagar_icone"]=="apagar")
	{
	    unlink($_SERVER["DOCUMENT_ROOT"]."/upd_blob/classes/ic_".$_POST['prefixo'].".gif");
        }

	if (isset($_FILES["ic_classe"]["name"]) && !empty($_FILES["ic_classe"]["name"]) && $_FILES["ic_classe"]["type"]=="image/gif")
	{
	    if (!$resultado=is_dir($_SERVER["DOCUMENT_ROOT"]."/upd_blob/classes/"))
	    {
		mkdir($_SERVER["DOCUMENT_ROOT"]."/upd_blob/classes/", 0700);
	    }
	    $nome_arquivo = "ic_".$_POST['prefixo'].".gif";
	    copy($_FILES["ic_classe"]["tmp_name"], $_SERVER["DOCUMENT_ROOT"]."/upd_blob/classes/".$nome_arquivo);
        } 

//	exit();

	$h = "Location:"._URL."/index.php/do/classes/".$_page->_objeto->Valor($_page, "cod_objeto").".html?cod_classe=".$cod_classe;
	if ($MsgObjeto)
	{
	 	$h .= '&MsgObjeto='.urlencode($MsgObjeto).'&IncluirObjeto='.urlencode($_POST['incluirObjeto']);
	}
	header($h);
?>
