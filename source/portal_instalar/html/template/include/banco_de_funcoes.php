<?php
    global $_page,$cod_objeto;

    function pegaUltimoParentescoComMenuProprio($_page,$cod_objeto)
    {
        $arrParentesco = explode(",", $_page->_adminobjeto->RecursivaCaminhoObjeto($_page, $cod_objeto));

        $return = 1;
        foreach($arrParentesco as $objeto){
            $aux = $_page->_adminobjeto->PegaPropriedades($_page, $objeto);

            if($aux['menu_proprio']['valor'] == 1){
                $return = $objeto;
            }
        }
        return $return;
    }

    /* MONTA O MENU HORIZONTAL E DECIDE SE ESTA SELECIONADO OU NAO
     * COMPARA A VARIAVEL $cod, PASSADA COMO ARGUMENTO DA FUNCAO, COM O $cod_objeto DA PAGINA ATUAL
     * SE OS CODIGOS FOREM IGUAIS, RETORNA O MENU SELECIONADO, SENAO, RETORNA UM MENU NORMAL
     */
    function verificaMenuHrzSelecionado($titulo, $cod, $view="")
    {
        global $_page, $cod_objeto, $_GET;

        $arrParentesco = explode(",", $_page->_adminobjeto->RecursivaCaminhoObjeto($_page, $cod_objeto));

        if( ( !in_array($cod, $arrParentesco) && $cod_objeto == $cod ) || ( in_array($cod, $arrParentesco) && $cod_objeto != $cod ) )
        {
            return '
                    <td align="center" class="menuHrzSelect linkMenuHrz">
                    <div class="menuHrzLeftSelect">
                    <div class="menuHrzRightSelect">
                    <div class="paddingMenuHrz">
                    <a href="/index.php/content/view/'.$cod.'.html?execview='.$view.'" title="'.$titulo.'">'.$titulo.'</a>
                    </div>
                    </div>
                    </div>
                    </td>
                    ';
        }else{
            return '
                    <td align="center" class="menuHrz linkMenuHrz">
                    <div class="menuHrzLeft">
                    <div class="menuHrzRight">
                    <div class="paddingMenuHrz">
                    <a href="/index.php/content/view/'.$cod.'.html?execview='.$view.'" title="'.$titulo.'">'.$titulo.'</a>
                    </div>
                    </div>
                    </div>
                    </td>
                    ';
        }
    }

    /* MONTA O MENU HORIZONTAL E DECIDE SE ESTA SELECIONADO OU NAO
     * COMPARA A VARIAVEL $cod, PASSADA COMO ARGUMENTO DA FUNCAO, COM O $cod_objeto DA PAGINA ATUAL
     * SE OS CODIGOS FOREM IGUAIS, RETORNA O MENU SELECIONADO, SENAO, RETORNA UM MENU NORMAL
     */
    function verificaMenuHrzSelecionadoAcessivel($titulo, $cod)
    {
        global $_page, $cod_objeto;

        $arrParentesco = explode(",", $_page->_adminobjeto->RecursivaCaminhoObjeto($_page, $cod_objeto));

        if( ( !in_array($cod, $arrParentesco) && $cod_objeto == $cod ) || ( in_array($cod, $arrParentesco) && $cod_objeto != $cod ) )
        {
            return '
                    <td align="center" class="menuHrzSelect linkMenuHrz"><a href="/index.php/content/view/'.$cod.'.html" title="'.$titulo.'">'.$titulo.'</a></td>
                    ';
        }else{
            return '
                    <td align="center" class="menuHrz linkMenuHrz"><a href="/index.php/content/view/'.$cod.'.html" title="'.$titulo.'">'.$titulo.'</a></td>
                    ';
        }
    }
	
	/*FUNÇÃO ÚTIL PARA DEBUG*/
	function xd($obj)
	{
		echo "<div style='background-color:#DFDFDF; border:1px #666666 solid'>";
			echo "<pre>";
				print_r($obj);
				die();
			echo "</pre>";
		echo "</div>";
	}
	
	/*FUNÇÃO ÚTIL PARA DEBUG QUE NÃO INCLUI O DIE*/
	function x($obj)
	{
		echo "<div style='background-color:#DFDFDF; border:1px #666666 solid'>";
			echo "<pre>";
				print_r($obj);
			echo "</pre>";
		echo "</div>";
	}

   /**
    * Trata retira caracteres que não interessam ao parâmetro
    * @author Marcos Rodrigo Ribeiro
    * @param  $strParametro - parametro informado
    * @return string
    */
    function limparParametro($strParametro)
	{
		$strParametro = str_replace(".","",$strParametro);
		$strParametro = str_replace("/","",$strParametro);
		$strParametro = str_replace("-","",$strParametro);
		$strParametro = str_replace(",","",$strParametro);
		$strParametro = str_replace("(","",$strParametro);
		$strParametro = str_replace(")","",$strParametro);
		
		return ($strParametro);
	}
   
   /**
    * Prepara o nome do arquivo enviado para upload para ser gravado no banco
    * @author Marcos Rodrigo Ribeiro
    * @param  $strNomeArquivo - nome do arquivo
    * @return string
    */
    function limparAcento($strNomeArquivo)
	{
		//retira acentos e substitui espaço em branco por underscores
		$arr1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
		$arr2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");
		$strNomeArquivoAlterado = str_replace( $arr1, $arr2, $strNomeArquivo );					    
		
		//transformas as letras em minúsulas
		$strNomeArquivoAlterado = strtolower($strNomeArquivoAlterado); 
		
		return $strNomeArquivoAlterado;

	}
   
   /**
    * Resume o texto na quantidade de caracteres enviados à função
    * @author Marcos Rodrigo Ribeiro
    * @param  $strTexto - texto a ser cortado
    * @param  $strLimite - tamanho máximo de caracteres que deseja mostrar do texto
    * @return string
    */
    function limitarTamanhoTexto($strTexto, $strLimite)
	{
	    // Se o texto for maior que o limite, ele corta o texto e adiciona 3 pontinhos.
	    if (strlen($strTexto) > $strLimite)
	    {
	        $strTexto = substr($strTexto, 0, $strLimite);
	        $strTexto = trim($strTexto) . "...";
	    }
		
		return $strTexto;

	}

   function trataTags($conteudo)
   {
     //retira acentos e substitui espaço em branco por underscores
     $arr1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
     $arr2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");
     
     $strNomeArquivoAlterado = str_replace( $arr1, $arr2, $conteudo );//transformas as letras em minúsulas
     
     $strNomeArquivoAlterado = strtolower($strNomeArquivoAlterado);
     
     if(substr($strNomeArquivoAlterado, strlen($strNomeArquivoAlterado)-1) == ',')
     {
     	$strNomeArquivoAlterado = substr($strNomeArquivoAlterado, 0, strlen($strNomeArquivoAlterado)-1 );
   	 }
     
   	 return $strNomeArquivoAlterado;
   }
	
?>
