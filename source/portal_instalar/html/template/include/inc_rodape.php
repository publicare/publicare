<?
global $_page;
if ($_GET["naoincluirheader"]==2)
{
	echo "<script>window.print();</script>";
}
else {
?>
<!-- =========================================================== -->
<!-- === ( topo, imprimir, envie para um amigo e fedes rss ) === -->

<div class="paddingTop12 paddingBottom12" align="right" >
	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td><img src="/html/imagens/site/ic-pontilhado.gif" width="3" height="15" /></td>
			<td align="center" class="paddingLeft paddingRight terra"><a href="#" title="ir para o topo">topo&nbsp;&nbsp;<img src="/html/imagens/site/ic-topo.gif" border="0" align="absmiddle" /></a></td>
			<td><img src="/html/imagens/site/ic-pontilhado.gif" width="3" height="15" /></td>
			<td align="center" class="paddingLeft paddingRight terra"><a href="#inexistente" id="print_button" title="imprimir esta página">imprimir&nbsp;&nbsp;<img src="/html/imagens/site/ic-imprimir.gif" width="16" height="13" border="0" align="absmiddle" /></a></td>
			<td><img src="/html/imagens/site/ic-pontilhado.gif" width="3" height="15" /></td>
			<td align="center" class="paddingLeft paddingRight terra"><a href="#" onclick="JSMostraeOcultaNovo('formAmigo');return false;" title="envie esta página para um amigo">envie para um amigo&nbsp;&nbsp;<img src="/html/imagens/site/ic-fale-conosco.gif" width="28" height="12" border="0" align="absmiddle" /></a></td>
			<td><img src="/html/imagens/site/ic-pontilhado.gif" width="3" height="15" /></td>
			<td align="center" class="paddingLeft paddingRight terra"><a href="/index.php/content/view/1.html?execview=rss" title="assinar nosso rss">feeds rss&nbsp;&nbsp;<img src="/html/imagens/site/ic-rss.gif" width="14" height="14" border="0" align="absmiddle" /></a></td>
			<td><img src="/html/imagens/site/ic-pontilhado.gif" width="3" height="15" /></td>
		</tr>
	</table>
</div>

<!-- Final ===================================================== -->
<!-- === ( topo, imprimir, envie para um amigo e fedes rss ) === -->
<!-- ================================ -->
<!-- === ( enviar para um amigo ) === -->
<div align="center" id="formAmigo" style="display: none;">
	<@incluir arquivo=["/html/template/include/inc_form_amigo.php"]@>
</div>

<?php } ?>

<script>
$("#print_button").click
(
  function()
  {
      $("#conteudo").printArea();
  }
);
</script>
