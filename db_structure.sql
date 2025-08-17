--
-- PostgreSQL database dump
--

-- Dumped from database version 17.5 (Debian 17.5-1.pgdg120+1)
-- Dumped by pg_dump version 17.5 (Debian 17.5-1.pgdg120+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: xgroups; Type: SCHEMA; Schema: -; Owner: neo
--

CREATE SCHEMA xgroups;


ALTER SCHEMA xgroups OWNER TO neo;

--
-- Name: delete_user_astro_info(); Type: FUNCTION; Schema: public; Owner: neo
--

CREATE FUNCTION public.delete_user_astro_info() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    DELETE FROM xgroups.userastroinfo WHERE userid = OLD.userid;
    RETURN OLD;
END;
$$;


ALTER FUNCTION public.delete_user_astro_info() OWNER TO neo;

--
-- Name: delete_user_birth_info(); Type: FUNCTION; Schema: public; Owner: neo
--

CREATE FUNCTION public.delete_user_birth_info() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    DELETE FROM xgroups.userbirthinfo WHERE userid = OLD.userid;
    RETURN OLD;
END;
$$;


ALTER FUNCTION public.delete_user_birth_info() OWNER TO neo;

--
-- Name: delete_user_chat_messages(); Type: FUNCTION; Schema: public; Owner: neo
--

CREATE FUNCTION public.delete_user_chat_messages() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    DELETE FROM xgroups.userchatmessages WHERE sender_id = OLD.userid;
    RETURN OLD;
END;
$$;


ALTER FUNCTION public.delete_user_chat_messages() OWNER TO neo;

--
-- Name: delete_user_interests(); Type: FUNCTION; Schema: public; Owner: neo
--

CREATE FUNCTION public.delete_user_interests() RETURNS trigger
    LANGUAGE plpgsql
    AS $$                                            
 BEGIN                                                    
     DELETE FROM xgroups.userinterests WHERE userid = OLD.userid; 
     RETURN OLD;                                          
 END;                                                     
 $$;


ALTER FUNCTION public.delete_user_interests() OWNER TO neo;

--
-- Name: delete_user_matches(); Type: FUNCTION; Schema: public; Owner: neo
--

CREATE FUNCTION public.delete_user_matches() RETURNS trigger
    LANGUAGE plpgsql
    AS $$                                           
 BEGIN                                                   
     DELETE FROM xgroups.usermatches WHERE usera_id = OLD.userid;
     RETURN OLD;                                         
 END;                                                    
 $$;


ALTER FUNCTION public.delete_user_matches() OWNER TO neo;

--
-- Name: delete_user_prof_info(); Type: FUNCTION; Schema: public; Owner: neo
--

CREATE FUNCTION public.delete_user_prof_info() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    DELETE FROM xgroups.userprofinfo WHERE userid = OLD.userid;
    RETURN OLD;
END;
$$;


ALTER FUNCTION public.delete_user_prof_info() OWNER TO neo;

--
-- Name: populate_user_astro_info(); Type: FUNCTION; Schema: public; Owner: neo
--

CREATE FUNCTION public.populate_user_astro_info() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    INSERT INTO xgroups.userastroinfo (userid) VALUES (NEW.userid);
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.populate_user_astro_info() OWNER TO neo;

--
-- Name: populate_user_birth_info(); Type: FUNCTION; Schema: public; Owner: neo
--

CREATE FUNCTION public.populate_user_birth_info() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    userExists INTEGER;
BEGIN
    SELECT COUNT(*) INTO userExists FROM xgroups.userbirthinfo WHERE userid = NEW.userid;
    IF userExists = 0 THEN
        INSERT INTO xgroups.userbirthinfo (userid, timezone) VALUES (NEW.userid, 1);
    END IF;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.populate_user_birth_info() OWNER TO neo;

--
-- Name: populate_user_interests(); Type: FUNCTION; Schema: public; Owner: neo
--

CREATE FUNCTION public.populate_user_interests() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    INSERT INTO xgroups.userinterests (userid) VALUES (NEW.userid);
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.populate_user_interests() OWNER TO neo;

--
-- Name: populate_user_prof_info(); Type: FUNCTION; Schema: public; Owner: neo
--

CREATE FUNCTION public.populate_user_prof_info() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    INSERT INTO xgroups.userprofinfo (userid, username) VALUES (NEW.userid, NEW.username);
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.populate_user_prof_info() OWNER TO neo;

--
-- Name: update_day_month_year(); Type: FUNCTION; Schema: public; Owner: neo
--

CREATE FUNCTION public.update_day_month_year() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.day := SPLIT_PART(NEW.birthdate, '/', 1);
    NEW.month := SPLIT_PART(NEW.birthdate, '/', 2);
    NEW.year := SPLIT_PART(NEW.birthdate, '/', 3);
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_day_month_year() OWNER TO neo;

--
-- Name: update_hour_minute_function(); Type: FUNCTION; Schema: public; Owner: neo
--

CREATE FUNCTION public.update_hour_minute_function() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    -- Extract the hour from the birthTime column
    NEW.hour := SPLIT_PART(NEW.birthtime, ':', 1);
    
    -- Extract the minute from the birthTime column
    NEW.minute := SPLIT_PART(NEW.birthtime, ':', 2);

    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_hour_minute_function() OWNER TO neo;

--
-- Name: update_updated_at_column(); Type: FUNCTION; Schema: public; Owner: neo
--

CREATE FUNCTION public.update_updated_at_column() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
   NEW.updated_at = NOW();
   RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_updated_at_column() OWNER TO neo;

--
-- Name: command; Type: SEQUENCE; Schema: public; Owner: neo
--

CREATE SEQUENCE public.command
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.command OWNER TO neo;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: migrations; Type: TABLE; Schema: public; Owner: neo
--

CREATE TABLE public.migrations (
    id bigint NOT NULL,
    version character varying(255) NOT NULL,
    class character varying(255) NOT NULL,
    "group" character varying(255) NOT NULL,
    namespace character varying(255) NOT NULL,
    "time" integer NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO neo;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: neo
--

CREATE SEQUENCE public.migrations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO neo;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neo
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: match_scores_eb_eb_full_weights; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.match_scores_eb_eb_full_weights (
    id character(2) NOT NULL,
    score integer NOT NULL,
    compared integer NOT NULL
);


ALTER TABLE xgroups.match_scores_eb_eb_full_weights OWNER TO neo;

--
-- Name: match_scores_eb_eb_scores; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.match_scores_eb_eb_scores (
    id character varying(2) NOT NULL,
    score bigint NOT NULL,
    compared bigint NOT NULL
);


ALTER TABLE xgroups.match_scores_eb_eb_scores OWNER TO neo;

--
-- Name: match_scores_eb_eb_weights; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.match_scores_eb_eb_weights (
    id character varying(2) NOT NULL,
    score bigint NOT NULL,
    compared bigint NOT NULL
);


ALTER TABLE xgroups.match_scores_eb_eb_weights OWNER TO neo;

--
-- Name: match_scores_hs_hs_full_weights; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.match_scores_hs_hs_full_weights (
    id character(2) NOT NULL,
    score integer NOT NULL,
    compared integer NOT NULL
);


ALTER TABLE xgroups.match_scores_hs_hs_full_weights OWNER TO neo;

--
-- Name: match_scores_hs_hs_scores; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.match_scores_hs_hs_scores (
    id character varying(2) NOT NULL,
    score bigint NOT NULL,
    compared bigint NOT NULL
);


ALTER TABLE xgroups.match_scores_hs_hs_scores OWNER TO neo;

--
-- Name: match_scores_hs_hs_weights; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.match_scores_hs_hs_weights (
    id character varying(2) NOT NULL,
    score bigint NOT NULL,
    compared bigint NOT NULL
);


ALTER TABLE xgroups.match_scores_hs_hs_weights OWNER TO neo;

--
-- Name: match_scores_my_scores; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.match_scores_my_scores (
    docu smallint DEFAULT 2,
    dana smallint DEFAULT 5,
    dant smallint DEFAULT '-2'::integer,
    ddes smallint DEFAULT 1,
    dgui smallint DEFAULT 3
);


ALTER TABLE xgroups.match_scores_my_scores OWNER TO neo;

--
-- Name: match_scores_my_weights; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.match_scores_my_weights (
    docu smallint DEFAULT 1,
    dana smallint DEFAULT 1,
    dant smallint DEFAULT 1,
    ddes smallint DEFAULT 1,
    dgui smallint DEFAULT 1
);


ALTER TABLE xgroups.match_scores_my_weights OWNER TO neo;

--
-- Name: match_scores_na_na_scores; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.match_scores_na_na_scores (
    id character varying(2) NOT NULL,
    score bigint NOT NULL,
    compared bigint NOT NULL
);


ALTER TABLE xgroups.match_scores_na_na_scores OWNER TO neo;

--
-- Name: match_scores_zd_zd_scores; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.match_scores_zd_zd_scores (
    id character varying(2) NOT NULL,
    score bigint NOT NULL,
    compared bigint NOT NULL
);


ALTER TABLE xgroups.match_scores_zd_zd_scores OWNER TO neo;

--
-- Name: match_scores_zd_zd_weights; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.match_scores_zd_zd_weights (
    id character varying(2) NOT NULL,
    score bigint NOT NULL,
    compared bigint NOT NULL
);


ALTER TABLE xgroups.match_scores_zd_zd_weights OWNER TO neo;

--
-- Name: userastroinfo; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.userastroinfo (
    userid bigint NOT NULL,
    element integer DEFAULT 1 NOT NULL,
    hs_hour character varying(20) DEFAULT NULL::character varying,
    eb_hour character varying(20) DEFAULT NULL::character varying,
    eb_hour_eng character varying(10) DEFAULT NULL::character varying,
    hs_day character varying(20) DEFAULT NULL::character varying,
    eb_day character varying(20) DEFAULT NULL::character varying,
    eb_day_eng character varying(10) DEFAULT NULL::character varying,
    hs_month character varying(20) DEFAULT NULL::character varying,
    eb_month character varying(20) DEFAULT NULL::character varying,
    eb_month_eng character varying(10) DEFAULT NULL::character varying,
    hs_year character varying(20) DEFAULT NULL::character varying,
    eb_year character varying(20) DEFAULT NULL::character varying,
    eb_year_eng character varying(10) DEFAULT NULL::character varying,
    season character varying(20) DEFAULT NULL::character varying,
    kin_tone character varying(20) DEFAULT NULL::character varying,
    kin_seal character varying(20) DEFAULT NULL::character varying,
    kin_number character varying(20) DEFAULT NULL::character varying,
    sun character varying(20) DEFAULT NULL::character varying,
    ascendant character varying(20) DEFAULT NULL::character varying,
    moon character varying(20) DEFAULT NULL::character varying,
    guide_seal character varying(255),
    guide_tone character varying(255),
    analogue_seal character varying(255),
    analogue_tone character varying(255),
    antipode_seal character varying(255),
    antipode_tone character varying(255),
    occult_seal character varying(255),
    occult_tone character varying(255),
    tribe character varying(255),
    a_tribe character varying(255),
    wavespell jsonb
);
ALTER TABLE ONLY xgroups.userastroinfo ALTER COLUMN wavespell SET STORAGE PLAIN;


ALTER TABLE xgroups.userastroinfo OWNER TO neo;

--
-- Name: userbirthinfo; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.userbirthinfo (
    userid bigint NOT NULL,
    sex character(1) DEFAULT NULL::bpchar,
    month character(2) DEFAULT NULL::bpchar,
    day character(2) DEFAULT NULL::bpchar,
    year character varying(4) DEFAULT NULL::character varying,
    birthdate character varying(16) DEFAULT '01/01/2024'::character varying,
    hour character(2) DEFAULT NULL::bpchar,
    minute character(2) DEFAULT NULL::bpchar,
    birthtime character varying(6) DEFAULT NULL::character varying,
    unknowntime integer,
    timezone character varying(10) DEFAULT '1'::character varying,
    timezone_txt character varying(30) DEFAULT NULL::character varying,
    city character varying(255) DEFAULT NULL::character varying,
    birthcountry character varying(20) DEFAULT NULL::character varying,
    long_deg character(3) DEFAULT NULL::bpchar,
    long_min character(2) DEFAULT NULL::bpchar,
    ew character(2) DEFAULT NULL::bpchar,
    lat_deg character(2) DEFAULT NULL::bpchar,
    lat_min character(2) DEFAULT NULL::bpchar,
    ns character(2) DEFAULT NULL::bpchar,
    long_secs character varying(20) DEFAULT NULL::character varying,
    lat_secs character varying(15) DEFAULT NULL::character varying,
    lon character varying(255),
    lat character varying(255)
);


ALTER TABLE xgroups.userbirthinfo OWNER TO neo;

--
-- Name: userbirthinfo_userid_seq; Type: SEQUENCE; Schema: xgroups; Owner: neo
--

CREATE SEQUENCE xgroups.userbirthinfo_userid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE xgroups.userbirthinfo_userid_seq OWNER TO neo;

--
-- Name: userbirthinfo_userid_seq; Type: SEQUENCE OWNED BY; Schema: xgroups; Owner: neo
--

ALTER SEQUENCE xgroups.userbirthinfo_userid_seq OWNED BY xgroups.userbirthinfo.userid;


--
-- Name: userchatmessages; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.userchatmessages (
    messageid character varying(200) NOT NULL,
    sender_id bigint,
    receiver_id bigint,
    message text,
    "timestamp" timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    read_status boolean DEFAULT false
);


ALTER TABLE xgroups.userchatmessages OWNER TO neo;

--
-- Name: userinterests; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.userinterests (
    userid bigint NOT NULL,
    interests text DEFAULT '{}'::text NOT NULL,
    lookingfor character varying(255) DEFAULT 'Not set'::character varying
);


ALTER TABLE xgroups.userinterests OWNER TO neo;

--
-- Name: userinterests_userid_seq; Type: SEQUENCE; Schema: xgroups; Owner: neo
--

CREATE SEQUENCE xgroups.userinterests_userid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE xgroups.userinterests_userid_seq OWNER TO neo;

--
-- Name: userinterests_userid_seq; Type: SEQUENCE OWNED BY; Schema: xgroups; Owner: neo
--

ALTER SEQUENCE xgroups.userinterests_userid_seq OWNED BY xgroups.userinterests.userid;


--
-- Name: usermatches; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.usermatches (
    usera_id bigint NOT NULL,
    userb_id bigint NOT NULL,
    matchid text NOT NULL,
    score_cn bigint NOT NULL,
    score_my bigint NOT NULL,
    score_zd bigint NOT NULL,
    score_hd bigint NOT NULL,
    score_num bigint NOT NULL,
    score_total integer NOT NULL
);


ALTER TABLE xgroups.usermatches OWNER TO neo;

--
-- Name: userprofinfo; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.userprofinfo (
    userid bigint NOT NULL,
    profession character varying(20) DEFAULT NULL::character varying,
    "position" character varying(20) DEFAULT NULL::character varying,
    sector character varying(20) DEFAULT NULL::character varying,
    username character varying(20)
);


ALTER TABLE xgroups.userprofinfo OWNER TO neo;

--
-- Name: users; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.users (
    userid bigint NOT NULL,
    created_at bigint,
    deleted_at timestamp with time zone,
    new integer DEFAULT 1,
    username character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    name character varying(255) DEFAULT NULL::character varying,
    surname character varying(50) DEFAULT NULL::character varying,
    sex character varying(255) DEFAULT NULL::character varying,
    looking character varying(255) DEFAULT NULL::character varying,
    profilepicture character varying(100) DEFAULT NULL::character varying,
    aboutme text,
    data_visibility text NOT NULL,
    active boolean DEFAULT false,
    verification_code character varying(32),
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    verification_token character varying(255),
    is_active boolean DEFAULT false,
    language character varying(10) DEFAULT 'en'::character varying NOT NULL
);


ALTER TABLE xgroups.users OWNER TO neo;

--
-- Name: users_backup; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.users_backup (
    userid bigint DEFAULT '0'::bigint NOT NULL,
    created_at bigint,
    deleted_at timestamp with time zone,
    new integer DEFAULT 1,
    username character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    name character varying(255) DEFAULT NULL::character varying,
    surname character varying(50) DEFAULT NULL::character varying,
    sex character varying(255) DEFAULT NULL::character varying,
    looking character varying(255) DEFAULT NULL::character varying,
    profilepicture character varying(100) DEFAULT NULL::character varying,
    aboutme text,
    data_visibility text DEFAULT '{}'::text
);


ALTER TABLE xgroups.users_backup OWNER TO neo;

--
-- Name: users_userid_seq; Type: SEQUENCE; Schema: xgroups; Owner: neo
--

CREATE SEQUENCE xgroups.users_userid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE xgroups.users_userid_seq OWNER TO neo;

--
-- Name: users_userid_seq; Type: SEQUENCE OWNED BY; Schema: xgroups; Owner: neo
--

ALTER SEQUENCE xgroups.users_userid_seq OWNED BY xgroups.users.userid;


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: neo
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: userbirthinfo userid; Type: DEFAULT; Schema: xgroups; Owner: neo
--

ALTER TABLE ONLY xgroups.userbirthinfo ALTER COLUMN userid SET DEFAULT nextval('xgroups.userbirthinfo_userid_seq'::regclass);


--
-- Name: userinterests userid; Type: DEFAULT; Schema: xgroups; Owner: neo
--

ALTER TABLE ONLY xgroups.userinterests ALTER COLUMN userid SET DEFAULT nextval('xgroups.userinterests_userid_seq'::regclass);


--
-- Name: users userid; Type: DEFAULT; Schema: xgroups; Owner: neo
--

ALTER TABLE ONLY xgroups.users ALTER COLUMN userid SET DEFAULT nextval('xgroups.users_userid_seq'::regclass);


--
-- Name: migrations pk_migrations; Type: CONSTRAINT; Schema: public; Owner: neo
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT pk_migrations PRIMARY KEY (id);


--
-- Name: userastroinfo idx_16422_primary; Type: CONSTRAINT; Schema: xgroups; Owner: neo
--

ALTER TABLE ONLY xgroups.userastroinfo
    ADD CONSTRAINT idx_16422_primary PRIMARY KEY (userid);


--
-- Name: userbirthinfo idx_16446_primary; Type: CONSTRAINT; Schema: xgroups; Owner: neo
--

ALTER TABLE ONLY xgroups.userbirthinfo
    ADD CONSTRAINT idx_16446_primary PRIMARY KEY (userid);


--
-- Name: userchatmessages idx_16470_primary; Type: CONSTRAINT; Schema: xgroups; Owner: neo
--

ALTER TABLE ONLY xgroups.userchatmessages
    ADD CONSTRAINT idx_16470_primary PRIMARY KEY (messageid);


--
-- Name: userinterests idx_16477_primary; Type: CONSTRAINT; Schema: xgroups; Owner: neo
--

ALTER TABLE ONLY xgroups.userinterests
    ADD CONSTRAINT idx_16477_primary PRIMARY KEY (userid);


--
-- Name: usermatches idx_16484_primary; Type: CONSTRAINT; Schema: xgroups; Owner: neo
--

ALTER TABLE ONLY xgroups.usermatches
    ADD CONSTRAINT idx_16484_primary PRIMARY KEY (matchid);


--
-- Name: userprofinfo idx_16489_primary; Type: CONSTRAINT; Schema: xgroups; Owner: neo
--

ALTER TABLE ONLY xgroups.userprofinfo
    ADD CONSTRAINT idx_16489_primary PRIMARY KEY (userid);


--
-- Name: users idx_16496_primary; Type: CONSTRAINT; Schema: xgroups; Owner: neo
--

ALTER TABLE ONLY xgroups.users
    ADD CONSTRAINT idx_16496_primary PRIMARY KEY (userid);


--
-- Name: match_scores_eb_eb_full_weights match_scores_eb_eb_full_weights_pkey; Type: CONSTRAINT; Schema: xgroups; Owner: neo
--

ALTER TABLE ONLY xgroups.match_scores_eb_eb_full_weights
    ADD CONSTRAINT match_scores_eb_eb_full_weights_pkey PRIMARY KEY (id);


--
-- Name: match_scores_hs_hs_full_weights match_scores_hs_hs_full_weights_pkey; Type: CONSTRAINT; Schema: xgroups; Owner: neo
--

ALTER TABLE ONLY xgroups.match_scores_hs_hs_full_weights
    ADD CONSTRAINT match_scores_hs_hs_full_weights_pkey PRIMARY KEY (id);


--
-- Name: idx_16470_idx_receiver; Type: INDEX; Schema: xgroups; Owner: neo
--

CREATE INDEX idx_16470_idx_receiver ON xgroups.userchatmessages USING btree (receiver_id);


--
-- Name: idx_16470_idx_sender; Type: INDEX; Schema: xgroups; Owner: neo
--

CREATE INDEX idx_16470_idx_sender ON xgroups.userchatmessages USING btree (sender_id);


--
-- Name: idx_16470_idx_timestamp; Type: INDEX; Schema: xgroups; Owner: neo
--

CREATE INDEX idx_16470_idx_timestamp ON xgroups.userchatmessages USING btree ("timestamp");


--
-- Name: users delete_user_astro_info_trigger; Type: TRIGGER; Schema: xgroups; Owner: neo
--

CREATE TRIGGER delete_user_astro_info_trigger BEFORE DELETE ON xgroups.users FOR EACH ROW EXECUTE FUNCTION public.delete_user_astro_info();


--
-- Name: users delete_user_birth_info_trigger; Type: TRIGGER; Schema: xgroups; Owner: neo
--

CREATE TRIGGER delete_user_birth_info_trigger BEFORE DELETE ON xgroups.users FOR EACH ROW EXECUTE FUNCTION public.delete_user_birth_info();


--
-- Name: users delete_user_chat_messages_trigger; Type: TRIGGER; Schema: xgroups; Owner: neo
--

CREATE TRIGGER delete_user_chat_messages_trigger BEFORE DELETE ON xgroups.users FOR EACH ROW EXECUTE FUNCTION public.delete_user_chat_messages();


--
-- Name: users delete_user_interests_trigger; Type: TRIGGER; Schema: xgroups; Owner: neo
--

CREATE TRIGGER delete_user_interests_trigger BEFORE DELETE ON xgroups.users FOR EACH ROW EXECUTE FUNCTION public.delete_user_interests();


--
-- Name: users delete_user_matches_trigger; Type: TRIGGER; Schema: xgroups; Owner: neo
--

CREATE TRIGGER delete_user_matches_trigger BEFORE DELETE ON xgroups.users FOR EACH ROW EXECUTE FUNCTION public.delete_user_matches();


--
-- Name: users delete_user_prof_info_trigger; Type: TRIGGER; Schema: xgroups; Owner: neo
--

CREATE TRIGGER delete_user_prof_info_trigger BEFORE DELETE ON xgroups.users FOR EACH ROW EXECUTE FUNCTION public.delete_user_prof_info();


--
-- Name: users populate_userastroinfo_userid; Type: TRIGGER; Schema: xgroups; Owner: neo
--

CREATE TRIGGER populate_userastroinfo_userid AFTER INSERT ON xgroups.users FOR EACH ROW EXECUTE FUNCTION public.populate_user_astro_info();


--
-- Name: users populate_userbirthinfo_timezone; Type: TRIGGER; Schema: xgroups; Owner: neo
--

CREATE TRIGGER populate_userbirthinfo_timezone AFTER INSERT ON xgroups.users FOR EACH ROW EXECUTE FUNCTION public.populate_user_birth_info();


--
-- Name: users populate_userinterests_userid; Type: TRIGGER; Schema: xgroups; Owner: neo
--

CREATE TRIGGER populate_userinterests_userid AFTER INSERT ON xgroups.users FOR EACH ROW EXECUTE FUNCTION public.populate_user_interests();


--
-- Name: users populate_userprofinfo_userid; Type: TRIGGER; Schema: xgroups; Owner: neo
--

CREATE TRIGGER populate_userprofinfo_userid AFTER INSERT ON xgroups.users FOR EACH ROW EXECUTE FUNCTION public.populate_user_prof_info();


--
-- Name: userbirthinfo update_day_month_year_trigger; Type: TRIGGER; Schema: xgroups; Owner: neo
--

CREATE TRIGGER update_day_month_year_trigger BEFORE UPDATE ON xgroups.userbirthinfo FOR EACH ROW EXECUTE FUNCTION public.update_day_month_year();


--
-- Name: userbirthinfo update_hour_minute_trigger; Type: TRIGGER; Schema: xgroups; Owner: neo
--

CREATE TRIGGER update_hour_minute_trigger BEFORE UPDATE ON xgroups.userbirthinfo FOR EACH ROW EXECUTE FUNCTION public.update_hour_minute_function();


--
-- Name: users update_users_updated_at; Type: TRIGGER; Schema: xgroups; Owner: neo
--

CREATE TRIGGER update_users_updated_at BEFORE UPDATE ON xgroups.users FOR EACH ROW EXECUTE FUNCTION public.update_updated_at_column();


--
-- Name: userastroinfo fk_userastroinfo_users; Type: FK CONSTRAINT; Schema: xgroups; Owner: neo
--

ALTER TABLE ONLY xgroups.userastroinfo
    ADD CONSTRAINT fk_userastroinfo_users FOREIGN KEY (userid) REFERENCES xgroups.users(userid) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: userbirthinfo fk_userbirthinfo_users; Type: FK CONSTRAINT; Schema: xgroups; Owner: neo
--

ALTER TABLE ONLY xgroups.userbirthinfo
    ADD CONSTRAINT fk_userbirthinfo_users FOREIGN KEY (userid) REFERENCES xgroups.users(userid) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: DEFAULT PRIVILEGES FOR FUNCTIONS; Type: DEFAULT ACL; Schema: -; Owner: neo
--

ALTER DEFAULT PRIVILEGES FOR ROLE neo REVOKE ALL ON FUNCTIONS FROM neo;
ALTER DEFAULT PRIVILEGES FOR ROLE neo GRANT ALL ON FUNCTIONS TO neo WITH GRANT OPTION;


--
-- PostgreSQL database dump complete
--

