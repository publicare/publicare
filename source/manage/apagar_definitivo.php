<?
global $_page;

$sql = "select count(cod_objeto) as total from objeto where apagado=1";
$rs = $_page->_db->ExecSQL($sql);
$total = $rs->fields["total"];

$tam = intval((isset($_GET['tam'])?$_GET['tam']:'20'));
$pag = intval((isset($_GET['pag'])?$_GET['pag']:'1'));
$inicio = ($pag>1)?(($tam*($pag-1))):0;
$fim = $inicio + $tam;
if ($fim > $total) $fim = $total;

$num_pags = intval($total/$tam);
if ($total%$tam>0) $num_pags++;

$max = $pag + 4;
$min = $pag - 4;
if ($min<1) $min = 1;
if ($max>$num_pags) $max = $num_pags;
if (($max-$min) < 8) $max = $max + (8-($max-$min));
if ($max > $num_pags) $max = $num_pags;

$ord1 = isset($_GET["ord1"])?$_GET["ord1"]:"titulo";
$ord2 = isset($_GET["ord2"])?$_GET["ord2"]:"asc";
if ($ord2=="asc") $ordf = $ord1;
else $ordf = "-".$ord1;
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
					<td class="pblTituloLog" width="80">
						Classe
					</td>
                                        <td class="pblTituloLog" width="10">
                                                Data da exclusão
                                        </td>
				</tr>
<?
	$deletedlist=$_page->_administracao->PegaListaDeApagados($_page, $inicio, $tam);
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
								//	echo "<i>Usuï¿½rio <B>".$log['user']. "</B> realizou a operaï¿½ï¿½o <strong>" . $log['op_name']."</strong> em <strong>". $log['logdate']."</strong></i><BR>";
								//}
							?>
						</td>
						<td class="<? echo $classe?>" valign="top" width="80">
							<? echo $obj["classe"];?>
						</td>
                                                <td class="<? echo $classe?>" valign="top" width="10">
                                                        <? echo ConverteData($obj["data_exclusao"], 5);?>
                                                </td>
					</tr>
			<?
					}
				}
			?>
				</tr>
				<tr>
					<td width="100%" align="right" colspan="4">
						<hr size="2" class="pblLinha">
						<input class="pblBotaoForm" type="button" name="purge" value="Inverter Sele&ccedil;&atilde;o" onclick="javascript:toggle('listcontent')">&nbsp;
					</td>
				</tr>
				<tr>
					<td align="right" colspan="4">
						<input class="pblBotaoForm" type="submit" name="undelete" value="Apagar Selecionados em Definitivo">&nbsp;
					</td>
				</tr>
				
				</table>
                                <br>
                                <center><font color="Black">
                                <?
                                if ($pag > 1)
                                {
                                ?>
                                <a href="/index.php/do/apagar_definitivo/<?=$cod_objeto?>.html?tam=<?=$tam?>&pag=1"><b>|primeira|</b></a> <a href="/index.php/do/apagar_definitivo/<?=$cod_objeto?>.html?tam=<?=$tam?>&pag=<?=($pag-1)?>"><b>|anterior|</b></a>
                                <?
                                } else {
                                ?>
                                |primeira| |anterior|
                                <?
                                }
                                for ($i=$min; $i<=$max; $i++)
                                {
                                        if ($i == $min && $i>1) echo " ... ";
                                        if ($pag==$i) echo " <font color='Red'><b>".$i."</b></font> ";
                                        else echo " <a href='/index.php/do/apagar_definitivo/".$cod_objeto.".html?tam=".$tam."&pag=".$i."'>".$i."</a> ";
                                        if ($i == $max && $i<$num_pags) echo " ... ";
                                }
                                if ($pag < $num_pags)
                                {
                                ?>
                                <a href="/index.php/do/apagar_definitivo/<?=$cod_objeto?>.html?tam=<?=$tam?>&pag=<?=($pag+1)?>"><b>|pr&oacute;xima|</b></a> <a href="/index.php/do/apagar_definitivo/<?=$cod_objeto?>.html?tam=<?=$tam?>&pag=<?=$num_pags?>"><b>|&uacute;ltima|</b></a>
                                <?
                                } else {
                                ?>
                                |pr&oacute;xima| |&uacute;ltima|
                                <?
                                }
                                ?></font></center>
				</div>
		</TD></TR>
		<TR><TD COLSPAN="2"><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>
		</TABLE>
		</DIV>
	</form>
