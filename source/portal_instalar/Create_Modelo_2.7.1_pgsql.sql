--
-- PostgreSQL database dump
--

SET client_encoding = 'LATIN1';
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: dbs_portalmct_; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE dbs_portalmct_ WITH TEMPLATE = template0 ENCODING = 'LATIN1' TABLESPACE = tsp_dbs_portalmct_;


\connect dbs_portalmct_

SET client_encoding = 'LATIN1';
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'Standard public schema';


SET search_path = public, pg_catalog;

--
-- Name: seq_classe; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_classe
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: classe; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE classe (
    cod_classe integer DEFAULT nextval('seq_classe'::regclass) NOT NULL,
    nome character varying(50),
    prefixo character varying(50),
    descricao character varying(255) DEFAULT ''::character varying NOT NULL,
    temfilhos smallint DEFAULT 0 NOT NULL,
    sistema smallint DEFAULT 0 NOT NULL,
    indexar smallint DEFAULT 0 NOT NULL
);


--
-- Name: classexfilhos; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE classexfilhos (
    cod_classe integer DEFAULT 0 NOT NULL,
    cod_classe_filho integer DEFAULT 0 NOT NULL
);


--
-- Name: classexobjeto; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE classexobjeto (
    cod_classe integer DEFAULT 0 NOT NULL,
    cod_objeto integer DEFAULT 0 NOT NULL
);


--
-- Name: seq_comentarios; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_comentarios
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: comentarios; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE comentarios (
    cod_comentario integer DEFAULT nextval('seq_comentarios'::regclass) NOT NULL,
    cod_objeto integer DEFAULT 0 NOT NULL,
    email character varying(255),
    texto text,
    aprovado smallint
);


--
-- Name: seq_errortable; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_errortable
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: errortable; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE errortable (
    cod_errortable integer DEFAULT nextval('seq_errortable'::regclass) NOT NULL,
    sql text NOT NULL,
    error character varying(255) DEFAULT ''::character varying NOT NULL,
    script character varying(255) DEFAULT ''::character varying NOT NULL,
    stamp timestamp without time zone NOT NULL
);


--
-- Name: seq_index_badwords; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_index_badwords
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: index_badwords; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE index_badwords (
    cod_badwords integer DEFAULT nextval('seq_index_badwords'::regclass) NOT NULL,
    word character varying(50) DEFAULT ''::character varying NOT NULL
);


--
-- Name: seq_infoperfil; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_infoperfil
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: infoperfil; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE infoperfil (
    cod_infoperfil integer DEFAULT nextval('seq_infoperfil'::regclass) NOT NULL,
    cod_perfil integer DEFAULT 0 NOT NULL,
    acao character varying(200),
    script character varying(200),
    donooupublicado smallint DEFAULT 0,
    sopublicado smallint DEFAULT 0,
    sodono smallint DEFAULT 0,
    naomenu smallint DEFAULT 0,
    ordem smallint
);


--
-- Name: logobjeto; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE logobjeto (
    cod_objeto integer DEFAULT 0 NOT NULL,
    estampa bigint NOT NULL,
    cod_usuario integer NOT NULL,
    cod_operacao smallint
);


--
-- Name: logrobo; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE logrobo (
    cod_robo integer NOT NULL,
    cod_objeto integer NOT NULL,
    estampa integer NOT NULL
);


--
-- Name: logworkflow; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE logworkflow (
    cod_objeto integer,
    cod_usuario integer,
    mensagem text,
    cod_status integer,
    estampa bigint
);


--
-- Name: seq_objeto; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_objeto
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: objeto; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE objeto (
    cod_objeto integer DEFAULT nextval('seq_objeto'::regclass) NOT NULL,
    cod_pai integer,
    cod_classe integer,
    cod_usuario integer,
    cod_pele integer,
    cod_status integer,
    titulo character varying(255),
    descricao text,
    data_publicacao bigint,
    data_exclusao bigint,
    data_validade bigint,
    script_exibir character varying(255),
    apagado smallint DEFAULT 0 NOT NULL,
    objetosistema smallint DEFAULT 0 NOT NULL,
    peso integer DEFAULT 0
);


