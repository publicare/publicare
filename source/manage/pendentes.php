<?
global $_page, $cod_objeto;

$sql = "SELECT count(t2.cod_objeto) as total  
from pendencia t1 
inner join objeto t2 on t1.cod_objeto=t2.cod_objeto 
inner join parentesco t3 on t1.cod_objeto=t3.cod_objeto 
where t3.cod_pai=".$cod_objeto." 
and t2.apagado=0"; 
$rs = $_page->_db->ExecSQL($sql);

$total = $rs->fields["total"];

$tam = 20;
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

$ord1 = isset($_GET["ord1"])?$_GET["ord1"]:"peso";
$ord2 = isset($_GET["ord2"])?$_GET["ord2"]:"asc";
if ($ord2=="asc") $ordf = $ord1;
else $ordf = "-".$ord1;
?>
<style>
trMouseAction1:hover {
		background: #fff;
}

</style>
<form action="/index.php/do/list_content_post.php/<?=$_page->_objeto->Valor($_page, "cod_objeto")?>.html" name="pendentes" id="pendentes" method="POST">
		<input type="hidden" name="return_obj" value="<? echo $_page->_objeto->Valor($_page, "cod_objeto")?>">
		<div class="pblAlinhamentoTabelas">
		<div id="divGuiaA" style="height: 0%; visibility: show;">
		<TABLE width="570" border="0" cellpadding=0 cellspacing=8 class="pblTabelaGeral">
		<tr id="trGravarTop1">
			<td class="pblTextoForm" colspan=3 align="right">
			<input class="pblBotaoForm" type="button" name="purge" value="Inverter Seleção" onclick="javascript:toggle('listcontent')">&nbsp;
		<input class="pblBotaoForm" type="submit" name="publicar_pendentes" value="Publicar Objeto" onclick="trGravarTop2.style.display='';trGravarTop1.style.display='none';">&nbsp;
			</TD>
		</tr>
		<tr id="trGravarTop2" style="display:none" height="30px">
			<td class="pblTextoForm" colspan=3 align="right">
			Processando informa&ccedil;&otilde;es .... aguarde....
			</td>
		</tr>
	<td height="1px" colspan="3">
		<hr size="3px" width="100%" color="#FA9C00">
	</td>
			<TR>
				<TD width="450">
					<img border=0 src="/html/imagens/portalimages/peca3.gif" ALT="" align="left"><font class="pblTituloBox">Objetos aguardando aprova&ccedil;&atilde;o</font><br>
				</TD>
				<TD width="120" class="pblAlinhamentoBotoes">
					<a class="ABranco" href="/index.php/content/view/<? echo $_page->_objeto->Valor($_page, "cod_objeto")?>.html"><img border=0 src="/html/imagens/portalimages/exibir.png" ALT="Exibir Objeto" hspace="2"></a>
				<?
					if ($_page->_objeto->Valor($_page, "cod_objeto")!=_ROOT) {
				?>
				
					<a class="ABranco" href="/index.php/do/pendentes/<? echo $_page->_objeto->Valor($_page, "cod_pai")?>.html"><img border=0 src="/html/imagens/portalimages/parent.gif" ALT="Listar Conte&uacute;do do Pai"></a>
				<?
					}
				?>
					
					<a href="#" onclick="history.back()"><img border=0 src="/html/imagens/portalimages/voltar2.gif" ALT="Voltar" hspace="2"></a>
				</TD>
			</TR>

			<TR><TD colspan="3">
