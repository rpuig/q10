--
-- PostgreSQL database dump
--

-- Dumped from database version 15.13 (Debian 15.13-1.pgdg120+1)
-- Dumped by pg_dump version 15.13 (Debian 15.13-1.pgdg120+1)

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
    DELETE FROM userastroinfo WHERE userid = OLD.userid;
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
    DELETE FROM userbirthinfo WHERE userid = OLD.userid;
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
    DELETE FROM userchatmessages WHERE sender_id = OLD.userid;
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
     DELETE FROM userinterests WHERE userid = OLD.userid; 
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
     DELETE FROM usermatches WHERE usera_id = OLD.userid;
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
    DELETE FROM userprofinfo WHERE userid = OLD.userid;
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
    INSERT INTO userastroinfo (userid) VALUES (NEW.userid);
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
    SELECT COUNT(*) INTO userExists FROM userbirthinfo WHERE userid = NEW.userid;
    IF userExists = 0 THEN
        INSERT INTO userbirthinfo (userid, timezone) VALUES (NEW.userid, 1);
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
    INSERT INTO userinterests (userid) VALUES (NEW.userid);
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
    INSERT INTO userprofinfo (userid, username) VALUES (NEW.userid, NEW.username);
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


ALTER TABLE public.command OWNER TO neo;

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


ALTER TABLE public.migrations_id_seq OWNER TO neo;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neo
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: betsusers; Type: TABLE; Schema: xgroups; Owner: neo
--

CREATE TABLE xgroups.betsusers (
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
    profilepicture character varying(100) DEFAULT NULL::character varying,
    aboutme text
);


ALTER TABLE xgroups.betsusers OWNER TO neo;

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
    a_tribe character varying(255)
);


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


ALTER TABLE xgroups.userbirthinfo_userid_seq OWNER TO neo;

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


ALTER TABLE xgroups.userinterests_userid_seq OWNER TO neo;

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


ALTER TABLE xgroups.users_userid_seq OWNER TO neo;

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
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: neo
--

COPY public.migrations (id, version, class, "group", namespace, "time", batch) FROM stdin;
1	2024-11-28-153320	App\\Database\\Migrations\\AddLanguageColumnToUsers	default	App	1732808015	1
2	2024-11-28-154101	App\\Database\\Migrations\\AddLanguageColumnToUsers	default	App	1732808464	2
3	2024-11-28-154200	App\\Database\\Migrations\\AddLanguageColumnToUsers	default	App	1732808521	3
4	2024-11-28-154230	App\\Database\\Migrations\\AddLanguageColumnToUsers	default	App	1732808552	4
5	2024-11-28-154942	App\\Database\\Migrations\\AddLanguageColumnToUsers	default	App	1732808984	5
6	2024-11-28-155122	App\\Database\\Migrations\\AddLanguageColumnToUsers	default	App	1732809084	6
7	2024-11-28-161752	App\\Database\\Migrations\\AddLanguageColumnToUsers	default	App	1732810674	7
\.


--
-- Data for Name: betsusers; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.betsusers (userid, created_at, deleted_at, new, username, email, password, name, surname, sex, profilepicture, aboutme) FROM stdin;
\.


--
-- Data for Name: match_scores_eb_eb_full_weights; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.match_scores_eb_eb_full_weights (id, score, compared) FROM stdin;
hh	3	1
hm	3	1
hy	3	1
dh	3	1
dm	3	1
dy	3	1
mh	3	1
md	3	1
mm	3	1
my	3	1
yh	3	1
ym	3	1
yy	3	1
hd	3	1
dd	3	1
yd	3	1
\.


--
-- Data for Name: match_scores_eb_eb_scores; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.match_scores_eb_eb_scores (id, score, compared) FROM stdin;
aa	3	0
ab	3	0
ac	3	0
ad	3	0
ae	3	0
af	3	0
ag	3	0
ah	3	0
ai	3	0
aj	3	0
ak	3	0
al	3	0
ba	3	0
hh	3	0
hi	3	0
hj	3	0
hk	3	0
hl	3	0
ia	3	0
ib	3	0
ic	3	0
id	3	0
ie	3	0
if	3	0
ig	3	0
ih	3	0
ii	3	0
ij	3	0
ik	3	0
il	3	0
ja	3	0
jb	3	0
jc	3	0
jd	3	0
je	3	0
jf	3	0
jg	3	0
jh	3	0
ji	3	0
jj	3	0
jk	3	0
jl	3	0
ka	3	0
kb	3	0
kc	3	0
kd	3	0
ke	3	0
kf	3	0
dd	3	0
de	3	0
df	3	0
dg	3	0
dh	3	0
di	3	0
dj	3	0
dk	3	0
dl	3	0
ea	3	0
eb	3	0
ec	3	0
ed	3	0
ee	3	0
ef	3	0
eg	3	0
eh	3	0
ei	3	0
ej	3	0
ek	3	0
el	3	0
fa	3	0
fb	3	0
fc	3	0
fd	3	0
fe	3	0
ff	3	0
fg	3	0
fh	3	0
fi	3	0
fj	3	0
fk	3	0
fl	3	0
ga	3	0
gb	3	0
gc	3	0
gd	3	0
ge	3	0
gf	3	0
gg	3	0
gh	3	0
gi	3	0
gj	3	0
gk	3	0
gl	3	0
ha	3	0
hb	3	0
hc	3	0
hd	3	0
kg	3	0
kh	3	0
ki	3	0
kj	3	0
kk	3	0
kl	3	0
la	3	0
lb	3	0
lc	3	0
ld	3	0
le	3	0
lf	3	0
lg	3	0
lh	3	0
li	3	0
lj	3	0
lk	3	0
ll	3	0
bb	3	0
bc	3	0
bd	3	0
be	3	0
bf	3	0
bg	3	0
bh	3	0
bi	3	0
bj	3	0
bk	3	0
bl	3	0
ca	3	0
cb	3	0
cc	3	0
cd	3	0
ce	3	0
cf	3	0
cg	3	0
ch	3	0
ci	3	0
cj	3	0
ck	3	0
cl	3	0
da	3	0
db	3	0
dc	3	0
he	3	0
hf	3	0
hg	3	0
\.


--
-- Data for Name: match_scores_eb_eb_weights; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.match_scores_eb_eb_weights (id, score, compared) FROM stdin;
hh	3	1
hm	3	1
hy	3	1
dh	3	1
dm	3	1
dy	3	1
mh	3	1
md	3	1
mm	3	1
my	3	1
yh	3	1
ym	3	1
yy	3	1
hh	3	1
hm	3	1
hy	3	1
dh	3	1
dm	3	1
dy	3	1
mh	3	1
md	3	1
mm	3	1
my	3	1
yh	3	1
ym	3	1
yy	3	1
hd	3	1
hd	3	1
yd	3	1
yd	3	1
dd	3	1
dd	3	1
\.


