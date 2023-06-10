--
-- PostgreSQL database dump
--

-- Dumped from database version 15.0
-- Dumped by pg_dump version 15.0

-- Started on 2023-06-10 13:46:18

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 245 (class 1255 OID 16904)
-- Name: ajout_reservation(text, integer, integer, double precision, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.ajout_reservation(text, integer, integer, double precision, integer, integer) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
	DECLARE p_date_debut ALIAS FOR $1;
	DECLARE p_duree ALIAS FOR $2;
	DECLARE p_personne ALIAS FOR $3;
	DECLARE p_cout ALIAS FOR $4;
	DECLARE p_id_client ALIAS FOR $5;
	DECLARE p_id_chambre ALIAS FOR $6;
	
	DECLARE id integer;
	DECLARE retour integer;
	
	DECLARE date_complet_debut date;
	DECLARE date_complet_fin date;

	BEGIN
		date_complet_debut = TO_DATE(p_date_debut, 'DD/MM/YYYY');
		date_complet_fin = date_complet_debut + p_duree;
	
		INSERT INTO reservation(res_date_debut, res_date_fin, personne, cout, id_client, id_chambre)
		VALUES (date_complet_debut, date_complet_fin, p_personne, p_cout, p_id_client, p_id_chambre);
	
		SELECT INTO id id_reservation FROM reservation WHERE res_date_debut = date_complet_debut AND res_date_fin = date_complet_fin;
	
		IF not found THEN
			retour = 0;
		ELSE
			retour = 1;
		END IF;
		
	return retour;
	
	END;
$_$;


ALTER FUNCTION public.ajout_reservation(text, integer, integer, double precision, integer, integer) OWNER TO postgres;

--
-- TOC entry 233 (class 1255 OID 16884)
-- Name: isadmin(text, text); Type: FUNCTION; Schema: public; Owner: jayson
--

CREATE FUNCTION public.isadmin(text, text) RETURNS boolean
    LANGUAGE plpgsql
    AS $_$
	DECLARE p_login alias for $1;
	DECLARE p_pass alias for $2;
	DECLARE id integer;
	DECLARE retour boolean;
	
	BEGIN
		SELECT INTO id id_admin FROM admin WHERE login = p_login AND password = p_pass;
		
		IF NOT FOUND THEN
			retour = false;
		ELSE
			retour = true;
		END IF;
		
		return retour;
	END;
$_$;


ALTER FUNCTION public.isadmin(text, text) OWNER TO jayson;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 229 (class 1259 OID 16876)
-- Name: admin; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.admin (
    id_admin integer NOT NULL,
    login text NOT NULL,
    password text NOT NULL
);


ALTER TABLE public.admin OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 16875)
-- Name: admin_id_admin_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.admin_id_admin_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.admin_id_admin_seq OWNER TO postgres;

--
-- TOC entry 3422 (class 0 OID 0)
-- Dependencies: 228
-- Name: admin_id_admin_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.admin_id_admin_seq OWNED BY public.admin.id_admin;


--
-- TOC entry 215 (class 1259 OID 16779)
-- Name: chambre; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.chambre (
    id_chambre integer NOT NULL,
    nom_chambre character varying(50) NOT NULL,
    prix double precision NOT NULL,
    lit integer,
    description text,
    image_chambre text
);


ALTER TABLE public.chambre OWNER TO postgres;

--
-- TOC entry 214 (class 1259 OID 16778)
-- Name: chambre_id_chambre_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.chambre_id_chambre_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.chambre_id_chambre_seq OWNER TO postgres;

--
-- TOC entry 3423 (class 0 OID 0)
-- Dependencies: 214
-- Name: chambre_id_chambre_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.chambre_id_chambre_seq OWNED BY public.chambre.id_chambre;


--
-- TOC entry 226 (class 1259 OID 16845)
-- Name: chambre_options; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.chambre_options (
    id_chambre integer NOT NULL,
    id_options integer NOT NULL
);


ALTER TABLE public.chambre_options OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 16814)
-- Name: client; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.client (
    id_client integer NOT NULL,
    nom_client character varying(50),
    prenom_client character varying(50),
    mail_client character varying(50),
    rue character varying(50),
    numero_rue integer,
    id_ville integer NOT NULL,
    id_pays integer NOT NULL
);


ALTER TABLE public.client OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 16813)
-- Name: client_id_client_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.client_id_client_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.client_id_client_seq OWNER TO postgres;

--
-- TOC entry 3424 (class 0 OID 0)
-- Dependencies: 223
-- Name: client_id_client_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.client_id_client_seq OWNED BY public.client.id_client;


