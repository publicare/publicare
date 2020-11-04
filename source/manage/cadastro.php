
<?

include('cadastro.class.pinc');

	if ($_GET['cod_classe'])
	{
		$classinfo=$_page->Administracao->PegaInfoDaClasse($_GET['cod_classe']);
	}


	if ($is_explorer)
	{
		$areasize=80;
	}
	else
	{
		$areasize=40;
	}
	
	$cad = new Cadastro();
?>
	
	<div class="pblAlinhamentoTabelas">
	<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=8 class="pblTabelaGeral">
	<TR>
		<TD>
			<img border=0 src="/html/imagens/portalimages/peca3.gif" ALT="" align="left"><font class="pblTituloBox">Banco de dados de usuários</font>
		</td>
		
		<TD>
			<a href="#" onclick="history.back()"><img border=0 src="/html/imagens/portalimages/voltar2.gif" ALT="Voltar"></a></TD>
	</TR>

	<tr>
		<td class="pblFormText">
            <form style="padding:0; margin:0;"  action="/index.php/do/cadastro/<? echo $_page->Objeto->Valor("cod_objeto")?>.html" method="get">
            	<TABLE width="100%" BORDER=0 cellpadding="4" cellspacing=2>
            		<tr>
            			<td width="140" class="pblTituloForm" valign="top" valign="top">
            				Selecione o banco de dados</td>
            			<td class="pblTextoForm">
            				<select class="pblSelectForm" name="cod_form">
            					 
            					<? echo $cad->DropDownForms($_GET['cod_form']);?>
            				</select>
							<br><br>
							<input type="radio" name="consulta" value="pesquisar"<?
							if ($_GET['consulta']=='pesquisar') echo ' checked';?>> Pesquisar<br>
							<input type="radio" name="consulta" value="arquivo"<?
							if ($_GET['consulta']=='arquivo') echo ' checked';?>> Gerar arquivo<br><br>
							
            				<input class="pblBotaoForm" type="submit" name="acao" value="Selecionar">
							<BR>  
						</td>
					</tr>
				</table>
			</form>
			<hr style="pblLinha" size="1">
<?
	if ($_GET['acao']=='Selecionar') {
		//Dar a opção de pesquisar ou gerar o CSV
		
		if ($_GET['consulta']=='pesquisar') {
			$cad->GerarPesquisa(intval($_GET['cod_form']));
		}
		elseif ($_GET['consulta']=='arquivo') {
			
			if ($_GET['gerar_arquivo']=='Gerar novo arquivo') {
				$cad->GerarCsv(intval($_GET['cod_form']));
				echo '<br>';
			}
			
			echo $cad->VerificarCsv(intval($_GET['cod_form']));
				
			echo '<br>';
			echo '
			<form name="gerar_arquivo" action="'.$PHP_SELF.'" method=get>
				<p class="pblTextoForm"><input type="submit" name="gerar_arquivo" value="Gerar novo arquivo" class="pblBotaoForm"></p>
				<input type="hidden" name="consulta" value="arquivo">
				<input type="hidden" name="acao" value="Selecionar">
				<input type="hidden" name="cod_form" value="'.$_GET['cod_form'].'">
			</form>
			';
			
		}
		
	}
	
	if ($_GET['cod_registro']) {
		$array_info = $cad->PegaInfo($_GET['cod_registro']);
		if (count($array_info)>0) {
			echo '
			<p class="pblTextoForm"><table width="480" border="0" class="pblTabelaClara" cellspacing="0" cellpadding="4">
				<tr><td colspan="2"><p class="pblTextoForm"><strong>Dados do registro selecionado</strong></p></td></tr>
';
			foreach ($array_info as $k=>$v) {
				echo '<tr><td width="30%"><p class="pblTextoForm" style="font-weight: bold">'.$k.':</p></td>
				<td width="70%"><p class="pblTextoForm">'.$v.'</p></td></tr>'."\n";
			}
			
			echo '
			</table>
			</p>
			<br>
			';
		}
	}
	
	if ($_GET['submit']=='Pesquisar') {
		echo '

<form method="get" action="'.$_SERVER['PHP_SELF'].'" name="descricao">
<font class="pblTextoForm" style="text-transform: uppercase"><strong>Resultados da pesquisa</strong></font><br>
<table width="500" border="0">
<tr><td>';

		$fator1 = intval($_GET['pag_atual']);
		$fator1--;
		$fator2 = intval($_GET['maximo']);
		$inicio = ( $fator1 * $fator2 );
		
		if ($array_pesquisa = $cad->Pesquisar($_GET, $inicio, intval($_GET['maximo']))) {
			if ( intval($array_pesquisa['count']) > 0 ) {
				
				echo '<p style="margin-left: 7px; margin-top: 7px;">
	<table width="480" cellspacing="0" cellpadding="4" border="0">
		<tr>
			<td><p class="pblTextoForm"><strong>Código</strong></p></td>
			<td><p class="pblTextoForm"><strong>Nome</strong></p></td>
			<td><p class="pblTextoForm"><strong>E-mail</strong></p></td>
			<td><p class="pblTextoForm"><strong>Data de registro</strong></p></td>
		</tr>
		';
				foreach($array_pesquisa['resultados'] as $v) {
					$url = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
					$url=preg_replace('!&cod_registro=\d+!is','',$url);
					echo '<tr>
			<td><p class="pblTextoForm">'.$v['cod_registro'].'</p></td>
			<td><p class="pblTextoForm"><a href="'.$url.'&cod_registro='.$v['cod_registro'].'" class="pblLinksAdmin">'.$v['nome'].'</a></p></td>
			<td><p class="pblTextoForm">'.$v['email'].'</p></td>
			<td><p class="pblTextoForm">'.$v['data_registro'].'</p></td>
		</tr>
		';
				}
				echo '
			<tr><td colspan="4"> <p style="margin-top: 7px">
			' . $cad->Paginacao( intval($array_pesquisa['count']), intval($_GET['maximo']), intval($_GET['pag_atual']) ). ' </p></td></tr>
		</table></p>
		<br>';
			}
			echo '</td></tr>
</table>
</form>
<font class="pblTextoForm"><P>';
		}
		else {
			echo '<p class="pblTextoForm">Não há resultados para a pesquisa.</P><br>';
		}
		
		$cad->GerarPesquisa(intval($_GET['cod_form']),$_GET);
	}
	
	
	
?>
              
           
		</td>
	</tr>
	
	<tr><td colspan="3"><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>

	</table>
	</div>

