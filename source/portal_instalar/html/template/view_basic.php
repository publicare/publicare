<script type="text/javascript" src="/html/javascript/highslide/highslide-with-gallery.js"></script>
<@incluir arquivo=["/html/template/include/inc_highside_galery.php"]@>
<link rel="stylesheet" href="/html/css/highslide.css" type="text/css" />
<!-- === T�tulo === -->
			<@incluir arquivo=['/html/template/include/inc_titulo.php']@>
            <!-- Final ======== -->
            <!-- === T�tulo === -->
            <!-- ============ -->
			
            <!-- === Texo === -->
            <div class="paddingBottom15">
				<@incluir arquivo=['/html/template/include/inc_imagem.php']@>
				<@= #texto@>
			</div>
            <!-- Final ====== -->
            <!-- === Texo === -->
            <!-- ================ -->
			
			<!-- ======== lista todos os filhos imagem do objeto =========== -->
			<@incluir arquivo=['/html/template/include/inc_filhosImagens.php']@>
			
            <!-- === Listagem === -->
			<@incluir arquivo=['/html/template/view_listatodos_ajax.php']@>
            <!-- Final ========== -->
            <!-- === Listagem === -->
            <!-- =========================================================== -->
			
            <!-- === Rodape === -->
			<@incluir arquivo=['/html/template/include/inc_rodape.php']@>
            <!-- Final ========== -->
            <!-- === Rodape === -->
            <!-- =========================================================== -->