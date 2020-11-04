<?
include('../../../publicare.conf');
include_once ("iniciar.php");
	
    if (trim(strtolower($_page->_objeto->metadados["classe"])) == "rss")
{

	$criar = 0;
	$conteudo = "";

	// se o xml nao existir aponmta flag para criacao
	if (!file_exists(_pastaRss."rss_".$cod_objeto.".xml")) $criar = 1;
	// se existir verifica data de modificacao,
	// caso passe o tempo de cache, aponta flag para criação
	else
	{
		$modif = (filemtime(_pastaRss."rss_".$cod_objeto.".xml") + _tempoRss);
		$atual = strtotime("+ 0 minutes");
		if ($modif < $atual) $criar = 1;
	}

	// criando arquivo se flag estiver indicando criacao
	if ($criar == 1)
	{
//		echo "criando arquivo";
		$cod_pai = $_page->_objeto->Valor($_page, "codigo_pai");
		$classes = $_page->_objeto->Valor($_page, "classes");
		$quantidade = $_page->_objeto->Valor($_page, "quantidade");
		$titulo = $_page->_objeto->Valor($_page, "titulo");
		$descricao = $_page->_objeto->Valor($_page, "descricao");
		$categoria = $_page->_objeto->Valor($_page, "categoria");

		$_page->_rss->__set("title", $titulo);
		$_page->_rss->__set("description", $descricao);
		$_page->_rss->__set("link", _URL."/html/objects/_viewrss.php?cod_objeto=".$cod_objeto);
		$_page->_rss->__set("categoria", $categoria);
		$_page->_rss->__set("copyright", $PORTAL_NAME);

		$objs = $_page->_adminobjeto->LocalizarObjetos($_page, $classes, '', '-data_publicacao', -1, $quantidade, $cod_pai);
		if ($objs){
			$cont = 0;
			foreach ($objs as $obj)
			{
				$sql = "SELECT t2.cod_blob,
   				t2.arquivo
				FROM objeto t1
	  			INNER JOIN tbl_blob t2 ON t1.cod_objeto = t2.cod_objeto
				WHERE 1=1
				AND t1.cod_pai = ".$obj->metadados["cod_objeto"]."
	 			AND t1.cod_classe = 15
	 			AND (t1.apagado = 0)
	 			AND (t1.cod_status = 2)
	 			AND (t1.data_publicacao <= ".date("YmdHis").")
	 			AND (t1.data_validade >= ".date("YmdHis").")
				order by t1.cod_objeto asc";
				$rs2 = $_page->_db->ExecSQL($sql, 1);
				if (!$rs2->EOF)
				{
					$line = $rs2->FetchRow();
					$cod_blob = $line["cod_blob"];
					$vext_blob = explode(".", $line["arquivo"]);
					$ext_blob = $vext_blob[count($vext_blob)-1];
					$obj->metadados["descricao"] = "<img src=\""._URL."/upd_thumb/".$cod_blob.".".$ext_blob."\" border=\"0\" align=\"left\" /> ".$obj->metadados["descricao"];
				}
				$_page->_rss->addItem($obj->metadados["titulo"], cortaTexto($obj->metadados["descricao"],500), _URL."/index.php/content/view/".$obj->metadados["cod_objeto"].".html", $obj->metadados["data_publicacao"]);
				$cont++;
			}
		}

		$file = fopen(_pastaRss."rss_".$cod_objeto.".xml", "w");
		$conteudo = "<?xml version=\"1.0\" encoding=\"".$_page->_rss->__get("encoding")."\" ?>\n";
		$conteudo .= $_page->_rss->showRSS();
		fwrite($file, $conteudo);
		fclose($file);
	}
	// senao, apenas le conteudo do arquivo
	else
	{
//		echo "lendo arquivo";
		$file = fopen(_pastaRss."rss_".$cod_objeto.".xml", "r");
		$conteudo = fread($file, filesize(_pastaRss."rss_".$cod_objeto.".xml"));
		fclose($file);
	}

//	exit();
	echo $conteudo;
}
else
{
	echo "Objeto informado n&atilde;o &eacute; um RSS"; 
}
	
?>
