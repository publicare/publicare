<?php
global $_page;

	if (isset($_GET['cod_classe']))
	{
		$classinfo=$_page->_administracao->PegaInfoDaClasse($_page, $_GET['cod_classe']);
	}
        else
        {
            $_GET['cod_classe'] = 0;
            $classinfo=$_page->_administracao->PegaInfoDaClasse($_page, 0);
        }


	if (isset($is_explorer) && $is_explorer)
	{
		$areasize=80;
	}
	else
	{
		$areasize=40;
	}
?>
<script type="text/javascript">
function ConfirmDelete()
{
    if (<?php echo(isset($classinfo['obj_conta'])?$classinfo['obj_conta']+0:false) ?>)
        return (confirm ("Tem certeza que quer apagar a classe?\nSeu portal contem <? echo $classinfo['obj_conta']?> objetos dessa classe\n que SERAO APAGADOS TAMBEM!"));
    else
        return (confirm ("Tem certeza que quer apagar a classe?"));
}
		
function Estado(elm, estado)
{
        //alert (elm);
    if (typeof(document.forms['editclass'][elm])=='object')
    {
        if (document.forms['editclass'][elm].length)
        {
            for (f=0;f<document.forms['editclass'][elm].length;f++)
                    document.forms['editclass'][elm][f].disabled=estado;
        }
        else
        {
            document.forms['editclass'][elm].disabled=estado;
        }
    }	
}

