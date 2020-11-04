<?
global $_page;

header("Content-Type: text/html; charset=ISO-8859-1",true);

$menu = $_page->_usuario->Menu($_page);
$cont = 0;

echo "<ul>
";

foreach ($menu as $item)
{
	if (!$item['script'] || $item['script'] == "")
	{
		$cont++;
		echo "<li class='titulo".$cont."'>".$item['acao']."</li>
		";
	}
	else
	{
		echo "<li><a href='/index.php".$item['script']."/".$_page->_objeto->Valor($_page, 'cod_objeto').".html'>
				<img src='/html/imagens/menu/menu_lateral/icn_".$item['ordem'].".gif'>".$item['acao']."</a></li>
				";
	}
}

echo "</ul>";

/*
foreach ($menu as $item)
{
	if (!$item['script'] || $item['script'] == "")
	{
		$cont++;
		echo "<span class=\"Title".$cont."\">".$item['acao']."</span>\n";
	}
	else
	{
		if ($item['script'] != "/content/view")
		{
			echo "<a href=\"/index.php".$item['script']."/".$_page->_objeto->Valor($_page, 'cod_objeto').".html?naoincluirheader&exibir\" onclick=\"jqAjaxLink($(this).attr('href'), 'container_corpo_publicare', true); jqAjaxLink('/index.php/inc/header/".$_page->_objeto->Valor($_page, 'cod_objeto').".html?naoincluirheader&url=".$item['script']."', 'container_header_publicare', true); return false;\">";
		}
		else
		{
			echo "<a href=\"/index.php".$item['script']."/".$_page->_objeto->Valor($_page, 'cod_objeto').".html\">";
		}
		echo "<img src=\"/html/imagens/menu/menu_lateral/icn_".$item['ordem'].".gif\" width=\"16\" height=\"16\" align=\"middle\">".$item['acao']."</a>";
	}
}
*/