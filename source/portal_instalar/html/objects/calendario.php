<?php
	function object_calendario($params)
	{
		//calendario($url, $cor='', $titulo='', $ano='', $mes='',$showdays=true,$startyear=2001)
		global $action,$cod_objeto,$ano,$mes,$dia,$nrdias;

		$param_array = explode (" ",$params." ");
		foreach ($param_array as $pr)
		{
			preg_match ('|(.*?)=(.*?)\s(.*)|is',$pr,$item);

		}

		if (isset($_GET['ano'])) $ano = $_GET['ano'];
		else $ano = date("Y");
		if (isset($_GET['mes'])) $mes = $_GET['mes'];
		else $mes = (int) date("m");
		if (isset($_GET['dia'])) $dia = $_GET['dia'];
		else $dia = (int) date("d");

		$showdays=true;
		$limitdate=true;
		$url="/index.php/content/view/".$cod_objeto.".html";
		$cor="#D5E3B7";
		$subtom="#D5E3B7";
		$corselecionado="#FFFFFF";
		$startyear=2003;
		$fontface="Arial,Verdana,Sans-Serif,Helvetica,Univers,Zurich BT";
		$fontsize="10px";
		$fontcolor="#000000";
		$fontcolorhover="#000000";
		$corclick="#5D8A45";



		global $dias_da_semana;
		global $nome_do_mes;

	?>
		<style type="text/css">
		.borda
		{
			background: #FFFFFF;
			border: 1px #AEAEAE solid;
			padding: 1px;
		}
		.ocorrencia A
		{
			font-size:11px;
			color: #000000;
			text-decoration: bold;
		}

		.ocorrencia A:hover
		{
			display: block;
			background:#5D8A45;
			font-size:11px;
			color: #FFFFFF;
			text-decoration: bold;
		}

		.ACalendario
		{
			font-family: <? echo $fontface?>;
			font-size:<? echo $fontsize?>;
			color: <? echo $fontcolor?>;
			text-decoration: none;
		}
		.ACalendario:hover
		{
			display: block;
			background:#5D8A45;
			font-family: <? echo $fontface?>;
			font-size:<? echo $fontsize?>;
			color: <? echo $fontcolorhover?>;
			text-decoration: NONE;
		}
		</style>
		<script language="javascript">
		var dia_selecionado = "";
		var mes_selecionado = "";
		var ano_selecionado = "";

		var dia_atual = "<?=$dia?>";
		var mes_atual = "<?=$mes?>";
		var ano_atual = "<?=$ano?>";

		function defineDia(dia){
			Form1 = document.form_calendario;
			Form1.dia.value = dia;
			document.getElementById('dia_'+dia).bgColor = "<?=$corclick?>";
			if (dia_selecionado!="") document.getElementById('dia_'+dia_selecionado).bgColor = "<?=$subtom?>";
			dia_selecionado = dia;
			if (mes_selecionado=="") defineMes(mes_atual);
			if (ano_selecionado=="") defineAno(ano_atual);
		}

		function defineMes(mes){
			Form1 = document.form_calendario;
			Form1.mes.value = mes;
			document.getElementById('mes_'+mes).bgColor = "<?=$corclick?>";
			if (mes_selecionado!="") document.getElementById('mes_'+mes_selecionado).bgColor = "<?=$subtom?>";
			mes_selecionado = mes;
			if (ano_selecionado=="") defineAno(ano_atual);
		}

		function defineAno(ano){
			Form1 = document.form_calendario;
			Form1.ano.value = ano;
			document.getElementById('ano_'+ano).bgColor = "<?=$corclick?>";
			if (ano_selecionado!="") document.getElementById('ano_'+ano_selecionado).bgColor = "<?=$subtom?>";
			ano_selecionado = ano;
		}
		</script>
	<?




		if ($ano=="")
		{
			$naomarcar=1;
			$ano=date('Y');
			$mes=intval(date('m'));
			$dia=date('d');
		}
		else
		{
			if ($mes=="")
				$mes=1;
		}

		$TD='<TD class="ocorrencia" bgcolor="'.$subtom.'" align="center"><font class="ACalendario">';
		$TDSELECIONADO='<TD class="ACalendario" bgcolor="'.$corselecionado.'" align="center"><font class="ACalendario">';

		echo '<form action="'.$url.'" method="get" name="form_calendario" id="form_calendario">';
		echo '<input type="hidden" id="dia" name="dia" value="">';
		echo '<input type="hidden" id="mes" name="mes" value="">';
		echo '<input type="hidden" id="ano" name="ano" value="">';
		echo '<TABLE width=150 cellpadding="1" cellspacing="1" bgcolor="#'.$cor.'" class="borda"><TR>';
		echo '<TD bgcolor="'.$cor.'" align="center" colspan="7">';
		echo '<font color="#000000"><strong> '.$nome_do_mes[$mes].'/'.$ano.'</strong></font></TD></TR><TR>';

		if ($showdays)
		{
			$limit=32;
			if ($limitdate)
			{
				if (($ano==date("Y")) && ($mes==date("m")))
					$limit=intval(date('d'));
				else
				{
					if (($ano>date("Y")) || (($ano==date("Y")) && ($mes>date("m"))))
					{
						$limit=0;
					}
				}
			}

			foreach($dias_da_semana as $dia_da_semana)
			{
				echo $TD.$dia_da_semana[0].'</TD>';
			}
			echo '</TR><TR>';
			echo str_repeat ($TD."&nbsp;</TD>", date('w',mktime (0,0,0, abs($mes), 1, $ano)));

			for($n=1;$n<=31;$n++)
			{
				if(checkdate($mes, $n, $ano))
				{
					if (($n==$dia) && (!isset($naomarcar))){
						$classe = "ACalendario";
						$corbg = $corselecionado;
					}
					else{
						$classe = "ocorrencia";
						$corbg = $subtom;
					}
					echo '<TD id="dia_'.$n.'" class="'.$classe.'" bgcolor="'.$corbg.'" align="center"><font class="ACalendario">';
					$timestamp=mktime (1,1,1, abs($mes), $n, $ano);
					if ($n>$limit)
						echo $n;
					else
					{
						echo '<b><a class="ACalendario" href="#" onclick="defineDia('.$n.'); return false;">';
						echo $n.'</a>';
					}
					echo '</TD>';
					if(date('w',$timestamp)==6) echo '</TR><TR>';
				} else break;
			}
			echo str_repeat ($TD."&nbsp;</TD>", (6-date('w',mktime (0,0,0, abs($mes), $n-1, $ano))));
			$nrdias = $n-1;

		}

		echo '</TR><TR><TD colspan=7 class="ACalendario" align="center">';
		echo '<font class="ACalendario"><strong>OUTROS MESES</strong></font>';
		echo '<TABLE border=0 cellpadding="1" cellspacing="1" width="100%"><TR>';

		//$TD='<TD class="calendario" bgcolor="'.$subtom.'" align="center"><font class="calendario">';
		//$TDS='<TD class="calendario" bgcolor="'.$subtom.'" align="center"><font class="calendario">';

		$conta_mes=1;
		$max=3;

		$limit=12;
		if ($limitdate)
		{
			if ($ano==date('Y'))
				$limit=intval(date('m'));
		}

		$count = 0;
		while($conta_mes<=$limit)
		{
			$count++;

			if (($conta_mes==$mes) && (!isset($naomarcar)) && (!empty($mes))){
				$classe = "ACalendario";
				$corbg = $corselecionado;
			}
			else{
				$classe = "ocorrencia";
				$corbg = $subtom;
			}
			echo '<TD id="mes_'.$conta_mes.'" class="'.$classe.'" bgcolor="'.$corbg.'" align="center"><font class="ACalendario">';
			echo '<A class="ACalendario" HREF="#" onclick="defineMes('.$conta_mes.'); return false;">'.$nome_do_mes[$conta_mes].'</A></TD>';
			if($count==$max) {
			 	echo '</TR></TABLE><TABLE border=0 cellpadding="1" cellspacing="1" width="100%"><TR>';
				$count=0;
			}
			$conta_mes++;
		}
		echo '</TR></TABLE>';
		echo '<font class="ACalendario"><strong>OUTROS ANOS</strong></font>';
		echo '<TABLE border=0 cellpadding="1" cellspacing="1" width="100%"><TR>';

		$conta_ano=$startyear;
		if ($limitdate)
			$limit=intval(Date('Y'));
		else
			$limit=$startyear+3;
		while($conta_ano<=$limit)
		{
			if (($conta_ano==$ano) && (!isset($naomarcar))){
				$classe = "ACalendario";
				$corbg = $corselecionado;
			}
			else{
				$classe = "ocorrencia";
				$corbg = $subtom;
			}
			echo '<TD id="ano_'.$conta_ano.'" class="'.$classe.'" bgcolor="'.$corbg.'" align="center"><font class="ACalendario">';
			echo '<A Class="ACalendario" HREF="#" onclick="defineAno('.$conta_ano.'); return false;">'.$conta_ano++.'</A></TD>';
		}
		echo '</TR></TABLE>
		<input type="submit" value="Ok" style="font-size:10px;background-color:#5D8A45; color:#FFFFFF; border:1px #000000 solid;">
		</TD></TR></TABLE></form>';
	}
?>