function EstaEntre(campo,elm,conjunto)
{
        //alert(elm);
    for (f=0;f<conjunto.length;f++)
    {
        if (conjunto[f].toLowerCase()==elm.toLowerCase())
        {
                alert(campo+" "+elm+" já existente. Por favor digite outro.");
                return true;
        }
    }
    return false;
}

		
		var ArrayCheck=new Array(100);
		function ChecaTipoDado(elm,conta,trobjetos)
		{
			campovalorpadrao = false;
			apagaobjeto = true;
			apagaobjetoI = true;
			apagaobjetoII = true;
			objeto = "trPropClass"+conta;
                        objetoo = "trPropClasss"+conta;
			objetoI = "trPropClassBlolean"+conta;
			
			// MOSTRA CAMPO -- OBJETO, OBJETOI, OBJETOII
			if ((elm.value!=0) && (elm.options[elm.value].value==6))
			{
				document.forms['editclass']['prop_'+conta+'_cod_referencia_classe'].disabled=false;
				document.forms['editclass']['prop_'+conta+'_campo_ref'].disabled=false;
				//document.forms['editclass']['prop_'+conta+'_valorpadrao'].disabled=true;
				document.forms['editclass']['prop_'+conta+'_valorpadrao'].value='';
				ArrayCheck[conta]=1;
				document.getElementById(objeto).style.display='';
                                document.getElementById(objetoo).style.display='';
				apagaobjeto = false;
				campovalorpadrao = true;
			}
			if ((elm.value!=0) && (elm.options[elm.value].value==3))
			{
				document.forms['editclass']['prop_'+conta+'_valorpadrao'].value="hoje";
				document.getElementById(objetoI).style.display='';
				campovalorpadrao = false;
			}
			if ((elm.value!=0) && (elm.options[elm.value].value==2))
			{
				document.forms['editclass']['prop_'+conta+'_bolean_1'].disabled=false;
				document.forms['editclass']['prop_'+conta+'_bolean_2'].disabled=false;
				///document.forms['editclass']['prop_'+conta+'_valorpadrao'].disabled=false;
				document.forms['editclass']['prop_'+conta+'_valorpadrao'].value='';
				document.forms['editclass']['prop_'+conta+'_bolean_1'].value="Sim";
				document.forms['editclass']['prop_'+conta+'_bolean_2'].value="Nao";
				document.getElementById(objetoI).style.display='';
				apagaobjetoI = false;
				campovalorpadrao = false;
			}
			//if ((elm.value!=0) && (elm.options[elm.value].value==8))
			//{
			//	document.forms['editclass']['prop_'+conta+'_seguranca'][3].selected=true;
			//	document.forms['editclass']['prop_'+conta+'_seguranca'].disabled=true;
			//	document.forms['editclass']['prop_'+conta+'_valorpadrao'].value="<? echo $classinfo['classe']['prefixo'].".php";?>";
			//	document.forms['editclass']['prop_'+conta+'_valorpadrao'].disabled=true;
			//	ArrayCheck[conta]=1;
			//	apagaobjetoII = false;
			//	campovalorpadrao = true;
			//}
			///////////////////////////////////////////////////////////////////
			// STATUS DO CAMPO -- VALORPADRAO
			if (!campovalorpadrao)
				document.forms['editclass']['prop_'+conta+'_valorpadrao'].disabled=campovalorpadrao;
			
			// ESCONDE CAMPO -- OBJETO, OBJETOI, OBJETOII
			if (apagaobjeto) 
			{
				document.forms['editclass']['prop_'+conta+'_cod_referencia_classe'].disabled=true;
				document.forms['editclass']['prop_'+conta+'_campo_ref'].disabled=true;
				ArrayCheck[conta]=0;
				document.getElementById(objeto).style.display='none';
                                document.getElementById(objetoo).style.display='none';

			}
			if (apagaobjetoI)
			{
				document.forms['editclass']['prop_'+conta+'_bolean_1'].disabled=true;
				document.forms['editclass']['prop_'+conta+'_bolean_2'].disabled=true;
				document.forms['editclass']['prop_'+conta+'_bolean_1'].value="";
				document.forms['editclass']['prop_'+conta+'_bolean_2'].value="";
				document.getElementById(objetoI).style.display='none';
			}
			//if (apagaobjetoII)
			//{
			//	document.forms['editclass']['prop_'+conta+'_seguranca'].disabled=false;
			//	document.forms['editclass']['prop_'+conta+'_seguranca'][0].selected=true;
			//	document.forms['editclass']['prop_'+conta+'_valorpadrao'].value="";
			//}
		}
	//-->
	
	</script>
	
	<div class="pblAlinhamentoTabelas">
	<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=8 class="pblTabelaGeral">
	<TR>
		<TD>
			<img border=0 src="/html/imagens/portalimages/peca3.gif" ALT="" align="left"><font class="pblTituloBox">Gerenciamento do Portal</font>
		</td>
		
		<TD>
			<a href="#" onclick="history.back()"><img border=0 src="/html/imagens/portalimages/voltar2.gif" ALT="Voltar"></a></TD>
	</TR>

	<tr>
		<td class="pblFormText">
            <form style="padding:0; margin:0;"  action="/index.php/do/classes/<? echo $_page->_objeto->Valor($_page, "cod_objeto")?>.html" method="get">
            	<TABLE width="100%" BORDER=0 cellpadding="4" cellspacing=2>
            		<tr>
            			<td width="140" class="pblTituloForm" valign="top" valign="top">
            				Selecione a Classe</td>
            			<td class="pblTextoForm">
            				<select class="pblSelectForm" name="cod_classe">
            					<option value="0"> -- NOVA -- </option> 
            					<?php echo $_page->_administracao->DropDownClasses($_page, $_GET['cod_classe'], false);?>
            				</select>
            				<input class="pblBotaoForm" type="submit" value="Selecionar">
							<BR>  
						</td>
					</tr>
				</table>
			</form>
			<hr style="pblLinha" size="1">
               <?php
               		$lista=$_page->_administracao->PegaListaDePrefixos($_page, $_GET['cod_classe']+0);
               		$strprfx=implode("','",$lista);
          			$cls=array();
					$lista=$_page->_administracao->PegaListaDeClasses($_page);
               		foreach($lista as $item)
               		{
               			if ($item['codigo']!=$_GET['cod_classe'])
               				$cls[]=$item['texto'];
               		}
               		$strcls=implode("','",$cls);
               ?>
