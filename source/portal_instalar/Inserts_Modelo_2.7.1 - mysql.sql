INSERT INTO classe (cod_classe,nome,prefixo,descricao,temfilhos,sistema,indexar) VALUES (1,'Diretório','folder','Diretório que contém outros objetos, além de um texto descritivo. Útil para dividir uma seção em categorias. Normalmente é utilizado para novos items de menu.',1,1,1);
INSERT INTO classe (cod_classe,nome,prefixo,descricao,temfilhos,sistema,indexar) VALUES (2,'Interlink','interlink','Link para objetos do portal',1,1,0);
INSERT INTO classe (cod_classe,nome,prefixo,descricao,temfilhos,sistema,indexar) VALUES (3,'Página','document','Documento em HTML.',1,1,1);
INSERT INTO classe (cod_classe,nome,prefixo,descricao,temfilhos,sistema,indexar) VALUES (4,'Imagem','imagem','Ilustração ou foto a ser exibida ou linkada na página (ex: fotos da galeria, ilustrações sobre artigo).',0,1,1);
INSERT INTO classe (cod_classe,nome,prefixo,descricao,temfilhos,sistema,indexar) VALUES (5,'Arquivo','arquivo','Arquivo que será disponibilizado no site para download (ex: documentos do Word, PDF, arquivos compactados,  etc).',0,1,1);
INSERT INTO classe (cod_classe,nome,prefixo,descricao,temfilhos,sistema,indexar) VALUES (6,'Link','link','Link para endereços externos ao portal.',0,1,0);
INSERT INTO classe (cod_classe,nome,prefixo,descricao,temfilhos,sistema,indexar) VALUES (10,'Notícia','noticia','',1,1,1);
INSERT INTO classe (cod_classe,nome,prefixo,descricao,temfilhos,sistema,indexar) VALUES (11,'Portal Data','portaldata','',1,1,1);
INSERT INTO classe (cod_classe,nome,prefixo,descricao,temfilhos,sistema,indexar) VALUES (12,'Portal Data Folder','portaldatafolder','',1,1,1);
INSERT INTO classe (cod_classe,nome,prefixo,descricao,temfilhos,sistema,indexar) VALUES (13,'Agência de Notícias','agenciadenoticias','Área para criação e gerenciamento de notícias.',1,1,1);
INSERT INTO classe (cod_classe,nome,prefixo,descricao,temfilhos,sistema,indexar) VALUES (17,'RSS','rss','Classe usada para criar feeds rss',0,1,0);

-- select setval('seq_classe', max(cod_classe)) from classe;

INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (11,12);
INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (13,10);
INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (10,5);
INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (3,5);
INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (10,6);
INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (10,4);
INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (3,6);
INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (3,3);
INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (3,4);
INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (10,2);
INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (3,2);
INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (1,5);
INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (1,1);
INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (1,4);
INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (1,2);
INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (1,6);
INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (1,3);
INSERT INTO classexfilhos (cod_classe,cod_classe_filho) VALUES (1,17);

INSERT INTO classexobjeto (cod_classe,cod_objeto) VALUES (11,1);

