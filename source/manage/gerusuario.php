<?php
global $_page;

$tmpArrPerfilObjeto = array();
if (isset($_GET['cod_usuario']) && !empty($_GET['cod_usuario']) && $_GET['cod_usuario']!="0")
{
    $usuario = $_page->_administracao->PegaInformacaoUsuario($_page, $_GET['cod_usuario']);
    // ARRAY: cont�m o mapa dos direitos sobre os objetos, do usu�rio selecionado
    $tmpArrPerfilObjeto = $_page->_administracao->PegaDireitosDoUsuario($_page, $usuario['cod_usuario']);
}
?>

<script>
function ConfirmDelete()
{
    return (confirm ("Tem certeza que quer apagar o usuario?"));
}

function ChecaValidade(frm)
{
    if (frm.email.value=='')
    {
	alert ("O campo email nao pode ficar em branco");
	return false;
    }
    if (frm.nome.value=='')
    {
	alert ("O campo nome nao pode ficar em branco");
	return false;
    }
    if (frm.login.value=='')
    {
	alert ("Login nao pode ficar em branco");
	return false;
    }
    if ((frm.senha.value!=frm.confirma.value) || (frm.senha.value==""))
    {
	alert ("Senha diferente da confirmacao");
	return false;
    }
    trGravarUsr1.style.display='none';
    trGravarUsr2.style.display='';
    return true;
}
		
function EnviaSecao(){
    top.window.location.href="/index.php/do/gerusuario/<?=$_page->_objeto->Valor($_page, 'cod_objeto');?>.html?secao=" + document.getElementById('tx_secao').value;
}
		
function AbrirBusca()
{
    window.open('/index.php/do/busca_usuario/<?=$_page->_objeto->Valor($_page, 'cod_objeto');?>.html?naoincluirheader', 'busca', 'height=400,width=700,scrollbars=true');
}
</script>
	
<div class="pblAlinhamentoTabelas">
    <table WIDTH=590 BORDER=0 CELLPADDING=0 CELLSPACING=8 class="pblTabelaGeral">
	<TR>
	    <TD colspan="3">
		<table width="100%">
		    <tr>
			<td width="60"><img border=0 src="/html/imagens/portalimages/peca3.gif" align="left"></td>
			<td><font class="pblTituloBox">Gerenciamento de Usu&aacute;rios</font></td>
			<td width="50"><a href="#" onclick="history.back()"><img border=0 src="/html/imagens/portalimages/voltar2.gif" ALT="Voltar"></a></td>
		    </tr>
		    <tr>
			<td colspan="3" align="right"><INPUT type="button" name="btn_busca" value="Procurar usu&aacute;rio" onclick="AbrirBusca();" class="pblBotaoForm"></td>
		    </tr>
		</table>
	    </TD>
	</TR>
	
	<form method="GET" action="/index.php/do/gerusuario/<? echo $_page->_objeto->Valor($_page, 'cod_objeto');?>.html">
	<tr>
