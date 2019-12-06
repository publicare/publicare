<?php
	//BoxPublicareTop("publicare");
?>
	<div class="pblAlinhamentoTabelas">
	<table class="pblTabelaGeral" cellpadding="8" cellspacing="0" bgcolor="white" width="520">
	<tr>
    	<td>
        	<img  align="center" src="/html/imagens/portalimages/peca.gif" ><font class="pblTituloBox">&nbsp;Publicare</font><p>
				<div align="center">

					<table border="0" cellspacing="8">
						<tr>
							<td width=520 align="left">
									<? 
										$num_filhos = $_page->_adminobjeto->PegaNumFilhos($_page, $_page->_objeto->Valor($_page, "cod_objeto"));
										//Alertar o usuario que o objeto a ser apagado contem filhos
										if ($num_filhos>0) {
										
											echo '<font class="pblTituloForm" style="color: #ff0000">ATEN&Ccedil;&Atilde;O<br>O objeto cont&eacute;m filhos. Ao apag&aacute;-lo, todos os filhos ser&atilde;o apagados tamb&eacute;m.</font>';
										}
										
										$info = $_page->_log->InfoObjeto($_page, $_page->_objeto->Valor($_page, "cod_objeto"));
										echo "<p class=\"pblTituloForm\">".$_page->_objeto->Valor($_page, "titulo")."</p>";
										echo '<p class="pblTextoLabelForm">&Uacute;ltima altera&ccedil;&atilde;o do Objeto:</p>';
										echo "<p><font class=\"pblTextoLabelForm\">Usu&aacute;rio:</font> <font class=\"pblTextoForm\">" . $info['usuario'].'</font><br>';
										echo "<font class=\"pblTextoLabelForm\">Data:</font> <font class=\"pblTextoForm\"> ".$info['estampa'].'</font><br>';
										echo "<font class=\"pblTextoLabelForm\">Mensagem:</font> <font class=\"pblTextoForm\"> ".$info['mensagem'].'</font></p>';
										
									?>
								<form action="/index.php/do/delete_post.php/<? echo $_page->_objeto->Valor($_page, "cod_objeto")?>.html" method="post" name="delete_post" id="delete_post">
									<input type="hidden" name="cod_pai" value="<? echo $_page->_objeto->Valor($_page, "cod_pai")?>">
									<input class="pblBotaoForm" type="submit" name="submit" value="Remover Objeto">	
								</form>		
							</td>
							</tr>
					</table>
			</TD></TR>
			<TR><TD COLSPAN="2"><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>
			</TABLE>