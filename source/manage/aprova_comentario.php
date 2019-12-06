<?
global $_page;
	$sql = "update comentarios set aprovado = 1 where cod_comentario = " . $_POST['cod_comentario'];
	$res = $_page->_db->ExecSQL($sql);
	header ("Location:"._URL."/content/comentarios.php?cod_obj_comentario=".$_POST['cod_obj_comentario']);
?>