<?php
if (!isset($_GET['secao']))
{
?>
	    <td width="100" class="pblTextoLabelForm">&Aacute;rea Vinculada</td>
	    <td class="pblTextoForm" colspan="2" width="390">
		<SELECT name="tx_secao" id="tx_secao" class="pblSelectForm">
<? 
		echo $_page->_administracao->DropDownUsuarioSecao($_page);
?>
		</SELECT>
		&nbsp;&nbsp;<INPUT type="button" name="btn_secao" value="Pr&eacute;-selecionar" onclick="EnviaSecao();" class="pblBotaoForm">
<?php
}
else
{
?>
	    <td width="100" class="pblTextoLabelForm">&Aacute;rea Vinculada</td>
	    <td class="pblTextoForm" colspan="2" width="390"><?=$_GET['secao']?> &nbsp;&nbsp;(<a href="/index.php/do/gerusuario/<?=$_page->_objeto->Valor($_page, 'cod_objeto');?>.html">voltar &agrave; lista</a>)<input type="hidden" name="secao" value="<?=$_GET['secao']?>"></td>
	</tr>
	<tr>
	    <td width="160" class="pblTextoLabelForm">Usu&aacute;rio</td>
	    <td class="pblTextoForm" colspan="3" width="390">

		<SELECT name="cod_usuario" class="pblSelectForm">
		    <OPTION value="0">---NOVO USU&Aacute;RIO---</OPTION>
		    <? echo $_page->_administracao->DropDownUsuarios($_page, $usuario['cod_usuario'], false, $_GET['secao']);?>
		</SELECT>
		&nbsp;&nbsp;<INPUT type="submit" name="submit" value="Selecionar" class="pblBotaoForm">
<?php
}
?>
	    </td>
	</tr>
	<tr>
	    <td colspan="3"><hr color="#FA9C00" size="1"></td>
	</tr>
	</form>
	<form action="/index.php/do/gerusuario_post/<?echo $_page->_objeto->Valor($_page, 'cod_objeto')?>.html" method="POST" onsubmit="return ChecaValidade(this);">
	<tr>
	    <td colspan="3">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		    <tr>
			<td>
			    <TABLE WIDTH=370 BORDER=0 CELLPADDING=0 CELLSPACING=8 class="" align="left">
				<tr>
				    <td>
					<input type="hidden" name="cod_usuario" value="<? echo isset($usuario['cod_usuario'])?$usuario['cod_usuario']:"";?>">
					<input type="hidden" name="nomehidden" value="<? echo isset($usuario['nome'])?$usuario['nome']:"";?>">
				    </td>
				</tr>
				<tr>
				    <td width="160" class="pblTextoLabelForm">Nome</td>
				    <td class="pblTextoForm"><INPUT class="pblInputForm" type="text" name="nome" value="<? echo isset($usuario['nome'])?$usuario['nome']:"";?>"></td>
				</tr>
				<tr>
				    <td width="160" class="pblTextoLabelForm">&Aacute;rea vinculada</td>
				    <td class="pblTextoForm">
	    <?php
					$secao = isset($_GET['cod_usuario']);
					$secao = isset($_GET["secao"])?$_GET["secao"]:"";
	    ?>
					<INPUT class="pblInputForm" type="text" name="secao" value="<?=$secao?>">
				    </td>
				</tr>
				<tr>
				    <td width="160" class="pblTextoLabelForm">Login</td>
				    <td class="pblTextoForm">
					<INPUT class="pblInputForm" type="text" name="login" value="<? echo isset($usuario['login'])?$usuario['login']:"";?>">
				    </td>
				</tr>
				<tr>
				    <td width="160" class="pblTextoLabelForm">E-mail</td>
				    <td class="pblTextoForm">
					<INPUT class="pblInputForm" type="text" name="email" value="<? echo isset($usuario['email'])?$usuario['email']:"";?>">
				    </td>
				</tr>
				<tr>
				    <td width="160" class="pblTextoLabelForm">Ramal (contato)</td>
				    <td class="pblTextoForm">
					<INPUT class="pblInputForm" type="text" name="ramal" value="<? echo isset($usuario['ramal'])?$usuario['ramal']:"";?>">
				    </td>
				</tr>
				<tr>
				    <td width="160" class="pblTextoLabelForm" valign="bottom">Senha</td>
				    <td class="pblTextoForm" valign="bottom">
					<INPUT class="pblInputForm" type="password" name="senha" value="<? echo isset($usuario['nome'])?$usuario['nome']:"";?>">
				    </td>
				</tr>
				<tr>
				    <td width="160" class="pblTextoLabelForm" valign="top">Confirme a Senha</td>
				    <td class="pblTextoForm" valign="top">
					<INPUT class="pblInputForm" type="password" name="confirma" value="<? echo isset($usuario['nome'])?$usuario['nome']:"";?>">
				    </td>
				</tr>
				<tr>
				    <td width="160" class="pblTextoLabelForm" valign="top">Chefia</td>
				    <td class="pblTextoForm" valign="top">
					<SELECT name="cod_chefia" class="pblSelectForm">
					    <OPTION value="0"> -- Nenhum -- </OPTION>
	    <?php
					    $selecionado = isset($usuario['chefia'])?$usuario['chefia']:0;
					    echo $_page->_administracao->DropDownUsuarios($_page, $selecionado, false);
	    ?>
					</SELECT>
				    </td>
				</tr>
	    <?php
				$data_validade = strftime("%Y%m%d", strtotime("+6 month"));
	    ?>
				<tr>
				    <td width="160" class="pblTextoLabelForm" valign="top">Validade(<? echo isset($usuario['data_atualizacao'])?ConverteData($usuario['data_atualizacao'],5):"";?>)</td>
				    <td class="pblTextoForm" valign="top">
					<INPUT class="pblInputForm" type="text" name="data_atualizacao" value="<?=ConverteData($data_validade,5);?>">
				    </td>
				</tr>
			    </TABLE>
			</td>
			<td>
			    <TABLE WIDTH=200 BORDER=0 CELLPADDING=0 CELLSPACING=8 class="">
				<tr>
				    <td class="pblTextoLabelForm" valign="top" align="left">Perfil no Objeto:</td>
				</tr>
			    <tr>
				<td class="pblTextoForm" valign="top">
