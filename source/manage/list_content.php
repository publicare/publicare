<?
global $_page;

$sql = "select count(cod_objeto) as total from objeto where apagado=0 and cod_pai=".$cod_objeto;
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
	<style>
	trMouseAction1:hover {
			background: #fff;
	}
	
	</style>
<?
	$_page->_objeto->PegaListaDeFilhos($_page, '*', $ordf, $inicio, $tam);
	$inicio++;
?>
	<form action="/index.php/do/list_content_post.php/<?=$_page->_objeto->Valor($_page, "cod_objeto")?>.html" name="listcontent" id="listcontent" method="post">
		<input type="hidden" name="return_obj" value="<? echo $_page->_objeto->Valor($_page, "cod_objeto")?>">
		<? //BoxPublicareTop('listar','exibir,pai,voltar');?>
		<div class="pblAlinhamentoTabelas">
		
		<div id="divGuiaA" style="height: 0%; visibility: show;">
		<TABLE width="570" border="0" cellpadding=0 cellspacing=8 class="pblTabelaGeral">
		<tr id="trGravarTop1">
			<td class="pblTextoForm" colspan=3 align="right">
				<BR>&nbsp;
				<input class="pblBotaoForm" type="button" name="purge" value="Inverter Sele&ccedil;&atilde;o" onclick="javascript:toggle('listcontent');" style="background: brown;">				
		<?php
			 if ($_SESSION['usuario']['perfil'] <= _PERFIL_EDITOR)
			  { 
			  $tmpBotaoPublicar = true;
		?>
			<input class="pblBotaoForm" type="submit" name="publicar" value="Publicar itens" onclick="trGravarTop2.style.display='';trGravarTop1.style.display='none';" style="background: #EEFFEE;">
			<input class="pblBotaoForm" type="submit" name="despublicar" value="Despublicar itens" onclick="trGravarTop2.style.display='';trGravarTop1.style.display='none';" style="background: #FFEE00;">
			<?php 
			}
			elseif ($_SESSION['usuario']['perfil'] == _PERFIL_AUTOR)
			{ 
			$tmpBotaoSolicitar = true;
			?>
			<input class="pblBotaoForm" type="submit" name="solicitar" value="Solicitar itens" onclick="trGravarTop2.style.display='';trGravarTop1.style.display='none';" style="background: #FFEEFF;">
			<?php
			 }  
			?>
			<BR><BR>
				&nbsp;&nbsp;<input type="submit" class="pblBotaoForm" name="delete" value="Apagar itens"  onclick="trGravarTop2.style.display='';trGravarTop1.style.display='none';">
				&nbsp;&nbsp;<input type="submit" class="pblBotaoForm" name="duplicate" value="Duplicar itens" onclick="trGravarTop2.style.display='';trGravarTop1.style.display='none';">
				&nbsp;&nbsp;<input class="pblBotaoForm" type="submit" name="copy" value="Copiar para a pilha" onclick="trGravarTop2.style.display='';trGravarTop1.style.display='none';">
				
			</TD>
		</tr>
		<tr id="trGravarTop2" style="display:none" height="60px">
			<td class="pblTextoForm" colspan=3 align="right">
			Processando informa&ccedil;&otilde;es .... aguarde....
			</td>
		</tr>
	<td height="1px" colspan="3">
		<hr size="3px" width="100%" color="#FA9C00">
	</td>
			<TR>
				<TD width="450">
					<img border=0 src="/html/imagens/portalimages/peca3.gif" ALT="" align="left"><font class="pblTituloBox">Listar conte&uacute;do</font><br>
				</TD>
				<TD width="120" class="pblAlinhamentoBotoes">
					<a class="ABranco" href="/index.php/content/view/<? echo $_page->_objeto->Valor($_page, "cod_objeto")?>.html"><img border=0 src="/html/imagens/portalimages/exibir.png" ALT="Exibir Objeto" hspace="2"></a>
				<?
					if ($_page->_objeto->Valor($_page, "cod_objeto")!=_ROOT) {
				?>
				
					<a class="ABranco" href="/index.php/do/list_content/<? echo $_page->_objeto->Valor($_page, "cod_pai")?>.html?tam=<?=$tam?>&pag=1&ord1=<?=$ord1?>&ord2=<?=$ord2?>"><img border=0 src="/html/imagens/portalimages/parent.gif" ALT="Listar Conte&uacute;do do Pai"></a>
				<?
					}
				?>
					
					<a href="#" onclick="history.back()"><img border=0 src="/html/imagens/portalimages/voltar2.gif" ALT="Voltar" hspace="2"></a>
				</TD>
			</TR>

			<TR>
			<TD COLSPAN="3">
				<table width="100%">
				<tr>
					<td class="pblTextoForm" width="100">
						<strong>Objeto Atual</strong></td>
					<td class="pblTextoForm" align="center"><b>Ordem</b>: <select id="ordem1" name="ordem1" class="pblSelectForm">
					<option value="data_publicacao" <?if ($ord1=="data_publicacao") echo "selected"?>>Data Publica&ccedil;&atilde;o</option>
					<option value="peso" <?if ($ord1=="peso") echo "selected"?>>Peso</option>
					<option value="titulo" <?if ($ord1=="titulo") echo "selected"?>>T&iacute;tulo</option>
					</select>
					<select id="ordem2" name="ordem2" class="pblSelectForm">
					<option value="asc"  <?if ($ord2=="asc") echo "selected"?>>Ascendente</option>
					<option value="desc"  <?if ($ord2=="desc") echo "selected"?>>Descendente</option>
					</select>
					<input type="button" class="pblBotaoForm" value="Ok" onclick="enviarOrdenacao()">
					<br>
					<b>N&uacute;mero de resultados:</b>  
					<select id="tam" name="tam" class="pblSelectForm">
					<option value="20" <?if ($tam==20) echo "selected"?>>20</option>
					<option value="50" <?if ($tam==50) echo "selected"?>>50</option>
					<option value="100" <?if ($tam==100) echo "selected"?>>100</option>
					<option value="200" <?if ($tam==200) echo "selected"?>>200</option>
					<option value="500" <?if ($tam==500) echo "selected"?>>500</option>					
					</select>
					<input type="hidden" name="cc_pag" id="cc_pag" value="<?=$pag?>">
					<input type="hidden" name="cc_cod" id="cc_cod" value="<?=$cod_objeto?>">
					<script language="javascript">
					function enviarOrdenacao()
					{
						var ord1 = document.getElementById("ordem1").value;
						var ord2 = document.getElementById("ordem2").value;
						var cod_obj = document.getElementById("cc_cod").value;
						var pag = document.getElementById("cc_pag").value;
						var tam = document.getElementById("tam").value;
						var url = "/index.php/do/list_content/" + cod_obj + ".html?tam=" + tam + "&pag=" + pag + "&ord1=" + ord1 + "&ord2=" + ord2;
						document.location.href = url;
					}
					</script>
					</td>
				</tr>
				<tr>
				<td colspan="2" class="pblTextoForm"><font color="Black"><? echo $_page->_objeto->Valor($_page, "titulo")?></font></td>
				</tr>
				</table>
				</TD>
			</TR>

			<TR><TD colspan="3">
			<center><font color="Black"><b><?=$total?></b> Registros encontrados. Listando de <b><?=$inicio?></b> a <b><?=$fim?></b>.</font></center>
				<table border="0" width="530">
				<tr>
				<td class="pblTextoForm">
						<strong>#</strong></td>
					<td class="pblTextoForm" width="40">
						<strong>Itens</strong></td>
					<td class="pblTextoForm" width="380">
						<strong>T&iacute;tulo</strong></td>
					<td class="pblTextoForm" width="50">
						<strong>Classe</strong></td>
					<td class="pblTextoForm" width="" align="center">
						<strong>Peso</strong></td>
					<td width="25" class="pblTextoForm" colspan="3" align="center" nowrap><strong> Op&ccedil;&otilde;es </strong></td>
				</tr>
				<?
				    $cont = $inicio;
					for ($i=0; $i<$_page->_objeto->quantidade; $i++)
					{
						$obj = $_page->_objeto->filhos[$i];
						if ($cont%2!=0)
							$classe="pblTextoLogImpar";
						else
							$classe="pblTextoLogPar";
				?>

				<tr class="<?=$classe?>">
					<td align="right">
						<strong><?=$cont?>. </strong></td>
					<td width=40 align="center">
						<? 
							if ((($_SESSION['usuario']['perfil']==_PERFIL_AUTOR) && ($obj->Valor($_page, "cod_usuario")==$_SESSION['usuario']['cod_usuario'])) || ($_SESSION['usuario']['perfil']<=_PERFIL_EDITOR))
							{
						?>		
							<input type="checkbox" id="objlist[]" name="objlist[]" value="<? echo $obj->Valor($_page, "cod_objeto")?>">
						<?
							$tmpPodeEditar = true;
							}
							else 
							{
							$tmpPodeEditar = false;
						?>
							&nbsp;
						<? }?>
					</td>
					<?php
					$cont++;
					if ($obj->Valor($_page, "cod_status")==_STATUS_PUBLICADO)
					{
						$SL_TITULO = $obj->Valor($_page, "titulo");
						$SL_CLASSE = $obj->Valor($_page, "classe");
						$SL_PESO = $obj->Valor($_page, "peso");
						if ($_SESSION['usuario']['perfil']<=_PERFIL_AUTOR)
							$ICN_EDIT = "<a href=\"/index.php/manage/edit/".$obj->Valor($_page, "cod_objeto").".html\"><img src=\"/html/imagens/portalimages/icone_editar.gif\" border=\"0\"  alt=\"Editar Objeto\"></a>";
						else
							$ICN_EDIT = "";
					}
					elseif ($obj->Valor($_page, "cod_status")==_STATUS_SUBMETIDO)
					{
						$SL_CLASSE = "<span style=\"color:blue;\">".$obj->Valor($_page, "classe")."</span>";
						$SL_TITULO = "<span style=\"color:blue;\">".$obj->Valor($_page, "titulo")."</span>";
						$SL_PESO = $obj->Valor($_page, "peso");
						if (($obj->Valor($_page, "cod_usuario")==$_SESSION['usuario']['cod_usuario']) || ($_SESSION['usuario']['perfil']<_PERFIL_AUTOR))
							$ICN_EDIT = "<a href=\"/index.php/manage/edit/".$obj->Valor($_page, "cod_objeto").".html\"><img src=\"/html/imagens/portalimages/icone_editar.gif\" border=\"0\"  alt=\"Editar Objeto\"></a>";
						else
							$ICN_EDIT = "";
					}
					else 
					{
//						echo "AQUI";
						$SL_CLASSE = "<span class=\"pblObrigatorio\">".$obj->Valor($_page, "classe")."</span>";
						$SL_TITULO = "<span class=\"pblObrigatorio\">".$obj->Valor($_page, "titulo")."</span>";
						$SL_PESO = $obj->Valor($_page, "peso");
						if (($obj->Valor($_page, "cod_usuario")==$_SESSION['usuario']['cod_usuario']) || ($_SESSION['usuario']['perfil']<_PERFIL_AUTOR))
							$ICN_EDIT = "<a href=\"/index.php/manage/edit/".$obj->Valor($_page, "cod_objeto").".html\"><img src=\"/html/imagens/portalimages/icone_editar.gif\" border=\"0\"  alt=\"Editar Objeto\"></a>";
						else
							$ICN_EDIT = "";
					}
					
					?>
					<td width="380">
						<? echo $SL_TITULO; ?></td>
					<td width="50">
						<? echo $SL_CLASSE; ?></td>
					<td width="" align="center">
						<? echo $SL_PESO; ?></td>
					<td align="center">
					<?php
						echo $ICN_EDIT;
					?>
					</td>	
					<td>
						<a  href="<? echo $obj->Valor($_page, "url")?>"><img src="/html/imagens/portalimages/icone_exibir.gif" border="0"  alt="Exibir Objeto"></a></td>
					<td width="25">
						<? if ($obj->PodeTerFilhos()) {?>
							<a  href="/index.php/do/list_content/<? echo $obj->Valor($_page, "cod_objeto")?>.html?tam=<?=$tam?>&pag=1&ord1=<?=$ord1?>&ord2=<?=$ord2?>"><img src="/html/imagens/portalimages/icone_listar.gif" border="0" alt="Lista Conte&uacute;do"></a></td>
						<? } else { echo "&nbsp;</td>";}?>
					
				</tr>	
				<?
					}
				?>
				
				</table>
				<center><font color="Black">
				<?
				if ($pag > 1)
				{
				?>
				<a href="/index.php/do/list_content/<?=$cod_objeto?>.html?tam=<?=$tam?>&pag=1&ord1=<?=$ord1?>&ord2=<?=$ord2?>"><b>|primeira|</b></a> <a href="/index.php/do/list_content/<?=$cod_objeto?>.html?tam=<?=$tam?>&pag=<?=($pag-1)?>&ord1=<?=$ord1?>&ord2=<?=$ord2?>"><b>|anterior|</b></a>
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
					else echo " <a href='/index.php/do/list_content/".$cod_objeto.".html?tam=".$tam."&pag=".$i."&ord1=".$ord1."&ord2=".$ord2."'>".$i."</a> ";
					if ($i == $max && $i<$num_pags) echo " ... ";
				}
				if ($pag < $num_pags)
				{
				?>
				<a href="/index.php/do/list_content/<?=$cod_objeto?>.html?tam=<?=$tam?>&pag=<?=($pag+1)?>&ord1=<?=$ord1?>&ord2=<?=$ord2?>"><b>|pr&oacute;xima|</b></a> <a href="/index.php/do/list_content/<?=$cod_objeto?>.html?tam=<?=$tam?>&pag=<?=$num_pags?>&ord1=<?=$ord1?>&ord2=<?=$ord2?>"><b>|&uacute;ltima|</b></a>
				<?
				} else {				
				?>
				|pr&oacute;xima| |&uacute;ltima|
				<?				
				}
				?></font></center>
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