--
-- Name: parentesco; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE parentesco (
    cod_objeto integer DEFAULT 0 NOT NULL,
    cod_pai integer DEFAULT 0 NOT NULL,
    ordem integer DEFAULT 0 NOT NULL
);


--
-- Name: seq_pele; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_pele
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: pele; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE pele (
    cod_pele integer DEFAULT nextval('seq_pele'::regclass) NOT NULL,
    nome character varying(50),
    prefixo character varying(50),
    publica integer DEFAULT 0
);


--
-- Name: pendencia; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE pendencia (
    cod_usuario integer DEFAULT 0 NOT NULL,
    cod_objeto integer DEFAULT 0 NOT NULL
);


--
-- Name: seq_perfil; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_perfil
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: perfil; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE perfil (
    cod_perfil integer DEFAULT nextval('seq_perfil'::regclass) NOT NULL,
    nome character varying(50) DEFAULT ''::character varying NOT NULL
);


--
-- Name: seq_pilha; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_pilha
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: pilha; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE pilha (
    cod_pilha integer DEFAULT nextval('seq_pilha'::regclass) NOT NULL,
    cod_objeto integer,
    cod_usuario integer,
    cod_tipo integer,
    datahora double precision
);


--
-- Name: seq_propriedade; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_propriedade
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: propriedade; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE propriedade (
    cod_propriedade integer DEFAULT nextval('seq_propriedade'::regclass) NOT NULL,
    cod_classe integer DEFAULT 0 NOT NULL,
    cod_tipodado integer DEFAULT 0 NOT NULL,
    cod_referencia_classe integer,
    campo_ref character varying(50),
    nome character varying(50),
    posicao smallint DEFAULT 0,
    descricao character varying(255),
    rotulo character varying(50),
    rot1booleano character varying(50),
    rot2booleano character varying(50),
    obrigatorio smallint,
    seguranca smallint,
    valorpadrao character varying(200)
);


--
-- Name: seq_robo; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_robo
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: robo; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE robo (
    cod_robo integer DEFAULT nextval('seq_robo'::regclass) NOT NULL,
    http_user_agent character varying(255)
);


--
-- Name: seq_busca; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_busca
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_cad_basico; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_cad_basico
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_cad_formularios; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_cad_formularios
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_cad_perguntas; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_cad_perguntas
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_cad_set_respostas; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_cad_set_respostas
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_enquete_perguntas; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_enquete_perguntas
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_enquete_respostas; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_enquete_respostas
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_filiados; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_filiados
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_filiados_admin; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_filiados_admin
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_filiados_dependentes; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_filiados_dependentes
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_index_word; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_index_word
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_mailing; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_mailing
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_orgaos; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_orgaos
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_status; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_status
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_tag; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE seq_tag
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_tbl_blob; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_tbl_blob
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_tbl_boolean; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_tbl_boolean
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_tbl_date; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_tbl_date
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_tbl_float; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_tbl_float
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_tbl_integer; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_tbl_integer
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_tbl_objref; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_tbl_objref
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_tbl_string; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_tbl_string
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_tbl_text; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_tbl_text
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_tipodado; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_tipodado
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_unlock_table; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_unlock_table
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: seq_usuario; Type: SEQUENCE; Schema: public; Owner: frodrigues
--

CREATE SEQUENCE seq_usuario
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: status; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE status (
    cod_status integer DEFAULT nextval('seq_status'::regclass) NOT NULL,
    nome character varying(50)
);


--
-- Name: tag; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE tag (
    cod_tag integer DEFAULT nextval('seq_tag'::regclass) NOT NULL,
    nome_tag character varying(50)
);


--
-- Name: tagxobjeto; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE tagxobjeto (
    cod_tag integer,
    cod_objeto integer
);


--
-- Name: tbl_blob; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE tbl_blob (
    cod_blob integer DEFAULT nextval('seq_tbl_blob'::regclass) NOT NULL,
    cod_objeto integer,
    cod_propriedade integer,
    arquivo character varying(255),
    tamanho integer
);


