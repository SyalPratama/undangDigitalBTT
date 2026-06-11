--
-- PostgreSQL database dump
--

\restrict GpMZrhh5fV1Omvsfw3jR8Yhn7Mt4oa3ImbkrgesVPJtUvSQF8Ei0wfXfcrBVATd

-- Dumped from database version 16.14 (Debian 16.14-1.pgdg13+1)
-- Dumped by pg_dump version 17.9

-- Started on 2026-06-10 15:34:00

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

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 220 (class 1259 OID 16624)
-- Name: cache; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


--
-- TOC entry 221 (class 1259 OID 16631)
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


--
-- TOC entry 234 (class 1259 OID 16778)
-- Name: events; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.events (
    id uuid NOT NULL,
    invitation_id uuid NOT NULL,
    name character varying(255) NOT NULL,
    description text,
    event_date date NOT NULL,
    start_time time(0) without time zone,
    end_time time(0) without time zone,
    venue_name character varying(255),
    address text,
    google_maps_url text,
    latitude numeric(10,8),
    longitude numeric(11,8),
    sort_order integer DEFAULT 0 NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 226 (class 1259 OID 16656)
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


--
-- TOC entry 225 (class 1259 OID 16655)
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3608 (class 0 OID 0)
-- Dependencies: 225
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- TOC entry 237 (class 1259 OID 16827)
-- Name: invitation_builders; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.invitation_builders (
    id uuid NOT NULL,
    invitation_id uuid NOT NULL,
    html text,
    css text,
    project_data json,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 233 (class 1259 OID 16761)
-- Name: invitation_media; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.invitation_media (
    id uuid NOT NULL,
    invitation_id uuid NOT NULL,
    type character varying(255) NOT NULL,
    file_path character varying(255) NOT NULL,
    mime_type character varying(255),
    file_size bigint,
    title character varying(255),
    description text,
    sort_order integer DEFAULT 0 NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT invitation_media_type_check CHECK (((type)::text = ANY ((ARRAY['cover'::character varying, 'gallery'::character varying, 'first_person'::character varying, 'second_person'::character varying, 'video'::character varying])::text[])))
);


--
-- TOC entry 232 (class 1259 OID 16747)
-- Name: invitation_profiles; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.invitation_profiles (
    id uuid NOT NULL,
    invitation_id uuid NOT NULL,
    event_owner_name character varying(255),
    first_name character varying(255),
    first_nickname character varying(255),
    second_name character varying(255),
    second_nickname character varying(255),
    first_father character varying(255),
    first_mother character varying(255),
    second_father character varying(255),
    second_mother character varying(255),
    headline character varying(255),
    quote text,
    description text,
    closing_text text,
    address text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 229 (class 1259 OID 16693)
-- Name: invitation_types; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.invitation_types (
    id uuid NOT NULL,
    name character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 231 (class 1259 OID 16717)
-- Name: invitations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.invitations (
    id uuid NOT NULL,
    user_id uuid NOT NULL,
    invitation_type_id uuid NOT NULL,
    theme_id uuid NOT NULL,
    slug character varying(255) NOT NULL,
    title character varying(255) NOT NULL,
    custom_domain character varying(255),
    is_active boolean DEFAULT false NOT NULL,
    password character varying(255),
    published_at timestamp(0) without time zone,
    event_date timestamp(0) without time zone,
    visitor_count bigint DEFAULT '0'::bigint NOT NULL,
    meta_title character varying(255),
    meta_description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- TOC entry 224 (class 1259 OID 16648)
-- Name: job_batches; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


--
-- TOC entry 223 (class 1259 OID 16639)
-- Name: jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


--
-- TOC entry 222 (class 1259 OID 16638)
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3609 (class 0 OID 0)
-- Dependencies: 222
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- TOC entry 216 (class 1259 OID 16593)
-- Name: migrations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


--
-- TOC entry 215 (class 1259 OID 16592)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3610 (class 0 OID 0)
-- Dependencies: 215
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 218 (class 1259 OID 16608)
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


--
-- TOC entry 228 (class 1259 OID 16676)
-- Name: role_user; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.role_user (
    id uuid NOT NULL,
    user_id uuid NOT NULL,
    role_id uuid NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 227 (class 1259 OID 16667)
-- Name: roles; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.roles (
    id uuid NOT NULL,
    name character varying(255) NOT NULL,
    display_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 219 (class 1259 OID 16615)
-- Name: sessions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id uuid,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


--
-- TOC entry 236 (class 1259 OID 16794)
-- Name: theme_categories; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.theme_categories (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 235 (class 1259 OID 16793)
-- Name: theme_categories_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.theme_categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3611 (class 0 OID 0)
-- Dependencies: 235
-- Name: theme_categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.theme_categories_id_seq OWNED BY public.theme_categories.id;


--
-- TOC entry 230 (class 1259 OID 16705)
-- Name: themes; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.themes (
    id uuid NOT NULL,
    name character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text,
    thumbnail character varying(255),
    view_name character varying(255) NOT NULL,
    price numeric(12,2) DEFAULT '0'::numeric NOT NULL,
    is_premium boolean DEFAULT false NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    theme_category_id bigint
);


--
-- TOC entry 217 (class 1259 OID 16599)
-- Name: users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.users (
    id uuid NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    reseller_id uuid
);


--
-- TOC entry 3344 (class 2604 OID 16659)
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- TOC entry 3343 (class 2604 OID 16642)
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- TOC entry 3342 (class 2604 OID 16596)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 3356 (class 2604 OID 16797)
-- Name: theme_categories id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.theme_categories ALTER COLUMN id SET DEFAULT nextval('public.theme_categories_id_seq'::regclass);


--
-- TOC entry 3585 (class 0 OID 16624)
-- Dependencies: 220
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- TOC entry 3586 (class 0 OID 16631)
-- Dependencies: 221
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- TOC entry 3599 (class 0 OID 16778)
-- Dependencies: 234
-- Data for Name: events; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.events (id, invitation_id, name, description, event_date, start_time, end_time, venue_name, address, google_maps_url, latitude, longitude, sort_order, is_active, created_at, updated_at) FROM stdin;
3bccb4b5-aaee-489f-bc79-216c8f7cfc0a	770a3144-67d7-4275-8765-dc802adc0520	Akad Nikah	\N	2026-08-15	08:00:00	10:00:00	Masjid Agung Bandung	Jl. Asia Afrika No.1 Bandung	\N	\N	\N	1	t	2026-06-04 08:26:46	2026-06-04 08:26:46
b976e664-24da-46e4-883c-52630a69ded8	770a3144-67d7-4275-8765-dc802adc0520	Resepsi	\N	2026-08-15	11:00:00	15:00:00	Gedung Serbaguna Bandung	Jl. Merdeka Bandung	\N	\N	\N	2	t	2026-06-04 08:26:46	2026-06-04 08:26:46
e4baa8d0-875a-4569-97f1-77d9ff528b0b	01e8d4a6-2968-4b0a-875a-5001090f89a3	Birthday Party	\N	2026-12-20	18:00:00	22:00:00	Cafe Harmoni	Jl. Sudirman No.10 Jakarta	\N	\N	\N	1	t	2026-06-04 08:26:46	2026-06-04 08:26:46
268aebb3-0a3c-4211-af97-f244550c5710	b1c67de7-0edf-48f9-ae34-a9423f3832ca	Tasyakuran Aqiqah	\N	2026-09-12	09:00:00	13:00:00	Kediaman Keluarga Faisyal	Jl. Raya Majalengka No. 10	\N	\N	\N	1	t	2026-06-05 05:22:39	2026-06-05 05:22:39
c4412ac8-6a6e-49e1-9f8d-bd546d6194a1	5719d911-f884-4f32-9bea-d7914b01d08a	Walimatul Khitan	\N	2026-10-18	10:00:00	15:00:00	Gedung Serbaguna Majalengka	Jl. KH Abdul Halim No. 50 Majalengka	\N	\N	\N	1	t	2026-06-05 05:22:39	2026-06-05 05:22:39
cd87cc92-b227-442a-8c2f-7ebe5a48bc14	1ec6e3f3-5d69-4261-aa17-d7ebd7dc4420	Test	Test	2026-06-05	18:12:00	18:12:00	Test	Test	\N	\N	\N	1	t	2026-06-05 07:13:10	2026-06-05 07:13:10
754f9fbe-5df9-4e6a-b61a-628445836347	84a72257-9775-4703-bd6d-8b8d4f6770d2	Test	Test	2026-06-09	20:16:00	20:16:00	Test	Test	\N	\N	\N	1	t	2026-06-09 10:04:07	2026-06-09 10:04:07
\.


--
-- TOC entry 3591 (class 0 OID 16656)
-- Dependencies: 226
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- TOC entry 3602 (class 0 OID 16827)
-- Dependencies: 237
-- Data for Name: invitation_builders; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.invitation_builders (id, invitation_id, html, css, project_data, created_at, updated_at) FROM stdin;
0461f49e-28f7-41b0-aded-7f3e981bac1a	770a3144-67d7-4275-8765-dc802adc0520	\N	\N	\N	2026-06-08 10:47:15	2026-06-08 10:47:15
\.


--
-- TOC entry 3598 (class 0 OID 16761)
-- Dependencies: 233
-- Data for Name: invitation_media; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.invitation_media (id, invitation_id, type, file_path, mime_type, file_size, title, description, sort_order, is_active, created_at, updated_at) FROM stdin;
d788f8a1-b2fc-4662-83f9-9b4bbcc7982e	770a3144-67d7-4275-8765-dc802adc0520	cover	seed/faisyal-cover.jpg	\N	\N	\N	\N	1	t	2026-06-04 08:26:46	2026-06-04 08:26:46
c512301b-d426-45e1-a012-a77bbd53bc84	770a3144-67d7-4275-8765-dc802adc0520	gallery	seed/faisyal-gallery-1.jpg	\N	\N	\N	\N	1	t	2026-06-04 08:26:46	2026-06-04 08:26:46
11765af2-39bf-4d99-b751-9fc551fe0ea1	01e8d4a6-2968-4b0a-875a-5001090f89a3	cover	seed/rizky-cover.jpg	\N	\N	\N	\N	1	t	2026-06-04 08:26:46	2026-06-04 08:26:46
839a687b-5e23-4ea2-9117-9b3d19ba9821	b1c67de7-0edf-48f9-ae34-a9423f3832ca	cover	seed/aqiqah-cover.jpg	\N	\N	\N	\N	1	t	2026-06-05 05:22:39	2026-06-05 05:22:39
f05b0d6d-ff64-4b29-a881-51f3e5439ee5	b1c67de7-0edf-48f9-ae34-a9423f3832ca	gallery	seed/aqiqah-gallery-1.jpg	\N	\N	\N	\N	1	t	2026-06-05 05:22:39	2026-06-05 05:22:39
f569db42-245c-4203-9435-c691e72cdc7d	5719d911-f884-4f32-9bea-d7914b01d08a	cover	seed/khitan-cover.jpg	\N	\N	\N	\N	1	t	2026-06-05 05:22:39	2026-06-05 05:22:39
8b7928e5-80da-4570-ac88-3bce561f465d	5719d911-f884-4f32-9bea-d7914b01d08a	gallery	seed/khitan-gallery-1.jpg	\N	\N	\N	\N	1	t	2026-06-05 05:22:39	2026-06-05 05:22:39
ba4042dd-d1e1-4399-ab6f-225deec921c9	1ec6e3f3-5d69-4261-aa17-d7ebd7dc4420	cover	assets/pernikahan/cover_1780643590_gkswJ.png	image/png	597424	\N	\N	1	t	2026-06-05 07:13:10	2026-06-05 07:13:10
762f5395-6922-4fa5-9049-f7552a71fe00	1ec6e3f3-5d69-4261-aa17-d7ebd7dc4420	gallery	assets/pernikahan/gallery_1780643590_nrw9t_0.png	image/png	597424	\N	\N	2	t	2026-06-05 07:13:10	2026-06-05 07:13:10
31f18fb9-3422-41bc-b85a-2a841e43d953	1ec6e3f3-5d69-4261-aa17-d7ebd7dc4420	gallery	assets/pernikahan/gallery_1780643590_59DCT_1.png	image/png	1406187	\N	\N	3	t	2026-06-05 07:13:10	2026-06-05 07:13:10
65a88a32-cca0-4e5a-98a3-15574d9bacc4	84a72257-9775-4703-bd6d-8b8d4f6770d2	cover	assets/pernikahan/cover_1780643786_aWTMA.png	image/png	389526	\N	\N	1	t	2026-06-05 07:16:26	2026-06-05 07:16:26
72788f3e-5c6c-411b-b55f-c2047f3e248b	84a72257-9775-4703-bd6d-8b8d4f6770d2	gallery	assets/pernikahan/gallery_1780643786_SDMBD_0.png	image/png	1344482	\N	\N	2	t	2026-06-05 07:16:26	2026-06-05 07:16:26
\.


--
-- TOC entry 3597 (class 0 OID 16747)
-- Dependencies: 232
-- Data for Name: invitation_profiles; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.invitation_profiles (id, invitation_id, event_owner_name, first_name, first_nickname, second_name, second_nickname, first_father, first_mother, second_father, second_mother, headline, quote, description, closing_text, address, created_at, updated_at) FROM stdin;
4f108534-5a68-4898-83a0-fa2635e83b79	770a3144-67d7-4275-8765-dc802adc0520	\N	Faisyal Nur	\N	Isma Herdiani	\N	Ahmad	Siti	Budi	Dewi	The Wedding Of	Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan pasangan untukmu.	Dengan memohon rahmat dan ridho Allah SWT.	\N	\N	2026-06-04 08:26:46	2026-06-04 08:26:46
4c8e8da4-413c-40bf-bbdd-40e4307ebabf	01e8d4a6-2968-4b0a-875a-5001090f89a3	Rizky	Rizky	\N	\N	\N	\N	\N	\N	\N	Sweet Seventeen	\N	Mari rayakan ulang tahunku yang ke-17 bersama.	\N	\N	2026-06-04 08:26:46	2026-06-04 08:26:46
1fb9d74f-ce54-42fb-865d-f2aa5d35c7a4	b1c67de7-0edf-48f9-ae34-a9423f3832ca	Muhammad Zayn	Muhammad Zayn	\N	\N	\N	Faisyal Nur	Isma Herdiani	\N	\N	Tasyakuran Aqiqah	Semoga menjadi anak yang sholeh, berbakti kepada orang tua dan bermanfaat bagi sesama.	Dengan memohon rahmat dan ridho Allah SWT, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara tasyakuran aqiqah putra kami.	\N	\N	2026-06-05 05:22:39	2026-06-05 05:22:39
442da819-95c5-477c-869b-7bee7158e7fe	5719d911-f884-4f32-9bea-d7914b01d08a	Ahmad Farhan	Ahmad Farhan	\N	\N	\N	Faisyal Nur	Isma Herdiani	\N	\N	Walimatul Khitan	Semoga menjadi anak yang sholeh, berbakti kepada orang tua dan berguna bagi agama serta bangsa.	Dengan memohon rahmat dan ridho Allah SWT, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara walimatul khitan putra kami.	\N	\N	2026-06-05 05:22:39	2026-06-05 05:22:39
89bcd158-66af-4c6e-8846-efff9e59ee4b	1ec6e3f3-5d69-4261-aa17-d7ebd7dc4420	\N	Rizza	Jawir	Mia	Mimi	\N	\N	\N	\N	Test	test	Test	Test	Test	2026-06-05 07:13:10	2026-06-05 07:13:10
d5f95bbe-fb29-4ab3-9346-49ceca05313b	84a72257-9775-4703-bd6d-8b8d4f6770d2	\N	Rizza Widi Nugraha	Rizza	Mia Amalia	Mia	Test	Test	Test	Test	Test	Test	Test	Test	Test	2026-06-05 07:16:26	2026-06-09 10:04:07
\.


--
-- TOC entry 3594 (class 0 OID 16693)
-- Dependencies: 229
-- Data for Name: invitation_types; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.invitation_types (id, name, slug, description, is_active, created_at, updated_at) FROM stdin;
41781cdd-bce4-46c7-b58d-2cb145a25d64	Pernikahan	wedding	\N	t	2026-06-03 06:13:57	2026-06-03 06:13:57
63786ff2-3cc8-4d82-98de-30be67ca9f8f	Ulang Tahun	birthday	\N	t	2026-06-03 06:13:57	2026-06-03 06:13:57
96fdec40-9c56-4372-a16a-6f86d900b0a1	Aqiqah	aqiqah	\N	t	2026-06-03 06:13:57	2026-06-03 06:13:57
fbc03458-eaf9-4014-89a2-4233dca38a7e	Khitan	khitan	\N	t	2026-06-03 06:13:57	2026-06-03 06:13:57
ba1278f2-5779-4da7-b9ab-179c20705071	Tunangan	engagement	\N	t	2026-06-03 06:13:57	2026-06-03 06:13:57
82772ea4-c1f7-4040-8802-412177a83125	Wisuda	graduation	\N	t	2026-06-03 06:13:57	2026-06-03 06:13:57
eda036bb-5256-46f6-bc45-4fb4c3fc7c41	Syukuran	syukuran	\N	t	2026-06-03 06:13:57	2026-06-03 06:13:57
cbb77fe4-c7f5-4869-80ee-8fcd21b4d30e	Reuni	reuni	\N	t	2026-06-03 06:13:57	2026-06-03 06:13:57
\.


--
-- TOC entry 3596 (class 0 OID 16717)
-- Dependencies: 231
-- Data for Name: invitations; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.invitations (id, user_id, invitation_type_id, theme_id, slug, title, custom_domain, is_active, password, published_at, event_date, visitor_count, meta_title, meta_description, created_at, updated_at, deleted_at) FROM stdin;
770a3144-67d7-4275-8765-dc802adc0520	c42d87e7-2af3-4bb3-a53c-3ed3d19a7f9c	41781cdd-bce4-46c7-b58d-2cb145a25d64	09cb85c1-dbd4-4df0-b1bc-98599415aa2f	faisyal-isma	Undangan Pernikahan Faisyal & Salsa	\N	t	\N	2026-06-04 08:26:46	2026-08-15 00:00:00	0	Undangan Pernikahan Faisyal & Salsa	Undangan Pernikahan Faisyal & Salsa	2026-06-04 08:26:46	2026-06-04 08:26:46	\N
01e8d4a6-2968-4b0a-875a-5001090f89a3	c42d87e7-2af3-4bb3-a53c-3ed3d19a7f9c	63786ff2-3cc8-4d82-98de-30be67ca9f8f	425d79ee-20a3-4437-9d0d-ef69d525db58	rizky-ulang-tahun	Sweet Seventeen Rizky	\N	t	\N	2026-06-04 08:26:46	2026-12-20 00:00:00	0	Sweet Seventeen Rizky	Undangan Ulang Tahun Rizky	2026-06-04 08:26:46	2026-06-04 08:26:46	\N
b1c67de7-0edf-48f9-ae34-a9423f3832ca	c42d87e7-2af3-4bb3-a53c-3ed3d19a7f9c	96fdec40-9c56-4372-a16a-6f86d900b0a1	cc7f7361-dd18-4286-8cc9-b6698fcd2acf	aqiqah-muhammad-zayn	Tasyakuran Aqiqah Muhammad Zayn	\N	t	\N	2026-06-05 05:22:39	2026-09-12 00:00:00	0	Undangan Aqiqah Muhammad Zayn	Tasyakuran Aqiqah Muhammad Zayn	2026-06-05 05:22:39	2026-06-05 05:22:39	\N
5719d911-f884-4f32-9bea-d7914b01d08a	c42d87e7-2af3-4bb3-a53c-3ed3d19a7f9c	fbc03458-eaf9-4014-89a2-4233dca38a7e	f10aa73c-4588-44a4-8e78-936064d5de1f	khitanan-ahmad-farhan	Walimatul Khitan Ahmad Farhan	\N	t	\N	2026-06-05 05:22:39	2026-10-18 00:00:00	0	Undangan Khitanan Ahmad Farhan	Walimatul Khitan Ahmad Farhan	2026-06-05 05:22:39	2026-06-05 05:22:39	\N
1ec6e3f3-5d69-4261-aa17-d7ebd7dc4420	7679f595-9c38-44ca-ae29-26013fe70580	41781cdd-bce4-46c7-b58d-2cb145a25d64	09cb85c1-dbd4-4df0-b1bc-98599415aa2f	pernikahan	Pernikahan	\N	f	\N	\N	2026-06-19 14:05:00	0	\N	\N	2026-06-05 07:13:10	2026-06-05 07:17:10	2026-06-05 07:17:10
84a72257-9775-4703-bd6d-8b8d4f6770d2	7679f595-9c38-44ca-ae29-26013fe70580	41781cdd-bce4-46c7-b58d-2cb145a25d64	09cb85c1-dbd4-4df0-b1bc-98599415aa2f	pernikahan-rizza-dan-mia-amalia-kaka	Pernikahan Rizza dan Mia Amalia KAKA	\N	t	\N	\N	2026-06-09 14:15:00	0	\N	\N	2026-06-05 07:16:26	2026-06-09 10:04:07	\N
\.


--
-- TOC entry 3589 (class 0 OID 16648)
-- Dependencies: 224
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- TOC entry 3588 (class 0 OID 16639)
-- Dependencies: 223
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- TOC entry 3581 (class 0 OID 16593)
-- Dependencies: 216
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2026_06_03_053624_create_roles_table	1
5	2026_06_03_053651_create_role_user_table	1
6	2026_06_03_054701_create_invitation_types_table	1
7	2026_06_03_055059_create_themes_table	1
8	2026_06_03_055150_create_invitations_table	1
9	2026_06_03_060136_create_invitation_profiles_table	1
10	2026_06_03_060355_create_invitation_media_table	1
11	2026_06_03_061626_create_events_table	2
12	2026_06_05_044402_create_theme_categories_table	3
13	2026_06_05_044420_add_theme_category_id_to_themes_table	3
14	2026_06_08_052712_add_reseller_id_to_users_table	4
16	2026_06_08_104310_create_invitation_builders_table	5
\.


--
-- TOC entry 3583 (class 0 OID 16608)
-- Dependencies: 218
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- TOC entry 3593 (class 0 OID 16676)
-- Dependencies: 228
-- Data for Name: role_user; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.role_user (id, user_id, role_id, created_at, updated_at) FROM stdin;
7d542bdc-be92-43e4-9e35-8ac2a24a88b1	c42d87e7-2af3-4bb3-a53c-3ed3d19a7f9c	a7f95ce8-9308-4699-b05e-ca73a22b8726	2026-06-03 06:13:55	2026-06-03 06:13:55
85ec374d-9f2a-4177-a2c3-c8f08d4bcd64	d78e7a76-9813-4790-8d32-60a4928c7097	1a0ed052-3835-44be-a57f-fe7e3a92b70c	2026-06-03 06:13:56	2026-06-03 06:13:56
cd5ec9c7-f627-4fa6-bc50-8ae1d5c57b98	7679f595-9c38-44ca-ae29-26013fe70580	0079a19c-3bc9-49bc-8d0b-1aa0e6827fed	2026-06-03 06:13:56	2026-06-03 06:13:56
aa06d891-187e-4bf1-b7fa-3f3d5338e472	f524ec4a-e4e4-450c-ab83-2d044c0fa3d2	0079a19c-3bc9-49bc-8d0b-1aa0e6827fed	2026-06-03 06:13:56	2026-06-03 06:13:56
1be1a080-1d6e-49f5-86ec-298832d369ad	48119127-c2c6-4699-9b00-729c54236c66	0079a19c-3bc9-49bc-8d0b-1aa0e6827fed	2026-06-03 06:13:56	2026-06-03 06:13:56
45026237-efa4-443d-87cb-ee678eba8ac5	e442c0c9-fe3d-44d7-a652-17d455c1fec6	0079a19c-3bc9-49bc-8d0b-1aa0e6827fed	2026-06-03 06:13:57	2026-06-03 06:13:57
66ec0870-2063-4010-a25a-54f6f1b655a3	194b0613-af39-4ea5-90c7-cbaeb60f8aef	0079a19c-3bc9-49bc-8d0b-1aa0e6827fed	2026-06-03 06:13:57	2026-06-03 06:13:57
9b26db46-eca9-4f8c-b9fe-68633a2821c7	f9a73367-f5f9-4365-9a45-dc71ff1e125e	0079a19c-3bc9-49bc-8d0b-1aa0e6827fed	2026-06-08 06:13:16	2026-06-08 06:13:16
\.


--
-- TOC entry 3592 (class 0 OID 16667)
-- Dependencies: 227
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.roles (id, name, display_name, created_at, updated_at) FROM stdin;
a7f95ce8-9308-4699-b05e-ca73a22b8726	superadmin	Super Admin	2026-06-03 06:13:55	2026-06-03 06:13:55
1a0ed052-3835-44be-a57f-fe7e3a92b70c	reseller	Reseller	2026-06-03 06:13:55	2026-06-03 06:13:55
0079a19c-3bc9-49bc-8d0b-1aa0e6827fed	customer	Customer	2026-06-03 06:13:55	2026-06-03 06:13:55
\.


--
-- TOC entry 3584 (class 0 OID 16615)
-- Dependencies: 219
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
I6BTV73jix81UfppcSAJ2TwzvgmM8XqSWYVYlfA3	\N	192.168.144.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiZmw1U21SWHpuTmhFekRpSFVpSzBmeTdxMnNXR1RvQnRuSWxVUm5sMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODEwOSI7fX0=	1780999731
\.


--
-- TOC entry 3601 (class 0 OID 16794)
-- Dependencies: 236
-- Data for Name: theme_categories; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.theme_categories (id, name, slug, description, created_at, updated_at) FROM stdin;
1	Pernikahan	wedding	\N	2026-06-05 04:47:53	2026-06-05 04:47:53
2	Ulang Tahun	birthday	\N	2026-06-05 04:47:54	2026-06-05 04:47:54
3	Aqiqah	aqiqah	\N	2026-06-05 04:47:54	2026-06-05 04:47:54
4	Khitan	khitan	\N	2026-06-05 04:47:54	2026-06-05 04:47:54
5	Tunangan	engagement	\N	2026-06-05 04:47:54	2026-06-05 04:47:54
6	Wisuda	graduation	\N	2026-06-05 04:47:54	2026-06-05 04:47:54
7	Syukuran	syukuran	\N	2026-06-05 04:47:54	2026-06-05 04:47:54
8	Reuni	reuni	\N	2026-06-05 04:47:54	2026-06-05 04:47:54
\.


--
-- TOC entry 3595 (class 0 OID 16705)
-- Dependencies: 230
-- Data for Name: themes; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.themes (id, name, slug, description, thumbnail, view_name, price, is_premium, is_active, created_at, updated_at, theme_category_id) FROM stdin;
11a01390-9f0f-453a-99f9-2a1c27c75626	Floral Pink	floral-pink	\N	\N	themes.floral-pink	75000.00	t	t	2026-06-03 06:13:57	2026-06-03 06:13:57	\N
09cb85c1-dbd4-4df0-b1bc-98599415aa2f	Classic White	classic-white	\N	assets/themes/thumbnail/1780633930_sd6YRvZelO.png	themes.wedding.classic-white	0.00	f	t	2026-06-03 06:13:57	2026-06-05 04:55:34	1
425d79ee-20a3-4437-9d0d-ef69d525db58	Elegant Night Party Vibes	night-party	\N	assets/themes/thumbnail/1780635414_qV8QCiwVgo.png	themes.birthday.night-party	0.00	f	t	2026-06-03 06:13:57	2026-06-05 04:56:54	2
66f9f046-d807-40d8-85fb-c2e3f43f0859	Elegant Gold	elegant-gold	\N	\N	themes.wedding.elegant-gold	50000.00	t	t	2026-06-03 06:13:57	2026-06-05 05:04:58	1
cc7f7361-dd18-4286-8cc9-b6698fcd2acf	Royal Tasyakur	royal-tasyakur	\N	\N	themes.aqiqah.royal-tasyakur	0.00	f	t	2026-06-05 05:13:02	2026-06-05 05:13:02	3
f10aa73c-4588-44a4-8e78-936064d5de1f	dummy	dummy	\N	\N	themes.khitan.dummy	0.00	f	t	2026-06-05 05:17:54	2026-06-05 05:17:54	4
\.


--
-- TOC entry 3582 (class 0 OID 16599)
-- Dependencies: 217
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, reseller_id) FROM stdin;
c42d87e7-2af3-4bb3-a53c-3ed3d19a7f9c	Super Admin	admin@ngajak.com	\N	$2y$12$cUlB65vJbDy70MVHAad92eK1Frv1Wcx7O74u5mwkbCfyD.8h/Bw4q	\N	2026-06-03 06:13:55	2026-06-03 06:13:55	\N
d78e7a76-9813-4790-8d32-60a4928c7097	Reseller	reseller@ngajak.com	\N	$2y$12$HT6dfopw2XCmmw1u5vZYt.aLaRH6hOON7tXMOzueDGgcK3LdIfUtu	\N	2026-06-03 06:13:56	2026-06-03 06:13:56	\N
f524ec4a-e4e4-450c-ab83-2d044c0fa3d2	Siti	siti@ngajak.com	\N	$2y$12$qEcxGBXa8ym7oXuIjFwEhumlqbmiZEUHJgso8s5qI.Ymg4djmhdRO	\N	2026-06-03 06:13:56	2026-06-03 06:13:56	\N
48119127-c2c6-4699-9b00-729c54236c66	Andi	andi@ngajak.com	\N	$2y$12$9kbV.dUOJlx5aQHCYKBH0evn4HDupw6Z8TBjO81y4lsOFjC6CY8rC	\N	2026-06-03 06:13:56	2026-06-03 06:13:56	\N
e442c0c9-fe3d-44d7-a652-17d455c1fec6	Dewi	dewi@ngajak.com	\N	$2y$12$7B0Rmp1Ohb4TThnn5O0kDukYte..NQZZSgh6YcOT51OXHbLB.KpBm	\N	2026-06-03 06:13:57	2026-06-03 06:13:57	\N
194b0613-af39-4ea5-90c7-cbaeb60f8aef	Eko	eko@ngajak.com	\N	$2y$12$8xUCgoHK9V0xJWUSBD2I1.fCC1eEPSGBeLTfES7H7qlPUZ3WRNyJ2	\N	2026-06-03 06:13:57	2026-06-03 06:13:57	\N
7679f595-9c38-44ca-ae29-26013fe70580	Budi	budi@ngajak.com	\N	$2y$12$DBXG4w.VMUppWHpSuNN8Je6mT0P9VhmN8TKYpXBoW.RxKfCIy41zO	\N	2026-06-03 06:13:56	2026-06-03 06:13:56	d78e7a76-9813-4790-8d32-60a4928c7097
f9a73367-f5f9-4365-9a45-dc71ff1e125e	Isma Herdiani	isma@ngajak.com	\N	$2y$12$yYbyM02.19DP.dgWlkgvg.DtdMmuBy2bXnDe4Y1KgpIUQQpldW7Im	\N	2026-06-08 06:13:16	2026-06-08 06:13:16	d78e7a76-9813-4790-8d32-60a4928c7097
\.


--
-- TOC entry 3612 (class 0 OID 0)
-- Dependencies: 225
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- TOC entry 3613 (class 0 OID 0)
-- Dependencies: 222
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- TOC entry 3614 (class 0 OID 0)
-- Dependencies: 215
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.migrations_id_seq', 16, true);


--
-- TOC entry 3615 (class 0 OID 0)
-- Dependencies: 235
-- Name: theme_categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.theme_categories_id_seq', 8, true);


--
-- TOC entry 3373 (class 2606 OID 16637)
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- TOC entry 3371 (class 2606 OID 16630)
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- TOC entry 3418 (class 2606 OID 16792)
-- Name: events events_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_pkey PRIMARY KEY (id);


--
-- TOC entry 3380 (class 2606 OID 16664)
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 3382 (class 2606 OID 16666)
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- TOC entry 3426 (class 2606 OID 16838)
-- Name: invitation_builders invitation_builders_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invitation_builders
    ADD CONSTRAINT invitation_builders_pkey PRIMARY KEY (id);


--
-- TOC entry 3415 (class 2606 OID 16776)
-- Name: invitation_media invitation_media_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invitation_media
    ADD CONSTRAINT invitation_media_pkey PRIMARY KEY (id);


--
-- TOC entry 3410 (class 2606 OID 16760)
-- Name: invitation_profiles invitation_profiles_invitation_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invitation_profiles
    ADD CONSTRAINT invitation_profiles_invitation_id_unique UNIQUE (invitation_id);


--
-- TOC entry 3412 (class 2606 OID 16758)
-- Name: invitation_profiles invitation_profiles_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invitation_profiles
    ADD CONSTRAINT invitation_profiles_pkey PRIMARY KEY (id);


--
-- TOC entry 3392 (class 2606 OID 16702)
-- Name: invitation_types invitation_types_name_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invitation_types
    ADD CONSTRAINT invitation_types_name_unique UNIQUE (name);


--
-- TOC entry 3394 (class 2606 OID 16700)
-- Name: invitation_types invitation_types_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invitation_types
    ADD CONSTRAINT invitation_types_pkey PRIMARY KEY (id);


--
-- TOC entry 3396 (class 2606 OID 16704)
-- Name: invitation_types invitation_types_slug_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invitation_types
    ADD CONSTRAINT invitation_types_slug_unique UNIQUE (slug);


--
-- TOC entry 3404 (class 2606 OID 16744)
-- Name: invitations invitations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invitations
    ADD CONSTRAINT invitations_pkey PRIMARY KEY (id);


--
-- TOC entry 3407 (class 2606 OID 16746)
-- Name: invitations invitations_slug_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invitations
    ADD CONSTRAINT invitations_slug_unique UNIQUE (slug);


--
-- TOC entry 3378 (class 2606 OID 16654)
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- TOC entry 3375 (class 2606 OID 16646)
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 3359 (class 2606 OID 16598)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 3365 (class 2606 OID 16614)
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- TOC entry 3388 (class 2606 OID 16692)
-- Name: role_user role_user_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.role_user
    ADD CONSTRAINT role_user_pkey PRIMARY KEY (id);


--
-- TOC entry 3390 (class 2606 OID 16690)
-- Name: role_user role_user_user_id_role_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.role_user
    ADD CONSTRAINT role_user_user_id_role_id_unique UNIQUE (user_id, role_id);


--
-- TOC entry 3384 (class 2606 OID 16675)
-- Name: roles roles_name_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_name_unique UNIQUE (name);


--
-- TOC entry 3386 (class 2606 OID 16673)
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- TOC entry 3368 (class 2606 OID 16621)
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- TOC entry 3420 (class 2606 OID 16803)
-- Name: theme_categories theme_categories_name_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.theme_categories
    ADD CONSTRAINT theme_categories_name_unique UNIQUE (name);


--
-- TOC entry 3422 (class 2606 OID 16801)
-- Name: theme_categories theme_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.theme_categories
    ADD CONSTRAINT theme_categories_pkey PRIMARY KEY (id);


--
-- TOC entry 3424 (class 2606 OID 16805)
-- Name: theme_categories theme_categories_slug_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.theme_categories
    ADD CONSTRAINT theme_categories_slug_unique UNIQUE (slug);


--
-- TOC entry 3398 (class 2606 OID 16714)
-- Name: themes themes_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.themes
    ADD CONSTRAINT themes_pkey PRIMARY KEY (id);


--
-- TOC entry 3400 (class 2606 OID 16716)
-- Name: themes themes_slug_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.themes
    ADD CONSTRAINT themes_slug_unique UNIQUE (slug);


--
-- TOC entry 3361 (class 2606 OID 16607)
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- TOC entry 3363 (class 2606 OID 16605)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 3416 (class 1259 OID 16790)
-- Name: events_invitation_id_event_date_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX events_invitation_id_event_date_index ON public.events USING btree (invitation_id, event_date);


--
-- TOC entry 3413 (class 1259 OID 16774)
-- Name: invitation_media_invitation_id_type_sort_order_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX invitation_media_invitation_id_type_sort_order_index ON public.invitation_media USING btree (invitation_id, type, sort_order);


--
-- TOC entry 3401 (class 1259 OID 16742)
-- Name: invitations_event_date_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX invitations_event_date_index ON public.invitations USING btree (event_date);


--
-- TOC entry 3402 (class 1259 OID 16741)
-- Name: invitations_is_active_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX invitations_is_active_index ON public.invitations USING btree (is_active);


--
-- TOC entry 3405 (class 1259 OID 16739)
-- Name: invitations_slug_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX invitations_slug_index ON public.invitations USING btree (slug);


--
-- TOC entry 3408 (class 1259 OID 16740)
-- Name: invitations_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX invitations_user_id_index ON public.invitations USING btree (user_id);


--
-- TOC entry 3376 (class 1259 OID 16647)
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- TOC entry 3366 (class 1259 OID 16623)
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- TOC entry 3369 (class 1259 OID 16622)
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- TOC entry 3435 (class 2606 OID 16785)
-- Name: events events_invitation_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_invitation_id_foreign FOREIGN KEY (invitation_id) REFERENCES public.invitations(id) ON DELETE CASCADE;


--
-- TOC entry 3436 (class 2606 OID 16832)
-- Name: invitation_builders invitation_builders_invitation_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invitation_builders
    ADD CONSTRAINT invitation_builders_invitation_id_foreign FOREIGN KEY (invitation_id) REFERENCES public.invitations(id) ON DELETE CASCADE;


--
-- TOC entry 3434 (class 2606 OID 16769)
-- Name: invitation_media invitation_media_invitation_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invitation_media
    ADD CONSTRAINT invitation_media_invitation_id_foreign FOREIGN KEY (invitation_id) REFERENCES public.invitations(id) ON DELETE CASCADE;


--
-- TOC entry 3433 (class 2606 OID 16752)
-- Name: invitation_profiles invitation_profiles_invitation_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invitation_profiles
    ADD CONSTRAINT invitation_profiles_invitation_id_foreign FOREIGN KEY (invitation_id) REFERENCES public.invitations(id) ON DELETE CASCADE;


--
-- TOC entry 3430 (class 2606 OID 16729)
-- Name: invitations invitations_invitation_type_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invitations
    ADD CONSTRAINT invitations_invitation_type_id_foreign FOREIGN KEY (invitation_type_id) REFERENCES public.invitation_types(id) ON DELETE CASCADE;


--
-- TOC entry 3431 (class 2606 OID 16734)
-- Name: invitations invitations_theme_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invitations
    ADD CONSTRAINT invitations_theme_id_foreign FOREIGN KEY (theme_id) REFERENCES public.themes(id) ON DELETE CASCADE;


--
-- TOC entry 3432 (class 2606 OID 16724)
-- Name: invitations invitations_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invitations
    ADD CONSTRAINT invitations_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 3427 (class 2606 OID 16684)
-- Name: role_user role_user_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.role_user
    ADD CONSTRAINT role_user_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- TOC entry 3428 (class 2606 OID 16679)
-- Name: role_user role_user_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.role_user
    ADD CONSTRAINT role_user_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 3429 (class 2606 OID 16806)
-- Name: themes themes_theme_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.themes
    ADD CONSTRAINT themes_theme_category_id_foreign FOREIGN KEY (theme_category_id) REFERENCES public.theme_categories(id) ON DELETE SET NULL;


-- Completed on 2026-06-10 15:34:01

--
-- PostgreSQL database dump complete
--

\unrestrict GpMZrhh5fV1Omvsfw3jR8Yhn7Mt4oa3ImbkrgesVPJtUvSQF8Ei0wfXfcrBVATd

