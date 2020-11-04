<?php

class AdminObjeto
{
	
	public $index;
	
	function CondicaoPublicado(&$_page)
	{
		return " and ".$_page->_db->nomes_tabelas["objeto"].".cod_status="._STATUS_PUBLICADO;
	}

	function CondicaoAutor(&$_page)
	{
		return " and ((".$_page->_db->nomes_tabelas["objeto"].".cod_status="._STATUS_PUBLICADO.$this->CondicaoData($_page).")
					 or ".$_page->_db->nomes_tabelas["objeto"].".cod_usuario=".$_SESSION['usuario']['cod_usuario'].')';
	}

	function CondicaoData(&$_page)
	{
		return " and (".$_page->_db->nomes_tabelas["objeto"].".data_publicacao<=".date("YmdHis")." and ".$_page->_db->nomes_tabelas["objeto"].".data_validade>=".date("YmdHis").")";
	}

	function Search(&$_page, $query, $use_or=0, $area=-1, $paginacao=20)
	{
		if ((isset($query) && strlen($query)>1)){
			$query = addslashes($query);
		
			include_once('index2.class.php');
	
			$this->index = new index();
			return $this->index->search($_page, $query, $use_or, $area);
			
//			if($resultado = )
//			{
//				echo count($resultado);
//				exit();
//				$_SESSION["cod_search"] = $cod_search;
//				$_SESSION["search_result_count"] = $index->search_result_count;
//				$_SESSION["paginacao"] = $paginacao;
//			} 
//			else {
//				return false;
//			}
		} 
	}

	function SearchPageMenu($cod_page=1, $font='', $page_size=0,$link='/index.php?action=/html/objects/search_result')
	{
		
		$page_size=$_SESSION["paginacao"];
		if(isset($_SESSION["cod_search"]) && is_array($_SESSION["cod_search"]) && sizeof($_SESSION["cod_search"])>0)
		{
			$output.= ' | ';
			for($n=1;$n<=ceil($_SESSION["search_result_count"]/$page_size);$n++)
			{
				if($n==$cod_page)
				{
					$output.= '<font '.$font.'><U><B>'.$n.'</B></U></font>';
				}
				else
				{
					$output.= '<A '.$font.' HREF="'.$link.'&search_page='.$n.'">'.$n.'</a>';
				}
				$output.= ' | ';
			}
		}
		return $output;
	}

	function SearchList(&$_page, $cod_page=1)
	{
		GLOBAL $session_cod_search;
		GLOBAL $session_paginacao;

		$output=array();
		if($session_cod_search>0)
		{
			$sql="select busca_rs.cod_objeto from busca_rs";
			$sql .= " inner join objeto on busca_rs.cod_objeto=objeto.cod_objeto";
		 	$sql .= " where cod_busca=".$session_cod_search." order by objeto.titulo";

			$rs=$this->db->ExecSQL($sql,(($cod_page-1) * $session_paginacao),$session_paginacao);
			while ($row=$this->db->FetchArray($rs))
			{
				//echo "incluindo ".$row['cod_objeto'].'<br>';
				$output[$row['cod_objeto']]=$this->ShowObjectResume($row['cod_objeto']);
			}
		}
		return $output;
	}

	function PegaTags(&$_page, $cod_objeto)
	{
		$tags = "";
		$sql = "select nome_tag from tag t1 inner join tagxobjeto t2 on t1.cod_tag=t2.cod_tag where t2.cod_objeto=".$cod_objeto;
		$rs = $_page->_db->ExecSQL($sql);
                if ($rs->_numOfRows>0)
                {
                  while ($row = $rs->FetchRow())
                  {
                      if (strlen($row["nome_tag"])>=3)
                      {
			$tags .= ", ".$row["nome_tag"];
                      }
                  }
                }
		if (strlen($tags)>=3) $tags = trim(substr($tags, 1));
		return $tags;
	}
	
	function PegaDadosObjetoPeloTitulo(&$_page, $titulo)
	{
			$sql = $_page->_db->sqlobj." where ".$_page->_db->nomes_tabelas["objeto"].".titulo = '$titulo'";
			$rs = $_page->_db->ExecSQL($sql);
			$dados = $rs->fields;
			return $dados;
	}

	function PegaDadosObjetoPeloID(&$_page, $cod_objeto)
	{
		if (is_numeric($cod_objeto))
		{
			$sql = $_page->_db->sqlobj." where ".$_page->_db->nomes_tabelas["objeto"].".cod_objeto=".$cod_objeto;
			$rs = $_page->_db->ExecSQL($sql);
			$dados = $rs->fields;
			return $dados;
		}
		return false;
	}

	function CriarObjeto(&$_page, $cod_objeto)
	{
		$objeto = new Objeto($_page, $cod_objeto);
		return $objeto;
	}

	function PegaCaminhoObjeto(&$_page, $cod_objeto)
	{
		$result='';
		$result = $this->RecursivaCaminhoObjeto($_page, $cod_objeto);
		return $result;
	}

	function RecursivaCaminhoObjeto(&$_page, $cod_objeto)
	{
		$result = "";
		$sql = "select cod_pai 
		from parentesco 
		where cod_objeto=".$cod_objeto." 
		order by ordem desc";
		$rs = $_page->_db->ExecSQL($sql);
		
		if ($rs->_numOfRows>0){
			while (!$rs->EOF)
			{
				$result[]=$rs->fields['cod_pai'];
				$rs->MoveNext();
			}
			return implode (',',$result);
		} else {
			return _ROOT;
		}
	}

	function PegaCaminhoObjetoComTitulo(&$_page, $cod_objeto)
	{
	 	$result=array();
				
		$sql = "select
		".$_page->_db->nomes_tabelas["parentesco"].".ordem,
		".$_page->_db->nomes_tabelas["objeto"].".cod_objeto,
		".$_page->_db->nomes_tabelas["objeto"].".titulo
		from objeto ".$_page->_db->nomes_tabelas["objeto"]." 
		inner join parentesco ".$_page->_db->nomes_tabelas["parentesco"]." on ".$_page->_db->nomes_tabelas["objeto"].".cod_objeto=".$_page->_db->nomes_tabelas["parentesco"].".cod_pai
		where ".$_page->_db->nomes_tabelas["parentesco"].".cod_objeto=$cod_objeto
		group by ".$_page->_db->nomes_tabelas["parentesco"].".ordem, 
		".$_page->_db->nomes_tabelas["objeto"].".cod_objeto, ".$_page->_db->nomes_tabelas["objeto"].".titulo
		order by ".$_page->_db->nomes_tabelas["parentesco"].".ordem desc";
		
		$res = $_page->_db->ExecSQL($sql);
		$row = $res->GetRows();
//		echo $sql;
		for ($i=0; $i<sizeof($row); $i++)
		{
			$result[]= array('cod_objeto'=>$row[$i]['cod_objeto'],'titulo'=>$row[$i]['titulo']);
		}
		
		return $result;
	}