--
-- Name: tbl_boolean; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE tbl_boolean (
    cod_boolean integer DEFAULT nextval('seq_tbl_boolean'::regclass) NOT NULL,
    cod_objeto integer,
    cod_propriedade integer,
    valor smallint
);


--
-- Name: tbl_date; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE tbl_date (
    cod_date integer DEFAULT nextval('seq_tbl_date'::regclass) NOT NULL,
    cod_objeto integer,
    cod_propriedade integer,
    valor bigint
);


--
-- Name: tbl_float; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE tbl_float (
    cod_float integer DEFAULT nextval('seq_tbl_float'::regclass) NOT NULL,
    cod_objeto integer,
    cod_propriedade integer,
    valor double precision
);


--
-- Name: tbl_integer; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE tbl_integer (
    cod_integer integer DEFAULT nextval('seq_tbl_integer'::regclass) NOT NULL,
    cod_objeto integer,
    cod_propriedade integer,
    valor integer
);


--
-- Name: tbl_objref; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE tbl_objref (
    cod_objref integer DEFAULT nextval('seq_tbl_objref'::regclass) NOT NULL,
    cod_objeto integer,
    cod_propriedade integer,
    valor integer
);


--
-- Name: tbl_string; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE tbl_string (
    cod_string integer DEFAULT nextval('seq_tbl_string'::regclass) NOT NULL,
    cod_objeto integer,
    cod_propriedade integer,
    valor character varying(1000)
);


--
-- Name: tbl_text; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE tbl_text (
    cod_text integer DEFAULT nextval('seq_tbl_text'::regclass) NOT NULL,
    cod_objeto integer,
    cod_propriedade integer,
    valor text
);


--
-- Name: temp_1611212674963; Type: TABLE; Schema: public; Owner: usdesenv; Tablespace: 
--

CREATE TABLE temp_1611212674963 (
    cod_objeto integer NOT NULL,
    cod_pai integer,
    cod_classe integer,
    classe character varying(255),
    temfilhos integer,
    prefixoclasse character varying(255),
    cod_usuario integer,
    cod_pele integer,
    pele character varying(255),
    prefixopele character varying(255),
    cod_status integer,
    status character varying(255),
    titulo character varying(255),
    descricao character varying(255),
    data_publicacao bigint,
    data_validade bigint,
    script_exibir character varying(255),
    apagado smallint,
    objetosistema smallint,
    peso integer
);


--
-- Name: temp_171212674978; Type: TABLE; Schema: public; Owner: usdesenv; Tablespace: 
--

CREATE TABLE temp_171212674978 (
    cod_objeto integer NOT NULL,
    cod_pai integer,
    cod_classe integer,
    classe character varying(255),
    temfilhos integer,
    prefixoclasse character varying(255),
    cod_usuario integer,
    cod_pele integer,
    pele character varying(255),
    prefixopele character varying(255),
    cod_status integer,
    status character varying(255),
    titulo character varying(255),
    descricao character varying(255),
    data_publicacao bigint,
    data_validade bigint,
    script_exibir character varying(255),
    apagado smallint,
    objetosistema smallint,
    peso integer
);


--
-- Name: temp_221212674793; Type: TABLE; Schema: public; Owner: usdesenv; Tablespace: 
--

CREATE TABLE temp_221212674793 (
    cod_objeto integer NOT NULL,
    cod_pai integer,
    cod_classe integer,
    classe character varying(255),
    temfilhos integer,
    prefixoclasse character varying(255),
    cod_usuario integer,
    cod_pele integer,
    pele character varying(255),
    prefixopele character varying(255),
    cod_status integer,
    status character varying(255),
    titulo character varying(255),
    descricao character varying(255),
    data_publicacao bigint,
    data_validade bigint,
    script_exibir character varying(255),
    apagado smallint,
    objetosistema smallint,
    peso integer,
    texto bigint
);


--
-- Name: temp_2811212674977; Type: TABLE; Schema: public; Owner: usdesenv; Tablespace: 
--

