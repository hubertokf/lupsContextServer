--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: KEYS; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE SEQUENCE keys_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE public.keys_id_seq OWNER TO postgres;

CREATE TABLE keys (
    id integer DEFAULT nextval('keys_id_seq'::regclass) NOT NULL,
    key character varying NOT NULL,
    level integer NOT NULL,
    ignore_limits integer NOT NULL DEFAULT 0,
    date_created integer NOT NULL,
    PRIMARY KEY (id)
);


ALTER TABLE public.keys OWNER TO postgres;

--
-- Name: agendamento; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE agendamento (
    agendamento_id integer NOT NULL,
    datetimefinal timestamp without time zone NOT NULL,
    descricao character varying NOT NULL,
    usuario_id bigint NOT NULL,
    ambiente_id integer NOT NULL,
    datetimeinicial timestamp without time zone NOT NULL
);


ALTER TABLE public.agendamento OWNER TO postgres;

--
-- Name: agendamento_id_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE agendamento_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.agendamento_id_seq OWNER TO postgres;

--
-- Name: agendamento_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE agendamento_id_seq OWNED BY agendamento.agendamento_id;


--
-- Name: ambiente; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE ambiente (
    ambiente_id integer NOT NULL,
    nome character varying NOT NULL,
    descricao character varying,
    status boolean DEFAULT true NOT NULL
);


ALTER TABLE public.ambiente OWNER TO postgres;

--
-- Name: ambiente_id_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE ambiente_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ambiente_id_seq OWNER TO postgres;

--
-- Name: ambiente_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE ambiente_id_seq OWNED BY ambiente.ambiente_id;


--
-- Name: configuracao_id_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE configuracao_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999
    CACHE 1;


ALTER TABLE public.configuracao_id_seq OWNER TO postgres;

--
-- Name: configuracoes; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE configuracoes (
    configuracao_id integer DEFAULT nextval('configuracao_id_seq'::regclass) NOT NULL,
    usuario_id integer,
    titulo character varying NOT NULL,
    img_cabecalho character varying,
    img_projeto character varying,
    cor_predominante character varying
);


ALTER TABLE public.configuracoes OWNER TO postgres;

--
-- Name: contextointeresse_id_seq_1; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE contextointeresse_id_seq_1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.contextointeresse_id_seq_1 OWNER TO postgres;

--
-- Name: contextointeresse; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE contextointeresse (
    contextointeresse_id integer DEFAULT nextval('contextointeresse_id_seq_1'::regclass) NOT NULL,
    nome character varying NOT NULL,
    servidorcontexto_id integer NOT NULL,
    publico boolean DEFAULT true NOT NULL,
    regra_id integer
);


ALTER TABLE public.contextointeresse OWNER TO postgres;

--
-- Name: fabricante; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE fabricante (
    fabricante_id integer NOT NULL,
    nome character varying(255),
    endereco character varying(300),
    telefone character varying(16),
    url character varying(255),
    cidade character varying(200),
    estado character varying,
    pais character varying
);


ALTER TABLE public.fabricante OWNER TO postgres;

--
-- Name: fabricante_id_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE fabricante_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.fabricante_id_seq OWNER TO postgres;

--
-- Name: fabricante_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE fabricante_id_seq OWNED BY fabricante.fabricante_id;


--
-- Name: gateway; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE gateway (
    gateway_id integer NOT NULL,
    nome character varying NOT NULL,
    modelo character varying,
    fabricante_id integer,
    servidorborda_id integer NOT NULL,
    uid character varying,
    status boolean DEFAULT true NOT NULL
);


ALTER TABLE public.gateway OWNER TO postgres;

--
-- Name: gateway_id_seq_1_1; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE gateway_id_seq_1_1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.gateway_id_seq_1_1 OWNER TO postgres;

--
-- Name: gateway_id_seq_1_1; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE gateway_id_seq_1_1 OWNED BY gateway.gateway_id;


--
-- Name: gateway_uid_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE gateway_uid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.gateway_uid_seq OWNER TO postgres;

--
-- Name: gateway_uid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE gateway_uid_seq OWNED BY gateway.uid;


--
-- Name: gatewaytemp; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE gatewaytemp (
    gatewaytemp_id integer NOT NULL,
    uid integer NOT NULL,
    nome integer NOT NULL,
    modelo integer NOT NULL,
    fabricante_id integer NOT NULL,
    status integer NOT NULL
);


