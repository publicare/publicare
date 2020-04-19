<?
global $_page;

	$perfil_chefia = $_page->_administracao->PegaListaDeUsuarios($_page);
	$tmpCheckProcedencia = false;
	foreach ($perfil_chefia as $sub)
	{
		// Verifica se o usuario atual e chefe do usuario que esta sendo modificado
		if ($_POST['cod_usuario'] == $sub['codigo'])
			$tmpCheckProcedencia = true;
	}
  if ($_SESSION['usuario']['perfil'] == 1)
  {
	
	if ($_POST['submit'])
	{
		// GRAVA DADOS DO USUARIO
		
		if ($_page->_administracao->ExisteOutroUsuario($_page, $_POST['login'], $_POST['cod_usuario']))
		{
             
		$Msg = "Login j&aacute; existe. Por favor escolha outro.";
                       
		}
		else
		{ 	
			if ($_POST['senha']==$_POST['confirma'])
			{
				if ($_POST['cod_usuario'])
				{
					if (strlen($_POST['secao']) <= 2)
						$secao = "sem qualifica&ccedil;&atilde;o";
					else
						$secao = $_POST['secao'];
					$sql = "update usuario set nome='".$_POST['nome']."',";
					$sql .= " email='".$_POST['email']."',";
					$sql .= " secao='".$secao."',";
					$sql .= " ramal='".$_POST['ramal']."',";
					$sql .= " login='".$_POST['login']."',";
					$sql .= " data_atualizacao=".ConverteData($_POST['data_atualizacao'],16);
					if ($_POST['senha']!=$_POST['nomehidden'])
						$sql .= ", senha='".md5($_POST['senha'])."'";
						
					$sql .= " , chefia=".$_POST['cod_chefia'];
					$sql .= " where cod_usuario=".$_POST['cod_usuario'];
					$_page->_db->ExecSQL($sql);

					// APAGA PERFIS SELECIONADOS DO QUADRO DE PERFIS
					if (isset($_POST['checkadmperfil']) && !empty($_POST['checkadmperfil']))
						foreach ($_POST['checkadmperfil'] as $tmpObjQuadro)
						{
							$_page->_administracao->AlterarPerfilDoUsuarioNoObjeto($_page, $_POST['cod_usuario'], $tmpObjQuadro, _PERFIL_DEFAULT, false);
						}
					
					// GRAVA DIREITOS DO USUARIO NO OBJETO ATUAL
					if ($_POST['perfil'] != _PERFIL_ADMINISTRADOR)
						$_page->_administracao->AlterarPerfilDoUsuarioNoObjeto($_page, $_POST['cod_usuario'], $_page->_objeto->Valor($_page, 'cod_objeto'), $_POST['perfil']);
					else // SE ESTIVER TORNANDO O USUARIO ADMINISTRADOR, FAZE-LO NA RAIZ DO SITE E DELETAR QUALQUER OUTRA ENTRADA ANTERIOR
					{
						$sql = "delete from usuarioxobjetoxperfil where cod_usuario = ".$_POST['cod_usuario'];
						$_page->_db->ExecSQL($sql);
						$_page->_administracao->AlterarPerfilDoUsuarioNoObjeto($_page, $_POST['cod_usuario'], _ROOT, _PERFIL_ADMINISTRADOR);
					}
				$Msg="Usu&aacute;rio atualizado com &ecirc;xito.";
				}
				else
				{
					$campos=array();
					$campos['nome']=$_POST['nome'];
					$campos['login']=$_POST['login'];
					$campos['email']=$_POST['email'];
					$campos['ramal']=$_POST['ramal'];
					$campos['chefia']=$_POST['cod_chefia'];
					$campos['secao']=$_POST['secao'];
					$campos['data_atualizacao']=ConverteData($_POST['data_atualizacao'],16);
					$campos['senha']=md5($_POST['senha']);
					$campos['valido']='1';

					$_POST['cod_usuario']=$_page->_db->Insert('usuario',$campos);
					
					// Se n�o tiver nenhum perfil selecionado, coloca o perfil default
					if (strlen($_POST['perfil'])>0){
						// DEFINE PERFIL SO_LOGADO PARA OBJETO ROOT NO SITE -- CASO N�O SEJA O OBJETO ROOT QUE ESTEJA SENDO DEFINIDO
						if ($_page->_objeto->Valor($_page, 'cod_objeto') != _ROOT)
						{
							$_page->_administracao->AlterarPerfilDoUsuarioNoObjeto($_page, $_POST['cod_usuario'], _ROOT, _PERFIL_RESTRITO);
							$_page->_administracao->AlterarPerfilDoUsuarioNoObjeto($_page, $_POST['cod_usuario'], $_page->_objeto->Valor($_page, 'cod_objeto'), $_POST['perfil']);
						}
						else 
						{
							$_page->_administracao->AlterarPerfilDoUsuarioNoObjeto($_page, $_POST['cod_usuario'], _ROOT, $_POST['perfil']);
						}
					} else {
						$_page->_administracao->AlterarPerfilDoUsuarioNoObjeto($_page, $_POST['cod_usuario'], _ROOT, _PERFIL_DEFAULT);
					}
				$Msg="Usu&aacute;rio criado com &ecirc;xito.";
				}
				
			}
			else
			{
				$Msg="Senha diferente da confirma&ccedil;&atilde;o. Digite novamente.";
			}
		}
	}
	else 
	{
		if (($_POST['apagar']) && ($_POST['cod_usuario']))
		{
			$sql = "update usuario set valido=0 where cod_usuario=".$_POST['cod_usuario'];
			$_page->_db->ExecSQL($sql);
			$_POST['cod_usuario']=0;
			// ZERA DIRETIOS DO USUARIO EM TODOS OS OBJETOS QUE O MESMO TINHA DIREITOS
			$_page->_administracao->AlterarPerfilDoUsuarioNoObjeto($_page, $_POST['cod_usuario'], $_page->_objeto->Valor($_page, 'cod_objeto'), _PERFIL_DEFAULT);
		}
	}
  }
  else 
  {
  	$Msg = "Acesso negado a edi&ccedil;&atilde;o deste usu&aacute;rio.";
  }
	$url = "Location:/index.php/do/gerusuario/".$_page->_objeto->Valor($_page, 'cod_objeto').".html?cod_usuario=".$_POST['cod_usuario']."&secao=".$_POST['secao'];
	
	if ($Msg)
		$url .= "&Msg=".urlencode($Msg)."&nome=".urlencode($_POST['nome']).'&login='.urlencode($_POST['login']).'&email='.urlencode($_POST['senha']);

		
	header($url);
?>

	