--
-- Data for Name: match_scores_hs_hs_full_weights; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.match_scores_hs_hs_full_weights (id, score, compared) FROM stdin;
hm	3	1
hy	3	1
dh	3	1
dm	3	1
dy	3	1
mh	3	1
md	3	1
mm	3	1
my	3	1
yh	3	1
ym	3	1
yy	3	1
hd	3	1
dd	3	1
hh	3	1
yd	3	1
\.


--
-- Data for Name: match_scores_hs_hs_scores; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.match_scores_hs_hs_scores (id, score, compared) FROM stdin;
gh	3	1
ch	3	1
hf	3	1
gf	3	1
fi	3	1
if	3	1
cc	3	0
ig	3	0
hc	3	0
gc	3	0
ic	3	0
ci	3	0
cg	3	0
he	3	0
ei	3	0
ah	3	0
fj	3	0
cf	3	0
jc	3	0
ac	3	0
ij	3	0
ai	3	0
cj	3	0
ce	3	0
ff	3	0
bf	3	0
bc	3	0
be	3	0
aa	3	0
ab	3	0
ad	3	0
ae	3	0
af	3	0
ag	3	0
aj	3	0
ba	3	0
bb	3	0
bd	3	0
bg	3	0
bh	3	0
bi	3	0
bj	3	0
ca	3	0
cb	3	0
cd	3	0
da	3	0
db	3	0
dc	3	0
dd	3	0
de	3	0
ga	3	0
gb	3	0
gd	3	0
gg	3	0
gj	3	0
ha	3	0
hb	3	0
hd	3	0
hg	3	0
hh	3	0
hi	3	0
hj	3	0
ia	3	0
ib	3	0
id	3	0
ih	3	0
ii	3	0
ja	3	0
jb	3	0
jd	3	0
je	3	0
jf	3	0
jg	3	0
df	3	0
dg	3	0
dh	3	0
di	3	0
dj	3	0
ec	3	0
ed	3	0
ee	3	0
ef	3	0
eh	3	0
ej	3	0
fa	3	0
fd	3	0
fe	3	0
ea	3	0
eg	3	0
eb	3	0
fb	3	0
ji	3	0
jh	3	0
fc	3	0
fh	3	1
fg	3	1
jj	3	0
gi	3	0
ge	3	0
ie	3	0
\.


--
-- Data for Name: match_scores_hs_hs_weights; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.match_scores_hs_hs_weights (id, score, compared) FROM stdin;
hh	3	1
hm	3	1
hy	3	1
dh	3	1
dm	3	1
dy	3	1
mh	3	1
md	3	1
mm	3	1
my	3	1
yh	3	1
ym	3	1
yy	3	1
hh	3	1
hm	3	1
hy	3	1
dh	3	1
dm	3	1
dy	3	1
mh	3	1
md	3	1
mm	3	1
my	3	1
yh	3	1
ym	3	1
yy	3	1
hd	3	1
hd	3	1
dd	3	1
dd	3	1
yd	3	1
yd	3	1
\.


