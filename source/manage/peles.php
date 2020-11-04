<?php
global $_page;

$cod_pele = isset($_POST['cod_pele'])?$_POST['cod_pele']:(isset($_GET['cod_pele'])?$_GET['cod_pele']:0);

$row = array("nome"=>"",
        "prefixo"=>"",
        "publica"=>"");


if ($cod_pele > 0)
{
    $sql = "select nome,prefixo,publica from pele where cod_pele=".$cod_pele;
    $rs = $_page->_db->ExecSQL($sql);
    $row = $rs->fields;
}

if (isset($_GET['msg']))
{
        $row['nome']=$_GET['nome'];
        $row['prefixo']=$_GET['prefixo'];
}
?>


	<div class="pblAlinhamentoTabelas">
	<TABLE WIDTH=500 BORDER=0 CELLPADDING=0 CELLSPACING=8 class="pblTabelaGeral">
	<TR>
		<TD>
			<img border=0 src="/html/imagens/portalimages/peca3.gif" ALT="" align="left"><font class="pblTituloBox">Apar&ecirc;ncia</font>
		</td>

		<TD class="pblAlinhamentoBotoes">
			<a href="#" onclick="history.back()"><img border=0 src="/html/imagens/portalimages/voltar2.gif" ALT="Voltar"></a></TD>
	</TR>
	<tr>
		<td colspan="2">
			<TABLE width=485 BORDER=0 cellpadding="4" cellspacing=2>
				<tr>
					<td class="pblTextoLabelForm" valign="top" valign="top">
						Apar&ecirc;ncia
					</td>
					<td class="pblTextoForm">
						<form style="padding:0px; margin:0px;"  action="/index.php/do/peles/<? echo $_page->_objeto->Valor($_page, "cod_objeto")?>.html" method="post">
							<select class="pblSelectForm" name="cod_pele">
								<option value="0"> -- NOVA -- </option>
								<? echo $_page->_administracao->DropDownListaDePeles($_page, $cod_pele, false)?>
							</select>
						<input class="pblBotaoForm" type="submit" value="Selecionar">
						</form>
					</td>
				</tr>
			</table>
			<hr size="1">
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<form style="padding:0; margin:0;" action="/index.php/do/peles_post.php/<?php echo $_page->_objeto->Valor($_page, "cod_objeto")?>.html" method="post">
				<input type="hidden" name="cod_pele" value="<? echo $cod_pele?>">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="pblTextoLabelForm" width=150 valign="top">
						Nome
					</td>
					<td class="pblTextoForm" valign="top">
						<input class="pblInputForm" type="Text" name="nome" value="<?php echo $row['nome']?>">
					</td>
				</tr>
				<tr>
					<td class="pblTextoLabelForm"  width=150 valign="top">
						Prefixo
					</td>
					<td class="pblTextoForm" valign="top">
						<input class="pblInputForm" type="Text" name="prefixo" value="<?php echo $row['prefixo']?>">
					</td>
				</tr>
				<tr>
					<td class="pblTextoLabelForm" colspan=2 align="left">
					<input type="checkbox" name="publica" id="publica" <?=($row['publica'])?'checked':''?>><label for="publica"> Tornar P&uacute;blica</label>
					</td>
				</tr>
                <?php
                	echo "<tr><td colspan='2' height='4'></td></tr>";
					echo "<tr><td colspan='2' class='pblInputForm pblTextoLabelForm'>";
					if (isset($_GET['erro'])) echo "<b>Erro: ".$_GET['erro']."</b>";
					echo "</td></tr>";
					echo "<tr><td colspan='2' height='4'></td></tr>";
				?>
				<tr>
					<td class="pblTextoLabelForm" colspan=2 align="right">
						<?
							if ($cod_pele)
							{
						?>
							<input class="pblBotaoForm" type="submit" name="update" value="Alterar">&nbsp;&nbsp;&nbsp;<input class="pblBotaoForm" type="submit" name="delete" value="Remover">
						<?
							}
							else
							{
						?>
							<input class="pblBotaoForm" type="submit" name="new" value="Criar">
						<? }?>
					</td>
				</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr><td colspan="2"><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>
</table>