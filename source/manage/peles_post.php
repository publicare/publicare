<?
global $_page;

	//Checa se o nome enviado � valido
	$msg = ChecaValidade($_page, $_POST['nome'],$_POST['prefixo'],$_POST['cod_pele']);
	if ($msg=='')
	{
		if ($_POST['cod_pele'])
		{
			if ($_POST['update'])
			{
				if ($_POST['publica'])
					$skinPublica = " publica='1'";
				else
					$skinPublica = "publica='0'";
				$sql = "update pele set nome='".$_POST['nome']."', prefixo='".$_POST['prefixo']."', ".$skinPublica." where cod_pele=".$_POST['cod_pele'];
				$_page->_db->ExecSQL($sql);
			}

			if ($_POST['delete'])
			{
				$sql = "delete from pele where cod_pele=".$_POST['cod_pele'];
				$_page->_db->ExecSQL($sql);
				$sql = "update objeto set cod_pele=0 where cod_pele=".$_POST['cod_pele'];
				$_page->_db->ExecSQL($sql);
				$_POST['cod_pele']=0;
			}
		}
		if ($_POST['new'])
		{
			if ($_POST['publica'])
				$skinPublica = '1';
			else
				$skinPublica = '0';
			$campos=array();
			$campos['nome']=$_POST['nome'];
			$campos['prefixo']=$_POST['prefixo'];
			$campos['publica']=$skinPublica;
			$_POST['cod_pele']=$_page->_db->Insert('pele',$campos);
		}
		header("Location:/index.php/do/peles/".$_page->_objeto->Valor($_page, "cod_objeto").".html?cod_pele=".$_POST['cod_pele']);
	}
	else
	{
		header("Location:/index.php/do/peles/".$_page->_objeto->Valor($_page, "cod_objeto").".html?erro=".$msg);
	}

	function ChecaValidade(&$_page, $nome,$prefixo,$cod_pele_atual)
	{
		if ($nome=='')
		{
			return 'Informe um nome para a pele.';
		}
		else
		{
			if (preg_match('&\W&is',$prefixo))
			{
			 	return 'Prefixo cont&eacute;m caracteres inv&aacute;lidos.';
			}
			else
			{
			 	$sql = "select cod_pele from pele where nome = '".$nome."'";
			 	if ($cod_pele_atual)
			 		$sql .= " and cod_pele <> ".$cod_pele_atual;
			 		
				$rs = $_page->_db->ExecSQL($sql);
			 	if (!$rs->EOF)
			 	{
					return 'Nome de pele j&aacute; existente. Escolha outro nome.';
				}
                $sql = "select cod_pele from pele where prefixo = '".$prefixo."'";
				if ($cod_pele_atual)
			 		$sql .= " and cod_pele<>".$cod_pele_atual;
			 	$rs = $_page->_db->ExecSQL($sql);
			 	if (!$rs->EOF)
			 	{
					return 'Prefixo j&aacute; existente. Escolha outro prefixo.';
				}

			}
		}
		return '';
	}
?>
	