--
-- TOC entry 220 (class 1259 OID 16801)
-- Name: pays; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pays (
    id_pays integer NOT NULL,
    nom character varying(50) NOT NULL
);


ALTER TABLE public.pays OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 16807)
-- Name: ville; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ville (
    id_ville integer NOT NULL,
    nom character varying(50) NOT NULL
);


ALTER TABLE public.ville OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 16887)
-- Name: clients; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.clients AS
 SELECT cl.id_client,
    cl.nom_client,
    cl.prenom_client,
    cl.mail_client,
    cl.rue,
    cl.numero_rue,
    v.nom AS ville,
    p.nom AS pays
   FROM ((public.client cl
     JOIN public.pays p ON ((cl.id_pays = p.id_pays)))
     JOIN public.ville v ON ((cl.id_ville = v.id_ville)));


ALTER TABLE public.clients OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 16795)
-- Name: employe; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.employe (
    id_employe integer NOT NULL,
    nom_employe character varying(50) NOT NULL,
    prenom_employe character varying(50),
    num_tel_employe integer
);


ALTER TABLE public.employe OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 16794)
-- Name: employe_id_employe_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.employe_id_employe_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.employe_id_employe_seq OWNER TO postgres;

--
-- TOC entry 3425 (class 0 OID 0)
-- Dependencies: 218
-- Name: employe_id_employe_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.employe_id_employe_seq OWNED BY public.employe.id_employe;


--
-- TOC entry 227 (class 1259 OID 16860)
-- Name: entretien; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.entretien (
    id_chambre integer NOT NULL,
    id_employe integer NOT NULL,
    date_entretien date
);


ALTER TABLE public.entretien OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 16788)
-- Name: option; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.option (
    id_options integer NOT NULL,
    nom_options character varying(50),
    supplement double precision
);


ALTER TABLE public.option OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 16787)
-- Name: option_id_options_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.option_id_options_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.option_id_options_seq OWNER TO postgres;

--
-- TOC entry 3426 (class 0 OID 0)
-- Dependencies: 216
-- Name: option_id_options_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.option_id_options_seq OWNED BY public.option.id_options;


--
-- TOC entry 230 (class 1259 OID 16885)
-- Name: pays_id_pays_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pays_id_pays_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.pays_id_pays_seq OWNER TO postgres;

--
-- TOC entry 3427 (class 0 OID 0)
-- Dependencies: 230
-- Name: pays_id_pays_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pays_id_pays_seq OWNED BY public.pays.id_pays;


--
-- TOC entry 232 (class 1259 OID 16891)
-- Name: reservation_id_reservation_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.reservation_id_reservation_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reservation_id_reservation_seq OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 16830)
-- Name: reservation; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reservation (
    res_date_debut date NOT NULL,
    res_date_fin date NOT NULL,
    personne integer,
    cout double precision,
    id_client integer NOT NULL,
    id_chambre integer NOT NULL,
    id_reservation integer DEFAULT nextval('public.reservation_id_reservation_seq'::regclass) NOT NULL
);


ALTER TABLE public.reservation OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 16806)
-- Name: ville_id_ville_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ville_id_ville_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ville_id_ville_seq OWNER TO postgres;

--
-- TOC entry 3428 (class 0 OID 0)
-- Dependencies: 221
-- Name: ville_id_ville_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ville_id_ville_seq OWNED BY public.ville.id_ville;


--
-- TOC entry 3229 (class 2604 OID 16879)
-- Name: admin id_admin; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admin ALTER COLUMN id_admin SET DEFAULT nextval('public.admin_id_admin_seq'::regclass);


--
-- TOC entry 3222 (class 2604 OID 16782)
-- Name: chambre id_chambre; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chambre ALTER COLUMN id_chambre SET DEFAULT nextval('public.chambre_id_chambre_seq'::regclass);


--
-- TOC entry 3227 (class 2604 OID 16817)
-- Name: client id_client; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client ALTER COLUMN id_client SET DEFAULT nextval('public.client_id_client_seq'::regclass);


--
-- TOC entry 3224 (class 2604 OID 16798)
-- Name: employe id_employe; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employe ALTER COLUMN id_employe SET DEFAULT nextval('public.employe_id_employe_seq'::regclass);


--
-- TOC entry 3223 (class 2604 OID 16791)
-- Name: option id_options; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.option ALTER COLUMN id_options SET DEFAULT nextval('public.option_id_options_seq'::regclass);


