<?php
define ('_VERSIONPROG','Publicare 2.8.6 - 25/07/2010');

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

/*
	vers�o: 2.7.9 - Alterado o Portal Instalar.
					
					
		            alterado a pasta Portal Instalar, deixando site pronto a ser instalado com qualquer layout
		            Manuel Poppe 14/04/2009
*/

/*
	vers�o: 2.7.10 - Corrigido a possibilidade de usar o like na condi��o do localizar com mais de uma classe.
		            alterado o arquivo adminobjeto.class.php na linha 681
		            Danilo 17/04/2009
*/

/*
	vers�o: 2.7.11 - Implementado a verifica��o dos campos do tipo BLOB quando forem obrigat�rios. 
					 Anteriormente a verifica��o n�o funcionava porque os campos do tipo BLOB n�o possu�am ID. 
					 A forma padr�o de verifica��o dos campos do formu�rio se d� atrav�z da recupera��o do campo pelo ID do mesmo.
		             Alterado o arquivo "manage/form_construct.php" nas linhas 281 e 344
		             Alterado o arquivo "manage/controles.php" na linha 258
		             Rodrigo 30/04/2009
		             
		             Implementado ordena��o dos scripts de exibi��o em ordem alfab�tica
					 As views da pele e pasta template foram ordenadas em ordem alfabetica na hora de exibi��o na combo
		             Alterado o arquivo "manage/form_advanced.php" entre as linhas 82 a 120 e 99 a 136
		             Rodrigo 04/05/2009
*/

/*
	vers�o: 2.7.12 - Corrigido m�todo EnviarEmail do arquivo funcoes.php. Esse m�todo
  fazia include('email.class.php') e isso gerava erro ao tentar redeclarar classe email quando
  tentava-se publicar v�rios objetos de uma s� vez quando a notifica��o de aviso de publica��o estava true.
  Foi substituido o " include('email.class.php');" por " include_once('email.class.php');" na linha 270.
					
		            alterado o funcoes.php nas linha 270
		            Danilo Lisboa 21/05/2009
*/

/*
	vers�o: 2.7.13 - Corrigida fun��o showRSS no arquivo rss.class.php
				Inserido tags CDATA em todos os campos da fun��o para escapar caratceres especiais.
					
		            alterado o rss.class.php nas linha 60 a 90
		            Danilo Lisboa 27/05/2009
*/
/* vers�o: 2.7.14 - Inserido nova forma de busca no comando LOCALIZAR
				O comando <@localizar@> agora possui uma nova  tag: ILIKE.
            Segundo di�logo com programador, esta foi a melhor forma para inserir uma busca por palavra "n�o case sensitive",
            mantentendo, portanto, a tag LIKE ativa sem altera��es.
            Foram inseridos meios de bloqueio de tentativa de utilizando das duas TAGs (LIKE / ILIKE) ao mesmo tempo,
            executando somente a tag ILIKE, quando for o caso. O comando foi testado, obtendo �xito.

		            Alterado "adminobjeto.class.php" (408 / 455 a 459)
                  Alterado "parse.class.php" (401 / 375)
		            Daniel von Paraski 21/08/2009
*/
/* vers�o: 2.8.0 - Modificada forma como o comando LINKBLOB trabalha.
            O comando <@linkblob@> agora tem o mesmo efeito do <@downloadblob@>. Isso foi feito
 *          para que n�o seja mais liberada para curiosos ou sistemas de busca (Ex. Google), o link direto para os blobs.
 *          Isso tamb�m favorece o uso da pasta de blobs fora da pasta public_html, ficando assim, protegidos de acesso direto.
 *
 *          Tamb�m foi modificado o arquivo _downloadblob.php para verificar se o arquivo a ser acessado n�o est� sob uma �rea protegida.(Chama a funcao $_page->_adminobjeto->estaSobAreaProtegida())
 *
 *          Em pagina.class.php na funcao IncluirAdmin os includes foram trocados por include_once.
 *
 *          Em adminobjeto.class.php foi criada a funcao estaSobAreaProtegida, que verifica se o arquivo a ser acessado n�o est� sob uma �rea protegida.
 *
 *          Alterado "pagina.class.php" (45 / 46 / 47)
 *          Alterado "parse.class.php" (651)
 *          Alterado "adminobjeto.class.php" (1299)
 *          Alterado "_downloadblob.php" (161 at� 165)
 *          Alterado "_viewblob.php" (31 at� 35)
 *          Alterado "_viewthumb.php" (23 at� 27)
 *
 *          Danilo Lisboa / Diogo Corazolla 04/11/2009
*/
/* vers�o: 2.8.1 - Feita a pagina��o dos objetos apagados.
 *
 *          Alterado "administracao.class.php" (1414 / 1431)
 *          Alterado "recuperar.php" (colocado o codigo necessario para a paginacao)
 *          Alterado "apagar_definitivo.php" (colocado o codigo necessario para a paginacao)
 *
 *          Helca Gonzaga / Danilo Lisboa 10/12/2009
*/
/* vers�o: 2.8.2 - Modificada forma de listagem de objetos apagados (Agora: por data de exclus�o)
 *
 *          Alterado "administracao.class.php" (1414 / 1431) -  ordenacao por data de exclusao
 *          Alterado "recuperar.php" (apresentacao da data de exclusao)
 *          Alterado "apagar_definitivo.php" (apresentacao da data de exclusao)
 *
 *          Helca Gonzaga / Danilo Lisboa 11/12/2009
*/