--
-- Data for Name: match_scores_na_na_scores; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.match_scores_na_na_scores (id, score, compared) FROM stdin;
aa	3	0
ab	3	0
ac	3	0
ad	3	0
ae	3	0
af	3	0
ag	3	0
ah	3	0
ai	3	0
aj	3	0
ak	3	0
al	3	0
am	3	0
an	3	0
ao	3	0
ap	3	0
aq	3	0
ar	3	0
as	3	0
at	3	0
au	3	0
av	3	0
aw	3	0
ax	3	0
ay	3	0
az	3	0
ba	3	0
bb	3	0
bc	3	0
bd	3	0
be	3	0
bf	3	0
bg	3	0
bh	3	0
bi	3	0
bj	3	0
bk	3	0
bl	3	0
bm	3	0
bn	3	0
bo	3	0
bp	3	0
bq	3	0
br	3	0
bs	3	0
bt	3	0
bu	3	0
bv	3	0
bw	3	0
bx	3	0
by	3	0
bz	3	0
ca	3	0
cb	3	0
cc	3	0
cd	3	0
ce	3	0
cf	3	0
cg	3	0
ch	3	0
ci	3	0
cj	3	0
ck	3	0
cl	3	0
cm	3	0
cn	3	0
co	3	0
cp	3	0
cq	3	0
cr	3	0
cs	3	0
ct	3	0
cu	3	0
cv	3	0
cw	3	0
cx	3	0
cy	3	0
cz	3	0
da	3	0
db	3	0
dc	3	0
dd	3	0
de	3	0
df	3	0
dg	3	0
dh	3	0
di	3	0
dj	3	0
dk	3	0
dl	3	0
dm	3	0
dn	3	0
do	3	0
dp	3	0
dq	3	0
dr	3	0
ds	3	0
dt	3	0
du	3	0
dv	3	0
dw	3	0
dx	3	0
dy	3	0
dz	3	0
ea	3	0
eb	3	0
ec	3	0
ed	3	0
ee	3	0
ef	3	0
eg	3	0
eh	3	0
ei	3	0
ej	3	0
ek	3	0
el	3	0
em	3	0
en	3	0
eo	3	0
ep	3	0
eq	3	0
er	3	0
es	3	0
et	3	0
eu	3	0
ev	3	0
ew	3	0
ex	3	0
ey	3	0
ez	3	0
fa	3	0
fb	3	0
fc	3	0
fd	3	0
fe	3	0
ff	3	0
fg	3	0
fh	3	0
fi	3	0
fj	3	0
fk	3	0
fl	3	0
fm	3	0
fn	3	0
fo	3	0
fp	3	0
fq	3	0
fr	3	0
fs	3	0
ft	3	0
fu	3	0
fv	3	0
fw	3	0
fx	3	0
fy	3	0
fz	3	0
ga	3	0
gb	3	0
gc	3	0
gd	3	0
ge	3	0
gf	3	0
gg	3	0
gh	3	0
gi	3	0
gj	3	0
gk	3	0
gl	3	0
gm	3	0
gn	3	0
go	3	0
gp	3	0
gq	3	0
gr	3	0
gs	3	0
gt	3	0
gu	3	0
gv	3	0
gw	3	0
gx	3	0
gy	3	0
gz	3	0
ha	3	0
hb	3	0
hc	3	0
hd	3	0
he	3	0
hf	3	0
hg	3	0
hh	3	0
hi	3	0
hj	3	0
hk	3	0
hl	3	0
hm	3	0
hn	3	0
ho	3	0
hp	3	0
hq	3	0
hr	3	0
hs	3	0
ht	3	0
hu	3	0
hv	3	0
hw	3	0
hx	3	0
hy	3	0
hz	3	0
ia	3	0
ib	3	0
ic	3	0
id	3	0
ie	3	0
if	3	0
ig	3	0
ih	3	0
ii	3	0
ij	3	0
ik	3	0
il	3	0
im	3	0
in	3	0
io	3	0
ip	3	0
iq	3	0
ir	3	0
is	3	0
it	3	0
iu	3	0
iv	3	0
iw	3	0
ix	3	0
iy	3	0
iz	3	0
ja	3	0
jb	3	0
jc	3	0
jd	3	0
je	3	0
jf	3	0
jg	3	0
jh	3	0
ji	3	0
jj	3	0
jk	3	0
jl	3	0
jm	3	0
jn	3	0
jo	3	0
jp	3	0
jq	3	0
jr	3	0
js	3	0
jt	3	0
ju	3	0
jv	3	0
jw	3	0
jx	3	0
jy	3	0
jz	3	0
ka	3	0
kb	3	0
kc	3	0
kd	3	0
ke	3	0
kf	3	0
kg	3	0
kh	3	0
ki	3	0
kj	3	0
kk	3	0
kl	3	0
km	3	0
kn	3	0
ko	3	0
kp	3	0
kq	3	0
kr	3	0
ks	3	0
kt	3	0
ku	3	0
kv	3	0
kw	3	0
kx	3	0
ky	3	0
kz	3	0
la	3	0
lb	3	0
lc	3	0
ld	3	0
le	3	0
lf	3	0
lg	3	0
lh	3	0
li	3	0
lj	3	0
lk	3	0
ll	3	0
lm	3	0
ln	3	0
lo	3	0
lp	3	0
lq	3	0
lr	3	0
ls	3	0
lt	3	0
lu	3	0
lv	3	0
lw	3	0
lx	3	0
ly	3	0
lz	3	0
ma	3	0
mb	3	0
mc	3	0
md	3	0
me	3	0
mf	3	0
mg	3	0
mh	3	0
mi	3	0
mj	3	0
mk	3	0
ml	3	0
mm	3	0
mn	3	0
mo	3	0
mp	3	0
mq	3	0
mr	3	0
ms	3	0
mt	3	0
mu	3	0
mv	3	0
mw	3	0
mx	3	0
my	3	0
mz	3	0
na	3	0
nb	3	0
nc	3	0
nd	3	0
ne	3	0
nf	3	0
ng	3	0
nh	3	0
ni	3	0
nj	3	0
nk	3	0
nl	3	0
nm	3	0
nn	3	0
no	3	0
np	3	0
nq	3	0
nr	3	0
ns	3	0
nt	3	0
nu	3	0
nv	3	0
nw	3	0
nx	3	0
ny	3	0
nz	3	0
oa	3	0
ob	3	0
oc	3	0
od	3	0
oe	3	0
of	3	0
og	3	0
oh	3	0
oi	3	0
oj	3	0
ok	3	0
ol	3	0
om	3	0
on	3	0
oo	3	0
op	3	0
oq	3	0
or	3	0
os	3	0
ot	3	0
ou	3	0
ov	3	0
ou	3	0
ov	3	0
ow	3	0
ox	3	0
oy	3	0
oz	3	0
pa	3	0
pb	3	0
pc	3	0
pd	3	0
pe	3	0
pf	3	0
pg	3	0
ph	3	0
pi	3	0
pj	3	0
pk	3	0
pl	3	0
pm	3	0
pn	3	0
po	3	0
pp	3	0
pq	3	0
pr	3	0
ps	3	0
pt	3	0
pu	3	0
pv	3	0
pw	3	0
px	3	0
py	3	0
pz	3	0
qa	3	0
qb	3	0
qc	3	0
qd	3	0
qe	3	0
qf	3	0
qg	3	0
qh	3	0
qi	3	0
qj	3	0
qk	3	0
ql	3	0
qm	3	0
qn	3	0
qo	3	0
qp	3	0
qq	3	0
qr	3	0
qs	3	0
qt	3	0
qu	3	0
qv	3	0
qw	3	0
qx	3	0
qy	3	0
qz	3	0
ra	3	0
rb	3	0
rc	3	0
rd	3	0
re	3	0
rf	3	0
rg	3	0
rh	3	0
ri	3	0
rj	3	0
rk	3	0
rl	3	0
rm	3	0
rn	3	0
ro	3	0
rp	3	0
rq	3	0
rr	3	0
rs	3	0
rt	3	0
ru	3	0
rv	3	0
rw	3	0
rx	3	0
ry	3	0
rz	3	0
sa	3	0
sb	3	0
sc	3	0
sd	3	0
se	3	0
sf	3	0
sg	3	0
sh	3	0
si	3	0
sj	3	0
sk	3	0
sl	3	0
sm	3	0
sn	3	0
so	3	0
sp	3	0
sq	3	0
sr	3	0
ss	3	0
st	3	0
su	3	0
sv	3	0
sw	3	0
sx	3	0
sy	3	0
sz	3	0
ta	3	0
tb	3	0
tc	3	0
td	3	0
te	3	0
tf	3	0
tg	3	0
th	3	0
ti	3	0
tj	3	0
tk	3	0
tl	3	0
tm	3	0
tn	3	0
to	3	0
tp	3	0
tq	3	0
tr	3	0
ts	3	0
tt	3	0
tu	3	0
tv	3	0
tw	3	0
tx	3	0
ty	3	0
tz	3	0
ua	3	0
ub	3	0
uc	3	0
ud	3	0
ue	3	0
uf	3	0
ug	3	0
uh	3	0
ui	3	0
uj	3	0
uk	3	0
ul	3	0
um	3	0
un	3	0
uo	3	0
up	3	0
uq	3	0
ur	3	0
us	3	0
ut	3	0
uu	3	0
uv	3	0
uw	3	0
ux	3	0
uy	3	0
uz	3	0
va	3	0
vb	3	0
vc	3	0
vd	3	0
ve	3	0
vf	3	0
vg	3	0
vh	3	0
vi	3	0
vj	3	0
vk	3	0
vl	3	0
vm	3	0
vn	3	0
vo	3	0
vp	3	0
vq	3	0
vr	3	0
vs	3	0
vt	3	0
vu	3	0
vv	3	0
vw	3	0
vx	3	0
vy	3	0
vz	3	0
wa	3	0
wb	3	0
wc	3	0
wd	3	0
we	3	0
wf	3	0
wg	3	0
wh	3	0
wi	3	0
wj	3	0
wk	3	0
wl	3	0
wm	3	0
wn	3	0
wo	3	0
wp	3	0
wq	3	0
wr	3	0
ws	3	0
wt	3	0
wu	3	0
wv	3	0
ww	3	0
wx	3	0
wy	3	0
wz	3	0
xa	3	0
xb	3	0
xc	3	0
xd	3	0
xe	3	0
xf	3	0
xg	3	0
xh	3	0
xi	3	0
xj	3	0
xk	3	0
xl	3	0
xm	3	0
xn	3	0
xo	3	0
xp	3	0
xq	3	0
xr	3	0
xs	3	0
xt	3	0
xu	3	0
xv	3	0
xw	3	0
xx	3	0
xy	3	0
xz	3	0
ya	3	0
yb	3	0
yc	3	0
yd	3	0
ye	3	0
yf	3	0
yg	3	0
yh	3	0
yi	3	0
yj	3	0
yk	3	0
yl	3	0
ym	3	0
yn	3	0
yo	3	0
yp	3	0
yq	3	0
yr	3	0
ys	3	0
yt	3	0
yu	3	0
yv	3	0
yw	3	0
yx	3	0
yy	3	0
yz	3	0
za	3	0
zb	3	0
zc	3	0
zd	3	0
ze	3	0
zf	3	0
zg	3	0
zh	3	0
zi	3	0
zj	3	0
zk	3	0
zl	3	0
zm	3	0
zn	3	0
zo	3	0
zp	3	0
zq	3	0
zr	3	0
zs	3	0
zt	3	0
zu	3	0
zv	3	0
zw	3	0
zx	3	0
zy	3	0
zz	3	0
\.


