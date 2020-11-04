<div id="divGuiaA" style="height: 0%; visibility: show;" class="pblAlinhamentoTabelas">
<table border=0 width=580 cellpadding="3" cellspacing="1">
	<tr>
		<td width=450 valign="top">
			<table class="pblTabelaGeral" width="100%" cellpadding="3" cellspacing="1">
			<tr>
				<td class="pblTituloLog" align="center">
				<?
					global $year, $day, $month;
					

					echo $GLOBALS['_page']->Objeto->Valor('titulo').' - ';
					if ($year=='')
					{
						$year=date("Y");
						$bntJSExecutar = "$year";
					}
					else {
						if ($day!='')
						{
							echo "$day/$month/$year";
							//echo ConverteData("$day/$month/$year",0);
							//$colspan=0;
							$datetitle="hora";
							$bntJSExecutar = "$year,$day,$month";
						}
						else
						{				
							$colspan=2;
							if ($month!='')
							{
								//echo $month;
								echo nome_do_mes($month).' de '.$year;
								$datetitle="dia";
								$bntJSExecutar = "$year,$month";
							}
							else
							{
								echo $year;
								$datetitle="Mês";
								$bntJSExecutar = "$year";
							}
						}
					}
				?>
				</td>
				<td align="right">
					<a href="<? echo $GLOBALS['_page']->Objeto->Valor('url')?>"><img border="0" src="/html/imagens/portalimages/exibir.png"></a>
				</td>
			</tr>
			<tr>
				<? if ($datetitle)
					{
				?>
				<td class="pblCabecaLog"><? echo $datetitle?></td>
				<? }?>
				<td class="pblCabecaLog">Acessos</td>
			</tr>
		<?
			$loglist=$GLOBALS['_page']->Administracao->GetLogAccessList($GLOBALS['_page']->Objeto->Valor("cod_objeto"),$year,$month,$day,$_GET['state'],$_GET['iporigem']);
			$count=0;
			$sum=0;
			//var_dump($loglist);
			foreach($loglist as $log)
			{
				if ($count++%2)
					$class="pblTextoLogImpar";
				else
					$class="pblTextoLogPar";
				echo '<tr>';
				if ($datetitle)
				{		
					echo '<td class="'.$class.'">';
					//var_dump($log);
					echo $log['adate'];
					echo '</td>';
				}
				echo '<td class="'.$class.'">';
				echo $log['counter'];
				echo '</td>';
				echo '</tr>';
				$sum +=$log['counter'];
			}
			if (!$count)
			{
				echo '<tr><td class="pblCabecaLog" colspan="2">Acessos inexistentes no período selecionado</td></tr>';
			}
			else
			{
				echo '<tr><td class="pblCabecaLog">Total de Acessos à área:</td><td class="pblCabecaLog">'.$sum.'</td></tr>';
			}
		?>
			</table>
<?
	if (count($loglist)>1)
	{
		$graf_data['value']='counter';
		$graf_data['title']='adate';
		$graf_data['data']=array_reverse($loglist);
		$_SESSION['graf_data']=$graf_data;
?>
			<P>
			<table border=0 cellpadding=4 cellspacing=0>
				<tr>
					<td align="center" class="pblTituloLog">
						Gráfico de Acessos por Data</td>
				</tr>
				<tr>
					<td class="pblTextoLogImpar">
						<img src="/html/objects/portalgraphic/line.php?var=graf_data"></td>
				</tr>
			</table>
<?	
	}
?>
		</td>
		<td valign="top">
			<?
				calendario("/index.php/do/logacesso/".$cod_objeto.".html",'','',$year,$month);
			?>
			<table class="pblTabelaGeral" width="100%" cellpadding="1" cellspacing="0" bgcolor="#ff9900">
			<tr>
				<td class="pblCalendario" align="center" colspan="2" bgcolor="#ff9900">
					<strong>OPÇÕES</strong>
				</td>
			</tr>
			<tr>
				<td width="5%">
				<input type="checkbox" name="state[]" id="state_1" value="1" <?=((($_GET['state']==4 || $_GET['state']==2) || (!isset($_GET['state']))) ? "checked" : "")?>>
				</td>
				<td>
				<label for="state_1">Ver logados</label>
				</td>
			</tr>
			<tr>
				<td width="5%">
				<input type="checkbox" name="state[]" id="state_2" value="2"  <?=((($_GET['state']==4 || $_GET['state']==3) || (!isset($_GET['state']))) ? "checked" : "")?>>
				</td>
				<td>
				<label for="state_2">Ver não-logados</label>
				</td>
			</tr>
			<tr>
				<td width="5%">
				<input type="checkbox" name="iporigem[]" id="iporigem_2" value="2"  <?=((($_GET['iporigem']==4 || $_GET['iporigem']==2) || (!isset($_GET['state']))) ? "checked" : "")?>>
				</td>
				<td>
				<label for="iporigem_2">Ver IP interno</label>
				</td>
			</tr>
			<tr>
				<td width="5%">
				<input type="checkbox" name="iporigem[]" id="iporigem_3" value="3"  <?=((($_GET['iporigem']==4 || $_GET['iporigem']==3) || (!isset($_GET['state']))) ? "checked" : "")?>>
				</td>
				<td>
				<label for="iporigem_3">Ver IP externo</label>
				</td>
			</tr>
			<tr>
				<td class="pblCalendario" align="center" colspan="2">
					<input type="button" onclick="JSCalendarioChangeData('/index.php/do/logacesso/<?=$cod_objeto;?>.html',<?=$bntJSExecutar?>);" value="Executar" size="10" style="height:20px;color:blue;"></a>
				</td>
			</tr>			
			</table>
		</td>
	</tr>
</table>
</div>