--
-- TOC entry 3225 (class 2604 OID 16886)
-- Name: pays id_pays; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pays ALTER COLUMN id_pays SET DEFAULT nextval('public.pays_id_pays_seq'::regclass);


--
-- TOC entry 3226 (class 2604 OID 16810)
-- Name: ville id_ville; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ville ALTER COLUMN id_ville SET DEFAULT nextval('public.ville_id_ville_seq'::regclass);


--
-- TOC entry 3414 (class 0 OID 16876)
-- Dependencies: 229
-- Data for Name: admin; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.admin (id_admin, login, password) FROM stdin;
1	admin	admin
\.


--
-- TOC entry 3400 (class 0 OID 16779)
-- Dependencies: 215
-- Data for Name: chambre; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.chambre (id_chambre, nom_chambre, prix, lit, description, image_chambre) FROM stdin;
7	X-Large	60	4	Chambre qui possède beaucoup de lit	Kaboom-xLarge-1.jpg
28	4 Friends	60	4	Chambre modeste pour des amis (friends)	Kaboom-4family-1.jpg
29	4 Family	80	4	Cette chambre possède des lits super posé	Kaboom-friends-1.jpg
30	4 Family – Large	80	4	Grand chambre parfaite pour la famille	Kaboom-4family-large-1.jpg
31	Basic Urban	39	2	Chambre très basique	Kaboom-Basic-urban-1.jpg
32	Medium Urban	45	2	Plus petite que la large	Kaboom-Medium-urban-1.jpg
33	Large Urban	55	2	Chambre plus confortable parfait pour un couple	Kaboom-Large-urban-2.jpg
\.


--
-- TOC entry 3411 (class 0 OID 16845)
-- Dependencies: 226
-- Data for Name: chambre_options; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.chambre_options (id_chambre, id_options) FROM stdin;
28	12
28	13
29	12
29	16
30	12
30	13
30	16
31	12
32	12
32	13
33	12
33	13
33	14
\.


--
-- TOC entry 3409 (class 0 OID 16814)
-- Dependencies: 224
-- Data for Name: client; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.client (id_client, nom_client, prenom_client, mail_client, rue, numero_rue, id_ville, id_pays) FROM stdin;
1	Doe	John	john.doe@gmail.com	Rue du rue	21	1	1
2	Bernard	Jojone	jojo.bernard@gmail.com	Rue du pasrue	14	1	1
\.


--
-- TOC entry 3404 (class 0 OID 16795)
-- Dependencies: 219
-- Data for Name: employe; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.employe (id_employe, nom_employe, prenom_employe, num_tel_employe) FROM stdin;
\.


--
-- TOC entry 3412 (class 0 OID 16860)
-- Dependencies: 227
-- Data for Name: entretien; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.entretien (id_chambre, id_employe, date_entretien) FROM stdin;
\.


--
-- TOC entry 3402 (class 0 OID 16788)
-- Dependencies: 217
-- Data for Name: option; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.option (id_options, nom_options, supplement) FROM stdin;
12	Wifi	10
13	TV	8
14	Mini bar	25
16	Climatisation	25
\.


--
-- TOC entry 3405 (class 0 OID 16801)
-- Dependencies: 220
-- Data for Name: pays; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pays (id_pays, nom) FROM stdin;
1	Belgique
\.


--
-- TOC entry 3410 (class 0 OID 16830)
-- Dependencies: 225
-- Data for Name: reservation; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.reservation (res_date_debut, res_date_fin, personne, cout, id_client, id_chambre, id_reservation) FROM stdin;
2023-06-15	2023-06-22	1	45	2	32	7
\.


--
-- TOC entry 3407 (class 0 OID 16807)
-- Dependencies: 222
-- Data for Name: ville; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ville (id_ville, nom) FROM stdin;
1	Mons
\.


--
-- TOC entry 3429 (class 0 OID 0)
-- Dependencies: 228
-- Name: admin_id_admin_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.admin_id_admin_seq', 1, true);


--
-- TOC entry 3430 (class 0 OID 0)
-- Dependencies: 214
-- Name: chambre_id_chambre_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.chambre_id_chambre_seq', 33, true);


--
-- TOC entry 3431 (class 0 OID 0)
-- Dependencies: 223
-- Name: client_id_client_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.client_id_client_seq', 4, true);


--
-- TOC entry 3432 (class 0 OID 0)
-- Dependencies: 218
-- Name: employe_id_employe_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.employe_id_employe_seq', 1, false);


--
-- TOC entry 3433 (class 0 OID 0)
-- Dependencies: 216
-- Name: option_id_options_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.option_id_options_seq', 16, true);


