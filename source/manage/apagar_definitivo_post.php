<?php
global $_page;

	if (isset($_POST['objlist'])){
		foreach($_POST['objlist'] as $obj)
		{
			$_page->_administracao->ApagarEmDefinitivo($_page, $obj);
		}
	}
	header ("Location:/index.php/do/apagar_definitivo/".$_page->_objeto->Valor($_page, 'cod_objeto').'.html');

?>
