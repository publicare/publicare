<?php
/**
* Criacao da view Lista Netos Ajax
*
* @author Manuel Poppe Correia de Barros
* @version * <pre>
*   <b>1.0</b>
*    Data: 26/11/2008
*    Autor: Manuel Poppe Correia de Barros
*    Descricao: Versao inicial
*   <hr>
* </pre>  
* @name view_listanetos
* @package html/template
* @access public
*/

	global $SUBCLASSE,$SUBDIV,$SUBCOD,$PERFIL,$CODCLASSE,$CLASSESSELECIONADAS,$REDIRECIONANETOS;
	//carrega o perfil do usuario q esta acessando o site na variavel global $perfil
    $PERFIL = $_page->_usuario->cod_perfil;
	$blnRegistroEncontrado = false;
	
//	include_once($_SERVER['DOCUMENT_ROOT']."/html/objects/variavelClassesSelecionadas.php");
?>

<@var $TITULOPAI=#titulo@>
<@var $REDIRECIONANETOS = #cod_objeto@>
<@localizar classes=['arquivo,link,interlink,document,publicacao,iframe,fontesfinanciamento,publicacoeslegis'] pai=[#cod_objeto] niveis=[0] ordem=['peso,titulo']@>

	<?php $blnRegistroEncontrado = true; ?>
	<@var $CODCLASSE=#cod_classe@>
	<@var $TEMFILHOS=#temfilhos@>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
	<?php
				switch ($CODCLASSE) {
					
	/********** CASE - CLASSE -> ARQUIVO **********************************/
				case 5:
	?>
					<@usarblob nome=['conteudo']@>
					<td valign="top" class="listaTitulo1Nive3">
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
					<td valign="top" class="listaTitulo1Nive3">
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
					<td valign="top" class="listaTitulo1Nive3">
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
					<td valign="top" class="listaTitulo1Nive3">
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
			</table>
<@/localizar@>

<?php
/******************************** TRAZ OS FILHOS FOLDER *******************************/
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<@localizar classes=['folder'] pai=[#cod_objeto] niveis=[0] ordem=['peso,data_publicacao']@>
		<?php $blnRegistroEncontrado = true; ?>
		<@var $SUBCOD=#cod_objeto@>
		<?php $SUBDIV="888".$SUBCOD;?>
		<tr>
			<td valign="top" class="listaTitulo1Nive3">
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
			<td width="15" align="right" valign="top" class="listaTitulo1Nivel">&nbsp;
			</td>
		</tr>
	<@/localizar@>
</table>

<?php if ($blnRegistroEncontrado == false) { ?>
<div align="center">Voçê está sendo redirecionado para&nbsp;<@= $TITULOPAI@></div>
<script>
	window.location="/index.php/content/view/<@= $REDIRECIONANETOS@>.html";
</script>
<?php } ?>
