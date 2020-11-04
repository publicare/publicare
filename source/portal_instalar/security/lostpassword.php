<?
	include("../../publicare.conf");
	//var_dump($HTTP_POST_VARS);
	//include ("initdocroot.pinc");

	if ($submit!='')
	{
		$sql="select cod_user from user where email='$email'";
		$db->ExecSQL($sql);
		$row=$db->FetchAssoc();
		if ($row['cod_user'])
		{
			$new_pass="pwd_".time();
			$msg= "$PORTAL_NAME\n\nSua senha de acesso foi alterada para '$new_pass'.\nLembre-se de alterá-la imediatamente após o seu primeiro acesso.\n";
			$header[]="Reply-To:$PORTAL_EMAIL";
			$header[]="From:$PORTAL_EMAIL";
			$_page->Mail($email,"Alteração de Senha para $PORTAL_NAME",$msg,$header);
			$_page->user->UpdatePassword($new_pass,$row['cod_user']);
			$Message="A senha foi alterada com sucesso e enviada para o e-mail fornecido.";
			$showform=false;
		}
		else
		{
			$Message="E-mail não consta de nossa base de dados.<BR>Tente novamente.";
			$showform=true;
		}
	}
	else
		$showform=true;
?>
	<form action="/index.php?action=/security/lostpassword&cod_objeto=<? echo $cod_objeto?>" method="post" name="changepassword" id="changepassword">
	<table border=0 align="center" cellpadding=4 cellspacing=2>
	<?
		if ($showform)
		{
	?>
		<tr>
			<td class="pblFormTitle" colspan="2" align="center">
				<strong>SENHA PERDIDA</strong>
			</td>
		</tr>	
		<tr>
			<td class="pblFormTitle">
				Digite seu e-mail
			</td>
			<td class="pblFormText">
				<input class="FormInput" type="text" name="email" size="28" value="">
			</td>
		</tr>		
		<tr>
			<td colspan="2" class="pblFormText">
				O Sistema não tem como recuperar a sua senha.<BR>Uma nova senha será atribuída e enviada por e-mail.<br>
				Ao acessar o sistema troque-a para uma senha criada por você.				
			</td>
		</tr>		
		<tr>
			<td class="pblFormTitle" align="right" colspan=2>
				<input class="pblFormButton" type="submit" name="submit" value="Confirmar">
			</td>
		</tr>
	<?
	}
	?>
		<? if ($Message)
		{
		?>
		<tr>
			<td class="pblFormMessage" colspan=2>
				<? echo $Message?>
			</td>
		</tr>	
		<?
		}
		?>		
		<tr>
			<td class="pblFormTitle"  align="center"  colspan="2">
				<a class="ABranco" href="/index.php"><strong>[Voltar]</strong></a>
			</td>
		</tr>
			
	</table>
	</form>
	