CREATE TABLE temp_2811212674977 (
    cod_objeto integer NOT NULL,
    cod_pai integer,
    cod_classe integer,
    classe character varying(255),
    temfilhos integer,
    prefixoclasse character varying(255),
    cod_usuario integer,
    cod_pele integer,
    pele character varying(255),
    prefixopele character varying(255),
    cod_status integer,
    status character varying(255),
    titulo character varying(255),
    descricao character varying(255),
    data_publicacao bigint,
    data_validade bigint,
    script_exibir character varying(255),
    apagado smallint,
    objetosistema smallint,
    peso integer
);


--
-- Name: temp_471212674963; Type: TABLE; Schema: public; Owner: usdesenv; Tablespace: 
--

CREATE TABLE temp_471212674963 (
    cod_objeto integer NOT NULL,
    cod_pai integer,
    cod_classe integer,
    classe character varying(255),
    temfilhos integer,
    prefixoclasse character varying(255),
    cod_usuario integer,
    cod_pele integer,
    pele character varying(255),
    prefixopele character varying(255),
    cod_status integer,
    status character varying(255),
    titulo character varying(255),
    descricao character varying(255),
    data_publicacao bigint,
    data_validade bigint,
    script_exibir character varying(255),
    apagado smallint,
    objetosistema smallint,
    peso integer
);


--
-- Name: temp_901212674792; Type: TABLE; Schema: public; Owner: usdesenv; Tablespace: 
--

CREATE TABLE temp_901212674792 (
    cod_objeto integer NOT NULL,
    cod_pai integer,
    cod_classe integer,
    classe character varying(255),
    temfilhos integer,
    prefixoclasse character varying(255),
    cod_usuario integer,
    cod_pele integer,
    pele character varying(255),
    prefixopele character varying(255),
    cod_status integer,
    status character varying(255),
    titulo character varying(255),
    descricao character varying(255),
    data_publicacao bigint,
    data_validade bigint,
    script_exibir character varying(255),
    apagado smallint,
    objetosistema smallint,
    peso integer,
    texto bigint
);


--
-- Name: tempcontrole; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE tempcontrole (
    tabela character varying(255) DEFAULT ''::character varying NOT NULL,
    data timestamp without time zone NOT NULL
);


--
-- Name: tipodado; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE tipodado (
    cod_tipodado integer DEFAULT nextval('seq_tipodado'::regclass) NOT NULL,
    nome character varying(50),
    tabela character varying(50),
    delimitador character varying(1)
);


--
-- Name: unlock_table; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE unlock_table (
    cod_unlock integer DEFAULT nextval('seq_unlock_table'::regclass) NOT NULL,
    cod_objeto integer
);


--
-- Name: usuario; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE usuario (
    cod_usuario integer DEFAULT nextval('seq_usuario'::regclass) NOT NULL,
    secao character varying(255),
    nome character varying(255),
    "login" character varying(32),
    email character varying(255),
    ramal character varying(50),
    senha character varying(32),
    chefia integer,
    valido smallint,
    data_atualizacao bigint
);


--
-- Name: usuarioxobjetoxperfil; Type: TABLE; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE TABLE usuarioxobjetoxperfil (
    cod_usuario integer DEFAULT 0 NOT NULL,
    cod_objeto integer DEFAULT 0 NOT NULL,
    cod_perfil integer DEFAULT 0 NOT NULL
);


--
-- Name: ix_objeto_cod_objeto; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY objeto
    ADD CONSTRAINT ix_objeto_cod_objeto UNIQUE (cod_objeto);


--
-- Name: pk__classe__44ff419a; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY classe
    ADD CONSTRAINT pk__classe__44ff419a PRIMARY KEY (cod_classe);


--
-- Name: pk__classexobjeto__4f7cd00d; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY classexobjeto
    ADD CONSTRAINT pk__classexobjeto__4f7cd00d PRIMARY KEY (cod_classe, cod_objeto);