<?
if ($total>0){		
?>	
<b>Ordem</b>: <select id="ordem1" name="ordem1" class="pblSelectForm">
					<option value="data_publicacao" <?if ($ord1=="data_publicacao") echo "selected"?>>Data Publica&ccedil;&atilde;o</option>
					<option value="peso" <?if ($ord1=="peso") echo "selected"?>>Peso</option>
					<option value="titulo" <?if ($ord1=="titulo") echo "selected"?>>T&iacute;tulo</option>
					</select>
					<select id="ordem2" name="ordem2" class="pblSelectForm">
					<option value="asc"  <?if ($ord2=="asc") echo "selected"?>>Ascendente</option>
					<option value="desc"  <?if ($ord2=="desc") echo "selected"?>>Descendente</option>
					</select>
					<input type="button" class="pblBotaoForm" value="Ok" onclick="enviarOrdenacao()">
					<input type="hidden" name="cc_pag" id="cc_pag" value="<?=$pag?>">
					<input type="hidden" name="cc_cod" id="cc_cod" value="<?=$cod_objeto?>">
					<script language="javascript">
					function enviarOrdenacao()
					{
						var ord1 = document.getElementById("ordem1").value;
						var ord2 = document.getElementById("ordem2").value;
						var cod_obj = document.getElementById("cc_cod").value;
						var pag = document.getElementById("cc_pag").value;
						var url = "/index.php/do/pendentes/" + cod_obj + ".html?pag=" + pag + "&ord1=" + ord1 + "&ord2=" + ord2;
						document.location.href = url;
					}
					</script>
			<center><font color="Black"><b><?=$total?></b> Registros encontrados. Listando de <b><?=($inicio+1)?></b> a <b><?=$fim?></b>.</font></center>
				<table border="0" width="550" cellpadding="1" cellspacing="1">
				<tr>
					<td class="pblTextoForm" width="30" align="right">
						<strong>#</strong></td>
					<td class="pblTextoForm" width="30">
						<strong>&Iacute;tens</strong></td>
					<td class="pblTextoForm">
						<strong>T&iacute;tulo</strong></td>
					<td width="55" class="pblTextoForm" align="center" nowrap colspan="3"><strong>Op&ccedil;&otilde;es</strong></td>
				</tr>
				
<?
	$objetos = $_page->_adminobjeto->LocalizarPendentes($_page, $cod_objeto, $_SESSION["usuario"]["cod_usuario"], $ord1, $ord2, $inicio, $tam);
	$cont = $inicio;
	foreach ($objetos as $obj)
	{
		$show = true;
		if ($_SESSION['usuario']['perfil']==_PERFIL_AUTOR || $_SESSION['usuario']['perfil']==_PERFIL_RESTRITO)
		{
			if ($obj['cod_usuario']==$_SESSION['usuario']['cod_usuario'])
				$show=true;
			else
				$show=false;
		}
		if ($cont%2!=0)
			$classe="pblTextoLogImpar";
		else
			$classe="pblTextoLogPar";
		$cont++;
		$loglist=$_page->_log->PegaLogWorkflow($_page, $obj["cod_objeto"]);
?>


				<tr class="<?=$classe?>">
					<td align="right">
						<?=$cont?>. 	
					</td>
					<td align="center">
					<? if ($show){ ?>
							<input type="checkbox" id="objlist[]" name="objlist[]" value="<?=$obj["cod_objeto"]?>">
					<? } ?>
					</td>
					<td><?=$obj["titulo"]?></td>
					<td align="center"><? if ($show){ ?><a href="/index.php/manage/edit/<?=$obj["cod_objeto"]?>.html"><img src="/html/imagens/portalimages/icone_editar.gif" border="0" title="Editar Objeto" alt="Editar Objeto"></a><? } ?></td>
					<td><a href="/index.php/content/view/<?=$obj['cod_objeto']?>.html"><img src="/html/imagens/portalimages/icone_exibir.gif" border="0" title="Exibir Objeto" alt="Exibir Objeto"></a></td>
					<td><a href="JavaScript:JSMostraeOculta(idHistorico<?=$ContagemdeItens?>x);"><img src="/html/imagens/portalimages/icn_down.jpg" border="0" title="Ver Histórico" alt="Ver Histórico"></a></td>
				</tr>
		<tr>
			<td colspan="6">
		<table class="pblTabelaGeral" id="idHistorico<?=$ContagemdeItens?>x" style="display:none;" width="100%">
		<tr>
			<td width="5">&nbsp;</td>
			<td class="pblTextoLog">
				<strong>Usu&aacute;rio</strong></td>
			<td class="pblTextoLog">
				<strong>Opera&ccedil;&atilde;o</strong></td>
			<td class="pblTextoLog" colspan="2">
				<strong>Data / Mensagem arquivada</strong></td>
		</tr>
				<?
			$count=0;
			foreach($loglist as $log)
			{
				if ($count++%2)
					$class="pblTextoLogImpar";
				else
					$class="pblTextoLogPar";
				echo '<tr>';
				echo '<td colspan="2" class="'.$class.'">';
				echo $log['usuario'];
				echo '</td>'."\n";
				echo '<td class="'.$class.'">';
				echo $log['status'];
				echo '</td>'."\n";
				echo '<td colspan="2" class="'.$class.'">';
				echo $log['estampa']."<br>".$log['mensagem'];
				echo '</tr>'."\n\n";
			}
			echo "</table>";
			echo "</td></tr>";
				
					}
				$ContagemdeItens++;
?>
</table>
<center><font color="Black">
				<?
				if ($pag > 1)
				{
				?>
				<a href="/index.php/do/pendentes/<?=$cod_objeto?>.html?pag=1&ord1=<?=$ord1?>&ord2=<?=$ord2?>"><b>|primeira|</b></a> <a href="/index.php/do/pendentes/<?=$cod_objeto?>.html?pag=<?=($pag-1)?>&ord1=<?=$ord1?>&ord2=<?=$ord2?>"><b>|anterior|</b></a>
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
					else echo " <a href='/index.php/do/pendentes/".$cod_objeto.".html?pag=".$i."&ord1=".$ord1."&ord2=".$ord2."'>".$i."</a> ";
					if ($i == $max && $i<$num_pags) echo " ... ";
				}
				if ($pag < $num_pags)
				{
				?>
				<a href="/index.php/do/pendentes/<?=$cod_objeto?>.html?pag=<?=($pag+1)?>&ord1=<?=$ord1?>&ord2=<?=$ord2?>"><b>|pr&oacute;xima|</b></a> <a href="/index.php/do/pendentes/<?=$cod_objeto?>.html?pag=<?=$num_pags?>&ord1=<?=$ord1?>&ord2=<?=$ord2?>"><b>|&uacute;ltima|</b></a>
				<?
				} else {				
				?>
				|pr&oacute;xima| |&uacute;ltima|
				<?				
				}
				?></font></center>
<?
}
else
{
	echo "<br><br><br><center><b><font size='3' color='black'>N&atilde;o existem &iacute;tens para aprova&ccedil;&atilde;o, a partir deste objeto.</font></b></center><br><br><br>";
}
?>
			<TR><TD COLSPAN="2"><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>
			</TABLE>
			</div>
	</form>
