--
-- PostgreSQL database dump
--

-- Dumped from database version 10.1
-- Dumped by pg_dump version 10.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: rooms; Type: TABLE; Schema: public; Owner: twebb2
--

CREATE TABLE rooms (
    building_id numeric,
    rooms json
);


ALTER TABLE rooms OWNER TO twebb2;

--
-- Name: uwf_buildings; Type: TABLE; Schema: public; Owner: twebb2
--

CREATE TABLE uwf_buildings (
    id bigint NOT NULL,
    name text,
    alias text,
    number text,
    type text,
    latitude numeric,
    longitude numeric,
    extra json
);


ALTER TABLE uwf_buildings OWNER TO twebb2;

--
-- Name: uwf_buildings_id_seq; Type: SEQUENCE; Schema: public; Owner: twebb2
--

CREATE SEQUENCE uwf_buildings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE uwf_buildings_id_seq OWNER TO twebb2;

--
-- Name: uwf_buildings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: twebb2
--

ALTER SEQUENCE uwf_buildings_id_seq OWNED BY uwf_buildings.id;


--
-- Name: uwf_users; Type: TABLE; Schema: public; Owner: twebb2
--

CREATE TABLE uwf_users (
    id bigint NOT NULL,
    username text,
    salt text,
    key text,
    extra json
);


ALTER TABLE uwf_users OWNER TO twebb2;

--
-- Name: uwf_users_id_seq; Type: SEQUENCE; Schema: public; Owner: twebb2
--

CREATE SEQUENCE uwf_users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE uwf_users_id_seq OWNER TO twebb2;

--
-- Name: uwf_users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: twebb2
--

ALTER SEQUENCE uwf_users_id_seq OWNED BY uwf_users.id;


--
-- Name: uwf_buildings id; Type: DEFAULT; Schema: public; Owner: twebb2
--

ALTER TABLE ONLY uwf_buildings ALTER COLUMN id SET DEFAULT nextval('uwf_buildings_id_seq'::regclass);


--
-- Name: uwf_users id; Type: DEFAULT; Schema: public; Owner: twebb2
--

ALTER TABLE ONLY uwf_users ALTER COLUMN id SET DEFAULT nextval('uwf_users_id_seq'::regclass);


--
-- Data for Name: rooms; Type: TABLE DATA; Schema: public; Owner: twebb2
--

COPY rooms (building_id, rooms) FROM stdin;
81	[\n    {\n        "room_num" : 349,\n        "alias" : "windows lab",\n        "schedule" : [\n            {\n                "class_id" : "4592",\n                "days" : "TR",\n                "start_time" : "1100",\n                "end_time" : "1215"\n            },\n            {\n                "class_id" : "4593",\n                "days" : "TR",\n                "start_time" : "1230",\n                "end_time" : "1345"\n            }\n        ]\n    },\n    {\n        "room_num" : 350,\n        "alias" : "mac lab",\n        "schedule" : [\n            {\n                "class_id" : "4410",\n                "days" : "MW",\n                "start_time" : "0800",\n                "end_time" : "0915"\n            }\n        ]\n    }\n]\n
\.


--
-- Data for Name: uwf_buildings; Type: TABLE DATA; Schema: public; Owner: twebb2
--

