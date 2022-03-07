--
-- PostgreSQL database dump
--

-- Dumped from database version 10.20
-- Dumped by pg_dump version 10.20

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
-- Name: DATABASE postgres; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON DATABASE postgres IS 'default administrative connection database';


--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- Name: adminpack; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS adminpack WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION adminpack; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION adminpack IS 'administrative functions for PostgreSQL';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: newtables; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.newtables (
    folio character varying,
    nombre character varying,
    direccion character varying,
    numero_registro character varying,
    nombre_apoderado character varying,
    escritura_apoderado character varying,
    fecha_apoderado character varying,
    notaria_apoderado character varying,
    escritura_constitutiva character varying,
    fecha_constitutiva character varying,
    notaria_constitutiva character varying,
    shcp_registro character varying,
    imss_registro character varying,
    infonavit_registro character varying,
    otras_especialidades character varying,
    capital money,
    fecha_constancia character varying,
    invitaciones_restringidas boolean,
    puesto_autoriza character varying,
    nombre_autoriza character varying,
    telefono character varying,
    especialidades character varying
);


ALTER TABLE public.newtables OWNER TO postgres;

--
-- Data for Name: newtables; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.newtables (folio, nombre, direccion, numero_registro, nombre_apoderado, escritura_apoderado, fecha_apoderado, notaria_apoderado, escritura_constitutiva, fecha_constitutiva, notaria_constitutiva, shcp_registro, imss_registro, infonavit_registro, otras_especialidades, capital, fecha_constancia, invitaciones_restringidas, puesto_autoriza, nombre_autoriza, telefono, especialidades) FROM stdin;
006	Mantenimiento, Construcción eInstalaciones de Inmuebles, S.A. de C.V.	Puerto Tlacotalpan no.12-2Col. Casas Aleman, Delg. Gustavo A. Madero México, D. F, C. P. 07580	GDF-SOS-059	Emma Sánchez González  	92324	1997-02-11 00:00:00	3	92324	1997-02-11 00:00:00	3	MCI 970212 M88	C35 30142 10	150905211	 	$4,871,717.00	2002-08-05 00:00:00	t	Coordinador Sectorial de Normas,Especificaciones y Precios Unitarios	Ing. Eduardo Gutiérrez Rodríguez 	5 753 81 69	Hidráulicas y Sanitarias,Vialidad Superficial,Vialidad y Transporte,Servicios Urbanos y Vivienda
032	Desarrollos Habitacionales, S.A. de C.V.	Segunda Cerrada del Parque No. 10-BCol. General AnayaMéxico, D.F., C.P. 03340	GDF-SOS-069	Lic. Joel Palma Gutiérrez 	792	1993-11-04 00:00:00	1, Chilapa, Gro.	3050	1997-08-14 00:00:00	1, Chilapa, Gro.	DHS 931104 V33	F34 25929 10	34 2592910	Mantenimiento en general y Construcción de viviendas y escuelas	$6,142,894.76	2000-07-28 00:00:00	t	Coordinador Sectorial de Normas,Especificaciones y Precios Unitarios	Ing. Francisco J. Montellano Magra	5 688 30 04	Hifráulicas y Sanitarias, Vialidad Superf.y de Transporte, Servicios UrbanosVivienda, Proyectos, Coord. Superv.,Supervisión de Estudios y Proyectos, Admín. Obras, Gestión y Consultorías
049	Servicios de Apoyo Técnico yConstrucciones, S.A. de C.V.	Calle 643 No. 2244a. y 5a. Sección de San Juan de AragónGustavo A. Madero, D.F., C.P. 07920	GDF-SOS-104	Ing. Oscar Clemente Muñoz 	153558	1993-06-15 00:00:00	6	153558	1993-06-15 00:00:00	6	SAT 930615 DU1	Y56 23578 10 0	09 29854 83	Otras (Especificar) Elaboración de licitaciones, costos y P.U.	$1,230,903.00	1999-04-15 00:00:00	t	Coordinador Sectorial de Normas,Especificaciones y Precios Unitarios	Ing. Francisco J. Montellano Magra	5 766 43 95	Hidráulicas y Sanitarias,Vialidad Superficial, Vivienda,Estudios Previos y Técnicos,Supervisión de obras, estudios y proyectos, Coordinación de Supervisión,
 094 Bis	MESBA, Ingeniería yConstrucciones, S.A. de C.V.	Privada del Clavel No. 3, AltosCol. Ejidos de HuipulcoTlalpan, D.F., C.P. 14380	GDF-SOS-390	Ing. Fernando Espada Ortega	37749	1991-03-12 00:00:00	5	14496	1996-11-07 00:00:00	14, Texcoco, Méx.	MIC 910313 FJ6	Y68 36505 10 4	09 299982 4	Otras (Especificar) Mantenimiento a pilotes de control,	$2,055,491.00	2002-06-28 00:00:00	t	Coordinador Sectorial de Normas,Especificaciones y Precios Unitarios	Ing. Eduardo Gutiérrez Rodríguez 	5 671 44 54 Fax	Hidráulicas y Sanitarias, Vialidad Superficialy de Transporte, Servicios Urbanos,Vivienda, Estudios Previos y Técnicos,Supervisión de obras, estudios y proyectos, Proyectos, Coord. Superv., Admón. Obras,
ILEGIBLE	Javier González Alvarado 	Central No. 32Col. Barrio Norte, Delg. Alvaro Obregón México, D.F, C.P. 01410	GDF-SOS-3712	 	ILEGIBLE	ILEGIBLE	ILEGIBLE	ILEGIBLE	ILEGIBLE	ILEGIBLE	GOAJ 660515 542	Y64 40284 10 4	Y64 40284 10 4	Arquitectura del paisaje  	$1,415,439.00	2004-08-10 00:00:00	t	Coordinador Sectorial de Normas,Especificaciones y Precios Unitarios	Ing. Eduardo Esquivel Herrera	5 257 28 52	Líneas Primarias y Secundarias, Guarniciones y Banquetas, Edificación, Urbanización en Gral., Vivienda,  
ILEGIBLE	Grupo Edificador Fortio, S.A. de C.V.	Cellejón de Ecuador No.121, Despacho "D",Col. Centro, Delegación Cuauhtémoc,México, D.F., C.P. 06020	GDF-SOS-5195	Monica Margarita Rojas  Olvera	7406	2000-03-18 00:00:00	2 Atotonilco el Grande,Hidalgo	7406	2000-03-18 00:00:00	2 Atotonilco el Grande,Hidalgo	GEF 000318 EP7	Y58 295442 10 8	Y58 295442 10 8	Mantenimiento de edificaciones 	$2,919,891.00	2005-05-13 00:00:00	t	Coordinador Sectorial de Normas,Especificaciones y Precios Unitarios	Ing. Eduardo Esquivel Herrera	53 96 10 65	Edificación, Proyectos de edificación, Supervisión de edificación, Pavimentación, Guarniciones y Banquetas 
\.


--
-- PostgreSQL database dump complete
--