<?php
				    if (isset($tmpArrPerfilObjeto['1']) && ($tmpArrPerfilObjeto['1'] == _PERFIL_ADMINISTRADOR) && ($_page->_objeto->Valor($_page, 'cod_objeto') != _ROOT))
				    {
					$tmpPerfilObjetoAtual = _PERFIL_ADMINISTRADOR;
					$tmpDisabled =  "disabled";
				    }
				    else
				    {
					$tmpPerfilObjetoAtual = $tmpArrPerfilObjeto[$_page->_objeto->Valor($_page, 'cod_objeto')];
				    }
?>
				    <input type="radio" name="perfil" value="<?=_PERFIL_ADMINISTRADOR?>" <?= ($tmpPerfilObjetoAtual==_PERFIL_ADMINISTRADOR)?'checked':''?> <?=$tmpDisabled;?>>Adminstrador<BR>
				    <input type="radio" name="perfil" value="<?=_PERFIL_EDITOR?>" <?= ($tmpPerfilObjetoAtual==_PERFIL_EDITOR)?'checked':''?> <?=$tmpDisabled;?>>Editor<BR>
				    <input type="radio" name="perfil" value="<?=_PERFIL_AUTOR?>" <?= ($tmpArrPerfilObjeto[$_page->_objeto->Valor($_page, 'cod_objeto')]==_PERFIL_AUTOR)?'checked':''?> <?=$tmpDisabled;?>>Autor<BR>
				    <input type="radio" name="perfil" value="<?=_PERFIL_RESTRITO?>" <?= ($tmpPerfilObjetoAtual==_PERFIL_RESTRITO)?'checked':''?> <?=$tmpDisabled;?>>Restrito<BR>
				    <input type="radio" name="perfil" value="<?=_PERFIL_MILITARIZADO?>" <?= ($tmpPerfilObjetoAtual==_PERFIL_MILITARIZADO)?'checked':''?> <?=$tmpDisabled;?>>Militarizado<BR>
				    <input type="radio" name="perfil" value="<?=_PERFIL_DEFAULT?>" <?= ($tmpPerfilObjetoAtual==_PERFIL_DEFAULT)?'checked':''?> <?=$tmpDisabled;?> >Default<BR>
				</td>
			    </tr>
			    <tr>
				<td class="pblTextoLabelForm" align="left"><hr color="#FA9C00" size="1" width="97%"></td>
			    </tr>
			    <tr>
				<td class="pblTextoLabelForm">Quadro atual:</td>
			    </tr>
			    <tr>
				<td class="pblTextoLabelForm">
<?php
				    while (list($key, $val) = each($tmpArrPerfilObjeto))
				    {
					echo '<input type="checkbox" id="checkadmperfil[]" name="checkadmperfil[]" value="'.$key.'">&nbsp;';
					echo " [$key] - ";
					$tmpCheckPerfil = VerificaPerfil($val);
					echo $tmpCheckPerfil;
					echo "<br>\n";
				    }
?>
				</td>
			    </tr>
			</TABLE>
		    </td>
		</tr>
	    </table>
	    </td>
	</tr>
	<? if ($GLOBALS['Msg']) {?>
	<tr>
	    <td class="pblMensagemForm" colspan="3" align="center">
		<? echo $GLOBALS['Msg'];?>
	    </td>
	</tr>
<?php
}
?>	
	<tr id="trGravarUsr1">
	    <td colspan="3" align="right" class="pblTextoForm">
		<hr color="#FA9C00" size="2"><br>
		<INPUT class="pblBotaoForm" type="submit" name="submit" value="Gravar" onclick="">&nbsp;&nbsp;<INPUT class="pblBotaoForm" type="submit" name="apagar" value="Bloquear Usu&aacute;rio" onclick="trGravarUsr1.style.display='none';trGravarUsr2.style.display='';">
	    </td>
	</tr>
	<tr id="trGravarUsr2" style="display:none">
	    <td colspan="3" align="right" class="pblTextoForm" align="right">
		<hr color="#FA9C00" size="2"><br> Salvando informa&ccedil;&otilde;es correntes . . .
	    </td>
	</tr>
	<tr>
	    <td colspan="3">
		<p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p>
	    </td>
	</tr>
    </form>
    </table>
</div>