COPY uwf_buildings (id, name, alias, number, type, latitude, longitude, extra) FROM stdin;
1	"BLDG 1"    	"                                              	 "1"    	BLDG	30.54361036257724	-87.220243015931274	\N
2	"BLDG 10"   	"                                              	 "10"   	BLDG	30.55122875874418	-87.220624822631308	\N
3	"BLDG 100"  	"                                              	 "100"  	BLDG	30.54204420033248	-87.204954224626164	\N
4	"BLDG 100A" 	"                                              	 "100A" 	BLDG	30.542012005033889	-87.204802877086649	\N
5	"BLDG 101"  	"                                              	 "101"  	BLDG	30.544042679735188	-87.198286123277754	\N
6	"BLDG 11"   	"                                              	 "11"   	BLDG	30.55166607569414	-87.220084258774662	\N
7	"BLDG 113"  	"                                              	 "113"  	BLDG	30.546767163988289	-87.220801760955695	\N
8	"BLDG 12"   	"                                              	 "12"   	BLDG	30.5510721250951	-87.219716852850709	\N
9	"BLDG 13"   	"                                              	 "13"   	BLDG	30.550953381339291	-87.221338748555226	\N
10	"BLDG 14"   	"                                              	 "14"   	BLDG	30.55000728616244	-87.220923471078805	\N
11	"BLDG 146"  	"                                              	 "146"  	BLDG	30.543572996297819	-87.220169525236471	\N
12	"BLDG 147"  	"                                              	 "147"  	BLDG	30.543536870426429	-87.220243442492716	\N
13	"BLDG 148"  	"                                              	 "148"  	BLDG	30.544160028690481	-87.197905190219544	\N
14	"BLDG 149"  	"                                              	 "149"  	BLDG	30.544201867658099	-87.198078031626693	\N
15	"BLDG 15"   	"                                              	 "15"   	BLDG	30.549511623208389	-87.221039341872128	\N
16	"BLDG 150"  	"                                              	 "150"  	BLDG	30.544194390695282	-87.198006013038551	\N
17	"BLDG 155"  	"                                              	 "155"  	BLDG	30.543633026794609	-87.198412826749077	\N
18	"BLDG 158"  	"                                              	 "158"  	BLDG	30.552311201123288	-87.216478702806427	\N
19	"BLDG 16"   	"                                              	 "16"   	BLDG	30.549714553000442	-87.220713005020158	\N
20	"BLDG 18"   	"                                              	 "18"   	BLDG	30.5503637398932	-87.22058248952861	\N
21	"BLDG 19"   	"                                              	 "19"   	BLDG	30.54988091288218	-87.218904640218071	\N
22	"BLDG 191"  	"                                              	 "191"  	BLDG	30.544159927838901	-87.212798948813074	\N
23	"BLDG 194"  	"                                              	 "194"  	BLDG	30.544188370286879	-87.21234026600132	\N
24	"BLDG 200"  	"                                              	 "200"  	BLDG	30.542463023000231	-87.206333903746611	\N
25	"BLDG 201"  	"                                              	 "201"  	BLDG	30.54228380813727	-87.206544832608543	\N
26	"BLDG 202"  	"                                              	 "202"  	BLDG	30.54246108828535	-87.206537258028774	\N
27	"BLDG 203"  	"                                              	 "203"  	BLDG	30.541507882277958	-87.206930359564552	\N
28	"BLDG 204"  	"                                              	 "204"  	BLDG	30.541309471593099	-87.207337606335372	\N
29	"BLDG 205"  	"                                              	 "205"  	BLDG	30.541616159884601	-87.207273165825868	\N
30	"BLDG 208"  	"                                              	 "208"  	BLDG	30.542111467252418	-87.205515535604334	\N
31	"BLDG 209"  	"                                              	 "209"  	BLDG	30.547614380582949	-87.221039744244152	\N
32	"BLDG 20E"  	"                                              	 "20E"  	BLDG	30.54837597199456	-87.219558544077657	\N
33	"BLDG 20W"  	"                                              	 "20W"  	BLDG	30.54861810332832	-87.219805773138845	\N
34	"BLDG 21"   	"                                              	 "21"   	BLDG	30.550223867127709	-87.219252749645094	\N
35	"BLDG 210"  	"                                              	 "210"  	BLDG	30.54181786501189	-87.206802478148816	\N
36	"BLDG 211"  	"                                              	 "211"  	BLDG	30.54167475691083	-87.20667997121555	\N
37	"BLDG 213"  	"                                              	 "213"  	BLDG	30.547199040454469	-87.220597574912176	\N
38	"BLDG 214"  	"                                              	 "214"  	BLDG	30.54151720197012	-87.203290567398867	\N
39	"BLDG 216"  	"                                              	 "216"  	BLDG	30.541741577387189	-87.205320470783775	\N
40	"BLDG 217"  	"                                              	 "217"  	BLDG	30.54157687068286	-87.205569873135957	\N
41	"BLDG 218"  	"                                              	 "218"  	BLDG	30.545371791433009	-87.212444799097298	\N
42	"BLDG 219"  	"                                              	 "219"  	BLDG	30.54018200165342	-87.203383992901081	\N
43	"BLDG 22"   	"Commons"                                       	 "22"   	BLDG	30.549036529751	-87.218658927117758	\N
44	"BLDG 220"  	"                                              	 "220"  	BLDG	30.540212985985129	-87.203528597433632	\N
45	"BLDG 221"  	"                                              	 "221"  	BLDG	30.540165349162539	-87.203225146915358	\N
46	"BLDG 222"  	"                                              	 "222"  	BLDG	30.541183001392579	-87.208209985357868	\N
47	"BLDG 223"  	"                                              	 "223"  	BLDG	30.542077438701551	-87.205248084981307	\N
48	"BLDG 224"  	"                                              	 "224"  	BLDG	30.541813505865662	-87.207042224207072	\N
49	"BLDG 225"  	"                                              	 "225"  	BLDG	30.541688775975739	-87.206993536440606	\N
50	"BLDG 229"  	"                                              	 "229"  	BLDG	30.542234075980002	-87.20570499924392	\N
51	"BLDG 23"   	"                                              	 "23"   	BLDG	30.548558837541279	-87.218933768385384	\N
52	"BLDG 231"  	"                                              	 "231"  	BLDG	30.54027895089315	-87.202578543449192	\N
53	"BLDG 232"  	"                                              	 "232"  	BLDG	30.54037743666586	-87.20696677071426	\N
54	"BLDG 233"  	"                                              	 "233"  	BLDG	30.541957482773689	-87.204497423289112	\N
55	"BLDG 235"  	"                                              	 "235"  	BLDG	30.54067507472017	-87.206035475286555	\N
56	"BLDG 24"   	"                                              	 "24"   	BLDG	30.54825151590714	-87.219116977275178	\N
57	"BLDG 25"   	"                                              	 "25"   	BLDG	30.54810458913953	-87.218744041905154	\N
58	"BLDG 26"   	"                                              	 "26"   	BLDG	30.548476301243269	-87.217594165664195	\N
59	"BLDG 27"   	"                                              	 "27"   	BLDG	30.548345936312771	-87.217241442414903	\N
60	"BLDG 28"   	"                                              	 "28"   	BLDG	30.548809021498709	-87.217432474320461	\N
61	"BLDG 281"  	"                                              	 "281"  	BLDG	30.545125865208789	-87.212288354164045	\N
62	"BLDG 29"   	"                                              	 "29"   	BLDG	30.548909008905071	-87.216997998966548	\N
63	"BLDG 291"  	"                                              	 "291"  	BLDG	30.540983871458341	-87.208205998730122	\N
64	"BLDG 3"    	"                                              	 "3"    	BLDG	30.548616356427111	-87.216970177851493	\N
65	"BLDG 30"   	"                                              	 "30"   	BLDG	30.549144473853449	-87.217449090554183	\N
66	"BLDG 309"  	"                                              	 "309"  	BLDG	30.544194054374518	-87.21942482927308	\N
67	"BLDG 31"   	"                                              	 "31"   	BLDG	30.54920204962416	-87.217049069090649	\N
68	"BLDG 312"  	"                                              	 "312"  	BLDG	30.55106145560579	-87.217955406605284	\N
69	"BLDG 317"  	"                                              	 "317"  	BLDG	30.540125055399429	-87.1980501851762	\N
70	"BLDG 318A" 	"                                              	 "318A" 	BLDG	30.540455673524701	-87.197934730306471	\N
71	"BLDG 318B" 	"                                              	 "318B" 	BLDG	30.540555955710801	-87.197890146180285	\N
72	"BLDG 318C" 	"                                              	 "318C" 	BLDG	30.540629631320311	-87.197840487490026	\N
73	"BLDG 318D" 	"                                              	 "318D" 	BLDG	30.540688662564971	-87.197811688730951	\N
74	"BLDG 318E" 	"                                              	 "318E" 	BLDG	30.540724634752561	-87.197777244160491	\N
75	"BLDG 318F" 	"                                              	 "318F" 	BLDG	30.54085907991529	-87.197790516309411	\N
76	"BLDG 32"   	"John C. Pace Library"                          	 "32"   	BLDG	30.55003975543621	-87.217260027190946	\N
77	"BLDG 33"   	"                                              	 "33"   	BLDG	30.549970504250322	-87.218131311812442	\N
78	"BLDG 36"   	"                                              	 "36"   	BLDG	30.550746714840638	-87.218421940119228	\N
79	"BLDG 37"   	"                                              	 "37"   	BLDG	30.55073400151711	-87.219083310774934	\N
80	"BLDG 38"   	"                                              	 "38"   	BLDG	30.55141610455177	-87.219063715157503	\N
81	"BLDG 4"    	"Hal Marcus College of Science and Engineering" 	 "4"    	BLDG	30.54697200470283	-87.21661848439939	\N
82	"BLDG 40"   	"                                              	 "40"   	BLDG	30.552569213751511	-87.218667786428838	\N
83	"BLDG 41"   	"                                              	 "41"   	BLDG	30.551953765147552	-87.218855798464858	\N
84	"BLDG 43"   	"                                              	 "43"   	BLDG	30.543104192330379	-87.198149117012548	\N
85	"BLDG 44"   	"                                              	 "44"   	BLDG	30.554752859565902	-87.217271263320612	\N
86	"BLDG 46"   	"                                              	 "46"   	BLDG	30.553209728122361	-87.218490953164917	\N
87	"BLDG 47"   	"                                              	 "47"   	BLDG	30.543606286202738	-87.220444172050819	\N
88	"BLDG 48"   	"                                              	 "48"   	BLDG	30.544113690759119	-87.197723471868414	\N
89	"BLDG 49"   	"                                              	 "49"   	BLDG	30.543678905859601	-87.197729888735097	\N
90	"BLDG 50"   	"                                              	 "50"   	BLDG	30.551474524986951	-87.216698787475053	\N
91	"BLDG 51"   	"                                              	 "51"   	BLDG	30.551146269633719	-87.21632126653013	\N
92	"BLDG 52"   	"                                              	 "52"   	BLDG	30.550440860024761	-87.215885228773686	\N
93	"BLDG 53"   	"                                              	 "53"   	BLDG	30.550332324240632	-87.215575199573962	\N
94	"BLDG 537"  	"                                              	 "537"  	BLDG	30.546158403154539	-87.221735783002856	\N
95	"BLDG 54"   	"                                              	 "54"   	BLDG	30.54540977069853	-87.221019653788062	\N
96	"BLDG 56A"  	"                                              	 "56A"  	BLDG	30.546150645555979	-87.212946314757659	\N
97	"BLDG 58"   	"                                              	 "58"   	BLDG	30.552266851165221	-87.216901212050558	\N
98	"BLDG 58A"  	"                                              	 "58A"  	BLDG	30.55197718505055	-87.217493710398713	\N
99	"BLDG 58B"  	"                                              	 "58B"  	BLDG	30.552435758262082	-87.216370050730575	\N
100	"BLDG 6"    	"                                              	 "6"    	BLDG	30.55252728605911	-87.217474916816371	\N
101	"BLDG 63"   	"                                              	 "63"   	BLDG	30.5526793589605	-87.215931023724963	\N
102	"BLDG 70"   	"                                              	 "70"   	BLDG	30.545594390122641	-87.214658578288081	\N
103	"BLDG 71"   	"                                              	 "71"   	BLDG	30.54411855442174	-87.218014505646792	\N
104	"BLDG 72"   	"                                              	 "72"   	BLDG	30.54471898136725	-87.221898374901599	\N
105	"BLDG 73"   	"                                              	 "73"   	BLDG	30.54558495843219	-87.221897272268635	\N
106	"BLDG 74"   	"                                              	 "74"   	BLDG	30.549748510186749	-87.215953867704712	\N
107	"BLDG 75"   	"                                              	 "75"   	BLDG	30.549784219015571	-87.215508085749889	\N
108	"BLDG 76"   	"                                              	 "76"   	BLDG	30.549503165445341	-87.215538225065927	\N
109	"BLDG 76A"  	"                                              	 "76A"  	BLDG	30.549221605365378	-87.21580165363703	\N
110	"BLDG 78"   	"                                              	 "78"   	BLDG	30.544500941254199	-87.218581203901564	\N
111	"BLDG 79"   	"Information and Technology Services"           	 "79"   	BLDG	30.548368229826728	-87.215891954407184	\N
112	"BLDG 80"   	"                                              	 "80"   	BLDG	30.545589452319	-87.214082922831238	\N
113	"BLDG 81"   	"                                              	 "81"   	BLDG	30.544559504402589	-87.219904269609827	\N
114	"BLDG 82"   	"College of Fine and Performing Arts"           	 "82"   	BLDG	30.54543865449898	-87.217265369074724	\N
115	"BLDG 82B"  	"                                              	 "82B"  	BLDG	30.54485285206982	-87.217310735174109	\N
116	"BLDG 83"   	"                                              	 "83"   	BLDG	30.552341336453001	-87.217791961897433	\N
117	"BLDG 84"   	"                                              	 "84"   	BLDG	30.552718317707068	-87.218199886754775	\N
118	"BLDG 85"   	"                                              	 "85"   	BLDG	30.543670907670169	-87.216614504705134	\N
119	"BLDG 86"   	"                                              	 "86"   	BLDG	30.544177615753821	-87.21599858145926	\N
120	"BLDG 88"   	"                                              	 "88"   	BLDG	30.543465295055821	-87.219443377748988	\N
121	"BLDG 89"   	"                                              	 "89"   	BLDG	30.54224403569668	-87.21768478176287	\N
122	"BLDG 90"   	"                                              	 "90"   	BLDG	30.543512394852531	-87.213160655396848	\N
123	"BLDG 901"  	"                                              	 "901"  	BLDG	30.541936895212981	-87.216554573864073	\N
124	"BLDG 91"   	"                                              	 "91"   	BLDG	30.544582285561031	-87.213224571962428	\N
125	"BLDG 910"  	"                                              	 "910"  	BLDG	30.541702748845069	-87.212969305115223	\N
126	"BLDG 920"  	"                                              	 "920"  	BLDG	30.547587179168019	-87.213451192720896	\N
127	"BLDG 921"  	"                                              	 "921"  	BLDG	30.549097223153922	-87.214873807929536	\N
128	"BLDG 922"  	"                                              	 "922"  	BLDG	30.548858964504131	-87.214248907301013	\N
129	"BLDG 925"  	"                                              	 "925"  	BLDG	30.550968073877371	-87.214746977924435	\N
130	"BLDG 93"   	"                                              	 "93"   	BLDG	30.544797275871801	-87.212795536010859	\N
131	"BLDG 930"  	"                                              	 "930"  	BLDG	30.551884174711471	-87.21595590339831	\N
132	"BLDG 94"   	"                                              	 "94"   	BLDG	30.544596125027081	-87.21237602719016	\N
133	"BLDG 94A"  	"                                              	 "94A"  	BLDG	30.544754773307041	-87.212148076422181	\N
134	"BLDG 94B"  	"                                              	 "94B"  	BLDG	30.544566114031682	-87.212079807486035	\N
135	"BLDG 95"   	"                                              	 "95"   	BLDG	30.544721015658549	-87.214253770185763	\N
136	"BLDG 950"  	"                                              	 "950"  	BLDG	30.543441615959338	-87.221506845172073	\N
137	"BLDG 95A"  	"                                              	 "95A"  	BLDG	30.544963697379352	-87.214459468163284	\N
138	"BLDG 95B"  	"                                              	 "95B"  	BLDG	30.54521715381032	-87.213892987623339	\N
139	"BLDG 960"  	"                                              	 "960"  	BLDG	30.54556577274904	-87.219153301785653	\N
140	"BLDG 99"   	"                                              	 "99"   	BLDG	30.543072589394029	-87.214875906141529	\N
141	"BLDG 99A"  	"                                              	 "99A"  	BLDG	30.543435831010449	-87.214861632060433	\N
142	"BLDG A"    	"                                              	 "A"    	BLDG	30.541827944240449	-87.216354206851264	\N
143	"BLDG B"    	"                                              	 "B"    	BLDG	30.54156862032794	-87.216485129747866	\N
144	"BLDG C"    	"                                              	 "C"    	BLDG	30.541734459239301	-87.216969079403938	\N
145	"BLDG D"    	"                                              	 "D"    	BLDG	30.542009876017008	-87.216827227607141	\N
146	"BLDG E"    	"                                              	 "E"    	BLDG	30.541473553584371	-87.213608356086894	\N
147	"BLDG F"    	"                                              	 "F"    	BLDG	30.54130422360889	-87.213286499855101	\N
148	"BLDG G"    	"                                              	 "G"    	BLDG	30.54124115274659	-87.212568315118816	\N
149	"BLDG H"    	"                                              	 "H"    	BLDG	30.541552008918831	-87.212490417248276	\N
150	"BLDG T06"  	"                                              	 "T06"  	BLDG	30.553217506334089	-87.218651104733837	\N
151	"BLDG T11"  	"                                              	 "T11"  	BLDG	30.541611236276552	-87.206478154933009	\N
152	"BLDG T2"   	"                                              	 "T2"   	BLDG	30.547376922803348	-87.223420381531383	\N
153	"BLDG T27"  	"                                              	 "T27"  	BLDG	30.548320120693941	-87.218467941924445	\N
154	"BLDG T3"   	"                                              	 "T3"   	BLDG	30.54086653093945	-87.202186127200832	\N
155	"BLDG T30"  	"                                              	 "T30"  	BLDG	30.541017972429611	-87.203139796256707	\N
156	"BLDG T31"  	"                                              	 "T31"  	BLDG	30.541029156480182	-87.203232373263987	\N
157	"BLDG T32"  	"                                              	 "T32"  	BLDG	30.54104339602134	-87.203300662636337	\N
158	"BLDG T33"  	"                                              	 "T33"  	BLDG	30.541055663665979	-87.203391068290159	\N
159	"BLDG T34"  	"                                              	 "T34"  	BLDG	30.541115191386169	-87.203700084430352	\N
160	"BLDG T35"  	"                                              	 "T35"  	BLDG	30.54248526195617	-87.206447417238067	\N
161	"BLDG T42"  	"                                              	 "T42"  	BLDG	30.550336043772791	-87.219983444969472	\N
162	"BLDG T5"   	"                                              	 "T5"   	BLDG	30.547270145240081	-87.223375986401081	\N
163	"LDG 92"    	"                                              	 null   	"LDG" 	30.54502284041428	-87.21327036097766	\N
164	"LOT 34"    	"                                              	 null   	"LOT" 	30.550290331923211	-87.218219904125007	\N
165	"LOT 35"    	"                                              	 null   	"LOT" 	30.550358282330158	-87.217837676481977	\N
166	"LOT 77"    	"                                              	 null   	"LOT" 	30.54489938244695	-87.218696489930224	\N
167	"LOT A"     	"                                              	 null   	"LOT" 	30.545165999200162	-87.219955114799816	\N
168	"LOT AA"    	"                                              	 null   	"LOT" 	30.542390807841912	-87.217871518126572	\N
169	"LOT AV1"   	"                                              	 null   	"LOT" 	30.54054965583661	-87.198943016022909	\N
170	"LOT B"     	"                                              	 null   	"LOT" 	30.543895607858019	-87.220581176334662	\N
171	"LOT BB"    	"                                              	 null   	"LOT" 	30.543841329248352	-87.217442979310476	\N
172	"LOT C"     	"                                              	 null   	"LOT" 	30.543369238234721	-87.221719657526549	\N
173	"LOT CC"    	"                                              	 null   	"LOT" 	30.543226417637079	-87.215987291836385	\N
174	"LOT DC1"   	"                                              	 null   	"LOT" 	30.542784294767941	-87.198920330789491	\N
175	"LOT DD"    	"                                              	 null   	"LOT" 	30.542913756711009	-87.215768932400238	\N
176	"LOT DP1"   	"                                              	 null   	"LOT" 	30.54567220208224	-87.214453755753041	\N
177	"LOT E"     	"                                              	 null   	"LOT" 	30.54472568134824	-87.223197260485165	\N
178	"LOT EC1"   	"                                              	 null   	"LOT" 	30.540359799662539	-87.197721618131155	\N
179	"LOT EE"    	"                                              	 null   	"LOT" 	30.543820659365611	-87.215358405330306	\N
180	"LOT F"     	"                                              	 null   	"LOT" 	30.549081875320681	-87.222624148984437	\N
181	"LOT FF"    	"                                              	 null   	"LOT" 	30.54351368581974	-87.214874327177995	\N
182	"LOT G"     	"                                              	 null   	"LOT" 	30.54998980717626	-87.221678715015273	\N
183	"LOT GG"    	"                                              	 null   	"LOT" 	30.54207688488663	-87.21641521529169	\N
184	"LOT H"     	"                                              	 null   	"LOT" 	30.549338814552829	-87.219968280536037	\N
185	"LOT HC 2"  	"                                              	 null   	"LOT" 	30.54867460610981	-87.216792332595915	\N
186	"LOT HC 6"  	"                                              	 null   	"LOT" 	30.551722544560409	-87.219017405207239	\N
187	"LOT HC10"  	"                                              	 null   	"LOT" 	30.550983265458608	-87.217058996208138	\N
188	"LOT HC11"  	"                                              	 null   	"LOT" 	30.550626051969289	-87.217259666640629	\N
189	"LOT HC11"  	"                                              	 null   	"LOT" 	30.551610703046361	-87.220341858433287	\N
190	"LOT HC12"  	"                                              	 null   	"LOT" 	30.54416838396072	-87.216334646971546	\N
191	"LOT HC3"   	"                                              	 null   	"LOT" 	30.549049643122071	-87.216350905359519	\N
192	"LOT HC4"   	"                                              	 null   	"LOT" 	30.549790887813732	-87.216868642792505	\N
193	"LOT HC5"   	"                                              	 null   	"LOT" 	30.550552211901689	-87.216246971659629	\N
194	"LOT HC8"   	"                                              	 null   	"LOT" 	30.552227498019899	-87.218846205032847	\N
195	"LOT HC9"   	"                                              	 null   	"LOT" 	30.54457185088911	-87.216659490529665	\N
196	"LOT HH"    	"                                              	 null   	"LOT" 	30.541918715314068	-87.213262185931825	\N
197	"LOT I"     	"                                              	 null   	"LOT" 	30.54798470870838	-87.220888650499887	\N
198	"LOT J"     	"                                              	 null   	"LOT" 	30.54642017674011	-87.219348212752692	\N
199	"LOT K"     	"                                              	 null   	"LOT" 	30.547665069413441	-87.217950259477405	\N
200	"LOT L"     	"                                              	 null   	"LOT" 	30.546026198496669	-87.218464783817367	\N
201	"LOT M"     	"                                              	 null   	"LOT" 	30.545597861667559	-87.215821714471062	\N
202	"LOT O"     	"                                              	 null   	"LOT" 	30.547163685004119	-87.215329276233547	\N
203	"LOT P"     	"                                              	 null   	"LOT" 	30.548058056987081	-87.214980003550508	\N
204	"LOT Q"     	"                                              	 null   	"LOT" 	30.54994791715129	-87.214411505139225	\N
205	"LOT R"     	"                                              	 null   	"LOT" 	30.55021873259205	-87.215162821279506	\N
206	"LOT S"     	"                                              	 null   	"LOT" 	30.55172433392519	-87.214902669681081	\N
207	"LOT S1"    	"                                              	 null   	"LOT" 	30.54372155966561	-87.213475782712891	\N
208	"LOT S2"    	"                                              	 null   	"LOT" 	30.544559814487162	-87.213487350902057	\N
209	"LOT S3"    	"                                              	 null   	"LOT" 	30.544674365919839	-87.213941640378124	\N
210	"LOT S4"    	"                                              	 null   	"LOT" 	30.544813687422462	-87.212584835871368	\N
211	"LOT S4"    	"                                              	 null   	"LOT" 	30.54472063924948	-87.212976163453163	\N
212	"LOT SP1"   	"                                              	 null   	"LOT" 	30.541997965349019	-87.207325131895018	\N
213	"LOT SP1"   	"                                              	 null   	"LOT" 	30.540952162476959	-87.207865389768756	\N
214	"LOT SP2"   	"                                              	 null   	"LOT" 	30.541842631647679	-87.203252637313497	\N
215	"LOT SP2"   	"                                              	 null   	"LOT" 	30.542708521761281	-87.204822631305163	\N
216	"LOT T"     	"                                              	 null   	"LOT" 	30.552104750307269	-87.215527444260374	\N
217	"LOT U"     	"                                              	 null   	"LOT" 	30.553057649306449	-87.2164667423027	\N
218	"LOT V"     	"                                              	 null   	"LOT" 	30.553110939201272	-87.217798116817036	\N
219	"LOT W"     	"                                              	 null   	"LOT" 	30.553911135720249	-87.216993319303313	\N
220	"LOT X"     	"                                              	 null   	"LOT" 	30.554438329806668	-87.217111406914313	\N
221	"LOT Y"     	"                                              	 null   	"LOT" 	30.546749798824209	-87.213660917921104	\N
222	"LOT Z"     	"                                              	 null   	"LOT" 	30.545685957915818	-87.213130335046955	\N
223	"T36"       	"                                              	 null   	"T"   	30.54650067316814	-87.22054628387788	\N
224	"T37"       	"                                              	 null   	"T"   	30.546951616809569	-87.220466367780332	\N
225	"T38"       	"                                              	 null   	"T"   	30.54730683373241	-87.220322594309465	\N
\.


--
-- Data for Name: uwf_users; Type: TABLE DATA; Schema: public; Owner: twebb2
--

COPY uwf_users (id, username, salt, key, extra) FROM stdin;
\.


--
-- Name: uwf_buildings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: twebb2
--

SELECT pg_catalog.setval('uwf_buildings_id_seq', 1, false);


--
-- Name: uwf_users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: twebb2
--

SELECT pg_catalog.setval('uwf_users_id_seq', 1, false);


--
-- Name: uwf_buildings uwf_buildings_pkey; Type: CONSTRAINT; Schema: public; Owner: twebb2
--

ALTER TABLE ONLY uwf_buildings
    ADD CONSTRAINT uwf_buildings_pkey PRIMARY KEY (id);


--
-- Name: uwf_users uwf_users_pkey; Type: CONSTRAINT; Schema: public; Owner: twebb2
--

ALTER TABLE ONLY uwf_users
    ADD CONSTRAINT uwf_users_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

