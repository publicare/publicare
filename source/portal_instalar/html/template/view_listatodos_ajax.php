<?php
    /**
    * Criacao da view Lista Todos Ajax
    *
    * @author Danilo Moreira Lisboa
    * @version * <pre>
    *   <b>1.0</b>
    *    Data: 25/11/2008
    *    Autor: Danilo Moreira Lisboa
    *    Descricao: Versao inicial
    *   <hr>
    * </pre> 
    * @name view_listatodos_ajax
    * @package html/template
    * @access public
    */
	if($_GET['execview'] == 'listatodos_ajax'){
		header("Content-type: text/html; charset=ISO-8859-1");//charset=iso-8859-1
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
	}
    /* ======================================================= */
    /* === lista todos os filhos de um objeto menos os selecionados na va variavel classes selecionadas  === */

    global $_page,$PERFIL,$CLASSESSELECIONADAS,$DIV,$COD,$PAI,$SUBDIV,$SUBCOD,$TEMFILHOS,$CODCLASSE;
    //carrega o perfil do usuario q esta acessando o site na variavel global $perfil
    $PERFIL = $_page->_usuario->cod_perfil;
    $blnRegistroEncontrado = false;
   
    //    include_once($_SERVER['DOCUMENT_ROOT']."/html/objects/variavelClassesSelecionadas.php");
