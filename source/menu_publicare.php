<!-- <link href="/html/css/publicare.css" rel="stylesheet" type="text/css"> -->
<script language="JavaScript1.2" src="/html/javascript/menu/js_menutab_data.js" type="text/javascript"></script>
<script language="JavaScript1.2" type="text/javascript">
 <?php
	 echo "menu_a = \"Visualizando\"".chr(10);
	 echo "menu_b = \"<a href=/index.php/do/preview/".$GLOBALS['cod_objeto'].".html class=TabTexto>Op&ccedil;&otilde;es de menu</a>\"".chr(10);
	 echo "menu_c = \" Dicas \"".chr(10);
	 echo "JSint_cod_obj = ".$GLOBALS['cod_objeto'].";".chr(10);
?>
 // --> Inicio de JS detecaoo de teclas de atalho -->
 		window.onfocus = function() { 
 			document[document.all ? 'onkeydown' : 'onkeypress'] = JSDetectarTeclaAtalho;
 		}
 		function JSDetectarTeclaAtalho(evento) {
 			if (document.all) {
 				evento = window.event;
 				target = evento.srcElement;
 			}
 			else {
 				target = evento.target;
 			}
 			// Transforma para minusculo, pois o IE so tava lendo maiusculas! Teste: alert(key);
   			var key = String.fromCharCode(document.all ? evento.keyCode : evento.charCode).toLowerCase();
			//alert(key);
   			if (evento.altKey && evento.ctrlKey){
   			switch (key){
   			case "e": // Editar Objeto
	   			JSChangeURL('/manage/edit',JSint_cod_obj,'');
	   			break;
   			case "c": // Criar Objeto
	   			JSChangeURL('/manage/new',JSint_cod_obj,'');   			
	   			break;
   			case "d": // Apagar Objeto
	   			JSChangeURL('/do/delete',JSint_cod_obj,'');   			
	   			break;
   			case "r": // Rejeitar Publicacao
	   			JSChangeURL('/do/rejeitar',JSint_cod_obj,'');   			
	   			break;
   			case "p": // Publicare Objeto
	   			JSChangeURL('/do/publicar',JSint_cod_obj,'');   			
	   			break;
   			case "l": // Lista Conteudo
	   			JSChangeURL('/do/list_content',JSint_cod_obj,'');   			
	   			break;
   			case "g": // Gerenciar Portal
	   			JSChangeURL('/do/indexportal',JSint_cod_obj,'');   			
	   			break;
   			case "u": // Gerenciar Usu�rios
	   			JSChangeURL('/do/gerusuario',JSint_cod_obj,'');   			
	   			break;
   			case "v": // Indice do Objeto
	   			JSChangeURL('/do/preview',JSint_cod_obj,'');   			
	   			break;
   			case "s": // Gerenciar Skins
	   			JSChangeURL('/do/peles',JSint_cod_obj,'');   			
	   			break;
   			case "o": // Logout
	   			JSChangeURL('/security/logout',JSint_cod_obj,'');   			
	   			break;	
			default:
				return evento;
				break;
   			}
   		  }
 		}

	function JSChangeURL(chrURL, intCod_Objeto, chrFrame) {
	if (chrFrame != '')
		chrFrame.parent.location.href="/index.php"+chrURL+"/"+intCod_Objeto+".html";
	else
		top.location.href="/index.php"+chrURL+"/"+intCod_Objeto+".html";
	}
 	// --> Fim de JS deteccao de teclas de atalho -->	*/
 
</script>
<table width="740" border="0" cellpadding="0" cellspacing="0" align="center">
<td valign="top" height="20" align="left">
<script language="JavaScript1.2" src="/html/javascript/menu/js_menutab_conf.js" type="text/javascript"></script>
</td></tr>
</table> 
<?php
	echo "<div id=\"divGuiaC\" style=\"height: 0%; visibility: hidden;\">";
?>
	<div class="pblAlinhamentoTabelas mercurio">
	<TABLE WIDTH=570 BORDER=0 CELLPADDING=0 CELLSPACING=8 class="pblTabelaGeral">
	<TR>
		<TD>
			<img border=0 src="/html/imagens/portalimages/peca3.gif"ALT="" align="left">
			<font class="pblTituloBox">Dicas <?=_VERSIONPROG?></font><br>
		</td>
	</TR>
	<tr><td>
	<pre>
	Quando estiver nesta janela, para facilitar a administra&ccedil;&atilde;o de seus objetos, utilize as teclas de atalho:
	- ctrl + alt + shift + E: Editar o Objeto atual
	- ctrl + alt + shift + C: Criar um Objeto, dentro do objeto atual
	- ctrl + alt + shift + D: Apagar Objeto atual
	- ctrl + alt + shift + P: Publicar Objeto atual
	- ctrl + alt + shift + R: Rejeitar publica&ccedil;&atilde;o do Objeto atual
	- ctrl + alt + shift + L: Listar conte&uacute;do, no Objeto atual
	- ctrl + alt + shift + V: Visualizar &Iacute;ndice do Objeto atual
	- ctrl + alt + shift + O: Efetuar LOGOFF no sistema

	* Aten&ccedil;&atilde;o: 
	1 - Alguns dos itens podem n&atilde;o funcionar, caso voce n&atilde;o tenha permiss&atilde;o dentro do objeto.
	2 - Devido a diferentes browsers dispon&iacute;veis no mercado, sua tecla de atalho pode funcionar
	    utilizando somente: ctrl + alt + LETRA
	
	</pre>
	</td></tr>
	<tr><td colspan="2"><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>
	</table>
	</div>
	</div>
<div id="divGuiaA" style="visibility: show;">