<?
global $_page;
	include("../publicare.conf");
	$tmpCodObjeto = $_page->_objeto->Valor($_page, "cod_objeto");
	$_page->_usuario->Logout();	
?>

<script>
	window.location.href="/index.php/content/view/<?=$tmpCodObjeto?>.html?LoginMessage=Logout+efetuado+com+sucesso";
</script>