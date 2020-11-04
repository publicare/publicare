<?php
	global $_page, $cod;
	include_once '../../../publicare.conf';
	include_once 'iniciar.php';
	$_page->IncluirAdmin();
	
	$codpai = $_POST['intCodPai'];
	$prefixoclasse = $_POST['strPrefixoClasse'];
	$codclasse = $_POST['intCodClasse'];
	$codusuario = $_POST['intCodUsuario'];
	$codpele = $_POST['intCodPele'];
	$datavalidade = $_POST['dteValidade'];
	$scriptexibir = $_POST['strScriptExibir'];
			
	$arrArquivos = $_FILES;
	
	//recupera o nome das fotos
	for($i=1; $i <= count($arrArquivos); $i++)
	{
		$arrNomeFotos[$i] = $_POST["nomefoto".$i];
	}

	//cria os objetos imagens
	for($i=1; $i <= count($arrArquivos); $i++)
	{
		if($arrArquivos["foto".$i]['name']!="")
		{
			if($arrNomeFotos[$i] != ""){
				$nomeFoto = $arrNomeFotos[$i];
			}else{
				$arrNomeFoto = explode(".",$arrArquivos["foto".$i]['name']);
				$nomeFoto = $arrNomeFoto[0];	
			}

			$_FILES = array("property:conteudo" => $arrArquivos["foto".$i]);

			$_POST =array("op" => "", 
						 "submit" => "Gravar",
						 "cod_pai" => $codpai,
						 "prefixoclasse" => $prefixoclasse,
						 "cod_classe" => 4, //classe IMAGEM
						 "cod_usuario" => $codusuario,
						 "cod_pele" => $codpele,
						 "cod_status" => 1,
						 "titulo" => $nomeFoto,
						 "dia_publicacao" => date("d/m/Y"),
						 "hora_publicacao" => date("H:i"),
						 "data_publicacao" => date("d/m/Y")." - ".date("H:i:s"),
						 "dia_validade" => $datavalidade,
						 "hora_validade" => date("H:i"),
						 "data_validade" => $datavalidade." - ".date("H:i"),
						 "property:credito" => "",
						 "property:legenda" => "",
						 "propriedadesegura" => "",
						 "descricao" => "",
						 "tags" => "",
						 "script_exibir" => $scriptexibir,
						 "peso" => ""
			);
			
			$_POST['cod_status'] = 1;
			$_POST['script_exibir'] = str_replace("//", "/", $_POST['script_exibir']); // Arruma uma falha
			
			// VERIFICA A EXISTENCIA DE SCRIPT (ANTES DE GRAVAR O OBJETO)
			$rtnExecAntes = $_page->_adminobjeto->ExecutaScript($_page, $_POST['cod_classe'],$_POST['cod_pele'],'antes');
			set_magic_quotes_runtime(0);
		
			$cod = $_page->_administracao->CriarObjeto($_page, $_POST);
			
			// OBTEM DADOS DO OBJETO RECEM CRIADO
			$data = $_page->_adminobjeto->PegaDadosObjetoPeloID($_page, $cod);
		
			// Publica ou Solicita o objeto, apos a criacao ou edicao
			if (($_POST['submit_publicar']) && (($_SESSION['usuario']['perfil']==_PERFIL_ADMINISTRADOR) || ($_SESSION['usuario']['perfil']==_PERFIL_EDITOR)))
			{
				$_page->_administracao->PublicarObjeto($_page, 'Objeto publicado durante a cria&ccedil;&atilde;o',$cod);
			}
			elseif ($_POST['submit_solicitar'])
			{
				$_page->_administracao->SubmeterObjeto($_page, 'Objeto solicitado durante a cria&ccedil;&atilde;o',$cod);
			}	
				
			// VERIFICA A EXISTENCIA DE SCRIPT (DEPOIS DE GRAVAR O OBJETO)
			$rtnExecDepois = $_page->_adminobjeto->ExecutaScript($_page, $_POST['cod_classe'],$_POST['cod_pele'],'depois');
			
			echo "Imagem: <b>".$nomeFoto."</b>  enviada com sucesso.<br>";
		
		}
		
	}
	
	echo "<br><br><center><a href='/index.php/content/view/".$codpai.".html'><span class='brod'>[RECARREGAR PÁGINA]</span></a></center>";
?>
