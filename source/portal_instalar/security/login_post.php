<?
include("../../publicare.conf");
session_start();
global $_page;

	if (!isset($_SESSION['_LOGIN_TENTATIVAS']))
		$_SESSION['_LOGIN_TENTATIVAS'] = 1;
	
	include ($_SESSION['_PATH_PUBLICARE']."iniciar.php");
	if (($_POST['submit']=='Cancelar') || ($_SESSION['_LOGIN_TENTATIVAS'] >= 10))
    	{
		header('Location:'._URL.'/login');
	}
	else
	{
		if (!$_page->_usuario->Login($_page, $_POST['login'],$_POST['password']))
		{
			$_SESSION['_LOGIN_TENTATIVAS']++;
			$LoginMessage=urlencode("Usuário/Senha errados");
			header("Location:"._URL."/login/index.php/content/view/".$cod_objeto.".html?LoginMessage=$LoginMessage&obj=".$_GET['obj']);
		}
		else
		{
			$LoginMessage=urlencode("Login efetuado pelo usuário $login.");
			header("Location:"._URL."/index.php/content/view/".$_GET['obj'].".html?&LoginMessage=$LoginMessage");
		}
	}
?>