--
-- Data for Name: match_scores_zd_zd_scores; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.match_scores_zd_zd_scores (id, score, compared) FROM stdin;
aa	3	0
ab	3	0
ac	3	0
ad	3	0
ae	3	0
af	3	0
ag	3	0
ah	3	0
ai	3	0
aj	3	0
ak	3	0
al	3	0
ba	3	0
bb	3	0
bc	3	0
bd	3	0
be	3	0
bf	3	0
bg	3	0
bh	3	0
bi	3	0
bj	3	0
bk	3	0
bl	3	0
ca	3	0
cb	3	0
cc	3	0
cd	3	0
ce	3	0
cf	3	0
cg	3	0
ch	3	0
ci	3	0
cj	3	0
ck	3	0
cl	3	0
da	3	0
db	3	0
dc	3	0
dd	3	0
de	3	0
df	3	0
dg	3	0
dh	3	0
di	3	0
dj	3	0
dk	3	0
dl	3	0
ea	3	0
eb	3	0
ec	3	0
ed	3	0
ee	3	0
ef	3	0
eg	3	0
eh	3	0
ei	3	0
ej	3	0
ek	3	0
el	3	0
fa	3	0
fb	3	0
fc	3	0
fd	3	0
fe	3	0
ff	3	0
fg	3	0
fh	3	0
fi	3	0
fj	3	0
fk	3	0
fl	3	0
ga	3	0
gb	3	0
gc	3	0
gd	3	0
ge	3	0
gf	3	0
gg	3	0
gh	3	0
gi	3	0
gj	3	0
gk	3	0
gl	3	0
ha	3	0
hb	3	0
hc	3	0
hd	3	0
he	3	0
hf	3	0
hg	3	0
hh	3	0
hi	3	0
hj	3	0
hk	3	0
hl	3	0
ia	3	0
ib	3	0
ic	3	0
id	3	0
ie	3	0
if	3	0
ig	3	0
ih	3	0
ii	3	0
ij	3	0
ik	3	0
il	3	0
ja	3	0
jb	3	0
jc	3	0
jd	3	0
je	3	0
jf	3	0
jg	3	0
jh	3	0
ji	3	0
jj	3	0
jk	3	0
jl	3	0
ka	3	0
kb	3	0
kc	3	0
kd	3	0
ke	3	0
kf	3	0
kg	3	0
kh	3	0
ki	3	0
kj	3	0
kk	3	0
kl	3	0
la	3	0
lb	3	0
lc	3	0
ld	3	0
le	3	0
lf	3	0
lg	3	0
lh	3	0
li	3	0
lj	3	0
lk	3	0
ll	3	0
\.


--
-- Data for Name: match_scores_zd_zd_weights; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.match_scores_zd_zd_weights (id, score, compared) FROM stdin;
aa	3	0
ab	3	0
ac	3	0
ba	3	0
bb	3	0
bc	3	0
ca	3	0
cb	3	0
cc	3	0
\.


--
-- Data for Name: userastroinfo; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.userastroinfo (userid, element, hs_hour, eb_hour, eb_hour_eng, hs_day, eb_day, eb_day_eng, hs_month, eb_month, eb_month_eng, hs_year, eb_year, eb_year_eng, season, kin_tone, kin_seal, kin_number, sun, ascendant, moon, guide_seal, guide_tone, analogue_seal, analogue_tone, antipode_seal, antipode_tone, occult_seal, occult_tone, tribe, a_tribe) FROM stdin;
1030	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1004	4	yang fire	yang fire	horse	yang water	yang earth	dragon	yang fire	yang metal	monkey	yang fire	yang earth	dragon	Early Autumn	planetary	human	192	Leo 16 03 09	Sco 19 34 16	Cap 27 47 56	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1010	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1013	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1014	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1015	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1016	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1031	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1032	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1033	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1034	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1035	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1036	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1020	1	yang metal	yang earth	dog	yang water	yang metal	monkey	yang metal	yang metal	monkey	yang earth	yang fire	horse	Early Autumn	electric	human	172	Vir 14 49 13	Ari 24 25 57	Sco 15 21 49	warrior	electric	hand	electric	wind	electric	moon	spectral	yellow	blue
1021	5	yang metal	yang earth	dog	yang fire	yang wood	tiger	yang water	yang water	rat	yang water	yang earth	dog	Mid Winter	electric	sun	120	Cap 02 13 01	Leo 10 55 00	Pis 16 33 37	seed	electric	storm	electric	dog	electric	dragon	spectral	yellow	blue
1040	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1041	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1017	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1022	4	yang metal	yang earth	dog	yin metal	yin fire	snake	yin fire	yin wood	rabbit	yin earth	yin fire	snake	Mid Spring	magnetic	mirror	118	Ari 02 10 19	Lib 21 19 29	Lib 06 41 51	mirror	magnetic	dragon	magnetic	star	magnetic	night	cosmic	white	red
1023	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1025	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1044	1	yin fire	yin earth	sheep	yang water	yang metal	monkey	yang metal	yang metal	monkey	yang earth	yang fire	horse	Early Autumn	electric	human	172	Vir 14 36 51	Sag 28 34 43	Sco 12 32 09	warrior	electric	hand	electric	wind	electric	moon	spectral	yellow	blue
370	1	yin fire	yin earth	sheep	yang water	yang metal	monkey	yang metal	yang metal	monkey	yang earth	yang fire	horse	Early Autumn	electric	human	172	Virgo	Sagittarius	Scorpio	warrior	electric	hand	electric	wind	electric	moon	spectral	yellow	blue
1043	4	yang fire	yang fire	horse	yang water	yang fire	horse	yin wood	yin fire	snake	yang water	yang wood	tiger	Early Summer	spectral	monkey	11	Gem 08 06 46	Vir 13 47 35	Tau 27 18 18	monkey	spectral	star	spectral	dragon	spectral	dog	electric	blue	yellow
1042	1	yin fire	yin earth	sheep	yang water	yang metal	monkey	yang metal	yang metal	monkey	yang earth	yang fire	horse	Early Autumn	electric	human	172	Virgo	Sagittarius	Scorpio	warrior	electric	hand	electric	wind	electric	moon	spectral	yellow	blue
\.


