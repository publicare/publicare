<?php
global $PORTAL_NAME, $cod_objeto, $_page;
?>
<html>
<head>
<title> <? echo $PORTAL_NAME ;?> -- <?php echo _VERSIONPROG; ?></title>
<script language="JavaScript1.2" src="/html/javascript/menu/js_menutab_data.js" type="text/javascript"></script>
<script language="JavaScript1.2" src="/html/javascript/system.js" type="text/javascript"></script>
<?php
	$NewBrowser = DetectaBrowser();	
	echo "<link href=\"/html/css/publicare_".$NewBrowser[0].".css\" rel=\"stylesheet\" type=\"text/css\">\n";
	
	$URLACTION = $_GET;
    $URLCOMMON = $_SERVER['PHP_SELF'];
    $tmpPosURL = strrpos($URLCOMMON,"/");
    $URLCOMMON = substr($URLCOMMON,0,$tmpPosURL);
    $tmpPosURL = strrpos($URLCOMMON,"new_");
    if (!$tmpPosURL===false)
    	$URLCOMMON = "criando_arquivo";
    	
    	
   // Determinando variaveis dinamicas utilizadas pelo JavaScript
    echo "<script language=\"JavaScript1.2\" type=\"text/javascript\">\n";
	echo "var COB=\"/".$cod_objeto.".html\";\n";
    
    switch ($URLCOMMON)
	{
	case "/do/preview":
	  echo "menu_a = \"&Iacute;ndice do Objeto\";\n";
  	 echo "menu_b = \"Workflow\";\n";
	 echo "menu_c = \"Log Status\";\n";
	 break;
	case "/manage/edit":
	 echo "menu_a = \"Editar Objeto\";\n";
	 echo "menu_b = \"Avan&ccedil;ado\";\n";
	 echo "bselectedItem = 1";
	 break;
	case "/do/delete":
	 echo "menu_a = \"Apagar Objeto\";\n";
	 break;
	case "/do/apagar_definitivo":
	 echo "menu_a = \"Apagar em definitivo\";\n";
	 break;
	case "/do/vencidos":
	 echo "menu_a = \"Apagar Objetos Vencidos\";\n";
	 break;
	case "/manage/new":
	 echo "menu_a = \"Criar Objeto\";\n";
	 break;
	case "/do/list_content":
	 echo "menu_a = \"Listar Conte&uacute;do\";\n";
	 echo "menu_b = \"Pilha\";\n";
	 break;
	case "/do/logacesso":
	 echo "menu_a = \"Log de Acessos\";\n";
	 break;
	case "/do/pendentes":
	  echo "menu_a = \"Objetos Pendentes\";\n";
	 break;
	case "/do/rejeitar":
	  echo "menu_a = \"Rejeitar Publica&ccedil;&atilde;o\";\n";
	  echo "menu_b = \"Workflow\";\n";
	  echo "menu_c = \"Log Status\";\n";
	 break;
	case "/do/publicar":
	  echo "menu_a = \"Objetos a publicar\";\n";
	  echo "menu_b = \"Workflow\";\n";
  	  echo "menu_c = \"Log Status\";\n";
	 break;
	case "/do/recuperar":
	  echo "menu_a = \"Recuperar Objetos Apagados\";\n";
	 break;
	case "/do/gerdadospessoais":
	  echo "menu_a = \"Gerenciar Dados Privados\";\n";
	 break;
	case "/do/indexportal":
	  echo "menu_a = \"Gerenciar Portal\";\n";
	  echo "menu_b = \"Usu&aacute;rios\";\n";
	  echo "menu_c = \"Classes\";\n";
	  echo "menu_d = \"Skins\";\n";
	 break;
	case "/do/classes":
	  echo "menu_a = \"Gerenciar Classes\";\n";
	 break;
	case "/do/gerusuario":
	  echo "menu_a = \"Gerenciar Usu&aacute;rios\";\n";
	 break;
	case "criando_arquivo":
	 echo "menu_a = \"Criar Objeto\";\n";
	 echo "menu_b = \"Avan&ccedil;ado\";\n";
	 break;
	case "/do/submeter":
	  echo "menu_a = \"Solicita&ccedil;&atilde;o de Publica&ccedil;&atilde;o\";\n";
	 break;
	case "/do/ajuda":
	  echo "menu_a = \"Ajuda do Portal C&T\";\n";
	 break;
	default:
	  echo "menu_a = \""._VERSIONPROG."\";\n";
	  break;
 }
?>
</script>
</head>

<body>

<div id="divMenuHorizontal">
<script language="JavaScript1.2" src="/html/javascript/menu/js_menutab_conf.js" type="text/javascript"></script>
</div>
<div class="divMenuLateral">
	<p>
	<?php

	$menu = $_page->_usuario->Menu($_page);
	foreach ($menu as $item)
	{
		switch ($item['ordem']){
		case 0:
			//echo "<span class=\"Logo\"><img src=\"/html/imagens/menu/menu_lateral/icn_xpicon1.gif\" width=\"\" height=\"\" align=\"middle\" id=\"Logo\"></span>";
			echo "<span class=\"Title1\">Admin. de Objetos\n";
			//echo "<img src=\"/html/imagens/menu/menu_lateral/xpexpand1.gif\" width=\"\" height=\"\" align=\"middle\">";
			echo "</span>";
			//echo "<a class=\"home\" href=\"\"><img alt=\"MCT\" src=\"/html/imagens/logo.gif\"></a>\n";
			break;
		case 9:			
			echo "<span class=\"Title2\">Admin. de Portal";
			//echo "<img src=\"/html/imagens/menu/menu_lateral/xpexpand2.gif\" width=\"\" height=\"\" align=\"middle\">";
			echo "</span>";
			break;
		case 14:
			echo "<span class=\"Title3\">Menu de Navega&ccedil;&atilde;o</span>\n";
			break;
		default:
			echo "<a rel=\"\" href=\"/index.php".$item['script']."/".$_page->_objeto->Valor($_page, 'cod_objeto').".html\">";
			echo "<img src=\"/html/imagens/menu/menu_lateral/icn_".$item['ordem'].".gif\" width=\"16\" height=\"16\" align=\"middle\">".$item['acao']."</a>";
			break;
	
		}
	}
	?>
	</p>
</div>