ALTER TABLE public.gatewaytemp OWNER TO postgres;

--
-- Name: gatewaytemp_fabricante_id_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE gatewaytemp_fabricante_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.gatewaytemp_fabricante_id_seq OWNER TO postgres;

--
-- Name: gatewaytemp_fabricante_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE gatewaytemp_fabricante_id_seq OWNED BY gatewaytemp.fabricante_id;


--
-- Name: gatewaytemp_gatewaytemp_id_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE gatewaytemp_gatewaytemp_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.gatewaytemp_gatewaytemp_id_seq OWNER TO postgres;

--
-- Name: gatewaytemp_gatewaytemp_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE gatewaytemp_gatewaytemp_id_seq OWNED BY gatewaytemp.gatewaytemp_id;


--
-- Name: gatewaytemp_modelo_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE gatewaytemp_modelo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.gatewaytemp_modelo_seq OWNER TO postgres;

--
-- Name: gatewaytemp_modelo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE gatewaytemp_modelo_seq OWNED BY gatewaytemp.modelo;


--
-- Name: gatewaytemp_nome_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE gatewaytemp_nome_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.gatewaytemp_nome_seq OWNER TO postgres;

--
-- Name: gatewaytemp_nome_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE gatewaytemp_nome_seq OWNED BY gatewaytemp.nome;


--
-- Name: gatewaytemp_status_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE gatewaytemp_status_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.gatewaytemp_status_seq OWNER TO postgres;

--
-- Name: gatewaytemp_status_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE gatewaytemp_status_seq OWNED BY gatewaytemp.status;


--
-- Name: gatewaytemp_uid_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE gatewaytemp_uid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.gatewaytemp_uid_seq OWNER TO postgres;

--
-- Name: gatewaytemp_uid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE gatewaytemp_uid_seq OWNED BY gatewaytemp.uid;


--
-- Name: menu; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE menu (
    menu_id integer NOT NULL,
    nome character varying(50),
    parente character varying(20) DEFAULT NULL::character varying,
    caminho character varying(100) DEFAULT NULL::character varying,
    ordem integer
);


ALTER TABLE public.menu OWNER TO postgres;

--
-- Name: menu_id_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE menu_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.menu_id_seq OWNER TO postgres;

--
-- Name: menu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE menu_id_seq OWNED BY menu.menu_id;


--
-- Name: perfilusuario; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE perfilusuario (
    perfilusuario_id integer NOT NULL,
    nome character varying(255),
    descricao character varying(255)
);


ALTER TABLE public.perfilusuario OWNER TO postgres;

--
-- Name: perfilusuario_id_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE perfilusuario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.perfilusuario_id_seq OWNER TO postgres;

--
-- Name: perfilusuario_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE perfilusuario_id_seq OWNED BY perfilusuario.perfilusuario_id;


--
-- Name: permissao_id_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE permissao_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.permissao_id_seq OWNER TO postgres;

--
-- Name: permissoes; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE permissoes (
    permissao_id integer DEFAULT nextval('permissao_id_seq'::regclass) NOT NULL,
    usuario_id integer NOT NULL,
    contextointeresse_id integer,
    sensor_id integer,
    ambiente_id integer,
    regra_id integer,
    podeeditar boolean DEFAULT false NOT NULL,
    recebeemail boolean DEFAULT false NOT NULL
);


ALTER TABLE public.permissoes OWNER TO postgres;

--
-- Name: publicacao; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE publicacao (
    publicacao_id integer NOT NULL,
    servidorborda_id integer NOT NULL,
    sensor_id integer NOT NULL,
    datacoleta timestamp without time zone NOT NULL,
    datapublicacao timestamp without time zone DEFAULT now() NOT NULL,
    valorcoletado real NOT NULL
);


ALTER TABLE public.publicacao OWNER TO postgres;

--
-- Name: publicacao_id_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE publicacao_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.publicacao_id_seq OWNER TO postgres;

--
-- Name: publicacao_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE publicacao_id_seq OWNED BY publicacao.publicacao_id;


--
-- Name: regra_id_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE regra_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999
    CACHE 1;


ALTER TABLE public.regra_id_seq OWNER TO postgres;

--
-- Name: regras; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE regras (
    regra_id integer DEFAULT nextval('regra_id_seq'::regclass) NOT NULL,
    status boolean NOT NULL,
    nome character varying NOT NULL,
    tipo integer DEFAULT 1 NOT NULL,
    arquivo_py character varying
);