INSERT INTO index_badwords (cod_badwords,word) VALUES (1,'algum');
INSERT INTO index_badwords (cod_badwords,word) VALUES (2,'aquilo');
INSERT INTO index_badwords (cod_badwords,word) VALUES (3,'ate');
INSERT INTO index_badwords (cod_badwords,word) VALUES (4,'com');
INSERT INTO index_badwords (cod_badwords,word) VALUES (5,'contudo');
INSERT INTO index_badwords (cod_badwords,word) VALUES (6,'disso');
INSERT INTO index_badwords (cod_badwords,word) VALUES (7,'entretanto');
INSERT INTO index_badwords (cod_badwords,word) VALUES (8,'essa');
INSERT INTO index_badwords (cod_badwords,word) VALUES (9,'esta');
INSERT INTO index_badwords (cod_badwords,word) VALUES (10,'este');
INSERT INTO index_badwords (cod_badwords,word) VALUES (11,'foi');
INSERT INTO index_badwords (cod_badwords,word) VALUES (12,'fora');
INSERT INTO index_badwords (cod_badwords,word) VALUES (13,'jamais');
INSERT INTO index_badwords (cod_badwords,word) VALUES (14,'nao');
INSERT INTO index_badwords (cod_badwords,word) VALUES (15,'naquela');
INSERT INTO index_badwords (cod_badwords,word) VALUES (16,'naquele');
INSERT INTO index_badwords (cod_badwords,word) VALUES (17,'naquilo');
INSERT INTO index_badwords (cod_badwords,word) VALUES (18,'nas');
INSERT INTO index_badwords (cod_badwords,word) VALUES (19,'nenhum');
INSERT INTO index_badwords (cod_badwords,word) VALUES (20,'nessa');
INSERT INTO index_badwords (cod_badwords,word) VALUES (21,'nesta');
INSERT INTO index_badwords (cod_badwords,word) VALUES (22,'neste');
INSERT INTO index_badwords (cod_badwords,word) VALUES (23,'nisso');
INSERT INTO index_badwords (cod_badwords,word) VALUES (24,'nos');
INSERT INTO index_badwords (cod_badwords,word) VALUES (25,'nunca');
INSERT INTO index_badwords (cod_badwords,word) VALUES (26,'onde');
INSERT INTO index_badwords (cod_badwords,word) VALUES (27,'para');
INSERT INTO index_badwords (cod_badwords,word) VALUES (28,'pela');
INSERT INTO index_badwords (cod_badwords,word) VALUES (29,'por');
INSERT INTO index_badwords (cod_badwords,word) VALUES (30,'porque');
INSERT INTO index_badwords (cod_badwords,word) VALUES (31,'qual');
INSERT INTO index_badwords (cod_badwords,word) VALUES (32,'quando');
INSERT INTO index_badwords (cod_badwords,word) VALUES (33,'que');
INSERT INTO index_badwords (cod_badwords,word) VALUES (34,'quem');
INSERT INTO index_badwords (cod_badwords,word) VALUES (35,'sem');
INSERT INTO index_badwords (cod_badwords,word) VALUES (36,'sempre');
INSERT INTO index_badwords (cod_badwords,word) VALUES (37,'ser');
INSERT INTO index_badwords (cod_badwords,word) VALUES (38,'sido');
INSERT INTO index_badwords (cod_badwords,word) VALUES (39,'sim');
INSERT INTO index_badwords (cod_badwords,word) VALUES (40,'talvez');
INSERT INTO index_badwords (cod_badwords,word) VALUES (41,'ter');
INSERT INTO index_badwords (cod_badwords,word) VALUES (42,'tido');
INSERT INTO index_badwords (cod_badwords,word) VALUES (43,'uma');
INSERT INTO index_badwords (cod_badwords,word) VALUES (44,'ver');
INSERT INTO index_badwords (cod_badwords,word) VALUES (45,'vos');

-- select setval('seq_index_badwords', max(cod_badwords)) from index_badwords;

