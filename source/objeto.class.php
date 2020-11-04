<?php
	class Objeto
	{
		public $ponteiro=0;
		public $quantidade=0;
		public $CaminhoObjeto;
		public $metadados;
        public $ArrayMEtadados;

        function Objeto(&$_page, $cod_objeto=-1)
        {
            $this->__construct($_page, $cod_objeto);
        }

		function __construct(&$_page, $cod_objeto=-1)
		{
//            echo "AQUI";
			$this->ArrayMetadados=$_page->_db->metadados;
//            var_dump($_page);
			if ($cod_objeto!=-1)
			{
				if (is_numeric($cod_objeto))
				{
					$dados = $_page->_adminobjeto->PegaDadosObjetoPeloID($_page, $cod_objeto);
				}
				else
				{
					$dados = $_page->_adminobjeto->PegaDadosObjetoPeloTitulo($_page, $cod_objeto);
				}
				
				if (is_array($dados) && sizeof($dados)>2)
				{
					$this->povoar($_page, $dados);
					$this->CaminhoObjeto = explode(",",$this->PegaCaminho($_page));
					return true;
				}
				
			}

			//Nao conseguiu selecionar o objeto
			return false;
		}
		
		function povoar(&$_page, $dados)
		{
			$this->metadados=$dados;
			$this->metadados['data_publicacao']=ConverteData($this->metadados['data_publicacao'],1);
			$this->metadados['data_validade']=ConverteData($this->metadados['data_validade'],1);
            $this->metadados['url']='/index.php/content/view/'.$this->metadados['cod_objeto'].".html";
            $this->metadados['tags']=$_page->_adminobjeto->PegaTags($_page, $this->metadados['cod_objeto']);
//            echo "<pre>";
//            var_dump($this->metadados);
		}

		function PegaCaminho(&$_page)
		{
			return $_page->_adminobjeto->PegaCaminhoObjeto($_page, $this->metadados['cod_objeto']);
		}

		function PegaCaminhoComTitulo(&$_page)
		{
			$resultado=$_page->_adminobjeto->PegaCaminhoObjetoComTitulo($_page, $this->metadados['cod_objeto']);
			return $resultado;
		}

		function Publicado()
		{
			return ($this->metadados['cod_status']==_STATUS_PUBLICADO);
		}

		function Valor(&$_page, $campo)
		{
			if (in_array($campo,$this->ArrayMetadados))
			{
				return trim($this->metadados[$campo]);
			}
			elseif ($campo=="tags")
			{
			
			}
			else
			{
				return trim ($this->Propriedade($_page, $campo));
			}
		}
		
		function LinkDiretoBlob(&$_page, $campo)
		{
            if (!is_array($this->propriedades))
			{
				$this->propriedades = $_page->_adminobjeto->PegaPropriedades($_page, $this->metadados['cod_objeto']);
			}
			$subpasta = identificaPasta($this->propriedades[$campo]['cod_blob']);
			return _BLOBURL.$subpasta.'/'.$this->propriedades[$campo]['cod_blob'].'.'.$this->propriedades[$campo]['tipo_blob'];
		}

		function LinkBlob(&$_page, $campo)
		{
			//echo "Campo: $campo<br>";
			if (!is_array($this->propriedades))
			{
				$this->propriedades = $_page->_adminobjeto->PegaPropriedades($_page, $this->metadados['cod_objeto']);
			}
			//return _URL."/content/_downloadblob.php?cod_blob=".$this->propriedades[$campo]['cod_blob'];
			$subpasta = identificaPasta($this->propriedades[$campo]['cod_blob']);
			return _BLOBURL.$subpasta.'/'.$this->propriedades[$campo]['cod_blob'].'.'.$this->propriedades[$campo]['tipo_blob'];
		}

		function DownloadBlob(&$_page, $campo)
		{
			//echo "Campo: $campo<br>";
			if (!is_array($this->propriedades))
			{
				$this->propriedades = $_page->_adminobjeto->PegaPropriedades($_page, $this->metadados['cod_objeto']);
			}
			return _URL."/html/objects/_downloadblob.php?cod_blob=".$this->propriedades[$campo]['cod_blob'];
		}

		function ExibirBlob(&$_page, $campo, $width=0, $height=0)
		{
		     if (!is_array($this->propriedades))
			{
				$this->propriedades = $_page->_adminobjeto->PegaPropriedades($_page, $this->metadados['cod_objeto']);
			}
			return _URL."/html/objects/_viewblob.php?cod_blob=".$this->propriedades[$campo]['cod_blob']."&width=$width&height=$height";
			//return _BLOBURL.$this->propriedades[$campo]['cod_blob'].'.'.$this->propriedades[$campo]['tipo_blob'];
		}

		function ExibirThumb(&$_page, $campo, $width=0, $height=0)
		{
		    if (!is_array($this->propriedades))
			{
				$this->propriedades = $_page->_adminobjeto->PegaPropriedades($_page, $this->metadados['cod_objeto']);
			}
			return _URL."/html/objects/_viewthumb.php?cod_blob=".$this->propriedades[$campo]['cod_blob']."&width=$width&height=$height";
		}

		function ValorParaEdicao(&$_page, $campo)
		{
			if (in_array($campo,$this->ArrayMetadados))
			{
				return (trim($this->metadados[$campo]));
			}
			else
			{
				return (trim($this->Propriedade($_page, $campo)));
			}
		}

		function PegaListaDePropriedades(&$_page)
		{
			if (!is_array($this->propriedades))
			{
				$this->propriedades = $_page->_adminobjeto->PegaPropriedades($_page, $this->metadados['cod_objeto']);
			}
			return $this->propriedades;
		}

		function Propriedade(&$_page, $campo)
		{
			$campo=strtolower($campo);
			if (!isset($this->propriedades) || !is_array($this->propriedades))
			{
				$this->propriedades = $_page->_adminobjeto->PegaPropriedades($_page, $this->metadados['cod_objeto']);
			}
			return $this->propriedades[$campo]['valor'];
		}

		function TamanhoBlob(&$_page, $campo)
		{
			if (!is_array($this->propriedades))
			{
				$this->propriedades = $_page->_adminobjeto->PegaPropriedades($_page, $this->metadados['cod_objeto']);
			}
			return ($this->propriedades[$campo]['tamanho_blob']);
		}

		function TipoBlob(&$_page, $campo)
		{
			if (!is_array($this->propriedades))
			{
				$this->propriedades = $_page->_adminobjeto->PegaPropriedades($_page, $this->metadados['cod_objeto']);
			}
			return ($this->propriedades[$campo]['tipo_blob']);
		}
		
		function IconeBlob(&$_page, $campo)
		{
			$arquivo ='/html/imagens/icnx_'.$this->TipoBlob($_page, $campo).'.gif';
			if (file_exists($_SERVER['DOCUMENT_ROOT'].$arquivo))
				return $arquivo;
			else
				return '/html/imagens/icnx_generic.gif';
		
		}

		function PegaListaDeFilhos(&$_page, $classe='*',$ordem='peso,titulo',$inicio=-1,$limite=-1)
		{
			if ($this->metadados['temfilhos'])
			{
				$this->filhos = $_page->_adminobjeto->ListaFilhos($_page, $this->metadados['cod_objeto'], $classe, $ordem, $inicio, $limite);
				$this->ponteiro = 0;
				$this->quantidade = count($this->filhos);
				return $this->quantidade;
			}
			else
				return false;
		}

		function PodeTerFilhos()
		{
			return $this->metadados['temfilhos'];
		}

		function PegaProximoFilho()
		{
			if ($this->ponteiro < $this->quantidade)
				return $this->filhos[$this->ponteiro++];
			else
				return false;
		}

		function VaiParaFilho($posicao)
		{
			if ($posicao>$this->quantidade)
				return false;
			else
			{
				$this->ponteiro=$posicao;
				return $this->filhos[$this->ponteiro++];
			}
		}

		function EFilho (&$_page, $cod_pai)
		{
			//echo "cod_objeto:".$this->Valor("cod_objeto");
			//exit;
			return $_page->_adminobjeto->EFilho($_page, $this->Valor("cod_objeto"), $cod_pai);
		}
	}

?>