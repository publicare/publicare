<?php
global $_page, $action;

include_once ($_SERVER['DOCUMENT_ROOT']."/FCKeditor/fckeditor.php");
		
// Variaveis de definicao para estrutura de formulario
$DatadeHoje = date("j/n/Y"); 

		
// Redefinido para que o STATUS de todos os objetos, 
// independentemente do nivel do usuario, sejam sempre DESPUBLICADOS
if ($_page->_objeto->Valor($_page, "cod_objeto") == _ROOT)
	$new_status=_STATUS_PUBLICADO;
else
	$new_status=_STATUS_PRIVADO;

if (strpos($action,"edit")===false)
{
	$classname=substr($action,strpos($action,'_')+1);
	$classe=$_page->_administracao->CodigoDaClasse($_page, $classname);
	$edit=false;
}
else
{
	$classname=$_page->_objeto->Valor($_page, "prefixoclasse");
	$classe=$_page->_objeto->Valor($_page, "cod_classe");
	$edit=true;
}

$intCodUsuarioDono = $_page->_objeto->ValorParaEdicao($_page, "cod_usuario");

include ("controles.php");
		
// Resgata dados do objeto-pai para uso futuro
$dadosPai = $_page->_adminobjeto->PegaDadosObjetoPeloID($_page, $_page->_objeto->Valor($_page, "cod_objeto"));

