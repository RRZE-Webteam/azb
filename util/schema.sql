--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.5
-- Dumped by pg_dump version 9.3.10
-- Started on 2015-12-11 11:37:25 CET

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;


CREATE SEQUENCE bewerbungsnummern
  INCREMENT 1
  MINVALUE 10000000
  MAXVALUE 99999999
  START 10000000
  CACHE 1;

CREATE SEQUENCE praktika_ids
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;

CREATE SEQUENCE upload_ids
  INCREMENT 1
  MINVALUE 10000
  MAXVALUE 99999
  START 10000
  CACHE 1;
--
-- TOC entry 211 (class 1259 OID 583447588)
-- Name: bewerbung; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE bewerbung (
    bewerbungsnummer bigint DEFAULT nextval('bewerbungsnummern'::regclass) NOT NULL,
    anrede character varying NOT NULL,
    vorname character varying NOT NULL,
    nachname character varying NOT NULL,
    adresse character varying,
    ort character varying,
    email character varying(256),
    telnummer character varying,
    geburtsdatum date,
    notendurchschnitt_schulabschluss numeric(3,2) DEFAULT 0,
    berufsausbildung text,
    studium text,
    note_deutsch smallint,
    note_englisch smallint,
    note_mathematik smallint,
    note_informatik smallint,
    hobbys text,
    angestrebter_abschluss character varying DEFAULT 'keiner'::character varying,
    erworbener_abschluss character varying DEFAULT 'keiner'::character varying,
    datum timestamp with time zone DEFAULT now() NOT NULL,
    kenntnisse_office smallint DEFAULT 0,
    kenntnisse_betriebssysteme smallint DEFAULT 0,
    kenntnisse_netzwerke smallint DEFAULT 0,
    kenntnisse_hardware smallint DEFAULT 0,
    anmerkungen text,
    kenntnisse_hardware_txt text,
    kenntnisse_office_txt text,
    kenntnisse_betriebssysteme_txt text,
    kenntnisse_netzwerke_txt text,
    frontendkey uuid,
    abgeschlossen boolean DEFAULT false NOT NULL,
    ist_bestaetigt boolean DEFAULT false,
    passwort character varying(128),
    passwort_wiederherstellen_token character varying,
    passwort_wiederherstellen_datum timestamp with time zone,
    invalid_uploads boolean DEFAULT true NOT NULL,
    postleitzahl character varying,
    zurueckgezogen boolean DEFAULT false NOT NULL,
    current_step integer DEFAULT 0 NOT NULL
);


--
-- TOC entry 2174 (class 0 OID 0)
-- Dependencies: 211
-- Name: COLUMN bewerbung.abgeschlossen; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN bewerbung.abgeschlossen IS 'steht auf true sobald die Bewerbung im Frontend vollstaendig abgeschlossen ist (muss Bewerber selbst entscheiden)';


--
-- TOC entry 189 (class 1259 OID 583438523)
-- Name: ci_session; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE ci_session (
    id character varying(40) NOT NULL,
    ip_address character varying(45) NOT NULL,
    "timestamp" bigint DEFAULT 0 NOT NULL,
    data text DEFAULT ''::text NOT NULL
);


SET default_with_oids = true;

--
-- TOC entry 212 (class 1259 OID 583447612)
-- Name: praktika; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE praktika (
    firma text,
    dauer integer,
    taetigkeit text NOT NULL,
    zu_bewerbung bigint,
    praktikum_id bigint DEFAULT nextval('praktika_ids'::regclass) NOT NULL
);


SET default_with_oids = false;

--
-- TOC entry 213 (class 1259 OID 583447619)
-- Name: uploads; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE uploads (
    subjekt character varying(64) NOT NULL,
    upload_id bigint DEFAULT nextval('upload_ids'::regclass) NOT NULL,
    dateiname character varying(128) NOT NULL,
    kommentar text,
    zu_bewerbung bigint NOT NULL,
    content bytea,
    mime_type character varying
);


--
-- TOC entry 2053 (class 2606 OID 583438532)
-- Name: ci_sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY ci_session
    ADD CONSTRAINT ci_sessions_pkey PRIMARY KEY (id);


--
-- TOC entry 2058 (class 2606 OID 583447636)
-- Name: pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY praktika
    ADD CONSTRAINT pk PRIMARY KEY (praktikum_id);


--
-- TOC entry 2056 (class 2606 OID 583447638)
-- Name: pk_bewerbung; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY bewerbung
    ADD CONSTRAINT pk_bewerbung PRIMARY KEY (bewerbungsnummer);


--
-- TOC entry 2060 (class 2606 OID 583447640)
-- Name: upload_id; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY uploads
    ADD CONSTRAINT upload_id PRIMARY KEY (upload_id);


--
-- TOC entry 2054 (class 1259 OID 583438533)
-- Name: ci_sessions_timestamp; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX ci_sessions_timestamp ON ci_session USING btree ("timestamp");


--
-- TOC entry 2061 (class 2606 OID 583447641)
-- Name: fk_bewerbung; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY praktika
    ADD CONSTRAINT fk_bewerbung FOREIGN KEY (zu_bewerbung) REFERENCES bewerbung(bewerbungsnummer);


--
-- TOC entry 2062 (class 2606 OID 583447646)
-- Name: fk_bewerbung; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY uploads
    ADD CONSTRAINT fk_bewerbung FOREIGN KEY (zu_bewerbung) REFERENCES bewerbung(bewerbungsnummer);


-- Completed on 2015-12-11 11:37:26 CET

--
-- PostgreSQL database dump complete
--