<script type="text/javascript">
function ChecaValidade()
{
    prfx = new Array('<?echo $strprfx?>');
    cls = new Array('<?echo $strcls?>');
    if (EstaEntre('Prefixo', document.forms['editclass'].prefixo.value, prfx)) return false;
    if (EstaEntre('Nome', document.forms['editclass'].nome.value, cls)) return false;
    for (f=0;f < ArrayCheck.length;f++)
    {
        if (ArrayCheck[f]==1)
        {
            if (typeof(document.forms['editclass']['prop_'+f+'_cod_referencia_classe'])=='object')
            {
                if (document.getElementById('prop_'+f+'_cod_referencia_classe').value==0)
                {
                    alert ("Campo \'Classe de Referência\' da Propriedade "+f+" não pode ficar em branco.");
                    return false;
                }
                if (document.getElementById('prop_'+f+'_campo_ref').value=='')
                {
                    alert ("Campo \'Campo de Referência\' da Propriedade "+f+" não pode ficar em branco.");
                    return false;
                }
            }
        }
    }
    for (f=0;f<conta_prop;f++)
    {
        if (typeof(document.forms['editclass']['prop_'+f+'_nome'])=='object')
        {
            if (document.forms['editclass']['prop_'+f+'_nome'].value=='')
            {
                alert ("Campo \'Nome\' da Propriedade "+f+" não pode ficar em branco");
                return false;
            }
        }
    }
               		
    trGravarClasse1.style.display='none';
    trGravarClasse2.style.display='';
    return true;
}
</script>
               <form style="padding:0px; margin:0px;" action="/index.php/do/classes_post/<? echo $_page->_objeto->Valor($_page, "cod_objeto")?>.html" method="post" name="editclass" id="editclass" onsubmit="" ENCTYPE="multipart/form-data">
               	<input type="hidden" name="cod_classe" value="<? echo $classinfo['classe']['cod_classe']?>">
               	<input type="hidden" name="old_prefixo" value="<? echo $classinfo['classe']['prefixo']?>">
                <input type="hidden" name="old_indexar" value="<? echo $classinfo['classe']['indexar']?>">
               	<input type="hidden" name="old_temfilhos" value="<? echo $classinfo['classe']['temfilhos']?>">
               	<table border=0 width="100%" cellpadding="3" cellspacing="2">
               		<tr>
						<td width="140" class="pblTextoLabelForm" valign="top" valign="top">
               				Nome
               			</td>
               			<td class="pblTextoForm" valign="top" valign="top">
               				<input class="pblInputForm" type="text" name="nome" id="nome" value="<? echo $classinfo['classe']['nome']?>">
               			</td>
               		</tr>
               		<tr>
               			<td class="pblTextoLabelForm" valign="top">
               				Prefixo
               			</td>
               			<td class="pblTextoForm" valign="top">
               				<input class="pblInputForm" type="text" name="prefixo" id="prefixo" value="<? echo $classinfo['classe']['prefixo'];?>" 
               				<? if ($classinfo['classe']['sistema']==true) { echo ' disabled '; }?>>
               			</td>
               		</tr>
               		<tr>
               			<td class="pblTextoLabelForm" valign="top">
               				Descri&ccedil;&atilde;o
               			</td>
               			<td class="pblTextoForm" valign="top">
                                    <textarea class="pblInputForm" rows="4" cols="<? echo $areasize?>" name="descricao" id="descricao"><? echo $classinfo['classe']['descricao']?></textarea>
               			</td>
               		</tr>
               		<tr>
               			<td class="pblTextoLabelForm" valign="top">
               				Cont&eacute;m outros objetos
               			</td>
               			<td class="pblTextoForm" valign="top">
               				
               				<?php 
                                        $has = "";
                                        $dont = "";
                                            if ($classinfo['classe']['temfilhos'])
               				   {
               				   		$has=" checked ";
               				   }
               				   else
               				   {
               				   		$dont=" checked ";
               				   }
               				?>
               				<input type="radio"  name="temfilhos" <? echo $dont?> value="0" onclick="Estado('podeconter[]',true)">N&atilde;o<br>
               				<input type="radio" name="temfilhos" <? echo $has ?> value="1" onclick="Estado('podeconter[]',false)">Sim<br>
               			</td>
               		</tr>

					<tr>
               			<td class="pblTextoLabelForm" valign="top">
               				Indexar para pesquisa
               			</td>
               			<td class="pblTextoForm" valign="top">
               				
               				<?php
                                        $has = "";
                                        $dont = "";
                                        
                                        if ($classinfo['classe']['indexar'])
               				   {
               				   		$has=" checked ";
               				   }
               				   else
               				   {
               				   		$dont=" checked ";
               				   }
               				?>
               				<input type="radio"  name="indexar" <? echo $dont?> value="0">N&atilde;o<br>
               				<input type="radio" name="indexar" <? echo $has ?> value="1">Sim<br>

               			</td>
               		</tr>

			<tr>
               			<td class="pblTextoLabelForm" valign="top">
               				&Iacute;cone da classe
               			</td>
               			<td class="pblTextoForm" valign="top">
