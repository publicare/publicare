<?php

define ('_VERSIONPROG','Publicare 2.8.8 - 09/12/2011');



/*
	versao: 2.8.8 - Corrigido bug ao criar tabela temporaria. Não estava criando as colunas corretamente. Erro no switch.
					- dblayer_adodb.class.php - linhas 277 - 303
					Adicionado o tipo Texto Avançado para buscas que utilizam tabela temporária
					- dblayer_adodb.class.php - linhas 103, 114, 124, 301-304
					Adicionada a palavra ILIKE para ser aceita na condição do publicare
					- adminobjeto.class.php - linha 357
					* Diogo Corazolla 23/11/2011
					
					Adicionado tipo de coluna Obj. ref para tabela temporária, utilizando mesmo tipo de dado de string.
					-  dblayer_adodb.class.php - linhas 292
					* Diogo Corazolla 25/11/2011
					
					Alterado publicare para utilizaçãod e tabelas temporárias, em vez de tabelas fisicas. Desta forma a busca fica mais rápida.
					* Diogo Corazolla 02/11/2011
					
					Corrigido Problema ao apagar classe, não estava apagando os relacionamentos, classexfilhos e classexobjeto.
					- administracao.class.php - ApagarClasse() - linhas: 2674 - 2686
					Retirada a tabela tempcontrole do publicare. Tabela não é mais necessária. Apagada do banco e removida do dblayer.
					- dblayer_adodb.class.php - linha 57
					
					* Diogo Corazolla 09/12/2011

	versao: 2.8.7 - Corrigido bug ao excluir propriedade de uma classe
					- administracao.class.php - linhas 2540 - 2544
					
					Alterada funcao limpaString() para nao dar mais problema de enconding
					- funcoes.php - linhas 313 - 339
					
					Adicionada segurança no _download_blob.php -> Verifica se está sob onjeto protegido e não permite download
					Adicionados mime types ao arquivo (flv, ogx, ogg, oga, ogv, spx, flac, anx, axa, axv, xspf)
					- portal_instalar/html/objects/_download_blob.php
					
					Pastas upd_blob e upd_thumb retiradas da public_html
					- portal_instalar/html/objects/_viewblob.php - adicionada visualização de ícones de classes
					- manage/classes.php - adicionada chamada para _viewblob.php e corrigida logica do icone
					- manage/classe_post.php - corrigido local de gravação do ícone da classe
					- parse.class.php - alterada funcao iconeclasse para exibir corretamente o icone e alterada chamada linkblob para executar downloadblob
					
					Corrigido arquivo header_publicare.php - linhas 13 a 17
					- Novo php trata de forma diferente a global $_SERVER["PHP_SELF"]
					
					Corrigido arquivo administracao.class.php - linha 1423
					- Alterado formato da data para gravacao na coluna data_exclusao da tabela objeto
					
					Corrigido problema de charset para utilização do postgres
					- Adicionada sentença  SET CLIENT_ENCODING TO 'LATIN1' no dblayer, quando for utilizado pgsql
					
					* Diogo Corazolla - 21/06/2011


	versão: 2.8.6 - Removida a verificação por cod_perfil em Administracao->SubmeterObjeto na linha 854
					- Alterado "administracao.class.php" (linha 854)
					* Danilo Lisboa - 19/07/2010


	versão: 2.8.5 - Incluido a TAG Publicare <@iconesadmin classe=['']@>
					- Alterado "parse.class.php" (linhas 724 a 761)
					- Alterado "publicare.conf" adicionado o caminho das imagens dos icones de administração
					- Alterado "funcoes.php" - atualizada a funcao "limpaString()" passou a retirar "." e "_" de uma string
					- Incluído imagens dos icones de administração na pastas "/html/imagens/portalimages/":
						"/html/imagens/portalimages/ic-inserir.gif"
						"/html/imagens/portalimages/ic-editar.gif"
						"/html/imagens/portalimages/ic-publicar.gif"
						"/html/imagens/portalimages/ic-excluir.gif"
					* Marcos Rodrigo - 13/04/2010


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

/* versão: 2.7.14 - Inserido nova forma de busca no comando LOCALIZAR

				O comando <@localizar@> agora possui uma nova  tag: ILIKE.

            Segundo diálogo com programador, esta foi a melhor forma para inserir uma busca por palavra "não case sensitive",

            mantentendo, portanto, a tag LIKE ativa sem alterações.

            Foram inseridos meios de bloqueio de tentativa de utilizando das duas TAGs (LIKE / ILIKE) ao mesmo tempo,

            executando somente a tag ILIKE, quando for o caso. O comando foi testado, obtendo êxito.



		            Alterado "adminobjeto.class.php" (408 / 455 a 459)

                  Alterado "parse.class.php" (401 / 375)

		            Daniel von Paraski 21/08/2009

*/