	function PegaPropriedades(&$_page, $cod_objeto)
	{
		$result=array();
		$sql = "select ".$_page->_db->nomes_tabelas["propriedade"].".cod_tipodado, 
			".$_page->_db->nomes_tabelas["propriedade"].".cod_propriedade,
			".$_page->_db->nomes_tabelas["propriedade"].".nome,
			".$_page->_db->nomes_tabelas["tipodado"].".tabela, 
			".$_page->_db->nomes_tabelas["tipodado"].".nome as tipodado,
			".$_page->_db->nomes_tabelas["propriedade"].".cod_referencia_classe, 
			".$_page->_db->nomes_tabelas["propriedade"].".campo_ref
			from objeto ".$_page->_db->nomes_tabelas["objeto"]." 
			inner join propriedade ".$_page->_db->nomes_tabelas["propriedade"]." on ".$_page->_db->nomes_tabelas["propriedade"].".cod_classe = ".$_page->_db->nomes_tabelas["objeto"].".cod_classe
			inner join tipodado ".$_page->_db->nomes_tabelas["tipodado"]." on ".$_page->_db->nomes_tabelas["propriedade"].".cod_tipodado=".$_page->_db->nomes_tabelas["tipodado"].".cod_tipodado 
			where cod_objeto=".$cod_objeto;
		
		$res = $_page->_db->ExecSQL($sql);
		$join=array();
		$campos=array();
		$tipo=array();
		//Primeiro SQL
//		echo "<pre>";
//		echo "1ï¿½ SQL >>".$sql."<BR><BR>";
//		echo "</pre>";
		$row = $res->GetRows();
		
		for ($i=0; $i<sizeof($row); $i++)
		{
		 	if (($row[$i]["tabela"]=="tbl_objref") && (!$this->EMetadado($_page, $row[$i]["campo_ref"])))
			{
					$sql="select ".$_page->_db->nomes_tabelas["objeto"].".cod_objeto 
						from tbl_objref ".$_page->_db->nomes_tabelas["tbl_objref"]."
						inner join objeto ".$_page->_db->nomes_tabelas["objeto"]." on ".$_page->_db->nomes_tabelas["objeto"].".cod_objeto=".$_page->_db->nomes_tabelas["tbl_objref"].".valor
						where ".$_page->_db->nomes_tabelas["tbl_objref"].".cod_propriedade=".$row[$i]["cod_propriedade"]." 
						and ".$_page->_db->nomes_tabelas["tbl_objref"].".cod_objeto=".$cod_objeto;
				$res2 = $_page->_db->ExecSQL($sql);
				$propriedade = $res2->fields;
				if ($propriedade["cod_objeto"])
					$dados = $this->PegaPropriedades($_page, $propriedade["cod_objeto"]);
				$row[$i]["valor_saida"]=$dados[strtolower($row[$i]["campo_ref"])];
			}
			$props[]=$row[$i];
		}
		
		if (isset($props) && is_array($props))
		{
			foreach ($props as $row)
			{
				$result[$row['nome']]['tipo']=$row['tabela'];
				$tabela='tbl_'.$row['nome'];
				$array_nomes[]=$row['nome'];
				
				switch ($row['tabela'])
				{
					case 'tbl_objref':
						if ($this->EMetadado($_page, $row['campo_ref']))
						{
	                        $tipo[]='ref';
							$join[]=" left join tbl_objref as ".$tabela." on (".$tabela.".cod_propriedade = ". $row['cod_propriedade'].
									" and ".$tabela.".cod_objeto=".$_page->_db->nomes_tabelas["objeto"].".cod_objeto) ";
							$join[]=" left join objeto as ".$tabela."_objeto on (".$tabela.".valor=".$tabela."_objeto.cod_objeto)";
							$campos[]=$tabela."_objeto.".$row['campo_ref']." as ".$row['nome'];
							$campos[]=$tabela."_objeto.cod_objeto as ".$row['nome']."_referencia";
						}
						else
						{
							$tipo[]='ref_prop';
	                        $campos[]="'".$row['valor_saida']."' as ".$row['nome'];
							$campos[]=$row['valor']." as ".$row['nome']."_referencia";
						}
					break;

					case 'tbl_blob':
						$tipo[]='blob';
						$join[]=" left join tbl_blob as ".$tabela." on (".$tabela.".cod_propriedade = ". $row['cod_propriedade'].
								" and ".$tabela.".cod_objeto=".$_page->_db->nomes_tabelas["objeto"].".cod_objeto) ";
						$campos[]=$tabela.".cod_blob as ".$row['nome']."_cod_blob";
	   					$campos[]=$tabela.".arquivo as ".$row['nome']."_arquivo";
	   					$campos[]=$tabela.".tamanho as ".$row['nome']."_tamanho";
					break;

					case 'tbl_date':
						$tipo[]='date';
						$join[]=" left join tbl_date as ".$tabela." on (".$tabela.".cod_propriedade=".$row['cod_propriedade'].
						        " and ".$tabela.".cod_objeto=".$_page->_db->nomes_tabelas["objeto"].".cod_objeto)";
						$campos[]=$tabela.".valor as ".$row['nome'];
					break;
					default:
						$tipo[]='default';
						$join[]=" left join ".$row['tabela']." as ".$tabela." on (".$tabela.".cod_propriedade=".$row['cod_propriedade'].
						        " and ".$tabela.".cod_objeto=".$_page->_db->nomes_tabelas["objeto"].".cod_objeto )";
						$campos[]=$tabela.".valor as ".$row['nome'];
					break;
				}
			}
			
//			echo "<pre>";
//			print_r($join);
//			print_r($campos);
			
			$sql = "select ".implode(',',$campos)." from objeto ".$_page->_db->nomes_tabelas["objeto"]." ".implode(' ',$join)." where ".$_page->_db->nomes_tabelas["objeto"].".cod_objeto=".$cod_objeto;
//			echo "TERCEIRO SQL ".$sql."<BR><BR>";
//			exit();
			$res=$_page->_db->ExecSQL($sql);
			if($dados=$res->fields)
			{
				foreach ($tipo as $key=>$value)
				{
					switch ($value)
					{
						case 'ref':
						case 'ref_prop':
							$result[$array_nomes[$key]]['valor']=$dados[$array_nomes[$key]];
							$result[$array_nomes[$key]]['referencia']=$dados[$array_nomes[$key].'_referencia'];
							break;
						case 'blob':
                            $result[$array_nomes[$key]]['valor']=$dados[$array_nomes[$key].'_arquivo'];
							$result[$array_nomes[$key]]['cod_blob']=$dados[$array_nomes[$key].'_cod_blob'];
							$result[$array_nomes[$key]]['tamanho_blob']=$dados[$array_nomes[$key].'_tamanho'];
							$result[$array_nomes[$key]]['tipo_blob']=preg_replace('/\A.*?\./is','',$dados[$array_nomes[$key].'_arquivo']);
							break;
						case 'date':
							$result[$array_nomes[$key]]['valor']=ConverteData($dados[$array_nomes[$key]],5);
							break;
						default:
                            $result[$array_nomes[$key]]['valor']=$dados[$array_nomes[$key]];
					}
				}
//				print_r($result);
//				print_r($array_nomes);
			}
		}
		return $result;
	}

