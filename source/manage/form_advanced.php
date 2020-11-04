<?
global $_page;
?>
<div class="pblAlinhamentoTabelas">
	<TABLE WIDTH=570 BORDER=0 CELLPADDING=0 CELLSPACING=8 class="pblTabelaGeral">
	
	<tr>
	<td width="100%" height="150px">&nbsp;
	</td>
	</tr>
	
	<tr>
		<td class="pblTextoLabelForm">
			Descri&ccedil;&atilde;o deste Objeto
		</td>
		<td class="pblTextoForm" colspan="2">
			<textarea class="pblInputForm" mmTranslatedValueHiliteColor="HILITECOLOR='No Color'" mmTranslatedValueHiliteColor="HILITECOLOR='No Color'" name="descricao" cols=45 rows=4><? if ($edit) echo $_page->_objeto->ValorParaEdicao($_page, "descricao") ?></textarea>
		</td>
	</tr>
	<!--
	-- removendo tags do form avançado
	--
	<tr>
		<td class="pblTextoLabelForm">
			TAGS deste Objeto
		</td>
		<td class="pblTextoForm" colspan="2">
			<textarea class="pblInputForm" mmTranslatedValueHiliteColor="HILITECOLOR='No Color'" mmTranslatedValueHiliteColor="HILITECOLOR='No Color'" name="tags" cols=45 rows=4><? if ($edit) echo $_page->_objeto->ValorParaEdicao($_page, "tags") ?></textarea>
		</td>
	</tr>
	-->
	<?php
		/* ........... SKIN ..........
		   Limita os campos PELE (publica e nao publica) / DONO DO OBJETO /
		*/
		//if ($_SESSION['usuario']['perfil'] == _PERFIL_ADMINISTRADOR) {
			echo "<tr><td class=\"pblTextoLabelForm\">Pele</td>\n";
			echo "<td class=\"pblTextoForm\" colspan=\"2\">\n";
			echo "<select class=\"pblSelectForm\" mmTranslatedValueHiliteColor=\"HILITECOLOR=%22No Color%22\" mmTranslatedValueHiliteColor=\"HILITECOLOR=%22No Color%22\" name=\"cod_pele\">\n";
			echo $_page->_administracao->DropDownListaDePeles($_page, $_page->_objeto->Valor($_page, "cod_pele"),true,$dadosPai['cod_pele']);			
			echo "\n</select>\n";
			echo "</td>\n</tr>";
		//}
		
	?> 
	<tr>
		<td class="pblTextoLabelForm">
			Script de exibi&ccedil;&atilde;o
		</td>
		<td class="pblTextoForm" colspan="2">
	
		<?php
		/* ........... SCRIPT_EXIBIR ..........
		   Limita os campos SCRIPT EXIBIR
		*/

		$DesenhaView = TRUE;
		$tmpScriptAtual = $_page->_objeto->metadados['script_exibir'];
		$RGX_SCRIPT = preg_match("/_protegido.*/",$tmpScriptAtual);
		$RGX_VIEWNO = preg_match("/view_protegido.php/",$tmpScriptAtual);

		
		if ($RGX_SCRIPT) {
			if ($_SESSION['usuario']['perfil'] != _PERFIL_ADMINISTRADOR)
				$DesenhaView = FALSE;
		}		
		
		// VERIFICACAO DE STATUS DE SCRIPT DE EXIBICAO
		if ($DesenhaView) {
			$DirectorioPathPadrao = $_SERVER['DOCUMENT_ROOT']."/html/template";
			$DirectorioPathwPele = $_SERVER['DOCUMENT_ROOT']."/html/skin/".$_page->_objeto->metadados['prefixopele'];
			$DirectorioViewPele = "/html/skin/".$_page->_objeto->metadados['prefixopele'];
			$DirectorioViewPadrao = "/html/template";
			
			echo "<select class=\"pblInputForm\" name=\"script_exibir\">";
			echo "<option value=\"0\">sele&ccedil;&atilde;o autom&aacute;tica</option>";
			
			/**
			 * MUDEI - AS VIEWS FORAM ORDENADAS EM ORDEM ALFABETICA 
			 * AS VIEWS(SCRIPT DE EXIBIÇÃO) FORAM COLOCADAS DENTRO DE UM ARRAY, O ARRAY FOI ORDENADO E DEPOIS
			 * FOI FEITO A IMPRESSÃO DAS VIEWS DENTRO DAS OPTIONS DO SELECT - RODRIGO 04/05/2009
			 */
			//LISTA VIEWS DA PELE
			if ($handle = opendir($DirectorioPathwPele)) 
			{
				//inicializa variável
				$arrViews = array();
				while (false !== ($ArquivoNome = readdir($handle))) 
				{
					//$tmpScriptDir = "$DirectorioViewPele/$ArquivoNome";
					$RGX_VIEWNO = preg_match("/view_protegido.php/",$ArquivoNome);
					
					/* CODIGO ANTIGO
					if ((substr($ArquivoNome,0,4) == "view") && (!$RGX_VIEWNO))
					{
						if ($edit && $tmpScriptDir == $tmpScriptAtual)
						  echo "<option value=\"$DirectorioViewPele/$ArquivoNome\" selected> (".$_page->_objeto->metadados['prefixopele'].") ".substr($ArquivoNome,0,-4)."</option>\n";
						else 
						  echo "<option value=\"$DirectorioViewPele/$ArquivoNome\"> (".$_page->_objeto->metadados['prefixopele'].") ".substr($ArquivoNome,0,-4)."</option>\n";
					}*/
					
					//COLOCA AS VIEWS DENTRO DO ARRAY
					if ((substr($ArquivoNome,0,4) == "view") && (!$RGX_VIEWNO))
					{
						array_push($arrViews, $ArquivoNome);
					}
					
				}
				
				//ORDENA O ARRAY E IMPRIME OS OPTIONS DAS VIEWS
				sort($arrViews);
				foreach($arrViews as $view) 
				{
					$tmpScriptDir = "$DirectorioViewPadrao/$view";
					
				    if ($edit &&  $tmpScriptDir== $tmpScriptAtual)
				    {
				    	echo "<option value=\"$DirectorioViewPele/$view\" selected> (".$_page->_objeto->metadados['prefixopele'].") ".substr($view,0,-4)."</option>\n";
				    }
					else 
					{
						echo "<option value=\"$DirectorioViewPele/$view\"> (".$_page->_objeto->metadados['prefixopele'].") ".substr($view,0,-4)."</option>\n";
					}
				}
				closedir($handle);
			}
			
			/**
			 * MUDEI - AS VIEWS FORAM ORDENADAS EM ORDEM ALFABETICA 
			 * AS VIEWS(SCRIPT DE EXIBIÇÃO) FORAM COLOCADAS DENTRO DE UM ARRAY, O ARRAY FOI ORDENADO E DEPOIS
			 * FOI FEITO A IMPRESSÃO DAS VIEWS DENTRO DAS OPTIONS DO SELECT - RODRIGO 04/05/2009
			 */
			//LISTA VIEWS DA PASTA TEMPLATE
			if ($handle = opendir($DirectorioPathPadrao)) 
			{	
				//inicializa variável
				$arrViews = array();
				while (false !== ($ArquivoNome = readdir($handle))) 
				{
					//$tmpScriptDir = "$DirectorioViewPadrao/$ArquivoNome";
					$RGX_VIEWNO = preg_match("/view_protegido.php/",$ArquivoNome);
					
					/* CODIGO ANTIGO
					if ((substr($ArquivoNome,0,4) == "view") && (!$RGX_VIEWNO))
					{					
						if ($edit && $tmpScriptDir == $tmpScriptAtual)
						  echo "<option value=\"$DirectorioViewPadrao/$ArquivoNome\" selected>(padr&atilde;o) ".substr($ArquivoNome,0,-4)."</option>\n";
						else 
						  echo "<option value=\"$DirectorioViewPadrao/$ArquivoNome\">(padr&atilde;o) ".substr($ArquivoNome,0,-4)."</option>\n";
					}*/
					
					//COLOCA AS VIEWS DENTRO DO ARRAY
					if ((substr($ArquivoNome,0,4) == "view") && (!$RGX_VIEWNO))
					{
						array_push($arrViews, $ArquivoNome);
					}
				}
				//ORDENA O ARRAY E IMPRIME OS OPTIONS DAS VIEWS
				sort($arrViews);
				foreach($arrViews as $view) 
				{
					$tmpScriptDir = "$DirectorioViewPadrao/$view";
					
				    if ($edit &&  $tmpScriptDir== $tmpScriptAtual)
				    {
					  	echo "<option value=\"$DirectorioViewPadrao/$view\" selected>(padr&atilde;o) ".substr($view,0,-4)."</option>\n";
				    }
					else 
					{
					  	echo "<option value=\"$DirectorioViewPadrao/$view\">(padr&atilde;o) ".substr($view,0,-4)."</option>\n";
					}
				}
				
				closedir($handle);
			}
			echo "</select>";
		}
		else {
			if ($edit)
				echo "<input type=\"hidden\" value=\"$tmpScriptAtual\" name=\"script_exibir\">Reservado ao <b>Administrador</b> do sistema.\n";
			else 
				echo "<input type=\"hidden\" value=\"/html/skin/".$dadosPai['prefixopele']."/view_".$classname."_protegido.php\" name=\"script_exibir\">Reservado ao <b>Administrador</b> do sistema.\n";
		}
		?>
		
		</td>
	</tr>
			<?php
				if ($_page->_administracao->UsuarioEDono($_page, $_SESSION['usuario']['cod_usuario'],$_page->_objeto->Valor($_page, "cod_objeto")) || ($_SESSION['usuario']['perfil'] <= _PERFIL_EDITOR))
				{
			?>
	<tr>
		<td class="pblTextoLabelForm">
			Dono do Objeto
		</td>
		<td class="pblTextoForm" colspan="2">
			
		<?php
					if ($edit) 
						$ListaDependente = $_page->_administracao->DropDownListaDependentes($_page, $intCodUsuarioDono);
					else 
						$ListaDependente = $_page->_administracao->DropDownListaDependentes($_page, $_SESSION['usuario']['cod_usuario']);
					if ($ListaDependente) {
						echo "<select class=\"pblSelectForm\" mmTranslatedValueHiliteColor=\"HILITECOLOR=%22No Color%22\" mmTranslatedValueHiliteColor=\"HILITECOLOR=%22No Color%22\" name=\"cod_usuario\">";
						echo $ListaDependente;
					}
					else {
						echo "<input type=\"hidden\" value=\"".$intCodUsuarioDono."\"  name=\"cod_usuario\">Reservado ao <b>Administrador</b> do sistema.</option>";
					}
		?>
		</select>
		</td>
	</tr>	
		<?php
			}
		?>
	<tr>
        <td class="pblTextoLabelForm">
			Peso
		</td>
		<td class="pblTextoForm" colspan="2">
			<input class="pblInputForm" type="text" name="peso" value="<?  if ($edit)
																echo $_page->_objeto->Valor($_page, 'peso');?>">
		</td>
	</tr>
	<tr><td colspan="5"><p class="pblAssinatura"><?php echo _VERSIONPROG; ?></p></td></tr>	
	</table>
	</div>