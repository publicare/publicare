<?php

session_start();
require ("funcoes.php");

// Definindo timezone
date_default_timezone_set("America/Sao_Paulo");

// Pegando parametros passados por url
if (strpos($_SERVER['SERVER_SOFTWARE'],"Apache")===false)
{
	$script = str_replace ("/","\\\\",$_SERVER['PATH_INFO']);
	$docroot=substr($_SERVER['PATH_TRANSLATED'],0,strpos($_SERVER['PATH_TRANSLATED'],$script));
	$DOCUMENT_ROOT = $docroot;
}
//incluido a possibilidade de colcoar o titulo na URL (incluido: /(\w+)\ )
if (preg_match('/index\.php(\/.+)\/(\d+)\/(\w.+)\.html.*$/', $_SERVER['REQUEST_URI'], $matches))
{
	$action=$matches[1];
	$cod_objeto=$matches[2];
}
//código antigo, para que URL sem o titulo continue funcionando
elseif(preg_match('/index\.php(\/.+)\/(\d+)\.html.*$/', $_SERVER['REQUEST_URI'], $matches))
{
	$action=$matches[1];
	$cod_objeto=$matches[2];
}
else
{
	if (preg_match('/index\.php(\/do\/.*?)[?.]/',$_SERVER['REQUEST_URI'],$matches))
	{
		$action = $matches[1];
	}
}



// Se nao conseguir pegar no padrao "index.php/action/cod_objeto" 
// tenta pegar por $_GET, se nao conseguir define valor padrao
if (!isset($action)) {
	if (isset($_GET["action"])) $action = $_GET["action"];
	elseif (isset($_POST["action"])) $action = $_POST["action"];
	else $action = "/content/view";
}
if (!isset($cod_objeto)) {
	if (isset($_GET["cod_objeto"])) $cod_objeto = $_GET["cod_objeto"];
	else $cod_objeto = _ROOT;
}

//echo $action."<br>";
//echo $cod_objeto;
//exit();

// inclusao das classes publicare
require ('Zend/Search/Lucene.php');
require ("adodb/adodb-exceptions.inc.php");
require ("adodb/adodb.inc.php");
require ("dblayer_adodb.class.php");
require ("pagina.class.php");
require ("adminobjeto.class.php");
require ("objeto.class.php");
require ("usuario.class.php");
require ("parse.class.php");
require ("rss.class.php");
require ("data.php");

// inclusao da classe jpcache se for necessario
//if (JPCACHE) include ('jpcache2.pinc');
//require ("imagem_lib2.pinc");
if (ATIVA_CACHE==true && !isset($_SESSION['usuario']["cod_usuario"]) && !isset($_SESSION['sessUsuarioPBQP']))
	require ("quickcache.php");

$_db = new DBLayer();
$_page = new Pagina($_db, $cod_objeto);
?>