--
-- Data for Name: userbirthinfo; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.userbirthinfo (userid, sex, month, day, year, birthdate, hour, minute, birthtime, unknowntime, timezone, timezone_txt, city, birthcountry, long_deg, long_min, ew, lat_deg, lat_min, ns, long_secs, lat_secs, lon, lat) FROM stdin;
1017	\N	\N	\N	\N	01/01/2024	\N	\N	\N	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1004	\N	08	08	1976	08/08/1976	12	00	12:00	\N	1	Europe/Rome	Rome	Italy	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1010	\N	\N	\N	\N	01/01/2024	\N	\N	\N	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1013	\N	\N	\N	\N	01/01/2024	\N	\N	\N	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1014	\N	\N	\N	\N	01/01/2024	\N	\N	\N	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1015	\N	\N	\N	\N	01/01/2024	\N	\N	\N	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1016	\N	\N	\N	\N	01/01/2024	\N	\N	\N	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1021	\N	12	24	1922	24/12/1922	19	10	19:10	\N	1	America/New_York	Boones Hill	United States	\N	\N	\N	\N	\N	\N	\N	\N		
1043	\N	05	29	2022	29/05/2022	12	00	12:00	\N	1	Europe/Paris	Rennes	France	\N	\N	\N	\N	\N	\N	\N	\N		
1042	\N	09	07	1978	07/09/1978	14	30	14:30	\N	1	Europe/Madrid	Toledo	Spain	\N	\N	\N	\N	\N	\N	\N	\N	-4.0108266	39.8625625
1044	\N	09	07	1978	07/09/1978	14	30	14:30	\N	1	Europe/Madrid	Madrid	Spain	\N	\N	\N	\N	\N	\N	\N	\N	-3.7035825	40.4167047
370	\N	09	07	1978	07/09/1978	14	31	14:31	\N	1	Europe/Paris	Madrid	Spain	\N	\N	\N	\N	\N	\N	\N	\N	-3.7035825	40.4167047
1022	\N	03	22	1989	22/03/1989	20	00	20:00	\N	1	America/Santiago	Santiago	Chile	\N	\N	\N	\N	\N	\N	\N	\N		
1023	\N	\N	\N	\N	01/01/2024	\N	\N	\N	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1025	\N	\N	\N	\N	01/01/2024	\N	\N	\N	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1030	\N	\N	\N	\N	01/01/2024	\N	\N	\N	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1031	\N	\N	\N	\N	01/01/2024	\N	\N	\N	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1032	\N	\N	\N	\N	01/01/2024	\N	\N	\N	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1033	\N	\N	\N	\N	01/01/2024	\N	\N	\N	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1034	\N	\N	\N	\N	01/01/2024	\N	\N	\N	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1035	\N	\N	\N	\N	01/01/2024	\N	\N	\N	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1036	\N	\N	\N	\N	01/01/2024	\N	\N	\N	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1020	\N	09	07	1978	07/09/1978	19	36	19:36	\N	1	Europe/Madrid	Madrid	Spain	\N	\N	\N	\N	\N	\N	\N	\N		
1040	\N	\N	\N	\N	01/01/2024	\N	\N	\N	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
1041	\N	\N	\N	\N	01/01/2024	\N	\N	\N	\N	1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
\.


