<?
global $_page, $cod_objeto, $bgCor, $tags,$PERFIL,$foto;
$ct=0;
if (empty($foto) || $foto=="") $foto=0;
?>
<@var $tags = #tags@>
<@var $titulo = #titulo@>
<@localizar classes=['imagem'] pai=[$cod_objeto] niveis=[0] ordem=['peso,data_publicacao'] condicao=['cod_objeto <> '.$foto]@>
    <@se [%INDICE==1]@>
    <div class="paddingTop10">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td class="vejaTambem" title="Outras Imagens">Outras Imagens</td>
			</tr>
			<tr>
				<td class="paddingLeft10 paddingRight10 paddingTop paddingBottom bgJupter">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <@/se@>
<?php 
					if ($ct%4==0) {
?>
						<tr>
<?php
					}
?>
					        <@usarblob nome=['conteudo']@>
					            <? 
					                if (file_exists($_SERVER['DOCUMENT_ROOT'].$_OBJ_->LinkBlob($_page, conteudo)))
					                {
					                    $tmpCaminhoImagem = $_SERVER['DOCUMENT_ROOT'].$_OBJ_->LinkBlob($_page, conteudo);	
					                }
					                $tmpTamanho = getimagesize($tmpCaminhoImagem);
					                $tmpLargura = $tmpTamanho[0];
					                if ($tmpLargura>200)
					                {
					                    $tmpLargura = 200;
					                }
					            ?>
					            <td align="center">
					            <a href="<@linkblob@>"  class="highslide" onclick="return hs.expand(this)"><img src="<@srcthumb@>" width="100" alt="<@= #titulo@>" title="Clique para ampliar" vspace="10"/></a>
					            <div class="highslide-heading">
					                <@= #titulo@>
					            </div>
<?php
// === verifica se o usuario está logado e insere o icone de editar objeto===
								if ($PERFIL <= _PERFIL_AUTOR)
								{
?>
								<div class="paddingLeft10" align="center">
								&nbsp;<a href="/index.php/manage/edit/<@= #cod_objeto@>.html"><img src="/html/imagens/site/ic-editar.gif" title="Editar&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a>
								</div>
<?php
								}
?>
								<@se [#cod_status!=2]@><div class="apublicar" align="center">&nbsp;<a href="/index.php/do/publicar/<@= #cod_objeto@>.html" title="Publicar&nbsp;<@= strip_tags(#titulo)@>">a publicar</a></div><@/se@></a>
					            </td>
					        <@/usarblob@>
<?php 
					if ($ct%4==3) {
?>
						</tr>
<?php
					}
					$ct++;
?>
    <@se [%INDICE==%FIM]@>
    				</table>
				</td>
			</tr>
		</table>
	</div>
    <@/se@>
<@/localizar@>
