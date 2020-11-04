<?
	include("../../publicare.conf");
	session_start();

?>
<html>
	<head>
	<?php
	function DetectaBrowser(){
	
	if ( strpos($_SERVER['HTTP_USER_AGENT'], 'Gecko') ){
	if ( strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape') ){
		$arrBrowser[1] = 'Netscape (Gecko/Netscape)';
		$arrBrowser[0] = 'Netscape';}
	else if ( strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') ){
		$arrBrowser[1] = 'Mozilla Firefox (Gecko/Firefox)';
		$arrBrowser[0] = 'Firefox';}
	else {
		$arrBrowser[1] = 'Mozilla (Gecko/Mozilla)';
		$arrBrowser[0] = 'Firefox';}
	}
	else if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') )
	{
	if ( strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') )
	{
		$arrBrowser[1] = 'Opera (MSIE/Opera/Compatible)';
		$arrBrowser[0] = 'Opera';
	}
	else
	{
		$arrBrowser[1] = 'Internet Explorer (MSIE/Compatible)';
		$arrBrowser[0] = 'MSIE';
	}
	}
	else
	{
		$arrBrowser[1] = 'Others browsers';
		$arrBrowser[0] = 'none';
	}
	// Transforma $arrBrowser[0] em minúsculas
	$arrBrowser[0] = strtolower($arrBrowser[0]);
	return $arrBrowser;
	}
	
	$NewBrowser = DetectaBrowser();	
	echo "<link href=\"/html/css/publicare_".$NewBrowser[0].".css\" rel=\"stylesheet\" type=\"text/css\">\n";
	?>
		<title>Login</title>
</head>


<BODY bgColor="#FFFFFF" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0" onload="<? if ($LoginMessage!='') echo "alert('$LoginMessage')"?>">

<br><br>
<div align="center">
<table border=0 cellpadding=0 cellspacing=8 width="350" class="pblTabelaGeral">
	<tr>
		<td colspan="2">
			<img src="../html/imagens/portalimages/peca3.gif" alt="" border="0" align="left"><font class="pblTituloBox">Login</font></td>
	</tr>
	
	<form action="/security/login_post.php" method="post">
	<tr>
		<td>
			<font class="pblTextoLabelForm">Login</font>
		</td>
		<td>
			<input class="pblInputForm" type="text" name="login" value="">
		</td>
	</tr>
	<tr>
		<td>
			<font class="pblTextoLabelForm">Senha</font>
		</td>
		<td>
			<input class="pblInputForm" type="password" name="password" value="">
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<span align="pblAlinhamentoBotoes">
			<input class="pblBotaoForm" type="submit" name="submit" value="Enviar">
			</span>
		</td>
	</tr>
	</form>
	<tr><td colspan="2"><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>
</table>
</div>

</body>
</HTML>
