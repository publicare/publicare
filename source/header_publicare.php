<?php
global $PORTAL_NAME, $cod_objeto, $_page;


$versao_php = phpversion();
if (strpos($versao_php, '-')) $versao_php = substr($versao_php, 0, strpos($versao_php, '-'));

$URLACTION = $_GET;
$URLCOMMON = $_SERVER['PHP_SELF'];
if (strnatcmp($versao_php, '5.3.6') >= 0)
{
	$tmpPosURL = strrpos($URLCOMMON,"/");
	$URLCOMMON = substr($URLCOMMON,0,$tmpPosURL);
}
else
{
	$tmpPosURL = strrpos($URLCOMMON,"/") - 10;
	$URLCOMMON = substr($URLCOMMON,10,$tmpPosURL);
}
$tmpPosURL = strrpos($URLCOMMON,"new_");
if (!$tmpPosURL===false) $URLCOMMON = "criando_arquivo";

?>
<html>
<head>
<title> <? echo $PORTAL_NAME ;?> -- <?php echo _VERSIONPROG; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<script type="text/javascript" src="/html/javascript/publicare/jquery.min.js"></script>
<script type="text/javascript" src="/html/javascript/publicare/funcoes.logicbsb.js"></script>
<script type="text/javascript">
$(document).ready(function(){

	jqAjaxLink("/index.php/inc/header/<?=$_page->_objeto->Valor($_page, 'cod_objeto')?>.html?naoincluirheader&url=<?=$URLCOMMON?>", "container_header_publicare", true);
	jqAjaxLink("/index.php/inc/menu/<?=$_page->_objeto->Valor($_page, 'cod_objeto')?>.html?naoincluirheader", "container_menu_vertical_publicare", true);
	jqAjaxLink("/index.php<?=$URLCOMMON?>/<?=$_page->_objeto->Valor($_page, 'cod_objeto')?>.html?naoincluirheader&exibir", "container_corpo_publicare", true);
	
});
</script>
<link href="/html/css/publicare.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body
{
	background: #FFF;
	font-family: verdana, arial, helvetica, sans-serif;
	font-size: 100%;
	padding: 0px;
	margin: 0px;
}

#container_tudo_publicare
{
	width: 820px;
	position: relative;
}

#container_header_publicare
{
	width: 99%;
	position: relative;
}

#container_centro_publicare
{
	width: 99%;
	position: relative;
	display: table;
	margin: 0;
	padding: 0;
}

#abasHeaderPublicare {
	padding-bottom:8px; 
	padding-top:8px;
	margin-left: 250px;
	margin-top: 10px;
}

#abasHeaderPublicare a {
	font-size: 10pt;
}	
	
#abasHeaderPublicare a.botao {
	font-weight: bold; 
	margin-bottom:-2px; 
	margin-left: 2px;
	background-color:#FAE0B5;
	padding-left:15px; 
	padding-right:15px; 
	padding-top:8px; 
	padding-bottom:9px;
	border-top: 2px #FA9C00 solid; 
	border-left: 2px #FA9C00 solid; 
	border-right: 2px #FA9C00 solid;
	cursor:pointer;
}
	
#abasHeaderPublicare a.select {
	font-weight: bold; 
	margin-bottom:-2px; 
	margin-left: 2px;
	background-color:#FAE0B5;
	padding-left:15px; 
	padding-right:15px; 
	padding-top:8px; 
	padding-bottom:9px;
	border-top: 2px #000 solid; 
	border-left: 2px #000 solid; 
	border-right: 2px #000 solid;
	cursor:pointer;
}

div.menu_lateral_publicare
{
	position: relative;
	width: 230px;
	float: left;
	left: 10px;
}

div.menu_lateral_publicare ul
{
	list-style-type: none;
	padding: 0;
	margin: 0;
}

div.menu_lateral_publicare ul li
{
	border-bottom: 1px solid #A4A0F5;
	padding: 0;
	margin: 0;
}

div.menu_lateral_publicare ul li.titulo1
{
	color: #fff;
	text-align: right;
	background:#E18A2C url(/html/imagens/menu/menu_lateral/xptitle.gif) repeat-Y top left; 
	padding-top: 5px;
	padding-bottom: 5px;
	padding-right: 5px;
	font-weight: bold;
}

div.menu_lateral_publicare ul li.titulo2
{
	color: #fff;
	text-align: right;
	background:#E18A2C url(/html/imagens/menu/menu_lateral/xptitle.gif) repeat-Y top left; 
	padding-top: 5px;
	padding-bottom: 5px;
	padding-right: 5px;
	font-weight: bold;
}