?>
		<script>
	function AtualizaData(theObj){
		if (theObj){
			var dataValidade = document.getElementById('data_validade')
			var diaValidade = document.getElementById('dia_validade')
			var horaValidade = document.getElementById('hora_validade')
			dataValidade.value = diaValidade.value +' - '+ horaValidade.value +':00'
		}
		else	{
			var dataPublicacao = document.getElementById('data_publicacao')
			var diaPublicacao = document.getElementById('dia_publicacao')
			var horaPublicacao = document.getElementById('hora_publicacao')
			dataPublicacao.value = diaPublicacao.value +' - '+ horaPublicacao.value +':00'
		}
	}
	
	</script>
	<form enctype="multipart/form-data" action="/index.php/do/obj_post.php/<?=$_page->_objeto->Valor($_page, "cod_objeto")?>.html" method="post" onsubmit="return validateForm(this)" name="formedit" id="formedit">
	<input type="hidden" name="op" value="<? if ($edit) echo "edit"?>">
	
	<TABLE WIDTH="570" BORDER="0" CELLPADDING="0" CELLSPACING="8" class="pblAlinhamentoTabelas" style="z-index:1;">
	<tr id="trGravarTop1" height="50px">
		<td class="pblTextoForm" colspan=3 align="right">
		Modifique todas as guias e clique no bot&atilde;o adequado.<BR><BR>
			<input class="pblBotaoForm" type="submit" name="submit" value="Gravar" onclick="trGravarTop2.style.display='';trGravarTop1.style.display='none';">
			&nbsp;
			<?php
			 if (($_SESSION['usuario']['perfil']==_PERFIL_ADMINISTRADOR) || ($_SESSION['usuario']['perfil']==_PERFIL_EDITOR))
			  { 
			?>
			<input class="pblBotaoForm" type="submit" name="submit_publicar" value="Gravar & Publicar" onclick="trGravarTop2.style.display='';trGravarTop1.style.display='none';">
			<?php 
			}
			else 
			{ ?>
			<input class="pblBotaoForm" type="submit" name="submit_solicitar" value="Gravar & Solicitar" onclick="trGravarTop2.style.display='';trGravarTop1.style.display='none';">
			<?php
			 }  ?>
			&nbsp;
			<input class="pblBotaoForm" type="submit" name="submit_insert" value="Gravar & Inserir Outro" onclick="trGravarTop2.style.display='';trGravarTop1.style.display='none';">
			<br>&nbsp;<br>
		</td>
	</tr>
	<tr id="trGravarTop2" style="display:none" height="60px">
		<td class="pblTextoForm" colspan=3 align="right">
		Salvando informa&ccedil;&otilde;es .... aguarde....
		</td>
	</tr>
	<tr>
	<td height="1px" colspan="3">
	<hr size="3px" width="100%" color="#FA9C00">
	</td>
	</tr>
		<TR id="trGravarTop3" height="50px">
		<TD colspan=2" width="320">
			<img border=0 src="/html/imagens/portalimages/peca3.gif" align="left" ALT=""><font class="pblTituloBox">
			<? if ($edit) {?>
				Editar
		   <?} else {?>
			    Criar
		   <? }?>
		   objeto</font><br>
			<font class="pblTextoForm">
			<? if ($edit)
			   {
			   		echo strtoupper('Editando '.substr($_page->_objeto->Valor($_page, "titulo"),50).' - '.substr($_page->_objeto->Valor($_page, "classe"),0,50));
			   }
			   else
			   {
				 	echo strtoupper('Criando '.$classname.' em '.substr($_page->_objeto->Valor($_page, "titulo"),0,50));
			   }
			?>
		</TD>
		<TD class="pblAlinhamentoBotoes" width="250">
			<? if (($_page->_objeto->Valor($_page, "cod_status")==_STATUS_SUBMETIDO) && ($edit) && ($_page->_usuario->PodeExecutar($_page, '/do/publicar'))) {?>
				<!--<a href="/index.php?action=/manage/publicar&cod_objeto=<? echo $_page->_objeto->Valor($_page, "cod_objeto")?>">--><img border=0 src="/html/imagens/portalimages/publicar.png" WIDTH=30 HEIGHT=30 ALT="Publicar" hspace="2"><!--</a>-->
			<? } else { ?>
				<img border=0 src="/html/imagens/portalimages/publicar_out.png" WIDTH=30 HEIGHT=30 ALT="" hspace="2">
			<?}?>

			<? if ((($_page->_objeto->Valor($_page, "cod_status")==_STATUS_SUBMETIDO) || ($_page->_objeto->Valor($_page, "cod_status")==_STATUS_PUBLICADO)) && ($edit) && ($_page->_usuario->PodeExecutar($_page, '/do/rejeitar')))  {?>
				<!--<a href="/index.php?action=/manage/rejeitar&cod_objeto=<? echo $_page->_objeto->Valor($_page, "cod_objeto")?>">--><img border=0 src="/html/imagens/portalimages/rejeitar.png" WIDTH=30 HEIGHT=30 hspace="2" ALT="Rejeitar publica&ccedil;&atilde;o"><!--</a>-->
			<? } else { ?>
				<img border=0 src="/html/imagens/portalimages/rejeitar_out.png" WIDTH=30 HEIGHT=30 hspace="2" ALT="">
			<?}?>


			<? if (($_page->_objeto->Valor($_page, "cod_status")==_STATUS_PRIVADO) && ($edit) && ($_page->_usuario->PodeExecutar($_page, '/manage/solicitar'))) {?>
				<!--<a href="/index.php?action=/manage/solicitar&cod_objeto=<? echo $_page->_objeto->Valor($_page, "cod_objeto")?>">--><img border=0 src="/html/imagens/portalimages/solicitar.png" WIDTH=30 HEIGHT=30 hspace="2" ALT="Solicitar publica&ccedil;&atilde;o"><!--</a>-->
			<? } else { ?>
				<img border=0 src="/html/imagens/portalimages/solicitar_out.png" WIDTH=30 HEIGHT=30 hspace="2" ALT="">
			<?}?>


			<? if ($edit) {?>
				<!--<a href="/index.php?action=/content/view&cod_objeto=<? echo $_page->_objeto->Valor($_page, "cod_objeto")?>">--><img border=0 src="/html/imagens/portalimages/exibir.png" WIDTH=30 HEIGHT=30 hspace="2" ALT="Exibir Objeto"><!--</a>-->
			<? } else { ?>
				<img border=0 src="/html/imagens/portalimages/exibir_out.png" WIDTH=30 HEIGHT=30 hspace="2" ALT="">
			<?}?>


			<? if (($edit) && ($_page->_usuario->PodeExecutar($_page, '/do/delete'))) {?>
				<!--<a href="/index.php?action=/manage/delete&cod_objeto=<? echo $_page->_objeto->Valor($_page, "cod_objeto")?>">--><img border=0 src="/html/imagens/portalimages/apagar.png" WIDTH=30 HEIGHT=30 hspace="2" ALT="Apagar Objeto"><!--</a>-->
			<? } else { ?>
				<img border=0 src="/html/imagens/portalimages/apagar_out.png" WIDTH=30 HEIGHT=30 hspace="2" ALT="">
			<?}?>
		</TD>
	</TR>
	</table>
	<div class="pblAlinhamentoTabelas">

	<div id="divGuiaA" style="height: 0%; visibility: show;">
	<TABLE WIDTH=570 BORDER=0 CELLPADDING=0 CELLSPACING=8 class="pblTabelaGeral">
	<tr>
	<td width="100%" height="170px">&nbsp;</td>
	</tr>
	<tr>
		<td class="pblTextoLabelForm" colspan="3">
			<input type="hidden" name="cod_pai" value="<?if ($edit)
																echo $_page->_objeto->ValorParaEdicao($_page, 'cod_pai');
															 else
															 	echo $_page->_objeto->ValorParaEdicao($_page, 'cod_objeto'); ?>">
		
			<input type="hidden" name="prefixoclasse" value="<?echo $_page->_objeto->ValorParaEdicao($_page, 'prefixoclasse');?>">
		
			<? if ($edit) {?>
				<input type="hidden" name="cod_objeto" value="<?echo $_page->_objeto->ValorParaEdicao($_page, 'cod_objeto');?>">
			<?}?>
		
			<input type="hidden" name="cod_classe" value="<? echo $classe;?>">
			<input type="hidden" name="cod_usuario" value="<? 
															if ($edit)
																echo $_page->_objeto->Valor($_page, 'cod_usuario');
															else
																echo $_SESSION['usuario']['cod_usuario'];?>">
			<input type="hidden" name="cod_pele" value="<? echo $_page->_objeto->ValorParaEdicao($_page, "cod_pele");?>">
			<input type="hidden" name="cod_status" value="<? echo $new_status?>">
			
			T&iacute;tulo do objeto &nbsp;<a href='#' onclick='return false;' onmouseover='document.getElementById("help_titulo").style.display="";' onmouseout='document.getElementById("help_titulo").style.display="none";'><b>&lt;?&gt;</b></a> <span id='help_titulo' style='position:absolute; width:200px; background:#ffffff; padding-left:2px; padding-right:2px; padding-top:2px; padding-bottom:2px; color:#000000; font-weight:normal; border: 1px solid #000000; display:none;'>T&iacute;tulo do objeto.</span><br>
			<input class="pblInputForm" type="text" size=50 name="titulo" value='<? if ($edit) 
														echo $_page->_objeto->ValorParaEdicao($_page, "titulo");
													  else
													  	echo isset($titulo)?$titulo:"";?>'>
			<p>
			Data de Publica&ccedil;&atilde;o - (campo hora no formato 23h) &nbsp;<a href='#' onclick='return false;' onmouseover='document.getElementById("help_data_publicacao").style.display="";' onmouseout='document.getElementById("help_data_publicacao").style.display="none";'><b>&lt;?&gt;</b></a> <span id='help_data_publicacao' style='position:absolute; width:200px; background:#ffffff; padding-left:2px; padding-right:2px; padding-top:2px; padding-bottom:2px; color:#000000; font-weight:normal; border: 1px solid #000000; display:none;'>Data de publica&ccedil;&atilde;o do objeto. O objeto s&oacute; ficar&aacute; vis&iacute;vel a partir desta data.</span><br>
			<input class="pblInputForm" type="text" name="dia_publicacao" id="dia_publicacao" 
													   value="<? if ($edit) 
																echo ConverteData($_page->_objeto->Valor($_page, "data_publicacao"),5);
															   else
															 	echo ConverteData(date("d/m/Y"),5);?>" onchange="AtualizaData(0);" maxlength="10">
			 Hora:
			<input class="pblInputForm" type="text" name="hora_publicacao" id="hora_publicacao" 
													   value="<? if ($edit) 
																echo ConverteData($_page->_objeto->Valor($_page, "data_publicacao"),30);
															  else
															 	echo date("H:i");?>" size="6" maxlength="5" onchange="AtualizaData(0);">
			<input type="text" name="data_publicacao" id="data_publicacao" style="display:none"> 
			<p>
			Data de Validade - (campo hora no formato 23h) &nbsp;<a href='#' onclick='return false;' onmouseover='document.getElementById("help_data_validade").style.display="";' onmouseout='document.getElementById("help_data_validade").style.display="none";'><b>&lt;?&gt;</b></a> <span id='help_data_validade' style='position:absolute; width:200px; background:#ffffff; padding-left:2px; padding-right:2px; padding-top:2px; padding-bottom:2px; color:#000000; font-weight:normal; border: 1px solid #000000; display:none;'>Data de validade do objeto. O objeto deixar&aacute; de ser vis&iacute;vel a partir desta data.</span><br>
			<input class="pblInputForm" type="text" name="dia_validade" id="dia_validade"
														 value="<? if ($edit)
																echo ConverteData($_page->_objeto->Valor($_page, "data_validade"),5);
															 else
															 	echo ("31/12/2036");?>" onchange="AtualizaData(1);"  maxlength="10">
 Hora:
			<input class="pblInputForm" type="text" name="hora_validade" id="hora_validade"
													   value="<? if ($edit) 
																echo ConverteData($_page->_objeto->Valor($_page, "data_validade"),30);
															 else
															 	echo date("H:i");?>" size="6" maxlength="5" onchange="AtualizaData(1);">
		<input type="text" name="data_validade" id="data_validade" style="display:none"> 
				<p>	
	<script>
	document.getElementById('data_validade').value =  document.getElementById('dia_validade').value + ' - ' + document.getElementById('hora_validade').value +':00'
	document.getElementById('data_publicacao').value =  document.getElementById('dia_publicacao').value + ' - ' + document.getElementById('hora_publicacao').value +':00'
	</script>
	<?php
		// Declarando variaveis Globais
		
		$properties = $_page->_administracao->PegaPropriedadesDaClasse($_page, $classe);
		
		if (is_array($properties))
		{
			if (isset($ORDER) && is_array($ORDER))
			{
//				echo "entrou!!!";
//				exit();				
				foreach($ORDER as $item)
				{
					foreach($properties as $prop)
					{
						if ($prop['nome']==$item)
						{
							$new_array[]=$prop;
							break;
						}
					}
				}
				$properties=$new_array;
			}
			
			$arrNamePropriedade = array();
			$arrIDPropriedade = array();
			$strPropriedadeSegura = "";
			
			foreach ($properties as $key=>$prop)
			{
			
				// Verifica se o campo e permitido para o PERFIL atual do usuario
				if ((int)$prop['seguranca'] >= (int)$_SESSION['usuario']['perfil'])
				{
					$DisplayObjeto = "style=\"display:show\"";
				}
				else 
				{
					$DisplayObjeto = "style=\"display:none\"";
					if ($strPropriedadeSegura)
						$strPropriedadeSegura .= ";";
						$strPropriedadeSegura .= "property:".$prop['nome'];
				}
				// Fim de verificacao de PERFIL
				
				
					echo "<p class=\"pblTextoLabelForm";
					
					// Verifica se a propriedade e obrigatoria & Escreve seu rotulo 

					if ($prop['obrigatorio'])
					{
						echo " pblObrigatorio\" ".$DisplayObjeto.">".$prop['rotulo']." *";
						if (!($edit && strtolower($prop['cod_tipodado']) == 1))
						{
							$chrtmpProp = "document.getElementById('property:".$prop['nome']."')";
							array_push($arrIDPropriedade, $chrtmpProp);
							array_push($arrNamePropriedade, $prop['rotulo']);
						}
					}
					else
					{
						echo "\" ".$DisplayObjeto.">".$prop['rotulo'];
					}  
					
					if (isset($prop['descricao']) && !empty($prop['descricao']) && $prop['descricao']!="" && strlen(trim($prop['descricao']))>3)
					{
						echo "&nbsp;<a href='#' onclick='return false;' onmouseover='document.getElementById(\"help_".$prop["nome"]."\").style.display=\"\";' onmouseout='document.getElementById(\"help_".$prop["nome"]."\").style.display=\"none\";'><b>&lt;?&gt;</b></a> <span id='help_".$prop["nome"]."' style='position:absolute; width:200px; background:#ffffff; padding-left:2px; padding-right:2px; padding-top:2px; padding-bottom:2px; color:#000000; font-weight:normal; border: 1px solid #000000; display:none;'>".$prop['descricao']."</span>";
					}
					
					echo "<BR>";
					
					// Fim de: Obrigatoriedade & Rotulo
					

					$incluir=false;
					switch ($prop['cod_tipodado'])
					{
						case 8:
							if ($prop['seguranca'] >= $_SESSION['usuario']['perfil'])
							{
								$f = new FCKeditor('property:'. $prop['nome']);
								if ($edit)
								$f->Value = $_page->_objeto->ValorParaEdicao($_page, $prop['nome']);
								$f->Config['CustomConfigurationsPath'] = '/html/javascript/fckeditor-config.js' ;
								$f->Create();
							}
							break;
						case 6: // Campo Referencia a um objeto (RefObj)
							if ($edit)
								$value=$_page->_objeto->ValorParaEdicao($_page, $prop['nome']);
							else
							{
								if ($prop['valorpadrao'])
								 $value = $prop['valorpadrao'];
								else
								 $value=-1;
							}
							echo '<select class="pblSelectForm" name="property:'.$prop['nome'].'" id="property:'.$prop['nome'].'" size="1">';
							echo $_page->_administracao->DropDownListaDeObjetos($_page, $prop['cod_referencia_classe'],$prop['campo_ref'],$value,55);
							echo '</select>';
							break;
						case 1: // Campo Blob
							if ($edit)
							{
								if ($_page->_objeto->ValorParaEdicao($_page, $prop['nome']))
									echo $_page->_objeto->ValorParaEdicao($_page, $prop['nome'])." - ".$_page->_objeto->TamanhoBlob($_page, $prop['nome'])." bytes<BR>";
							}
							echo '<input class="pblInputForm" type="file" name="property:'.$prop['nome'].'" value="">';
							if (($edit) && ($_page->_objeto->ValorParaEdicao($_page, $prop['nome'])!=''))
							{
								echo '<input type="checkbox" id="property:'.$prop['nome'].'" name="property:'.$prop['nome'].'^delete" value="1">&nbsp;Apagar';
							}
							break;
						case 2: //Campo Booleano
							echo '<input type="radio" id="property:'.$prop['nome'].'" name="property:'.$prop['nome'].'" ';
							if ($edit)
							{
								if ($_page->_objeto->ValorParaEdicao($_page, $prop['nome'])) echo ' checked ';
							}
							else 
							{
								if ($prop['valorpadrao'] && $prop['valorpadrao']!=" ") echo ' checked ';
							}
							echo ' value="1">'.$prop['rot1booleano'];
							echo '<input type="radio" id="property:'.$prop['nome'].'" name="property:'.$prop['nome'].'"';
							if ($edit)
							{
								if (!$_page->_objeto->ValorParaEdicao($_page, $prop['nome'])) echo ' checked ';
							}
							else 
							{
								if (!$prop['valorpadrao'] && $prop['valorpadrao']!=" ") echo ' checked ';
							}
							echo ' value="0">'.$prop['rot2booleano'];
							break;
						case 3: // Campo data
							if ($prop['valorpadrao'] == "hoje") {
								$ValorData = $DatadeHoje;}
							elseif ($edit) {
								$ValorData = $_page->_objeto->ValorParaEdicao($_page, $prop['nome']);}
							else  {
								($prop['valorpadrao']==" ")?$ValorData='':$ValorData=$prop['valorpadrao'];}

							$JavaScript = " onKeyPress=\"if (window.event.keyCode < 47 || window.event.keyCode > 57) window.event.returnValue = false;\"";
							$inputsize = 15;
							echo '<input class="pblInputForm" type="text" size='.$inputsize.' id="property:'.$prop['nome'].'" name="property:'.$prop['nome'].'" value="'.$ValorData.'"';
							echo ' '.$JavaScript.'">';
							break;
						case 4: // Campo numero
							$JavaScript = "";
							$inputsize = 15;
							$incluir=true;
							break;
						case 5: // Campo numero preciso
							$JavaScript = "";
							$inputsize = 15;
							$incluir=true;
							break;
						case 9: // Script executavel [EXCLU�DO! AGORA ELE L� NA PASTA /html/execscript/]
							echo "<input type=\"texto\" id=\"property:".$prop['nome']."\" name=\"property:\"".$prop['nome']."\" value=\"".$prop['valorpadrao']."\">";
							break;
	
						default:
							$JavaScript = "";
							$inputsize = 40;
							$incluir=true;
					}	
					
					if ($incluir)
					{
						echo '<input class="pblInputForm" type="text" size='.$inputsize.' id="property:'.$prop['nome'].'" name="property:'.$prop['nome'].'" value="';
						if ($edit)
							echo $_page->_objeto->ValorParaEdicao($_page, $prop['nome']);
						else 
							echo ($prop['valorpadrao']==" ")?'':$prop['valorpadrao'];
						echo '" ';
						if (isset($SIZES) && is_array($SIZES))
							echo ' size="'.$SIZES[$key].'"';
						echo $JavaScript.'>';
					}
			}
		}
		
	?>
	</P>
	<input type="hidden" value="<?=isset($strPropriedadeSegura)?$strPropriedadeSegura:"";?>" name="propriedadesegura" readonly>
	</td>
	</tr>
	<tr><td colspan="3"><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>

	</table>
	</div>
	</div>
	<script language="JavaScript1.2" type="text/javascript">
	
		function ReReadFieldValue(field)
		{
			xajax_ReadFieldValue(field);			
			janela.close();			
		}

		function openEditor(fieldname)
		{
			<? if ($edit)
				$open=$_page->_objeto->Valor($_page, 'cod_objeto');
			   else
			   	$open=-1;?>
			janela = window.open('/manage/editor/edit.php?cod_objeto=<? echo $open?>&field='+fieldname,"editor","height=450 width=700 menubar=no resizable=no status=yes scrollbars=no");
			return false;
		}
		
	function validateForm(theForm)
	{
	<?php
	$tmpContador = 0;
	if (isset($arrIDPropriedade)){
		foreach ($arrIDPropriedade as $item)
		{					
			echo "if (!JSVerificaCampoObrigatorio($arrIDPropriedade[$tmpContador],\"$arrNamePropriedade[$tmpContador]\")) return false;".chr(10);
			$tmpContador++;
		}
	}
	?>
	if (!validRequired(theForm.titulo,"Titulo")) { MostraBotaoGravar(); return false;}
		 	if (!validDateTime(theForm.dia_publicacao,"Data de Publica&ccedil;&atilde;o",true,true)) { MostraBotaoGravar(); return false;}
			if (!validDateTime(theForm.dia_validade,"Data de Validade",true,true)) { MostraBotaoGravar();return false; }
		<? echo isset($validation)?$validation:"";?>
		return true;
	}
	
		

	</script>
<?php
	/* =============
	Inserindo Guias
	================*/
 	echo "<div id=\"divGuiaB\" style=\"height: 0%; visibility: hidden;\">";
	include ("form_advanced.php");
	echo "</div>";

?>
	</form>
	