	function ListaFilhos(&$_page, $cod_objeto, $classe='*', $ordem='', $inicio=-1, $limite=-1)
	{
		return $this->LocalizarObjetos($_page, $classe, '', $ordem, $inicio, $limite, $cod_objeto, 0);
	}

	function ListaCodFilhos(&$_page, $cod_objeto)
	{
		$sql = "select cod_objeto from parentesco where cod_pai = ".$cod_objeto;
		$res = $_page->_db->ExecSQL($sql);
		while ($row = $res->FetchRow())
		{
			$result[]=$row['cod_objeto'];
		}
		return $result;
	}

	function CriaInfoTeste(&$_page, $str)
	{
		$result=array();
		if ($str=='') return $result;
		while (preg_match ("%(.*?)(&&|\|\|)(.*)%",$str,$passo_um))
		{
			$str = $passo_um[3];
			$array_exp[]=$passo_um[1];
			$array_exp[]=$passo_um[2];
		}
		$array_exp[]=$str;
		foreach ($array_exp as $exp)
		{

			/* MUDEI - INCLUI O LIKE E O % PARA LIBERAÇÃO COMO CARACTER VÁLIDO DENTRO DA CONDIÇÃO  - RODRIGO 20/03/2009 */
			if (preg_match("%(.+?)(>=|<=|<>|=|<|>|LIKE|\%)(.+)%is",$exp,$passo_dois))
			{
				$passo_dois[1] = trim ($passo_dois[1]);
				$passo_dois[2] = trim ($passo_dois[2]);
				$passo_dois[3] = trim ($passo_dois[3]);
				if ($this->EMetadado($_page, $passo_dois[1]))
				{
					if ($passo_dois[1]=='data_publicacao' || $passo_dois[1]=='data_validade')
					{
						$passo_dois[1]=$_page->_db->Day($_page->_db->nomes_tabelas["objeto"].'.'.$passo_dois[1]);
						$passo_dois[3]=ConverteData($passo_dois[3],16);
					}
					$passo_dois[1] = $_page->_db->nomes_tabelas["objeto"].'.'.$passo_dois[1];
				}
				if (preg_match("/\d{1,2}\/\d{1,2}\/\d{2,4}/",$passo_dois[3]))
                {
					$passo_dois[3] = ConverteData($passo_dois[3],16);
                }

				$result[]=array($passo_dois[1],$passo_dois[2],$passo_dois[3]);
			}
			else
			{
				switch ($exp)
				{
					case "&&":
					$result[]="AND";
					break;
					case "||":
					$result[]="OR";
					break;
					default:
					$_page->AdicionarAviso("Operador ".$exp." desconhecido.",true);
				}
			}
		}
		return $result;
	}

	function EMetadado(&$_page, $teste)
	{
		if (strpos($teste,'.'))
		{
			$teste = substr($teste,strpos($teste,'.')+1);
		}
		if (in_array($teste,$_page->_db->metadados)) return true;
		
		if (strpos($teste,'objeto.') || strpos($teste,$_page->_db->nomes_tabelas['objeto'].".")) return true;
		return false;
	}

	function LocalizarObjetos(&$_page, $classe, $qry, $ordem='', $inicio=-1, $limite=-1, $pai=-1, $niveis=-1, $apagados=false, $likeas='', $likenocase='', $tags='')
	{
		if (!isset($classe) || $classe==null || $classe=='') {
			return false;
		}
		
		$array_qry = $this->CriaInfoTeste($_page, $qry);
		$pai_join = $this->CriaSQLPais($_page, $pai, $niveis);
		$usuario_where = $this->CriaCondicaoUsuario($_page);
		$tags_join = "";
		$tags_where = "";
		$tags_temp = "";

		if ($tags!="")
		{
			$array_tags = split(",",$tags);
			$tags_join .= " inner join tagxobjeto ".$_page->_db->nomes_tabelas['tagxobjeto']." on ".$_page->_db->nomes_tabelas['objeto'].".cod_objeto=".$_page->_db->nomes_tabelas['tagxobjeto'].".cod_objeto 
			inner join tag ".$_page->_db->nomes_tabelas['tag']." on ".$_page->_db->nomes_tabelas['tagxobjeto'].".cod_tag=".$_page->_db->nomes_tabelas['tag'].".cod_tag ";
			$tags_where .= " and (";
			foreach ($array_tags as $tag)
			{
				$tags_temp .= " or ".$_page->_db->nomes_tabelas['tag'].".nome_tag='".trim($tag)."'";
			}
			$tags_where .= substr($tags_temp, 3);
			$tags_where .= ")";
//			var_dump($pai_join);
		}
		
		if (!$apagados)
			$apagado_where = " and (".$_page->_db->nomes_tabelas['objeto'].".apagado<>1)";

		$cod_classe_array=array();

		if ($ordem=='')
		{
			$ordem = array('peso');
		}
		else
		{
			if (!is_array($ordem))
			$ordem = explode (",",$ordem);
		}

		if(!$likeas=='')
		{
			$like_as = " and ".$_page->_db->nomes_tabelas['objeto'].".titulo LIKE '".$likeas."'";
		}
      // Além de perguntar sobre 'ilike', também garante que só um LIKE será usado na Query (caso programador tente usar LIKE e iLIKE na mesma chamada)
		if((!$likenocase=='') || ((!$likeas=='') && (!$likenocase=='')))
		{
			$like_as = " and ".$_page->_db->nomes_tabelas['objeto'].".titulo ILIKE '".strtolower($likenocase)."'";
		}

		/******** TESTA SE TEM PROPRIEDADE NA ORDEM ***********/
		$tem_propriedade_na_ordem=false;
		foreach ($ordem as $key=>$item)
		{
			if ($item[0]=='-')
			{
				$array_ordem[$key]['orientacao'] = ' desc ';
				$array_ordem[$key]['campo']=substr($item,1);
			}
			elseif ($item[0]=='+')
			{
				$array_ordem[$key]['campo']=substr($item,1);
				$array_ordem[$key]['orientacao'] = ' asc ';
			}
			else
			{
				$array_ordem[$key]['campo']=$item;
			}
			if (!$this->EMetadado($_page, $array_ordem[$key]['campo']))
			$tem_propriedade_na_ordem=true;
		}
		/********* FIM TESTA SE TEM PROPRIEDADE NA ORDEM **********/


		/********* TESTA SE TEM PROPRIEDADE NA QUERY **********/
		$tem_propriedade_na_qry = false;
		foreach ($array_qry as $condicao)
		{
			if (!$this->EMetadado($_page, $condicao[0]))
			{
				$tem_propriedade_na_qry = true;
			}
		}
		/********* FIM TESTA SE TEM PROPRIEDADE NA QUERY **********/


		/************** PREPARA SQL PARA CLASSES ***************/
		$multiclasse=false; //Classe ï¿½nica ï¿½ true. Nesse caso Nï¿½O ï¿½ preciso cria a temp table
		$todas_as_classes=false;
		if ($classe=='*')
		{
			$todas_as_classes=true;
			$multiclasse=true;  //Classe unica e falso. Nesse caso e preciso cria a temp table
		}
		else
		{

			if (!is_array($classe))
			{
				$classe = explode (",",strtolower($classe));
			}
			if (count($classe)>1)
				$multiclasse=true; //Classe unica e falso. Nesse caso e preciso cria a temp table
		}
		$classes = $this->CodigoDasClasses($_page, $classe);


		////////////////// ATE AQUI O CODIGO ESTA CERTO SEM DUVIDA ////////////////

		if (($tem_propriedade_na_ordem) || ($multiclasse) && ($tem_propriedade_na_qry))
		{
			$sql_out = $this->_LocalizarObjetosComTabelaTemporaria ($_page, $classes, $array_qry, $array_ordem, $apagado_where.$tags_where.$usuario_where.$classes_where, $pai_join.$tags_join);
			$sqlfinal = "select * from ".$sql_out['tbl'].$sql_out['ordem'];
		}
		else
		{
			$sql_out = $this->_LocalizarObjetosSemTabelaTemporaria ($_page, $classes, $array_qry, $array_ordem);
			if (is_array($sql_out['classes']))
			{
				$classes_where = ' and '.$_page->_db->CreateTest($_page->_db->nomes_tabelas['objeto'].'.cod_classe',$sql_out['classes']);
			}
			$sqlfinal = "select ".$_page->_db->sqlobjsel;
			if (isset($sql_out['campos'])) $sqlfinal .= $sql_out['campos'];
			$sqlfinal .= $_page->_db->sqlobjfrom.$pai_join.$tags_join;
			if (isset($sql_out['from'])) $sqlfinal .= $sql_out['from'];
			$sqlfinal .= ' where (1=1)'.$apagado_where.$tags_where;
			if (isset($sql_out['where'])) $sqlfinal .= $sql_out['where'];
			$sqlfinal .= $usuario_where.$classes_where;
			if (isset($like_as)) $sqlfinal .= $like_as;
			if (isset($sql_out['ordem'])) $sqlfinal .= $sql_out['ordem'];
		}
		
		$res = $_page->_db->ExecSQL($sqlfinal,$inicio,$limite);
		$row = $res->GetRows();
		
		$objetos = array();
		
		for ($i=0; $i<sizeof($row); $i++)
		{
			$obj = new Objeto($_page);
			$obj->povoar($_page, $row[$i]);
			if (!in_array($obj, $objetos)) $objetos[]=$obj;
		}
		
		if (isset($sql_out['tbl']) && $sql_out['tbl'] != '')
		{
			$_page->_db->DropTempTable($sql_out['tbl']);
		}
			
		return $objetos;
	}

