<?php
define ('_VERSIONPROG','Publicare 2.7.8 - 03/04/2009');

/*
	versão: 2.7.6 - Adicionada a possibilidade de usar o like na condição do localizar.
		            alterado o arquivo adminobjeto.class.php nas linhas 357 E 788
		            Rodrigo 20/03/2009
*/

/*
	versão: 2.7.7 - Alterada a pasta tmp do ADODB para /tmp/adodb, as versões anteriores estvam apagando todos os arquivos com permissão para o apache.
		            alterado o arquivo adodb.inc.php nas linhas 164
		            Manuel Poppe 03/04/2009
*/

/*
	versão: 2.7.8 - Alterado metodo publicaObjeto para enviar email de notificacao de publicacao. Para que a função funcione é necessário acrescentar 3 linhas no publicare.conf.
					Exemplo:	
					define('_avisoPublicacao', true);
					define('_emailAvisoPublicacao', "mpoppe@mct.gov.br");
					define('_remetenteAvisoPublicacao', "ascom@mct.gov.br");
					
		            alterado o administracao.class.php nas linhas 801 a 830
		            Manuel Poppe 03/04/2009
*/

?>
