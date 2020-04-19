<?php
global $_page, $cod_objeto;
?>
	<form action="/index.php/do/new_post.php/<?=$_page->_objeto->Valor($_page, "cod_objeto")?>.html" name="listcontent" id="listcontent">
	<input type="hidden" name="cod_objeto" value="<? echo $cod_objeto?>">
	<input type="hidden" name="prefixo" id="prefixo" value="">

	<div class="pblAlinhamentoTabelas">
	<TABLE width=550 cellpadding=0 cellspacing=8 class="pblTabelaGeral" border="0">
	<TR>
		<TD width="525">
			<img border=0 src="/html/imagens/portalimages/peca.gif" ALT="" align="left"><font class="pblTituloBox">Selecione a classe</font><br>
			<font class="pblTextoForm"><?
	echo $_page->_objeto->Valor($_page, "classe").": ".$_page->_objeto->Valor($_page, "titulo");?></font></td>
		<TD width="25" class="pblAlinhamentoBotoes">
			<a href="#" onclick="history.back()"><img border=0 src="/html/imagens/portalimages/voltar2.gif" ALT="Voltar"></a></TD>
	</TR>
	<TR><TD colspan="2">
	<DIV ALIGN="CENTER"><table width="500" border="0">
	<tr>
		<td class="pblTituloForm" colspan="2" width="500">
			Classe<BR>
			<hr color="#FA9C00" size="2">
		</td>
	</tr>
<?
	$lista=$_page->_administracao->ListaDeClassesPermitidas($_page, $_page->_objeto->Valor($_page, "cod_classe"));
	$lista2=$_page->_administracao->ListaDeClassesPermitidasNoObjeto($_page, $_page->_objeto->Valor($_page, "cod_objeto"));
	
	$lista=array_merge($lista,$lista2);
	foreach($lista as $row)
	{
?>
		<tr>
			<td class="pblTituloForm" colspan="2">
				
			</td>
		</tr>
		<tr onclick="document.listcontent.prefixo.value=this.id;listcontent.submit();" id="<?=$row['prefixo']?>">
			
			<td class="pblTituloForm" width="10" valign="top">
				<img src="/html/imagens/portalimages/ver_dep.gif">
			</td>
			<td class="pblTextoForm" width="525" style="cursor:pointer;">
				<? echo '<b>'.$row['nome'].'</b><br><i>'.$row['descricao'].'</i>';?>
			</td>
		</tr>
	<?
	}
	?>
	</table></DIV>
	</TD></TR>
	
	<tr><td colspan="2"><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>
	
	</table>
	</div>

	</form>