--
-- Data for Name: userchatmessages; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.userchatmessages (messageid, sender_id, receiver_id, message, "timestamp", read_status) FROM stdin;
1004.1004.2024-08-13 10:38:58	1004	1004	hi handsome	2024-08-13 10:38:58+02	f
1004.1004.2024-08-13 10:48:01	1004	1004	tetas	2024-08-13 10:48:01+02	f
1004.370.2024-08-13 10:48:28	1004	370	hi puto	2024-08-13 10:48:28+02	f
1004.370.2024-08-20 10:15:21	1004	370	cacasdsds	2024-08-20 10:15:21+02	f
1004.370.2024-08-20 10:19:54	1004	370	sdads	2024-08-20 10:19:54+02	f
1004.370.2024-08-20 10:20:06	1004	370	hola	2024-08-20 10:20:06+02	f
1004.370.2024-08-20 10:31:07	1004	370	sda	2024-08-20 10:31:07+02	f
1004.370.2024-08-20 11:50:56	1004	370	guarro	2024-08-20 11:50:56+02	f
370.1004.2024-07-31 10:15:47	370	1004	hola puti	2024-07-31 10:15:47+02	f
370.1004.2024-07-31 10:16:17	370	1004	que tal el tanga	2024-07-31 10:16:17+02	f
370.1004.2024-08-14 08:33:30	370	1004	dass	2024-08-14 08:33:30+02	f
370.1004.2024-08-14 08:35:19	370	1004	sdasdsdda	2024-08-14 08:35:19+02	f
370.1004.2024-08-14 08:37:48	370	1004	sda	2024-08-14 08:37:48+02	f
370.1004.2024-08-14 08:41:31	370	1004	asddasda	2024-08-14 08:41:31+02	f
370.1004.2024-08-14 08:43:29	370	1004	sadsadastt	2024-08-14 08:43:29+02	f
370.1004.2024-08-20 06:09:32	370	1004	dasdasda	2024-08-20 06:09:32+02	f
370.1004.2024-08-20 06:10:06	370	1004	putttataddadda	2024-08-20 06:10:06+02	f
370.1004.2024-08-20 10:09:15	370	1004	sda	2024-08-20 10:09:15+02	f
370.1004.2024-08-20 10:14:19	370	1004	cacsa	2024-08-20 10:14:19+02	f
370.1004.2024-08-20 10:14:29	370	1004	dadasda	2024-08-20 10:14:29+02	f
370.1004.2024-08-20 10:14:34	370	1004	pappaa	2024-08-20 10:14:34+02	f
370.1004.2024-08-20 10:31:28	370	1004	cscas	2024-08-20 10:31:28+02	f
370.1004.2024-08-20 10:36:26	370	1004	hhh	2024-08-20 10:36:26+02	f
370.1004.2024-08-20 10:42:36	370	1004	ttt	2024-08-20 10:42:36+02	f
370.1004.2024-08-20 10:53:29	370	1004	asda	2024-08-20 10:53:29+02	f
370.1004.2024-08-20 10:53:37	370	1004	asda	2024-08-20 10:53:37+02	f
370.1004.2024-08-20 11:15:08	370	1004	18:15	2024-08-20 11:15:08+02	f
370.1004.2024-08-20 11:18:21	370	1004	&lt;htmlZ	2024-08-20 11:18:21+02	f
370.1004.2024-08-20 11:18:27	370	1004	&lt;html&gt;	2024-08-20 11:18:27+02	f
370.1004.2024-08-20 11:46:14	370	1004	tata	2024-08-20 11:46:14+02	f
370.1004.2024-08-20 11:47:53	370	1004	tatawsda	2024-08-20 11:47:53+02	f
370.1004.2024-08-20 11:48:19	370	1004	sdada	2024-08-20 11:48:19+02	f
370.1004.2024-08-20 11:48:25	370	1004	ttreere	2024-08-20 11:48:25+02	f
370.1004.2024-08-20 11:50:33	370	1004	jadeputa	2024-08-20 11:50:33+02	f
370.1004.2024-08-20 11:51:35	370	1004	gorda	2024-08-20 11:51:35+02	f
370.1004.2024-08-21 11:53:44	370	1004	tetas	2024-08-21 11:53:44+02	f
370.1004.2024-08-25 09:57:33+02	370	1004	tarererdasdada	2024-08-25 09:57:33+02	f
370.1004.2024-08-25 09:58:01+02	370	1004	sdada	2024-08-25 09:58:01+02	f
370.1004.2024-08-25 12:00:00+02	370	1004	\N	2024-08-25 12:00:00+02	f
360.1004.2024-08-25 12:00:00+02	360	1004	test	2024-08-25 12:00:00+02	f
370.1004.2024-08-25 13:00:00+02	370	1004	test	2024-08-25 13:00:00+02	f
370.1004.2024-08-25 10:14:41+02	370	1004	kkkkkk	2024-08-25 10:14:41+02	f
370.1004.2024-09-22 18:56:37.238409+02	370	1004	jodeeee	2024-09-22 18:56:37.238843+02	f
370.1004.2024-09-22 19:01:47.689194+02	370	1004	cacaca	2024-09-22 19:01:47.689693+02	f
1004.370.2024-09-22 19:01:56.405325+02	1004	370	aewadasd	2024-09-22 19:01:56.405732+02	f
370.1004.2024-09-22 19:10:39.097212+02	370	1004	coñooo	2024-09-22 19:10:39.097764+02	f
370.1004.2024-09-22 19:11:35.394647+02	370	1004	casca	2024-09-22 19:11:35.395074+02	f
370.1004.2024-09-22 19:11:53.159176+02	370	1004	yyyuuu	2024-09-22 19:11:53.159723+02	f
370.1004.2024-09-22 19:18:58.474576+02	370	1004	hahahaha	2024-09-22 19:18:58.475014+02	f
370.1004.2024-09-22 19:19:01.348008+02	370	1004	hihihih	2024-09-22 19:19:01.348531+02	f
370.1004.2024-09-22 19:19:02.748271+02	370	1004	hohohohh	2024-09-22 19:19:02.748729+02	f
370.1004.2024-09-22 19:19:06.018626+02	370	1004	haahahhahahahah ahhahahahha ahhahah	2024-09-22 19:19:06.019058+02	f
370.1004.2024-09-22 19:19:08.248955+02	370	1004	exceklelleltn	2024-09-22 19:19:08.249395+02	f
1004.370.2024-09-22 19:19:20.195446+02	1004	370	ohhhhhhhhhh siiiiii	2024-09-22 19:19:20.195862+02	f
370.1004.2024-10-01 16:18:29.881205+02	370	1004	holita	2024-10-01 16:18:29.883+02	f
370.1004.2024-10-09 14:40:33.806173+02	370	1004	test	2024-10-09 14:40:33.806786+02	f
370.1021.2024-11-20 16:20:44.98095+01	370	1021	caca	2024-11-20 16:20:44.981543+01	f
1021.370.2024-11-20 16:49:00.51964+01	1021	370	DWAD	2024-11-20 16:49:00.520346+01	f
1021.370.2024-11-20 17:00:12.478586+01	1021	370	dsada	2024-11-20 17:00:12.479069+01	f
1021.370.2024-11-20 17:00:15.639871+01	1021	370	tetete	2024-11-20 17:00:15.640364+01	f
370.1021.2024-11-20 17:00:38.856957+01	370	1021	sfasfa	2024-11-20 17:00:38.857462+01	f
1021.370.2024-11-20 17:00:57.025936+01	1021	370	ha	2024-11-20 17:00:57.026501+01	f
370.1004.2024-11-22 17:37:06.585978+01	370	1004	sada	2024-11-22 17:37:06.586566+01	f
370.1021.2024-11-22 18:35:05.695415+01	370	1021	tatas	2024-11-22 18:35:05.696039+01	f
370.1021.2024-11-22 18:35:12.811379+01	370	1021	dudidiada	2024-11-22 18:35:12.811948+01	f
370.1021.2024-11-22 18:36:03.033105+01	370	1021	jejejeje	2024-11-22 18:36:03.033707+01	f
370.1021.2024-11-22 18:36:05.365703+01	370	1021	jujuju	2024-11-22 18:36:05.366191+01	f
1021.370.2024-11-22 18:36:26.757086+01	1021	370	ohhh hahahaha	2024-11-22 18:36:26.757649+01	f
1021.370.2024-11-22 18:37:28.371559+01	1021	370	retard	2024-11-22 18:37:28.372143+01	f
1021.370.2024-11-22 19:06:42.983005+01	1021	370	dada	2024-11-22 19:06:42.983562+01	f
370.1021.2024-11-22 19:06:53.181261+01	370	1021	sdada	2024-11-22 19:06:53.181933+01	f
1021.370.2024-11-22 19:08:32.125635+01	1021	370	dsada	2024-11-22 19:08:32.126194+01	f
370.1021.2024-11-22 19:33:48.505212+01	370	1021	sdadasd	2024-11-22 19:33:48.505765+01	f
370.1021.2024-11-22 19:35:22.772936+01	370	1021	asdasda adasdas da qeawdsa dadas dasd asdadasdadada a dasdsadadaa dasda	2024-11-22 19:35:22.773499+01	f
1042.1022.2025-04-09 17:55:56.29947+02	1042	1022	hello valentina	2025-04-09 17:55:56.304979+02	f
1042.1021.2025-04-09 18:08:52.220874+02	1042	1021	hillo	2025-04-09 18:08:52.222135+02	f
\.


--
-- Data for Name: userinterests; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.userinterests (userid, interests, lookingfor) FROM stdin;
370	{}	Women
1004	{}	Men
1010	{}	Not set
1013	{}	Not set
1014	{}	Not set
1015	{}	Not set
1016	{}	Not set
1017	{}	Not set
1005	{}	Women
1006	{}	Women
1007	{}	Women
1008	{}	Women
1009	{}	Women
1020	{}	Women
1021	{}	Men
1022	{}	Men
1023	{}	Not set
1025	{}	Not set
1030	{}	Not set
1031	{}	Not set
1032	{}	Not set
1033	{}	Not set
1034	{}	Not set
1035	{}	Not set
1036	{}	Not set
1040	{}	Not set
1041	{}	Not set
1042	{}	Women
1043	{}	Women
1044	{}	Women
\.


--
-- Data for Name: usermatches; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.usermatches (usera_id, userb_id, matchid, score_cn, score_my, score_zd, score_hd, score_num, score_total) FROM stdin;
1004	370	1004_370	12	0	0	0	0	12
1020	1004	1020_1004	11	0	0	0	0	11
1043	1004	1043_1004	12	0	0	0	0	12
1043	1021	1043_1021	11	0	0	0	0	11
1043	1022	1043_1022	12	0	0	0	0	12
1021	1020	1021_1020	9	1	0	0	0	10
1021	370	1021_370	9	1	0	0	0	10
1044	1004	1044_1004	9	0	0	0	0	9
1044	1021	1044_1021	9	1	0	0	0	10
1044	1022	1044_1022	9	0	0	0	0	9
1042	1004	1042_1004	12	0	0	0	0	12
1042	1021	1042_1021	11	1	0	0	0	12
1042	1022	1042_1022	12	0	0	0	0	12
370	1004	370_1004	12	0	0	0	0	12
370	1021	370_1021	11	1	0	0	0	12
370	1022	370_1022	12	0	0	0	0	12
\.


