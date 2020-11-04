<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

// inicia sessao caso não esteja iniciada ainda
if (!isset($_SESSION))
    session_start();
global $_dominios;

$url = $_SERVER['REQUEST_URI'];

// inclui funcoes requeridas pelo publicare
include_once("funcoes.php");

/*
// Acelerar carregamento de imagens
if (strpos($url, 'viewblob') || strpos($url, 'viewthumb')) {

    $file = $_SERVER["DOCUMENT_ROOT"] . $_SERVER["REDIRECT_URL"];
    if (file_exists($file)) {
        include $file;
        print 44;
    } else {
        print "Not Found :(";
    }
}
*/




//xd("parou!");

// define timezone gmt -3
date_default_timezone_set("America/Sao_Paulo");

// retira variaveis passadas por _GET da url
$aurl = preg_split("[\?]", $url);
$url = $aurl[0];

// inclusao das classes publicare
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
require_once ("versao.php");

// iniciando banco de dados
$_db = new DBLayer();


$incluir = "";
$amigavel = "";

$arrUrl = preg_split("[\/]", $url);
//xd($arrUrl);

switch ($arrUrl[1]) {
    // formulario de login
    case "login":
        $incluir = $_SERVER["DOCUMENT_ROOT"] . "/login/index.php";
        break;

    // pasta security... efetua login / logoff
    case "security":
        $incluir = $_SERVER["DOCUMENT_ROOT"] . "/security/" . $arrUrl[2];
        break;

    // chamando arquivos pasta objects
    case "html":
        if ($arrUrl[2] == "objects") {
            $tempFile = "";
            for ($i = 3; $i < count($arrUrl); $i++) {
                $tempFile .= "/" . $arrUrl[$i];
            }
            $incluir = $_SERVER["DOCUMENT_ROOT"] . "/html/objects" . $tempFile;
        }
        break;

    // aparentemente url padrao antigo do publicare
    case "index.php":
//		if (isset($_POST["action"]) || isset($_GET["action"]))
//		{		
//			$action = isset($_POST["action"])?$_POST["action"]:isset($_GET["action"])?$_GET["action"]:"";
//			$tmpArrUrl = split("[/]", $url);
//		}
//		else
//		{
        if (isset($arrUrl[2])) {
                switch ($arrUrl[2]) {
                // content/view?
                case "content":

                    if ($arrUrl[3] == "view") {
                        $action = "/content/view";
                        // url publicare com codigo e titulo
                        if (is_numeric($arrUrl[4])) {
                            $cod_objeto = $arrUrl[4];
                        } else {
                            $temp = preg_split("[\.]", $arrUrl[4]);
                            $cod_objeto = $temp[0];
                        }
                    }

                    break;
                // manage ou do
                case "manage":
                case "do":
                    $action = "/" . $arrUrl[2] . "/" . $arrUrl[3];
                    $temp = preg_split("[\.]", $arrUrl[4]);
                    $cod_objeto = $temp[0];
                    break;

                case "security":
                    $incluir = $_SERVER["DOCUMENT_ROOT"] . "/security/" . $arrUrl[3] . ".php";
                    break;
            }
        }
//		}
        break;

    // nenhum caso conhecido, tenta url amigavel
    default:
        $action = "/content/view";
        // remove extensoes
        $temp = preg_split("[\.]", $arrUrl[1]);
        $arrUrl[1] = $temp[0];
        // garante url sem caracteres especiais
        $arrUrl[1] = limpaString($arrUrl[1]);
        // tudo para minusculo
        $arrUrl[1] = strtolower($arrUrl[1]);
        $amigavel = $arrUrl[1];
        break;
}

// verifica se eh url amigavel
if ($amigavel != "") {
    // procura no banco pela url amigavel
    $sql = "select cod_objeto from objeto where url_amigavel='" . $amigavel . "'";
    $rs = $_db->ExecSQL($sql, 0, 1);
    while ($row = $rs->FetchRow()) {
        $cod_objeto = $row["cod_objeto"];
    }
}

// verifica existencia de action
if (!isset($action) || isset($_GET["action"]) || isset($_POST["action"])) {
    // se nao tiver, verifica action em get
    if (isset($_GET["action"]))
        $action = $_GET["action"];
    // se nao tiver em get, verifica em post
    elseif (isset($_POST["action"]))
        $action = $_POST["action"];
    // se nao tiver em post, define action como "/content/view"
    else
        $action = "/content/view";
}

if (isset($_dominios)) {
    $dominio = $_SERVER['HTTP_HOST'];
    if (!isset($cod_objeto) || !is_numeric($cod_objeto) || $cod_objeto <= 0) {
        foreach ($_dominios as $dom => $dom1) {
            if ($dominio == $dom)
                $cod_objeto = $_dominios[$dominio];
        }
    }
}

//echo "<!-- ";
//echo $cod_objeto;
//echo "-->";
// verificando existencia e formato de $cod_objeto
// previne erros!
if (!isset($cod_objeto) || !is_numeric($cod_objeto) || $cod_objeto <= 0) {
    // caso nao exista cod_objeto, verifica nos parametros get
    if (isset($_GET["cod_objeto"]) && is_numeric($_GET["cod_objeto"]) && $_GET["cod_objeto"] > 0) {
        $cod_objeto = $_GET["cod_objeto"];
    } else {
        // caso nao exista cod_objeto nos parametros get, verifica nos parametros post
        if (isset($_POST["cod_objeto"]) && is_numeric($_POST["cod_objeto"]) && $_POST["cod_objeto"] > 0) {
            $cod_objeto = $_POST["cod_objeto"];
        }
        // caso nao exista cod_objeto nos parametros post, define como _ROOT
        else {
            $cod_objeto = _ROOT;
        }
    }
}

// cache
//if (ATIVA_CACHE == true && !isset($_SESSION['usuario']["cod_usuario"]))
//    require("quickcache/quickcache.php");

// iniciando pagina
$_page = new Pagina($_db, $cod_objeto);

// se for inclusao de arquivo, inclui o mesmo e termina execucao
if ($incluir != "") {
    $incluir = str_replace("\.\.\/", "", $incluir);
    include($incluir);
    exit();
}
?>
