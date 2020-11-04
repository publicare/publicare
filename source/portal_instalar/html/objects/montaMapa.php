<?php
include_once ("../../../publicare.conf");
include_once ("iniciar.php");

$cod	    = $_GET["cod"];
$classes    = '*';

//    echo "cod: $cod - classes: $classes - nivel: $nivel<br>";

// Localiza os objetos conforme array informado acima
$objetos = $_page->_adminobjeto->LocalizarObjetos($_page, $classes, '', 'peso,titulo', -1, -1, $cod, 0);
$total = count($objetos);
$cont = 1;
if ($ultimo == 1) $figura = "arv_bra.gif";
else $figura = "arv_top_bai.gif";
$figura = "arv_top_bai.gif";

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">';

foreach ($objetos as $obj)
{
    echo '<tr>';

    $num_filhos = $_page->_adminobjeto->PegaNumFilhos($_page, $obj->metadados["cod_objeto"]);

    if ($cont == $total)
    {
	$fundo = "/html/imagens/arv_bra.gif";
	echo '<td width="20" valign="top"><img src="/html/imagens/arv_top_dir.gif" align="absmiddle"></td>';
    }
    else
    {
	$fundo = "/html/imagens/arv_top_bai.gif";
        echo '<td width="20" valign="top" style="background-image: url('.$fundo.'); background-repeat: repeat-y;"><img src="/html/imagens/arv_top_dir_bai.gif" align="absmiddle"></td>';
    }
    echo '<td>';
    if ($num_filhos > 0) echo '<b>&nbsp;<span id="link_'.$obj->metadados["cod_objeto"].'"><a href="#" onclick="expandirArvore('.$obj->metadados["cod_objeto"].');return false;"><img src="/html/imagens/icn_mais.jpg" border="0"></a></span></b>';
    echo '&nbsp;&nbsp;<a href='.$obj->metadados["url"].'>'.$obj->metadados["titulo"].'</a></td>';
    echo '</tr><tr><td style="background-image: url('.$fundo.'); background-repeat: repeat-y;"></td><td><span id="filhos_'.$obj->metadados["cod_objeto"].'"></span></td></tr>';
	
    $cont++;
}

echo '</table>';
exit();
?>