ALTER TABLE public.regras OWNER TO postgres;

--
-- Name: COLUMN regras.tipo; Type: COMMENT; Schema: public; Owner: huberto
--

COMMENT ON COLUMN regras.tipo IS '1->Script Python';

--
-- Name: relcontextointeresse; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE relcontextointeresse (
    sensor_id integer NOT NULL,
    contextointeresse_id integer NOT NULL,
    ativaregra boolean DEFAULT false NOT NULL
);


ALTER TABLE public.relcontextointeresse OWNER TO postgres;

--
-- Name: relmenuperfil; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE relmenuperfil (
    menu_id integer NOT NULL,
    perfilusuario_id integer NOT NULL
);


ALTER TABLE public.relmenuperfil OWNER TO postgres;

--
-- Name: sensor; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE sensor (
    sensor_id integer NOT NULL,
    nome character varying NOT NULL,
    descricao character varying(300),
    modelo character varying NOT NULL,
    precisao double precision DEFAULT 1,
    valormin double precision,
    valormax double precision,
    fabricante_id integer,
    tiposensor_id integer,
    ambiente_id integer,
    gateway_id integer NOT NULL,
    servidorborda_id integer NOT NULL,
    valormax_n double precision,
    valormin_n double precision,
    inicio_luz time without time zone,
    fim_luz time without time zone,
    status boolean DEFAULT true NOT NULL
);


ALTER TABLE public.sensor OWNER TO postgres;

--
-- Name: sensor_id_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE sensor_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sensor_id_seq OWNER TO postgres;

--
-- Name: sensor_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE sensor_id_seq OWNED BY sensor.sensor_id;


--
-- Name: servidorborda; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE servidorborda (
    servidorborda_id integer NOT NULL,
    nome character varying NOT NULL,
    descricao character varying NOT NULL,
    latitude character varying NOT NULL,
    longitude character varying NOT NULL,
    servidorcontexto_id integer NOT NULL,
    url character varying
);


ALTER TABLE public.servidorborda OWNER TO postgres;

--
-- Name: servidorborda_servidorborda_id_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE servidorborda_servidorborda_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.servidorborda_servidorborda_id_seq OWNER TO postgres;

--
-- Name: servidorborda_servidorborda_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE servidorborda_servidorborda_id_seq OWNED BY servidorborda.servidorborda_id;


--
-- Name: servidorcontexto; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE servidorcontexto (
    servidorcontexto_id integer NOT NULL,
    nome character varying NOT NULL,
    longitude character varying NOT NULL,
    latitude character varying NOT NULL,
    descricao character varying NOT NULL
);


ALTER TABLE public.servidorcontexto OWNER TO postgres;

--
-- Name: servidorcontexto_id_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE servidorcontexto_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.servidorcontexto_id_seq OWNER TO postgres;

--
-- Name: servidorcontexto_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE servidorcontexto_id_seq OWNED BY servidorcontexto.servidorcontexto_id;


--
-- Name: tiposensor; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE tiposensor (
    tiposensor_id integer NOT NULL,
    nome character varying NOT NULL,
    descricao character varying NOT NULL,
    unidade character varying NOT NULL
);


ALTER TABLE public.tiposensor OWNER TO postgres;

--
-- Name: tiposensor_id_seq_1; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE tiposensor_id_seq_1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tiposensor_id_seq_1 OWNER TO postgres;

--
-- Name: tiposensor_id_seq_1; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE tiposensor_id_seq_1 OWNED BY tiposensor.tiposensor_id;


--
-- Name: usuario; Type: TABLE; Schema: public; Owner: huberto; Tablespace: 
--

CREATE TABLE usuario (
    usuario_id bigint NOT NULL,
    username character varying(255) NOT NULL,
    password character varying(32) NOT NULL,
    cadastro timestamp without time zone DEFAULT now() NOT NULL,
    email character varying(255),
    nome character(100),
    telefone character(30),
    celular character(30),
    perfilusuario_id integer NOT NULL
);


ALTER TABLE public.usuario OWNER TO postgres;

--
-- Name: usuario_id_seq; Type: SEQUENCE; Schema: public; Owner: huberto
--

CREATE SEQUENCE usuario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuario_id_seq OWNER TO postgres;

--
-- Name: usuario_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: huberto
--

ALTER SEQUENCE usuario_id_seq OWNED BY usuario.usuario_id;


