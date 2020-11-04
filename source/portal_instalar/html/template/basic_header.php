 <?php
    $PERFIL = $_page->_usuario->cod_perfil;
    $recebeBrowser = DetectaBrowser();
if ($recebeBrowser[0] == "msie"){
    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><meta name="robots" content="index, follow" />';
} else {
    echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
}
?>
<?php 
	global $_page, $cod_objeto, $caminho_imagem, $recebeBrowser, $toPrint, $PERFIL;
	
	$toPrint = $_GET['toPrint'];
?>

<@var $objetocaminho = %COD_OBJETO@>
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt" xml:lang="pt">
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" />
<head>
  <title><?php echo _PORTAL_NAME?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="/html/css/stylesite.css" rel="stylesheet" type="text/css"/>
<?php
	 $recebeBrowser = DetectaBrowser();	 	
?>
  <meta content="text/html;charset=ISO-8859-1" http-equiv="Content-Type">
	<script language="JavaScript1.2" src="/html/javascript/site.js" type="text/javascript"></script> 
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- inclui o menu de administraï¿½o -->



<@incluimenu@>		
<!-- Tabela Principal -->
<table width="740" border="0" align="center" cellpadding="0" cellspacing="0" style=" background: #ffffff; border-right: 1px #333333 solid; border-left: 1px #333333 solid;">
	<tr>
		<td class="jeta bold">		
			Basic Header		
		</td>
	</tr>
	<tr>
		<form action="/index.php" method="post" name="frmBuscaMCTOutroLayout" id="frmBuscaMCTOutroLayout">
		    <td align="center" class="paddingLeft12 paddingRight12 terra">
			    <input name="searchquery" type="text" id="campoBusca" value=" campo de busca" title="campo de busca" class="formulario" onFocus="this.value='';" size="20">
			    &nbsp;&nbsp;
			    <a href="#" title="botão que submete a consulta" class="botaoBusca">buscar</a>
			    &nbsp;&nbsp;
				<a href="#" class="underline bold terra" onClick="document.getElementById('boxBuscaAvancadaOutroLayout').style.display = ''; janelafloat('boxBuscaAvancadaOutroLayout');"  title="busca avançada">busca avançada</a>
			    <input type="hidden" name="action" id="action" value="/html/objects/search_result">
		    </td>
		    
		    <td align="right" class="paddingLeft12 paddingRight12 bold terra"><a href="?execview=mapasite" title="Mapa do site">Mapa do site</a></td>
		    <td align="center" class="paddingLeft12 bold terra"><!-- <a href="/index.php/content/view/70140.html" title="Fale Conosco">Fale Conosco</a>--></td>
		</form>
	</tr>
  <!-- Final TR 1 -->  
  <!-- TR 2 -->
 	<tr> 
  		<td> 
 			<@incluir arquivo=['/html/template/include/inc_caminho.php']@>
		</td>
	</tr>
	<tr>
		<td valign="top">