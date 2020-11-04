<?php
global $PORTAL_EMAIL, $_DBSERVERTYPE, $_DBHOST, $_DB;
?>
	<div class="pblAlinhamentoTabelas">
	<TABLE WIDTH=570 BORDER=0 CELLPADDING=0 CELLSPACING=8 class="pblTabelaGeral">
	<TR>
		<TD colspan="2">
			<img border=0 src="/html/imagens/portalimages/peca3.gif" ALT="" align="left">
			<font class="pblTituloBox">Informações do Publicare</font><br>
		</td>
	</TR>
	<tr>
		<td width="150" class="pblFormTitle" valign="top" align="left">Nome do Site:</td>
		<td class="pblFormText" valign="top" align="left">
		<?php
		 echo "<b>"._PORTAL_NAME."</b> [<i>"._LANGUAGE."</i>]";

		 ?>
		 </td>
	</tr>
	<tr>
		<td width="" class="pblFormTitle" valign="top" align="left">E-Mail Administrador:</td>
		<td class="pblFormText" valign="top" align="left">
	<?php
	echo $PORTAL_EMAIL;
	?>
	</tr>
	<tr>
		<td width="" class="pblFormTitle" valign="top" align="left">URL Principal:</td>
		<td class="pblFormText" valign="top" align="left">
		<?php
		echo _URL;
		?>
		</td>
	</tr>	
	<tr>
		<td width="" class="pblFormTitle" valign="top" align="left">Diretório Principal:</td>
		<td class="pblFormText" valign="top" align="left">
		<?php
		echo $_SERVER['DOCUMENT_ROOT'];
		?>
		</td>
	</tr>
	<tr>
		<td width="" class="pblFormTitle" valign="top" align="left">Diretório de Blob:</td>
		<td class="pblFormText" valign="top" align="left">
		<?php
		echo _BLOBDIR;
		?>
		</td>
	</tr>	
	<tr>
		<td width="" class="pblFormTitle" valign="top" align="left">Diretório de Thumb:</td>
		<td class="pblFormText" valign="top" align="left">
		<?php
			echo _THUMBDIR;
		?>
		</td>
	</tr>	
		<!--TESTAR SE O OBJETO TEM FILHOS -->
	<tr>
		<td width="" class="pblFormTitle" valign="top" align="left">Tipo de Banco de Dados:</td>
		<td class="pblFormText" valign="top" align="left">
		<?php
			if (_DBSERVERTYPE == "odbc_mssql")
				echo "Microsoft SQL";
			elseif (_DBSERVERTYPE == "mysql")
				echo "MySQL";
			else
				echo "PostgreSQL";
		?>
		</td>
	</tr>
		
	<tr>
		<td width="" class="pblFormTitle" valign="top" align="left">Banco utilizado & Porta:</td>
		<td class="pblFormText" valign="top" align="left">
		<?php
			echo _DBHOST.":"._DBPORT." [<i>"._DBNOME."</i>]";
		?>
		</td>
	</tr>
	<tr>	
	<td width="" class="pblFormTitle" valign="top" align="left">Navegador:</td>
		<td class="pblFormText" valign="top" align="left">
		<?php
		$arrRecebeNomeBrowser = DetectaBrowser();
		echo $arrRecebeNomeBrowser[1];
		?>
		</td>
	
	</tr>
		<tr><td colspan="2"><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>
	</table>
	</div>