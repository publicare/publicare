<?
global $_page;
	if (($_page->_objeto->PodeTerFilhos()))
	{
?>
<form action="/index.php/do/pilha_post/<? echo $_page->_objeto->Valor($_page, "cod_objeto")?>.html" method="POST" name="objmanage" id="objmanage">
	
	<div class="pblAlinhamentoTabela">
	<table width="570" border="0" cellpadding="8" cellspacing="2" class="pblTabelaGeral">
	<TR>
		<TD width="350" colspan="3">
			<img border=0 src="/html/imagens/portalimages/peca3.gif" align="left"><font class="pblTituloBox">Pilha</font></td>
		<TD width="100" class="pblAlinhamentoBotoes">
			<a href="#" onclick="history.back()"><img border=0 src="/html/imagens/portalimages/voltar2.gif" ALT="Voltar"></a></TD>
	</TR>
		<tr id="trGravarPilha2" style="display:none" height="60px">
			<td class="pblTextoForm" colspan=3 align="right">
			Processando informa&ccedil;&otilde;es .... aguarde....
			</td>
		</tr>
		<tr id="trGravarPilha1">
			<td class="pblTituloForm">
				<select class="pblSelectForm" name="cod_objmanage">
					<? echo $_page->_administracao->DropDownPilha($_page) ?>
				</select>
				<?
					if ($_page->_administracao->TemPilha($_page))
					{
				?>
				<br>&nbsp;<BR>
				<input class="pblBotaoForm" type="submit" name="pastelink" value=" Colar Link " onclick="trGravarPilha2.style.display='';trGravarPilha1.style.display='none';">&nbsp;&nbsp;
				<input class="pblBotaoForm" type="submit" name="move" value="Mover" onclick="trGravarPilha2.style.display='';trGravarPilha1.style.display='none';">
				<input class="pblBotaoForm" type="submit" name="copy" value="Colar c&oacute;pia" onclick="trGravarPilha2.style.display='';trGravarPilha1.style.display='none';">
				<input class="pblBotaoForm" type="submit" name="clear" value="Limpar Lista" onclick="trGravarPilha2.style.display='';trGravarPilha1.style.display='none';">

				<?
					}
				?></td>
		</tr>
		
		<tr><td><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>
	</table>
	</div>
</form>
<?
	}
?>