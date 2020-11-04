<?
global $_page, $cod_objeto, $bgCor, $tags,$perfil, $indicepai, $fim;
$ct==0;
$perfil = $_page->_usuario->cod_perfil;
$perfilDefault = _PERFIL_DEFAULT;
?>
<script>
function expandirArvore(codigo)
{
    pegaConteudoGET('/html/objects/montaMapa.php?cod=' + codigo,'filhos_' + codigo);
    document.getElementById('link_' + codigo).innerHTML = '<a href="#" onclick="recolherArvore(' + codigo + ');return false;"><img src="/html/imagens/icn_menos.jpg" border="0"></a>';

}
function recolherArvore(codigo)
{
    document.getElementById('filhos_' + codigo).innerHTML = '';
    document.getElementById('link_' + codigo).innerHTML = '<a href="#" onclick="expandirArvore(' + codigo + ');return false;"><img src="/html/imagens/icn_mais.jpg" border="0"></a>';

}
</script>
<@var $tags = #tags@>
<@var $titulo = #titulo@>
<!-- ========================================================= -->
<!-- == ( td que dividi entra o conteúdo e o menu interno ) == -->
<!-- === Título ( do tema da página ) === -->
<@incluir arquivo=["/html/template/inc_titulo.php"]@>
<!-- Final === Título ( do tema da página ) === -->
<!-- ================================== -->
<!-- === Conteúdo da página interna === -->
<!-- === Primeiro destaque da página === -->
<div class="paddingBottom15">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="paddingLeft10 paddingRight10">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top">
							<@se [#texto!='']@>
							<div class="terra paddingBottom10">
								<@= #texto@>
							</div>
							<@/se@>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
<!-- Final === Primeiro destaque da página === -->

<!-- === Mapa do Site === -->
<?
$areas[0]["cod"] = "73409";
$areas[0]["nome"] = "Plano de Ação";
$areas[0]["classes"] = "*";

$areas[1]["cod"] = "125";
$areas[1]["nome"] = "Áreas de Atuação";
$areas[1]["classes"] = "*";

$areas[2]["cod"] = "105";
$areas[2]["nome"] = "O MCT";
$areas[2]["classes"] = "*";

$areas[3]["cod"] = "67303";
$areas[3]["nome"] = "Agências";
$areas[3]["classes"] = "*";

$areas[4]["cod"] = "741";
$areas[4]["nome"] = "Unidades de Pesquisa";
$areas[4]["classes"] = "*";

$areas[5]["cod"] = "740";
$areas[5]["nome"] = "Indicadores";
$areas[5]["classes"] = "*";

$areas[6]["cod"] = "723";
$areas[6]["nome"] = "Legislação";
$areas[6]["classes"] = "*";

$areas[7]["cod"] = "724";
$areas[7]["nome"] = "Fontes de Financiamento";
$areas[7]["classes"] = "*";

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">';

for ($i=0; $i<count($areas); $i++)
{
    echo '<tr>';
    if ($i == (count($areas)-1))
    {
	$fundo = "/html/imagens/arv_bra.gif";
	echo '<td width="20" valign="top"><img src="/html/imagens/arv_top_dir.gif" align="absmiddle"></td>';
    }
    else
    {
	$fundo = "/html/imagens/arv_top_bai.gif";
	if ($i==0)
	{
	    echo '<td width="20" valign="top"><img src="/html/imagens/arv_dir_bai.gif" align="absmiddle"></td>';
	}
	else
	{
	    echo '<td width="20" valign="top"><img src="/html/imagens/arv_top_dir_bai.gif" align="absmiddle"></td>';
	}
    }
    if ($i == (count($areas)-1)) $ultimo = 1;
    else $ultimo = 0;
    echo '<td><b>&nbsp;<span id="link_'.$areas[$i]["cod"].'"><a href="#" onclick="expandirArvore('.$areas[$i]["cod"].');return false;"><img src="/html/imagens/icn_mais.jpg" border="0"></a></span></b>
	&nbsp;&nbsp;<a href="/index.php/content/view/'.$areas[$i]["cod"].'.html">'.$areas[$i]["nome"].'</a></td>';
    echo '</tr><tr><td style="background-image: url('.$fundo.'); background-repeat: repeat-y;"></td><td><span id="filhos_'.$areas[$i]["cod"].'"></span></td></tr>';
}
echo '</table>';
?>
<!-- Final === Mapa do Site === -->

<!-- Tabela Leia mais, topo e imprimir -->
<@incluir arquivo=["/html/template/inc_rodape.php"]@>
<!-- Final Tabela Leia mais, topo e imprimir -->
<!-- Final =================================================== -->
<!-- == ( td que dividi entra o conteúdo e o menu interno ) == -->