<?
global $_page;

	$netRedirect = "list_content";
	foreach($_POST['objlist'] as $obj)
	{
		if ($_POST['delete'])	{
			$_page->_administracao->ApagarObjeto($_page, $obj);
		}
		if ($_POST['duplicate'])	{
			$_page->_administracao->DuplicarObjeto($_page, $obj);
		}
		if (($_POST['copy']))	{
			$_page->_administracao->CopiarObjetoParaPilha($_page, $obj);
		}
		if (($_POST['publicar']))	{
			$_page->_administracao->PublicarObjeto($_page, 'Objeto publicado atrav&eacute;s da a&ccedil;&atilde;o listar conte&uacute;do',$obj);
		}
		if (($_POST['publicar_pendentes']))	{
			$netRedirect = "pendentes";
			$_page->_administracao->PublicarObjeto($_page, 'Objeto publicado atrav&eacute;s da lista de objetos pendentes.',$obj);
		}		
		if (($_POST['despublicar']))	{
			$_page->_administracao->DesPublicarObjeto($_page, 'Objeto despublicado atrav&eacute;s da a&ccedil;&atilde;o listar conte&uacute;do',$obj);
		}
		if (($_POST['solicitar']))	{
			$_page->_administracao->SubmeterObjeto($_page, 'Objeto solicitado atrav&eacute;s da a&ccedil;&atilde;o listar conte&uacute;do',$obj);
		}
		
	}
	header ("Location:"._URL.'/index.php/do/'.$netRedirect.'/'.$_POST['return_obj'].'.html');


?>