--
-- Data for Name: userprofinfo; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.userprofinfo (userid, profession, "position", sector, username) FROM stdin;
370	Tennis Player	\N	\N	\N
1004	Lawyer	\N	\N	\N
1010	\N	\N	\N	dudeman
1013	\N	\N	\N	rapperdude2
1014	\N	\N	\N	puiti
1015	\N	\N	\N	cacp
1016	\N	\N	\N	puter
1017	\N	\N	\N	puta
1020	Lawyer	\N	\N	putinga
1021	Other	\N	\N	avagardner
1022	Lawyer	\N	\N	valentina
1023	\N	\N	\N	tete
1025	\N	\N	\N	puitput
1030	\N	\N	\N	dodo
1031	\N	\N	\N	dodode
1032	\N	\N	\N	rayu
1033	\N	\N	\N	test
1034	\N	\N	\N	testa
1035	\N	\N	\N	eco
1036	\N	\N	\N	retard
1040	\N	\N	\N	tont
1041	\N	\N	\N	tatata
1042	Lawyer	\N	\N	stefanos2
1043	Lawyer	\N	\N	tutankamon
1044	Lawyer	\N	\N	putamn
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.users (userid, created_at, deleted_at, new, username, email, password, name, surname, sex, looking, profilepicture, aboutme, data_visibility, active, verification_code, updated_at, verification_token, is_active, language) FROM stdin;
1004	\N	\N	0	puri	puri@puri.com	$2y$10$E7dSmnJkMWNU3AuwPMWYu.deKUnikwv/2Ces6v5epcdVGNEZdY8YK	Cameron Diaz	charles	Female	\N	1723563030_359d97c0bb60dd4978bc.png	Tell a little bit about yourself	{"name":"1","surname":"1","sex":null,"bdate":null,"city":null,"profession":null,"aboutme":null,"lookingfor":null}	f	\N	2024-09-19 16:13:40.310648	\N	f	en
1010	\N	\N	1	dudeman	trading@ramonpuig.me	$2y$10$N.hFrSeO/.8qxK64CNsMkucrgJdk99kS9owG0/WX9biFrKl4RTGv.	\N	\N	\N	\N	\N	\N	{}	f	\N	2024-09-23 18:21:12.405284	\N	f	en
1013	\N	\N	1	rapperdude2	coding@ramonpuig.me	$2y$10$bFvlpM8rPXgSg617t1r6jORsOYnRmAd.2iK1h7mN5XxCM5M5r/SOe	\N	\N	\N	\N	\N	\N	{}	f	\N	2024-09-23 18:53:13.463988	\N	f	en
1014	\N	\N	1	puiti	biodiversity@ramonpuig.me	$2y$10$LqjWq9.Ajrp9YCCX3cIAUuxLJR77Rki1d.9poA0fAZaigbzUewRpe	\N	\N	\N	\N	\N	\N	{}	f	\N	2024-09-23 19:10:48.830697	\N	f	en
1015	\N	\N	1	cacp	ramon@ramonpuig.me	$2y$10$2vsuJhvK3WHYfAryOD2dheVthO7FhSWk3HjQ7IDIntNZCiZLGSRNW	\N	\N	\N	\N	\N	\N	{}	f	\N	2024-09-23 19:27:21.456856	\N	f	en
1016	\N	\N	1	puter	instagram@ramonpuig.me	$2y$10$urlC8c6VR1PRTjCsT.U7hO9Rfwk6fIvrwUN7pyKrCBufcmSWCRxzO	\N	\N	\N	\N	\N	\N	{}	f	\N	2024-09-23 19:53:04.701264	\N	f	en
1017	\N	\N	1	puta	dd@r.com	$2y$10$nWfXXoZz/lJvGW.scVKhEu/7W.SDufkNIlcpKi33kNWEtJPbcjy1e	\N	\N	\N	\N	\N	\N	{}	f	\N	2024-10-19 13:23:43.466312	\N	f	en
1020	\N	\N	0	putinga	putinga@r.com	$2y$10$BT4Nj6DcHzCZJoLpe4TKiOze1HlwkpZJgkAtpB1x4tSOiv/cnO7BO	putinga	pu	Male	\N	\N	Tell a little bit about yourself	{"name":null,"surname":null,"sex":null,"bdate":null,"city":null,"profession":null,"aboutme":null,"lookingfor":null}	f	\N	2024-11-19 13:15:53.873227	\N	f	en
1030	\N	\N	1	dodo	rpuigdel@gmail.com	$2y$10$j942UgObVfNRtcmcnpXhS.il5Sb1Z/mNpuQz3jhDpWeyh5TjIJFp6	\N	\N	\N	\N	\N	\N	{}	f	\N	2024-11-27 19:40:28.663243	4ac3bdbb9161e0a1fb49e7c8038a90ec	f	en
1031	\N	\N	1	dodode	Q10@ramonpuig.me	$2y$10$h0BR8y2g4Wdtq2lqSLLLoOa/XPcfyKE.U7U.1qmk.aLjiRVAEjaEG	\N	\N	\N	\N	\N	\N	{}	f	\N	2024-11-27 19:42:05.241667	dbcb7d6caa46532224c5caffc591bc01	f	en
1032	\N	\N	1	rayu	shop@ramonpuig.me	$2y$10$0QkSzB8o.K1jyLhQ99W8F.JE4tLGdf4KEm2CxrKOGC8JbsWEULzDu	\N	\N	\N	\N	\N	\N	{}	f	\N	2024-11-27 22:26:48.705231	\N	t	en
1033	\N	\N	1	test	contact@ramonpuig.me	$2y$10$nL6WpGevduvinsNW67vAl.Ko366PvniYxd6KQ.ctHwHwyDRa3qDbq	\N	\N	\N	\N	\N	\N	{}	f	\N	2024-11-27 23:32:10.161889	d4aa93165e65a99e604e7f57c0892d29	f	en
1034	\N	\N	1	testa	rpuigpal@gmail.com	$2y$10$8KJVDFDbNkG5MokGPLNdTuw3irNlpNGBKWnzQw1OBAi/MkHMDhqPW	\N	\N	\N	\N	\N	\N	{}	f	\N	2024-11-27 23:43:35.683528	4192784551c70549ef2e9e99fe570af2	f	en
1035	\N	\N	1	eco	ecoaldeas@ramonpuig.me	$2y$10$Nw3Vzq14mriLP/mEXeHPUep72GKkb1apQ9PDt106fTl4f6zE4LNna	\N	\N	\N	\N	\N	\N	{}	f	\N	2024-11-28 10:13:43.867804	27b5f357b3d5e294e121bb74722fde3d	f	en
1036	\N	\N	1	retard	retard@rat.com	$2y$10$OFeXLk1nKoDJCJLFJveGeeSb.9Tbom2eMMqa1oirups77CsRds6JO	\N	\N	\N	\N	\N	\N	{}	f	\N	2024-11-28 10:14:48.887826	e7c6789fe53f7e2c7fe1bb70f66eb32f	f	en
1021	\N	\N	0	avagardner	r@r.com	$2y$10$IHbyk6G.oVY43T1BWNOBg.vXWeBG6tElczrK3PTiLkHjiIxLt6ZaO	ava	gardner	Female	\N	1732115979_efd9c7e928df4384b890.png	Tell a little bit about yourself	{}	f	\N	2024-11-20 16:21:31.583601	\N	f	en
1040	\N	\N	1	tont	tont@r.com	$2y$10$E3yHAasUzJszLhQk8.ook.PVtsI5OjJOfI4LrSh.6beZRhxLFqvHu	\N	\N	\N	\N	\N	\N	{}	f	\N	2024-11-28 10:47:31.458248	\N	t	en
1041	\N	\N	1	tatata	tatata@ta.com	$2y$10$0OVV0fBO5phRYif1KJ0NtO36kT5DYwjUO.xmr6L9PKDZ8ZjvBA6zy	\N	\N	\N	\N	\N	\N	{}	f	\N	2024-11-28 11:53:39.268259	\N	t	en
1022	\N	\N	0	valentina	r@r.org	$2y$10$5bNM3KVpdCf9hgbn6T/JHO6/dWbiTB/7DC9Hx.o8kw3MVGVjp6USu	valentina	valentina	Female	\N	\N	Tell a little bit about yourself	{}	f	\N	2024-11-26 20:38:32.060588	\N	f	en
1023	\N	\N	1	tete	tete@tete.com	$2y$10$4EOxgAbniyzu41q8nDSR0OoF5LEvvASnZ4bAbyU44Hy7lvkHBy48C	\N	\N	\N	\N	\N	\N	{}	f	\N	2024-11-27 18:08:10.625227	8c8f951744839db862ada52d4ef868cc	f	en
1025	\N	\N	1	puitput	work@ramonpuig.me	$2y$10$S4A2vK6WiyDJjRApedtrOOmngp0zzam241g3FE5Wi9k2U1/I9KUce	\N	\N	\N	\N	\N	\N	{}	f	\N	2024-11-27 19:30:23.120133	904aa3d4f69087cc2aab0eb99740dd1f	f	en
1042	\N	\N	0	stefanos2	stefanos@r.com	$2y$10$q0fBWrpUR98/pb7jlxWtCuHagvXNQ/itrCw1ZeFd1/EpvVmFWGs5K	stef	anos oliente	Male	\N	1732988848_c30c5a6ad967e0139b82.jpg	Tell a little bit about yourself	{}	f	\N	2025-02-28 11:50:21.346877	\N	t	es
1044	\N	\N	0	putamn	puta@putaman.com	$2y$10$TaFj1LQU8f.6NZ2D2nGJMukrOpv.CCAU8dsh27f0Krm3Vzkvok/IW	\N	\N	Male	\N	\N	Tell a little bit about yourself	{}	f	\N	2025-01-19 19:34:42.144124	\N	t	en
370	\N	\N	0	stefanos	Tsitsipas@g,com	$2y$10$wFfxvrc5/v4acZE9c16Dye4zBEuisOw7wJDvFtJv14HlTiq6O4KMC	Stefanos	Tsitsipas	Male	\N	1719945830_614259e5dd8c452ef591.png	i am great and i love sex and tennis at table sdasda	{"name":"1","surname":"1","sex":"1","bdate":"1","city":null,"profession":"1","aboutme":null,"lookingfor":null}	f	\N	2025-06-05 19:00:37.510074	\N	f	en
1043	\N	\N	0	tutankamon	tutankamon@egipto.com	$2y$10$kJfl0NmcammmPIzF5OHxM.eg0AquYOcv9.Ok86eWbemHahQuPOzNe	\N	\N	Male	\N	1732991420_7677cd746fe4f0a8cae5.jpeg	Tell a little bit about yourself	{}	f	\N	2024-11-30 19:41:03.185467	\N	t	en
\.


