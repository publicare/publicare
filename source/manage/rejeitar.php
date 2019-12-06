<?
global $_page;
?>
<div id="divGuiaA" style="height: 0%; visibility: show;">

<form action="/index.php/do/rejeitar_post/<? echo $_page->_objeto->Valor($_page, "cod_objeto");?>.html" method="post">

<div class="pblAlinhamentoTabelas">
		<TABLE width="570" border="0" cellpadding=0 cellspacing=8 class="pblTabelaGeral">
			<TR>
				<TD width="450">
					<img border=0 src="/html/imagens/portalimages/peca3.gif" ALT="" align="left"><font class="pblTituloBox">Rejeitar</font><br>
					<font class="pblTextoForm"><? echo $_page->_objeto->Valor($_page, "titulo")?></font>
				</TD>
				<TD width="120" class="pblAlinhamentoBotoes">
					<a class="ABranco" href="/index.php/content/view/<? echo $_page->_objeto->Valor($_page, "cod_objeto")?>.html"><img border=0 src="/html/imagens/portalimages/exibir.png" ALT="Exibir Objeto" hspace="2"></a>
					<a href="#" onclick="history.back()"><img border=0 src="/html/imagens/portalimages/voltar2.gif" ALT="Voltar"></a>
				</TD>
			</TR>
			
			<TR><TD COLSPAN="2" HEIGHT="10"></TD></TR>
			
			<TR><TD colspan="2">
			
	<div align="center">
	<table cellpadding=4 cellspacing=2 width="510" border="0">
	<tr>
		<td class="pblTituloForm">
			<P>Coment&aacute;rios<br>
			<textarea class="pblInputForm" name="message" rows=5 cols=59 ><? echo isset($message)?$message:""; ?></textarea>
		</td>
	</tr>
	<tr>
		<td class="pblTituloForm"align="right">
			<input type="submit" class="pblBotaoForm" name="submit" value="Gravar">	
		</td>
	</tr>
	</table>
	</div>
</TD></TR>

<TR><TD COLSPAN="2"><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>

</TABLE>
</div>
</form>
</div>
<?php
	/* =============
	Inserindo Guias
	================*/
	echo "<div id=\"divGuiaB\" style=\"height: 0%; visibility: hidden;\">";
	include_once ("log_workflow.php");
	echo "</div>";

	echo "<div id=\"divGuiaC\" style=\"height: 0%; visibility: hidden;\">";
	include_once ("log_objeto.php");
	echo "</div>";
?>