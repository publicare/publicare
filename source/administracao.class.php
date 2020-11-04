<?php

	class Administracao
	{
		
		public $classesPrefixos;
		public $classesNomes;
		public $classesLocalizarPorNome;
		public $classesIndexaveis;
		public $_index;
		
		function __construct(&$_page)
		{
			$this->metadados = $_page->_db->metadados;
		}

		function CarregaClasses(&$_page)
		{
        	$sql = "select cod_classe, 
        	prefixo, 
        	nome, 
        	indexar 
        	from classe 
        	order by nome";
			$res=$_page->_db->ExecSQL($sql);
			$row=$res->GetRows();
			for ($i=0; $i<sizeof($row); $i++)
			{
				$this->classesPrefixos[$row[$i]['prefixo']]=$row[$i]['cod_classe'];
 				$this->classesNomes[$row[$i]['nome']]=$row[$i]['cod_classe'];
				$this->classesLocalizarPorNome[strtolower($row[$i]['nome'])]=$row[$i]['cod_classe'];

				if ($row[$i]['indexar'])
					$this->classesIndexaveis[]=$row[$i]['cod_classe'];
			}
		}

		function CodigoDaClasse(&$_page, $prefixo)
		{
		 	$this->CarregaClasses($_page);
			return $this->classesPrefixos[$prefixo];
		}

		function PegaListaDePeles(&$_page, $rcvPele=NULL)
		{
			$result=array();
			if ($rcvPele && $rcvPele!=NULL)
				$sqladd = " OR cod_pele = ".$rcvPele;
			if ($_SESSION['usuario']['perfil'] == _PERFIL_ADMINISTRADOR) {
				$sql = "select cod_pele as codigo, nome as texto from pele order by texto";
			} else {
				$sql = "select cod_pele as codigo, nome as texto from pele where (publica = '1' ";
				if (isset($sqladd)) $sql .= $sqladd;
				$sql .= ") 	order by texto";
			}
			$res = $_page->_db->ExecSQL($sql);
			return $res->GetRows();
		}

		function DropDownListaDePeles(&$_page, $cod_pele, $branco=true, $peleAtual=NULL)
		{
			$lista = $this->PegaListadePeles($_page, $peleAtual);
			if ($lista)
				return $this->CriaDropDown($lista, $cod_pele, $branco);
		}

		function PegaListadeDependentes(&$_page, $cod_usuario)
		{
			$result=array();
			if($_SESSION['usuario']['perfil']==_PERFIL_ADMINISTRADOR)
				$sql = "select usuario.cod_usuario as codigo, 
				usuario.nome as texto 
				from usuario 
				where ((valido = 1) or cod_usuario = ".$cod_usuario.") 
				order by texto";
			else {
				if ($_SESSION['usuario']['cod_usuario'] == $cod_usuario)
					$sql = "select usuario.cod_usuario as codigo, 
					usuario.nome as texto 
					from usuario 
					where ((chefia = ".$cod_usuario.") 
					or (cod_usuario = ".$cod_usuario." and valido = ".$cod_usuario.") 
					or (cod_usuario = ".$cod_usuario.")) 
					order by texto";
				else 
					$sql = false;
			}
			if ($sql) {
				$rs = $_page->_db->ExecSQL($sql);
				$result = $rs->GetRows();
			}
			return $result;
		}
		
		function DropDownListaDependentes(&$_page, $cod_usuario)
		{
			$lista=$this->PegaListadeDependentes($_page, $cod_usuario);
			return $this->CriaDropDown($lista, $cod_usuario, false, 30);
		}

		function PegaListadeArquivosNoDiretorio() {} // Producao prevista para 30/10/2006
		
		function DropDownListaViews() {}		// Producao prevista para 30/10/2006
		
		function CriaDropDown($lista, $selecionado, $branco=true, $nummaxletras=0)
		{
			$result = "";
			if ($branco)
				$result = '<option value="0" selected>&nbsp;Selecione&nbsp;</option>';
			
			foreach($lista as $item)
			{
				$result.='<option value="'.$item['codigo'].'"';
				if (($selecionado==$item['codigo']) || ($selecionado==$item['texto']))
					$result .=' selected ';
				$result .= '>';
				if ($nummaxletras)
				 $result .= substr($item['texto'],0,$nummaxletras);
				else 
				 $result .= $item['texto'];
				$result .= '</option>';
			}
			return $result;
		}
	
		function PegaPropriedadesDaClasse(&$_page, $cod_classe)
		{
			$result = "";
			$sql = "select ".$_page->_db->nomes_tabelas["propriedade"].".cod_tipodado, 
				cod_propriedade,
				".$_page->_db->nomes_tabelas["tipodado"].".nome as tipodado, 
				".$_page->_db->nomes_tabelas["propriedade"].".campo_ref,
				".$_page->_db->nomes_tabelas["propriedade"].".nome,
				".$_page->_db->nomes_tabelas["tipodado"].".tabela,
				".$_page->_db->nomes_tabelas["propriedade"].".cod_referencia_classe, 
				".$_page->_db->nomes_tabelas["propriedade"].".posicao, 
				".$_page->_db->nomes_tabelas["propriedade"].".descricao, 
				".$_page->_db->nomes_tabelas["propriedade"].".rotulo, 
				".$_page->_db->nomes_tabelas["propriedade"].".obrigatorio, 
				".$_page->_db->nomes_tabelas["propriedade"].".seguranca, 
				".$_page->_db->nomes_tabelas["propriedade"].".valorpadrao, 
				".$_page->_db->nomes_tabelas["propriedade"].".rot1booleano, 
				".$_page->_db->nomes_tabelas["propriedade"].".rot2booleano 
				from propriedade ".$_page->_db->nomes_tabelas["propriedade"]." 
				inner join tipodado ".$_page->_db->nomes_tabelas["tipodado"]." on ".$_page->_db->nomes_tabelas["propriedade"].".cod_tipodado = ".$_page->_db->nomes_tabelas["tipodado"].".cod_tipodado
				where ".$_page->_db->nomes_tabelas["propriedade"].".cod_classe=$cod_classe 
				order by ".$_page->_db->nomes_tabelas["propriedade"].".posicao";
			$rs = $_page->_db->ExecSQL($sql);
			return $rs->GetRows(); 
		}

		function PegaListaDeObjetos(&$_page, $cod_classe, $propriedade)
		{
			$result=array();
			if (in_array($propriedade, $_page->_db->metadados))
			{
				$sql = "select cod_objeto as codigo,
				$propriedade as texto 
				from objeto 
				where cod_classe=$cod_classe 
				and apagado <> 1 
				order by $propriedade";
			}
			else
			{
				$info=$_page->_adminobjeto->CriaSQLPropriedade($_page, cod_classe, $propriedade, ' asc');
				//var_dump($info);
				//exit;
				$sql = "select objeto.cod_objeto as codigo,
				".$info['field']." as texto 
				from objeto ".$info['join']." 
				where ".$info['where']." 
				order by ".$info['sort'];
			}
			$res=$_page->_db->ExecSQL($sql);
			return $res->GetRows();
		}

		function DropDownListaDeObjetos(&$_page, $cod_classe, $propriedade, $selecionado=-1, $nummaxletras=0)
		{
			$lista=$this->PegaListadeObjetos($_page, $cod_classe, $propriedade);
			return $this->CriaDropDown($lista, $selecionado, true, $nummaxletras);
		}

        function TrocaPeleFilhos(&$_page, $cod_objeto, $cod_pele)
        {
                $filhos = $_page->_adminobjeto->ListaCodFilhos($_page, $cod_objeto);
                if (count($filhos)>0)
                {
					$sql_pele_filhos="update objeto 
					set cod_pele=".($cod_pele+0)." 
					where cod_objeto in (".join(',',$filhos).")";
                	$_page->_db->ExecSQL($sql_pele_filhos);
                    foreach ($filhos as $filho)
                    {
                    	$this->TrocaPeleFilhos($_page, $filho, $cod_pele);

                    }
                }
        }

		function AlterarListaDeObjetosQueContemClasse(&$_page, $cod_classe, $lista)
		{
			$sql = 'delete from classexobjeto 
			where cod_classe='.$cod_classe;
			$_page->_db->ExecSQL($sql);
			
//			print_r($lista);
//			exit();
			
			if (is_array($lista))
			{
			 	foreach ($lista as $item)
			 	{
					$_page->_db->ExecSQL("insert into classexobjeto(cod_classe,cod_objeto) values(".$cod_classe.",".$item.")");
				}
			}
		}

		function AlterarObjeto(&$_page, $dados, $log=true)
		{	
			if (JPCACHE==1)
				ClearCache();

			$fieldlist = array();
			$valorlist = array();
			$tagslist = array();
			foreach ($dados as $key=>$valor)
			{
				if ($key!="submit")
				{
					if ($key=="tags")
						$tagslist = split(",",$valor);
					if (strpos($key,":"))
						$proplist[$key]=$valor;
				}
			}

			$sql_pele = "select cod_pele 
            from objeto 
            where cod_objeto=".$dados['cod_objeto'];
            $row_pele = $_page->_db->ExecSQL($sql_pele);
            $row_pele = $row_pele->GetRows();
            $row_pele = $row_pele[0];
            if ($row_pele['cod_pele']!=$dados['cod_pele'])
            {
            	$this->TrocaPeleFilhos($_page, $dados['cod_objeto'], $dados['cod_pele']);

            }
            
			if ($dados['cod_objeto']==1)
				$dados['cod_status'] = _STATUS_PUBLICADO;
			
			$sql = "update objeto 
			set cod_pai=".$dados['cod_pai'].",
			script_exibir='".$dados['script_exibir']."',
			cod_classe=".$dados['cod_classe'].",
			cod_usuario=".$dados['cod_usuario'].",
			cod_pele=".($dados['cod_pele']+0).",
			cod_status=".$dados['cod_status'].",
			titulo='".$_page->_db->Slashes($dados['titulo'])."',
			descricao='".$_page->_db->Slashes($dados['descricao'])."',
			data_publicacao='".ConverteData($dados['data_publicacao'],27)."',
			data_validade ='".ConverteData($dados['data_validade'],27)."',
			peso='".$dados['peso']."' 
			where cod_objeto=".$dados['cod_objeto'];
			
			$_page->_db->ExecSQL($sql);

			$this->ApagarPropriedades($_page, $dados['cod_objeto'],false);
			$this->GravarPropriedades($_page, $dados['cod_objeto'], $dados['cod_classe'], $proplist);
			$this->GravarTags($_page, $dados['cod_objeto'], $tagslist);
			if ($this->ClasseIndexavel($_page, $dados['cod_classe']) && $dados['cod_status'] == _STATUS_PUBLICADO)
			{
				if (!is_object($this->index))
					$this->index= new index();
				$this->index->record_index($_page, $dados['cod_objeto']);
			}
			if ($log)
				$_page->_log->IncluirLogObjeto($_page, $dados['cod_objeto'], _OPERACAO_OBJETO_EDITAR);
				
			return $dados['cod_objeto'];
		}
	 
		function ApagarPropriedades(&$_page, $cod_objeto, $tudo=true)
		{
			$sql = "select tabela 
			from objeto 
			inner join propriedade on objeto.cod_classe=propriedade.cod_classe
			inner join tipodado on propriedade.cod_tipodado = tipodado.cod_tipodado
			where cod_objeto = ".$cod_objeto ;
		
			if (!$tudo)
				$sql .= " and tabela<>'tbl_blob'";   

			$res = $_page->_db->ExecSQL($sql);
			$row = $res->GetRows();
		
			for ($i=0; $i<sizeof($row); $i++)
			{
				if ($row[$i]['tabela']=='tbl_blob')
				{
					if (defined ("_BLOBDIR"))
					{
						$sql = "select cod_blob, arquivo 
						from tbl_blob 
						where cod_objeto=$cod_objeto";
						$res_blob = $_page->_db->ExecSQL($sql);
						$row_blob = $res_blob->GetRows();
						
						for ($j=0; $j<sizeof($row_blob); $j++)
						{
							$file_ext=$this->PegaExtensaoArquivo($row_blob[$j]['arquivo']);

							//Linhas abaixo alteradas para encontrar o blob dentro da subpasta numerada
							if (file_exists(_BLOBDIR."/".identificaPasta($row_blob[$j]['cod_blob'])."/".$row_blob[$j]['cod_blob'].'.'.$file_ext))
								$checkDelete = unlink(_BLOBDIR."/".identificaPasta($row_blob[$j]['cod_blob'])."/".$row_blob[$j]['cod_blob'].'.'.$file_ext);
							if (defined ("_THUMBDIR"))
							{
								if (file_exists(_THUMBDIR.$row_blob[$j]['cod_blob'].'.'.$file_ext))
									unlink(_THUMBDIR.$row_blob[$j]['cod_blob'].'.'.$file_ext);
							}
						}
					}
				}
				$sql = "delete from ".$row[$i]['tabela']." where cod_objeto = ".$cod_objeto;
				$_page->_db->ExecSQL($sql);
			}
		}

		function GravarPropriedades(&$_page, $cod_objeto, $cod_classe, $proplist, $array_files='')
		{
			global $_FILES;
			
			if (!is_array($array_files))
			{
				$array_files= $_FILES;
				$source='post';
			}
			else
			{
				$source='string';
			}
			
//			var_dump($proplist);
//			exit();
			
			if (is_array($proplist))
			{
				foreach ($proplist as $key=>$valor)
				{
					$ar_fld = explode (":",$key);
					if (strpos($ar_fld[1],"^")===false)
					{
						$info = $_page->_adminobjeto->PegaInfoSobrePropriedade($_page, $cod_classe, $ar_fld[1]);

						if ($info['tabela']=='tbl_text')
						{
							if (!preg_match('%(\<p|\<BR)%is',$valor))
								$valor=nl2br($valor);
						}
						if ($info['tabela']=='tbl_date')
						{
							$valor=ConverteData($valor,16);
						}
						if ($valor!="")
						{
							if ($valor == _VERSIONPROG)
								$valor = NULL;
							$valor=stripslashes($valor);
							if ($info['tabela']!='tbl_blob')
							{
								$sql = "insert into ".$info['tabela']." (cod_propriedade,cod_objeto,valor) values (".
									$info['cod_propriedade'].",".$cod_objeto.",".$info['delimitador'].$_page->_db->Slashes($valor).$info['delimitador'].")";
									$_page->_db->ExecSQL($sql);
							}
							else
							{
								if (!$this->tamanho_temp_blob) $this->tamanho_temp_blob = 1;
								$sql = "insert into ".$info['tabela']."(cod_propriedade,cod_objeto,arquivo,tamanho) values (".
									$info['cod_propriedade'].",".$cod_objeto.",".$info['delimitador'].$_page->_db->Slashes($valor).$info['delimitador'].",".$this->tamanho_temp_blob.")";
								$_page->_db->ExecSQL($sql);
// COPIA BLOB
// linhas adicionadas para 	copiar o objeto blob com novo codigo
								if ($this->codigo_temp_blob){
									$cod_temporario = $_page->_db->InsertID($info['tabela']);
									if (!$resultado=is_dir(_BLOBDIR.identificaPasta($cod_temporario)."/")) { //Verifica se a pasta existe
										mkdir(_BLOBDIR.identificaPasta($cod_temporario), 0700); //cria a pasta
									}
									copy(_BLOBDIR.identificaPasta($this->codigo_temp_blob)."/".$this->codigo_temp_blob.".".$this->tipo_temp_blob, _BLOBDIR.identificaPasta($cod_temporario)."/".$cod_temporario.".".$this->tipo_temp_blob);
									
// criar thumb do objeto copiado
									if (defined("_THUMBDIR"))
									{									
										if ($this->tipo_temp_blob=="jpg") $im = @imagecreatefromjpeg(_BLOBDIR.identificaPasta($cod_temporario)."/".$cod_temporario.".".$this->tipo_temp_blob);
										if ($this->tipo_temp_blob=="png") $im = @imagecreatefrompng(_BLOBDIR.identificaPasta($cod_temporario)."/".$cod_temporario.".".$this->tipo_temp_blob);
										if (!$im){}
										else
										{
											$x=ImageSX($im);
											$y=ImageSY($im);
											$width=_THUMBWIDTH;
											$height=ceil(_THUMBWIDTH*$y/$x);
											if ($this->tipo_temp_blob =="jpg")
												$newim = ImageCreateTrueColor($width,$height);
											else
												$newim=ImageCreate($width,$height);
											ImageCopyResized($newim,$im,0,0,0,0,$width,$height,$x,$y);
											$im=$newim;
											switch ($this->tipo_temp_blob)
											{
											case 'jpg':
												ImageJpeg($im,_THUMBDIR.$cod_temporario.'.'.$this->tipo_temp_blob,100);
												break;
											case 'png':
												ImagePNG($im,_THUMBDIR.$cod_temporario.'.'.$this->tipo_temp_blob);
												break;
											}
										}
									}
								} /* if */
// FIM COPIA BLOB
							} /* if */
						}
					}
					else
					{
						$ar_fld = explode("^",$ar_fld[1]);

						$info = $_page->_adminobjeto->PegaInfoSobrePropriedade($_page, $cod_classe, $ar_fld[0]);
						
						if ($info['tabela'] == "tbl_blob")
						{
						    $sql = "Select * from tbl_blob where cod_propriedade=".$info["cod_propriedade"]." and cod_objeto=".$cod_objeto;
						    $rs = $_page->_db->ExecSQL($sql);
						    
						    while ($row = $rs->FetchRow())
						    {

							$file_ext = $this->PegaExtensaoArquivo($row['arquivo']);

//							//Linhas abaixo alteradas para encontrar o blob dentro da subpasta numerada
							if (file_exists(_BLOBDIR."/".identificaPasta($row['cod_blob'])."/".$row['cod_blob'].'.'.$file_ext))
								$checkDelete = unlink(_BLOBDIR."/".identificaPasta($row['cod_blob'])."/".$row['cod_blob'].'.'.$file_ext);
							if (defined ("_THUMBDIR"))
							{
								if (file_exists(_THUMBDIR.$row['cod_blob'].'.'.$file_ext))
									unlink(_THUMBDIR.$row['cod_blob'].'.'.$file_ext);
							}


						    }
						}
						
						$sql = "delete from ".$info['tabela']." where cod_propriedade=".$info['cod_propriedade'].
								" and cod_objeto=$cod_objeto";
						$_page->_db->ExecSQL($sql);
						
					}
				}
			}
			
			if (is_array($array_files))
			{
				
				//dump ($array_files);
				foreach ($array_files as $key=>$valor)
				{
					if ($valor['size'])
					{
						$ar_fld = explode (":",$key);
						$info = $_page->_adminobjeto->PegaInfoSobrePropriedade($_page, $cod_classe, $ar_fld[1]);
						if ($valor!="")
						{
							$sql = "delete from ".$info['tabela']." where cod_propriedade=".$info['cod_propriedade'].
									" and cod_objeto=$cod_objeto";
							$_page->_db->ExecSQL($sql);
							if ($source=='post')
								$data = fread(fopen($valor['tmp_name'], "rb"), filesize($valor['tmp_name']));
							else
								$data = stripslashes($valor['data']);
							//preg_match("/.*[\.](.*)\Z/i",$valor['name'], $extensao);
							//fclose($fp);

							if (!defined ("_BLOBDIR"))
							{
								$campo = gzcompress($data);
								$sql = "insert into ".$info['tabela']."(cod_propriedade,cod_objeto,valor,arquivo,tamanho) values (".
								$info['cod_propriedade'].",".$cod_objeto.",".$info['delimitador'].$_page->_db->BlobSlashes($data).$info['delimitador'].",'".$valor['name']."',".filesize($valor['tmp_nsme']).")";
								$_page->_db->ExecSQL($sql);
							}
							else
							{
								$campos = array();
								$campos['cod_propriedade'] = (int)$info['cod_propriedade'];
								$campos['cod_objeto'] = (int)$cod_objeto;
								$campos['arquivo'] = strtolower($valor['name']);
								$campos['tamanho'] = filesize($valor['tmp_name']);
								
								$name = $_page->_db->Insert($info['tabela'],$campos);
								$filetype=$this->PegaExtensaoArquivo($valor['name']);

// Linha abaixo alterada para gravar o blob na subpasta numerada
								$subpasta = identificaPasta($name);  //Pega o nome da subpasta
								if (!$resultado=is_dir(_BLOBDIR."/".$subpasta."/")) { //Verifica se a pasta existe
									mkdir(_BLOBDIR."/".$subpasta, 0700); //cria a pasta
								}
								$fp=fopen(_BLOBDIR."/".$subpasta."/".$name.'.'.$filetype,"wb");
								fwrite($fp,$data);
								fclose($fp);
								if (defined("_THUMBDIR"))
								{
									if (in_array($filetype,array('png','jpg')))
									{
										$im = imagecreatefromstring($data);
										$x=ImageSX($im);
										$y=ImageSY($im);
										$width=_THUMBWIDTH;
										$height=ceil(_THUMBWIDTH*$y/$x);
										if ($filetype=='jpg')
											$newim = ImageCreateTrueColor($width,$height);
										else
											$newim=ImageCreate($width,$height);
										ImageCopyResized($newim,$im,0,0,0,0,$width,$height,$x,$y);
										$im=$newim;
										switch ($filetype)
										{
											case 'jpg':
												ImageJpeg($im,_THUMBDIR.$name.'.'.$filetype,100);
												break;

											case 'png':
												ImagePNG($im,_THUMBDIR.$name.'.'.$filetype);
												break;
										}
									}
								}
							}
						}
					}
				}
			}
			//exit;
		}

		function PegaExtensaoArquivo($nome)
		{
			if (preg_match('/\.(.+?)$/is',$nome,$matches))
				return strtolower($matches[1]);
			else 
				return '';	
		}
		
		function CriarObjeto(&$_page, $dados, $log=true, $array_files='')
		{
			$fieldlist = array();
			$valuelist = array();
			$tagslist = array();
			foreach ($dados as $key=>$value)
			{
				if ($key!="submit")
				{
					if ($key=="tags")
						$tagslist = split(",",$value);
					if (strpos($key,":"))
						$proplist[$key]=$value;
				}
				//$dados[$key]=stripslashes($dados[$key]);
			}
			
			if (strlen($dados['data_publicacao'])<9)
			{
				if (preg_match('|[\.-]|',$dados['data_publicacao']))
				{
					$dados['data_publicacao'].= ' 00:00:00';
				}
				else
				{
					$dados['data_publicacao'].= '000000';
				}
			}
			if (strlen($dados['data_validade'])<9)
			{
				if (preg_match('|[\.-]|',$dados['data_validade']))
				{
					$dados['data_validade'].= ' 00:00:00';
				}
				else
				{
					$dados['data_validade'].= '000000';
				}
			}	
			$noname = date("ymd-his"); 
			if ($dados['titulo']=="")
				$dados['titulo']=$noname;
			
			$campos = array();
			$campos['script_exibir'] = $dados['script_exibir'];
			$campos['cod_pai'] = $dados['cod_pai'];
			$campos['cod_classe'] = $dados['cod_classe'];
			$campos['cod_usuario'] = $dados['cod_usuario'];
			$campos['cod_pele'] = $dados['cod_pele']+0;
			$campos['cod_status'] = $dados['cod_status'];
			$campos['titulo'] = $dados['titulo'];
			$campos['descricao'] = $dados['descricao'];
			$campos['data_publicacao']= ConverteData($dados['data_publicacao'],27);
			$campos['data_validade']= ConverteData($dados['data_validade'],27);
			$campos['peso'] = $dados['peso']+0;
			
			$cod_objeto = $_page->_db->Insert('objeto',$campos);
			
			$this->GravarPropriedades($_page, $cod_objeto, $dados['cod_classe'], $proplist, $array_files);

			$this->CriaParentesco($_page, $cod_objeto, $dados['cod_pai']);
			
			$this->GravarTags($_page, $cod_objeto, $tagslist);
			
			if ($this->ClasseIndexavel($_page, $dados['cod_classe']) && $dados['cod_status'] == _STATUS_PUBLICADO)
			{
				if (!is_object($this->index))
					$this->index= new index();
				$this->index->record_index($_page, $cod_objeto);
			}
			
			if ($log)
				$_page->_log->IncluirLogObjeto($_page, $cod_objeto,_OPERACAO_OBJETO_CRIAR);
			return $cod_objeto;
		}

		function GravarTags(&$_page, $cod_objeto, $tagslist)
		{
			if (!is_object($this->index))
					$this->index= new index();
			if (is_array($tagslist) && count($tagslist)>=1)
			{
				$this->ApagarTags($_page, $cod_objeto);
				
				foreach ($tagslist as $tag)
				{
					$tag = trim($this->index->clean($tag));
					$sql = "select cod_tag from tag where nome_tag='".$tag."'";
					$rs = $_page->_db->ExecSQL($sql);
					if ($rs->_numOfRows == 0)
					{
						$cod_tag = $_page->_db->Insert("tag", array("nome_tag"=>$tag));
					}
					else
					{
						$row = $rs->FetchRow();
						$cod_tag = $row["cod_tag"];
					}
					
					$sql = "insert into tagxobjeto (cod_tag, cod_objeto) values (".$cod_tag.",".$cod_objeto.")";
					$rs = $_page->_db->ExecSQL($sql);
				}
			}
		}
		
		function ApagarTags(&$_page, $cod_objeto)
		{
			$sql = "delete from tagxobjeto where cod_objeto=".$cod_objeto;
			$rs = $_page->_db->ExecSQL($sql);
			
			$sql = "delete from tag where cod_tag not in (select cod_tag from tagxobjeto)";
			$rs = $_page->_db->ExecSQL($sql);
		}
		
		function ApagarParentesco(&$_page, $cod_objeto)
		{
			$_page->_db->ExecSQL("delete from parentesco where cod_objeto =".$cod_objeto);
		}

		function CriaParentesco(&$_page, $cod_objeto, $cod_pai)
		{
			$sql = "insert into parentesco(cod_objeto,cod_pai,ordem) select $cod_objeto,cod_pai,ordem+1 from parentesco where cod_objeto=$cod_pai";
			$_page->_db->ExecSQL($sql);
			$sql = "insert into parentesco(cod_objeto,cod_pai,ordem) values ($cod_objeto,$cod_pai,1)";
			$_page->_db->ExecSQL($sql);
		}

		function ClasseIndexavel(&$_page, $cod_classe)
		{
		 	$this->CarregaClasses($_page);
			return (in_array($cod_classe, $this->classesIndexaveis));
		}

		function ApagarObjeto(&$_page, $cod_objeto, $definitivo=false)
		{
			if ($this->ObjetoIndexado($_page, $cod_objeto))
			{
				if (!is_object($this->index))
					$this->index = new index();
				$this->index->delete_index($cod_objeto);
			}
			if (!$definitivo)
			{
	            $sql = "select parentesco.cod_objeto, cod_status 
	            from parentesco inner join objeto on parentesco.cod_objeto=objeto.cod_objeto 
	            where parentesco.cod_pai=$cod_objeto 
	            or parentesco.cod_objeto=$cod_objeto";
				$res = $_page->_db->ExecSQL($sql);
				
				while ($row = $res->FetchRow())
				{
					if ($this->ObjetoIndexado($_page, $row["cod_objeto"]))
					{
						if (!is_object($this->index))
							$this->index = new index();
						$this->index->delete_index($row["cod_objeto"]);
					}
					
					$sql = "update objeto set apagado=1, data_exclusao='".date("Y-m-d H:i:s")."' ";
					if ($row['cod_status']==_STATUS_SUBMETIDO)
					{
						$_page->_db->ExecSQL("delete from pendencia where cod_objeto=".$row["cod_objeto"]);
					 	$sql .=", cod_status="._STATUS_PRIVADO;
					}
					$sql .= " where cod_objeto=".$row["cod_objeto"];

					$_page->_db->ExecSQL($sql);
				}
			}
			else
			{
				$sql = "delete from tagxobjeto where cod_objeto=".$cod_objeto;
				$rs = $_page->_db->ExecSQL($sql);
				$this->ApagarPropriedades($_page, $cod_objeto, true);
				$sql = "delete from objeto where cod_objeto=$cod_objeto";
				$_page->_db->ExecSQL($sql);
                $sql = "select cod_objeto from parentesco where cod_pai=$cod_objeto";
				$res = $_page->_db->ExecSQL($sql);
				$row = $res->GetRows();
				for ($m=0; $m<sizeof($row); $m++)
				{
					if ($this->ObjetoIndexado($_page, $row[$m]["cod_objeto"]))
					{
						if (!is_object($this->index))
							$this->index = new index();
						$this->index->delete_index($row[$m]["cod_objeto"]);
					}
					$this->ApagarPropriedades($_page, $row[$m]['cod_objeto'],true);
					$sql = "delete from objeto where cod_objeto=".$row[$m]['cod_objeto'];
					$_page->_db->ExecSQL($sql);
				}
				$this->ApagarParentesco($_page, $cod_objeto);
			}
			$_page->_log->IncluirLogObjeto($_page, $cod_objeto,_OPERACAO_OBJETO_REMOVER);
		}

		function ObjetoIndexado(&$_page, $cod_objeto)
		{
			$sql = "select indexar from classe left join objeto on objeto.cod_classe=classe.cod_classe
					where cod_objeto=$cod_objeto";
			$rs = $_page->_db->ExecSQL($sql);
			$row = $rs->fields;
			return $row['indexar'];
		}

		function UsuarioEDono(&$_page, $cod_usuario,$cod_objeto)
		{
			$sql = "select cod_objeto from objeto where cod_objeto=$cod_objeto and cod_usuario=$cod_usuario";
			$rs = $_page->_db->ExecSQL($sql);
			if ($rs->_numOfRows > 0)
				return true;
			else
				return false;
		}
		 
		function QuemEDono(&$_page, $cod_objeto)
		{
			$sql = "select usuario.cod_usuario as cod_usuario, usuario.nome as nome, usuario.email as email, usuario.login as login, usuario.chefia as chefia, usuario.valido as valido from objeto inner join usuario on usuario.cod_usuario = objeto.cod_usuario where cod_objeto=".$cod_objeto;
			$rs = $_page->_db->ExecSQL($sql);
			return $rs->GetRows(); 
		}

		function RejeitarObjeto(&$_page, $mensagem, $cod_objeto)
		{
			if (($_SESSION['usuario']['perfil']==_PERFIL_ADMINISTRADOR) || ($_SESSION['usuario']['perfil']==_PERFIL_EDITOR)
				|| (($_SESSION['usuario']['perfil']==_PERFIL_AUTOR) && $this->UsuarioEdono($_page, $_SESSION['usuario']['cod_usuario'], $cod_objeto)))
			{
				$this->TrocaStatusObjeto($_page, $mensagem, $cod_objeto, _STATUS_REJEITADO);
				$_page->_db->ExecSQL("delete from pendencia where cod_objeto=".$cod_objeto);
			}
		}

		function PublicarObjeto(&$_page, $mensagem, $cod_objeto)
		{			
			if (($_SESSION['usuario']['perfil']==_PERFIL_ADMINISTRADOR) || ($_SESSION['usuario']['perfil']==_PERFIL_EDITOR))
			{

				$this->TrocaStatusObjeto($_page, $mensagem, $cod_objeto, _STATUS_PUBLICADO);
				$_page->_db->ExecSQL("delete from pendencia where cod_objeto=".$cod_objeto);
				
				if ($this->ObjetoIndexado($_page, $cod_objeto))
				{
					if (!is_object($this->index))
						$this->index = new index();
					$this->index->record_index($_page, $cod_objeto);
				}
				
				if (defined("_avisoPublicacao") && _avisoPublicacao==true) {
					$objetoPublicado = new Objeto($_page, $cod_objeto);
					$array_objeto = null;
					$array_objeto[] = array($objetoPublicado->metadados["cod_objeto"], $objetoPublicado->metadados["titulo"]);
					$caminhoObjeto = $_page->_adminobjeto->PegaIDPai($_page, $cod_objeto, 100, array(0));
					foreach ($caminhoObjeto as $codigo=>$titulo) {
						$array_objeto[] = array($codigo, $titulo);
					}

					$mensagemEmail = "<html><head><title>Objeto Publicado</title></head>
					<body>
					Objeto publicado no site: <b>"._PORTAL_NAME."</b><br>
					Data: ".date("d/m/Y H:i:s")."<br>
					Objeto: <a href=\""._URL."/index.php/content/view/".$array_objeto[0][0].".html\" target=\"_blank\">".$array_objeto[0][1]."</a><br><br>
					Caminho do objeto: <br>";
					
					for ($i=1; $i<sizeof($array_objeto); $i++) {
						$mensagemEmail .= $i." - <a href=\""._URL."/index.php/content/view/".$array_objeto[$i][0].".html\" target=\"_blank\">".$array_objeto[$i][1]."</a><br>";
					}
					
					$mensagemEmail .= "<br><small>Mensagem gerada automaticamente. N�o responda.</small>
					</body></html>";
					
					$destinatario = _emailAvisoPublicacao;
					$remetente =  _remetenteAvisoPublicacao;
					$assunto = "Objeto publicado no site: "._PORTAL_NAME;
					$wassent = EnviarEmail($remetente, $destinatario, $assunto, $mensagemEmail); 
					
				}
			}
		}

		function DesPublicarObjeto(&$_page, $mensagem, $cod_objeto)
		{			
			if (($_SESSION['usuario']['perfil']==_PERFIL_ADMINISTRADOR) || ($_SESSION['usuario']['perfil']==_PERFIL_EDITOR))
				$this->TrocaStatusObjeto($_page, $mensagem, $cod_objeto, _STATUS_PRIVADO);
			
			if ($this->ObjetoIndexado($_page, $cod_objeto))
			{
				if (!is_object($this->index))
					$this->index = new index();
				$this->index->delete_index($cod_objeto);
			}
		}
			
		function SubmeterObjeto(&$_page, $mensagem, $cod_objeto)
		{
			$dadosObjeto = $_page->_adminobjeto->PegaDadosObjetoPeloID($_page, $cod_objeto);

			if ((($_SESSION['usuario']['perfil']==_PERFIL_AUTOR) || ($this->UsuarioEdono($_page, $_SESSION['usuario']['cod_usuario'],$cod_objeto))) && ($dadosObjeto['cod_status'] == _STATUS_PRIVADO))
			{
				$this->TrocaStatusObjeto($_page, $mensagem, $cod_objeto, _STATUS_SUBMETIDO);
				
				$sql = "select ".$_SESSION["usuario"]["chefia"]." as cod_usuario,".$cod_objeto." as cod_objeto from usuarioxobjetoxperfil inner join parentesco on (usuarioxobjetoxperfil.cod_objeto=parentesco.cod_pai or usuarioxobjetoxperfil.cod_objeto=parentesco.cod_objeto) where parentesco.cod_objeto=".$cod_objeto." and cod_perfil="._PERFIL_EDITOR." group by cod_usuario, cod_usuario";
				$rs = $_page->_db->ExecSQL($sql, 1, 1);
				$campos = $rs->fields;	
				
				$sql = "select * from pendencia where cod_usuario = ".$campos['cod_usuario']." and cod_objeto = ".$campos['cod_objeto'];
				$rs = $_page->_db->ExecSQL($sql);
				
				if (!$rs->GetRows()) {
										
				$sql = "insert into pendencia(cod_usuario, cod_objeto) values (".$campos['cod_usuario'].", ".$campos['cod_objeto'].")";
				$_page->_db->ExecSQL($sql);
				
				}
				
				$EnviaEmailSolicitacao = $_page->_adminobjeto->EnviaEmailSolicitacao($_page, $_SESSION['usuario']['chefia'], $cod_objeto, $mensagem);
			}
		}

		function RemovePendencia(&$_page, $mensagem, $cod_objeto)
		{
			$this->TrocaStatusObjeto($_page, $mensagem, $cod_objeto, _STATUS_PRIVADO);
			$sql = "delete from pendencia where cod_objeto = ".$cod_objeto;
			$_page->_db->ExecSQL($sql);
		}
		
		function TrocaStatusObjeto(&$_page, $mensagem, $cod_objeto, $cod_status)
		{
			if ($cod_objeto != _ROOT)
			{
				$_page->_db->ExecSQL("update objeto set cod_status=".$cod_status." where cod_objeto=$cod_objeto");
				$_page->_log->RegistraLogWorkFlow($_page, $mensagem, $cod_objeto, $cod_status);
			}
		}

		function PegaStatusNovoObjeto()
		{
			if ($_SESSION['usuario']['perfil']==_PERFIL_AUTOR)
			{
				$status=_STATUS_PRIVADO;
			}
			else
			{
				$status = _STATUS_PUBLICADO;
			}
			return $status;
		}

		function CopiarObjeto(&$_page, $cod_objeto, $cod_pai)
		{
			$this->DuplicarObjeto($_page, $cod_objeto, $cod_pai);
			$this->RemoveObjetoDaPilha($_page, $cod_objeto);
		}

		function MoverObjeto(&$_page, $cod_objeto, $cod_pai)
		{
			if ($cod_objeto==-1)
			{
				$cod_objeto=$this->PegaPrimeiroDaPilha($_page);
			}
			
			$sql = "update objeto set cod_pai=$cod_pai where cod_objeto=$cod_objeto";
			$_page->_db->ExecSQL($sql);

			$this->ApagarParentesco($_page, $cod_objeto);
			$this->CriaParentesco($_page, $cod_objeto, $cod_pai);
			
			$sql = "select objeto.cod_pai,objeto.cod_objeto from objeto inner join parentesco on objeto.cod_objeto=parentesco.cod_objeto 
					where parentesco.cod_pai=".$cod_objeto." group by objeto.cod_objeto, objeto.cod_pai";
			$res = $_page->_db->ExecSQL($sql);
			$row = $res->GetRows();
			for ($i=0; $i<sizeof($row); $i++)
			{
				$this->ApagarParentesco($_page, $row[$i]['cod_objeto']);
				$this->CriaParentesco($_page, $row[$i]['cod_objeto'], $row[$i]['cod_pai']);
			}
			
			$this->RemoveObjetoDaPilha($_page, $cod_objeto);
		}

		function ColarComoLink(&$_page, $cod_objeto, $cod_pai)
		{
			if ($cod_objeto==-1)
			{
				$cod_objeto=$this->PegaPrimeiroDaPilha($_page);
			}

			$orig_obj = $_adminobjeto->CriarObjeto($_page, $cod_objeto);
			$dados = $orig_obj->metadados;
			
			$status = $this->PegaStatusNovoObjeto();
			
			$campos=array();

			$campos['cod_pai'] = $cod_pai;
			$campos['cod_classe'] = _Interlink;
			$campos['cod_usuario'] = $dados['cod_usuario'];
			$campos['cod_pele'] = ($dados['cod_pele']+0);
			$campos['cod_status'] = $dados['cod_status'];
			$campos[' titulo'] = $_page->_db->Slashes($dados['titulo']);
			$campos['descricao'] = $_page->_db->Slashes($dados['descricao']);
			$campos['data_publicacao'] = ConverteData($dados['data_publicacao'],27);
			$campos['data_validade'] = ConverteData($dados['data_validade'],27);
			
			$novo_cod_objeto = $_page->_db->Insert('objeto',$campos);		
		
			$this->GravarPropriedades($_page, $novo_cod_objeto, _Interlink, array('property:endereco'=>"$cod_objeto"));
			$this->RemoveObjetoDaPilha($_page, $cod_objeto);
			$this->CriaParentesco($_page, $novo_cod_objeto, $cod_pai);
		}

		function PegaPrimeiroDaPilha(&$_page)
		{
			$sql = "select pilha.cod_objeto from pilha
					where pilha.cod_usuario=".$_SESSION['usuario']['cod_usuario'];
			$rs = $_page->_db->ExecSQL($sql);
			$row = $rs->fields;
			return $row['cod_objeto'];
		}

		function DuplicarObjeto(&$_page, $cod_objeto, $cod_pai=-1)
		{
			if ($cod_objeto==-1)
			{
				$cod_objeto=$this->PegaPrimeiroDaPilha($_page);
			}

			$orig_obj = $_page->_adminobjeto->CriarObjeto($_page, $cod_objeto);
			$dados = $orig_obj->metadados;
			
			if ($cod_pai==-1)
				$cod_pai=$dados['cod_pai'];

			$campos = array();
			$campos['script_exibir'] = $dados['script_exibir'];
			$campos['cod_pai'] = $cod_pai;
			$campos['cod_classe'] = $dados['cod_classe'];
			$campos['cod_usuario'] = $dados['cod_usuario'];
			$campos['cod_pele'] = ($dados['cod_pele']+0);
			$campos['cod_status'] = $dados['cod_status'];
			$campos[' titulo'] = $_page->_db->Slashes($dados['titulo']);
			$campos['descricao'] = $_page->_db->Slashes($dados['descricao']);
			$campos['data_publicacao'] = ConverteData($dados['data_publicacao'],27);
			$campos['data_validade'] = ConverteData($dados['data_validade'],27);
			$campos['peso'] = $dados['peso'];
			
			$cod_objeto = $_page->_db->Insert('objeto',$campos);	

			$this->DuplicarPropriedades($_page, $cod_objeto, $orig_obj);
			$this->CriaParentesco($_page, $cod_objeto, $cod_pai);
			
			if ($orig_obj->PegaListaDeFilhos($_page))
			{
				while ($childobj = $orig_obj->PegaProximoFilho())
				{
					$this->DuplicarObjeto($_page, $childobj->Valor($_page, "cod_objeto"), $cod_objeto);
				}
			}
			if ($this->ClasseIndexavel($_page, $dados['cod_classe']) && $dados['cod_status'] == _STATUS_PUBLICADO)
			{
				if (!is_object($this->index))
					$this->index= new index();
				$this->index->record_index($_page, $cod_objeto);
			}
			$_page->_log->IncluirLogObjeto($_page, $cod_objeto, _OPERACAO_OBJETO_CRIAR);
			return $cod_objeto;
		}

		function DuplicarPropriedades(&$_page, $destino, $origem)
		{
			$propriedades = $origem->PegaListaDePropriedades($_page);
			foreach ($propriedades as $nome => $valor)
			{
				if ($valor["tipo"]=="tbl_objref" && isset($valor["referencia"]))
				{
					$lista['property:'.$nome] = $valor['referencia'];
				}
				else
				{
// adicionado para duplicar os blobs no caso de copias
					if ($valor["tipo"] == "tbl_blob" && isset($valor["cod_blob"]))
					{
						$this->codigo_temp_blob = $valor['cod_blob'];
						$this->tipo_temp_blob = $valor['tipo_blob'];
						$this->tamanho_temp_blob = $valor['tamanho_blob'];
					}
					$lista["property:".$nome] = $valor["valor"];
				}
			}
			$this->GravarPropriedades($_page, $destino, $origem->Valor($_page, "cod_classe"), $lista);
		}

		function ListaDeClassesPermitidas(&$_page, $cod_classe)
		{
			$out=array();
			$sql = "select cod_classe_filho, classe.nome, classe.descricao,classe.prefixo from classexfilhos
					inner join classe on classe.cod_classe=classexfilhos.cod_classe_filho
					where classexfilhos.cod_classe=$cod_classe order by classe.nome";
			$res = $_page->_db->ExecSQL($sql);
			return $res->GetRows();
		}

		function ListaDeClassesPermitidasNoObjeto(&$_page, $cod_objeto)
		{
			$out=array();
			$sql = "select classe.cod_classe,classe.nome, classe.descricao,classe.prefixo from classexobjeto
					inner join classe on classe.cod_classe=classexobjeto.cod_classe
					where classexobjeto.cod_objeto=$cod_objeto order by classe.nome";
			$rs = $_page->_db->ExecSQL($sql);
			return $rs->GetRows();
		}

		function CopiarObjetoParaPilha(&$_page, $cod_objeto)
		{
			$sql = "insert into pilha (cod_objeto,cod_usuario) values($cod_objeto,".$_SESSION['usuario']['cod_usuario'].")";
			$_page->_db->ExecSQL($sql);
		}

		function RemoveObjetoDaPilha(&$_page, $cod_objeto)
		{
			$sql = "delete from pilha where cod_usuario=".$_SESSION['usuario']['cod_usuario']." and cod_objeto=$cod_objeto";
			$_page->_db->ExecSQL($sql);
		}

		function LimparPilha(&$_page)
		{
			$sql = "delete from pilha where cod_usuario=".$_SESSION['usuario']['cod_usuario'];
			$_page->_db->ExecSQL($sql);
		}

		function PegaPilha(&$_page)
		{
			$result=array();
			$this->ContadorPilha=0;
			$sql = "select pilha.cod_objeto as codigo, objeto.titulo as texto from pilha
					left join objeto on objeto.cod_objeto=pilha.cod_objeto
					where pilha.cod_usuario=".$_SESSION['usuario']['cod_usuario'];
			$rs = $_page->_db->ExecSQL($sql);
			$row = $rs->GetRows();
			for ($i=0; $i<sizeof($row); $i++)
			{
				$this->ContadorPilha++;
				$result[]=$row[$i];
			}
			return $result;
		}

		function TemPilha(&$_page)
		{
			if (!$this->ContadorPilha)
			{
				$sql = "select count(*) as contador from pilha where cod_usuario=".$_SESSION['usuario']['cod_usuario'];
				$rs = $_page->_db->ExecSQL($sql);
				$this->ContadorPilha = $rs->fields["contador"];
			}
			return $this->ContadorPilha;

		}

		function DropDownPilha(&$_page, $selecionado='', $branco=false)
		{
			$lista = $this->PegaPilha($_page);
			return $this->CriaDropDown($lista, $selecionado, $branco);
		}

		function PegaInfoDaClasse(&$_page, $cod_classe)
		{
			$sql = "select * from classe where cod_classe=$cod_classe order by classe.nome";
			$rs = $_page->_db->ExecSQL($sql);
			$result['classe'] = $rs->fields;
			$sql = "select cod_classe,nome from classe order by nome";
			$rs = $_page->_db->ExecSQL($sql);
			$row = $rs->GetRows();
			for ($i=0; $i<sizeof($row); $i++)
			{
				$result['todas'][$row[$i]['cod_classe']]=$row[$i];
			}
			$sql = "select cod_classe_filho from classexfilhos where cod_classe=$cod_classe";
			$rs = $_page->_db->ExecSQL($sql);
			$row = $rs->GetRows();
			for ($i=0; $i<sizeof($row); $i++)
			{
				$result['todas'][$row[$i]['cod_classe_filho']]['permitido']=true;
			}

			$sql = "select cod_classe from classexfilhos where cod_classe_filho=$cod_classe";
			$rs = $_page->_db->ExecSQL($sql);
			$row = $rs->GetRows();
			for ($i=0; $i<sizeof($row); $i++)
			{
				$result['todas'][$row[$i]['cod_classe']]['criadoem']=true;
			}


			$prop = $this->PegaPropriedadesDaClasse($_page, $cod_classe);
			$count=1;
			$result['prop']=array();
			if (is_array($prop))
			{
				foreach($prop as $value)
				{
					$result['prop'][$value['nome']]=$value;
				}
			}
			//$result['prop_conta']=$count-1;

			$sql = "select count(cod_objeto) as cnt from objeto where cod_classe=$cod_classe";
			$rs = $_page->_db->ExecSQL($sql);
			$result['obj_conta'] = $rs->fields["cnt"];

			$sql = "select objeto.cod_objeto, objeto.titulo from classexobjeto
					inner join objeto on classexobjeto.cod_objeto=objeto.cod_objeto where classexobjeto.cod_classe=$cod_classe";
			$res = $_page->_db->ExecSQL($sql);
			$row = $res->GetRows();
			for ($k=0; $k<sizeof($row); $k++)
			{
				$result['objetos'][]=$row[$k];
			}
			
			return $result;
		}

		function DropDownTipoDado(&$_page, $selecionado, $branco=false)
		{
			$lista=$this->PegaListaDeTipoDado($_page);
			return $this->CriaDropDown($lista, $selecionado, $branco);
		}

		function PegaListaDeTipoDado(&$_page)
		{
			$sql = "select cod_tipodado as codigo, nome as texto from tipodado order by nome";
			$rs = $_page->_db->ExecSQL($sql);
			return $rs->GetRows();
		}

		function DropDownClasses(&$_page, $selecionado, $branco=false)
		{
			$lista = $this->PegaListaDeClasses($_page);
			return $this->CriaDropDown($lista,$selecionado,$branco);
		}

		function PegaListaDeClasses(&$_page)
		{
			$this->CarregaClasses($_page);

			foreach ($this->classesNomes as $texto => $codigo)
				$saida[]=array ('codigo'=>$codigo,'texto'=>$texto);

			return $saida;
		}

		function CheckBoxClasses(&$_page, $nome, $lista, $flag, $habilitado=true)
		{
			$codigo='cod_classe';
			$texto='nome';
			$selecionado=$flag;
			if (!is_array($lista))
			{
				$lista=$this->PegaListaDeClasses($_page);
				$codigo='codigo'; 
				$texto='texto';
				$selecionado='selecionado';
			}
			return $this->CriaCheckBox($nome,$lista,$codigo,$texto,$selecionado,$habilitado);
		}

		function CriaCheckBox($nome,$lista,$codigo='codigo',$texto='texto',$selecionado='selecionado',$habilitado=true)
		{
			if (!$habilitado)
				$txt=" disabled ";
			foreach ($lista as $item)
			{
				$result.= '<input '.$txt.'type="checkbox" name="'.$nome.'" value="'.$item[$codigo].'"';
				if ($item[$selecionado])
					$result.=" checked ";
				$result.='>'.$item[$texto]."<BR>";
			}
			return $result;
		}

		function PegaListaDePrefixos(&$_page, $cod_classe)
		{
			$result=array();
			$sql = "select prefixo from classe where cod_classe<>$cod_classe";
			$rs = $_page->_db->ExecSQL($sql);
			$row = $rs->GetRows();
			for ($i=0; $i<sizeof($row); $i++)
			{
				$result[]=$row[$i]['prefixo'];
			}
			return $result;
		}

		function ApagarPropriedadeDaClasse(&$_page, $cod_classe, $nome)
		{
			$sql = "select cod_propriedade,tipodado.tabela from propriedade
					left join tipodado on tipodado.cod_tipodado=propriedade.cod_tipodado
					where propriedade.nome='$nome' and propriedade.cod_classe=$cod_classe";
			$rs = $_page->_db->ExecSQL($sql);
			$row = $rs->fields;
			if ($row['tabela']=="tbl_blob")
			{
			    $sql = "select cod_blob,arquivo from tbl_blob where cod_propriedade=".$row['cod_propriedade'];
			    $rs2 = $_page->_db->ExecSQL($sql);
			    while ($row2 = $rs2->FetchRow())
			    {
				$file_ext = $this->PegaExtensaoArquivo($row2['arquivo']);

				if (file_exists(_BLOBDIR."/".identificaPasta($row2['cod_blob'])."/".$row2['cod_blob'].'.'.$file_ext))
				    $checkDelete = unlink(_BLOBDIR."/".identificaPasta($row2['cod_blob'])."/".$row2['cod_blob'].'.'.$file_ext);
				if (defined ("_THUMBDIR"))
				{
					if (file_exists(_THUMBDIR.$row2['cod_blob'].'.'.$file_ext))
					    unlink(_THUMBDIR.$row2['cod_blob'].'.'.$file_ext);
				}
                            }
                        }
			$sql = "delete from ".$row['tabela']." where cod_propriedade=".$row['cod_propriedade'];
			$_page->_db->ExecSQL($sql);
			$sql = "delete from propriedade where cod_propriedade=".$row['cod_propriedade'];
			$_page->_db->ExecSQL($sql);
		}

		function RenomearPropriedadeDaClasse(&$_page, $cod_classe, $nomeatual, $nome)
		{
			$sql = "update propriedade set nome='$nome' where nome='$nomeatual' and cod_classe=$cod_classe";
			$_page->_db->ExecSQL($sql);
		}

		function AcrescentarPropriedadeAClasse(&$_page, $cod_classe, $novo)
		{
			$sql = "insert into propriedade (cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao, rotulo, descricao, obrigatorio, seguranca, valorpadrao, rot1booleano, rot2booleano)
					values ($cod_classe,".($novo['cod_tipodado']+0).",'".($novo['cod_referencia_classe']+0)."','".$novo['campo_ref'].
					"','".$novo['nome']."','".($novo['posicao']+0)."','".
					$novo['rotulo']."','".$novo['descricao']."',".($novo['obrigatorio']+0).",".($novo['seguranca']+0).",'".trim($novo['valorpadrao'])."','".trim($novo['rot1booleano'])."','".trim($novo['rot2booleano'])."')";
					$_page->_db->ExecSQL($sql);
		}

		function AtualizarDadosDaPropriedade(&$_page, $cod_propriedade,$dados)
		{
			$sql = "update propriedade set 
					nome='".$dados['nome']."',
					rotulo='".$dados['rotulo']."', 
					descricao='".$dados['descricao']."', 
					valorpadrao='".trim($dados['valorpadrao'])."', 
					rot1booleano='".trim($dados['rot1booleano'])."', 
					rot2booleano='".trim($dados['rot2booleano'])."', 
					obrigatorio=".($dados['obrigatorio']+0).", 
					seguranca=".($dados['seguranca']+0).",  
					posicao=".($dados['posicao']+0)." 
					where cod_propriedade=".$cod_propriedade;
			$_page->_db->ExecSQL($sql);
		}
		
		function AtualizarInfoDaPropriedade(&$_page, $cod_classe, $novo)
		{
			$sql = "update propriedade set campo_ref='".$novo['cod_referencia_classe']."',
					posicao='".$novo['posicao']."' where cod_classe=$cod_classe and
					nome='".$novo['nome']."'";
			//echo "<p>$sql</p>";
			$_page->_db->ExecSQL($sql);
		}
		
		function DropDownUsuarioSecao(&$_page, $selecionado=0, $branco=false){
			$lista = $this->PegaListaDeSecao($_page);
			return $this->CriaDropDown($lista,$selecionado,$branco,40);
		}

		function PegaListaDeSecao(&$_page){
			$sql = "select DISTINCT secao as codigo, secao as texto from usuario where valido=1 and secao <> '' order by secao";
			$rs = $_page->_db->ExecSQL($sql);
			return $rs->GetRows();
		}
		
		function DropDownUsuarios(&$_page, $selecionado, $branco=false, $secao=NULL)
		{
			$lista=$this->PegaListaDeUsuarios($_page, $secao);
			return $this->CriaDropDown($lista,$selecionado,$branco,20);
		}

		function PegaListaDeUsuarios(&$_page, $secao=NULL)
		{
			if (!$secao)
				$sql = "select cod_usuario as codigo,nome as texto, chefia as intchefia from usuario where valido=1 order by  nome, secao";
			else 
				$sql = "select cod_usuario as codigo,nome as texto, chefia as intchefia from usuario where valido=1 and secao = '".$secao."' order by nome, secao";
			$rs = $_page->_db->ExecSQL($sql);
			return $rs->GetRows();
		}
		
		function PegaInformacaoUsuario(&$_page, $cod_usuario)
		{
			$sql = "select cod_usuario,nome,email,login,chefia,secao,ramal,data_atualizacao from usuario where cod_usuario=$cod_usuario";
			$rs = $_page->_db->ExecSQL($sql);
			return $rs->fields;
		}

		function ExisteOutroUsuario(&$_page, $login, $cod_usuario)
		{
			$sql = "select cod_usuario from usuario where login='$login' and valido<>0";
			if ($cod_usuario)
				$sql .=" and cod_usuario<>$cod_usuario ";
			$rs = $_page->_db->ExecSQL($sql);
			return !$rs->EOF;
		}

		function ApagarClasse(&$_page, $cod_classe)
		{
			$sql = "select cod_objeto from objeto where cod_classe=$cod_classe";
			$rs = $_page->_db->ExecSQL($sql);
			while ($row = $rs->FetchRow())
			{
					$this->ApagarObjeto($_page, $row['cod_objeto'],true);
			}
			$sql = "delete from propriedade where cod_classe=$cod_classe";
			$_page->_db->ExecSQL($sql);
			$sql  = "delete from classe where cod_classe=$cod_classe";
			$_page->_db->ExecSQL($sql);
		}

		function PegaDireitosDoUsuario(&$_page, $interCod_Usuario)
		{
			$sql = "select cod_objeto, 
			cod_perfil 
			from usuarioxobjetoxperfil 
			where cod_usuario=$interCod_Usuario";
			$rs = $_page->_db->ExecSQL($sql);
			if ($rs->_numOfRows>0){
				while (!$rs->EOF){
					$out[$rs->fields['cod_objeto']]=$rs->fields['cod_perfil'];
					$rs->MoveNext();
				}
			}
			return $out;
		}

		function PegaPerfilDoUsuarioNoObjeto(&$_page, $cod_usuario, $cod_objeto)
		{
			if (empty($cod_usuario))
				return false;
			$perfil = $this->PegaDireitosDoUsuario($_page, $cod_usuario);
			$caminho = explode(",", $_page->_adminobjeto->PegaCaminhoObjeto($_page, $cod_objeto));
			foreach ($perfil as $objeto => $cod_perfil)
			{
				if ((in_array($objeto,$caminho)))
					return $cod_perfil;
			}
			return false;
		}

		function AlterarPerfilDoUsuarioNoObjeto(&$_page, $cod_usuario, $cod_objeto, $perfil, $inserir=true)
		{
			$sql = "delete from usuarioxobjetoxperfil where cod_objeto=$cod_objeto and cod_usuario=$cod_usuario";
			$_page->_db->ExecSQL($sql);
			if ($inserir)
			{
				$sql = "insert into usuarioxobjetoxperfil (cod_usuario,cod_objeto,cod_perfil) values($cod_usuario,$cod_objeto,$perfil)";
				$_page->_db->ExecSQL($sql);
			}
		}

		function PegaListaDeApagados(&$_page, $start=-1, $limit=-1)
		{
			$out=array();
			$sql = "select cod_objeto,data_exclusao,titulo,cod_usuario,classe.nome as classe from objeto
					left join classe on classe.cod_classe=objeto.cod_classe
					where apagado=1 order by data_exclusao desc";
                        if ($limit!=-1 && $start!=-1){
                            $rs = $_page->_db->ExecSQL($sql, $start, $limit);
                        }else{
                            $rs = $_page->_db->ExecSQL($sql);
                        }
			$row = $rs->GetRows();
			for ($l=0; $l<sizeof($row); $l++){
				$row[$l]['exibir']="/index.php/content/view/".$row[$l]['cod_objeto'].".html";
				$out[]=$row[$l];
			}
			return $out;
		}

		function PegaListaDeVencidos(&$_page, $cod_usuario, $ord1="peso", $ord2="asc", $inicio=-1, $limite=-1, $cod_objeto=1)
		{
			$out=array();
			$sql = "select t1.cod_objeto,
			t1.titulo,
			t1.cod_usuario,
			t1.data_validade,
			t2.nome as classe 
			from objeto t1 
			inner join classe t2 on t2.cod_classe=t1.cod_classe 
			inner join parentesco t3 on t1.cod_objeto=t3.cod_objeto
			where t3.cod_pai=".$cod_objeto." 
			and t1.data_validade < ".date("Ymd")."000000 
			and t1.apagado=0
			order by t1.".$ord1." ".$ord2;
			$rs = $_page->_db->ExecSQL($sql, $inicio, $limite);
			$row = $rs->GetRows();
			for ($i=0; $i<sizeof($row); $i++)
			{
				$row[$i]['exibir']="/index.php?action=/content/view&cod_objeto=".$row[$i]['cod_objeto'];
				$out[]=$row[$i];

			}
			return $out;
		}

		function ApagarEmDefinitivo(&$_page, $cod_objeto)
		{
			$this->ApagarTags($_page, $cod_objeto);
			$sql = "select cod_objeto from parentesco where cod_pai=$cod_objeto";
			$res=$_page->_db->ExecSQL($sql);
			$row = $res->GetRows();
			for ($c=0; $c<sizeof($row); $c++)
			{
				$this->ApagarTags($_page, $row[$c]["cod_objeto"]);
				$sql = "delete from objeto where cod_objeto=".$row[$c]["cod_objeto"];
				$_page->_db->ExecSQL($sql);
				$this->ApagarPropriedades($_page, $row[$c]["cod_objeto"]);
			}
			$this->ApagarPropriedades($_page, $cod_objeto);
			$_page->_db->ExecSQL("delete from parentesco where cod_objeto=$cod_objeto");
            $_page->_db->ExecSQL("delete from objeto where cod_objeto=$cod_objeto");
		}

		function PegarFolderTemporario(&$_page)
		{
			$sql = 'select cod_objeto from objeto where titulo="Itens Recuperados" and cod_pai='._ROOT;
			$res = $_page->_db->ExecSQL($sql);
			$row = $res->fields;
			if (!$row['cod_objeto'])
			{
				$dados['titulo']="Itens Recuperados";
				$dados['cod_pai']=_ROOT;
				$dados['cod_classe']=1;
				$dados['cod_usuario']=1;
				$dados['data_publicacao']=date('Ymd000000');
				$dados['data_validade']='20361231000000';
				$dados['cod_status']=_STATUS_PRIVADO;
				return $this->CriarObjeto($_page, $dados);
			}
			else
			{
				return $row['cod_objeto'];
			}
		}
		
		function RecuperarObjeto(&$_page, $cod_objeto)
		{
            $sql = "select parentesco.cod_objeto, 
            cod_status, 
            cod_classe 
            from parentesco 
            inner join objeto on parentesco.cod_objeto=objeto.cod_objeto 
            where parentesco.cod_pai=$cod_objeto 
            or parentesco.cod_objeto=$cod_objeto";
			$res=$_page->_db->ExecSQL($sql);
			$row = $res->GetRows();
			for ($i=0; $i<sizeof($row); $i++)
			{
				$sql = "update objeto set apagado=0 ";
				$sql .= " where cod_objeto=".$row[$i]['cod_objeto'];
				$_page->_db->ExecSQL($sql);
				
				if ($this->ClasseIndexavel($_page, $row[$i]['cod_classe']) && $row[$i]['cod_status'] == _STATUS_PUBLICADO)
				{
					if (!is_object($this->index))
						$this->index= new index();
					$this->index->record_index($_page, $row[$i]['cod_objeto']);
				}
			}
					
			if ($this->ObjetoIndexado($_page, $cod_objeto))
			{
				if (!is_object($this->index))
					$this->index= new index();
				$this->index->record_index($_page, $cod_objeto);
			}
			$_page->_log->IncluirLogObjeto($_page, $cod_objeto, _OPERACAO_OBJETO_RECUPERAR);
		}
			
		function GetLogAccessList(&$_page, $cod_objeto='', $year='', $month='', $day='', $estado=NULL, $iporigem=NULL)
		{
			global $_page;
		
			switch ($estado){
				case 1:
					$sqlChoice .= " (";
					break;
				case 2:
					$sqlChoice .= " (cod_usuario = 12   OR";
					break;
				case 3:
					$sqlChoice .= " (cod_usuario = 13   OR";
					break;
				default:
					$sqlChoice .= " (cod_usuario = 13 OR cod_usuario = 12   OR";
					break;
			}
			
			switch ($iporigem){
				case 1:
					$sqlChoice .= "";
					break;				
				case 2:
					$sqlChoice .= " cod_usuario = 3 OR ";
					break;
				case 3:
					$sqlChoice .= " cod_usuario = 2 OR ";
					break;
				default:
					$sqlChoice .= " cod_usuario = 3 OR cod_usuario = 2 OR ";
					break;
			}
			$sqlChoice .= " cod_usuario = -1)";
						
			if ($year=='')
			{
				$year=date('Y');
			}

			$_page->_db->RegisterError(0);

			$month = sprintf("%02d",($month+0));
			$day = sprintf("%02d",$day);

			if ($cod_objeto=='')
				$cod_objeto = $_page->_objeto->Valor($_page, "cod_objeto");

			if ($cod_objeto!=_ROOT)
			{
				$sqlobj=" and (parentesco.cod_pai=$cod_objeto or parentesco.cod_objeto=$cod_objeto) ";
			}
			else
			{
				$sqlobj="";
			}
			$access_list=array();
			if ($distinct)
			{
				$conta = " distinct (cod_cookie)";
			}
			else
			{
				$conta =" distinct (cod_logacesso)";
			}

			//Log do Mes ou do Dia
			if ($month!='00')
			{
				$tabela = 'logacesso_'.$year.'_'.$month;
			    if ($day!='00')
				{
				// Get day log
					$sql=   "select count($conta) as counter, ".$_page->_db->Hour("estampa")." as adate
							from ".$tabela." as logacesso ";
                    if ($cod_objeto!=_ROOT)
					{
  						   $sql .= "inner join parentesco on parentesco.cod_objeto=logacesso.cod_objeto ";
					}
					$sql .= " where 1=1 AND $sqlChoice $sqlobj and ".$_page->_db->CreateDateTest("estampa","=",$year.$month.$day).
							" group by ".$_page->_db->Hour("estampa")." order by adate asc";
				}
			    else
				{
					$sql=   "select count($conta) as counter, ".$_page->_db->Day("estampa")." as adate
							from ".$tabela." as logacesso ";
                    if ($cod_objeto!=_ROOT)
					{
  						   $sql .= "inner join parentesco on parentesco.cod_objeto=logacesso.cod_objeto ";
					}
  					$sql .= " where 1=1 AND ".$sqlChoice.$sqlobj;
					$sql .= " group by ".$_page->_db->Day("estampa")." order by adate asc";
				}

			    $rs = $_page->_db->ExecSQL($sql);


				while ($row = $rs->FetchRow())
				{
					//dump ($row);
					if ($day!='00')
					{
						$row['adate']=substr($row['adate'],8,2);
					}
					else
					{
						if ($month=='00')
							$row['adate']=nome_do_mes(substr($row['adate'],4,2));
						else
							$row['adate']=substr($row['adate'],6,2);
					}
					$access_list[]=$row;
				}
			}
			else
			{
				if ($year==date('Y'))
					$limite=date('m');
				else
					$limite=12;

				for ($f=1;$f<=$limite;$f++)
				{
					$tabela = sprintf('logacesso_%d_%02d',$year,$f);
					$sql =   "  select count($conta) as counter
								from ".$tabela." as logacesso ";
                     if ($cod_objeto!=_ROOT)
					{
  						   $sql .= "inner join parentesco on parentesco.cod_objeto=logacesso.cod_objeto ";
					}
	   				$sql .=" where 1=1 AND".$sqlChoice.$sqlobj;
					$_page->_db->ExecSQL($sql);
					if (!$_page->_db->Error())
					{
						$row=$this->db->FetchAssoc();
						$access_list[]=array('counter'=>$row['counter'],'adate'=>nome_do_mes($f));
					}
				}
			}
			return $access_list;
			$this->db->RegisterError(2);
		}
		
		function ValidarPropriedades(&$_page, $cod_classe, $propriedades)
		{
			$lista = $this->PegaPropriedadesDaClasse($_page, $cod_classe);
			foreach ($lista as $prop)
			{
				if (($prop['obrigatorio']) && (!strlen($propriedades['prop:'.$prop['nome']])))
					return false;
			}
			return true;	
		}
	}
	