?>
<div class="paddingBottom25 estruturaBasic">
<@var $TITULOPAI=#titulo@>
<@var $REDIRECIONA = #cod_objeto@>
<@var $txt=#texto@>
<@localizar classes=['folder,arquivo,document,link,interlink,agenciadenoticias,agenda'] pai=[#cod_objeto] niveis=[0] ordem=['peso,titulo']@>

    <?php $blnRegistroEncontrado = true; ?>
    <@var $CODCLASSE=#cod_classe@>
    <@var $TEMFILHOS=#temfilhos@>
    <@var $COD=#cod_objeto@>
    <? $DIV="999".$COD;?>
    <@se [%INDICE==1]@>
	<?php 
		if(!$_GET['execview'] == 'listatodos_ajax'){
	?>
        <div class="paddingBottom">
            <@se [$txt!='']@>
                <div class="mvTituloFundo">Veja Também</div>
            <@/se@>
		</div>
	<?php
		}
	?>
		<div class="paddingBottom3">
    <@/se@>
   
            <?php
                switch ($CODCLASSE) {
                   
                /********** CASE - CLASSE -> FOLDER **********************************/
                case 1:
            ?>
                        
  <div style="position:relative; width:100%; line-height:25px;"> 
    <div style="float:left; position:relative; width:95%; border-bottom:1px #cccccc dotted;"><@iconeclasse@>&nbsp;<a href="<@= #url@>"><@= strip_tags(#titulo)@></a> 
      <@se [#cod_status!=2]@><span class="apublicar"@>&nbsp;<a href="/index.php/do/publicar/<@= #cod_objeto@>.html" title="Publicar&nbsp;<@= strip_tags(#titulo)@>">a 
      publicar</a></span><@/se@> 
      <?php if ($PERFIL <= _PERFIL_AUTOR){ ?>
      <span class="paddingLeft10">&nbsp;<a href="/index.php/manage/edit/<@= #cod_objeto@>.html"><img src="/html/imagens/ic-editar.gif" title="Editar&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a></span> 
      <@se [#temfilhos==1]@> <a href="/index.php/manage/new/<@= #cod_objeto@>.html"><img src="/html/imagens/ic-inserir.gif" title="Inserir outros objetos em&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a> 
      <@/se@> 
      <?php } ?>
    </div>
    <div style="float:left; position:relative; width:5%; border-bottom:1px #cccccc dotted; text-align:right;" class="listaTitulo1Nivel"> 
      <a href="#lista" onclick="JSMostraFilhosComAjax(<?= $DIV?>,<?= $COD?>,'listatodos_ajax');"> 
      <img src="/html/imagens/site/bullet-mais.gif" width="13" height="13" border="0" align="absmiddle" id="<?= $COD?>"> 
      </a> </div>
  </div>
						<@se [#resumo!='']@> 
						
  <div style="position:relative; float:left; width:100%;" class="brod paddingLeft"><@= cortaTexto(#resumo, 300)@></div>
						<@/se@>
                        
  <div style="position:relative; float:left; width:95%; padding-left:5%;">
    <div id="<?= $DIV?>" style="display:none;"></div>
  </div>
            <?php
                break;   
                    /********** CASE - CLASSE -> ARQUIVO **********************************/
                case 5:
            ?>
                    <@usarblob nome=['conteudo']@>
                        
  <div style="position:relative; width:100%; line-height:25px;"> 
    <div style="float:left; position:relative; width:100%; <@se [#resumo=='']@><@= ' '@>border-bottom:1px #cccccc dotted;<@/se@>"><@iconeclasse@>&nbsp;<a href="<@linkblob@>" title="Clique aqui para baixar o arquivo&nbsp;<@= strip_tags(#titulo)@>"><@= strip_tags(#titulo)@></a> 
      <@se [#cod_status!=2]@><span class="apublicar"@>&nbsp;<a href="/index.php/do/publicar/<@= #cod_objeto@>.html" title="Publicar&nbsp;<@= strip_tags(#titulo)@>">a 
      publicar</a></span><@/se@> 
      <?php if ($PERFIL <= _PERFIL_AUTOR){ ?>
      <span class="paddingLeft10">&nbsp;<a href="/index.php/manage/edit/<@= #cod_objeto@>.html"><img src="/html/imagens/ic-editar.gif" title="Editar&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a></span> 
      <@se [#temfilhos==1]@> <a href="/index.php/manage/new/<@= #cod_objeto@>.html"><img src="/html/imagens/ic-inserir.gif" title="Inserir outros objetos em&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a> 
      <@/se@> 
      <?php } ?>
    </div>
  </div>
						<@se [#resumo!='']@> 
						
  <div style="position:relative; float:left; border-bottom:1px #cccccc dotted; width:100%;" class="brod paddingLeft"><@= cortaTexto(#resumo, 300)@></div>
						<@/se@>
                    <@/usarblob@>
            <?php
                break;
                /********** CASE - CLASSE ->LINK **********************************/
                case 6:
            ?>
                        
  <div style="position:relative; width:100%; line-height:25px;"> 
    <div style="float:left; position:relative; width:95%; border-bottom:1px #cccccc dotted;"><@iconeclasse@>&nbsp;<a href="<@= #endereco@>" target="_blank" title="<@= strip_tags(#titulo)@>"><@= strip_tags(#titulo)@></a> 
      <@se [#cod_status!=2]@><span class="apublicar"@>&nbsp;<a href="/index.php/do/publicar/<@= #cod_objeto@>.html" title="Publicar&nbsp;<@= strip_tags(#titulo)@>">a 
      publicar</a></span><@/se@> 
      <?php if ($PERFIL <= _PERFIL_AUTOR){ ?>
      <span class="paddingLeft10">&nbsp;<a href="/index.php/manage/edit/<@= #cod_objeto@>.html"><img src="/html/imagens/ic-editar.gif" title="Editar&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a></span> 
      <@se [#temfilhos==1]@> <a href="/index.php/manage/new/<@= #cod_objeto@>.html"><img src="/html/imagens/ic-inserir.gif" title="Inserir outros objetos em&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a> 
      <@/se@> 
      <?php } ?>
    </div>
    <div style="float:left; position:relative; width:5%; border-bottom:1px #cccccc dotted; text-align:right;" class="listaTitulo1Nivel">&nbsp;</div>
  </div>
            <?php
                break;
                /********** CASE - CLASSE ->INTERLINK **********************************/
                case 2:
            ?>
                        
  <div style="position:relative; width:100%; line-height:25px;"> 
    <div style="float:left; position:relative; width:95%; border-bottom:1px #cccccc dotted;"><@iconeclasse@><a href="/index.php/content/view/<@= #endereco@>.html#ancora" title="<@= strip_tags(#titulo)@>">&nbsp;&nbsp;<@= strip_tags(#titulo)@></a> 
      <@se [#cod_status!=2]@><span class="apublicar"@>&nbsp;<a href="/index.php/do/publicar/<@= #cod_objeto@>.html" title="Publicar&nbsp;<@= strip_tags(#titulo)@>">a 
      publicar</a></span><@/se@> 
      <?php if ($PERFIL <= _PERFIL_AUTOR){ ?>
      <span class="paddingLeft10">&nbsp;<a href="/index.php/manage/edit/<@= #cod_objeto@>.html"><img src="/html/imagens/ic-editar.gif" title="Editar&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a></span> 
      <@se [#temfilhos==1]@> <a href="/index.php/manage/new/<@= #cod_objeto@>.html"><img src="/html/imagens/ic-inserir.gif" title="Inserir outros objetos em&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a> 
      <@/se@> 
      <?php } ?>
    </div>
    <div style="float:left; position:relative; width:5%; border-bottom:1px #cccccc dotted; text-align:right;" class="listaTitulo1Nivel">&nbsp;</div>
  </div>
            <?php
                break;
                /******************************** DEFAULT **********************************/
                default:
            ?>
                        
  <div style="position:relative; width:100%; line-height:25px;"> 
    <div style="float:left; position:relative; width:95%; border-bottom:1px #cccccc dotted;"><@iconeclasse@>&nbsp;<a href="<@= #url@>" title="<@= strip_tags(#titulo)@>"><@= strip_tags(#titulo)@></a> 
      <@se [#cod_status!=2]@><span class="apublicar"@>&nbsp;<a href="/index.php/do/publicar/<@= #cod_objeto@>.html" title="Publicar&nbsp;<@= strip_tags(#titulo)@>">a 
      publicar</a></span><@/se@> 
      <?php if ($PERFIL <= _PERFIL_AUTOR){ ?>
      <span class="paddingLeft10">&nbsp;<a href="/index.php/manage/edit/<@= #cod_objeto@>.html"><img src="/html/imagens/ic-editar.gif" title="Editar&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a></span> 
      <@se [#temfilhos==1]@> <a href="/index.php/manage/new/<@= #cod_objeto@>.html"><img src="/html/imagens/ic-inserir.gif" title="Inserir outros objetos em&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a> 
      <@/se@> 
      <?php } ?>
    </div>
    <div style="float:left; position:relative; width:5%; border-bottom:1px #cccccc dotted; text-align:right;" class="listaTitulo1Nivel">&nbsp;</div>
  </div>
    <?php }//FECHA SWITCH ?>
   <@se [%INDICE==%FIM]@>
   </div>
   <@/se@>
<@/localizar@>
<@naolocalizado@>
<?php 
	if($_GET['execview'] == 'listatodos_ajax'){
?>
<div style="position:relative; width:100%; line-height:22px;"> 
  <div align="center" style="font-weight:bold; float:left; position:relative; width:100%;">Não 
    há subníveis neste item. Clique no titulo para ver o conteúdo.</div>
</div>
<?php
	}
?>
<@/naolocalizado@>
</div>