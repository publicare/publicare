<? global $texto; ?>
<table width="100%" align="center" cellpadding="0">
	<tr>
	
	<!-- destaques -->
		<td valign="top" align="right">
	<? //lista todos seus filhos Link,Interlink ?>
	<@se [#menu_proprio!=1]@>
		<@incluir arquivo=["/html/template/inc_veja_conteudo.pbl"]@>
	<@/se@>
		
	
		</td>
		
		<@se [$escreve_linha==1]@>
		<td background="/html/imagens/pixel-vert.jpg">&nbsp;&nbsp;</td>
		<@/se@>
	<!-- Final Destaques -->
		
		<td valign="top" width="100%">
			<span id="titulo"><@= #titulo@>
			<@se [#cod_status!='2']@>
				<span class="aPublicar">&nbsp;-&nbsp;a publicar</span>
			<@/se@></span><br>
			<table border="0" width="100%" cellpadding="2" cellspacing="2">
				<tr>
					<td valign="top" id="texto">
					<@localizar classes=["rss"] pai=[1] @>
						<a href="/html/objects/_viewrss.php?cod_objeto=<@= #cod_objeto@>"><@= #titulo@></a><br>
					<@/localizar@>
					</td>
				</tr>
			</table>
			
			
			<!-- Opção de impressao -->
			<@incluir arquivo=["/html/template/inc_impressao.pbl"]@>
			
		</td>
	</tr>
</table>