	function CodigoDasClasses(&$_page, $classes)
	{
		$this->CarregaClasses($_page);
		$saida=array();
		if ($classes=='*')
		{
			return $_SESSION['classesNomes'];
		}
		else
		{
			foreach ($classes as $nome)
			{
				if ($_SESSION['classesLocalizarPorNome'][strtolower($nome)])
					$saida[]=$_SESSION['classesLocalizarPorNome'][strtolower($nome)];
				else
					$saida[]=$_SESSION['classesPrefixos'][strtolower($nome)];
			}
		}
		return $saida;
	}

	function CarregaClasses(&$_page)
	{
		if ((!isset($_SESSION['classesPrefixos'])) || (!is_array($_SESSION['classesPrefixos'])) || ($_page->_usuario->EstaLogado()))
	 	{
        	$sql = "select cod_classe, 
        	prefixo, 
        	nome, 
        	indexar 
        	from classe ";
			$rs = $_page->_db->ExecSQL($sql);
			
			if ($rs->_numOfRows > 0){
				while (!$rs->EOF){
					$_SESSION['classesPrefixos'][$rs->fields['prefixo']]=$rs->fields['cod_classe'];
					$_SESSION['classesNomes'][strtolower($rs->fields['nome'])]=$rs->fields['cod_classe'];
					$_SESSION['classesLocalizarPorNome'][strtolower($rs->fields['nome'])]=$rs->fields['cod_classe'];
				
					if ($rs->fields['indexar']) $_SESSION['classesIndexaveis'][]=$rs->fields['cod_classe'];
					$rs->MoveNext();
				}
			}
			
		}
	}

	function _LocalizarObjetosComTabelaTemporaria (&$_page, $classes, $array_qry, $array_ordem, $default_where, $pai_join)
	{
		$tbl = $_page->_db->GetTempTable();
		
		// Variavel para controlar a criacao dos campos na tabela temporaria //
		$primeiro_loop=true;
		$campo_incluido=array();
		$campo_incluido_natabela=array();
		$ordem_temporaria=array();
		
		foreach ($classes as $cod_classe)
		{
			$temp_campos=array();
			$temp_from=array();
			$temp_where=array();
			$campo_incluido=array();
			
			//Constroi SQL para casos em que existem propriedades na ordem
			foreach ($array_ordem as $item)
			{
				if (!$this->EMetadado($_page, $item['campo']))
				{
					$info = $this->CriaSQLPropriedade($_page, $item['campo'],$item['orientacao'],$cod_classe);
					if (!in_array($info['field'],$campo_incluido_natabela))
					{
						$_page->_db->AddFieldToTempTable($tbl,$info);
						$campo_incluido_natabela[]=$info['field'];
					}
					if (!in_array($info['field'],$campo_incluido))
					{
						$temp_campos[]=$info['field'];
						$temp_from[]=$info['from'];
						$temp_where[]=$info['where'];
						$campo_incluido[]=$info['field'];
					}
				}
				$string_temp = $item['campo'].' '.$item['orientacao'];
				if (!in_array($string_temp, $ordem_temporaria))
					$ordem_temporaria[]=$item['campo'].' '.$item['orientacao'];

				//$ordem_insercao[]=$item;
			}
			//fim

			//Constroi SQL para casos em que existem propriedades na condicao
			foreach ($array_qry as $condicao)
			{
				if (!is_array($condicao))
				{
					$out['where'] .= ' '.$condicao;
				} 
				else 
				{
	                if ($this->EMetadado($_page, $condicao[0]))
	                {
				if (preg_match('/floor/',$condicao[0])) {
					$condicao[0]=str_replace('objeto.','',$condicao[0]);
				}
	                    $temp_where[]=' ('.$condicao[0].$condicao[1]."'".$condicao[2]."')";
	                }
	                else
	                {

				$info = $this->CriaSQLPropriedade($_page, $condicao[0],"", $cod_classe);
	                    if (!in_array($info['field'],$campo_incluido_natabela))
	                    {
	                        $_page->_db->AddFieldToTempTable($tbl,$info);
	                        $campo_incluido_natabela[]=$info['field'];
	                    }
	                    if (!in_array($info['field'],$campo_incluido))
	                    {
	                        $temp_campos[]=$info['field'];
	                        $temp_from[]=$info['from'];
	                        $temp_where[]=$info['where'];
	                        $campo_incluido[]=$info['field'];
	                    }
			/*	MUDEI - COLOQUEI UM ESPAÇO ENTRE OS OS CAMPOS E O DELIMITADOR - DANILO 17/04/2009 */
			$temp_where[]= ' ('.$info['field']." ".$condicao[1]." ".$info['delimitador'].$condicao[2].$info['delimitador'].')';                   
	                }
                }
			}
			//fim
			$campos=','.implode($temp_campos,',');
			$from = implode($temp_from,' ');
			$where = implode($temp_where,' and ');

			$sql = 'insert into '.$tbl.
				" select ".$_page->_db->sqlobjsel.$campos.$_page->_db->sqlobjfrom.$pai_join.$from.' where (1=1) and '.$where.$default_where;
			$_page->_db->ExecSQL($sql);

		}


		$result['tbl']=$tbl;
		$result['ordem']=' order by '.implode($ordem_temporaria,',');
			
		return $result;
	}

