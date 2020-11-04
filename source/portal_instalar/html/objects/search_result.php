<?php
global $_page;

	function processing_time($START=false)
	{
	    $an = 4;    // How much digit return after point
	
	    if(!$START) return time() + microtime();
	    $END = time() + microtime();
	    return round($END - $START, $an);
	}
	
	function pegaAreasArray()
	{
		return explode(",", urldecode($_GET["buscaselecionada"]));
	}
	
	function cortaHighLight($texto)
	{
		preg_match('/<b style="(.*)">(.*)<\/b>/', $texto, $matches, PREG_OFFSET_CAPTURE);
//		echo "<pre>";
		var_dump($matches);
//		echo "</pre>";
//		exit();
//		preg_match('/index\.php(\/.+)\/(\d+)\.html.*$/', $_SERVER['REQUEST_URI'], $matches);
	}
	
	$inicioExecucao = processing_time();

	$i = 0;
	$searchquery = (isset($_POST['searchquery']))?$_POST['searchquery']:((isset($_GET['searchquery']))?urldecode($_GET['searchquery']):"");
	$areasearch = (isset($_POST['buscaselecionada']))?$_POST['buscaselecionada']:((isset($_GET['buscaselecionada']))?pegaAreasArray():null);
	
	if ($areasearch != null) $areas_query = implode(",", $areasearch);
	else $areas_query = "";

	$busca = $_page->_adminobjeto->Search($_page, $searchquery, ($search_type + 0), $areasearch);
	
//	echo "<pre>";
//	var_dump();
//	$highlightedHTML = $_page->_adminobjeto->index->qry->highlightMatches($sourceHTML);
//	exit();
	
	$totalExecucao = processing_time($inicioExecucao);
	
	$tam = 20;
	$pag = intval((isset($_GET['search_page'])?$_GET['search_page']:'1'));
	$total = count($busca);
	
	if ($total>0)
	{
		$inicio = ($pag>1)?(($tam*($pag-1))+1):1;
		$fim = ($inicio + $tam) - 1;
		if ($fim > $total) $fim = $total;
		
		$num_pags = intval($total/$tam);
		if ($total%$tam>0) $num_pags++;
		
		$max = $pag + 5;
		$min = $pag - 5;
		if ($min<1) $min = 1;
		if ($max>$num_pags) $max = $num_pags;
		if (($max-$min) < 9) $max = $max + (9-($max-$min));
		if ($max > $num_pags) $max = $num_pags;
	}
?>


	<table width="100%" border="0" cellpadding="4" cellspacing="4">
		<?php
		$search_results = $busca;
		
		echo '<tr><td bgcolor="#eeeeee" colspan="2"><font class="TextoPreto">
		Buscando por: '.$searchquery.'<br>
		<div align="right">Tempo: '.$totalExecucao." segundos</div><br>";
		
		
		if ($total>0){
			echo '<b>'.$total.'</b> resultados encontrados. Mostrando de <b>'.$inicio.'</b> a <b>'.$fim.'</b><br>
			<br>
			Páginas de resultados: ';

			for ($i=$min; $i<=$max; $i++)
			{
				if ($i == $min && $i>1) echo " <b>...</b> ";
				if ($pag==$i) echo " <b><font color='#ff0000'>".$i."</font></b> ";
				else echo " <a href='/index.php?action=/html/objects/search_result&buscaselecionada=".$areas_query."&searchquery=".urlencode($searchquery)."&search_page=".$i."'>".$i."</a> ";
				if ($i == $max && $i<$num_pags) echo " <b>...</b> ";
				else if ($i<$num_pags) echo " | ";
			}
			echo '</font></td></tr>';
	
			$contaresult = 0;
			$cont = $inicio;
			
			for ($cont=$inicio; $cont<=$fim; $cont++)
			{
				echo '<tr><td bgcolor="#888888" width="40" align="right"><font color="#ffffff">'.$cont.'.</font></TD>';
				echo '<td bgcolor="#eeeeee"><font class="TextoPreto">';
				echo '<div align="right"><small>'.number_format((($search_results[($cont-1)]->score)*100),1).'%</small></div>';
				echo '<A HREF="/index.php/content/view/'.$search_results[($cont-1)]->cod_objeto.'.html">';
				echo utf8_decode($search_results[($cont-1)]->titulo);
				echo '</A>';
//				echo "<br>".cortaHighLight( substr($_page->_adminobjeto->index->qry->highlightMatches($search_results[($cont-1)]->conteudo), strlen($search_results[($cont-1)]->conteudo)) );
				if(isset($search_results[($cont-1)]->descricao) && strlen($search_results[($cont-1)]->descricao)>5)
				{
					echo '<BR><I>'.utf8_decode($search_results[($cont-1)]->descricao).'</I>';
				}
				echo '</td></tr>';
			}
		} else {
			echo "<br><br><center>Nenhum registro encontrado</center></font></td></tr>";
		}
		?>
	
	</table>
