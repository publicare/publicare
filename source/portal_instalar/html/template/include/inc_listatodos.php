<!-- ======================================================= -->
<!-- === lista todos os filhos de um objeto menos os selecionados na va variavel classes selecionadas  === -->
<?php
	global $_page,$PERFIL,$CLASSESSELECIONADAS,$PAI,$COD,$DIV,$TEMFILHOS,$CODCLASSE,$QUEMEHQUEM;
	
//	include_once($_SERVER['DOCUMENT_ROOT']."/html/objects/variavelClassesSelecionadas.php");
?>
<@var $txt=#texto@>
<@var $PAI=#cod_objeto@>

<!-- === verifica se o objeto tem menu próprio === -->
<@se [#menu_proprio!=1]@>
<@localizar classes=['arquivo,link,interlink,document,publicacao,iframe,fontesfinanciamento,publicacoeslegis'] pai=[$PAI] niveis=[0] ordem=['peso,titulo']@>
	<@var $CODCLASSE=#cod_classe@>
	<@var $TEMFILHOS=#temfilhos@>
	
	<@se [%INDICE==1]@>
		<div class="paddingTop10">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<@se [$txt!='']@>
			<tr>
				<td class="vejaTambem" title="Veja Também">Veja Também</td>
			</tr>
			<@/se@>
			<tr>
				<td class="paddingLeft10 paddingRight10 paddingTop paddingBottom bgJupter" valign="top">
				<!-- === ( conteúdo do Veja Também ) === -->
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<@/se@>
				<tr>
	<?php
				switch ($CODCLASSE) {
					
	/********** CASE - CLASSE -> ARQUIVO **********************************/
				case 5:
	?>
					<@usarblob nome=['conteudo']@>
					<td valign="top" class="listaTitulo1Nivel">
						<div style="position:relative; width:100%;"> 
	        				<div style="float:left; position:relative; width:5%;" align="right"> <@iconeclasse@> </div>
	        				<div style="float:left; position:relative; width:95%;"> &nbsp;&nbsp;<a href="<@linkblob@>" title="Clique aqui para baixar o arquivo&nbsp;<@= strip_tags(#titulo)@>"><@= strip_tags(#titulo)@></a> 
	         			 	<@se [#cod_status!=2]@><span class="apublicar"@>&nbsp;<a href="/index.php/do/publicar/<@= #cod_objeto@>.html" title="Publicar&nbsp;<@= strip_tags(#titulo)@>">a publicar</a></span><@/se@> 
	<?php
						// === verifica se o usuario está logado e insere o icone de editar objeto===
						if ($PERFIL <= _PERFIL_AUTOR)
						{
	?>
	         				 <span class="paddingLeft10">&nbsp;<a href="/index.php/manage/edit/<@= #cod_objeto@>.html"><img src="/html/imagens/site/ic-editar.gif" title="Editar&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a></span> 
	<?php
						}
	?>
	        			</div>
	        			<div class="brod terra paddingLeft38" title="Resumo do objeto"><@= strip_tags(cortaTexto(#resumo, 300))@></div>
	     			 	</div>
					</td>
					<@/usarblob@>
					<td align="right" valign="top" class="listaTitulo1Nivel">&nbsp;</td>
				</tr>
	<?php
				break;
	/********** CASE - CLASSE ->LINK **********************************/
				case 6:
	?>
					<td valign="top" class="listaTitulo1Nivel">
					<div style="position:relative; width:100%;"> 
	        			<div style="float:left; position:relative; width:5%;" align="right"> <@iconeclasse@></div>
	       				<div style="float:left; position:relative; width:95%;"> &nbsp;&nbsp;<a href="<@= #endereco@>" target="_blank" title="<@= strip_tags(#titulo)@>"><@= strip_tags(#titulo)@></a>	       				
	          			<@se [#cod_status!=2]@><span class="apublicar"@>&nbsp;<a href="/index.php/do/publicar/<@= #cod_objeto@>.html" title="Publicar&nbsp;<@= strip_tags(#titulo)@>">a publicar</a></span><@/se@> 
	<?php
						// === verifica se o usuario está logado e insere o icone de editar objeto===
						if ($PERFIL <= _PERFIL_AUTOR)
						{
	?>
	          				<span class="paddingLeft10">&nbsp;<a href="/index.php/manage/edit/<@= #cod_objeto@>.html"><img src="/html/imagens/site/ic-editar.gif" title="Editar&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a></span> 
	<?php
						}
	?>
		                </div>
		                <div class="brod terra paddingLeft38" title="Resumo do objeto"><@= strip_tags(cortaTexto(#resumo, 300))@></div>
		              </div>
					</td>
					<td align="right" valign="top" class="listaTitulo1Nivel">&nbsp;</td>
				</tr>
	<?php
				break;
	/********** CASE - CLASSE ->INTERLINK **********************************/
				case 2:
	?>
					<td valign="top" class="listaTitulo1Nivel">
					<div style="position:relative; width:100%;"> 
	        			<div style="float:left; position:relative; width:5%;" align="right"> <@iconeclasse@> </div>
	        			<div style="float:left; position:relative; width:95%;"> <a href="/index.php/content/view/<@= #endereco@>.html#ancora" title="<@= strip_tags(#titulo)@>">&nbsp;&nbsp;<@= strip_tags(#titulo)@></a>	        			
	          			<@se [#cod_status!=2]@><span class="apublicar"@>&nbsp;<a href="/index.php/do/publicar/<@= #cod_objeto@>.html" title="Publicar&nbsp;<@= strip_tags(#titulo)@>">a publicar</a></span><@/se@> 
	<?php
						// === verifica se o usuario está logado e insere o icone de editar objeto===
						if ($PERFIL <= _PERFIL_AUTOR)
						{
	?>
	          				<span class="paddingLeft10">&nbsp;<a href="/index.php/manage/edit/<@= #cod_objeto@>.html"><img src="/html/imagens/site/ic-editar.gif" title="Editar&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a></span> 
	<?php
						}
	?>
	                </div>
	                <div class="brod terra paddingLeft38" title="Resumo do objeto"><@= strip_tags(cortaTexto(#resumo, 300))@></div>
	              </div>
					</td>
					<td align="right" valign="top" class="listaTitulo1Nivel">&nbsp;</td>
				</tr>
	<?php
				break;
	/******************************** DEFAULT **********************************/
				default:
	?>
				<tr>
					<td valign="top" class="listaTitulo1Nivel">
					<div style="position:relative; width:100%;"> 
	        			<div style="float:left; position:relative; width:5%;" align="right"> <@iconeclasse@> </div>
	        			<div style="float:left; position:relative; width:95%;"> &nbsp;&nbsp;<a href="<@= #url@>" title="<@= strip_tags(#titulo)@>"><@= strip_tags(#titulo)@></a> 
	          			<@se [#cod_status!=2]@><span class="apublicar"@>&nbsp;<a href="/index.php/do/publicar/<@= #cod_objeto@>.html" title="Publicar&nbsp;<@= strip_tags(#titulo)@>">a publicar</a></span><@/se@> 
	<?php
						// === verifica se o usuario está logado e insere o icone de editar objeto===
						if ($PERFIL <= _PERFIL_AUTOR)
						{
	?>
	          				<span class="paddingLeft10"> &nbsp;<a href="/index.php/manage/edit/<@= #cod_objeto@>.html"><img src="/html/imagens/site/ic-editar.gif" title="Editar&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a> 
	<?php
							if ($TEMFILHOS==1)
							{
	?>
	              				&nbsp;<a href="/index.php/manage/new/<@= #cod_objeto@>.html"><img src="/html/imagens/site/ic-inserir.gif" title="Inserir outros objetos em&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a> 
	<?php
							}
	?>
			                  </span> 
	<?php
						}
	?>
		                </div>
		                <div class="brod terra paddingLeft38" title="Resumo do objeto"><@= strip_tags(cortaTexto(#resumo, 300))@></div>
		            </div>
					</td>
	<?php
						//}
					}//FECHA SWITCH
	?>
	<@se [%INDICE==%FIM]@>
					</table>
				</td>
			</tr>
			
		</table>
	</div>
	<@/se@>
<@/localizar@>

<?php
/******************************** TRAZ OS FILHOS FOLDER *******************************/
if ($QUEMEHQUEM==false){
?>
<@localizar classes=['folder'] pai=[$PAI] niveis=[0] ordem=['peso,data_publicacao']@>
<@se [%INDICE==1]@>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="paddingLeft10 paddingRight10 paddingTop paddingBottom bgJupter" valign="top">
		<!-- === ( conteúdo do Veja Também ) === -->
		<table width="100%" border="0" cellspacing="0" cellpadding="0">		
<@/se@>
			<@var $COD=#cod_objeto@>
			<? $DIV="999".$COD;?>
			<tr>
				<td valign="top" class="listaTitulo1Nivel">
				<div style="position:relative; width:100%;"> 
        			<div style="float:left; position:relative; width:5%;" align="right"> <@iconeclasse@> </div>
        			<div style="float:left; position:relative; width:95%;"> &nbsp;&nbsp;<a href="<@= #url@>" title="<@= strip_tags(#titulo)@>"><@= strip_tags(#titulo)@></a> 
          			<@se [#cod_status!=2]@><span class="apublicar"@>&nbsp;<a href="/index.php/do/publicar/<@= #cod_objeto@>.html" title="Publicar&nbsp;<@= strip_tags(#titulo)@>">a publicar</a></span><@/se@> 
<?php
					// === verifica se o usuario está logado e insere o icone de editar objeto===
					if ($PERFIL <= _PERFIL_AUTOR){
?>
          				<span class="paddingLeft10"> 
          					&nbsp;<a href="/index.php/manage/edit/<@= #cod_objeto@>.html"><img src="/html/imagens/site/ic-editar.gif" title="Editar&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a> 
              				&nbsp;<a href="/index.php/manage/new/<@= #cod_objeto@>.html"><img src="/html/imagens/site/ic-inserir.gif" title="Inserir outros objetos em&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a> 
		                </span> 
<?php				}
?>
	                </div>
	            </div>
				</td>
				<td width="15" align="right" valign="top" class="listaTitulo1Nivel">
					<a href="#lista" onclick="JSMostraFilhosComAjax(<?= $DIV?>,<?= $COD?>,'listatodos_ajax');">
						<img src="/html/imagens/site/bullet-mais.gif" width="13" height="13" border="0" align="absmiddle" id="<?= $COD?>">
					</a> 
				</td>
			</tr>
			<!-- TD QUE MSOTRA O RESULTADO DOS FILHOS -->
			<tr>
				<td colspan="2" valign="top"  style="display:none" id="<?= $DIV?>" align="right"></td>
			</tr>
<@se [%INDICE==%FIM]@>		
		</table>
	</tr>
</table>
<@/se@>
<@/localizar@>
<?php
}
?>
<@/se@><!-- FECHA SE, SE O POSSUI MENU PROPRIO -->