--
-- Data for Name: users_backup; Type: TABLE DATA; Schema: xgroups; Owner: neo
--

COPY xgroups.users_backup (userid, created_at, deleted_at, new, username, email, password, name, surname, sex, looking, profilepicture, aboutme, data_visibility) FROM stdin;
370	\N	\N	0	stefanos	Tsitsipas@g,com	$2y$10$wFfxvrc5/v4acZE9c16Dye4zBEuisOw7wJDvFtJv14HlTiq6O4KMC	timezone	Tsitsipas	Male	\N	1719945830_614259e5dd8c452ef591.png	i am great and i love sex and tennis at table	{"name":"1","surname":"1","sex":"1","bdate":"1","city":"1","profession":"1","aboutMe":null,"lookingFor":"1"}
381	\N	\N	0	zorrita	zorri@g.com	$2y$10$GN06J4ZfQdX8meuqCFxWguP1xEPZb/BMv7kx6TuW/NupUf/pziRAK	samantha	fox	Female	\N	1716846214_e8ab47c66cf8fef7e366.png	I am superb MILF who loves to eat dick and swallow your cum	{"name":"1","surname":"1","sex":"1","bdate":"1","city":"1","profession":"1","aboutMe":null,"lookingFor":"1"}
386	\N	\N	0	rajo	rajo@rajo.com	$2y$10$uiSL0vmnP6TiT4p2JzEU/OXcPFkgSEETbB/eAqvGuZFVUNYcTi.Vq	ra	jo	Male	\N	\N	Tell a little bit about yourself	{"name":null,"surname":null,"sex":null,"bdate":null,"city":null,"profession":null,"aboutMe":null,"lookingFor":null}
\.


--
-- Name: command; Type: SEQUENCE SET; Schema: public; Owner: neo
--

SELECT pg_catalog.setval('public.command', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neo
--

SELECT pg_catalog.setval('public.migrations_id_seq', 7, true);


--
-- Name: userbirthinfo_userid_seq; Type: SEQUENCE SET; Schema: xgroups; Owner: neo
--

SELECT pg_catalog.setval('xgroups.userbirthinfo_userid_seq', 1004, true);


--
-- Name: userinterests_userid_seq; Type: SEQUENCE SET; Schema: xgroups; Owner: neo
--

SELECT pg_catalog.setval('xgroups.userinterests_userid_seq', 1010, true);


--
-- Name: users_userid_seq; Type: SEQUENCE SET; Schema: xgroups; Owner: neo
--

SELECT pg_catalog.setval('xgroups.users_userid_seq', 1044, true);


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
-- PostgreSQL database dump complete
--