/* vers�o: 2.8.3 - Desfeita a modificacao da versao 2.8.0
 *
 * 			Os arquivos la citados voltaram a versao anterior
 * 			
 * 			Danilo Lisboa
*/

/* vers�o: 2.8.4 - Incluido o titulo do objeto na URL mantendo a leitura das URL antigas
 *				
 *		    Alterado "objeto.class.php" (linha 43)
 *		    Alterado "iniciar.php" (linha 17) - incluido: "/(\w+)\" e mantido o if original na (linha 23)
 *			Alterado "funcoes.php" - incluido as funcoes "x()", "xd()" uteis para debug e a funcao "limpaString()" responsavel
 *						             por retirar acentos, espa�os, e caracteres especiais de uma string
 *			
 *			
 *			Marcos Rodrigo - 06/04/2010
 */

/* vers�o: 2.8.5 - Incluido a TAG Publicare <@iconesadmin classe=['']@>
 *				
 *		    Alterado "parse.class.php" (linhas 724 a 761)
 *		    Alterado "publicare.conf" adicionado o caminho das imagens dos icones de administra��o
 *			Alterado "funcoes.php" - atualizada a funcao "limpaString()" passou a retirar "." e "_" de uma string
 *			Inclu�do imagens dos icones de administra��o na pastas "/html/imagens/portalimages/":
 *				"/html/imagens/portalimages/ic-inserir.gif"
 *				"/html/imagens/portalimages/ic-editar.gif"
 *				"/html/imagens/portalimages/ic-publicar.gif"
 *				"/html/imagens/portalimages/ic-excluir.gif"
 *			
 *			Marcos Rodrigo - 13/04/2010
 */

/* vers�o: 2.8.6 - Corre��o e melhora do �tem 2.8.4
 *				
 *		    Alterado "iniciar.php" (linha 17) - Corrigida express�o regular para leitura da url com titulo
 *						trocada /(\w+)\ por /(\w.+)\
 *			Alterado "funcoes.php" - atualizada a funcao "limpaString()" passou a retirar ",", "\" e "\"" de uma string.
 *						Agora adiciona "-" onde tiver espa�o, assim facilita a leitura da url
 *			
 *			Diogo Corazolla - 25/07/2010
 */
?>
