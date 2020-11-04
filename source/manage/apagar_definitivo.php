<?
global $_page;
?>
<form action="/index.php/do/apagar_definitivo_post.php/<?=$_page->_objeto->Valor($_page, "cod_objeto")?>.html" name="listcontent" id="listcontent" method="POST">
	<div class="pblAlinhamentoTabelas">
	<table class="pblTabelaGeral" cellpadding="8" cellspacing="0" bgcolor="white" width="520">
	<tr>
    	<td>
        	<img  align="center" src="/html/imagens/portalimages/peca.gif" ><font class="pblTituloBox">&nbsp;Apagar em definitivo</font><p>
				<div align="center">
				<table align="center" width="480" border="0" cellpadding="4" cellspacing="0">
				<tr>
					<td class="pblTituloLog" width="30">
						&nbsp;
					</td>
					<td class="pblTituloLog" width="360">
						T&iacute;tulo
					</td>
					<td class="pblTituloLog" width="90">
						Classe
					</td>
				</tr>
<?
	$deletedlist=$_page->_administracao->PegaListaDeApagados($_page);
	$count=0;
	foreach ($deletedlist as $obj)
	{
		$show=true;
		if ($_SESSION['usuario']['perfil']==_PERFIL_AUTOR || $_SESSION['usuario']['perfil']==_PERFIL_RESTRITO)
		{
			if ($obj['cod_usuario']==$_SESSION['usuario']['cod_usuario'])
				$show=true;
			else
				$show=false;
		}
		if ($show)
		{
			if ($count++%2)
				$classe="pblTextoLogImpar";
			else
				$classe="pblTextoLogPar";
			?>
					<tr>
						<td valign="top" class="<? echo $classe?>" width=30>
							<input type="checkbox" name="objlist[]" value="<? echo $obj["cod_objeto"];?>">
						</td>
						<td class="<? echo $classe?>" width="360">
							<a href="<? echo $obj["exibir"]?>"><strong><? echo $obj["titulo"];?></strong></a><BR>
							<?
								//$loglist=$_page->LogManage->GetLogEditList($obj["cod_objeto"]);
							//	$count=0;
								//foreach ($loglist as $log)
								//{
								//	echo "<i>Usu�rio <B>".$log['user']. "</B> realizou a opera��o <strong>" . $log['op_name']."</strong> em <strong>". $log['logdate']."</strong></i><BR>";
								//}
							?>
						</td>
						<td class="<? echo $classe?>" valign="top" width="90">
							<? echo $obj["classe"];?>
						</td>
					</tr>
			<?
					}
				}
			?>
				</tr>
				<tr>
					<td width="100%" align="right" colspan="3">
						<hr size="2" class="pblLinha">
						<input class="pblBotaoForm" type="button" name="purge" value="Inverter Sele&ccedil;&atilde;o" onclick="javascript:toggle('listcontent')">&nbsp;
					</td>
				</tr>
				<tr>
					<td align="right" colspan="3">
						<input class="pblBotaoForm" type="submit" name="undelete" value="Apagar Selecionados em Definitivo">&nbsp;
					</td>
				</tr>
				
				</table>
				</div>
		</TD></TR>
		<TR><TD COLSPAN="2"><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>
		</TABLE>
		</DIV>
	</form>
