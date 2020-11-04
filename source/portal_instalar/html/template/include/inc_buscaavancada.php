<?php global $codigo, $titulo;?>
<script>
function JSFecharBoxBusca()
{
	if(document.getElementById('boxBuscaAvancada'))
	{
		JSMostraeOcultaNovo('boxBuscaAvancada');
	}
	if(document.getElementById('boxBuscaAvancadaOutroLayout'))
	{
		JSMostraeOcultaNovo('boxBuscaAvancadaOutroLayout');
	}
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" title="Seções">
	<tr>
		<td colspan="3" class="mvInternoTituloFundo cxTitulo">
			<div class="mvInternoTituloLeft">
				<div class="mvInternoTituloRight">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="100%" class="mvInternoPaddingLeft"><a href="#" title="Busca Avançada">Busca Avançada</a></td>
							<td align="right" class="mvInternoPaddingRight "><a href="#" onclick="JSFecharBoxBusca();" title="fechar"><img src="/html/imagens/site/ic-fechar.gif" width="15" height="15" border="0" align="absmiddle"></a></td>
						</tr>
					</table>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td  colspan="3" class="cxBg bgverdeCx">
			<table width="100%" align="center" cellpadding="0">
			<tr>
				<td>
				    <div style="display:block; border: 1px #000;">
<?php
						/*$arrUnidadeBuscaAvancada = array('O MCT'=>OMCT,
														 'Indicadores'=>INDICADORES,
														 'Legislação'=>LEGISLACAO,
														 'Fontes de Financiamento'=>FONTFINANC,
														 'Unidades de Pesquisa'=>UNIDPESQ,
														 'Nanotecnogia'=>NANOTECNOLOGIA,
														 'Tecnologia da Informação'=>TECINFOCOM,
														 'Tecnologia Industrial Basica'=>TECINDSERVTEC,
														 'Apoio ao Desenvolvimento Tecnológico de Empresas'=>DESCTECEMP,
														 'Marco Legal da Inovação Tecnológica'=>INOVTEC,
														 'Biodiversidade'=>BIODIVERSIDADE,
														 'Ciências do Mar'=>CIENCIADOMAR,
														 'Cooperação Internacional'=>COOPERINTER,
														 'Mudanças Climáticas'=>MUDCLIMATICAS,
														 'Meteorologia, Climatologia e Hidrologia'=>METCLIHIDRO,
														 'Gestão de Ecossistemas'=>GESTECO,
														 'Biodiesel'=>BIODISEL,
														 'Inclusão Social'=>INCLUSAOSOCIAL,
														 'Difusão e Popularização da Ciência'=>DIFPOPCITEC,
														 'Segurança Alimentar e Nutricional'=>SEGALIMNUT,
														 'Tecnologias Sociais'=>TECSOCIAIS,
														 'Arranjos Produtivos Locais'=>ARRPROLOC,
														 'Centros Vocacionais Tecnológicos'=>CEVOCTEC,
														 'Inclusão Digital'=>INCLUSAODIGITAL);*/
						
						$intIndiceCheckBox = 0;	 
						
						$arrUnidadeBuscaAvancada = array(
														'O MCT'=>105,
														'Indicadores'=>740,
														'Legislação'=>723,
														'Fontes de Financiamento'=>724,
														);
?>
						<!-- PREENCHE A CAIXA DE PESQUISA AVANÇADA COM TODAS OS TEMAS -->
						<@localizar classes=["areasatuacao"] condicao=['cod_pai <> 105 && retirar_menu <> 1'] ordem=['peso,titulo'] niveis=[0]@>
							<@var $titulo = #titulo@>
							<@var $codigo = #cod_objeto@>
							<?php 
								$arrUnidadeBuscaAvancada[$titulo] = $codigo;
							?>
						<@/localizar@>
						
						<table border=0 width='100%'>
						<tr>
							<td class='bgNeturno paddingLeft' colspan="6" height="25">Para não efetuar a busca em todo o portal selecione as áreas desejadas:</td>
						</tr>
						<tr>
<?php									
							foreach ($arrUnidadeBuscaAvancada as $tmpTexto => $tmpCodObjeto)
							{
								$ColocarTR = ($intIndiceCheckBox+1) % 3;
								echo "<td valign='top'>";
								echo "<input type=\"checkbox\" name=\"buscaselecionada[]\" id=\"buscaselecionada[$intIndiceCheckBox]\" value=\"$tmpCodObjeto\"></td><td valign='top'><label for=buscaselecionada[$intIndiceCheckBox]>$tmpTexto</label>";
								echo "</td>";
							
								$intIndiceCheckBox++;
								
								if ((!$ColocarTR) && ($intIndiceCheckBox >= 3))
								echo "</tr><tr>";
							}
?>
						</table>
										
					</div> 
			    </td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="left-bottom-b-verde-cx bgverdeCx"><img src="/html/imagens/site/nada.gif" width="4" height="4" alt="imagem"></td>
		<td width="100%" class="bottom-b-verde-cx bgverdeCx"><img src="/html/imagens/site/nada.gif" width="4" height="4" alt="imagem"></td>
		<td class="right-bottom-b-verde-cx bgverdeCx"><img src="/html/imagens/site/nada.gif" width="4" height="4" alt="imagem"></td>
	</tr>
</table>