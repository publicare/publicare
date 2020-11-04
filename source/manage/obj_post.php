<?php

	// AJUSTES
	global $_page, $cod;
	$_POST['cod_status'] = 1;
	$_POST['script_exibir'] = str_replace("//", "/", $_POST['script_exibir']); // Arruma uma falha
	
	if ($_POST['cod_pele']==0) $_POST['cod_pele'] = null;
	

	// VERIFICA A EXISTENCIA DE SCRIPT (ANTES DE GRAVAR O OBJETO)
	$rtnExecAntes = $_page->_adminobjeto->ExecutaScript($_page, $_POST['cod_classe'],$_POST['cod_pele'],'antes');
	set_magic_quotes_runtime(0);

	if ($_POST['op']=="edit"){
		$cod = $_page->_administracao->AlterarObjeto($_page, $_POST);
	}
	else
	{
		$cod = $_page->_administracao->CriarObjeto($_page, $_POST);
	}
	
	// OBTEM DADOS DO OBJETO RECEM CRIADO
	$data = $_page->_adminobjeto->PegaDadosObjetoPeloID($_page, $cod);
	

	// Publica ou Solicita o objeto, apos a criacao ou edicao
	
	if (($_POST['submit_publicar']) && (($_SESSION['usuario']['perfil']==_PERFIL_ADMINISTRADOR) || ($_SESSION['usuario']['perfil']==_PERFIL_EDITOR)))
	{
		$_page->_administracao->PublicarObjeto($_page, 'Objeto publicado durante a cria&ccedil;&atilde;o',$cod);
	}
	elseif ($_POST['submit_solicitar'])
	{
		$_page->_administracao->SubmeterObjeto($_page, 'Objeto solicitado durante a cria&ccedil;&atilde;o',$cod);
	}
	elseif ($_POST['op']=="edit")
	{
		$_page->_administracao->RemovePendencia($_page, 'Objeto editado ap&oacute;s solicita&ccedil;&atilde;o. Status redefinido pelo sistema.',$cod);
	}	
		
	// VERIFICA A EXISTENCIA DE SCRIPT (DEPOIS DE GRAVAR O OBJETO)
	$rtnExecDepois = $_page->_adminobjeto->ExecutaScript($_page, $_POST['cod_classe'],$_POST['cod_pele'],'depois');
	
	// Redirecinador ...

	if ($_POST['submit_insert'])
	{
		header("Location:"._URL."/index.php/manage/new_".$data['prefixoclasse']."/".$data['cod_pai'].".html");
	}
	else
	{
	 	header("Location:"._URL."/index.php/content/view/$cod.html");
	}
?>