--
-- Name: agendamento_id; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY agendamento ALTER COLUMN agendamento_id SET DEFAULT nextval('agendamento_id_seq'::regclass);


--
-- Name: ambiente_id; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY ambiente ALTER COLUMN ambiente_id SET DEFAULT nextval('ambiente_id_seq'::regclass);


--
-- Name: fabricante_id; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY fabricante ALTER COLUMN fabricante_id SET DEFAULT nextval('fabricante_id_seq'::regclass);


--
-- Name: gateway_id; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY gateway ALTER COLUMN gateway_id SET DEFAULT nextval('gateway_id_seq_1_1'::regclass);


--
-- Name: gatewaytemp_id; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY gatewaytemp ALTER COLUMN gatewaytemp_id SET DEFAULT nextval('gatewaytemp_gatewaytemp_id_seq'::regclass);


--
-- Name: uid; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY gatewaytemp ALTER COLUMN uid SET DEFAULT nextval('gatewaytemp_uid_seq'::regclass);


--
-- Name: nome; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY gatewaytemp ALTER COLUMN nome SET DEFAULT nextval('gatewaytemp_nome_seq'::regclass);


--
-- Name: modelo; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY gatewaytemp ALTER COLUMN modelo SET DEFAULT nextval('gatewaytemp_modelo_seq'::regclass);


--
-- Name: fabricante_id; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY gatewaytemp ALTER COLUMN fabricante_id SET DEFAULT nextval('gatewaytemp_fabricante_id_seq'::regclass);


--
-- Name: status; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY gatewaytemp ALTER COLUMN status SET DEFAULT nextval('gatewaytemp_status_seq'::regclass);


--
-- Name: menu_id; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY menu ALTER COLUMN menu_id SET DEFAULT nextval('menu_id_seq'::regclass);


--
-- Name: perfilusuario_id; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY perfilusuario ALTER COLUMN perfilusuario_id SET DEFAULT nextval('perfilusuario_id_seq'::regclass);


--
-- Name: publicacao_id; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY publicacao ALTER COLUMN publicacao_id SET DEFAULT nextval('publicacao_id_seq'::regclass);


--
-- Name: sensor_id; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY sensor ALTER COLUMN sensor_id SET DEFAULT nextval('sensor_id_seq'::regclass);


--
-- Name: servidorborda_id; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY servidorborda ALTER COLUMN servidorborda_id SET DEFAULT nextval('servidorborda_servidorborda_id_seq'::regclass);


--
-- Name: servidorcontexto_id; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY servidorcontexto ALTER COLUMN servidorcontexto_id SET DEFAULT nextval('servidorcontexto_id_seq'::regclass);


--
-- Name: tiposensor_id; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY tiposensor ALTER COLUMN tiposensor_id SET DEFAULT nextval('tiposensor_id_seq_1'::regclass);


--
-- Name: usuario_id; Type: DEFAULT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY usuario ALTER COLUMN usuario_id SET DEFAULT nextval('usuario_id_seq'::regclass);


--
-- Data for Name: agendamento; Type: TABLE DATA; Schema: public; Owner: huberto
--



--
-- Name: agendamento_id_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('agendamento_id_seq', 1, false);


--
-- Name: ambiente_id_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('ambiente_id_seq', 1, false);


--
-- Name: configuracao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('configuracao_id_seq', 50, true);


--
-- Data for Name: configuracoes; Type: TABLE DATA; Schema: public; Owner: huberto
--

INSERT INTO configuracoes VALUES (1, NULL, 'plenUS', 'banner_intranet1.jpg', NULL, NULL);


--
-- Name: contextointeresse_id_seq_1; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('contextointeresse_id_seq_1', 1, false);


--
-- Data for Name: fabricante; Type: TABLE DATA; Schema: public; Owner: huberto
--

INSERT INTO fabricante VALUES (1, 'LUPS', 'Rua Gomes Carneiro 1', '5555555555555', 'http://lups.inf.ufpel.edu.br', 'Pelotas', 'RS', 'Brasil');


--
-- Name: fabricante_id_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('fabricante_id_seq', 1, true);

--
-- Name: gateway_id_seq_1_1; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('gateway_id_seq_1_1', 1, false);


--
-- Name: gateway_uid_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('gateway_uid_seq', 1, false);


--
-- Data for Name: gatewaytemp; Type: TABLE DATA; Schema: public; Owner: huberto
--



