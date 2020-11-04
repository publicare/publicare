<?
global $_page;

	echo "administrando classes<br />";

	//var_dump($_POST);
	if ($_POST['apagar'])
	{
		echo "apagando<br />";
		$cod_classe=$_POST['cod_classe'];
		$_page->_administracao->ApagarClasse($_page, $_POST['cod_classe']);
//		$cod_classe=0;
	}

	if ($_POST['submit'])
	{
		$limite=100;
		$out=array();
		
		echo "preparando variáveis<br />";
		
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
		
		//Edição de Uma Classe Existente
		if ($_POST['cod_classe'])
		{
			$cod_classe=$_POST['cod_classe'];
			echo "editando a classe<br />";
			
			$classinfo=$_page->_administracao->PegaInfoDaClasse($_page, $cod_classe);

			if ($_POST['prefixo']=='')
			{
				$prefixo=$_POST['old_prefixo'];
				$temfilhos=$_POST['old_temfilhos'];
			}
			
			foreach ($classinfo['prop'] as $atual)
			{
				if (is_array($out[$atual['nome']]))
				{
					//Propriedade Já Existe
					echo "Encontrado ".$atual['nome'].'<BR>';
				}
				else
				{
					//Propriedade apagada
					echo "Apagado ".$atual['nome'].'<BR>';
					$_page->_administracao->ApagarPropriedadeDaClasse($_page, $cod_classe,$atual['nome']);
				}
			}

			
			//Edição da Classe
			if (!isset($_POST['temfilhos']))
				$_POST['temfilhos']=$_POST['old_temfilhos'];
			if (!isset($_POST['indexar']))
				$_POST['indexar']=$_POST['old_indexar'];
			if (!isset($_POST['prefixo']))
				$_POST['prefixo']=$_POST['old_prefixo'];

			echo "executando sql update<br />";
			$sql = "update classe set nome='".$_POST['nome']."',prefixo='".$_POST['prefixo']."',descricao='".$_POST['descricao'].
				"',temfilhos='".$_POST['temfilhos']."', indexar='".$_POST['indexar']."' where cod_classe=".$cod_classe;
			echo $sql."<br />";
			$_page->_db->ExecSQL($sql);

		}
		else
		{
			echo "criando classe<br />";
			$campos=array();
			$campos['nome']=$_POST['nome'];
			$campos['prefixo']=$_POST['prefixo'];
			$campos['descricao']=$_POST['descricao'];
			$campos['temfilhos']=$_POST['temfilhos'];
			$campos['indexar']=$_POST['indexar'];
			$cod_classe=$_page->db->Insert('classe',$campos);
			echo "ID: ".$cod_classe."<br />";
//			$cod_classe=$_POST['cod_classe'];
		}

		//var_dump($out);

		foreach ($out as $novo)
		{
			if ($classinfo['prop'][$novo['nome']]['cod_propriedade'])
			{	
				//Atualizando dados da Propriedade
				if (($novo['nomeatual']) && ($novo['rotulo']))
				{
					echo "atualizando propriedades da classe<br />";
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
			 	echo "adicionando propriedades a classe<br />";
				$_page->_administracao->AcrescentarPropriedadeAClasse($_page, $cod_classe,$novo);
			}
			//$_page->Administracao->AtualizarInfoDaPropriedade($_POST['cod_classe'],$novo);
		}

		//Apaga as informações sobre onde pode ser criado
		$sql = "delete from classexfilhos where cod_classe=".$cod_classe." or cod_classe_filho=".$cod_classe;
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

		//Inclusão de objetos que podem conter a classe
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
            $rs = $_page->_db->ExecSQL($sql);
			if ($row=$rs->FetchRow())
			{
				$_POST['objetos'][]=$row['cod_objeto'];
			}
			else
			{
				$MsgObjeto = 'Objeto '.$_POST['incluirObjeto'].' inválido.';
			}
		}
		$_page->_administracao->AlterarListaDeObjetosQueContemClasse($_page, $cod_classe, $_POST['objetos']);

	}

	exit();
	$h = "Location:"._URL."/index.php/do/classes/".$_page->_objeto->Valor($_page, "cod_objeto").".html?cod_classe=".$cod_classe;
	if ($MsgObjeto)
	{
	 	$h .= '&MsgObjeto='.urlencode($MsgObjeto).'&IncluirObjeto='.urlencode($_POST['incluirObjeto']);
	}
	header($h);
?>