--
-- Name: pk__comentarios__534d60f1; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY comentarios
    ADD CONSTRAINT pk__comentarios__534d60f1 PRIMARY KEY (cod_comentario);


--
-- Name: pk__errortable__693ca210; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY errortable
    ADD CONSTRAINT pk__errortable__693ca210 PRIMARY KEY (cod_errortable);


--
-- Name: pk__index_badwords__19dfd96b; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY index_badwords
    ADD CONSTRAINT pk__index_badwords__19dfd96b PRIMARY KEY (cod_badwords);


--
-- Name: pk__infoperfil__236943a5; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY infoperfil
    ADD CONSTRAINT pk__infoperfil__236943a5 PRIMARY KEY (cod_infoperfil);


--
-- Name: pk__objeto__3a4ca8fd; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY objeto
    ADD CONSTRAINT pk__objeto__3a4ca8fd PRIMARY KEY (cod_objeto);


--
-- Name: pk__parentesco__4a8310c6; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY parentesco
    ADD CONSTRAINT pk__parentesco__4a8310c6 PRIMARY KEY (cod_objeto, cod_pai);


--
-- Name: pk__pele__503bea1c; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY pele
    ADD CONSTRAINT pk__pele__503bea1c PRIMARY KEY (cod_pele);


--
-- Name: pk__pendencia__540c7b00; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY pendencia
    ADD CONSTRAINT pk__pendencia__540c7b00 PRIMARY KEY (cod_objeto, cod_usuario);


--
-- Name: pk__perfil__57dd0be4; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY perfil
    ADD CONSTRAINT pk__perfil__57dd0be4 PRIMARY KEY (cod_perfil);


--
-- Name: pk__pilha__5d95e53a; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY pilha
    ADD CONSTRAINT pk__pilha__5d95e53a PRIMARY KEY (cod_pilha);


--
-- Name: pk__propriedade__634ebe90; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY propriedade
    ADD CONSTRAINT pk__propriedade__634ebe90 PRIMARY KEY (cod_propriedade);


--
-- Name: pk__status__6aefe058; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY status
    ADD CONSTRAINT pk__status__6aefe058 PRIMARY KEY (cod_status);


--
-- Name: pk__tbl_blob__6dcc4d03; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY tbl_blob
    ADD CONSTRAINT pk__tbl_blob__6dcc4d03 PRIMARY KEY (cod_blob);


--
-- Name: pk__tbl_boolean__73852659; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY tbl_boolean
    ADD CONSTRAINT pk__tbl_boolean__73852659 PRIMARY KEY (cod_boolean);


--
-- Name: pk__tbl_date__793dffaf; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY tbl_date
    ADD CONSTRAINT pk__tbl_date__793dffaf PRIMARY KEY (cod_date);


--
-- Name: pk__tbl_float__7e02b4cc; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY tbl_float
    ADD CONSTRAINT pk__tbl_float__7e02b4cc PRIMARY KEY (cod_float);


--
-- Name: pk__tbl_integer__02c769e9; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY tbl_integer
    ADD CONSTRAINT pk__tbl_integer__02c769e9 PRIMARY KEY (cod_integer);


--
-- Name: pk__tbl_objref__078c1f06; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY tbl_objref
    ADD CONSTRAINT pk__tbl_objref__078c1f06 PRIMARY KEY (cod_objref);


--
-- Name: pk__tbl_string__0c50d423; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY tbl_string
    ADD CONSTRAINT pk__tbl_string__0c50d423 PRIMARY KEY (cod_string);


--
-- Name: pk__tbl_text__11158940; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY tbl_text
    ADD CONSTRAINT pk__tbl_text__11158940 PRIMARY KEY (cod_text);


--
-- Name: pk__tempcontrole__14e61a24; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY tempcontrole
    ADD CONSTRAINT pk__tempcontrole__14e61a24 PRIMARY KEY (tabela);


--
-- Name: pk__tipodado__17c286cf; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY tipodado
    ADD CONSTRAINT pk__tipodado__17c286cf PRIMARY KEY (cod_tipodado);