<?php
if (isset($_GET['cod_classe']) && !empty($_GET['cod_classe']) && $_GET['cod_classe']>0)
{
    if (file_exists(_BLOBDIR."classes/ic_".$classinfo["classe"]["prefixo"].".gif"))
    {
		$arquivo_exibir = "ic_".$classinfo["classe"]["prefixo"].".gif";
		$mensagem = $arquivo_exibir." <input type=\"checkbox\" name=\"apagar_icone\" id=\"apagar_icone\" value=\"apagar\" /> Apagar &iacute;cone.";
    } else {
		$arquivo_exibir = "ic_default.gif";
		$mensagem = "&Iacute;cone n&atilde;o definido";
    }
} else {
    $arquivo_exibir = "ic_default.gif";
    $mensagem = "&Iacute;cone n&atilde;o definido";
}
echo "<img src=\"/html/objects/_viewblob.php?tipo=classe&nome=".$classinfo["classe"]["prefixo"]."\" border=\"0\" align=\"absmiddle\" /> ".$mensagem."<br />";
//echo "<img src=\"/upd_blob/classes/".$arquivo_exibir."\" border=\"0\" align=\"absmiddle\" /> ".$mensagem."<br />";
?>
<input type="file" id="ic_classe" name="ic_classe" class="pblInputForm">
               			</td>
               		</tr>

               		<tr>
			    <td colspan="2">
			    <table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
               			<td width="50%" class="pblTextoLabelForm" valign="top">
               				<img src="/html/imagens/portalimages/icn_down.jpg" border="0" hspace="5">Pode Conter: 
               			</td>
                		<td class="pblTextoLabelForm" valign="top">
               				<img src="/html/imagens/portalimages/icn_down.jpg" border="0" hspace="5">Pode Ser Criado Nas Classes: 
               			</td>
					</tr>
					<tr>
               			<td class="pblTextoForm" valign="top" id="tdPodeConterChk">
               				<?php echo $_page->_administracao->CheckBoxClasses($_page, 'podeconter[]', $classinfo['todas'], 'permitido', ($classinfo['classe']['temfilhos']));?>
               			</td>
               			<td class="pblTextoForm" valign="top" id="tdPodeSerCriadoChk">
               				<?php echo $_page->_administracao->CheckBoxClasses($_page, 'criadoem[]',$classinfo['todas'],'criadoem');?>
               			</td>
				</tr>
			    </table>
			    </td>
               		</tr>
               		<tr>
               			<td class="pblTextoLabelForm" valign="top">
							Pode Ser Criado Em:<br>
							<i><font style="font-size: 9px">Use o campo texto para incluir objetos (por cod_objeto ou t&iacute;tulo)</font></i>
						</td>
               			<td class="pblTextoForm" valign="top">
							<?php