--
-- Name: gatewaytemp_fabricante_id_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('gatewaytemp_fabricante_id_seq', 1, false);


--
-- Name: gatewaytemp_gatewaytemp_id_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('gatewaytemp_gatewaytemp_id_seq', 1, false);


--
-- Name: gatewaytemp_modelo_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('gatewaytemp_modelo_seq', 1, false);


--
-- Name: gatewaytemp_nome_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('gatewaytemp_nome_seq', 1, false);


--
-- Name: gatewaytemp_status_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('gatewaytemp_status_seq', 1, false);


--
-- Name: gatewaytemp_uid_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('gatewaytemp_uid_seq', 1, false);


--
-- Data for Name: menu; Type: TABLE DATA; Schema: public; Owner: huberto
--

INSERT INTO menu VALUES (6, 'Administração', NULL, NULL, 9);
INSERT INTO menu VALUES (1, 'Início', '', 'CI_inicio', 1);
INSERT INTO menu VALUES (2, 'Servidor de Contexto', NULL, 'cadastros/CI_servidorcontexto', 2);
INSERT INTO menu VALUES (3, 'Sensores', NULL, 'cadastros/CI_sensor', 7);
INSERT INTO menu VALUES (5, 'Agendamento', '', 'agenda/CI_agenda', 8);
INSERT INTO menu VALUES (11, 'Tipo de sensores', '3', 'cadastros/CI_tipo_sensor', 11);
INSERT INTO menu VALUES (13, 'Servidores de Borda', NULL, 'cadastros/CI_servidorborda', 4);
INSERT INTO menu VALUES (14, 'Fabricantes', '6', 'cadastros/CI_fabricante', 14);
INSERT INTO menu VALUES (16, 'Publicações Realizadas', '3', 'cadastros/CI_publicacao', 16);
INSERT INTO menu VALUES (17, 'Perfis', '6', 'cadastros/CI_perfil', 18);
INSERT INTO menu VALUES (18, 'Usuários', '6', 'cadastros/CI_usuario', 19);
INSERT INTO menu VALUES (19, 'Menus', '6', 'cadastros/CI_menu', 17);
INSERT INTO menu VALUES (21, 'Visualizar', '5', 'agenda/CI_agenda/selecionar', 23);
INSERT INTO menu VALUES (22, 'Ambientes', NULL, 'cadastros/CI_ambiente', 6);
INSERT INTO menu VALUES (24, 'Relatórios', '5', 'agenda/CI_agenda/relatorio', 22);
INSERT INTO menu VALUES (25, 'Gateway', '13', 'cadastros/CI_gateway', 5);
INSERT INTO menu VALUES (37, 'Contexto de Interesse', '2', 'cadastros/CI_contextointeresse', 0);
INSERT INTO menu VALUES (38, 'Regras', '2', 'cadastros/CI_regras', 0);
INSERT INTO menu VALUES (40, 'Configurações Gerais', '6', 'configuracoes/CI_configuracoes/geral', 0);
INSERT INTO menu VALUES (39, 'Personalizar perfil', '6', 'configuracoes/CI_configuracoes/personaliza', 5);


--
-- Name: menu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('menu_id_seq', 41, true);


--
-- Data for Name: perfilusuario; Type: TABLE DATA; Schema: public; Owner: huberto
--

INSERT INTO perfilusuario VALUES (1, 'Administrador', 'Administrador');
INSERT INTO perfilusuario VALUES (10, 'Agendador', 'Agendador');
INSERT INTO perfilusuario VALUES (2, 'Super Administrador', 'Super Administrador');
INSERT INTO perfilusuario VALUES (11, 'Visualizador', 'asdf');


--
-- Name: perfilusuario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('perfilusuario_id_seq', 11, true);


--
-- Name: permissao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('permissao_id_seq', 1, false);


--
-- Name: publicacao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('publicacao_id_seq', 1, false);


--
-- Name: regra_id_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('regra_id_seq', 1, false);


--
-- Data for Name: relmenuperfil; Type: TABLE DATA; Schema: public; Owner: huberto
--

