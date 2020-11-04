<?php
define ('_VERSIONPROG','Publicare 2.7.13 - 27/05/2009');

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

/*
	versão: 2.7.9 - Alterado o Portal Instalar.
					
					
		            alterado a pasta Portal Instalar, deixando site pronto a ser instalado com qualquer layout
		            Manuel Poppe 14/04/2009
*/

/*
	versão: 2.7.10 - Corrigido a possibilidade de usar o like na condição do localizar com mais de uma classe.
		            alterado o arquivo adminobjeto.class.php na linha 681
		            Danilo 17/04/2009
*/

/*
	versão: 2.7.11 - Implementado a verificação dos campos do tipo BLOB quando forem obrigatórios. 
					 Anteriormente a verificação não funcionava porque os campos do tipo BLOB não possuíam ID. 
					 A forma padrão de verificação dos campos do formuário se dá atravéz da recuperação do campo pelo ID do mesmo.
		             Alterado o arquivo "manage/form_construct.php" nas linhas 281 e 344
		             Alterado o arquivo "manage/controles.php" na linha 258
		             Rodrigo 30/04/2009
		             
		             Implementado ordenação dos scripts de exibição em ordem alfabética
					 As views da pele e pasta template foram ordenadas em ordem alfabetica na hora de exibição na combo
		             Alterado o arquivo "manage/form_advanced.php" entre as linhas 82 a 120 e 99 a 136
		             Rodrigo 04/05/2009
*/

/*
	versão: 2.7.12 - Corrigido método EnviarEmail do arquivo funcoes.php. Esse método
  fazia include('email.class.php') e isso gerava erro ao tentar redeclarar classe email quando
  tentava-se publicar vários objetos de uma só vez quando a notificação de aviso de publicação estava true.
  Foi substituido o " include('email.class.php');" por " include_once('email.class.php');" na linha 270.
					
		            alterado o funcoes.php nas linha 270
		            Danilo Lisboa 21/05/2009
*/

/*
	versão: 2.7.13 - Corrigida função showRSS no arquivo rss.class.php
				Inserido tags CDATA em todos os campos da função para escapar caratceres especiais.
					
		            alterado o rss.class.php nas linha 60 a 90
		            Danilo Lisboa 27/05/2009
*/
?>
