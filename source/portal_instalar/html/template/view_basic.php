<?php
/**
* Criacao da view Basic e seus includes
*
* @author Manuel Poppe Correia de Barros
* @version * <pre>
*   <b>1.0</b>
*    Data: 20/11/2008
*    Autor: Manuel Poppe Correia de Barros
*    Descricao: Versao inicial
*   <hr>
* </pre>  
* @name view_basic
* @package html/template
* @access public
*/ 
?>

<?php
	global $COD_OBJETO, $TAGS;
?>
<script type="text/javascript" src="/html/javascript/highslide/highslide-with-gallery.js"></script>
<@incluir arquivo=["/html/template/include/inc_highside_galery.php"]@>
<link rel="stylesheet" href="/html/css/highslide.css" type="text/css" />
<@var $COD_OBJETO=#cod_objeto@>
<@var $inicio=3@>
<@var $TAGS = #tags@>
<@var $titulo = #titulo@>
<!-- ======== incluir arquivo do titulo =========== -->
<@incluir arquivo=["/html/template/include/inc_titulo.php"]@>

<!-- ================================================= -->
<!-- === ( Texto ou qualquer conteúdo entra aqui ) === -->
<table width="100%">
	<tr>
		<td class="paddingBottom15">
<!-- ======== insere uma imagem antes do texto se ela existir =========== -->
			<@incluir arquivo=['/html/template/include/inc_imagem.php']@>
			<@se [#texto!='']@>			
		        <div class="paddingBottom10 paddingRight15">
		            <@= strip_tags(#texto,'<a><b><p><br><strong><i><u><ul><li><table><tr><td>')@>
		        </div>
		    <@/se@>
	    </td>
    </tr>
</table>
<!-- Final =========================================== -->
<!-- === ( Texto ou qualquer conteúdo entra aqui ) === -->

<!-- ======== lista todos os filhos imagem do objeto =========== -->
<@incluir arquivo=['/html/template/include/inc_filhosImagens.php']@>


<!-- ======================================================== -->
<!-- ======= ( Veja Também ) ================================ -->
<!-- ======= lista todos os filhos do objeto menos imagem === -->
<@incluir arquivo=['/html/template/include/inc_listatodos.php']@>


<!-- ======================================================== -->
<!-- ======= ( Rodape ) ================================ -->
<!-- ======= enviar para um amigo, imprimir, rss, e topo === -->
<@incluir arquivo=['/html/template/include/inc_rodape.php']@>
