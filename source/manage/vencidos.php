<?php
global $_page, $cod_objeto;

$sql = "SELECT count(t1.cod_objeto) as total  
from objeto t1 
inner join classe t2 on t2.cod_classe=t1.cod_classe 
inner join parentesco t3 on t1.cod_objeto=t3.cod_objeto
where t3.cod_pai=".$cod_objeto." 
and t1.data_validade < ".date("Ymd")."000000 
and t1.apagado=0";
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
<form action="/index.php/do/vencidos_post.php/<?=$_page->_objeto->Valor($_page, "cod_objeto")?>.html" name="listcontent" id="listcontent" method="POST">
		<input type="hidden" name="return_obj" value="<?php echo $_page->_objeto->Valor($_page, "cod_objeto")?>">
		<? //BoxPublicareTop('listar','exibir,pai,voltar');?>
		<div class="pblAlinhamentoTabelas">
		
		<div id="divGuiaA" style="height: 0%; visibility: show;">
		<TABLE width="570" border="0" cellpadding=0 cellspacing=8 class="pblTabelaGeral">
		<tr id="trGravarTop1">
			<td class="pblTextoForm" colspan=3 align="right">
			<input class="pblBotaoForm" type="button" name="purge" value="Inverter Sele&ccedil;&atilde;o" onclick="javascript:toggle('listcontent')">&nbsp;
		<input class="pblBotaoForm" type="submit" name="undelete" value="Apagar Selecionados em Definitivo" onclick="trGravarTop2.style.display='';trGravarTop1.style.display='none';">&nbsp;
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
					<img border=0 src="/html/imagens/portalimages/peca3.gif" ALT="" align="left"><font class="pblTituloBox">Objeto Vencidos</font><br>
				</TD>
				<TD width="120" class="pblAlinhamentoBotoes">
					<a class="ABranco" href="/index.php/content/view/<?php echo $_page->_objeto->Valor($_page, "cod_objeto")?>.html"><img border=0 src="/html/imagens/portalimages/exibir.png" ALT="Exibir Objeto" hspace="2"></a>
				<?php
					if ($_page->_objeto->Valor($_page, "cod_objeto")!=_ROOT) {
				?>
				
					<a class="ABranco" href="/index.php/do/vencidos/<? echo $_page->_objeto->Valor($_page, "cod_pai")?>.html"><img border=0 src="/html/imagens/portalimages/parent.gif" ALT="Listar Conte&uacute;do do Pai"></a>
				<?php
					}
				?>
					
					<a href="#" onclick="history.back()"><img border=0 src="/html/imagens/portalimages/voltar2.gif" ALT="Voltar" hspace="2"></a>
				</TD>
			</TR>

			<TR>
			<TD COLSPAN="3">
<?php
if ($total>0)
{
?>
			<font class="pblObrigatorio">ATEN&Ccedil;&Atilde;O: Objeto deletados aqui n&atilde;o poder&atilde;o ser recuperados!</font>
			</TD>
			</TR>

			<TR><TD colspan="3">
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
						var url = "/index.php/do/vencidos/" + cod_obj + ".html?pag=" + pag + "&ord1=" + ord1 + "&ord2=" + ord2;
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
					<td width="25" class="pblTextoForm" align="center" nowrap><strong>Validade</strong></td>
					<td class="pblTextoForm" width="14"><strong>Editar</strong></td>
				</tr>
				<?php
				$arrListaObjetoVencidos = $_page->_administracao->PegaListaDeVencidos($_page, $ord1, $ord2, $inicio, $tam, $cod_objeto);
				$cont = $inicio;
				foreach ($arrListaObjetoVencidos as $ListaChave => $ListaTexto)
				{
					$show = true;
					if ($_SESSION['usuario']['perfil']==_PERFIL_AUTOR || $_SESSION['usuario']['perfil']==_PERFIL_RESTRITO)
					{
						if ($obj['cod_usuario']==$_SESSION['usuario']['cod_usuario'])
							$show=true;
						else
							$show=false;
					}
					
					$cont++;
					if ($cont%2!=0)
						$classe="pblTextoLogImpar";
					else
						$classe="pblTextoLogPar";
				?>

				<tr class="<?=$classe?>">
					<td align="right">
						<?=$cont?>. 	
					</td>
					<td align="center">
					<? if ($show){ ?>
							<input type="checkbox" id="objlist[]" name="objlist[]" value="<?=$ListaTexto['cod_objeto']?>">
					<? } ?>
					</td>
					<td><?=$ListaTexto['titulo']?></td>
					<td align="center"><?=ConverteData($ListaTexto['data_validade'],5)?>&nbsp;</td>
					<td align="center"><? if ($show){ ?><a href="/index.php/manage/edit/<?=$ListaTexto['cod_objeto']?>.html"><img src="/html/imagens/portalimages/icone_editar.gif" border="0" alt="Editar Objeto"></a><? } ?></td>
				</tr>
				<?php
				}
				?>
				
				</table>
<center><font color="Black">
				<?php
				if ($pag > 1)
				{
				?>
				<a href="/index.php/do/vencidos/<?=$cod_objeto?>.html?pag=1&ord1=<?=$ord1?>&ord2=<?=$ord2?>"><b>|primeira|</b></a> <a href="/index.php/do/vencidos/<?=$cod_objeto?>.html?pag=<?=($pag-1)?>&ord1=<?=$ord1?>&ord2=<?=$ord2?>"><b>|anterior|</b></a>
				<?php
				} else {				
				?>
				|primeira| |anterior|
				<?php
				}
				for ($i=$min; $i<=$max; $i++)
				{
					if ($i == $min && $i>1) echo " ... ";
					if ($pag==$i) echo " <font color='Red'><b>".$i."</b></font> ";
					else echo " <a href='/index.php/do/vencidos/".$cod_objeto.".html?pag=".$i."&ord1=".$ord1."&ord2=".$ord2."'>".$i."</a> ";
					if ($i == $max && $i<$num_pags) echo " ... ";
				}
				if ($pag < $num_pags)
				{
				?>
				<a href="/index.php/do/vencidos/<?=$cod_objeto?>.html?pag=<?=($pag+1)?>&ord1=<?=$ord1?>&ord2=<?=$ord2?>"><b>|pr&oacute;xima|</b></a> <a href="/index.php/do/vencidos/<?=$cod_objeto?>.html?pag=<?=$num_pags?>&ord1=<?=$ord1?>&ord2=<?=$ord2?>"><b>|&uacute;ltima|</b></a>
				<?php
				} else {				
				?>
				|pr&oacute;xima| |&uacute;ltima|
				<?php				
				}
				?></font></center>
<?php
}
else
{
	echo "<br><br><br><center><b><font size='3' color='black'>N&atilde;o existem &iacute;tens vencidos, a partir deste objeto.</font></b></center><br><br><br>";
}
?>
			<TR><TD COLSPAN="2"><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>
			</TABLE>
			</div>
			<? //BoxPublicareBottom()?>
	</form>
<?php
	echo "<div id=\"divGuiaB\" style=\"height: 0%; visibility: hidden;\">";
	include ("pilha.php");
	echo "</div>";
?>
