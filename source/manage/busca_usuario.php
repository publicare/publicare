<?php
global $_page, $PORTAL_NAME;

$acao = isset($_POST["acao"])?$_POST["acao"]:"";
$busca = isset($_POST["busca"])?$_POST["busca"]:"";
?>
<html>
<head>
<title> <? echo $PORTAL_NAME ;?> -- Busca de usuários</title>
<?
$recebeBrowser = DetectaBrowser();
if ($recebeBrowser[0]!="firefox" && $recebeBrowser[0]!="msie") $recebeBrowser[0] = "firefox";
echo '<link href="/html/css/publicare_'.$recebeBrowser[0].'.css" rel="stylesheet" type="text/css" />';
?>
<script>
function enviaUsuario(secao, cod)
{
	opener.location.href = "/index.php/do/gerusuario/<?=$_page->_objeto->Valor($_page, 'cod_objeto');?>.html?secao="+secao+"&cod_usuario="+cod+"&submit=Selecionar";
	window.close();
}
</script>
</head>
<body>
<form method="post" action="/index.php/do/busca_usuario/<?=$_page->_objeto->Valor($_page, 'cod_objeto');?>.html?naoincluirheader">
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="pblTabelaGeral">
	<tr height="30">
		<td align="center"><font size="3"><b>Busca de Usu&aacute;rios</b></font></td>
	</tr>
	<tr>
	<td align="center">
		<table border="0" cellpadding="2" cellspacing="1" width="300">
		<tr>
			<td align="right" class="pblTextoForm">Busca:</td>
			<td><input type="text" name="busca" id="busca" value="<?=$_POST["busca"]?>" class="pblInputForm">
			<td><input type="submit" value="Buscar" class="pblBotaoForm"><input type="hidden" name="acao" id="acao" value="buscar"></td>
		</tr>
		</table>
	</td>
	</tr>
	<tr>
	<td>
<?
if ($acao=="buscar")
{
	$sql = "select cod_usuario,
	secao,
	nome,
	login,
	email 
	from usuario 
	where (nome like ('%".$busca."%')
	or login like ('%".$busca."%')
	or email like ('%".$busca."%')) 
	and valido=1";
	$rs = $_page->_db->ExecSQL($sql);
	if ($rs->_numOfRows > 0)
	{
?>
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td class="pblTextoForm"><strong>#</strong></td>
<td class="pblTextoForm"><strong>Nome</strong></td>
<td class="pblTextoForm"><strong>Email</strong></td>
<td class="pblTextoForm"><strong>Login</strong></td>
<td class="pblTextoForm"><strong>Se&ccedil;&atilde;o</td>
</tr>
<?
		$cont = 0;
		while ($row = $rs->FetchRow())
		{
			$cont++;
			if ($cont%2!=0)
				$classe="pblTextoLogImpar";
			else
				$classe="pblTextoLogPar";
?>
		<tr class="<?=$classe?>">
			<td><?=$cont?></td>
			<td><a href="javascript:enviaUsuario('<?=$row["secao"]?>', '<?=$row["cod_usuario"]?>')"><?=$row["nome"]?></a></td>
			<td><?=$row["email"]?></td>
			<td><?=$row["login"]?></td>
			<td><?=$row["secao"]?></td>
		</tr>
	
<?
		}
?>
</table>
<?
	} else {
		echo "<center><b><br><br><br>Nenhum usuário encontrado<br><br><br></b></center>";
	}
}
?>
		</td>
	</tr>
</table>
</form>
</body>
</html>