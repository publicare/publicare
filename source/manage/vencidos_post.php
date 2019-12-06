<?
global $_page;

	foreach($_POST['objlist'] as $obj)
	{
		if ($_SESSION['usuario']['perfil']==_PERFIL_ADMINISTRADOR)
			$_page->_administracao->ApagarEmDefinitivo($_page, $obj);
		elseif ($_SESSION['usuario']['perfil']==_PERFIL_EDITOR)
			$_page->_administracao->ApagarObjeto($_page, $obj); 
	}
	
	header ("Location:/index.php/do/vencidos/".$_page->_objeto->Valor($_page, 'cod_objeto').'.html');

?>