	function _LocalizarObjetosSemTabelaTemporaria(&$_page, $classes, $array_qry, $array_ordem)
	{
		foreach ($array_ordem as $item)
		{
			$temp_array = $_page->_db->nomes_tabelas["objeto"].'.'.$item['campo'];
			if (isset($item['orientacao'])) $temp_array .= $item['orientacao'];
			$result['ordem'][]= $temp_array;
			if (!$this->EMetadado($_page, $item['campo']))
			{
				$result['campos'][]=$item['campo'];
			}
		}
		
		foreach ($classes as $cod_classe)
		{
			$input=array();
			$input = $this->CriaSQLParaCondicao($_page, $array_qry, $cod_classe);
			if (isset($input) && is_array($input))
			{
				$result['where'][] = $input['where'];
				$result['from'][] = $input['from'];
			}
			$result['classes'][] = $cod_classe;
		}

		if (isset($result['where']) && is_array($result['where']))
		{
			$result['where']=' and '.implode($result['where'],' and ');
		}


		if (isset($result['campos']) && is_array($result['campos']))
		$result['campos']=implode($result['campos'],',');

		if (isset($result['from']) && is_array($result['from']))
        {
        	$sep_temp='';
          	$saida_from='';
        	foreach ($result['from'] as $cada_from)
            {
            	if ($cada_from)
                {
            		$saida_from=$sep_temp.$cada_from;
					$sep_temp=',';
                }
            }
			$result['from']=$saida_from;
        }

		if (is_array($result['ordem']))
			$result['ordem']=' order by '.implode($result['ordem'],',');

			return $result;

	}

	function CriaSQLParaCondicao(&$_page, $array_qry, $cod_classe)
	{
		$out="";
		/***************** 	GERA SQL PARA CONDICAO *******************/
		foreach ($array_qry as $condicao)
		{
//			echo '<p>CONDICAO<BR>';
//			print_r($condicao);
//			echo '<p>';
			if (!is_array($condicao))
			{
//				echo "entrou";
				$out['where'] .= ' '.$condicao;
			}
			else
			{
//				echo ">>>".$condicao[0]."<br>";
				if ($this->EMetadado($_page, $condicao[0]))
				{
					$condicao[0] = str_replace($_page->_db->nomes_tabelas["objeto"].'.(','(',$condicao[0]);
					$out['where'].=' '.$condicao[0].$condicao[1]."'".$condicao[2]."'";
				}
				else
				{

					$temp = $this->CriaSQLPropriedade($_page, $condicao[0],"", $cod_classe);
					if (!strpos($out['from'],$temp['from'])) $out['from'] .= ' '.$temp['from'];
					$out['condicao'][]=$condicao[0];
					/*	MUDEI - COLOQUEI UM ESPAÇO ENTRE OS OS CAMPOS E O DELIMITADOR - RODRIGO 20/03/2009 */
					//original - $out['where'] .= ' ('.$temp['where'].' AND '.$temp['field'].$condicao[1].$temp['delimitador'].$condicao[2].$temp['delimitador'].')';
					$out['where'] .= ' ('.$temp['where'].' AND '.$temp['field']." ".$condicao[1]." ".$temp['delimitador'].$condicao[2].$temp['delimitador'].')';
				}
			}
		}
//		echo '<p>OUT<BR>';
//		print_r($out);
//		echo '<p>';
		return $out;
		/***************** FIM	GERA SQL PARA CONDICAO *******************/
	}

	function LocalizarPendentes(&$_page, $cod_pai, $cod_usuario, $ord1, $ord2, $inicio=-1, $limite=-1)
	{
		$sql_pendentes = "SELECT t2.cod_objeto, t2.titulo 
		from pendencia t1 
		inner join objeto t2 on t1.cod_objeto=t2.cod_objeto 
		inner join parentesco t3 on t1.cod_objeto=t3.cod_objeto 
		where t3.cod_pai=".$cod_pai." 
		and t2.apagado=0
		order by t2.".$ord1." ".$ord2;
		$rs = $_page->_db->ExecSQL($sql_pendentes, $inicio, $limite);
		return $rs->GetRows(); 
	}
	
	function LocalizarRejeitados(&$_page)
	{
		$objetos=array();
		$usuario_atual = $_SESSION['usuario']["cod_usuario"];
		$sql_rejeitados = "SELECT cod_objeto,titulo from objeto where cod_status IN ("._STATUS_REJEITADO.") and cod_usuario = ".$usuario_atual." and apagado=0";
		$rs = $_page->_db->ExecSQL($sql_rejeitados);
		while ($row_rejeitados=$rs->FetchRow())
		{
			$obj[] = $row_rejeitados;
		}
		if (count($obj))
		{
			foreach ($obj as $obj_atual)
			{
				//$perfil_atual = $_page->Administracao->PegaPerfilDoUsuarioNoObjeto($usuario_atual,$obj_atual["cod_objeto"]);
				//if (($perfil_atual==_PERFIL_ADMINISTRADOR)||$perfil_atual==(_PERFIL_EDITOR)) {
				$objetos[]=$obj_atual;
				//}
			}
		}
		
		return $objetos;
	}

