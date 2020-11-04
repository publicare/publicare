<@filhos classes=['Tradução'] ordem=['peso,titulo']@>
    	<@se [%INDICE==1]@>
    	<div class="paddingBottom5" align="right">		
    	<@/se@>
    	<@var $link=#link@>
    	<@var $idioma=#idioma@>
    	<@localizar classes=['Idiomas'] condicao=['titulo='.$idioma]@>
	      	<@usarblob nome=["bandeira"]@>
				<a href="/index.php/content/view/<@= $link@>.html"><img src="<@linkblob@>" vspace="3" hspace="3" width="25" border="0" title="<@= strip_tags(#titulo)@>" alt="<@= strip_tags(#titulo)@>"></a>&nbsp;
			<@/usarblob@>
    	<@/localizar@>
	    <@se [%INDICE==%FIM]@>
    	</div>			
    	<@/se@>
 <@/filhos@>



<!-- =========================================== -->
<!-- ======== ( Título do conteúdo ) =========== -->
<!-- === Include contendo o titulo do objeto === -->

<div class="paddingBottom15">
	<div class="tituloConteudo" title="Título da página:<@= ' '.strip_tags(#titulo)@>">
		<@= strip_tags(#titulo)@>
<!-- ======== Verifica se o objeto está publicado =========== -->
		<@se [#cod_status!=2]@>
			<span class="apublicar beta bold">&nbsp;-&nbsp;<a href="/index.php/do/publicar/<@= #cod_objeto@>.html" title="Publicar&nbsp;<@= strip_tags(#titulo)@>">a publicar</a></span>
		<@/se@>
<?php
global $PERFIL;
// === verifica se o usuario está logado ===
		if ($PERFIL <= _PERFIL_AUTOR)
		{
?>
			<span class="paddingLeft10">&nbsp;<a href="/index.php/manage/edit/<@= #cod_objeto@>.html"><img src="/html/imagens/site/ic-editar.gif" title="Editar&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a>
			<@se [#temfilhos==1]@>
				&nbsp;<a href="/index.php/manage/new/<@= #cod_objeto@>.html"><img src="/html/imagens/site/ic-inserir.gif" title="Inserir outros objetos em&nbsp;<@= strip_tags(#titulo)@>" border="0" align="absmiddle"></a>
			<@/se@>
			</span>
<?php
		}
?>
	</div>
</div>
		
<!-- ==== Final ======================== -->
<!-- ==== ( Título do conteúdo ) ======= -->