--
-- Name: pk__unlock_table__1c873bec; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY unlock_table
    ADD CONSTRAINT pk__unlock_table__1c873bec PRIMARY KEY (cod_unlock);


--
-- Name: pk__usuario__1f63a897; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT pk__usuario__1f63a897 PRIMARY KEY (cod_usuario);


--
-- Name: pk__usuarioxobjetoxp__2610a626; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY usuarioxobjetoxperfil
    ADD CONSTRAINT pk__usuarioxobjetoxp__2610a626 PRIMARY KEY (cod_objeto, cod_perfil, cod_usuario);


--
-- Name: pky_tag; Type: CONSTRAINT; Schema: public; Owner: frodrigues; Tablespace: 
--

ALTER TABLE ONLY tag
    ADD CONSTRAINT pky_tag PRIMARY KEY (cod_tag);


--
-- Name: ind_logobjeto_codobjeto; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ind_logobjeto_codobjeto ON logobjeto USING btree (cod_objeto);


--
-- Name: ix_classe_cod_classe_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE UNIQUE INDEX ix_classe_cod_classe_desc ON classe USING btree (cod_classe);


--
-- Name: ix_infoperfil_cod_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE UNIQUE INDEX ix_infoperfil_cod_desc ON infoperfil USING btree (cod_infoperfil);


--
-- Name: ix_infoperfil_cod_perfil_asc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_infoperfil_cod_perfil_asc ON infoperfil USING btree (cod_perfil);


--
-- Name: ix_infoperfil_cod_perfil_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_infoperfil_cod_perfil_desc ON infoperfil USING btree (cod_infoperfil);


--
-- Name: ix_objeto_classe; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_objeto_classe ON objeto USING btree (cod_classe);


--
-- Name: ix_objeto_classe_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_objeto_classe_desc ON objeto USING btree (cod_status);


--
-- Name: ix_objeto_pele; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_objeto_pele ON objeto USING btree (cod_pele);


--
-- Name: ix_objeto_pele_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_objeto_pele_desc ON objeto USING btree (cod_objeto);


--
-- Name: ix_objeto_peso_asc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_objeto_peso_asc ON objeto USING btree (peso);


--
-- Name: ix_objeto_peso_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_objeto_peso_desc ON objeto USING btree (peso);


--
-- Name: ix_objeto_status; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_objeto_status ON objeto USING btree (cod_status);


--
-- Name: ix_objeto_status_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_objeto_status_desc ON objeto USING btree (cod_objeto);


--
-- Name: ix_parentesco_cod_objeto_asc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_parentesco_cod_objeto_asc ON parentesco USING btree (cod_objeto, cod_pai);


--
-- Name: ix_parentesco_cod_objeto_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_parentesco_cod_objeto_desc ON parentesco USING btree (cod_objeto, cod_pai);


--
-- Name: ix_parentesco_ordem_asc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_parentesco_ordem_asc ON parentesco USING btree (ordem);


--
-- Name: ix_parentesco_ordem_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_parentesco_ordem_desc ON parentesco USING btree (ordem);


--
-- Name: ix_propriedade_classe_asc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_propriedade_classe_asc ON propriedade USING btree (cod_classe);


--
-- Name: ix_propriedade_classe_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_propriedade_classe_desc ON propriedade USING btree (cod_classe);


--
-- Name: ix_propriedade_tipodado_asc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_propriedade_tipodado_asc ON propriedade USING btree (cod_tipodado);


--
-- Name: ix_propriedade_tipodado_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_propriedade_tipodado_desc ON propriedade USING btree (cod_tipodado);


--
-- Name: ix_tbl_blob_cod_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE UNIQUE INDEX ix_tbl_blob_cod_desc ON tbl_blob USING btree (cod_blob);


--
-- Name: ix_tbl_blob_objeto_asc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_blob_objeto_asc ON tbl_blob USING btree (cod_objeto);


--
-- Name: ix_tbl_blob_objeto_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_blob_objeto_desc ON tbl_blob USING btree (cod_blob);