	function CriaCondicaoUsuario(&$_page)
	{
		$sql_condicao = "";
		switch ($_SESSION['usuario']['perfil'])
		{
			case _PERFIL_DEFAULT:
				$sql_condicao = $this->CondicaoPublicado($_page).$this->CondicaoData($_page);
				break;
			case _PERFIL_AUTOR:
				//$sql_condicao=$this->CondicaoAutor();
//				$sql_condicao=$this->CondicaoData($_page);
				break;
			case _PERFIL_RESTRITO:
				$sql_condicao=$this->CondicaoData($_page);
				break;
			case _PERFIL_MILITARIZADO:
				$sql_condicao=$this->CondicaoPublicado($_page).$this->CondicaoData($_page);
				break;
			case _PERFIL_ADMINISTRADOR:
				//$sql_condicao=$this->CondicaoData($_page);
				break;
			default:
//				$sql_condicao = $this->CondicaoPublicado($_page).$this->CondicaoData($_page);
//				$sql_condicao = $this->CondicaoData($_page);
				break;
		}
		
		return $sql_condicao;
	}

	function CriaClasseInfo(&$_page, $classe)
	{
		if (!is_array($classe))
		{
			if ($classe!='')
			$classe = explode(',',$classe);
		}
		if ((!is_array($classe)) || (!count($classe)))
		return false;
		$sql = "select cod_classe from classe where ".$_page->_db->CreateTest('nome',$classe);
		$rs = $_page->_db->ExecSQL($sql);
		while ($row=$rs->FetchRow())
		{
			$cod_classe_array[]=$row['cod_classe'];
		}
		if (count ($cod_classe_array)!=count($classe))
		{
			$_page->AdicionarAviso("Uma ou mais classes inexistentes em ".implode(",",$classe).".");
		}
		if (count($cod_classe_array))
		{
			$whereclasse=$_page->_db->CreateTest('objeto.cod_classe',$cod_classe_array);
		}
		else
		$whereclasse=" 1=0 ";

		$whereclasse = " and ".$whereclasse;
		return array("cod_classe_array"=>$cod_classe_array,"sql"=>$whereclasse);
	}

	function PegaNomeClasse(&$_page, $cod_classe)
	{
		$sql = "select nome, 
		prefixo 
		from classe 
		where cod_classe=".$cod_classe;
		$rs = $_page->_db->ExecSQL($sql);
		return $rs->fields;
	}

	function CriaSQLPropriedade(&$_page, $campo, $direcao, $cod_classe)
	{
		$info = $this->PegaInfoSobrePropriedade($_page, $cod_classe, $campo);
		
		if ($info!=null && $info!='')
		{

			$montagem['from'] = " left join ".$info['tabela']." as ".$campo." on ";
			$on = ' '.$_page->_db->nomes_tabelas["objeto"].'.cod_objeto='.$campo.'.cod_objeto';
			$montagem['type'] = $info['nome'];
			if ($info['tabela']=='tbl_objref')
			{
				$montagem['from'] .= '(('.$on.') and ('.$campo.'.cod_propriedade='.$info['cod_propriedade'].'))';
				$montagem['where'] = '(1 = 1)';
				$montagem['from'] .= " left join objeto as ".$campo."_ref on ".$campo.".valor=".$campo."_ref.cod_objeto";
				if (!$this->EMetadado($_page, $info['campo_ref']))
				{
					$propriedade=$this->PegaInfoSobrePropriedade($_page, $info['cod_referencia_classe'],$info['campo_ref']);
					//$montagem['from'] .= '(('.$on.') and ('.$campo."_property.cod_propriedade=".$propriedade['cod_propriedade'].'))';
					$montagem['from'] .= " left join ".$propriedade['tabela']." as ".$campo."_campo_ref on ".
					$campo.'_ref.cod_objeto='.$campo.'_property.cod_objeto';
					$montagem['field'] .= $campo."_property.valor";
					$montagem['delimitador']=$propriedade['delimitador'];
					//$montagem['where'] .= $campo."_property.cod_propriedade=".$propriedade['cod_propriedade'];
				}
				else
				{
					//$montagem['from'] .= '(('.$on.') and ('.$campo.'.cod_propriedade='.$info['cod_propriedade'].'))';
					$montagem['field'] .=  $campo."_ref.".$info['campo_ref'];
					$montagem['delimitador']="'";
				}
			}
			else
			{
				$montagem['from'] .= $on;
				$montagem['where'] = $campo.".cod_propriedade=".$info['cod_propriedade'];
				$montagem['field'] .=$campo.".valor";
				$montagem['delimitador']="'";
			}
		}
		else
		{
			$ClasseNome = $this->PegaNomeClasse($_page, $cod_classe);
			$_page->AdicionarAviso("Classe ".$ClasseNome['nome']." n&atilde;o tem propriedade $campo.",true);
		}
		return $montagem;
	}

	function PegaInfoSobrePropriedade(&$_page, $cod_classe, $prop)
	{
		$tabelas = $_page->_db->nomes_tabelas;
		
		$sql = "select ".$tabelas["propriedade"].".cod_propriedade, 
		".$tabelas["tipodado"].".nome, 
		".$tabelas["tipodado"].".tabela, 
		".$tabelas["propriedade"].".cod_referencia_classe, 
		".$tabelas["propriedade"].".campo_ref, 
		".$tabelas["tipodado"].".delimitador 
		from propriedade ".$tabelas["propriedade"]." 
		inner join tipodado ".$tabelas["tipodado"]." 
		on ".$tabelas["propriedade"].".cod_tipodado = ".$tabelas["tipodado"].".cod_tipodado
		where ".$tabelas["propriedade"].".cod_classe=".$cod_classe;
		
		if (!intval($prop))
			$sql .=" and ".$tabelas["propriedade"].".nome='".$prop."'";
		else
			$sql .=" and ".$tabelas["propriedade"].".cod_propriedade=".$prop;
			
		$rs = $_page->_db->ExecSQL($sql);
		$return = $rs->fields;
		return $return;
	}

	function Limites($inicio,$limite)
	{
		if ($limite!="")
		{
			$result=" limit ".intval($inicio).",$limite";
		}
		else
		{
			if ($inicio)
			$result=" limit $inicio";
		}
		return $result;
	}