//							var_dump($classinfo['objetos']);
//							exit();
								if (isset($classinfo['objetos']) && is_array($classinfo['objetos']))
								{
									foreach ($classinfo['objetos'] as $objeto)
									{
							?>
										<input type="checkbox" name="objetos[]" checked value="<? echo $objeto['cod_objeto']?>"><? echo $objeto['titulo']?><BR>
							<?
									}
							    }
							?>
							<input class="pblInputForm" type="text" name="incluirObjeto" value="<?php echo(isset($_GET['IncluirObjeto'])?$_GET['IncluirObjeto']:"")?>"><P>
							<?php
								if (isset($_GET['MsgObjeto']))
								{
								 	echo '<font class="pblAlerta">'.$_GET['MsgObjeto'].'</font>';
								}
							?>
						</td>
					</tr>
               	</table>
            <div id="pp">
<?php
$count=0;
$posicaoMaior = 0;
if (is_array($classinfo['prop']))
{
    foreach ($classinfo['prop'] as $prop)
    {
        if ($prop['posicao']>$posicaoMaior) $posicaoMaior=$prop['posicao'];
?>
                <div id='DivProp<?php echo $count?>'>
                    <table border='0' width="540" cellpadding='0' cellspacing='6'>
                        <tr>
                            <td width="50" nowrap class="pblTextoLabelForm">
                                Propriedade <?php echo $count?> (<?php echo $prop['cod_propriedade'] ?>)
                            </td>
                            <td colspan="2">
                                <hr color="#FA9C00" size="3" width="95%">
                            </td>
                        </tr>
                        <tr>
                            <td class='pblTextoLabelForm'>
                                Prefixo<br>
                                <input type="hidden" name="prop_<?php echo $count?>_nomeatual" id="prop_<?php echo $count?>_nomeatual" value="<?php echo $prop['nome']?>">
                                <input class="pblInputForm" type="text" name="prop_<?php echo $count?>_nome" id="prop_<?php echo $count?>_nome" value="<?php echo $prop['nome']?>">
                            </td>
                            <td class="pblTextoLabelForm">
                                R&oacute;tulo<br>
                                <input class="pblInputForm" type="text" name="prop_<?php echo $count?>_rotulo" id="prop_<?php echo $count?>_rotulo" value="<?php echo $prop['rotulo']?>"> 
                            </td>
                            <td class='pblTextoLabelForm'>
                                Tipo de Dado<br>
                                <input type="hidden" name="prop_<? echo $count?>_cod_tipodado" value="<? echo $prop['cod_tipodado']?>">
                                <select disabled class="pblInputForm" name="prop_<?php echo $count?>_tipodado" OnChange="ChecaTipoDado(this,<?php echo $count?>, trPropClass<?php echo $count?>)">
                                    <?php echo $_page->_administracao->DropDownTipoDado($_page, $prop['cod_tipodado'],true);?>
                                </select>
                            </td>
                        </tr>
                        <tr id="trPropClasss<?php echo $count?>" style="display:<?php echo(($prop['cod_tipodado']==6)?'':'none')?>">
                            <td class='pblTextoLabelForm pblObrigatorio' colspan="3">                               
                                Refer&ecirc;ncias:
                            </td>
                        </tr>
                        <tr id="trPropClass<?php echo $count?>" style="display:<?php echo(($prop['cod_tipodado']==6)?'':'none')?>">
                            <td valign="top" class='pblTextoLabelForm' colspan="2">
                            <?php
                            if (!$prop['cod_referencia_classe'])
                            {
                                $txtref=' disabled ';
                            }
                            else
                            {
                                $txtref='';
                            ?>
                            <script type="text/javascript">ArrayCheck[<? echo $count?>]=1</script>
                            <?php
                            }
                            ?>
                                Classe de Refer&ecirc;ncia<BR>
                                <input type="hidden" name="prop_<?php echo $count?>_cod_referencia_classe" id="prop_<?php echo $count?>_cod_referencia_classe" value="<?php echo $prop['cod_referencia_classe']?>">
                                <select disabled class="pblSelectForm" name="prop_<?php echo $count?>_cod_referencia_classe" id="prop_<?php echo $count?>_cod_referencia_classe" <?php echo $txtref?>>
                                    <?php echo $_page->_administracao->DropDownClasses($_page, $prop['cod_referencia_classe'],true);?>
                                </select>
                            </td>
                            <td valign="top" class='pblTextoLabelForm'>
                                Campo de Refer&ecirc;ncia<BR>
                                <input type="hidden" name="prop_<?php echo $count?>_cod_referencia_campo_ref" id="prop_<?php echo $count?>_cod_referencia_campo_ref" value="<?php echo $prop['campo_ref']?>">
                                <input  disabled class="pblInputForm" type="text" name="prop_<?php echo $count?>_campo_ref" id="prop_<?php echo $count?>_campo_ref" value="<?php echo $prop['campo_ref']?>" <?php echo $txtref?> > 
                            </td>
                        </tr>
                        <tr id="trPropClassBlolean<?php echo $count?>" style="display:<?= ($prop['cod_tipodado']==2)?'':'none'?>">
                            <td class="pblTextoLabelForm pblObrigatorio">Nomea&ccedil;&atilde;o:</td>
                            <td valign="top" class="pblTextoLabelForm">
                                Campo 1:<BR>
                                <input class="pblInputForm" type="text" name="prop_<?php echo $count?>_bolean_1" id="prop_<?php echo $count?>_bolean_1" value="<?=$prop['rot1booleano']?>">
                            </td>
                            <td valign="top" class="pblTextoLabelForm">
                                Campo 0:<BR>
                                <input class="pblInputForm" type="text" name="prop_<?php echo $count?>_bolean_2" id="prop_<?php echo $count?>_bolean_2" value="<?=$prop['rot2booleano']?>">
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class='pblTextoLabelForm'>
                                Valor Padr&atilde;o<br>
                                <input class="pblInputForm" type="text" name="prop_<?php echo $count?>_valorpadrao" id="prop_<?php echo $count?>_valorpadrao"
                                 <?= ($prop['valorpadrao']!=" ")?' value="'.$prop['valorpadrao'].'"':'value=""';?> maxlength="200">	
                            </td>
                            <td valign="top" class='pblTextoLabelForm'>
                                Posi&ccedil;&atilde;o<br>
                                <input class="pblInputForm" type="text" name="prop_<?php echo $count?>_posicao" id="prop_<?php echo $count?>_posicao" value="<?php echo $prop['posicao']?>">
                            </td>
                            <td class="pblTextoLabelForm">
                                Seguran&ccedil;a:
                                <select class="pblSelectForm" name="prop_<?php echo $count?>_seguranca" id="prop_<?php echo $count?>_seguranca" OnChange="">
                                    <option value="<?=_PERFIL_AUTOR?>"<?= ($prop['seguranca']==_PERFIL_AUTOR)?' selected ':''?>>Autor</option>
                                    <option value="<?=_PERFIL_EDITOR?>"<?= ($prop['seguranca']==_PERFIL_EDITOR)?' selected ':''?>>Editor</option>
                                    <option value="<?=_PERFIL_ADMINISTRADOR?>"<?= ($prop['seguranca']==_PERFIL_ADMINISTRADOR)?' selected ':''?>>Administrador</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="pblTextoLabelForm" colspan="2">
                                Descri&ccedil;&atilde;o<br>
                                <textarea class="pblInputForm" name="prop_<?php echo $count?>_descricao" id="prop_<?php echo $count?>_descricao" rows="2" cols="55"><?php echo $prop['descricao']?></textarea>
                            </td>
                            <td class="pblTextoLabelForm">
                                <input type="checkbox" name="prop_<?php echo $count?>_obrigatorio" id="prop_<?php echo $count?>_obrigatorio" <?= ($prop['obrigatorio'])?' checked ':''?> value="1">&nbsp;Obrigat&oacute;rio
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" valign="bottom" align="right" class="pblTextoForm">
                                <input  class="pblBotaoForm" type="button" name="apagar_prop" value="Apagar Propriedade" onclick="ApagarPropriedade(<? echo $count?>);return false;">
                            </td>
                        </tr>
                    </table>
                </div>
<?php		
        $count++;
    }
}
?>
                <div id="novapp">
                </div>
            </div>
            <hr color="#FA9C00" size="2">
            <table border=0 width="100%" cellpadding="4" cellspacing="0">
                <tr id="trGravarClasse1">
                    <td class="pblTextoForm" align="left">
                        <input class="pblBotaoForm" type="button" value="Adicionar Propriedade" onclick="AdicionarPropriedade();return false;">
                    </td>
                    <td class="pblTextoLabelForm" align="right">
                    <?php if (!$classinfo['classe']['sistema']) {?>
                        <input class="pblBotaoForm" type="submit" name="apagar" value="Apagar Classe" onclick="javascript: return ConfirmDelete();">&nbsp;&nbsp;
                    <? }?>
                        <input  type="submit" name="submit" onclick="return ChecaValidade()" class="pblBotaoForm" value="Gravar">
                    </td>
                </tr>
                <tr id="trGravarClasse2" style="display:none">
                    <td colspan="2" align="right" class="pblTextoForm">
                        Aguarde, salvando propriedades da Classe . . . 
                    </td>
                </tr>			
            </table>
