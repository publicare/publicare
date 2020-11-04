<script type="text/javascript">
	function startCallback() {
		// make something useful before submit (onStart)
		return true;
	}
 
	function completeCallback(response) {
		// make something useful after (onComplete)
		//document.getElementById('nr').innerHTML = parseInt(document.getElementById('nr').innerHTML) + 1;
		document.getElementById('r').innerHTML = response;
		document.formulario.reset();
	}
	function JSAdicionaArquivo(destino,nome_campo)
	{
		var indice = parseInt($("#indice").val())+1;
		$("#indice").val(indice);
		$("#"+destino).append("<div id='"+nome_campo+indice+"'><label>Arquivo:</label> <input type='file' name='"+nome_campo+"[]'> <span onclick='JSRemoveArquivo(\""+nome_campo+indice+"\")' style='cursor:pointer'><font color='blue'>remover</font></span></div>");
	}
	function JSRemoveArquivo(destino)
	{
		$("#"+destino).remove();
		var indice = parseInt($("#indice").val())-1;
		$("#indice").val(indice);
	}
</script>
<div align="right"><a href="#" onclick="document.getElementById('camposform').style.display = ''; return false;">[ADICIONAR MÚLTIPLAS IMAGENS]</a></div>
<div id="camposform" style="display:none">
<hr color="#CCCCCC" size="1">
<table width="100%" bgcolor="#EFEFEF" cellpadding="3"  cellspacing="3">
	<tr>
		<td colspan="2" bgcolor="#DFDFDF" style="padding:5px"><b>Envio de múltiplas imagens</b></td>
	</tr>
 	<tr>
 		<td width="50%" valign="top">
			<form action="/html/objects/inserirMultiplasImagens.php" method="post" id="formulario" name="formulario" enctype="multipart/form-data" onsubmit="return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback})">
			<div id="camposfile">
				<input type="hidden" name="indice" id="indice" value="3">
				<?php 
					$qtde = 10;
					echo "<table width='100%'>";
					for($i=1; $i <= $qtde; $i++)
					{
						echo "<tr>";
							echo "<td nowrap>";
								echo "Nome foto:";
							echo "</td>";
							echo "<td>";
								echo "<input type='text' name='nomefoto".$i."'/> ";
							echo "</td>";
							echo "<td nowrap>";
								echo "Arquivo:";
							echo "</td>";
							echo "<td>";
								echo "<input type='file' name='foto".$i."'/>";
							echo "</td>";
						echo "</tr>";
					}
					echo "</table>";
				?>
				
			</div>
			<input type="hidden" name="intCodPai" value="<@= #cod_objeto@>">
			<input type="hidden" name="strPrefixoClasse" value="<@= #prefixoclasse@>">
			<input type="hidden" name="intCodClasse" value="<@= #cod_classe@>">
			<input type="hidden" name="intCodUsuario" value="<@= #cod_usuario@>">
			<input type="hidden" name="intCodPele" value="<@= #cod_pele@>">
			<input type="hidden" name="dteValidade" value="<@= #data_validade@>">
			<input type="hidden" name="strScriptExibir" value="<@= #script_exibir@>">
			<!-- 
				<div style="text-align:right">
					<span onclick="JSAdicionaArquivo('camposfile','blob')" style="cursor:pointer"><font color="blue">adicionar arquivo</font></span>
				</div>
			 -->
			<br></br><div align="center"><input type="submit" value="Enviar imagem(ns)" /></div>
			</form>
		</td>
		<td width="50%" style="padding-left:15px">
			<!-- <div>Formulario submetido <span id="nr">0</span> vez(es)</div> -->
			<div><pre id="r">
		</td>
	</tr>
	<tr>
		<td align="right" colspan="2">
			<a href="#" onclick="document.getElementById('camposform').style.display = 'none'; return false;">[FECHAR]</a>
		</td>
	</tr>
	<tr>
	</tr>
</table>
</div>
<hr color="#CCCCCC" size="1">