INSERT INTO relmenuperfil VALUES (1, 1);
INSERT INTO relmenuperfil VALUES (2, 1);
INSERT INTO relmenuperfil VALUES (3, 1);
INSERT INTO relmenuperfil VALUES (11, 1);
INSERT INTO relmenuperfil VALUES (16, 1);
INSERT INTO relmenuperfil VALUES (5, 1);
INSERT INTO relmenuperfil VALUES (21, 1);
INSERT INTO relmenuperfil VALUES (24, 1);
INSERT INTO relmenuperfil VALUES (6, 1);
INSERT INTO relmenuperfil VALUES (14, 1);
INSERT INTO relmenuperfil VALUES (17, 1);
INSERT INTO relmenuperfil VALUES (18, 1);
INSERT INTO relmenuperfil VALUES (19, 1);
INSERT INTO relmenuperfil VALUES (13, 1);
INSERT INTO relmenuperfil VALUES (22, 1);
INSERT INTO relmenuperfil VALUES (25, 1);
INSERT INTO relmenuperfil VALUES (37, 1);
INSERT INTO relmenuperfil VALUES (38, 1);
INSERT INTO relmenuperfil VALUES (39, 1);
INSERT INTO relmenuperfil VALUES (1, 10);
INSERT INTO relmenuperfil VALUES (5, 10);
INSERT INTO relmenuperfil VALUES (21, 10);
INSERT INTO relmenuperfil VALUES (24, 10);
INSERT INTO relmenuperfil VALUES (6, 10);
INSERT INTO relmenuperfil VALUES (17, 10);
INSERT INTO relmenuperfil VALUES (40, 1);
INSERT INTO relmenuperfil VALUES (1, 2);
INSERT INTO relmenuperfil VALUES (2, 2);
INSERT INTO relmenuperfil VALUES (37, 2);
INSERT INTO relmenuperfil VALUES (38, 2);
INSERT INTO relmenuperfil VALUES (3, 2);
INSERT INTO relmenuperfil VALUES (11, 2);
INSERT INTO relmenuperfil VALUES (16, 2);
INSERT INTO relmenuperfil VALUES (5, 2);
INSERT INTO relmenuperfil VALUES (21, 2);
INSERT INTO relmenuperfil VALUES (24, 2);
INSERT INTO relmenuperfil VALUES (6, 2);
INSERT INTO relmenuperfil VALUES (14, 2);
INSERT INTO relmenuperfil VALUES (17, 2);
INSERT INTO relmenuperfil VALUES (18, 2);
INSERT INTO relmenuperfil VALUES (19, 2);
INSERT INTO relmenuperfil VALUES (39, 2);
INSERT INTO relmenuperfil VALUES (40, 2);
INSERT INTO relmenuperfil VALUES (13, 2);
INSERT INTO relmenuperfil VALUES (25, 2);
INSERT INTO relmenuperfil VALUES (22, 2);

--
-- Name: sensor_id_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('sensor_id_seq', 1, false);


--
-- Name: servidorborda_servidorborda_id_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('servidorborda_servidorborda_id_seq', 1, false);


--
-- Data for Name: servidorcontexto; Type: TABLE DATA; Schema: public; Owner: huberto
--

INSERT INTO servidorcontexto VALUES (9, 'Servidor de Contexto', '3', '2', 'Servidor de Contexto - plenus.cpact.embrapa.br - 192.168.162.8');


--
-- Name: servidorcontexto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('servidorcontexto_id_seq', 1, false);


--
-- Data for Name: tiposensor; Type: TABLE DATA; Schema: public; Owner: huberto
--

INSERT INTO tiposensor VALUES (9, 'Temperatura', 'Sensor de Temperatura', 'ºC');
INSERT INTO tiposensor VALUES (10, 'Umidade', 'Sensor de Umidade', '%UR');
INSERT INTO tiposensor VALUES (11, 'Estado de Evento', 'Estado de Evento - Ligado ou Desligado', 'L/D');
INSERT INTO tiposensor VALUES (12, 'Presença/Ausência Luz', 'Presença ou Ausência de luz', '%Luz');


--
-- Name: tiposensor_id_seq_1; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('tiposensor_id_seq_1', 12, true);


--
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: huberto
--

INSERT INTO usuario VALUES (2, 'adenauer', 'plenus2luz', '2015-09-03 15:39:32', 'adenauer@inf.ufpel.edu.br', 'Adenauer                                                                                            ', '                              ', '5391123478                    ', 2);
INSERT INTO usuario VALUES (1, 'hubertokf', '99766330', '2015-09-25 12:32:02', 'betinhoh@gmail.com', 'Huberto Kaiser Filho                                                                                ', '5330277169                    ', '5381177468                    ', 2);


--
-- Name: usuario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: huberto
--

SELECT pg_catalog.setval('usuario_id_seq', 2, true);


