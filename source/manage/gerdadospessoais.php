<?
global $_page;
?>
	<script>


		function ChecaValidade(frm)
		{
			if (frm.email.value=='')
			{
				alert ("O campo email não pode ficar em branco");
				return false;
			}
			if (frm.nome.value=='')
			{
				alert ("O campo nome não pode ficar em branco");
				return false;
			}
			if (frm.login.value=='')
			{
				alert ("Login não pode ficar em branco");
				return false;
			}
			if (frm.senha.value!=frm.confirma.value)
			{
				alert ("Senha diferente da confirmação");
				return false;
			}
			return true;
		}
	</script>
	
	<form method="GET" action="/index.php/do/usuarios/<? echo $_page->_objeto->Valor($_page, 'cod_objeto');?>.html">
	
	<div class="pblAlinhamentoTabelas">
	<TABLE WIDTH=570 BORDER=0 CELLPADDING=0 CELLSPACING=8 class="pblTabelaGeral">
	<TR>
		<TD width="350" colspan="2">
			<img border=0 src="/html/imagens/portalimages/peca3.gif" ALT="" align="left"><font class="pblTituloBox">Gerenciamento do portal</font></td>
		<TD width="100" class="pblAlinhamentoBotoes">
			<a href="#" onclick="history.back()"><img border=0 src="/html/imagens/portalimages/voltar2.gif" ALT="Voltar"></a></TD>
	</TR>
	<tr><td width="100" height="10"></td>
		<td width="300" height="10"></td>
		<td width="50" height="10"></td>
	</tr>

	<tr>
		<td width="160" class="pblTextoLabelForm">
			Usu&aacute;rio</td>
		<td class="pblTextoForm" colspan="2" width="390">
			<?php echo $_SESSION['usuario']['nome']; ?>
		</td>
	</tr>
	<tr>
		<td width="160" class="pblTextoLabelForm">
			&Aacute;rea vinculada</td>
		<td class="pblTextoForm" colspan="2" width="390">
			<?php echo $_SESSION['usuario']['secao']; ?>
		</td>
	</tr>
	<tr>
		<td colspan="3">
		 	<hr color="#FA9C00" size="1">
		</td>
	</tr>
	</form>			
	<form action="/index.php/do/gerdadospessoais_post/<?echo $_page->_objeto->Valor($_page, 'cod_objeto')?>.html" method="POST" onsubmit="return ChecaValidade(this);">
	<input type="hidden" name="cod_usuario" value="<? echo $_SESSION['usuario']['cod_usuario'];?>">
	<input type="hidden" name="nomehidden" value="<? echo $_SESSION['usuario']['nome'];?>">
	<input type="hidden" name="secao" value="<? echo $_SESSION['usuario']['secao'];?>">
	<input type="hidden" name="nome" value="<? echo $_SESSION['usuario']['nome'];?>">
<!--		<tr>
			<td width="160" class="pblTextoLabelForm">
				&Aacute;rea vinculada</td>
			<td class="pblTextoForm" colspan="2">
				<INPUT class="pblInputForm" type="text" name="secao" value="<?php //echo $_SESSION['usuario']['secao'];?>">
			</td>
		</tr>
		
	<tr>
			<td width="160" class="pblTextoLabelForm">
				Nome Completo</td>
			<td class="pblTextoForm" colspan="2">
				<INPUT class="pblInputForm" type="text" name="nome" value="<?php //echo $_SESSION['usuario']['nome'];?>">
			</td>
		</tr>
		-->
		<tr>
			<td width="160" class="pblTextoLabelForm">
				E-mail</td>
			<td class="pblTextoForm" colspan="2">
				<INPUT class="pblInputForm" type="text" name="email" value="<?php echo $_SESSION['usuario']['email'];?>">
			</td>
		</tr>
		<tr>
			<td width="160" class="pblTextoLabelForm">
				Ramal (contato)</td>
			<td class="pblTextoForm" colspan="2">
				<INPUT class="pblInputForm" type="text" name="ramal" value="<?php echo $_SESSION['usuario']['ramal'];?>">
			</td>
		</tr>
		<tr>
			<td width="160" class="pblTextoLabelForm">
				Senha</td>
			<td class="pblTextoForm" colspan="2">
				<INPUT class="pblInputForm" type="password" name="senha" value="<?php echo $_SESSION['usuario']['nome'];?>">
			</td>
		</tr>
		<tr>
			<td width="160" class="pblTextoLabelForm">
				Confirme a Senha</td>
			<td class="pblTextoForm" colspan="2">
				<INPUT class="pblInputForm" type="password" name="confirma" value="<?php echo $_SESSION['usuario']['nome'];?>">
			</td>
		</tr>
		<? if ($GLOBALS['Msg']) {?>
			<tr>
				<td class="pblMensagemForm" colspan="2" align="center">
					<? echo $GLOBALS['Msg'];?>
				</td>
			</tr>
		<? } ?>
		<tr>
			<td colspan="3" align="right" class="pblTextoForm">
				<hr color="#FA9C00" size="2"><br>
				<INPUT class="pblBotaoForm" type="submit" name="submit" value="Gravar">
			</td>
		</tr>
		
		<tr><td colspan="3"><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>
	</table>
	</div>
	
	</form>