INSERT INTO `infoperfil` (`cod_infoperfil`, `cod_perfil`, `acao`, `script`, `donooupublicado`, `sopublicado`, `sodono`, `naomenu`, `ordem`) VALUES (1, 2, 'Editar este objeto', '/manage/edit.*', 0, 0, 0, 0, 2),
(2, 6, 'Visualizar Objeto', '/content/view.*', 0, 1, 0, 1, 16),
(3, 6, 'Login', '/login/index', 0, 0, 0, 0, 100),
(4, 1, 'Editar este objeto', '/manage/edit.*', 0, 0, 0, 0, 2),
(5, 1, 'Criar novo objeto', '/manage/new.*', 0, 0, 0, 0, 1),
(6, 1, 'Apagar este objeto', '/do/delete', 0, 0, 0, 0, 7),
(7, 1, 'Listar Conte&uacute;do', '/do/list_content', 0, 0, 0, 0, 4),
(8, 2, 'Listar Conte&uacute;do', '/do/list_content', 0, 0, 0, 0, 4),
(9, 1, 'Gerenciar Portal', '/do/indexportal', 0, 0, 0, 0, 10),
(10, 1, 'Restaurar apagados', '/do/recuperar', 0, 0, 0, 0, 8),
(11, 2, 'Restaurar apagados', '/do/recuperar', 0, 0, 0, 0, 8),
(12, 1, 'Apagar objetos em definitivo', '/do/apagar_definitivo', 0, 0, 0, 0, 12),
(13, 2, 'Criar novo objeto', '/manage/new.*', 0, 0, 0, 0, 1),
(14, 3, 'Visualizar Objeto', '/content/view.*', 0, 0, 0, 0, 16),
(15, 6, 'Logout', '/security/logout', 0, 0, 0, 0, 17),
(16, 1, 'Publicar objeto', '/do/publicar', 0, 0, 0, 0, 5),
(17, 2, 'Publicar objeto', '/do/publicar', 0, 0, 0, 0, 5),
(18, 1, 'Rejeitar publica&ccedil;&atilde;o', '/do/rejeitar', 0, 0, 0, 0, 6),
(19, 2, 'Rejeitar publica&ccedil;&atilde;o', '/do/rejeitar', 0, 0, 0, 0, 6),
(20, 3, 'Criar novo objeto', '/manage/new.*', 0, 0, 0, 0, 1),
(21, 3, 'Editar este objeto', '/manage/edit.*', 1, 0, 0, 0, 2),
(22, 2, 'Novo (interno)', '/do/new.*', 0, 0, 0, 1, 100),
(24, 3, 'Novo (interno)', '/do/new.*', 0, 0, 0, 1, 100),
(26, 3, 'Apagar este objeto', '/do/delete', 0, 0, 1, 0, 7),
(27, 3, 'Solicitar publica&ccedil;&atilde;o', '/do/submeter.*', 0, 0, 1, 0, 5),
(28, 2, 'Visualizar Objeto', '/content/view.*', 0, 0, 0, 0, 16),
(29, 1, 'Objetos pendentes', '/do/pendentes', 0, 0, 0, 0, 3),
(30, 2, 'Objetos pendentes', '/do/pendentes', 0, 0, 0, 0, 3),
(31, 3, 'Ver objetos rejeitados', '/do/rejeitados', 0, 0, 0, 0, 6),
(32, 2, 'Posts Internos', '/do/.*post', 0, 0, 0, 1, 100),
(34, 1, 'Ger. Usu&aacute;rios (interno)', '/do/gerusuario.*', 0, 0, 0, 1, 100),
(35, 1, 'Ger.  Classes (interno)', '/do/classes', 0, 0, 0, 1, 100),
(36, 1, 'Ger.  Skins (interno)', '/do/peles', 0, 0, 0, 1, 100),
(38, 1, '&Iacute;ndice do Objeto', '/do/preview.*', 0, 0, 0, 0, 15),
(39, 2, '&Iacute;ndice do Objeto', '/do/preview.*', 0, 0, 0, 0, 15),
(40, 3, '&Iacute;ndice do Objeto', '/do/preview.*', 0, 0, 0, 0, 15),
(41, 1, 'Visualizar Objeto', '/content/view.*', 0, 0, 0, 0, 16),
(42, 3, 'Adm. de Objetos', NULL, 0, 0, 0, 0, 0),
(43, 6, 'Adm. do Portal', NULL, 0, 0, 0, 0, 9),
(44, 6, 'Menu de Navega&ccedil;&atilde;o', NULL, 0, 0, 0, 0, 14),
(45, 3, 'Listar Conte&uacute;do', '/do/list_content', 0, 0, 0, 0, 4),
(46, 4, '&Iacute;ndice do Objeto', '/do/preview.*', 0, 0, 0, 0, 15),
(48, 1, 'Adm. de Objetos', NULL, 0, 0, 0, 0, 0),
(49, 2, 'Adm. de Objetos', NULL, 0, 0, 0, 0, 0),
(50, 4, 'Visualizar Objeto', '/content/view.*', 0, 0, 0, 0, 16),
(51, 2, 'Apagar este Objeto', '/do/delete', 0, 0, 0, 0, 7),
(53, 1, 'Post Internos', '/do/.*post', 0, 0, 0, 1, 100),
(54, 3, 'Post Internos', '/do/.*post', 0, 0, 0, 1, 100),
(55, 6, 'Resultado de Pesquisa', '/html/objects/search_result', 0, 0, 0, 1, 100),
(56, 2, 'Dados Pessoais', '/do/gerdadospessoais', 0, 0, 0, 0, 11),
(57, 3, 'Dados Pessoais', '/do/gerdadospessoais', 0, 0, 0, 0, 11),
(58, 4, 'Dados Pessoais', '/do/gerdadospessoais', 0, 0, 0, 0, 11),
(59, 2, 'Ajuda Publicare', '/do/ajuda', 0, 0, 0, 0, 13),
(60, 3, 'Ajuda Publicare', '/do/ajuda', 0, 0, 0, 0, 13),
(61, 4, 'Ajuda Publicare', '/do/ajuda', 0, 0, 0, 0, 13),
(62, 1, 'Ajuda Publicare', '/do/ajuda', 0, 0, 0, 0, 13),
(63, 1, 'Objetos vencidos', '/do/vencidos', 0, 0, 0, 0, 3),
(64, 2, 'Objetos vencidos', '/do/vencidos', 0, 0, 0, 0, 3),
(65, 1, 'Log de Acesso', '/do/logacesso', 0, 0, 0, 0, 13),
(66, 2, 'Log de Acesso', '/do/logacesso', 0, 0, 0, 0, 13),
(67, 3, 'Log de Acesso', '/do/logacesso', 0, 0, 0, 0, 13),
(68, 4, 'Log de Acesso', '/do/logacesso', 0, 0, 0, 0, 13),
(69, 6, 'Dados Pessoais', '/do/gerdadospessoais', 1, 1, 0, 0, 11),
(71, 5, 'Dados Pessoais', '/do/gerdadospessoais', 1, 1, 0, 0, 11),
(72, 5, 'Visualizar Objeto', '/content/view.*', 0, 1, 0, 0, 16);