--
-- Name: ix_tbl_boolean_cod_boolean_asc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE UNIQUE INDEX ix_tbl_boolean_cod_boolean_asc ON tbl_boolean USING btree (cod_boolean);


--
-- Name: ix_tbl_boolean_cod_boolean_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE UNIQUE INDEX ix_tbl_boolean_cod_boolean_desc ON tbl_boolean USING btree (cod_boolean);


--
-- Name: ix_tbl_boolean_objeto_asc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_boolean_objeto_asc ON tbl_boolean USING btree (cod_objeto);


--
-- Name: ix_tbl_boolean_objeto_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_boolean_objeto_desc ON tbl_boolean USING btree (cod_objeto);


--
-- Name: ix_tbl_boolean_propriedade_asc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_boolean_propriedade_asc ON tbl_boolean USING btree (cod_propriedade);


--
-- Name: ix_tbl_boolean_propriedade_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_boolean_propriedade_desc ON tbl_boolean USING btree (cod_propriedade);


--
-- Name: ix_tbl_integer_cod_objeto_asc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_integer_cod_objeto_asc ON tbl_integer USING btree (cod_objeto);


--
-- Name: ix_tbl_integer_cod_objeto_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_integer_cod_objeto_desc ON tbl_integer USING btree (cod_objeto);


--
-- Name: ix_tbl_integer_cod_propriedade; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_integer_cod_propriedade ON tbl_integer USING btree (cod_propriedade);


--
-- Name: ix_tbl_objref_objeto_asc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_objref_objeto_asc ON tbl_objref USING btree (cod_objeto);


--
-- Name: ix_tbl_objref_objeto_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_objref_objeto_desc ON tbl_objref USING btree (cod_objref);


--
-- Name: ix_tbl_objref_objref_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE UNIQUE INDEX ix_tbl_objref_objref_desc ON tbl_objref USING btree (cod_objref);


--
-- Name: ix_tbl_objref_propriedade_asc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_objref_propriedade_asc ON tbl_objref USING btree (cod_propriedade);


--
-- Name: ix_tbl_objref_propriedade_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_objref_propriedade_desc ON tbl_objref USING btree (cod_propriedade);


--
-- Name: ix_tbl_string_objeto; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_string_objeto ON tbl_string USING btree (cod_objeto);


--
-- Name: ix_tbl_text_cod_text_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_text_cod_text_desc ON tbl_text USING btree (cod_text);


--
-- Name: ix_tbl_text_objeto; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_text_objeto ON tbl_text USING btree (cod_objeto);


--
-- Name: ix_tbl_text_objeto_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_text_objeto_desc ON tbl_text USING btree (cod_text);


--
-- Name: ix_tbl_text_propriedade_asc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_text_propriedade_asc ON tbl_text USING btree (cod_propriedade);


--
-- Name: ix_tbl_text_propriedade_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tbl_text_propriedade_desc ON tbl_text USING btree (cod_text);


--
-- Name: ix_tipodado_cod_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE UNIQUE INDEX ix_tipodado_cod_desc ON tipodado USING btree (cod_tipodado);


--
-- Name: ix_tipodado_cod_tipodado_desc; Type: INDEX; Schema: public; Owner: frodrigues; Tablespace: 
--

CREATE INDEX ix_tipodado_cod_tipodado_desc ON tipodado USING btree (cod_tipodado);


--
-- Name: fky_objeto_tagxobjeto; Type: FK CONSTRAINT; Schema: public; Owner: frodrigues
--

ALTER TABLE ONLY tagxobjeto
    ADD CONSTRAINT fky_objeto_tagxobjeto FOREIGN KEY (cod_objeto) REFERENCES objeto(cod_objeto);


--
-- Name: fky_tag_tagxobjeto; Type: FK CONSTRAINT; Schema: public; Owner: frodrigues
--

ALTER TABLE ONLY tagxobjeto
    ADD CONSTRAINT fky_tag_tagxobjeto FOREIGN KEY (cod_tag) REFERENCES tag(cod_tag);


--
-- PostgreSQL database dump complete
--

