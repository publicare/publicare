<?
	//var_dump($HTTP_POST_VARS);
	//include ("initdocroot.pinc");

	if ($submit!='')
	{
		if ($new_password!=$confirm)
		{
			$Message="Senha e Confirmação estão diferentes. Digite novamente.";
			$showform=true;
		}
		else
		{
			if ($_page->user->CheckValidPassword($password))
			{
				$_page->user->UpdatePassword($confirm);
				$Message="Senha Alterada com sucesso.";
				$showform=false;
			}
			else
			{
				$Message = "Senha atual inválida. Digite novamente.";
				$showform=true;
			}
		}
	}
	else
		$showform=true;
?>
	<form action="/index.php?action=/security/password&cod_objeto=<? echo $cod_objeto?>" method="post" name="changepassword" id="changepassword">
	<table border=0 align="center" cellpadding=4 cellspacing=2>
	<?
		if ($showform)
		{
	?>
		<tr>
			<td class="pblFormTitle" colspan="2" align="center">
				<strong>TROCAR A SENHA</strong>
			</td>
		</tr>	
		<tr>
			<td class="pblFormTitle">
				Senha Atual
			</td>
			<td class="pblFormText">
				<input class="FormInput" type="Password" name="password" size="20" value="">
			</td>
		</tr>		
		<tr>
			<td class="pblFormTitle">
				Nova Senha
			</td>
			<td class="pblFormText">
				<input class="FormInput" type="Password" name="new_password" size="20" value="">
			</td>
		</tr>		
		<tr>
			<td class="pblFormTitle">
				Confirmação
			</td>
			<td class="pblFormText">
				<input class="FormInput" type="Password" name="confirm" size="20" value="">
			</td>
		</tr>
		<tr>
			<td class="pblFormTitle" align="right" colspan=2>
				<input class="pblFormButton" type="submit" name="submit" value="Alterar">
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
		<tr>
			<td class="pblFormTitle" align="center" colspan=2>
				<a class="ABranco" href="/index.php"><strong>[Voltar]</strong></a>
			</td>
		</tr>	
		<?
		}
		?>			
	</table>
	</form>
	