INSERT INTO objeto (cod_objeto,cod_pai,cod_classe,cod_usuario,cod_pele,cod_status,titulo,descricao,data_publicacao,data_validade,script_exibir,apagado,objetosistema,peso) VALUES (1,-1,1,1,0,2,'Página Inicial','Página principal',19811212000000,20361212000000,'/html/template/view_home.pbl',0,1,1);

-- select setval('seq_objeto', max(cod_objeto)) from objeto;

INSERT INTO `perfil` (`cod_perfil`, `nome`) VALUES (1, 'Administrador'),
(2, 'Editor'),
(3, 'Autor'),
(4, 'Restrito'),
(5, 'Militarizado'),
(6, '_Default');

INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (1,3,8,0,'0','texto',5,'Campo de texto da classe Documento','Texto','Sim','Não',0,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (2,1,8,0,'0','texto',2,'','Texto','Sim','Não',0,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (3,4,1,0,'0','conteudo',0,'Arquivo de imagem para upload. Localiza na máquina local.','Imagem','Sim','Não',1,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (4,5,1,0,'0','conteudo',0,'Arquivo a disponibilizar para upload.','Arquivo','Sim','Não',0,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (5,4,7,0,'0','credito',1,'Nome do autor da imagem','Crédito','Sim','Não',0,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (6,6,7,0,'0','descricao',2,'Descrição do link','Descrição','Sim','Não',0,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (7,4,7,0,'0','legenda',2,'Legenda da imagem','Legenda','Sim','Não',0,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (8,10,8,0,'','texto',2,'Texto da Notícia','Texto','Sim','Não',0,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (9,10,2,0,'','destaque',7,'Definir se a notícia em causa é destaque ou não','Destacar?(S/N)','Sim','Não',0,3,'0');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (10,10,7,0,'','subtitulo',0,'Subtitulo da Notícia','Sub-Titulo','Sim','Não',0,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (11,10,7,0,'','veiculo',4,'Veiculo onde a notícia foi vinculada','Veiculo','Sim','Não',0,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (12,10,7,0,'','autor',5,'Autor da notícia','Autor','Sim','Não',0,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (13,10,7,0,'','link',6,'Link para notícia original','Link para notícia original','Sim','Não',0,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (14,1,2,0,'','menu_proprio',1,'Checa se este folder é inicio de seção e contém menu próprio ou se pega o menu do pai','Tem Menu Próprio?','Sim','Não',0,2,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (15,2,4,0,'','endereco',1,'Número do Objeto','Código do Objeto','Sim','Não',1,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (16,10,8,0,'','resumo',1,'Resumo da noticia','Resumo','Sim','Não',0,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (17,3,8,0,'','resumo',1,'Resumo do Documento','Resumo','Sim','Não',0,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (18,6,7,0,'','endereco',1,'Endereço da URL a linkar neste objeto','Endereço Completo','Sim','Não',1,3,'http://');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (19,5,8,0,'','resumo',1,'Resumo do Arquivo','Resumo','','',0,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (20,2,7,0,'','ancora',2,'','Linkar com ancora','','',0,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (21,17,8,0,'','resumo',1,'Resumo do RSS','Resumo','','',0,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (22,17,8,0,'','texto',2,'Texto do RSS','Texto','','',0,3,'');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (23,17,2,0,'','destaque_home',3,'','Destacar na primeira página?','Sim','Não',0,3,'0');
INSERT INTO propriedade (cod_propriedade,cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao,descricao,rotulo,rot1booleano,rot2booleano,obrigatorio,seguranca,valorpadrao) VALUES (24,17,4,0,'','limite',4,'','Número de artigos a listar','','',0,3,'');

-- select setval('seq_propriedade', max(cod_propriedade)) from propriedade;

INSERT INTO status (cod_status,nome) VALUES (1,'Privado');
INSERT INTO status (cod_status,nome) VALUES (2,'Publicado');
INSERT INTO status (cod_status,nome) VALUES (3,'Rejeitado');
INSERT INTO status (cod_status,nome) VALUES (4,'Submetido');

INSERT INTO tipodado (cod_tipodado,nome,tabela,delimitador) VALUES (1,'Blob','tbl_blob','''');
INSERT INTO tipodado (cod_tipodado,nome,tabela,delimitador) VALUES (2,'Booleano','tbl_boolean',NULL);
INSERT INTO tipodado (cod_tipodado,nome,tabela,delimitador) VALUES (3,'Data','tbl_date','''');
INSERT INTO tipodado (cod_tipodado,nome,tabela,delimitador) VALUES (4,'Número','tbl_integer',NULL);
INSERT INTO tipodado (cod_tipodado,nome,tabela,delimitador) VALUES (5,'Número Preciso','tbl_float',NULL);
INSERT INTO tipodado (cod_tipodado,nome,tabela,delimitador) VALUES (6,'Ref. Objeto','tbl_objref',NULL);
INSERT INTO tipodado (cod_tipodado,nome,tabela,delimitador) VALUES (7,'String','tbl_string','''');
INSERT INTO tipodado (cod_tipodado,nome,tabela,delimitador) VALUES (8,'Texto Avanc.','tbl_text','''');

INSERT INTO usuario (cod_usuario,secao,nome,login,email,ramal,senha,chefia,valido,data_atualizacao) VALUES (1,NULL,'Root','root','root@root.com',NULL,'63a9f0ea7bb98050796b649e85481845',NULL,1,20100101);

-- select setval('seq_usuario', max(cod_usuario)) from usuario;

INSERT INTO usuarioxobjetoxperfil (cod_usuario,cod_objeto,cod_perfil) VALUES (0,1,6);
INSERT INTO usuarioxobjetoxperfil (cod_usuario,cod_objeto,cod_perfil) VALUES (1,1,1);