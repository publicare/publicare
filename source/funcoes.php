<?php

function _antiSqlInjection($Target){
    $sanitizeRules = array('FROM','SELECT','INSERT','DELETE','WHERE','DROP TABLE','SHOW TABLES','*','--','=','SCRIPT','EVAL');
    foreach($Target as $key => $value):
        if(is_array($value)): $arraSanitized[$key] = _antiSqlInjection($value);
        else:
            $arraSanitized[$key] = (!get_magic_quotes_gpc()) ? addslashes(str_ireplace($sanitizeRules,"",$value)) : str_ireplace($sanitizeRules,"",$value);
        endif;
    endforeach;
    return $arraSanitized;
}


function PegaExtensaoArquivo($nome)
{
	$filetype = "";
	if ($nome && !empty($nome) && $nome!="")
	{
		$arrNome = split("[.]", $nome);
		$filetype = strtolower($arrNome[count($arrNome)-1]);
	}
	
	return $filetype;
}

/**
 * Funcao usada para redirecionar páginas quando já tem saida de informação
 *
 * @param unknown_type $url
 */
function redirecionar($url)
{
	echo "<script>
	document.location.href='".$url."';
	</script>";
}


/**
 * Retorna texto cortado. Não corta as palavras no meio.
 *
 * @param unknown_type $txt
 * @param unknown_type $tam
 * @return unknown
 */
function cortaTexto($txt, $tam){
	$vtxt = explode(" ", $txt);
	$tam_temp = 0;
	$txt_temp = "";
	for ($cont=0; $cont<sizeof($vtxt); $cont++){
		$tam_temp += strlen($vtxt[$cont]);
		if ($tam_temp < $tam)
		{
			$txt_temp .= " ".$vtxt[$cont];
		}
		else
		{
			$txt_temp .= "...";
			break;
		}
	}
	return $txt_temp;
}
 
/**
 * Recebe o código do blob e retorna o nome da pasta onde ficará
 *
 * @param unknown_type $cod_blob
 * @return unknown
 */
function identificaPasta($cod_blob){
	$ret = false;
	$tamanho = strlen($cod_blob);
	if ($cod_blob+0) {
		if ($tamanho<=3){
			$ret="0000";
		} else {
			$ret = (int)($cod_blob/1000);
		}
		for ($i=strlen($ret); $i<4; $i++) $ret="0".$ret;
	}
	return $ret;
}

/**
 * Calendário
 */
