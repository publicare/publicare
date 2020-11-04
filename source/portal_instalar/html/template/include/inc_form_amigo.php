<?
    if (isset($_GET["ok"])) echo "<script>alert('Mensagem enviada com sucesso');</script>";
?>
<form action="/html/objects/enviaEmailAmigo.php" id="formEnviaEmailParaAmigo" method="POST" onsubmit="return Verifica(this);">	
	<table width="100%" border="0" cellspacing="0" cellpadding="0" title="Seções">
		<tr>
			<td colspan="3" class="mvInternoTituloFundo cxTitulo">
				<div class="mvInternoTituloLeft">
					<div class="mvInternoTituloRight">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="100%" class="mvInternoPaddingLeft"><a href="#" title="Envie para um amigo">Envie para um amigo</a></td>
								<td align="right" class="mvInternoPaddingRight "><a href="#" onclick="JSMostraeOcultaNovo('formAmigo')" title="fechar"><img src="/html/imagens/site/ic-fechar.gif" width="15" height="15" border="0" align="absmiddle"></a></td>
							</tr>
						</table>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td  colspan="3" class="cxBg bgverdeCx">
<!-- ============================================ -->
<!-- === ( Conteúdo de enviar para um amigo ) === -->
				<div class="bold terra">Nome do remetente:*</div>
				<div class="paddingBottom paddingTop"><input name="nomeRemetente" type="text" id="nomeRemetente" obrigatorio="1" class="formulario tamanhoForm"></div>
				<div class="bold terra">Email do remetente:*</div>
				<div class="paddingBottom paddingTop"><input name="emailRemetente" type="text" id="emailRemetente" obrigatorio="1" class="formulario tamanhoForm"></div>
				<div class="bold terra">Nome do destinatário:</div>
				<div class="paddingBottom paddingTop"><input name="nomeDestinatario" type="text" id="nomeDestinatario" obrigatorio="1" class="formulario tamanhoForm"></div>
				<div class="bold terra">Email do destinatario:*</div>
				<div class="paddingBottom paddingTop"><input name="emailDestinatario" type="text" id="emailDestinatario" obrigatorio="1" class="formulario tamanhoForm"></div>
				<div class="bold terra">Comentário:</div>
				<div class="paddingBottom paddingTop"><textarea name="txtComentario" rows="3" class="formularioTextArea tamanhoForm" id="txtComentario"></textarea></div>
				<input type="hidden" id="enderecoPagina" name="enderecoPagina" value="<?=_URL?>/index.php/content/view/<@= #cod_objeto@>.html">
				<div align="center" class="paddingTop"><input name="limpar" type="reset" id="limpar2" value="limpar" class="botao">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="enviar" type="submit" id="enviar2" value="enviar" class="botao"></div>
<!-- Final ====================================== -->
<!-- === ( Conteúdo de enviar para um amigo ) === -->
			</td>
		</tr>
		<tr>
			<td class="left-bottom-b-verde-cx bgverdeCx"><img src="/html/imagens/site/nada.gif" width="4" height="4" alt="imagem"></td>
			<td width="100%" class="bottom-b-verde-cx bgverdeCx"><img src="/html/imagens/site/nada.gif" width="4" height="4" alt="imagem"></td>
			<td class="right-bottom-b-verde-cx bgverdeCx"><img src="/html/imagens/site/nada.gif" width="4" height="4" alt="imagem"></td>
		</tr>
	</table>
</form>
<!-- ================================ -->
<!-- === ( enviar para um amigo ) === -->
<script>
function Verifica(form)
{
if (!form.nomeRemetente.value)
{ alert("Você deve preencher nome do remetente.");return false;}

if (!form.emailRemetente.value)
{ alert("Você deve preencher email do remetente.");return false;}

if (!form.emailDestinatario.value)
{ alert("Você deve preencher email do destinatário.");return false;}

var emailValido = /^[\w!#$%&'*+\/=?^`{|}~-]+(\.[\w!#$%&'*+\/=?^`{|}~-]+)*@(([\w-]+\.)+[A-Za-z]{2,6}|\[\d{1,3}(\.\d{1,3}){3}\])$/;
if (!emailValido.test(form.emailRemetente.value)) {
alert(form.emailRemetente.value + " NÃO é um endereço de e-mail válido.");
return false;
}
if (!emailValido.test(form.emailDestinatario.value)) {
alert(form.emailDestinatario.value + " NÃO é um endereço de e-mail válido.");
return false;
}

return true;
}
</script>