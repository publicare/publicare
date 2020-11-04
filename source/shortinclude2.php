<?php
	if (strpos($_SERVER['SERVER_SOFTWARE'],"Apache")===false)
	{
		$docroot = dirname($_SERVER['SCRIPT_NAME']);
		$_SERVER['DOCUMENT_ROOT'] = $docroot;
	}
	include_once ($_SERVER['DOCUMENT_ROOT']."/../publicare.conf");

	set_magic_quotes_runtime (0);
	require ("adodb/adodb-exceptions.inc.php");
	require ("adodb/adodb.inc.php");
	require ("dblayer_adodb.class.php");
	$_db = new DBLayer();
?>