--
-- Name: agendamento_id; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY agendamento
    ADD CONSTRAINT agendamento_id PRIMARY KEY (agendamento_id);


--
-- Name: ambiente_id; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY ambiente
    ADD CONSTRAINT ambiente_id PRIMARY KEY (ambiente_id);


--
-- Name: configuracoes_pkey; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY configuracoes
    ADD CONSTRAINT configuracoes_pkey PRIMARY KEY (configuracao_id);


--
-- Name: contexto_id; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY servidorcontexto
    ADD CONSTRAINT contexto_id PRIMARY KEY (servidorcontexto_id);


--
-- Name: contextointeresse_id; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY contextointeresse
    ADD CONSTRAINT contextointeresse_id PRIMARY KEY (contextointeresse_id);


--
-- Name: fabricante_id; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY fabricante
    ADD CONSTRAINT fabricante_id PRIMARY KEY (fabricante_id);


--
-- Name: gateway_id; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY gateway
    ADD CONSTRAINT gateway_id PRIMARY KEY (gateway_id);


--
-- Name: gatewaytemp_pkey; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY gatewaytemp
    ADD CONSTRAINT gatewaytemp_pkey PRIMARY KEY (gatewaytemp_id);


--
-- Name: menu_id; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY menu
    ADD CONSTRAINT menu_id PRIMARY KEY (menu_id);


--
-- Name: nome_unique; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY tiposensor
    ADD CONSTRAINT nome_unique UNIQUE (nome);


--
-- Name: perfilusuario_id; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY perfilusuario
    ADD CONSTRAINT perfilusuario_id PRIMARY KEY (perfilusuario_id);


--
-- Name: permissoes_pkey; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY permissoes
    ADD CONSTRAINT permissoes_pkey PRIMARY KEY (permissao_id);


--
-- Name: publicacao_id; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY publicacao
    ADD CONSTRAINT publicacao_id PRIMARY KEY (publicacao_id);


--
-- Name: regras_id; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY regras
    ADD CONSTRAINT regras_id PRIMARY KEY (regra_id);


--
-- Name: relcontextointeresse_id; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY relcontextointeresse
    ADD CONSTRAINT relcontextointeresse_id PRIMARY KEY (sensor_id, contextointeresse_id);


--
-- Name: relmenuperfil_id; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY relmenuperfil
    ADD CONSTRAINT relmenuperfil_id PRIMARY KEY (menu_id, perfilusuario_id);


--
-- Name: sensor_id; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY sensor
    ADD CONSTRAINT sensor_id PRIMARY KEY (sensor_id);


--
-- Name: servidorborda_id; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY servidorborda
    ADD CONSTRAINT servidorborda_id PRIMARY KEY (servidorborda_id);


--
-- Name: tiposensor_id; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY tiposensor
    ADD CONSTRAINT tiposensor_id PRIMARY KEY (tiposensor_id);


--
-- Name: usuario_id; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_id PRIMARY KEY (usuario_id);


--
-- Name: usuario_id_unique; Type: CONSTRAINT; Schema: public; Owner: huberto; Tablespace: 
--

ALTER TABLE ONLY configuracoes
    ADD CONSTRAINT usuario_id_unique UNIQUE (usuario_id);


--
-- Name: uid_unique; Type: INDEX; Schema: public; Owner: huberto; Tablespace: 
--

CREATE UNIQUE INDEX uid_unique ON gateway USING btree (uid);


--
-- Name: username_unique; Type: INDEX; Schema: public; Owner: huberto; Tablespace: 
--

CREATE UNIQUE INDEX username_unique ON usuario USING btree (username);


--
-- Name: borda_gateway_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY gateway
    ADD CONSTRAINT borda_gateway_fk FOREIGN KEY (servidorborda_id) REFERENCES servidorborda(servidorborda_id);


--
-- Name: borda_publicacao_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY publicacao
    ADD CONSTRAINT borda_publicacao_fk FOREIGN KEY (servidorborda_id) REFERENCES servidorborda(servidorborda_id);


--
-- Name: contexto_borda_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY servidorborda
    ADD CONSTRAINT contexto_borda_fk FOREIGN KEY (servidorcontexto_id) REFERENCES servidorcontexto(servidorcontexto_id);


--
-- Name: contextointeresse_relcontextointeresse_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY relcontextointeresse
    ADD CONSTRAINT contextointeresse_relcontextointeresse_fk FOREIGN KEY (contextointeresse_id) REFERENCES contextointeresse(contextointeresse_id) ON DELETE CASCADE;


