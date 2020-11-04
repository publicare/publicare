-- phpMyAdmin SQL Dump
-- version 2.10.0.2
-- http://www.phpmyadmin.net
-- Servidor: mysql1072.servage.net
-- Tempo de Geração: Set 26, 2008 as 12:26 AM
-- Versão do Servidor: 5.0.67
-- Versão do PHP: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Banco de Dados: `dbs_nome`
-- 

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `classe`
-- 

CREATE TABLE `classe` (
  `cod_classe` int(11) NOT NULL auto_increment,
  `nome` varchar(50) default NULL,
  `prefixo` varchar(50) default NULL,
  `descricao` varchar(255) NOT NULL default '',
  `temfilhos` tinyint(1) NOT NULL default '0',
  `sistema` tinyint(1) NOT NULL default '0',
  `indexar` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`cod_classe`),
  KEY `nome` (`nome`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `classexfilhos`
-- 

CREATE TABLE `classexfilhos` (
  `cod_classe` int(11) NOT NULL default '0',
  `cod_classe_filho` int(11) NOT NULL default '0',
  KEY `cod_classe` (`cod_classe`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `classexobjeto`
-- 

CREATE TABLE `classexobjeto` (
  `cod_classe` int(11) NOT NULL default '0',
  `cod_objeto` int(11) NOT NULL default '0',
  PRIMARY KEY  (`cod_classe`,`cod_objeto`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `comentarios`
-- 

CREATE TABLE `comentarios` (
  `cod_comentario` int(11) NOT NULL auto_increment,
  `cod_objeto` int(11) NOT NULL default '0',
  `nome` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `texto` text,
  `aprovado` tinyint(1) default NULL,
  PRIMARY KEY  (`cod_comentario`),
  KEY `cod_objeto` (`cod_objeto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `errorTable`
-- 

CREATE TABLE `errorTable` (
  `cod_errortable` int(11) NOT NULL auto_increment,
  `sql` text NOT NULL,
  `error` varchar(255) NOT NULL default '',
  `script` varchar(255) NOT NULL default '',
  `stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`cod_errortable`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `index_badwords`
-- 

CREATE TABLE `index_badwords` (
  `cod_badwords` int(11) NOT NULL auto_increment,
  `word` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`cod_badwords`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `index_objectxword`
-- 

CREATE TABLE `index_objectxword` (
  `cod_objeto` int(10) unsigned NOT NULL default '0',
  `cod_index_word` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cod_objeto`,`cod_index_word`),
  KEY `cod_index_word` (`cod_index_word`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `index_word`
-- 

CREATE TABLE `index_word` (
  `cod_index_word` int(11) NOT NULL auto_increment,
  `word` char(50) default NULL,
  PRIMARY KEY  (`cod_index_word`),
  KEY `word` (`word`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `infoperfil`
-- 

CREATE TABLE `infoperfil` (
  `cod_infoperfil` int(11) NOT NULL auto_increment,
  `cod_perfil` int(11) NOT NULL default '0',
  `acao` varchar(200) default NULL,
  `script` varchar(200) default NULL,
  `donooupublicado` tinyint(1) default '0',
  `sopublicado` tinyint(1) default '0',
  `sodono` tinyint(1) default '0',
  `naomenu` tinyint(1) default '0',
  `ordem` tinyint(1) default '0',
  PRIMARY KEY  (`cod_infoperfil`),
  KEY `cod_perfil` (`cod_perfil`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `logobjeto`
-- 

CREATE TABLE `logobjeto` (
  `cod_objeto` int(11) NOT NULL default '0',
  `estampa` bigint(14) default NULL,
  `cod_usuario` int(1) NOT NULL default '0',
  `cod_operacao` tinyint(1) default NULL,
  KEY `cod_objeto` (`cod_objeto`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `logrobo`
-- 

CREATE TABLE `logrobo` (
  `cod_robo` int(11) NOT NULL default '0',
  `cod_objeto` int(11) NOT NULL default '0',
  `estampa` int(11) NOT NULL default '0',
  KEY `cod_objeto` (`cod_objeto`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `logworkflow`
-- 

CREATE TABLE `logworkflow` (
  `cod_objeto` int(11) default NULL,
  `cod_usuario` int(11) default NULL,
  `mensagem` text,
  `cod_status` int(11) default NULL,
  `estampa` bigint(14) default NULL,
  KEY `cod_objeto` (`cod_objeto`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `objeto`
-- 

CREATE TABLE `objeto` (
  `cod_objeto` int(11) NOT NULL auto_increment,
  `cod_pai` int(11) default NULL,
  `cod_classe` int(11) default NULL,
  `cod_usuario` int(11) default NULL,
  `cod_pele` int(11) default NULL,
  `cod_status` int(11) default NULL,
  `titulo` varchar(255) default NULL,
  `descricao` text,
  `data_publicacao` bigint(14) default NULL,
  `data_exclusao` bigint( 14 ) default NULL,
  `data_validade` bigint(14) default NULL,
  `script_exibir` varchar(255) default NULL,
  `apagado` tinyint(4) NOT NULL default '0',
  `objetosistema` tinyint(4) NOT NULL default '0',
  `peso` int(11) default '0',
  PRIMARY KEY  (`cod_objeto`),
  KEY `cod_classe` (`cod_classe`),
  KEY `cod_pai` (`cod_pai`),
  KEY `data_publicacao` (`data_publicacao`),
  KEY `data_validade` (`data_validade`),
  KEY `ordem` (`peso`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `parentesco`
-- 

CREATE TABLE `parentesco` (
  `cod_objeto` int(11) NOT NULL default '0',
  `cod_pai` int(11) NOT NULL default '0',
  `ordem` int(11) NOT NULL default '0',
  PRIMARY KEY  (`cod_objeto`,`cod_pai`),
  KEY `cod_pai` (`cod_pai`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `pele`
-- 

CREATE TABLE `pele` (
  `cod_pele` int(11) NOT NULL auto_increment,
  `nome` varchar(50) default NULL,
  `prefixo` varchar(50) default NULL,
  `publica` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`cod_pele`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `pendencia`
-- 

CREATE TABLE `pendencia` (
  `cod_usuario` int(11) NOT NULL default '0',
  `cod_objeto` int(11) NOT NULL default '0',
  PRIMARY KEY  (`cod_usuario`,`cod_objeto`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `perfil`
-- 

CREATE TABLE `perfil` (
  `cod_perfil` int(11) NOT NULL auto_increment,
  `nome` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`cod_perfil`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `pilha`
-- 

CREATE TABLE `pilha` (
  `cod_pilha` int(11) NOT NULL auto_increment,
  `cod_objeto` int(11) default NULL,
  `cod_usuario` int(11) default NULL,
  `cod_tipo` int(11) default NULL,
  `datahora` float default NULL,
  PRIMARY KEY  (`cod_pilha`),
  KEY `cod_usuario` (`cod_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `propriedade`
-- 

CREATE TABLE `propriedade` (
  `cod_propriedade` int(11) NOT NULL auto_increment,
  `cod_classe` int(11) NOT NULL default '0',
  `cod_tipodado` int(11) NOT NULL default '0',
  `cod_referencia_classe` int(11) default NULL,
  `campo_ref` varchar(50) default NULL,
  `nome` varchar(50) default NULL,
  `posicao` tinyint(4) default '0',
  `descricao` varchar(255) default NULL,
  `rotulo` varchar(50) default NULL,
  `rot1booleano` varchar(50) default NULL,
  `rot2booleano` varchar(50) default NULL,
  `obrigatorio` tinyint(4) default NULL,
  `seguranca` tinyint(4) default NULL,
  `valorpadrao` varchar(200) default NULL,
  PRIMARY KEY  (`cod_propriedade`),
  KEY `cod_classe` (`cod_classe`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `robo`
-- 

CREATE TABLE `robo` (
  `cod_robo` int(11) NOT NULL auto_increment,
  `http_user_agent` varchar(255) default NULL,
  KEY `cod_robo` (`cod_robo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `status`
-- 

CREATE TABLE `status` (
  `cod_status` int(11) NOT NULL auto_increment,
  `nome` varchar(50) default NULL,
  PRIMARY KEY  (`cod_status`),
  KEY `nome` (`nome`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `tag`
-- 

CREATE TABLE `tag` (
  `cod_tag` int(11) NOT NULL auto_increment,
  `nome_tag` varchar(50) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`cod_tag`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `tagxobjeto`
-- 

CREATE TABLE `tagxobjeto` (
  `cod_tag` int(11) default NULL,
  `cod_objeto` int(11) default NULL,
  KEY `cod_tag` (`cod_tag`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `tbl_blob`
-- 

CREATE TABLE `tbl_blob` (
  `cod_blob` int(11) NOT NULL auto_increment,
  `cod_objeto` int(11) default NULL,
  `cod_propriedade` int(11) default NULL,
  `arquivo` varchar(255) default NULL,
  `tamanho` int(11) default NULL,
  PRIMARY KEY  (`cod_blob`),
  KEY `cod_objeto` (`cod_objeto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `tbl_boolean`
-- 

CREATE TABLE `tbl_boolean` (
  `cod_boolean` int(11) NOT NULL auto_increment,
  `cod_objeto` int(11) default NULL,
  `cod_propriedade` int(11) default NULL,
  `valor` tinyint(4) default NULL,
  PRIMARY KEY  (`cod_boolean`),
  KEY `cod_objeto` (`cod_objeto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `tbl_date`
-- 

CREATE TABLE `tbl_date` (
  `cod_date` int(11) NOT NULL auto_increment,
  `cod_objeto` int(11) default NULL,
  `cod_propriedade` int(11) default NULL,
  `valor` bigint(14) default NULL,
  PRIMARY KEY  (`cod_date`),
  KEY `cod_objeto` (`cod_objeto`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `tbl_float`
-- 

CREATE TABLE `tbl_float` (
  `cod_float` int(11) NOT NULL auto_increment,
  `cod_objeto` int(11) default NULL,
  `cod_propriedade` int(11) default NULL,
  `valor` float default NULL,
  PRIMARY KEY  (`cod_float`),
  KEY `cod_objeto` (`cod_objeto`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `tbl_integer`
-- 

CREATE TABLE `tbl_integer` (
  `cod_integer` int(11) NOT NULL auto_increment,
  `cod_objeto` int(11) default NULL,
  `cod_propriedade` int(11) default NULL,
  `valor` int(11) default NULL,
  PRIMARY KEY  (`cod_integer`),
  KEY `cod_objeto` (`cod_objeto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `tbl_objref`
-- 

CREATE TABLE `tbl_objref` (
  `cod_objref` int(11) NOT NULL auto_increment,
  `cod_objeto` int(11) default NULL,
  `cod_propriedade` int(11) default NULL,
  `valor` int(11) default NULL,
  PRIMARY KEY  (`cod_objref`),
  KEY `cod_objeto` (`cod_objeto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `tbl_string`
-- 

CREATE TABLE `tbl_string` (
  `cod_string` int(11) NOT NULL auto_increment,
  `cod_objeto` int(11) default NULL,
  `cod_propriedade` int(11) default NULL,
  `valor` varchar(512) default NULL,
  PRIMARY KEY  (`cod_string`),
  KEY `cod_objeto` (`cod_objeto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `tbl_text`
-- 

CREATE TABLE `tbl_text` (
  `cod_text` int(11) NOT NULL auto_increment,
  `cod_objeto` int(11) default NULL,
  `cod_propriedade` int(11) default NULL,
  `valor` text,
  PRIMARY KEY  (`cod_text`),
  KEY `cod_objeto` (`cod_objeto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `tempControle`
-- 

CREATE TABLE `tempControle` (
  `tabela` varchar(255) NOT NULL default '',
  `data` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`tabela`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



-- 
-- Estrutura da tabela `tipodado`
-- 

CREATE TABLE `tipodado` (
  `cod_tipodado` int(11) NOT NULL auto_increment,
  `nome` char(50) default NULL,
  `tabela` char(50) default NULL,
  `delimitador` char(1) default NULL,
  PRIMARY KEY  (`cod_tipodado`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `unlock_table`
-- 

CREATE TABLE `unlock_table` (
  `cod_unlock` int(11) NOT NULL auto_increment,
  `cod_objeto` int(11) default NULL,
  PRIMARY KEY  (`cod_unlock`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `usuario`
-- 

CREATE TABLE `usuario` (
  `cod_usuario` int(11) NOT NULL auto_increment,
  `secao` varchar(255) default NULL,
  `nome` varchar(255) default NULL,
  `login` varchar(32) default NULL,
  `email` varchar(255) default NULL,
  `ramal` varchar(50) default NULL,
  `senha` varchar(32) default NULL,
  `chefia` int(11) default NULL,
  `valido` tinyint(4) default NULL,
  `data_atualizacao` bigint(14) NOT NULL default '0',
  PRIMARY KEY  (`cod_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `usuarioxobjetoxperfil`
-- 

CREATE TABLE `usuarioxobjetoxperfil` (
  `cod_usuario` int(11) NOT NULL default '0',
  `cod_objeto` int(11) NOT NULL default '0',
  `cod_perfil` int(11) NOT NULL default '0',
  PRIMARY KEY  (`cod_usuario`,`cod_objeto`,`cod_perfil`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ALTER TABLE `objeto` ADD `data_exclusao` BIGINT( 14 ) NULL AFTER `data_publicacao` 