	function CriaSQLQuery(&$_page, $qry, $cod_classe_array)
	{
		//dump ($qry);
		if ($qry!='')
		{
			if (!is_array($qry))
			{
				if (strpos($qry,'&&')===false)
				{
					$qry=explode('||',$qry);
					$cola=" OR ";
				}
				else
				{
					$qry=explode('&&',$qry);
					$cola=" AND ";
				}
			}
		}
		else
		$qry=array();
		//dump($qry);
		foreach ($qry as $value)
		{
			//dump ($value);
			preg_match("|(.+?)([=\<\>]{1,2})(.+)|",$value,$item);
			if ($item[1]!='')
			{
				//dump ($item);
				$item[1]=trim($item[1]);
				$item[3]=trim($item[3]);
				if ($this->EMetadado($_page, $item[1]))
				{
					if ($result['where']!='')
					$result['where'].=$cola;
					if ($item[1]=='data_publicacao' || $item[1]=='data_validade')
					{
						if ($item[2]=='=')
						{
							$item[1]=$this->db->Day('objeto.'.$item[1]);
							$data=ConverteData($item[3],16);
						}
						else
						{
							$data=ConverteData($item[3],15);
						}
						$result['where'].=$item[1].$item[2];
						$result['where'].=$data;
					}
					else
					{
						$result['where'].=' objeto.'.$item[1].$item[2];
						if (is_numeric($item[3]))
						{
							$result['where'].=$item[3];
						}
						else
						{
							$result['where'].="'".$item[3]."'";
						}
					}
				}
				else
				{
					if (is_array($cod_classe_array))
					{
						//var_dump($cod_classe_array);
						$sqltoproperty=$this->CriaSQLPropriedade($_page, $cod_classe_array, $item[1], '');
						if ($sqltoproperty[0]['field'])
						{
							$start=true;
							foreach ($sqltoproperty as $property)
							{
								//echo "<br>$property<br>";
								//dump($property);
								if ($start)
								{
									$field=$property['field'];
									$result['joined']=$field;
									if (($result['sort']!='') && ($property['sort']!=''))
									$result['sort'].=',';
									$result['sort'].=$property['sort'];
									$result['join'].=$property['join'];
									$result['join'].=' and ('.$property['where'];
									$start=false;
								}
								else
								{
									$result['join'].=' or '.$property['where'];
								}
							}
							$result['join'].=')';
							if ($result['where']!='')
							$result['where'].=$cola;
							$result['where'].=$field.$item[2];

							if ($property['type']=='data')
							{
								$item[3] = ConverteData($item[3],15);

							}

							if (is_numeric($item[3]))
							{
								$result['where'].=$item[3];
							}
							else
							{
								$result['where'].="'".$item[3]."'";
							}
							$result['field'].=','.$field;
						}
						else
						{
							$_page->AdicionarAviso('Erro no processamento de um comando Localizar.<br> Express&atilde;o "'.$value.'" pede um campo n&atilde;o existente.',true);
						}
					}
				}
			}
			else
			{
				$_page->AdicionarAviso('Erro no processamento de um comando Localizar.<br> Express&atilde;o "'.$value.'" n&atilde;o pode ser analisada.',true);
			}
		}
		if ($result['where']!='')
		{
			$result['where'] = ' and ('.$result['where'].')';
		}
		return $result;
	}