--
-- Name: equipamento_agendamento_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY agendamento
    ADD CONSTRAINT equipamento_agendamento_fk FOREIGN KEY (ambiente_id) REFERENCES ambiente(ambiente_id);


--
-- Name: equipamento_sensor_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY sensor
    ADD CONSTRAINT equipamento_sensor_fk FOREIGN KEY (ambiente_id) REFERENCES ambiente(ambiente_id);


--
-- Name: fabricante_gateway_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY gateway
    ADD CONSTRAINT fabricante_gateway_fk FOREIGN KEY (fabricante_id) REFERENCES fabricante(fabricante_id);


--
-- Name: fabricante_id; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY sensor
    ADD CONSTRAINT fabricante_id FOREIGN KEY (fabricante_id) REFERENCES fabricante(fabricante_id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: gateway_sensor_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY sensor
    ADD CONSTRAINT gateway_sensor_fk FOREIGN KEY (gateway_id) REFERENCES gateway(gateway_id);


--
-- Name: menu_relmenuperfil_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY relmenuperfil
    ADD CONSTRAINT menu_relmenuperfil_fk FOREIGN KEY (menu_id) REFERENCES menu(menu_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: perfilusuario_relmenuperfil_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY relmenuperfil
    ADD CONSTRAINT perfilusuario_relmenuperfil_fk FOREIGN KEY (perfilusuario_id) REFERENCES perfilusuario(perfilusuario_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: perfilusuario_usuario_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT perfilusuario_usuario_fk FOREIGN KEY (perfilusuario_id) REFERENCES perfilusuario(perfilusuario_id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: permissoes_ambiente_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY permissoes
    ADD CONSTRAINT permissoes_ambiente_fk FOREIGN KEY (ambiente_id) REFERENCES ambiente(ambiente_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: permissoes_contextointeresse_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY permissoes
    ADD CONSTRAINT permissoes_contextointeresse_fk FOREIGN KEY (contextointeresse_id) REFERENCES contextointeresse(contextointeresse_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: permissoes_regras_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY permissoes
    ADD CONSTRAINT permissoes_regras_fk FOREIGN KEY (regra_id) REFERENCES regras(regra_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: permissoes_sensor_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY permissoes
    ADD CONSTRAINT permissoes_sensor_fk FOREIGN KEY (sensor_id) REFERENCES sensor(sensor_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: permissoes_usuario_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY permissoes
    ADD CONSTRAINT permissoes_usuario_fk FOREIGN KEY (usuario_id) REFERENCES usuario(usuario_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: regra_contextointeresse_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY contextointeresse
    ADD CONSTRAINT regra_contextointeresse_fk FOREIGN KEY (regra_id) REFERENCES regras(regra_id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: sensor_contextointeresse_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY relcontextointeresse
    ADD CONSTRAINT sensor_contextointeresse_fk FOREIGN KEY (sensor_id) REFERENCES sensor(sensor_id) ON DELETE CASCADE;


--
-- Name: sensor_publicacao_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY publicacao
    ADD CONSTRAINT sensor_publicacao_fk FOREIGN KEY (sensor_id) REFERENCES sensor(sensor_id);


--
-- Name: servidorborda_id; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY sensor
    ADD CONSTRAINT servidorborda_id FOREIGN KEY (servidorborda_id) REFERENCES servidorborda(servidorborda_id);


--
-- Name: servidorcontexto_contextointeresse_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY contextointeresse
    ADD CONSTRAINT servidorcontexto_contextointeresse_fk FOREIGN KEY (servidorcontexto_id) REFERENCES servidorcontexto(servidorcontexto_id);


--
-- Name: tiposensor_sensor_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY sensor
    ADD CONSTRAINT tiposensor_sensor_fk FOREIGN KEY (tiposensor_id) REFERENCES tiposensor(tiposensor_id);


--
-- Name: usuario_agendamento_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY agendamento
    ADD CONSTRAINT usuario_agendamento_fk FOREIGN KEY (usuario_id) REFERENCES usuario(usuario_id);


--
-- Name: usuario_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: huberto
--

ALTER TABLE ONLY configuracoes
    ADD CONSTRAINT usuario_id_fk FOREIGN KEY (usuario_id) REFERENCES usuario(usuario_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