/* versão: 2.8.0 - Modificada forma como o comando LINKBLOB trabalha.

            O comando <@linkblob@> agora tem o mesmo efeito do <@downloadblob@>. Isso foi feito

 *          para que não seja mais liberada para curiosos ou sistemas de busca (Ex. Google), o link direto para os blobs.

 *          Isso também favorece o uso da pasta de blobs fora da pasta public_html, ficando assim, protegidos de acesso direto.

 *

 *          Também foi modificado o arquivo _downloadblob.php para verificar se o arquivo a ser acessado não está sob uma área protegida.(Chama a funcao $_page->_adminobjeto->estaSobAreaProtegida())

 *

 *          Em pagina.class.php na funcao IncluirAdmin os includes foram trocados por include_once.

 *

 *          Em adminobjeto.class.php foi criada a funcao estaSobAreaProtegida, que verifica se o arquivo a ser acessado não está sob uma área protegida.

 *

 *          Alterado "pagina.class.php" (45 / 46 / 47)

 *          Alterado "parse.class.php" (651)

 *          Alterado "adminobjeto.class.php" (1299)

 *          Alterado "_downloadblob.php" (161 até 165)

 *          Alterado "_viewblob.php" (31 até 35)

 *          Alterado "_viewthumb.php" (23 até 27)

 *

 *          Danilo Lisboa / Diogo Corazolla 04/11/2009

*/

/* versão: 2.8.1 - Feita a paginação dos objetos apagados.

 *

 *          Alterado "administracao.class.php" (1414 / 1431)

 *          Alterado "recuperar.php" (colocado o codigo necessario para a paginacao)

 *          Alterado "apagar_definitivo.php" (colocado o codigo necessario para a paginacao)

 *

 *          Helca Gonzaga / Danilo Lisboa 10/12/2009

*/

/* versão: 2.8.2 - Modificada forma de listagem de objetos apagados (Agora: por data de exclusão)

 *

 *          Alterado "administracao.class.php" (1414 / 1431) -  ordenacao por data de exclusao

 *          Alterado "recuperar.php" (apresentacao da data de exclusao)

 *          Alterado "apagar_definitivo.php" (apresentacao da data de exclusao)

 *

 *          Helca Gonzaga / Danilo Lisboa 11/12/2009

*/



/* versão: 2.8.3 - Desfeita a modificacao da versao 2.8.0

 *

 * 			Os arquivos la citados voltaram a versao anterior

 * 			

 * 			Danilo Lisboa

*/



/* versão: 2.8.4 - Incluido o titulo do objeto na URL mantendo a leitura das URL antigas

 *				

 *		    Alterado "objeto.class.php" (linha 43)

 *		    Alterado "iniciar.php" (linha 17) - incluido: "/(\w+)\" e mantido o if original na (linha 23)

 *			Alterado "funcoes.php" - incluido as funcoes "x()", "xd()" uteis para debug e a funcao "limpaString()" responsavel

 *						             por retirar acentos, espaços, e caracteres especiais de uma string

 *			

 *			

 *			Marcos Rodrigo - 06/04/2010

 */



/* 

 */



/* 

 */