div.menu_lateral_publicare ul li.titulo3
{
	color: #fff;
	text-align: right;
	background:#E18A2C url(/html/imagens/menu/menu_lateral/xptitle.gif) repeat-Y top left; 
	padding-top: 5px;
	padding-bottom: 5px;
	padding-right: 5px;
	font-weight: bold;
}

div.menu_lateral_publicare ul li a:link, div.menu_lateral_publicare ul li a:visited {
	display: block;
	height: 1%;
	text-decoration: none;
	font-size: 9pt;
	color: #5E0F50;
	border-left: 5px solid #EEC591;
	padding-top: 2px;
	padding-bottom: 2px;
}

div.menu_lateral_publicare ul li a img
{
	vertical-align: middle;
	/*margin-left: -22px;*/
	margin-right: 5px;
	margin-left: 5px;
	width: 20px;
	height: 20px;
	border: 0;
}

div.menu_lateral_publicare ul li a:hover {
	background-color: #FFE4B5;
	color: #DAA520;
	border-left: 5px solid #000;
} 

.loading {
	left:50%; 
	margin-left:-140px; 
	top:50%;
	margin-top:-110px;
	_top:expression(eval(document.body.scrollTop));
	position:fixed;
	_position:absolute;
	float: left;
	background-image:url(/html/imagens/publicare/carregar.gif);
	background-repeat:no-repeat;
	background-position:top left;
	text-align: right;
	text-indent:-9999999999;
	width:272px;
	height:212px;
	z-index: 9999;
	color: #ffffff;
	display: block; 
}

#container_corpo_publicare
{
	width: 570px;
	position: relative;
	float: right;
}

/*
#container_menu_vertical_publicare 
{
	
}

#container_menu_vertical_publicare span {
	font-weight: bold;
	padding-right: 10px;
	padding-top: 5px;
	padding-bottom: 5px;
	display: block;
	width:210px;
	font-size: 11pt;
}

#container_menu_vertical_publicare a
{ 
	background: #F9E8D7;
	display: block; 
	height: 20px;
	margin: 2px;
}

#container_menu_vertical_publicare span.Title1
{
	color: #fff;
	text-align: right;
	background:#E18A2C url(/html/imagens/menu/menu_lateral/xptitle.gif) repeat-Y top left; 
}

#container_menu_vertical_publicare span.Title2 
{ 
	color: #854E15;
	text-align: right;
	background:#F9E7D5 url(/html/imagens/menu/menu_lateral/xptitle2.gif) repeat-Y top left; 
}

#container_menu_vertical_publicare span.Title3 {
	text-align: right;
	color: #FFF;
	background:#265BCC;
}

#container_menu_vertical_publicare a img 
{
	border:0px; 
	margin-left: 15px;
	margin-right: 5px;
	vertical-align: middle;
}

#container_menu_vertical_publicare a:link
{ 
	text-decoration: none; 
	color: #555
}
#container_menu_vertical_publicare a:visited 
{ 
	text-decoration: none; 
	color: #555 
}
#container_menu_vertical_publicare a:hover 
{ 
	background: #FFF6E8; 
	color: #555 
}

.pblAlinhamentoTabelas {
	text-align: left;
	position: relative;
}

.pblTabelaGeral {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #FA9C00;
	background-color: #FAE0B5;
	border: 3px #FA9C00 solid;
}

.pblTituloBox {
	font-family: Trebuchet, Arial, Helvetica, sans-serif;
	font-size: 24px;
	color: #FA9C00;	
	font-weight: bold;
	margin-left: 10px;
}

.pblTituloForm {
	font-family: Trebuchet, Arial, Helvetica, sans-serif;
	font-size: 16px;
	line-height: 22px;
	color: #FA9C00;	
	font-weight: bold;
	margin-left: 0px;
}

.pblTextoForm {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #FA9C00;
	margin-left: 10px;
}

.pblTextoLabelForm {
	/* Este estilo descreve as opções do formulário (à esquerda). A pblTextoForm são as opções propriamente ditas (à direita) */
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #FA9C00;
	margin-left: 10px;
	font-weight: bold;
}
*/
</style>
</head>
<body>

<div id="container_tudo_publicare">

	<div id="container_header_publicare"></div>
	
	<div id="container_centro_publicare">
	
		<div id="container_menu_vertical_publicare" class="menu_lateral_publicare"></div>
		<div id="container_corpo_publicare"></div>
	
	</div>
	
	<div id="container_footer_publicare"></div>

</div>

</body>
</html>