$dias_da_semana=array('Dom','Seg','Ter','Qua','Qui','Sex','Sáb');
$nome_do_mes=array("", "janeiro", "fevereiro", "mar&ccedil;o", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");

/**
 * Monta calendario do publicare
 *
 * @param unknown_type $url
 * @param unknown_type $cor
 * @param unknown_type $titulo
 * @param unknown_type $ano
 * @param unknown_type $mes
 * @param unknown_type $showdays
 * @param unknown_type $startyear
 */
function calendario($url, $cor='', $titulo='', $ano='', $mes='',$showdays=true,$startyear=2001)
{
	if (!$state)
		$state = 0;
	if (!$iporigem)
		$iporigem = 0;
	global $dias_da_semana;
	global $nome_do_mes;
	if((!$ano)||(!isset($ano))) $ano=date('Y');
	if((!$mes)||(!isset($mes))) $mes=date('m');
	$mes=abs($mes);
	$cor="ff9900";
	$subtom="ffcc99";

	$TD='<TD class="pblCalendario" bgcolor="'.$subtom.'" align="center"><font class="pblCalendario">';
	echo '<TABLE width=150 cellpadding="1" cellspacing="1" bgcolor="#'.$cor.'"><TR>';
	echo '<TD class="pblCalendario" bgcolor="'.$subtom.'" align="center" colspan="7">';
	echo '<font class="TextoBoldPreto">'.$titulo.' '.$nome_do_mes[$mes].'/'.$ano.'</font></TD></TR><TR>';

		if ($showdays)
		{
			if (($ano==date("Y")) && ($mes==intval(date("m"))))
				$limit=intval(date('d'));
			else
				$limit=32;
			foreach($dias_da_semana as $dia_da_semana)
			{
				echo $TD.$dia_da_semana[0].'</TD>';
			}
			echo '</TR><TR>';
			echo str_repeat ($TD."&nbsp;</TD>", date('w',mktime (0,0,0, abs($mes), 1, $ano)));

			for($n=1;$n<=31;$n++)
			{
				if(checkdate($mes, $n, $ano))
				{
					echo $TD;
					$timestamp=mktime (1,1,1, abs($mes), $n, $ano);
					if ($n>$limit)
						echo $n;
					else
					{
						//echo '<a href="'.$url.'?year='.$ano.'&month='.$mes.'&day='.$n.'"><b>';
						echo "<a href=\"JavaScript: JSCalendarioChangeData('".$url."',".$ano.",".$mes.",".$n.");\"><b>";
						echo $n.'</b></a>';
					}
					echo '</TD>';
					if(date('w',$timestamp)==6) echo '</TR><TR>';
				} else break;
			}
			echo str_repeat ($TD."&nbsp;</TD>", (6-date('w',mktime (0,0,0, abs($mes), $n-1, $ano))));

		}

		echo '</TR><TR><TD colspan=7 class="pblCalendario" align="center">';
		echo '<b>OUTROS MESES</b>';
		echo '<TABLE border=0 cellpadding="1" cellspacing="1" width="100%"><TR>';
		$TD='<TD class="pblCalendario" bgcolor="'.$subtom.'" align="center"><font class="pblCalendario">';

		$conta_mes=1;
		$max=3;
		if ($ano==date("Y"))
			$limit=intval(date("m"));
		else
			$limit=12;

		while($conta_mes<=$limit)
		{
			$count++;
			echo $TD;
			echo "<a href=\"JavaScript: JSCalendarioChangeData('".$url."',".$ano.",".$conta_mes.");\">".$nome_do_mes[$conta_mes++]."</A></TD>";
			if($count==$max) {
			 	echo '</TR></TABLE><TABLE border=0 cellpadding="1" cellspacing="1" width="100%"><TR>';
				$count=0;
			}
		}
		echo '</TR></TABLE>';
		echo '<font class="pblCalendario"><strong>OUTROS ANOS</strong></font>';
		echo '<TABLE border=0 cellpadding="1" cellspacing="1" width="100%"><TR>';

		$conta_ano=$startyear;
		while($conta_ano<=intval(Date('Y')))
		{
			echo $TD;
			echo "<a href=\"JavaScript: JSCalendarioChangeData('".$url."',".$conta_ano.");\">".$conta_ano++."</A></TD>";
		}
		echo '</TR></TABLE></TD></TR></TABLE>';
	}

	/**
	 * Detecta o browser usado pelo usuario
	 *
	 * @return unknown
	 */
	function DetectaBrowser(){
	// ESTA FUNCAO ESTA REPLICADA NAS PASTAS: /LOGIN E /PUBLICARE
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
	// Transforma $arrBrowser[0] em minusculas
	$arrBrowser[0] = strtolower($arrBrowser[0]);
	return $arrBrowser;
	}

	
/**
 * Retorna nome do perfil, de acordo com a constante
 *
 * @param unknown_type $tmpNum
 * @return unknown
 */
	function VerificaPerfil($tmpNum){
		switch ($tmpNum) {
		case _PERFIL_ADMINISTRADOR:
			$tmpPerfil = "Administrador";
			break;
		case _PERFIL_EDITOR:
			$tmpPerfil = "Editor";	
			break;
		case _PERFIL_AUTOR:
			$tmpPerfil = "Autor";
			break;
		case _PERFIL_RESTRITO:
			$tmpPerfil = "Restrito";
			break;
		case _PERFIL_MILITARIZADO:
			$tmpPerfil = "Militarizado";
			break;
		case _PERFIL_DEFAULT:
			$tmpPerfil = "Nenhum";
			break;
		default:
			$tmpPerfil = "!incoerencia";
			break;
		}
	return $tmpPerfil;
	}
	
	function array_push_associative(&$arr) {
	   $args = func_get_args();
	   foreach ($args as $arg) {
	       if (is_array($arg)) {
	           foreach ($arg as $key => $value) {
	               $arr[$key] = $value;
	               $ret++;
	           }
	       }else{
	           $arr[$arg] = "";
	       }
	   }
	   return $ret;
	}
	

	function EnviarEmail($remetente_nome, $remetente_email, $destinatario_nome, $destinatario_email, $assunto=-1, $texConteudo=-1, $altConteudo="", $arrArquivoAnexado=array())
	{
		include_once("phpmailer/class.phpmailer.php");
		
		// para views antes da versao 2.8.9
		$flag = 0;
		if ($assunto==-1 && $texConteudo==-1)
		{
			$tempRem = $remetente_nome;
			$tempDes = $remetente_email;
			$tempAss = $destinatario_nome;
			$tempMsg = $destinatario_email;

			// arrumando campo remetente
			if (strpos($remetente_nome, "<")!==false)
			{
				$remetente_nome = substr($tempRem, 0, strpos($tempRem, "<"));
				$remetente_email = substr($tempRem, strpos($tempRem, "<")+1, strpos($tempRem, ">")-strpos($tempRem, "<")-1);
			}
			else
			{
				$remetente_nome = $remetente_email = $tempRem;
			}
			
			// arrumando campo destinatario
			$arDes = preg_split("[,|;]", $tempDes);

			$destin = array();
			for ($i=0; $i<count($arDes); $i++)
			{
				$temp = $arDes[$i];
				$destin[] = array("nome"=>"", "email"=>$temp);
			}
			
			$assunto = $tempAss;
			$texConteudo = $tempMsg;
			
			$flag = 1;
		}
		else
		{
			$destin = array(array("nome"=>$destinatario_nome, "email"=>$destinatario_email));
		}
		
		$mail = new PHPMailer(true);
		$mail->Charset = 'UTF-8';
		
		$retorno = false;
		
		foreach ($arrArquivoAnexado as $arq)
		{
			$mail->AddAttachment($arq[0], $arq[1]);
		}
		
		if (_mailsmtp)
		{
			// envio smtp
			try {
				$mail->SetFrom($remetente_email, $remetente_nome);
				$mail->AddReplyTo($remetente_email, $remetente_nome);
				$mail->IsHTML(true);
				$mail->Subject = $assunto;
				$mail->Body     = $texConteudo;
				$mail->AltBody = $altConteudo;
				$mail->IsSMTP();
				$mail->Host     = _mailhost;
				$mail->Port     = _mailport;
				if (_mailuser!="")
				{
					$mail->SMTPAuth = true;
					$mail->Username = _mailuser;
					$mail->Password = _mailpass;		
				}
				foreach($destin as $dest)
				{
					$mail->AddAddress($dest["email"], $dest["nome"]);
				}
				$mail->Send();
				$retorno = true;
			} catch (phpmailerException $e) {
				echo $e->errorMessage();
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		} 
		else 
		{
			// envio simples
			try
			{
				$mail->SetFrom($remetente_email, $remetente_nome);
				$mail->AddReplyTo($remetente_email, $remetente_nome);
				foreach($destin as $dest)
				{
					$mail->AddAddress($dest["email"], $dest["nome"]);
				}
				$mail->Subject    = $assunto;
				$mail->AltBody    = $altConteudo;
				$mail->MsgHTML($texConteudo);
				$mail->Send();
				$retorno = true;
			} catch (phpmailerException $e) {
				echo $e->errorMessage(); 
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
		
		return $retorno;
	}
	
	
	/*FUNÇÃO ÚTIL PARA DEBUG*/
	function xd($obj)
	{
		echo "<div style='background-color:#DFDFDF; border:1px #666666 solid'>";
			echo "<pre>";
				var_dump($obj);
			echo "</pre>";
		echo "</div>";
		die();
	}
	
	/*FUNÇÃO ÚTIL PARA DEBUG SEM  DIE*/
	function x($obj)
	{
		echo "<div style='background-color:#DFDFDF; border:1px #666666 solid'>";
			echo "<pre>";
				var_dump($obj);
			echo "</pre>";
		echo "</div>";
	}
	
	
	/**
    * Retira acentos, espaços e caracteres especiais da string
    * @param  string $str - string que ira ser tratada
    * @return string
    */
    function limpaString($str)
	{
		
		$acentos = array(
					'A' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
					'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
					'C' => '/&Ccedil;/',
					'c' => '/&ccedil;/',
					'E' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/',
					'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/',
					'I' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/',
					'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/',
					'N' => '/&Ntilde;/',
					'n' => '/&ntilde;/',
					'O' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/',
					'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/',
					'U' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/',
					'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/',
					'Y' => '/&Yacute;/',
					'y' => '/&yacute;|&yuml;/',
					'-' => '/ |&amp;|&uml;|&ordf;|&ordm;|&deg;|&gt;|&lt;|&nbsp;|&sup1;|&sup2;|&sup3;|&quot;|\/|\–|_/',
					'' => '/\.|,|\$|\?|\"|\'|\*|\:|\!|\“|\”|\(|\)|\||\+|\¹|\?|&ldquo;|&rdquo;/');

		$palavra =  preg_replace($acentos, array_keys($acentos), htmlentities($str, ENT_QUOTES, "UTF-8"));
		$palavra = str_replace("--", "-", $palavra);
		$palavra = str_replace("--", "-", $palavra);
		$palavra = str_replace("--", "-", $palavra);
	
		return $palavra;

	}
	
	function limpaStringEspaco($str)
	{
		
		$acentos = array(
					'A' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
					'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
					'C' => '/&Ccedil;/',
					'c' => '/&ccedil;/',
					'E' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/',
					'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/',
					'I' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/',
					'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/',
					'N' => '/&Ntilde;/',
					'n' => '/&ntilde;/',
					'O' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/',
					'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/',
					'U' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/',
					'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/',
					'Y' => '/&Yacute;/',
					'y' => '/&yacute;|&yuml;/');

		$palavra =  preg_replace($acentos, array_keys($acentos), htmlentities($str, ENT_QUOTES, "UTF-8"));
		$palavra = str_replace("--", "-", $palavra);
		$palavra = str_replace("--", "-", $palavra);
		$palavra = str_replace("--", "-", $palavra);
	
		return $palavra;

	}

	/**
	* Lê arquivo em byte streaming
	*/
	function readfile_chunked($filename, $retbytes=true)
	{
		$chunksize = 1*(1024*1024); // tamanho dos pedaços
		$buffer = '';
		$cnt = 0;
		$handle = fopen($filename, 'rb');
		if ($handle === false) return false;
		while (!feof($handle))
		{
			$buffer = fread($handle, $chunksize);
			echo $buffer;
			ob_flush();
			flush();
			if ($retbytes)
			{
				$cnt += strlen($buffer);
			}
		}
		$status = fclose($handle);
		if ($retbytes && $status) return $cnt;
		return $status;
	} 	
