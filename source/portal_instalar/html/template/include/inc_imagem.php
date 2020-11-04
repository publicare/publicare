<?
global $_page, $cod_objeto, $bgCor, $tags,$PERFIL,$foto;
$ct==0;
?>
<@var $tags = #tags@>
<@var $titulo = #titulo@>
<@filhos classes=['imagem'] ordem=['peso,data_publicacao'] limite=[1]@>
<@var $foto=#cod_objeto@>
    <div class="paddingBottom">
    <@usarblob nome=['conteudo']@>
        <a href="<@linkblob@>"  class="highslide" onclick="return hs.expand(this)"><img src="<@srcblob@>" width="200" alt="Clique para ver todas as fotos de&nbsp;<@= $titulo@>" title="Clique para ver todas as fotos de&nbsp;<@= strip_tags(#titulo)@>" hspace="10" vspace="5" class="bordaFoto" align="left"></a>
        <div class="highslide-heading">
            <@= #titulo@>
        </div>
    <@/usarblob@>
<?php
    if ($PERFIL <= _PERFIL_AUTOR){
?>
    <a href="/index.php/manage/edit/<@= #cod_objeto@>.html"><img src="/html/imagens/site/ic-editar.gif" title="Editar esta foto" border="0" align="absmiddle" width="16" vspace="5"></a>
    <@se [#cod_status!=2]@><span class="apublicar"@>&nbsp;<a href="/index.php/do/publicar/<@= #cod_objeto@>.html" title="Publicar&nbsp;<@= strip_tags(#titulo)@>">a publicar</a></span><@/se@></a>
    </div>
<?php
    }
?>
<@/filhos@>
