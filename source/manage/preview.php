<?
global $_page;
?>
<div id="divGuiaA" style="height: 0%; visibility: hidden;">
	<div class="pblAlinhamentoTabelas">
	<TABLE WIDTH=570 BORDER=0 CELLPADDING=0 CELLSPACING=8 class="pblTabelaGeral">
	<TR>
		<TD colspan="2">
			<img border=0 src="/html/imagens/portalimages/peca3.gif" ALT="" align="left"><font class="pblTituloBox">Preview de Objeto</font><br>
		</td>
	</TR>
	<tr>
		<td width="130" class="pblFormTitle" valign="top" align="left">Objeto:</td>
		<td class="pblFormText" valign="top" align="left">
		<?php
		 echo "<b>".$_page->_objeto->Valor($_page, "titulo")."</b>";
		 echo " <i>[cod: ".$_page->_objeto->Valor($_page, "cod_objeto")."]</i>";

		 ?>
		 </td>
	</tr>
	<tr>
		<td width="" class="pblFormTitle" valign="top" align="left">Hierarquia:</td>
		<td class="pblFormText" valign="top" align="left">
	<?php
//	echo "<pre>";
//	var_dump($_page->_objeto);
//	exit();
	$tmpCaminhoObjeto=$_page->_objeto->PegaCaminhoComTitulo($_page);
	foreach ($tmpCaminhoObjeto as $item)
	{
		echo '<a href="/index.php/do/preview/'.$item['cod_objeto'].'.html">'.$item['titulo'].'</a><i> [cod: '.$item['cod_objeto'].']</i><br>';
	}
	?>
	</tr>
	<tr>
		<td width="" class="pblFormTitle" valign="top" align="left">Classe:</td>
		<td class="pblFormText" valign="top" align="left">
		<?php
		echo $_page->_objeto->Valor($_page, "classe")." [".$_page->_objeto->Valor($_page, "prefixoclasse")."]";
		?>
		</td>
	</tr>	
	<tr>
		<td width="" class="pblFormTitle" valign="top" align="left">Pele:</td>
		<td class="pblFormText" valign="top" align="left">
		<?php
		if ($_page->_objeto->metadados['cod_pele'])
		{
			echo $_page->_objeto->metadados['prefixopele'];
			echo "<i> [cod: ".$_page->_objeto->metadados['cod_pele']."]</i>";
		}
		else
		echo "N&atilde;o utilizada [cod: 0]"
		?>
		</td>
	</tr>	
	<tr>
		<td width="" class="pblFormTitle" valign="top" align="left">Script:</td>
		<td class="pblFormText" valign="top" align="left">
		<?php
		if ($_page->_objeto->metadados['script_exibir']) {
		 if (file_exists($_SERVER['DOCUMENT_ROOT'].$_page->_objeto->metadados['script_exibir']))
			echo $_page->_objeto->metadados['script_exibir'];
		 else
			echo "<b>A view do objeto foi deletada! <i>[".$_page->_objeto->metadados['script_exibir']."]</i></b>";}
		else
			echo "Sele&ccedil;&atilde;o autom&aacute;tica [cod: 0]";
		?>
		</td>
	</tr>	
		<!--TESTAR SE O OBJETO TEM FILHOS -->
	<tr>
		<td width="" class="pblFormTitle" valign="top" align="left">Objeto pode ter filhos:</td>
		<td class="pblFormText" valign="top" align="left">
		<?php
		if ($_page->_objeto->Valor($_page, "temfilhos"))
			echo "Sim";
		else
			echo "Nao";
		?>
		</td>
	</tr>
		<!--TESTAR SE O OBJETO ESTA PUBLICADO -->
		
	<tr>
		<td width="" class="pblFormTitle" valign="top" align="left">Status do objeto:</td>
		<td class="pblFormText" valign="top" align="left">
		<?php
		if ($_page->_objeto->Valor($_page, "cod_status")!=_STATUS_PUBLICADO)
			echo "<b>N&atilde;o publicado</b>";
		else
			echo "Publicado";
		?>
		</td>
	</tr>
	<tr>	<td width="" class="pblFormTitle" valign="top" align="left">Publica&ccedil;&atilde;o:</td>
		<td class="pblFormText" valign="top" align="left">
		<?php
		echo $_page->_objeto->Valor($_page, "data_publicacao");
		?>
		</td>
	</tr>
	<tr>	<td width="" class="pblFormTitle" valign="top" align="left">Validade:</td>
		<td class="pblFormText" valign="top" align="left">
		<?php
		echo $_page->_objeto->Valor($_page, "data_validade");
		?>
		</td>
	
	</tr>
	<tr>	<td width="" class="pblFormTitle" valign="top" align="left">Navegador:</td>
		<td class="pblFormText" valign="top" align="left">
		<?php
		$arrRecebeNomeBrowser = DetectaBrowser();
		echo $arrRecebeNomeBrowser[1];
		?>
		</td>
	
	</tr>
	<tr>
		<td colspan="2">
		<hr color="orange" size=1 width=520>
		</td>
	</tr>	
	<tr>
		<td colspan="2">
		<font class="pblTituloBox">Informa&ccedil;&atilde;es do Usu&aacute;rio</font>
		</td>
	</tr>
		<tr>
			<td width="160" class="pblFormTitle" valign="top">
				
				Nome do usu&aacute;rio: 
				<BR>
				<?php
				if (isset($_page->user->anonymous))
				echo "<font color=red size=11><b>Anonimo</b></font>";
				else
				echo "<font color=red>".$_SESSION['usuario']['nome']."</font>";
				
				?>
				<BR>
				Perfil no objeto:
				<BR>
				<?php
				$recebePerfil = VerificaPerfil($_SESSION['usuario']['perfil']);
				echo "<font color=red>".$recebePerfil."</font>";
				?>
			</td>
			<td class="pblFormText" valign="top">
			<?php
			//$incluir="$DOCUMENT_ROOT/manage/ajuda/topicos.php";
			//include ("$incluir");
			?>
			</td>
			

		</tr>
		<tr><td colspan="2"><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>
		
	</table>
	</div>
	</div>
<?php
	/* =============
	Inserindo Guias
	================*/
	echo "<div id=\"divGuiaB\" style=\"height: 0%; visibility: hidden;\">";
	include ("log_workflow.php");
	echo "</div>";

	echo "<div id=\"divGuiaC\" style=\"height: 0%; visibility: hidden;\">";
	include ("log_objeto.php");
	echo "</div>";
?>