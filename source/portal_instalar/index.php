<?
	// Define configuracoes de BANCO DE DADOS e PHP.INI
	include("../publicare.conf");
	// Faz inclusoes do publicare e instancia objetos
	include ("iniciar.php");

	if ($is_explorer)
		$size=18;
	else
		$size=9;

	//desabilita o cache se o usuario esta logado
	if (isset($_SESSION['_USUARIO']) && is_array($_SESSION['_USUARIO']))
		$JPCACHE_ON = false;

	if ((!$JPCACHE_FIRST_PAGE) && ($cod_objeto==_ROOT))
		$JPCACHE_ON = false;

	$_page->Executar($action);

?>