<?php
$novo_div='<div id="DivProp\'+conta_prop+\'">
    <table border="0" width="540" cellpadding="0" cellspacing="6">
        <tr>
            <td width="50" nowrap class="pblTextoLabelForm">
                Propriedade \'+conta_prop+\'
            </td>
            <td colspan="2">
                <hr color="#FA9C00" size="3" width="95%">
            </td>
        </tr>
	<tr>
            <td class="pblTextoLabelForm">
                Prefixo<br>
		<input class="pblInputForm" type="text" name="prop_\'+conta_prop+\'_nome" value="">
            </td>
            <td class="pblTextoLabelForm">
		R&oacute;tulo<br>
		<input class="pblInputForm" type="text" name="prop_\'+conta_prop+\'_rotulo" value=""> 
            </td>												
            <td class="pblTextoLabelForm">
		Tipo de Dado<br>
		<select class="pblSelectForm" name="prop_\'+conta_prop+\'_cod_tipodado" id="prop_\'+conta_prop+\'_cod_tipodado" OnChange="ChecaTipoDado(this,\'+conta_prop+\',trPropClass\'+conta_prop+\')">
                    '. $_page->_administracao->DropDownTipoDado($_page, "",true) .'
		</select>
            </td>
	</tr>
        <tr id="trPropClasss\'+conta_prop+\'" style="display:none">
            <td class="pblTextoLabelForm pblObrigatorio" colspan="3">Refer&ecirc;ncias:</td>
        </tr>
	<tr id="trPropClass\'+conta_prop+\'" style="display:none">
            <td valign="top" class="pblTextoLabelForm" colspan="2">
                Classe de Refer&ecirc;ncia<BR>
                <select class="pblSelectForm" name="prop_\'+conta_prop+\'_cod_referencia_classe" id="prop_\'+conta_prop+\'_cod_referencia_classe" disabled>
                        '. $_page->_administracao->DropDownClasses($_page, "",true) .'
                </select>
            </td>
            <td valign="top" class="pblTextoLabelForm">
                Campo de Refer&ecirc;ncia<BR>
                <input class="pblInputForm" type="text" name="prop_\'+conta_prop+\'_campo_ref" id="prop_\'+conta_prop+\'_campo_ref" value="" disabled>
            </td>
        </tr>
        <tr id="trPropClassBlolean\'+conta_prop+\'" style="display:none">
            <td class="pblTextoLabelForm pblObrigatorio">Nomea&ccedil;&atilde;o:</td>
            <td valign="top" class="pblTextoLabelForm">
                Campo 1:<BR>
                <input class="pblInputForm" type="text" name="prop_\'+conta_prop+\'_bolean_1" id="prop_\'+conta_prop+\'_bolean_1" value="" disabled>
            </td>
            <td valign="top" class="pblTextoLabelForm">
                Campo 0:<BR>
                <input class="pblInputForm" type="text" name="prop_\'+conta_prop+\'_bolean_2" id="prop_\'+conta_prop+\'_bolean_2" value="" disabled>
            </td>
        </tr>
        <tr>
            <td valign="top" class="pblTextoLabelForm">
                Valor Padr&atilde;o<br>
                <input class="pblInputForm" type="text" name="prop_\'+conta_prop+\'_valorpadrao" id="prop_\'+conta_prop+\'_valorpadrao" value="" maxlength="200">	
            </td>
            <td class="pblTextoLabelForm">
                Posi&ccedil;&atilde;o<br>
                <input class="pblInputForm" type="text" name="prop_\'+conta_prop+\'_posicao" id="prop_\'+conta_prop+\'_posicao" value="">
            </td>
            <td class="pblTextoLabelForm">
                Seguran&ccedil;a:<br>
                <select class="pblSelectForm" name="prop_\'+conta_prop+\'_seguranca" id="prop_\'+conta_prop+\'_seguranca" OnChange=trMensagemTemporaria.style.display="">
                    <option value="'._PERFIL_AUTOR.'" selected>Autor</option>
                    <option value="'._PERFIL_EDITOR.'">Editor</option>
                    <option value='._PERFIL_ADMINISTRADOR.'">Administrador</option>
                </select>
            </td>
        </tr>
        <tr id="trMensagemTemporaria" style="display:none">
            <td colspan="3" class="pblTextoLabelForm pblObrigatorio">
                <font size=1>Aten&ccedil;&atilde;o: Campos ocultos a usu&aacute;rios que n&atilde;o possuem valor padr&atilde;o s&atilde;o gravados como vazio.</font>
            </td>
        </tr>	
        <tr>
            <td class="pblTextoLabelForm" colspan="2">
                Descri&ccedil;&atilde;o<br>
                <textarea name="prop_\'+conta_prop+\'_descricao" id="prop_\'+conta_prop+\'_descricao" rows="2" cols="55" class="pblInputForm"></textarea>
            </td>
            <td class="pblTextoLabelForm">
                <input type="checkbox" name="prop_\'+conta_prop+\'_obrigatorio" id="prop_\'+conta_prop+\'_obrigatorio" value="1">&nbsp;Obrigat&oacute;rio
            </td>
        </tr>
        <tr>
            <td colspan="3" valign="bottom" align="right" class="pblTextoForm">
                <input class="pblBotaoForm" type="button" name="apagar_prop" value="Apagar Propriedade" onclick="ApagarPropriedade(\'+conta_prop+\');return false;">
            </td>
        </tr>
    </table>
</div>';
$novo_div=str_replace("\n","",$novo_div);
$novo_div=str_replace("\r","",$novo_div);
?>               		
            </form>
		</td>
	</tr>
	
	<tr><td colspan="3"><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>

	</table>
	</div>

            <script type="text/javascript">

	var conta_prop=<?php echo ($count+0)?>;
	var posicaoMaior = <?php echo ($posicaoMaior+1);?>;

		
		function AdicionarPropriedade()
		{
			divobj = document.getElementById('novapp');
			divobj = document.getElementById('pp');
			novodiv= document.createElement("div"); 			
			novodiv.innerHTML='<? echo $novo_div?>';
			divobj.appendChild(novodiv);
			
			var inputvalue = 'prop_'+conta_prop+'_posicao';
			eval('document.editclass.'+inputvalue+'.value='+posicaoMaior++);
			conta_prop++;
		}
		function ApagarPropriedade(indice)
		{
		    if (confirm("Deseja realmente apagar esta propriedade?"))
		    {
			divobj = document.getElementById('DivProp'+indice);
			divobj.style.visibility="hidden";
			divobj.style.display="none";
			divobj.innerHTML="";
			//conta_prop--;
			//posicaoMaior--;
		    }
		}
</script>