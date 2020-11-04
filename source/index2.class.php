<?php

class index
{
	public $cod_objeto;
	public $contents;
	public $titulo;
	public $data_publicacao;
	public $data_validade;
	public $descricao;
	public $msg;
	public $badwords = array();
	public $host;
	public $search_info;
	public $search_result_count;
	public $indexed_words;
	public $parentesco;
	public $index;
	
	function __construct()
	{
		// criando
//		$index = Zend_Search_Lucene::create(_pastaIndice);
//		$index->commit();

		//otimizando
//		$index = Zend_Search_Lucene::open(_pastaIndice);
//		$index->optimize();
//		exit();
		
		$this->verificaIndex();
	}

	function verificaIndex()
	{
		$criado = false;
		if (!file_exists (_pastaIndice) ) {
			mkdir (_pastaIndice, 0777);
		}
		
		if ($handle = opendir(_pastaIndice)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && $file != ".svn") {
					$criado = true;
				}
			}
			closedir($handle);
		}
		
		if (!$criado) 
		{
			$index = Zend_Search_Lucene::create(_pastaIndice);
			$index->commit();
		}
	}
	
	function get_string_array(&$_page, $contents=false)
	{
		if(!$contents) $contents=$this->contents;
		setlocale(LC_ALL,'pt_BR');
		$results=array();
		$word_array=array();
		$contents=$this->clean($contents);

		if(preg_match_all('|\b([A-Z\d]{3,50})\b|is', $contents, $output))
		{
			$word_array=array_unique($output[1]);
			sort($word_array);
			$word_array=$this->strip_badwords($_page, $word_array);
		}
		return $word_array;
	}

	function clean($contents=false)
	{
		if(!$contents) $contents=$this->contents;
		$contents=strtolower(stripslashes($contents));
//		$contents=strtolower($contents);
		$chr_src='בדאדגהיטךכםלןמףעץפצתשûüחס';
		$chr_dst='aaaaaaeeeeiiiiooooouuuucn';
		for($n=0;$n<strlen($chr_src);$n++)
		{
			$contents = str_replace($chr_src[$n], $chr_dst[$n], $contents);
		}
		$contents = str_replace("&aacute;", "a", $contents);
		$contents = str_replace("&acirc;", "a", $contents);
		$contents = str_replace("&atilde;", "a", $contents);
		$contents = str_replace("&agrave;", "a", $contents);
		$contents = str_replace("&auml;", "a", $contents);
		$contents = str_replace("&aring;", "a", $contents);
		
		$contents = str_replace("&eacute;", "e", $contents);
		$contents = str_replace("&ecirc;", "e", $contents);
		$contents = str_replace("&egrave;", "e", $contents);
		$contents = str_replace("&euml;", "e", $contents);
		
		$contents = str_replace("&iacute;", "i", $contents);
		$contents = str_replace("&icirc;", "i", $contents);
		$contents = str_replace("&igrave;", "i", $contents);
		$contents = str_replace("&iuml;", "i", $contents);
		
		$contents = str_replace("&ograve;", "o", $contents);
		$contents = str_replace("&oacute;", "o", $contents);
		$contents = str_replace("&otilde;", "o", $contents);
		$contents = str_replace("&ocirc;", "o", $contents);
		$contents = str_replace("&ouml;", "o", $contents);
		
		$contents = str_replace("&ugrave;", "u", $contents);
		$contents = str_replace("&uacute;", "u", $contents);
		$contents = str_replace("&ucirc;", "u", $contents);
		$contents = str_replace("&uuml;", "u", $contents);
		
		$contents = str_replace("&ccedil;", "c", $contents);
		
		$contents = str_replace("&amp;", "&", $contents);
//		$contents = str_replace("&quot;", " ", $contents);
		$contents = str_replace("&nbsp;", " ", $contents);
		$contents = str_replace("&ordm;", " ", $contents);
		$contents = str_replace("&sect;", "§", $contents);
		$contents = str_replace("&ndash;", " ", $contents);
		$contents = str_replace("&mdash;", " ", $contents);
		$contents = str_replace('\n', ' ', $contents);
		return $contents;
	}

	function strip_badwords(&$_page, $word_array)
	{
		$output=array();
		if(count($this->badwords)==0)
		{
			$sql='select * from index_badwords order by word';
			$res = $_page->_db->ExecSQL($sql);
			$row = $res->GetRows();
			for ($j=0; $j<sizeof($row); $j++){
				$this->badwords[] = $row[$j]["word"];
			}
		}
		return array_diff($word_array, $this->badwords);
	}

	function delete_index($cod_objeto)
	{
		$index = Zend_Search_Lucene::open(_pastaIndice);
		$term = new Zend_Search_Lucene_Index_Term($cod_objeto, 'cod_objeto');
    	foreach ($index->termDocs($term) as $id)
        	$index->delete($id);
	} 

	function CreateUnlockCode(&$_page, $cod_objeto)
	{
		$campos['cod_objeto']=$cod_objeto;
		return $_page->_db->Insert('unlock_table', $campos);
	}

	function record_index(&$_page, $cod_objeto)
	{
		$this->cod_objeto=$cod_objeto;
		$this->delete_index($cod_objeto);
		
		$sql="select cod_objeto, cod_classe, titulo, descricao, data_publicacao, data_validade from objeto where cod_objeto=".$cod_objeto;
		$rs=$_page->_db->ExecSQL($sql);
		$row = $rs->fields;
		$this->contents.=$row['titulo'].' '.$row['descricao'];
		$this->titulo = $row['titulo'];
		$this->data_publicacao = $row['data_publicacao'];
		$this->data_validade = $row['data_validade'];
		$this->descricao = $row['descricao'];
		$this->cod_classe = $row['cod_classe'];
		
		$sql = "select valor from tbl_text where cod_objeto=".$cod_objeto;
		$rs=$_page->_db->ExecSQL($sql);
		$row = $rs->fields;
		for ($i=0; $i<sizeof($row); $i++){
			$this->contents.=" ".substr($row["valor"],0,5000);
		}
		
		$sql = "select valor from tbl_string where cod_objeto=".$cod_objeto;
		$rs=$_page->_db->ExecSQL($sql);
		$row = $rs->fields;
		for ($i=0; $i<sizeof($row); $i++){
			$this->contents.=" ".$row["valor"];
		}
		
		$this->parentesco = $_page->_adminobjeto->PegaCaminhoObjeto($_page, $cod_objeto).",".$cod_objeto;
		$this->parentesco = str_replace("," , " " , $this->parentesco);
		$this->parentesco = $this->intToChar($this->parentesco);
		$this->record_words($cod_objeto);
		
		return true;
	}

	function record_words($cod_objeto)
	{
		$index = Zend_Search_Lucene::open(_pastaIndice);
	
		$doc = new Zend_Search_Lucene_Document();
		$doc->addField(Zend_Search_Lucene_Field::Keyword('cod_objeto', $cod_objeto));
		$doc->addField(Zend_Search_Lucene_Field::Keyword('cod_classe', $this->clean($this->cod_classe)));
		$doc->addField(Zend_Search_Lucene_Field::Keyword('data_publicacao', $this->data_publicacao));
		$doc->addField(Zend_Search_Lucene_Field::Keyword('data_validade', $this->data_validade));
		$doc->addField(Zend_Search_Lucene_Field::UnIndexed('titulo', $this->titulo));
		$doc->addField(Zend_Search_Lucene_Field::UnIndexed('descricao', $this->descricao));
		$doc->addField(Zend_Search_Lucene_Field::Text('parentesco', $this->parentesco));
		$doc->addField(Zend_Search_Lucene_Field::UnStored('conteudo', $this->clean($this->contents)));
		
		
		// trecho do indexador em java
//		 	doc.add(Field.Keyword("cod_objeto", cod_objeto));
//			doc.add(Field.Text("cod_classe", cod_classe));
//			doc.add(Field.Text("data_publicacao", data_publicacao));
//			doc.add(Field.Text("data_validade", data_validade));
//			doc.add(Field.UnIndexed("titulo", titulo));
//			doc.add(Field.UnIndexed("descricao", descricao));
//			doc.add(Field.Text("parentesco", parentesco));
//			doc.add(Field.Text("conteudo", conteudo));

		$index->addDocument($doc);
		$index->commit();
//		$index->optimize();
	}
	
	function intToChar($num)
	{
		$num = str_replace("0", "a", $num);
		$num = str_replace("1", "b", $num);
		$num = str_replace("2", "c", $num);
		$num = str_replace("3", "d", $num);
		$num = str_replace("4", "e", $num);
		$num = str_replace("5", "f", $num);
		$num = str_replace("6", "g", $num);
		$num = str_replace("7", "h", $num);
		$num = str_replace("8", "i", $num);
		$num = str_replace("9", "j", $num);
		return $num;
	}

	function search(&$_page, $qry, $use_or, $area=-1)
	{
		$hits = null;
		$saida=array();
		$cont = 0;
		
		if (strlen(trim($qry)) > 0) {
			$query = $this->clean($qry);
//			$dat_min = "19000101000000";
//			$dat_max = "30000101000000";
//			$dat_atu = date("YmdHis");
//			$query = Zend_Search_Lucene_Search_QueryParser::parse($qry);
//			$query .= " AND (cod_objeto:11626) ";
//			$query .= "+ data_validade:{".$dat_atu." TO ".$dat_max."} ";
//			$query .= " + ((data_publicacao:[20050101000000 TO ".date("YmdHis")."]) + (data_validade:[".date("YmdHis")." TO 30000101000000])) ";
			
			if (isset($area) && $area!=-1 && !empty($area) && is_array($area)){
				$query .= " + (";
				$contt = 0;
				for ($i=0; $i<sizeof($area); $i++)
				{
					if ($contt>0) $query .= " OR ";
					$query .= "parentesco:".$this->intToChar($area[$i]);
					$contt++;
				}
				$query .= ")";
			}
			
//			$query .= " AND (data_publicacao:[18000101000000 TO ".date("YmdHis")."])";
			
//			echo $query;
//			exit();
			
			$index = Zend_Search_Lucene::open(_pastaIndice);
//			$query = new Zend_Search_Lucene_Search_Query_Boolean();
//			$query = new Zend_Search_Lucene_Search_Query_MultiTerm();
			
			
//			$query = new Zend_Search_Lucene_Search_Query_Boolean();
//
//			$subquery1 = new Zend_Search_Lucene_Search_Query_MultiTerm();
//			$subquery1->addTerm(new Zend_Search_Lucene_Index_Term($qry, 'conteudo'), true);
			
//			$from = new Zend_Search_Lucene_Index_Term(date("YmdHis"), 'data_validade');
//			$to   = new Zend_Search_Lucene_Index_Term(date("YmdHis"), 'data_publicacao');
//			$subquery2 = new Zend_Search_Lucene_Search_Query_Range(null, $to, true);
//
//			$query->addSubquery($subquery1, true);
//			$query->addSubquery($subquery2, true);
//			
			

//			$query->addTerm(new Zend_Search_Lucene_Index_Term($qry, 'conteudo'), true);
			
			
//			$query->addSubquery();

//			echo $query;
			$query = Zend_Search_Lucene_Search_QueryParser::parse($query);

			$hits  = $index->find($query);
			
//			$index = Zend_Search_Lucene::open(_pastaIndice);
//			$this->qry = Zend_Search_Lucene_Search_QueryParser::parse($query);
//			$hits = $index->find($qry);
			return $hits;
		}
		return false; 
		
		
		
//		if (count($hits)>0)
//		{
//			foreach ($hits as $hit)
//			{
//				$tmp_arr = array();
//				$tmp_arr[0] = $hit->cod_objeto;
//				$tmp_arr[1] = utf8_decode($hit->titulo);
//				$tmp_arr[2] = $hit->data_publicacao;
//				$tmp_arr[3] = "/index.php/content/view/".$hit->cod_objeto.".html";
//				$tmp_arr[4] = utf8_decode($hit->descricao);
//				$tmp_arr[5] = $hit->cod_classe;
//				$tmp_arr[6] = number_format((($hit->score)*100),1);
//				$saida[] = $tmp_arr;
//				$cont++;
//			}
//			$total = $cont;
//			$this->search_result_count = $total;
//			return $saida;
//		}
//		return false;
	}
}
?>