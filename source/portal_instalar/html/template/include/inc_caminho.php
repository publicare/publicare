<?php
    global $_page, $cod_objeto;
    if ( ($cod_objeto != 1) && ($cod_objeto != 2))
    {
?>
<div class="paddingBottom12">
  <div class="bgNeturno paddingBottom6 paddingTop6 paddingLeft10" title="voltar para">
    <strong>voltar para</strong>
    <span class="terra">
    <?php
        $excecoes = array(125,3881);
        $caminho =  $_page->_adminobjeto->PegaIDPai($_page, $cod_objeto,7, $excecoes);
        foreach ($caminho as $cod_pai => $titulo)
        {
          $escrevecaminho = '<img src="/html/imagens/site/bullet-caminho.gif" hspace="5" align="absmiddle" alt="seta ilustrativa"><a href="/index.php/content/view/'.$cod_pai.'.html">'.$titulo.'</a>'.$escrevecaminho;
        }
        $codObjetoCaminho = $cod_pai;
        if (!(in_array(('Página Inicial'), $caminho))) {
          echo '...&nbsp;';
        }
        echo $escrevecaminho;
        $pagina=$_page->_objeto->Valor($_page, "cod_pai");
    ?>
    </span>
  </div>
</div>
<?php
    }
?>