	function CriaSQLPais(&$_page, $pai, $niveis, $campo="objeto.cod_pai")
	{
		if ($pai!=-1)
		{
		 	$return = " inner join parentesco ".$_page->_db->nomes_tabelas["parentesco"]." 
				on (".$_page->_db->nomes_tabelas["parentesco"].".cod_objeto = ".$_page->_db->nomes_tabelas["objeto"].".cod_objeto 
				and ".$_page->_db->nomes_tabelas["parentesco"].".cod_pai=".$pai;
		 	if ($niveis>=0)
		 		$return.= " and ordem<=".($niveis+1).')';
		 	else
		 		$return .=')';
		}
		return $return;
	}

	function PegaIDFilhos(&$_page, $pai, $niveis)
	{
		$sql = "select cod_pai from parentesco where cod_pai=$pai";
		$res = $_page->_db->ExecSQL($sql);
		while ($row = $res->FetchRow())
		{
			$list[]=$row['cod_objeto'];
		}
		return $list;
	}
	
	function PegaIDPai(&$_page, $cod_objeto, $nivel, $excecoes, $desc=false)
	{
		$rtnLista = array();
		$contador = 0;
		$sql = "select ".$_page->_db->nomes_tabelas["parentesco"].".cod_pai, 
		".$_page->_db->nomes_tabelas["objeto"].".titulo from parentesco ".$_page->_db->nomes_tabelas["parentesco"]." 
		inner join objeto ".$_page->_db->nomes_tabelas["objeto"]." on ".$_page->_db->nomes_tabelas["objeto"].".cod_objeto = ".$_page->_db->nomes_tabelas["parentesco"].".cod_pai 
		where ".$_page->_db->nomes_tabelas["parentesco"].".cod_objeto = $cod_objeto 
		order by ".$_page->_db->nomes_tabelas["parentesco"].".ordem";
		if ($desc)
			$sql .= " desc";
		$res = $_page->_db->ExecSQL($sql);
		while ($row = $res->FetchRow())
		{
			$arrCodeTitulo = array($row['cod_pai'] => $row['titulo']);
			if (($contador < $nivel) && !(in_array($row['cod_pai'],$excecoes)))
			{
			array_push_associative($rtnLista,$arrCodeTitulo);
			$contador = $contador + 1;
			}
		}
		//array_flip($rtnLista);
		return $rtnLista;
	}
	
	function PegaNumFilhos(&$_page, $pai)
	{
		$sql = "SELECT count(*) as total 
		FROM parentesco ".$_page->_db->nomes_tabelas["parentesco"]." 
		LEFT JOIN objeto ".$_page->_db->nomes_tabelas["objeto"]." on ".$_page->_db->nomes_tabelas["parentesco"].".cod_objeto = ".$_page->_db->nomes_tabelas["objeto"].".cod_objeto 
		WHERE ".$_page->_db->nomes_tabelas["parentesco"].".cod_pai = $pai 
		AND ".$_page->_db->nomes_tabelas["objeto"].".apagado <> 1";
		$res = $_page->_db->ExecSQL($sql);
		return $res->fields["total"];
	}

	function EFilho(&$_page, $cod_objeto, $cod_pai)
	{
		$sql = "select ".$_page->_db->nomes_tabelas["parentesco"].".cod_objeto 
		from parentesco ".$_page->_db->nomes_tabelas["parentesco"]." 
		where ".$_page->_db->nomes_tabelas["parentesco"].".cod_pai=$cod_pai 
		and ".$_page->_db->nomes_tabelas["parentesco"].".cod_objeto=$cod_objeto";
		$res = $_page->_db->ExecSQL($sql);
		return !$res->EOF;
	}

	function ShowObjectResume(&$_page, $cod_objeto)
	{
		$obj = $this->CriarObjeto($_page, $cod_objeto);
		foreach ($obj as $key => $quadro)
		{
			if ($key == 'CaminhoObjeto')
				$arrCaminho = $quadro;
		}
		//echo $obj['CaminhoObjeto']."<br>";
		//var_dump_pre($cod_objeto);
		return array('url'=>$obj->Valor('url'), 'titulo'=>$obj->Valor('titulo'), 'descricao'=>$obj->Valor('descricao'), 'codigo'=>$obj->Valor('cod_objeto'),'caminho'=>$arrCaminho);
	}

	function EnviaEmailSolicitacao(&$_page, $cod_chefia, $cod_objeto,$mensagemsubmetida)
	{
		global $PORTAL_NAME;
	  include('email.class.pinc');
	  $arrInfoUsuario = $_page->_administracao->PegaInformacaoUsuario($_page, $cod_chefia);
	  $arrInfoDadosObjeto = $_page->_adminobjeto->PegaDadosObjetoPeloID($_page, $cod_objeto);
	  
		 $texConteudo = "<font align=\"left\">Esta mensagem &eacute; para informar a solicita&ccedil;&atilde;o de publica&ccedil;&atilde;o de objetos por parte do usu&aacute;rio <b>".$_SESSION['usuario']['nome']."</b> dentro do ".$PORTAL_NAME.".
		 <br>
		 Voc&ecirc; deve efetuar login no sistema, utilizando seu usu&aacute;rio e senha, <a href=\""._URL."/login\">clicando aqui</a>. Dentro das <b>Op&ccedil;&otilde;es de Menu</b>, localize o bot&atilde;o de <i>objetos aguardando aprova&ccedil;&atilde;o</i>.
		 <br><br>
		 Os dados do objeto seguem:<br>
		 <br>
		 <br>
		 <b>Mensagem de solicita&ccedil;&atilde;o:</b> ".$mensagemsubmetida."<br><b>T&iacute;tulo do Objeto:</b> ".$arrInfoDadosObjeto['titulo']." <i>[".$arrInfoDadosObjeto['cod_objeto']."]</i> <br>
		 <b>Data de Validade:</b> ".ConverteData($arrInfoDadosObjeto['data_validade'],1)."<br>
		 <b>Data de Publica&ccedil;&atilde;o:</b> ".ConverteData($arrInfoDadosObjeto['data_publicacao'],1)."<br>
		 <b>Classe utilizada:</b> ".$arrInfoDadosObjeto['classe']."<br>
		 <br><br>
		 Caso seja necess&aacute;rio, os dados do solicitante s&atilde;o descritos abaixo:
		 <br><br>
		 <b>Nome do Solicitante:</b> ".$_SESSION['usuario']['nome']."<br>
		 <b>E-mail do Solicitante:</b> ".$_SESSION['usuario']['email']."<br>
		 <b>Telefone de contato:</b> - n&atilde;o cadastrado -<br>
		 <br><br><br><br>
		 <b>Esta mensagem &eacute; autom&aacute;tica e n&atilde;o deve ser respondida.</b>
		 <br><br>
		 <center>Coordena&ccedil;&atilde;o Geral de Tecnologia da Informa&ccedil;&atilde;o - <b>CGTI</b></center></font>";
	  
	  $destinatario = $arrInfoUsuario['nome']." <".$arrInfoUsuario['email'].">";
	  $remetente =  "$PORTAL_NAME <$PORTAL_EMAIL>";
	  $email = new Email($destinatario,	//** to address(es).
										$remetente,						//** from address.
										"Solicitacao de Publicacao");	//** subject.
	
	  $email->TextOnly = false;
	  $email->Content = "<html><body style='margin:0; padding:0;'>".
						"<center>".
						"<BR>Caro Sr(a), ".$arrInfoUsuario['nome']."<BR><BR>".
						"$texConteudo".
						"<BR></body></html>";
	
	//** send a copy of this file in the email. (nï¿½o nescessï¿½rio)
	  //$email->Attach(__FILE__, "text/plain");
	
	
	//** attach this included image file.
	
	  //$email->Attach("informect/images/logo_ct2.gif", "image/gif");
	  //$email->Attach("informect/images/brasil2.gif", "image/gif");
	  //$email->Attach("informect/images/moldura_dest_dir.gif", "image/gif");
	  //$email->Attach("informect/images/bottom_informe.gif", "image/gif");
	  //$email->Attach("informect/images/headre_informe.jpg", "image/gif");
	
	  $wassent = $email->Send();
	  return $wassent;
	}

	function ExecutaScript(&$_page, $codClasse, $codPele,$codTexto) {
		$ClasseUtilizada = $this->PegaNomeClasse($_page, $codClasse);
		$PeleUtilizada = $_page->_administracao->PegaListaDePeles($_page, $codPele);

		if (file_exists($_SERVER['DOCUMENT_ROOT']."/html/execscript/exec_".$PeleUtilizada['prefixo']."_".$ClasseUtilizada['prefixo']."_".$codTexto.".php"))	{
			include($_SERVER['DOCUMENT_ROOT']."/html/execscript/exec_".$PeleUtilizada['prefixo']."_".$ClasseUtilizada['prefixo']."_".$codTexto.".php");
		}
		elseif (file_exists($_SERVER['DOCUMENT_ROOT']."/html/execscript/exec_".$ClasseUtilizada['prefixo']."_".$codTexto.".php")) {
			include($_SERVER['DOCUMENT_ROOT']."/html/execscript/exec_".$ClasseUtilizada['prefixo']."_".$codTexto.".php");
		}
	}

	function ExecutaScriptDepois(&$_page, $codClasse, $codPele) {
		$ClasseUtilizada = $this->PegaNomeClasse($_page, $codClasse);
		$PeleUtilizada = $_page->_administracao->PegaListaDePeles($_page, $codPele);
		
		if (file_exists($_SERVER['DOCUMENT_ROOT']."/html/skin/".$PeleUtilizada['prefixo']."/exec_".$ClasseUtilizada['prefixo']."_depois.php"))	{
			include($_SERVER['DOCUMENT_ROOT']."/html/skin/".$PeleUtilizada['prefixo']."/exec_".$ClasseUtilizada['prefixo']."_depois.php");
			return $_SERVER['DOCUMENT_ROOT']."/html/skin/".$PeleUtilizada['prefixo']."/exec_".$ClasseUtilizada['prefixo']."_depois.php";
		}
		elseif (file_exists($_SERVER['DOCUMENT_ROOT']."/html/execscript/exec_".$ClasseUtilizada['prefixo']."depois.php")) {
			include($_SERVER['DOCUMENT_ROOT']."/html/execscript/exec_".$ClasseUtilizada['prefixo']."_depois.php");
			return $_SERVER['DOCUMENT_ROOT']."/html/execscript/exec_".$ClasseUtilizada['prefixo']."_depois.php";
		}
	}

        function estaSobAreaProtegida(&$_page, $cod_objeto)
        {
            $_page->IncluirAdmin();
            $protegido = false;
            $caminho = $_page->_adminobjeto->RecursivaCaminhoObjeto($_page, $cod_objeto);
            $caminho = explode(",", $caminho);
            $caminho[] = $cod_objeto;

            $objBlob = new Objeto($_page, $cod_objeto);

            // pegando permissao do usuario no objeto
            $permissao = $_page->_administracao->PegaPerfilDoUsuarioNoObjeto($_page, $_SESSION['usuario']["cod_usuario"], $cod_objeto);

            // verificando se o objeto está publicado
            if ($objBlob->metadados["cod_status"]!="2" && !$permissao)
            {
               return false;
            }

            // verificando se tem objeto protegido no parentesco
            foreach ($caminho as $obj)
            {
                $objeto = new Objeto($_page, $obj);
                if (preg_match("/_protegido.*/", $objeto->metadados["script_exibir"]))
                {
                    $protegido = true;
                    break;
                }
            }

            if ($protegido && (!$permissao || $permissao>_PERFIL_MILITARIZADO))
            {
                return false;
            }

            return true;
        }

}

