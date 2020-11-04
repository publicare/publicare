<?
global $_page;
header("Content-Type: text/html; charset=ISO-8859-1",true);

$url = isset($_GET["url"])?$_GET["url"]:"default";

if ($url == "/do/indexportal") $url = "/do/gerportal";

switch ($url)
{
	case "/do/preview":
	case "/do/workflow":
	case "/do/log":
		$todas_abas = array(
							array("&Iacute;ndice do Objeto"=>"/do/preview"), 
							array("Workflow"=>"/do/workflow"),
							array("Log Status"=>"/do/log")
						);
		break;
	case "/do/vencidos":
		$todas_abas = array(
							array("Apagar Objetos Vencidos"=>"/do/vencidos")
						);
		break;
	case "/do/list_content":
	case "/do/pilha":
		$todas_abas = array(
							array("Listar Conte&uacute;do"=>"/do/list_content"),
							array("Pilha"=>"/do/pilha")
						);
		break;
	case "/do/recuperar":
		$todas_abas = array(
							array("Recuperar Objetos Apagados"=>"/do/recuperar")
						);
		break;
	case "/do/gerportal":
	case "/do/gerusuario":
	case "/do/classes":
	case "/do/peles":
		$todas_abas = array(
							array("Gerenciar Portal"=>"/do/gerportal"),
							array("Usu&aacute;rios"=>"/do/gerusuario"),
							array("Classes"=>"/do/classes"),
							array("Skins"=>"/do/peles")
						);
		break;
}
/*
$todas_abas = array(
			"/do/preview" => array(
									array("&Iacute;ndice do Objeto"=>"/do/preview"), 
									array("Workflow"=>"/do/workflow"),
									array("Log Status"=>"/do/log")),
			"/manage/edit" => array(
									array("Editar Objeto"=>"/manage/edit"), 
									array("Avan&ccedil;ado"=>"/manage/avancado")),
			"/do/delete" => array("Apagar Objeto"),
			"/do/apagar_definitivo" => array("Apagar em definitivo"),
			"/do/vencidos" => array("Apagar Objetos Vencidos"),
			"/manage/new" => array("Criar Objeto"),
			"/do/list_content" => array("Listar Conte&uacute;do", "Pilha"),
			"/do/logacesso" => array("Log de Acessos"),
			"/do/pendentes" => array("Objetos Pendentes"),
			"/do/rejeitar" => array("Rejeitar Publica&ccedil;&atilde;o", "Workflow", "Log Status"),
			"/do/publicar" => array("Objetos a publicar", "Workflow", "Log Status"),
			"/do/recuperar" => array("Recuperar Objetos Apagados"),
			"/do/gerdadospessoais" => array("Gerenciar Dados Privados"),
			"/do/indexportal" => array("Gerenciar Portal", "Usu&aacute;rios", "Classes", "Skins"),
			"/do/classes" => array("Gerenciar Classes"),
			"/do/gerusuario" => array("Gerenciar Usu&aacute;rios"),
			"criando_arquivo" => array("Criar Objeto", "Avan&ccedil;ado"),
			"/do/submeter" => array("Solicita&ccedil;&atilde;o de Publica&ccedil;&atilde;o"),
			"/do/ajuda" => array("Ajuda do Publicare"),
			"default" => array(_VERSIONPROG)
			);
*/
?>
<div id="abasHeaderPublicare">
<?
foreach($todas_abas as $abas)
{
	foreach($abas as $aba=>$valor)
	{
		$classe = ($valor==$url)?"botao":"select";
		echo "<span><a class='".$classe." botoes_aba' href='/index.php".$valor."/".$_page->_objeto->Valor($_page, 'cod_objeto').".html?naoincluirheader&exibir' onclick='$(\".botoes_aba\").attr(\"class\", \"select botoes_aba\"); $(this).attr(\"class\", \"botao botoes_aba\"); jqAjaxLink($(this).attr(\"href\"), \"container_corpo_publicare\", true); return false;'>".$aba."</a></span>";
	}
}
?>
</div>
