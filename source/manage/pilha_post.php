<?
global $_page, $cod_objeto;

	if ($_POST['copy'])
		$_page->_administracao->CopiarObjeto($_page, $_POST['cod_objmanage'], $_page->_objeto->Valor($_page, "cod_objeto"));
	if ($_POST['pastelink'])
		$_page->_administracao->ColarComoLink($_page, $_POST['cod_objmanage'], $_page->_objeto->Valor($_page, "cod_objeto"));
	if ($_POST['move'])
		$_page->_administracao->MoverObjeto($_page, $_POST['cod_objmanage'], $_page->_objeto->Valor($_page, "cod_objeto"));
	
	if ($_POST['clear'])
		$_page->_administracao->LimparPilha($_page);
		
//	exit();
		
	header ("Location:"._URL.'/index.php/do/list_content/'.$cod_objeto.'.html');
?>
