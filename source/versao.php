<?php
define ('_VERSIONPROG','Publicare 2.7.8 - 03/04/2009');

/*
	vers�o: 2.7.6 - Adicionada a possibilidade de usar o like na condi��o do localizar.
		            alterado o arquivo adminobjeto.class.php nas linhas 357 E 788
		            Rodrigo 20/03/2009
*/

/*
	vers�o: 2.7.7 - Alterada a pasta tmp do ADODB para /tmp/adodb, as vers�es anteriores estvam apagando todos os arquivos com permiss�o para o apache.
		            alterado o arquivo adodb.inc.php nas linhas 164
		            Manuel Poppe 03/04/2009
*/

/*
	vers�o: 2.7.8 - Alterado metodo publicaObjeto para enviar email de notificacao de publicacao. Para que a fun��o funcione � necess�rio acrescentar 3 linhas no publicare.conf.
					Exemplo:	
					define('_avisoPublicacao', true);
					define('_emailAvisoPublicacao', "mpoppe@mct.gov.br");
					define('_remetenteAvisoPublicacao', "ascom@mct.gov.br");
					
		            alterado o administracao.class.php nas linhas 801 a 830
		            Manuel Poppe 03/04/2009
*/

?>