--
-- TOC entry 3434 (class 0 OID 0)
-- Dependencies: 230
-- Name: pays_id_pays_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pays_id_pays_seq', 1, true);


--
-- TOC entry 3435 (class 0 OID 0)
-- Dependencies: 232
-- Name: reservation_id_reservation_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.reservation_id_reservation_seq', 7, true);


--
-- TOC entry 3436 (class 0 OID 0)
-- Dependencies: 221
-- Name: ville_id_ville_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ville_id_ville_seq', 1, true);


--
-- TOC entry 3245 (class 2606 OID 16849)
-- Name: chambre_options chambre_options_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chambre_options
    ADD CONSTRAINT chambre_options_pkey PRIMARY KEY (id_chambre, id_options);


--
-- TOC entry 3231 (class 2606 OID 16786)
-- Name: chambre chambre_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chambre
    ADD CONSTRAINT chambre_pkey PRIMARY KEY (id_chambre);


--
-- TOC entry 3241 (class 2606 OID 16819)
-- Name: client client_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client
    ADD CONSTRAINT client_pkey PRIMARY KEY (id_client);


--
-- TOC entry 3235 (class 2606 OID 16800)
-- Name: employe employe_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employe
    ADD CONSTRAINT employe_pkey PRIMARY KEY (id_employe);


--
-- TOC entry 3247 (class 2606 OID 16864)
-- Name: entretien entretien_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.entretien
    ADD CONSTRAINT entretien_pkey PRIMARY KEY (id_chambre, id_employe);


--
-- TOC entry 3233 (class 2606 OID 16793)
-- Name: option option_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.option
    ADD CONSTRAINT option_pkey PRIMARY KEY (id_options);


--
-- TOC entry 3237 (class 2606 OID 16805)
-- Name: pays pays_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pays
    ADD CONSTRAINT pays_pkey PRIMARY KEY (id_pays);


--
-- TOC entry 3243 (class 2606 OID 16898)
-- Name: reservation reservation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservation
    ADD CONSTRAINT reservation_pkey PRIMARY KEY (res_date_debut, res_date_fin);


--
-- TOC entry 3239 (class 2606 OID 16812)
-- Name: ville ville_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ville
    ADD CONSTRAINT ville_pkey PRIMARY KEY (id_ville);


--
-- TOC entry 3252 (class 2606 OID 16850)
-- Name: chambre_options chambre_options_id_chambre_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chambre_options
    ADD CONSTRAINT chambre_options_id_chambre_fkey FOREIGN KEY (id_chambre) REFERENCES public.chambre(id_chambre);


--
-- TOC entry 3253 (class 2606 OID 16855)
-- Name: chambre_options chambre_options_id_options_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chambre_options
    ADD CONSTRAINT chambre_options_id_options_fkey FOREIGN KEY (id_options) REFERENCES public.option(id_options);


--
-- TOC entry 3248 (class 2606 OID 16825)
-- Name: client client_id_pays_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client
    ADD CONSTRAINT client_id_pays_fkey FOREIGN KEY (id_pays) REFERENCES public.pays(id_pays);


--
-- TOC entry 3249 (class 2606 OID 16820)
-- Name: client client_id_ville_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client
    ADD CONSTRAINT client_id_ville_fkey FOREIGN KEY (id_ville) REFERENCES public.ville(id_ville);


--
-- TOC entry 3254 (class 2606 OID 16865)
-- Name: entretien entretien_id_chambre_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.entretien
    ADD CONSTRAINT entretien_id_chambre_fkey FOREIGN KEY (id_chambre) REFERENCES public.chambre(id_chambre);


--
-- TOC entry 3255 (class 2606 OID 16870)
-- Name: entretien entretien_id_employe_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.entretien
    ADD CONSTRAINT entretien_id_employe_fkey FOREIGN KEY (id_employe) REFERENCES public.employe(id_employe);


--
-- TOC entry 3250 (class 2606 OID 16840)
-- Name: reservation reservation_id_chambre_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservation
    ADD CONSTRAINT reservation_id_chambre_fkey FOREIGN KEY (id_chambre) REFERENCES public.chambre(id_chambre);


--
-- TOC entry 3251 (class 2606 OID 16835)
-- Name: reservation reservation_id_client_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservation
    ADD CONSTRAINT reservation_id_client_fkey FOREIGN KEY (id_client) REFERENCES public.client(id_client);


-- Completed on 2023-06-10 13:46:19

--
-- PostgreSQL database dump complete
--

