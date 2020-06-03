DROP TABLE Sessions;

CREATE TABLE `Sessions` (
  `uID` int(11) NOT NULL,
  `SessionID` text NOT NULL,
  `SessionStart` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `uGroupIDs` text NOT NULL,
  `test` tinytext NOT NULL,
  UNIQUE KEY `uID` (`uID`),
  CONSTRAINT `Sessions_ibfk_1` FOREIGN KEY (`uID`) REFERENCES `user` (`uID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO Sessions VALUES("1","bc72759cc680b008ab693c61d9492f09b226e2d87ad032bdbd6b954d","2017-07-04 12:35:28","[\"1\",\"2\",\"4\"]","");
INSERT INTO Sessions VALUES("5","e0c5e3520294c69eb10cf6dd209ff259a9850d19ceb70cc541aa8784","2017-06-24 13:16:13","[\"2\"]","");
INSERT INTO Sessions VALUES("37","9e75d8b2d80f43106ff11e053c63fa2286c1c4daec50ec568a94e5e9","0000-00-00 00:00:00","[\"2\"]","");



DROP TABLE abgabe;

CREATE TABLE `abgabe` (
  `abID` int(11) NOT NULL AUTO_INCREMENT,
  `fID` int(11) NOT NULL,
  `abTyp` int(11) NOT NULL COMMENT '1:Videovertonung; 2:Videovertonung Bewertung; 3: Präsentation fertig; 4:...',
  `token` varchar(25) NOT NULL,
  `zu_abID` varchar(25) NOT NULL COMMENT 'bei Korrektur: zugehöriger Token der ursprünglichen Abgabe',
  `parameter` text NOT NULL,
  `datum` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`abID`),
  UNIQUE KEY `fID_token_zu_token` (`fID`,`token`,`zu_abID`),
  CONSTRAINT `abgabe_ibfk_1` FOREIGN KEY (`fID`) REFERENCES `folien` (`fID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=750 DEFAULT CHARSET=utf8;

INSERT INTO abgabe VALUES("42","16","1","58176dc708269","","{\"audioArr\":[{\"fileName\":\"16_58176dc708269_705fb880-7cef-fa31-8448-3dab18753011.wav\",\"abgegeben\":1}],\"fID\":16,\"token\":\"58176dc708269\"}","2017-03-27 16:50:16");
INSERT INTO abgabe VALUES("43","15","1","58176dc708269","","{\"audioArr\":[{\"fileName\":\"15_58176dc708269_0e23566f-64a3-71e7-3513-5b9b6669cff7.wav\",\"abgegeben\":1}],\"fID\":15,\"token\":\"58176dc708269\"}","2017-02-07 11:22:03");
INSERT INTO abgabe VALUES("44","13","1","58176dc708648","","{\"audioArr\":[{\"fileName\":\"13_58176dc708648_0d2b852e-b97b-ed1c-d1db-35a6a0c2b1d9.wav\",\"abgegeben\":0},{\"fileName\":\"13_58176dc708648_89215a09-6eab-2f06-6228-10cc69ca96a8.wav\",\"abgegeben\":0},{\"fileName\":\"13_58176dc708648_6d2738dc-dc81-fe37-a4ac-0ad1b86a2850.wav\",\"abgegeben\":0},{\"fileName\":\"13_58176dc708648_e2a1f23c-3829-5509-3541-f90e81714279.wav\",\"abgegeben\":0},{\"fileName\":\"13_58176dc708648_136bbbd8-2131-bec3-0d7f-bb45d0a87192.wav\",\"abgegeben\":1}],\"fID\":13,\"token\":\"58176dc708648\"}","2017-02-11 11:07:31");
INSERT INTO abgabe VALUES("61","22","3","58176dc708648","","{\"abgegeben\":1}","0000-00-00 00:00:00");
INSERT INTO abgabe VALUES("62","18","1","58176dc708648","","{\"audioArr\":[{\"fileName\":\"18_58176dc708648_4da3a0f1-622c-fc92-ec9c-2ab5e8dab725.wav\",\"abgegeben\":1}],\"fID\":18,\"token\":\"58176dc708648\"}","2017-02-11 14:25:04");
INSERT INTO abgabe VALUES("63","17","1","58176dc708648","","{\"audioArr\":[{\"fileName\":\"17_58176dc708648_85b84be5-a48f-8c4e-1aea-9cc0735dd189.wav\",\"abgegeben\":1}],\"fID\":17,\"token\":\"58176dc708648\"}","2017-02-11 14:27:05");
INSERT INTO abgabe VALUES("64","31","3","58176dc708648","","{\"abgegeben\":1}","0000-00-00 00:00:00");
INSERT INTO abgabe VALUES("65","33","2","58176dc708648","44","{\"FragenWerte\":{\"20\":\"5\",\"17\":\"19\",\"26\":\"11\"},\"kommentar\":\"Zeile 1Zeile 2Zeile 3\",\"PosTimeArr\":[\"4.758232\"],\"PosTxtArr\":[\"Testmarkierung\"]}","2017-02-12 13:52:39");
INSERT INTO abgabe VALUES("73","4","1","587cfb68d369f","","{\"audioArr\":[{\"fileName\":\"4_587cfb68d369f_f754e00a-af73-810c-eafc-98d1c163c6f1.wav\",\"abgegeben\":0},{\"fileName\":\"4_587cfb68d369f_6ec6c42e-4bc1-c61c-5702-048c31aa2bbe.wav\",\"abgegeben\":0},{\"fileName\":\"4_587cfb68d369f_1c1f9894-f3e3-3a05-ab96-ae0d4cffbe05.wav\",\"abgegeben\":0},{\"fileName\":\"4_587cfb68d369f_b41b27b5-ef21-47fe-1fe5-ea5006f7a2ab.wav\",\"abgegeben\":0},{\"fileName\":\"4_587cfb68d369f_ce2e3c38-a9a4-868f-cc61-ba944c777cd4.wav\",\"abgegeben\":0},{\"fileName\":\"4_587cfb68d369f_1e20ca13-52ff-0d61-f3de-5e4a3d54ff15.wav\",\"abgegeben\":1}],\"fID\":4,\"token\":\"587cfb68d369f\"}","2017-02-12 16:10:00");
INSERT INTO abgabe VALUES("79","10","2","587cfb68d369f","73","{\"FragenWerte\":{\"17\":\"10\",\"18\":\"12\",\"19\":\"40\",\"20\":\"6\",\"26\":\"11\"},\"kommentar\":\"Hallo \",\"PosTimeArr\":[\"    87.862435\",\" 2.575089\",\"3.638292\"],\"PosTxtArr\":[\"test bei 88s\",\"bei 3s\",\"test\"]}","2017-02-12 17:17:50");
INSERT INTO abgabe VALUES("225","37","3","587cff5edbcb5x","","{\"abgegeben\":\"1\",\"abstOption_1\":\"3\",\"WordCloud_2\":[\"Best Card\",\"Ticket\",\"Juhu\",\"es\",\"hat\",\"geklappt\"]}","2017-02-19 01:18:44");
INSERT INTO abgabe VALUES("366","37","3","587cff5edbcb5","","{\"abgegeben\":\"1\",\"WordCloud_2\":[\"Abgabe 2\",\"Mein\",\"Champ\"],\"Abst_Option_1\":\"0\"}","2017-02-18 14:12:43");
INSERT INTO abgabe VALUES("369","37","3","587cff5edb0f4","","{\"abgegeben\":\"1\",\"abstOption_1\":\"1\",\"WordCloud_2\":[]}","2017-02-19 01:18:44");
INSERT INTO abgabe VALUES("371","41","3","58a8a81f420db","","{\"abgegeben\":\"1\",\"KoFra_Option_2\":[\"4\"]}","2017-02-18 20:25:16");
INSERT INTO abgabe VALUES("376","42","3","58a8a81f420db","","{\"abgegeben\":\"1\",\"WordCloud_2\":[\"Halbschatten\",\"Kernschatten\",\"Mond\"]}","2017-02-18 20:27:53");
INSERT INTO abgabe VALUES("382","43","3","58a8a81f420db","","{\"abgegeben\":\"1\",\"abstOption_1\":\"0\"}","2017-02-19 01:18:44");
INSERT INTO abgabe VALUES("390","40","3","58a8a81f420db","","{\"abgegeben\":\"1\"}","2017-02-18 20:47:15");
INSERT INTO abgabe VALUES("391","39","3","58a8a81f420db","","{\"abgegeben\":\"1\"}","2017-02-18 20:47:24");
INSERT INTO abgabe VALUES("392","38","3","58a8a81f420db","","{\"abgegeben\":\"1\"}","2017-02-18 20:47:28");
INSERT INTO abgabe VALUES("393","41","3","58a8a81f42c81","","{\"abgegeben\":\"1\",\"KoFra_Option_2\":[\"2\",\"4\"]}","2017-02-18 21:08:26");
INSERT INTO abgabe VALUES("394","42","3","58a8a81f42c81","","{\"abgegeben\":\"1\",\"WordCloud_2\":[\"M&uuml;ller\",\"Vidal\",\"Neuer\"]}","2017-02-18 21:09:14");
INSERT INTO abgabe VALUES("396","42","3","58a8a81f435bf","","{\"abgegeben\":\"1\",\"WordCloud_2\":[\"Ziel\",\"Methoden\",\"Experimentieren\",\"Girwidz\",\"Bianca\",\"Vidal\",\"Mond\",\"Halbschatten\",\"Lahm\"]}","2017-02-19 15:53:34");
INSERT INTO abgabe VALUES("402","44","1","587cf6ad35732","","{\"audioArr\":[{\"fileName\":\"44_587cf6ad35732_5d65f784-be9f-5abf-5b68-969ac3c7c99b.wav\",\"abgegeben\":1}],\"fID\":44,\"token\":\"587cf6ad35732\"}","2017-02-18 23:34:17");
INSERT INTO abgabe VALUES("423","38","3","58a8a81f42c81","","{\"abgegeben\":\"1\"}","2017-02-19 12:07:47");
INSERT INTO abgabe VALUES("425","38","3","58a8a81f44108","","{\"abgegeben\":\"1\"}","2017-02-19 12:04:33");
INSERT INTO abgabe VALUES("430","39","3","58a8a81f42c81","","{\"abgegeben\":\"1\"}","2017-02-19 14:41:56");
INSERT INTO abgabe VALUES("431","40","3","58a8a81f42c81","","{\"abgegeben\":\"1\"}","2017-02-19 15:08:37");
INSERT INTO abgabe VALUES("432","38","3","58a8a81f435bf","","{\"abgegeben\":\"1\"}","2017-02-19 15:40:19");
INSERT INTO abgabe VALUES("433","39","3","58a8a81f435bf","","{\"abgegeben\":\"1\"}","2017-02-19 15:41:15");
INSERT INTO abgabe VALUES("434","40","3","58a8a81f435bf","","{\"abgegeben\":\"1\"}","2017-02-19 15:52:28");
INSERT INTO abgabe VALUES("438","41","3","58a8a81f435bf","","{\"abgegeben\":\"1\",\"KoFra_Option_2\":[\"3\"]}","2017-02-19 15:53:04");
INSERT INTO abgabe VALUES("440","43","3","58a8a81f435bf","","{\"abgegeben\":\"1\",\"abstOption_1\":\"1\"}","2017-02-19 16:10:57");
INSERT INTO abgabe VALUES("441","43","3","58a8a81f42c81","","{\"abgegeben\":\"1\",\"abstOption_1\":\"1\"}","2017-02-19 16:12:39");
INSERT INTO abgabe VALUES("442","48","1","587cf6ad35732","","{\"audioArr\":[{\"fileName\":\"48_587cf6ad35732_f6785ff7-9269-c80d-3764-d1e116e83151.wav\",\"abgegeben\":1}],\"fID\":48,\"token\":\"587cf6ad35732\"}","2017-02-20 08:30:33");
INSERT INTO abgabe VALUES("447","49","2","587cfb3be2c82","442","{\"FragenWerte\":{\"20\":\"10\",\"17\":\"44\",\"26\":\"10\"},\"kommentar\":\"Kommentar 2\",\"PosTimeArr\":[\"4.697633\",\"6.600725\"],\"PosTxtArr\":[\"Mark 1\",\"Mark 2\"]}","0000-00-00 00:00:00");
INSERT INTO abgabe VALUES("448","39","3","58a8a81f44108","","{\"abgegeben\":\"1\"}","2017-02-20 14:01:10");
INSERT INTO abgabe VALUES("449","40","3","58a8a81f44108","","{\"abgegeben\":\"1\"}","2017-02-20 14:01:50");
INSERT INTO abgabe VALUES("450","41","3","58a8a81f44108","","{\"abgegeben\":\"1\",\"KoFra_Option_2\":[\"1\",\"4\"]}","2017-02-20 14:02:47");
INSERT INTO abgabe VALUES("451","42","3","58a8a81f44108","","{\"abgegeben\":\"1\",\"WordCloud_2\":[\"Kerze\",\"Kernschatten\"]}","2017-02-20 14:08:18");
INSERT INTO abgabe VALUES("453","43","3","58a8a81f44108","","{\"abgegeben\":\"1\",\"abstOption_1\":\"1\"}","2017-02-20 14:09:11");
INSERT INTO abgabe VALUES("454","38","3","58aaabf3618ff","","{\"abgegeben\":\"1\"}","2017-02-21 13:36:16");
INSERT INTO abgabe VALUES("455","39","3","58aaabf3618ff","","{\"abgegeben\":\"1\"}","2017-02-21 13:36:31");
INSERT INTO abgabe VALUES("456","40","3","58aaabf3618ff","","{\"abgegeben\":\"1\"}","2017-02-21 13:37:39");
INSERT INTO abgabe VALUES("457","41","3","58aaabf3618ff","","{\"abgegeben\":\"1\"}","2017-02-21 13:37:53");
INSERT INTO abgabe VALUES("458","42","3","58aaabf3618ff","","{\"abgegeben\":\"1\",\"WordCloud_2\":[\"dadada\"]}","2017-02-21 13:38:50");
INSERT INTO abgabe VALUES("460","43","3","58aaabf3618ff","","{\"abgegeben\":\"1\",\"abstOption_1\":\"4\"}","2017-02-21 13:39:14");
INSERT INTO abgabe VALUES("461","47","3","58aaabf3618ff","","{\"abgegeben\":\"1\",\"txt_bottom\":\"\"}","2017-02-21 13:39:38");
INSERT INTO abgabe VALUES("462","38","3","58aaabf36119b","","{\"abgegeben\":\"1\"}","2017-02-23 14:13:21");
INSERT INTO abgabe VALUES("463","39","3","58aaabf36119b","","{\"abgegeben\":\"1\"}","2017-02-23 14:14:07");
INSERT INTO abgabe VALUES("464","40","3","58aaabf36119b","","{\"abgegeben\":\"1\"}","2017-02-23 14:16:06");
INSERT INTO abgabe VALUES("465","41","3","58aaabf36119b","","{\"abgegeben\":\"1\",\"KoFra_Option_2\":[\"3\",\"5\"]}","2017-02-23 14:16:45");
INSERT INTO abgabe VALUES("466","42","3","58aaabf36119b","","{\"abgegeben\":\"1\",\"WordCloud_2\":[\"Thurnes\",\"Hannah\",\"Kerze\"]}","2017-02-23 14:19:29");
INSERT INTO abgabe VALUES("469","43","3","58aaabf36119b","","{\"abgegeben\":\"1\",\"abstOption_1\":\"1\"}","2017-02-23 14:20:17");
INSERT INTO abgabe VALUES("470","49","2","58aaabf36119b","442","{\"FragenWerte\":{\"20\":\"8\",\"17\":\"26\",\"26\":\"8\"},\"kommentar\":\"\",\"PosTimeArr\":[\"6.34284\"],\"PosTxtArr\":[\"Hallo \"]}","0000-00-00 00:00:00");
INSERT INTO abgabe VALUES("477","37","3","587d016e33149","","{\"abgegeben\":\"1\",\"abstOption_1\":\"1\",\"WordCloud_2\":[\"Test\"]}","2017-03-06 09:46:36");
INSERT INTO abgabe VALUES("493","72","1","587cf6ad35732","","{\"audioArr\":[{\"fileName\":\"72_587cf6ad35732_51421a96-d324-a1a5-5b74-2ac60770100e.wav\",\"abgegeben\":1}],\"fID\":72,\"token\":\"587cf6ad35732\"}","2017-03-14 08:52:57");
INSERT INTO abgabe VALUES("502","73","2","587cfb3be2c82","493","{\"FragenWerte\":{\"16\":\"12\",\"20\":\"13\"},\"kommentar\":\"\",\"PosTimeArr\":[],\"PosTxtArr\":[]}","0000-00-00 00:00:00");
INSERT INTO abgabe VALUES("503","75","2","587cfb3be2c82","493","{\"FragenWerte\":{\"16\":\"4\",\"17\":\"50\",\"20\":\"4\",\"26\":\"14\"},\"kommentar\":\"\",\"PosTimeArr\":[],\"PosTxtArr\":[]}","0000-00-00 00:00:00");
INSERT INTO abgabe VALUES("504","77","1","587cfb3be2c82","","{\"audioArr\":[{\"fileName\":\"77_587cfb3be2c82_7b9ebc22-8dfe-dccc-ab4f-aa53ebf7cd9a.wav\",\"abgegeben\":1}],\"fID\":77,\"token\":\"587cfb3be2c82\"}","2017-03-14 12:01:01");
INSERT INTO abgabe VALUES("507","86","2","587cf6ad35732a","","{\"FragenWerte\":{\"17\":\"20\",\"20\":\"10\",\"26\":\"6\"},\"kommentar\":\"ab1 \",\"PosTimeArr\":[\" 1.909249\",\"0\"],\"PosTxtArr\":[\"dsf0000\",\"Test 12342\"]}","2017-03-27 16:18:33");
INSERT INTO abgabe VALUES("514","86","2","587cf6ad35732c","","{\"FragenWerte\":{\"17\":\"6\",\"20\":\"14\",\"26\":\"2\"},\"kommentar\":\"sdfdfs \",\"PosTimeArr\":[\"   1.909249\",\"  0\"],\"PosTxtArr\":[\"dsf123\",\"Test 2\"]}","2017-03-27 16:51:09");
INSERT INTO abgabe VALUES("517","86","2","587cfb3be2c82","","{\"FragenWerte\":{\"17\":\"27\",\"20\":\"14\",\"26\":\"2\"},\"kommentar\":\"sdfdfs \",\"PosTimeArr\":[\"  1.909249\",\" 0\"],\"PosTxtArr\":[\"dsf123\",\"Test 2\"]}","2017-03-27 16:56:02");
INSERT INTO abgabe VALUES("524","87","1","587cf6ad35732","","{\"audioArr\":[{\"fileName\":\"87_587cf6ad35732_f0eb3f35-7d4f-3fbc-b76d-9f13a732ef69.wav\",\"abgegeben\":1}],\"fID\":87,\"token\":\"587cf6ad35732\"}","2017-04-03 09:47:08");
INSERT INTO abgabe VALUES("525","62","1","587cf6ad35732","","{\"audioArr\":[{\"fileName\":\"62_587cf6ad35732_3af89304-da1d-362f-b822-760babb83bde.wav\",\"abgegeben\":1},{\"fileName\":\"62_587cf6ad35732_3692b9c9-b74c-f043-6a0d-508e1853fbb4.wav\",\"abgegeben\":0}],\"fID\":62,\"token\":\"587cf6ad35732\"}","2017-04-03 09:48:16");
INSERT INTO abgabe VALUES("527","90","1","587cf6ad35732","","{\"audioArr\":[{\"fileName\":\"90_587cf6ad35732_bd6992ef-87a2-14f1-6f93-af30823ca486.wav\",\"abgegeben\":1}],\"fID\":90,\"token\":\"587cf6ad35732\"}","2017-04-03 11:26:46");
INSERT INTO abgabe VALUES("576","107","3","587cfb3be2c82","","{\"abgegeben\":\"1\",\"KoFra_Option_1\":[\"2\",\"5\"],\"txt_2\":\"&lt;p&gt;Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.&lt;/p&gt;\"}","2017-05-09 15:32:35");
INSERT INTO abgabe VALUES("577","107","3","587cfb68d369f","","{\"abgegeben\":\"1\",\"KoFra_Option_1\":[\"4\",\"2\",\"3\"],\"txt_2\":\"&lt;p&gt;Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.&lt;/p&gt;\"}","2017-05-09 15:32:35");
INSERT INTO abgabe VALUES("580","108","3","587cfb68d369f","","{\"abgegeben\":\"1\",\"abstOption_1\":[\"1\",\"3\",\"0\"],\"WordCloud_2\":[\"Katze\",\"Wasser\",\"Schall\"]}","2017-05-09 16:36:32");
INSERT INTO abgabe VALUES("581","108","3","587cfb3be2c82","","{\"abgegeben\":\"1\",\"abstOption_1\":[\"3\",\"2\",\"1\"],\"WordCloud_2\":[\"Wellengleichung\",\"Wasser\"]}","2017-05-09 16:35:54");
INSERT INTO abgabe VALUES("582","105","3","59088a122b14e","","{\"abgegeben\":\"1\",\"FragenWerte_top\":{\"17\":\"41\",\"20\":\"5\",\"26\":\"11\"}}","2017-05-23 12:29:39");
INSERT INTO abgabe VALUES("583","99","3","59088a122b14e","","{\"abgegeben\":\"1\",\"FragenWerte_2\":{\"17\":\"35\",\"20\":\"4\",\"26\":\"10\"}}","2017-05-23 12:29:44");
INSERT INTO abgabe VALUES("584","101","3","59088a122b14e","","{\"abgegeben\":\"1\"}","2017-05-23 12:29:46");
INSERT INTO abgabe VALUES("585","102","3","59088a122b14e","","{\"abgegeben\":\"1\"}","2017-05-23 12:29:49");
INSERT INTO abgabe VALUES("586","104","3","59088a122b14e","","{\"abgegeben\":\"1\"}","2017-05-23 12:29:51");
INSERT INTO abgabe VALUES("587","107","3","59088a122b14e","","{\"abgegeben\":\"1\",\"KoFra_Option_1\":[\"1\",\"3\",\"5\"],\"txt_2\":\"\"}","2017-05-23 12:29:57");
INSERT INTO abgabe VALUES("588","108","3","59088a122b14e","","{\"abgegeben\":\"1\",\"abstOption_1\":[\"1\",\"3\"],\"WordCloud_2\":[\"Test\"]}","2017-05-23 12:30:07");
INSERT INTO abgabe VALUES("590","105","3","59088a122bd16","","{\"abgegeben\":\"1\",\"FragenWerte_top\":{\"17\":\"39\",\"20\":\"12\",\"26\":\"12\"}}","2017-05-23 12:32:41");
INSERT INTO abgabe VALUES("591","99","3","59088a122bd16","","{\"abgegeben\":\"1\",\"FragenWerte_2\":{\"17\":\"40\",\"20\":\"11\",\"26\":\"10\"}}","2017-05-23 12:32:46");
INSERT INTO abgabe VALUES("592","101","3","59088a122bd16","","{\"abgegeben\":\"1\"}","2017-05-23 12:33:32");
INSERT INTO abgabe VALUES("593","102","3","59088a122bd16","","{\"abgegeben\":\"1\"}","2017-05-23 12:38:18");
INSERT INTO abgabe VALUES("595","104","3","59088a122bd16","","{\"abgegeben\":\"1\"}","2017-05-23 12:54:29");
INSERT INTO abgabe VALUES("596","107","3","59088a122bd16","","{\"abgegeben\":\"1\",\"KoFra_Option_1\":[\"3\",\"4\"],\"txt_2\":\"\"}","2017-05-23 13:17:48");
INSERT INTO abgabe VALUES("597","108","3","59088a122bd16","","{\"abgegeben\":\"1\",\"WordCloud_2\":[]}","2017-05-23 13:17:58");
INSERT INTO abgabe VALUES("598","105","3","59088a122d620","","{\"abgegeben\":\"1\",\"FragenWerte_top\":{\"17\":\"26\",\"20\":\"8\",\"26\":\"8\"}}","2017-05-23 14:48:10");
INSERT INTO abgabe VALUES("599","99","3","59088a122d620","","{\"abgegeben\":\"1\",\"FragenWerte_2\":{\"17\":\"26\",\"20\":\"8\",\"26\":\"8\"}}","2017-05-23 20:14:55");
INSERT INTO abgabe VALUES("600","104","3","59088a122d620","","{\"abgegeben\":\"1\"}","2017-05-23 20:15:37");
INSERT INTO abgabe VALUES("601","107","3","59088a122d620","","{\"abgegeben\":\"1\",\"KoFra_Option_1\":[\"3\",\"5\"],\"txt_2\":\"\"}","2017-05-23 20:16:00");
INSERT INTO abgabe VALUES("602","108","3","59088a122d620","","{\"abgegeben\":\"1\",\"abstOption_1\":[\"1\",\"2\"],\"WordCloud_2\":[\"Test\"]}","2017-05-23 20:16:12");
INSERT INTO abgabe VALUES("609","105","3","59088a1238d8b","","{\"abgegeben\":\"1\",\"FragenWerte_top\":{\"16\":\"2\",\"17\":\"3\",\"20\":\"0\",\"35\":\"3\",\"36\":\"Moritz\",\"26\":\"2\",\"28\":\"3\",\"29\":\"3\",\"30\":\"3\",\"31\":\"3\",\"32\":\"3\",\"33\":\"3\",\"34\":\"3\"}}","2017-06-13 08:12:09");
INSERT INTO abgabe VALUES("610","105","3","59088a1237ff6","","{\"abgegeben\":\"1\",\"FragenWerte_top\":{\"16\":\"2\",\"17\":\"3\",\"20\":\"0\",\"35\":\"3\",\"36\":\"Peter\",\"26\":\"2\",\"28\":\"3\",\"29\":\"3\",\"30\":\"3\",\"31\":\"3\",\"32\":\"3\",\"33\":\"3\",\"34\":\"3\"}}","2017-06-13 09:21:43");
INSERT INTO abgabe VALUES("611","1268","3","59432bd84583b","","{\"abgegeben\":\"1\",\"abstOption_2\":[\"1\"]}","2017-06-16 08:32:24");
INSERT INTO abgabe VALUES("619","1268","3","59439879e4b6f","","{\"abgegeben\":\"1\",\"abstOption_2\":[\"1\"]}","2017-06-16 08:37:56");
INSERT INTO abgabe VALUES("621","1267","3","594399056bb1d","","{\"abgegeben\":\"1\"}","2017-06-16 08:38:40");
INSERT INTO abgabe VALUES("622","1268","3","594399056bb1d","","{\"abgegeben\":\"1\",\"abstOption_2\":[\"1\"]}","2017-06-16 08:38:53");
INSERT INTO abgabe VALUES("624","1267","3","5943f320d6611","","{\"abgegeben\":\"1\"}","2017-06-16 15:03:02");
INSERT INTO abgabe VALUES("625","1268","3","5943f320d6611","","{\"abgegeben\":\"1\",\"abstOption_2\":[\"1\"]}","2017-06-16 15:15:30");
INSERT INTO abgabe VALUES("626","1269","3","5943f320d6611","","{\"abgegeben\":\"1\",\"abstOption_2\":[\"1\"]}","2017-06-16 15:15:52");
INSERT INTO abgabe VALUES("627","1267","3","5943f635caf4b","","{\"abgegeben\":\"1\"}","2017-06-16 15:16:22");
INSERT INTO abgabe VALUES("629","1268","3","5943f635caf4b","","{\"abgegeben\":\"1\",\"abstOption_2\":[\"1\"]}","2017-06-16 15:16:27");
INSERT INTO abgabe VALUES("630","1267","3","5943f69033a56","","{\"abgegeben\":\"1\"}","2017-06-16 15:17:42");
INSERT INTO abgabe VALUES("631","1268","3","5943f69033a56","","{\"abgegeben\":\"1\",\"abstOption_2\":[\"1\"]}","2017-06-16 15:17:46");
INSERT INTO abgabe VALUES("632","1269","3","5943f69033a56","","{\"abgegeben\":\"1\",\"abstOption_2\":[\"1\"]}","2017-06-16 15:17:50");
INSERT INTO abgabe VALUES("633","105","3","5947bd925dd5c","","{\"abgegeben\":\"1\",\"FragenWerte_top\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_top_90_minVal\":\"1\",\"f_top_91_minVal\":\"1\",\"f_top_92_minVal\":\"1\",\"f_top_93_minVal\":\"1\",\"f_top_94_minVal\":\"1\",\"f_top_95_minVal\":\"1\",\"f_top_96_minVal\":\"1\",\"f_top_97_minVal\":\"1\",\"f_top_98_minVal\":\"1\",\"f_top_99_minVal\":\"1\",\"f_top_100_minVal\":\"1\",\"f_top_101_minVal\":\"1\",\"f_top_102_minVal\":\"1\",\"f_top_103_minVal\":\"1\",\"f_top_104_minVal\":\"1\",\"f_top_105_minVal\":\"1\"}","2017-06-19 12:03:50");
INSERT INTO abgabe VALUES("634","99","3","5947bd925dd5c","","{\"abgegeben\":\"1\",\"FragenWerte_2\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_2_90_minVal\":\"1\",\"f_2_91_minVal\":\"1\",\"f_2_92_minVal\":\"1\",\"f_2_93_minVal\":\"1\",\"f_2_94_minVal\":\"1\",\"f_2_95_minVal\":\"1\",\"f_2_96_minVal\":\"1\",\"f_2_97_minVal\":\"1\",\"f_2_98_minVal\":\"1\",\"f_2_99_minVal\":\"1\",\"f_2_100_minVal\":\"1\",\"f_2_101_minVal\":\"1\",\"f_2_102_minVal\":\"1\",\"f_2_103_minVal\":\"1\",\"f_2_104_minVal\":\"1\",\"f_2_105_minVal\":\"1\"}","2017-06-19 12:03:58");
INSERT INTO abgabe VALUES("635","101","3","5947bd925dd5c","","{\"abgegeben\":\"1\",\"WordCloud_2\":[]}","2017-06-19 12:04:03");
INSERT INTO abgabe VALUES("636","102","3","5947bd925dd5c","","{\"abgegeben\":\"1\"}","2017-06-19 12:04:07");
INSERT INTO abgabe VALUES("637","105","3","5947be1b2a63d","","{\"abgegeben\":\"1\",\"FragenWerte_top\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_top_90_minVal\":\"1\",\"f_top_91_minVal\":\"1\",\"f_top_92_minVal\":\"1\",\"f_top_93_minVal\":\"1\",\"f_top_94_minVal\":\"1\",\"f_top_95_minVal\":\"1\",\"f_top_96_minVal\":\"1\",\"f_top_97_minVal\":\"1\",\"f_top_98_minVal\":\"1\",\"f_top_99_minVal\":\"1\",\"f_top_100_minVal\":\"1\",\"f_top_101_minVal\":\"1\",\"f_top_102_minVal\":\"1\",\"f_top_103_minVal\":\"1\",\"f_top_104_minVal\":\"1\",\"f_top_105_minVal\":\"1\"}","2017-06-19 12:05:53");
INSERT INTO abgabe VALUES("638","99","3","5947be1b2a63d","","{\"abgegeben\":\"1\",\"FragenWerte_2\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_2_90_minVal\":\"1\",\"f_2_91_minVal\":\"1\",\"f_2_92_minVal\":\"1\",\"f_2_93_minVal\":\"1\",\"f_2_94_minVal\":\"1\",\"f_2_95_minVal\":\"1\",\"f_2_96_minVal\":\"1\",\"f_2_97_minVal\":\"1\",\"f_2_98_minVal\":\"1\",\"f_2_99_minVal\":\"1\",\"f_2_100_minVal\":\"1\",\"f_2_101_minVal\":\"1\",\"f_2_102_minVal\":\"1\",\"f_2_103_minVal\":\"1\",\"f_2_104_minVal\":\"1\",\"f_2_105_minVal\":\"1\"}","2017-06-19 12:06:23");
INSERT INTO abgabe VALUES("641","101","3","5947be1b2a63d","","{\"abgegeben\":\"1\",\"WordCloud_2\":[]}","2017-06-19 12:06:26");
INSERT INTO abgabe VALUES("642","102","3","5947be1b2a63d","","{\"abgegeben\":\"1\"}","2017-06-19 12:06:28");
INSERT INTO abgabe VALUES("643","104","3","5947be1b2a63d","","{\"abgegeben\":\"1\"}","2017-06-19 12:06:30");
INSERT INTO abgabe VALUES("644","107","3","5947be1b2a63d","","{\"abgegeben\":\"1\",\"KoFra_Option_1\":[\"3\"],\"txt_2\":\"\"}","2017-06-19 12:06:34");
INSERT INTO abgabe VALUES("645","108","3","5947be1b2a63d","","{\"abgegeben\":\"1\",\"abstOption_1\":[\"2\"],\"WordCloud_2\":[]}","2017-06-19 12:06:39");
INSERT INTO abgabe VALUES("646","105","3","5947be681b140","","{\"abgegeben\":\"1\",\"FragenWerte_top\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_top_90_minVal\":\"1\",\"f_top_91_minVal\":\"1\",\"f_top_92_minVal\":\"1\",\"f_top_93_minVal\":\"1\",\"f_top_94_minVal\":\"1\",\"f_top_95_minVal\":\"1\",\"f_top_96_minVal\":\"1\",\"f_top_97_minVal\":\"1\",\"f_top_98_minVal\":\"1\",\"f_top_99_minVal\":\"1\",\"f_top_100_minVal\":\"1\",\"f_top_101_minVal\":\"1\",\"f_top_102_minVal\":\"1\",\"f_top_103_minVal\":\"1\",\"f_top_104_minVal\":\"1\",\"f_top_105_minVal\":\"1\"}","2017-06-19 12:07:21");
INSERT INTO abgabe VALUES("647","99","3","5947be681b140","","{\"abgegeben\":\"1\",\"FragenWerte_2\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_2_90_minVal\":\"1\",\"f_2_91_minVal\":\"1\",\"f_2_92_minVal\":\"1\",\"f_2_93_minVal\":\"1\",\"f_2_94_minVal\":\"1\",\"f_2_95_minVal\":\"1\",\"f_2_96_minVal\":\"1\",\"f_2_97_minVal\":\"1\",\"f_2_98_minVal\":\"1\",\"f_2_99_minVal\":\"1\",\"f_2_100_minVal\":\"1\",\"f_2_101_minVal\":\"1\",\"f_2_102_minVal\":\"1\",\"f_2_103_minVal\":\"1\",\"f_2_104_minVal\":\"1\",\"f_2_105_minVal\":\"1\"}","2017-06-19 12:07:25");
INSERT INTO abgabe VALUES("648","101","3","5947be681b140","","{\"abgegeben\":\"1\",\"WordCloud_2\":[]}","2017-06-19 12:07:44");
INSERT INTO abgabe VALUES("649","102","3","5947be681b140","","{\"abgegeben\":\"1\"}","2017-06-19 12:07:50");
INSERT INTO abgabe VALUES("650","104","3","5947be681b140","","{\"abgegeben\":\"1\"}","2017-06-19 12:09:09");
INSERT INTO abgabe VALUES("651","107","3","5947be681b140","","{\"abgegeben\":\"1\",\"KoFra_Option_1\":[\"2\"],\"txt_2\":\"\"}","2017-06-19 12:21:01");
INSERT INTO abgabe VALUES("652","105","3","5947c212bd2e2","","{\"abgegeben\":\"1\",\"FragenWerte_top\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_top_90_minVal\":\"1\",\"f_top_91_minVal\":\"1\",\"f_top_92_minVal\":\"1\",\"f_top_93_minVal\":\"1\",\"f_top_94_minVal\":\"1\",\"f_top_95_minVal\":\"1\",\"f_top_96_minVal\":\"1\",\"f_top_97_minVal\":\"1\",\"f_top_98_minVal\":\"1\",\"f_top_99_minVal\":\"1\",\"f_top_100_minVal\":\"1\",\"f_top_101_minVal\":\"1\",\"f_top_102_minVal\":\"1\",\"f_top_103_minVal\":\"1\",\"f_top_104_minVal\":\"1\",\"f_top_105_minVal\":\"1\"}","2017-06-19 12:31:03");
INSERT INTO abgabe VALUES("653","101","3","5947c212bd2e2","","{\"abgegeben\":\"1\",\"WordCloud_2\":[]}","2017-06-19 12:41:35");
INSERT INTO abgabe VALUES("654","99","3","5947c212bd2e2","","{\"abgegeben\":\"1\",\"FragenWerte_2\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_2_90_minVal\":\"1\",\"f_2_91_minVal\":\"1\",\"f_2_92_minVal\":\"1\",\"f_2_93_minVal\":\"1\",\"f_2_94_minVal\":\"1\",\"f_2_95_minVal\":\"1\",\"f_2_96_minVal\":\"1\",\"f_2_97_minVal\":\"1\",\"f_2_98_minVal\":\"1\",\"f_2_99_minVal\":\"1\",\"f_2_100_minVal\":\"1\",\"f_2_101_minVal\":\"1\",\"f_2_102_minVal\":\"1\",\"f_2_103_minVal\":\"1\",\"f_2_104_minVal\":\"1\",\"f_2_105_minVal\":\"1\"}","2017-06-19 13:23:30");
INSERT INTO abgabe VALUES("655","99","3","5947ffdaaf09d","","{\"abgegeben\":\"1\",\"FragenWerte_2\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_2_90_minVal\":\"1\",\"f_2_91_minVal\":\"1\",\"f_2_92_minVal\":\"1\",\"f_2_93_minVal\":\"1\",\"f_2_94_minVal\":\"1\",\"f_2_95_minVal\":\"1\",\"f_2_96_minVal\":\"1\",\"f_2_97_minVal\":\"1\",\"f_2_98_minVal\":\"1\",\"f_2_99_minVal\":\"1\",\"f_2_100_minVal\":\"1\",\"f_2_101_minVal\":\"1\",\"f_2_102_minVal\":\"1\",\"f_2_103_minVal\":\"1\",\"f_2_104_minVal\":\"1\",\"f_2_105_minVal\":\"1\"}","2017-06-19 17:52:45");
INSERT INTO abgabe VALUES("656","105","3","5947ffdaaf09d","","{\"abgegeben\":\"1\"}","2017-06-19 17:53:13");
INSERT INTO abgabe VALUES("657","101","3","5947ffdaaf09d","","{\"abgegeben\":\"1\",\"WordCloud_2\":[]}","2017-06-19 18:31:41");
INSERT INTO abgabe VALUES("658","102","3","5947ffdaaf09d","","{\"abgegeben\":\"1\"}","2017-06-19 18:31:50");
INSERT INTO abgabe VALUES("659","104","3","5947ffdaaf09d","","{\"abgegeben\":\"1\"}","2017-06-19 18:31:55");
INSERT INTO abgabe VALUES("663","107","3","5947ffdaaf09d","","{\"abgegeben\":\"1\",\"KoFra_Option_1\":[\"0\",\"0\",\"2\",\"0\",\"0\",\"0\"],\"txt_2\":\"\"}","2017-06-19 18:35:49");
INSERT INTO abgabe VALUES("665","108","3","5947ffdaaf09d","","{\"abgegeben\":\"1\",\"abstOption_1\":[\"-1\",\"-1\",\"-1\",\"-1\",\"-1\"],\"WordCloud_2\":[]}","2017-06-19 18:40:12");
INSERT INTO abgabe VALUES("666","105","3","59481a556c4ff","","{\"abgegeben\":\"1\"}","2017-06-19 18:39:26");
INSERT INTO abgabe VALUES("667","99","3","59481a556c4ff","","{\"abgegeben\":\"1\",\"FragenWerte_2\":{\"90\":\"4\",\"91\":\"2\",\"92\":\"3\",\"93\":\"3\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_2_90_minVal\":\"1\",\"f_2_91_minVal\":\"1\",\"f_2_92_minVal\":\"1\",\"f_2_93_minVal\":\"1\",\"f_2_94_minVal\":\"1\",\"f_2_95_minVal\":\"1\",\"f_2_96_minVal\":\"1\",\"f_2_97_minVal\":\"1\",\"f_2_98_minVal\":\"1\",\"f_2_99_minVal\":\"1\",\"f_2_100_minVal\":\"1\",\"f_2_101_minVal\":\"1\",\"f_2_102_minVal\":\"1\",\"f_2_103_minVal\":\"1\",\"f_2_104_minVal\":\"1\",\"f_2_105_minVal\":\"1\"}","2017-06-19 18:39:35");
INSERT INTO abgabe VALUES("668","101","3","59481a556c4ff","","{\"abgegeben\":\"1\",\"WordCloud_2\":[\"Test\"]}","2017-06-19 18:39:42");
INSERT INTO abgabe VALUES("670","102","3","59481a556c4ff","","{\"abgegeben\":\"1\"}","2017-06-19 18:39:47");
INSERT INTO abgabe VALUES("671","104","3","59481a556c4ff","","{\"abgegeben\":\"1\"}","2017-06-19 18:39:50");
INSERT INTO abgabe VALUES("672","107","3","59481a556c4ff","","{\"abgegeben\":\"1\",\"KoFra_Option_1\":[\"0\",\"0\",\"2\",\"0\",\"0\",\"4\",\"0\"],\"txt_2\":\"\"}","2017-06-19 18:39:55");
INSERT INTO abgabe VALUES("673","108","3","59481a556c4ff","","{\"abgegeben\":\"1\",\"abstOption_1\":[\"-1\",\"-1\",\"-1\",\"2\",\"-1\",\"-1\"],\"WordCloud_2\":[\"Test\"]}","2017-06-19 18:40:15");
INSERT INTO abgabe VALUES("676","105","3","59483c57145c9","","{\"abgegeben\":\"1\"}","2017-06-19 21:16:16");
INSERT INTO abgabe VALUES("677","99","3","59483c57145c9","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"Submit\",\"FragenWerte_2\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_2_90_minVal\":\"1\",\"f_2_91_minVal\":\"1\",\"f_2_92_minVal\":\"1\",\"f_2_93_minVal\":\"1\",\"f_2_94_minVal\":\"1\",\"f_2_95_minVal\":\"1\",\"f_2_96_minVal\":\"1\",\"f_2_97_minVal\":\"1\",\"f_2_98_minVal\":\"1\",\"f_2_99_minVal\":\"1\",\"f_2_100_minVal\":\"1\",\"f_2_101_minVal\":\"1\",\"f_2_102_minVal\":\"1\",\"f_2_103_minVal\":\"1\",\"f_2_104_minVal\":\"1\",\"f_2_105_minVal\":\"1\"}","2017-06-19 21:18:13");
INSERT INTO abgabe VALUES("678","101","3","59483c57145c9","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\",\"WordCloud_2\":[]}","2017-06-19 21:21:16");
INSERT INTO abgabe VALUES("679","102","3","59483c57145c9","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\"}","2017-06-19 21:21:24");
INSERT INTO abgabe VALUES("680","105","3","594841b4e7f35","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\"}","2017-06-19 21:27:52");
INSERT INTO abgabe VALUES("681","99","3","594841b4e7f35","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\",\"FragenWerte_2\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_2_90_minVal\":\"1\",\"f_2_91_minVal\":\"1\",\"f_2_92_minVal\":\"1\",\"f_2_93_minVal\":\"1\",\"f_2_94_minVal\":\"1\",\"f_2_95_minVal\":\"1\",\"f_2_96_minVal\":\"1\",\"f_2_97_minVal\":\"1\",\"f_2_98_minVal\":\"1\",\"f_2_99_minVal\":\"1\",\"f_2_100_minVal\":\"1\",\"f_2_101_minVal\":\"1\",\"f_2_102_minVal\":\"1\",\"f_2_103_minVal\":\"1\",\"f_2_104_minVal\":\"1\",\"f_2_105_minVal\":\"1\"}","2017-06-19 21:27:56");
INSERT INTO abgabe VALUES("682","101","3","594841b4e7f35","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\",\"WordCloud_2\":[]}","2017-06-19 21:27:59");
INSERT INTO abgabe VALUES("683","102","3","594841b4e7f35","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\"}","2017-06-19 21:28:12");
INSERT INTO abgabe VALUES("687","104","3","594841b4e7f35","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\"}","2017-06-19 21:36:14");
INSERT INTO abgabe VALUES("688","107","3","594841b4e7f35","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\",\"KoFra_Option_1\":[\"0\",\"0\",\"0\",\"0\",\"0\"],\"txt_2\":\"\"}","2017-06-19 21:36:19");
INSERT INTO abgabe VALUES("689","108","3","594841b4e7f35","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\",\"abstOption_1\":[\"-1\",\"-1\",\"-1\",\"-1\",\"-1\"],\"WordCloud_2\":[]}","2017-06-19 21:36:21");
INSERT INTO abgabe VALUES("690","105","3","5948bc54e90d7","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\"}","2017-06-20 06:10:34");
INSERT INTO abgabe VALUES("691","105","3","5948bffdb4791","","{\"abgegeben\":\"1\"}","2017-06-20 06:26:48");
INSERT INTO abgabe VALUES("693","99","3","5948bffdb4791","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\",\"FragenWerte_2\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_2_90_minVal\":\"1\",\"f_2_91_minVal\":\"1\",\"f_2_92_minVal\":\"1\",\"f_2_93_minVal\":\"1\",\"f_2_94_minVal\":\"1\",\"f_2_95_minVal\":\"1\",\"f_2_96_minVal\":\"1\",\"f_2_97_minVal\":\"1\",\"f_2_98_minVal\":\"1\",\"f_2_99_minVal\":\"1\",\"f_2_100_minVal\":\"1\",\"f_2_101_minVal\":\"1\",\"f_2_102_minVal\":\"1\",\"f_2_103_minVal\":\"1\",\"f_2_104_minVal\":\"1\",\"f_2_105_minVal\":\"1\"}","2017-06-20 08:11:52");
INSERT INTO abgabe VALUES("694","101","3","5948bffdb4791","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\",\"WordCloud_2\":[]}","2017-06-20 08:11:54");
INSERT INTO abgabe VALUES("695","102","3","5948bffdb4791","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\"}","2017-06-20 08:11:55");
INSERT INTO abgabe VALUES("696","104","3","5948bffdb4791","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\"}","2017-06-20 08:11:56");
INSERT INTO abgabe VALUES("697","107","3","5948bffdb4791","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\",\"KoFra_Option_1\":[\"0\",\"0\",\"0\",\"0\",\"0\"],\"txt_2\":\"\"}","2017-06-20 08:11:58");
INSERT INTO abgabe VALUES("698","108","3","5948bffdb4791","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\",\"abstOption_1\":[\"-1\",\"-1\",\"-1\",\"-1\",\"-1\"],\"WordCloud_2\":[]}","2017-06-20 08:11:59");
INSERT INTO abgabe VALUES("699","99","3","5948bc54e90d7","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\",\"FragenWerte_2\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_2_90_minVal\":\"1\",\"f_2_91_minVal\":\"1\",\"f_2_92_minVal\":\"1\",\"f_2_93_minVal\":\"1\",\"f_2_94_minVal\":\"1\",\"f_2_95_minVal\":\"1\",\"f_2_96_minVal\":\"1\",\"f_2_97_minVal\":\"1\",\"f_2_98_minVal\":\"1\",\"f_2_99_minVal\":\"1\",\"f_2_100_minVal\":\"1\",\"f_2_101_minVal\":\"1\",\"f_2_102_minVal\":\"1\",\"f_2_103_minVal\":\"1\",\"f_2_104_minVal\":\"1\",\"f_2_105_minVal\":\"1\"}","2017-06-20 08:41:48");
INSERT INTO abgabe VALUES("700","101","3","5948bc54e90d7","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\",\"WordCloud_2\":[]}","2017-06-20 08:41:49");
INSERT INTO abgabe VALUES("701","102","3","5948bc54e90d7","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\"}","2017-06-20 08:41:51");
INSERT INTO abgabe VALUES("702","104","3","5948bc54e90d7","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\"}","2017-06-20 08:41:52");
INSERT INTO abgabe VALUES("703","107","3","5948bc54e90d7","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\",\"KoFra_Option_1\":[\"0\",\"0\",\"0\",\"0\",\"0\"],\"txt_2\":\"\"}","2017-06-20 08:42:00");
INSERT INTO abgabe VALUES("704","108","3","5948bc54e90d7","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\",\"abstOption_1\":[\"-1\",\"-1\",\"-1\",\"-1\",\"-1\"],\"WordCloud_2\":[]}","2017-06-20 08:42:04");
INSERT INTO abgabe VALUES("705","105","3","5948e068c5ff4","","{\"abgegeben\":\"1\"}","2017-06-20 08:47:20");
INSERT INTO abgabe VALUES("706","99","3","5948e068c5ff4","","{\"abgegeben\":\"1\",\"FragenWerte_2\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_2_90_minVal\":\"1\",\"f_2_91_minVal\":\"1\",\"f_2_92_minVal\":\"1\",\"f_2_93_minVal\":\"1\",\"f_2_94_minVal\":\"1\",\"f_2_95_minVal\":\"1\",\"f_2_96_minVal\":\"1\",\"f_2_97_minVal\":\"1\",\"f_2_98_minVal\":\"1\",\"f_2_99_minVal\":\"1\",\"f_2_100_minVal\":\"1\",\"f_2_101_minVal\":\"1\",\"f_2_102_minVal\":\"1\",\"f_2_103_minVal\":\"1\",\"f_2_104_minVal\":\"1\",\"f_2_105_minVal\":\"1\"}","2017-06-20 08:47:25");
INSERT INTO abgabe VALUES("707","101","3","5948e068c5ff4","","{\"abgegeben\":\"1\",\"WordCloud_2\":[]}","2017-06-20 08:48:04");
INSERT INTO abgabe VALUES("708","102","3","5948e068c5ff4","","{\"abgegeben\":\"1\"}","2017-06-20 08:48:25");
INSERT INTO abgabe VALUES("709","104","3","5948e068c5ff4","","{\"abgegeben\":\"1\"}","2017-06-20 08:48:29");
INSERT INTO abgabe VALUES("710","107","3","5948e068c5ff4","","{\"abgegeben\":\"1\",\"KoFra_Option_1\":[\"0\",\"0\",\"0\",\"3\",\"0\",\"0\"],\"txt_2\":\"\"}","2017-06-20 08:48:33");
INSERT INTO abgabe VALUES("711","108","3","5948e068c5ff4","","{\"abgegeben\":\"1\",\"abstOption_1\":[\"-1\",\"0\",\"-1\",\"-1\",\"-1\",\"-1\"],\"WordCloud_2\":[]}","2017-06-20 08:48:43");
INSERT INTO abgabe VALUES("712","105","3","5948e178a2030","","{\"abgegeben\":\"1\"}","2017-06-20 08:49:01");
INSERT INTO abgabe VALUES("713","99","3","5948e178a2030","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\",\"FragenWerte_2\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_2_90_minVal\":\"1\",\"f_2_91_minVal\":\"1\",\"f_2_92_minVal\":\"1\",\"f_2_93_minVal\":\"1\",\"f_2_94_minVal\":\"1\",\"f_2_95_minVal\":\"1\",\"f_2_96_minVal\":\"1\",\"f_2_97_minVal\":\"1\",\"f_2_98_minVal\":\"1\",\"f_2_99_minVal\":\"1\",\"f_2_100_minVal\":\"1\",\"f_2_101_minVal\":\"1\",\"f_2_102_minVal\":\"1\",\"f_2_103_minVal\":\"1\",\"f_2_104_minVal\":\"1\",\"f_2_105_minVal\":\"1\"}","2017-06-20 08:52:07");
INSERT INTO abgabe VALUES("714","101","3","5948e178a2030","","{\"abgegeben\":\"1\",\"WordCloud_2\":[\"Zug\"]}","2017-06-20 08:52:17");
INSERT INTO abgabe VALUES("716","102","3","5948e178a2030","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\"}","2017-06-20 08:52:22");
INSERT INTO abgabe VALUES("717","104","3","5948e178a2030","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\"}","2017-06-20 08:52:24");
INSERT INTO abgabe VALUES("718","107","3","5948e178a2030","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\",\"KoFra_Option_1\":[\"0\",\"0\",\"0\",\"0\",\"0\",\"5\"],\"txt_2\":\"\"}","2017-06-20 08:52:30");
INSERT INTO abgabe VALUES("719","108","3","5948e178a2030","","{\"abgegeben\":\"1\",\"abstOption_1\":[\"-1\",\"-1\",\"-1\",\"-1\",\"-1\"],\"WordCloud_2\":[\"JuHu!!!\"]}","2017-06-20 08:52:43");
INSERT INTO abgabe VALUES("721","105","3","5948e9c48ce1d","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\"}","2017-06-20 09:25:02");
INSERT INTO abgabe VALUES("722","99","3","5948e9c48ce1d","","{\"abgegeben\":\"1\",\"FragenWerte_2\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_2_90_minVal\":\"1\",\"f_2_91_minVal\":\"1\",\"f_2_92_minVal\":\"1\",\"f_2_93_minVal\":\"1\",\"f_2_94_minVal\":\"1\",\"f_2_95_minVal\":\"1\",\"f_2_96_minVal\":\"1\",\"f_2_97_minVal\":\"1\",\"f_2_98_minVal\":\"1\",\"f_2_99_minVal\":\"1\",\"f_2_100_minVal\":\"1\",\"f_2_101_minVal\":\"1\",\"f_2_102_minVal\":\"1\",\"f_2_103_minVal\":\"1\",\"f_2_104_minVal\":\"1\",\"f_2_105_minVal\":\"1\"}","2017-06-20 09:25:18");
INSERT INTO abgabe VALUES("723","101","3","5948e9c48ce1d","","{\"abgegeben\":\"1\",\"WordCloud_2\":[]}","2017-06-20 09:26:30");
INSERT INTO abgabe VALUES("725","102","3","5948e9c48ce1d","","{\"abgegeben\":\"1\"}","2017-06-20 09:26:45");
INSERT INTO abgabe VALUES("726","105","3","5948ec163455a","","{\"abgegeben\":\"1\"}","2017-06-20 09:34:20");
INSERT INTO abgabe VALUES("727","99","3","5948ec163455a","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\",\"FragenWerte_2\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_2_90_minVal\":\"1\",\"f_2_91_minVal\":\"1\",\"f_2_92_minVal\":\"1\",\"f_2_93_minVal\":\"1\",\"f_2_94_minVal\":\"1\",\"f_2_95_minVal\":\"1\",\"f_2_96_minVal\":\"1\",\"f_2_97_minVal\":\"1\",\"f_2_98_minVal\":\"1\",\"f_2_99_minVal\":\"1\",\"f_2_100_minVal\":\"1\",\"f_2_101_minVal\":\"1\",\"f_2_102_minVal\":\"1\",\"f_2_103_minVal\":\"1\",\"f_2_104_minVal\":\"1\",\"f_2_105_minVal\":\"1\"}","2017-06-20 09:55:18");
INSERT INTO abgabe VALUES("728","101","3","5948ec163455a","","{\"abgegeben\":\"1\",\"WordCloud_2\":[]}","2017-06-20 09:56:19");
INSERT INTO abgabe VALUES("730","102","3","5948ec163455a","","{\"abgegeben\":\"1\"}","2017-06-20 09:56:29");
INSERT INTO abgabe VALUES("745","1267","3","594e7058de95e","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\",\"FragenWerte_1\":{\"90\":\"7\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_1_90_minVal\":\"1\",\"f_1_91_minVal\":\"1\",\"f_1_92_minVal\":\"1\",\"f_1_93_minVal\":\"1\",\"f_1_94_minVal\":\"1\",\"f_1_95_minVal\":\"1\",\"f_1_96_minVal\":\"1\",\"f_1_97_minVal\":\"1\",\"f_1_98_minVal\":\"1\",\"f_1_99_minVal\":\"1\",\"f_1_100_minVal\":\"1\",\"f_1_101_minVal\":\"1\",\"f_1_102_minVal\":\"1\",\"f_1_103_minVal\":\"1\",\"f_1_104_minVal\":\"1\",\"f_1_105_minVal\":\"1\"}","2017-06-24 14:00:13");
INSERT INTO abgabe VALUES("746","1268","3","594e7058de95e","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\"}","2017-06-24 14:05:04");
INSERT INTO abgabe VALUES("747","105","3","587cf6ad35732","","{\"abgegeben\":\"1\",\"SaveAndNext\":\"goToNext_fID\"}","2017-06-25 18:24:26");
INSERT INTO abgabe VALUES("749","1267","3","587cf6ad35732","","{\"abgegeben\":\"1\",\"FragenWerte_1\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_1_90_minVal\":\"1\",\"f_1_91_minVal\":\"1\",\"f_1_92_minVal\":\"1\",\"f_1_93_minVal\":\"1\",\"f_1_94_minVal\":\"1\",\"f_1_95_minVal\":\"1\",\"f_1_96_minVal\":\"1\",\"f_1_97_minVal\":\"1\",\"f_1_98_minVal\":\"1\",\"f_1_99_minVal\":\"1\",\"f_1_100_minVal\":\"1\",\"f_1_101_minVal\":\"1\",\"f_1_102_minVal\":\"1\",\"f_1_103_minVal\":\"1\",\"f_1_104_minVal\":\"1\",\"f_1_105_minVal\":\"1\",\"FragenWerte_bottom\":{\"90\":\"4\",\"91\":\"0\",\"92\":\"0\",\"93\":\"0\",\"94\":\"0\",\"95\":\"0\",\"96\":\"0\",\"97\":\"0\",\"98\":\"0\",\"99\":\"0\",\"100\":\"0\",\"101\":\"0\",\"102\":\"0\",\"103\":\"0\",\"104\":\"0\",\"105\":\"0\"},\"f_bottom_90_minVal\":\"1\",\"f_bottom_91_minVal\":\"1\",\"f_bottom_92_minVal\":\"1\",\"f_bottom_93_minVal\":\"1\",\"f_bottom_94_minVal\":\"1\",\"f_bottom_95_minVal\":\"1\",\"f_bottom_96_minVal\":\"1\",\"f_bottom_97_minVal\":\"1\",\"f_bottom_98_minVal\":\"1\",\"f_bottom_99_minVal\":\"1\",\"f_bottom_100_minVal\":\"1\",\"f_bottom_101_minVal\":\"1\",\"f_bottom_102_minVal\":\"1\",\"f_bottom_103_minVal\":\"1\",\"f_bottom_104_minVal\":\"1\",\"f_bottom_105_minVal\":\"1\"}","2017-07-02 17:46:20");



DROP TABLE ablauf_individuell;

CREATE TABLE `ablauf_individuell` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kursID` int(11) NOT NULL,
  `fID` int(11) NOT NULL,
  `parameter` text NOT NULL COMMENT 'Einstellungen zur jeweiligen Folie',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kursID_fID` (`kursID`,`fID`),
  KEY `fID` (`fID`),
  CONSTRAINT `ablauf_individuell_ibfk_1` FOREIGN KEY (`kursID`) REFERENCES `kurs` (`kursID`),
  CONSTRAINT `ablauf_individuell_ibfk_2` FOREIGN KEY (`fID`) REFERENCES `folien` (`fID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE ablauf_master;

CREATE TABLE `ablauf_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `KursID` int(11) NOT NULL,
  `fID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `freigabeStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'Freigabe durch Lehrkraft; 1: freigegeben; 0 versteckt',
  `aktiv` int(11) NOT NULL DEFAULT '1' COMMENT '0: inaktiv; 1:aktiv',
  `parameter` text NOT NULL COMMENT 'Einstellungen zur jeweiligen Folie',
  PRIMARY KEY (`id`),
  UNIQUE KEY `fID_KursID` (`fID`,`KursID`),
  CONSTRAINT `ablauf_master_ibfk_2` FOREIGN KEY (`fID`) REFERENCES `folien` (`fID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1410 DEFAULT CHARSET=utf8;

INSERT INTO ablauf_master VALUES("41","1","13","1","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("42","1","15","3","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("43","1","16","4","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("44","1","17","5","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("45","1","18","6","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("46","1","14","2","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("47","1","19","7","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("48","1","20","8","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("49","1","21","9","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("50","1","22","10","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("287","1","29","11","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("373","1","31","12","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("387","1","32","13","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("418","1","33","14","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("419","22","34","1","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("420","22","35","2","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("421","22","37","3","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("422","23","38","1","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("423","23","39","2","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("424","23","40","3","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("425","23","41","4","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("434","23","42","5","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("445","23","43","6","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":0,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("458","23","44","7","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("473","23","45","8","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("474","23","46","9","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("493","23","47","10","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("494","22","53","4","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("495","24","48","2","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("496","24","49","3","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("497","24","50","4","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("498","24","54","1","0","0","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("499","23","56","13","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("500","23","52","11","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("501","23","55","12","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("502","23","57","14","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("571","23","64","15","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("572","1","65","15","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("596","24","61","5","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("694","25","58","8","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("695","25","59","9","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("696","25","60","6","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("697","25","62","10","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("698","25","63","11","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("699","25","72","7","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("711","25","81","2","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("712","25","84","3","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("713","25","85","4","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("714","25","86","5","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("717","25","88","12","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("718","25","89","1","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("720","25","91","14","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("721","25","90","13","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("736","25","92","15","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("737","25","93","16","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("738","25","94","17","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("743","28","99","3","1","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":1,\"show_nach_bearb\":0,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("744","21","1","1","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("745","21","4","2","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("746","21","5","3","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("747","21","51","6","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("748","21","66","7","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("750","21","100","8","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("751","28","101","4","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":0,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("752","28","102","5","1","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":1,\"show_nach_bearb\":0,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("754","28","104","6","1","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":1,\"show_nach_bearb\":0,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("755","27","105","5","0","0","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("759","21","10","4","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("760","21","12","5","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("770","28","107","7","1","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":1,\"show_nach_bearb\":0,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("771","28","105","1","1","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("772","28","108","8","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("773","28","109","9","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("1082","25","125","0","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1083","25","126","0","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1084","25","127","0","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1085","25","128","0","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1086","25","129","0","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1087","25","130","0","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1088","25","138","0","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1089","25","141","0","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1090","25","142","0","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1091","25","143","0","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1092","25","145","0","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1093","25","146","0","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1094","25","147","0","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1095","25","148","0","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1145","28","1261","2","0","0","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1165","25","1262","18","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1166","25","1263","19","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1167","25","1264","20","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1168","25","1265","21","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1169","25","1266","22","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1170","111","1267","1","1","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":0,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1171","111","1268","2","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("1176","111","1269","3","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("1325","113","1270","1","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1326","113","1271","2","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1327","113","1272","3","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1346","23","110","16","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1347","23","111","17","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1348","23","112","18","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1349","23","113","19","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1350","23","114","20","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1351","23","115","21","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1352","23","116","22","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1353","23","117","23","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1354","23","118","24","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1355","23","119","25","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1356","23","120","26","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1357","23","121","27","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1358","23","122","28","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1359","23","123","29","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1360","23","124","30","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1361","23","156","31","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1362","23","157","32","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1363","23","158","33","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1364","23","159","34","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1365","23","160","35","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1366","23","161","36","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1367","23","162","37","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1368","23","163","38","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1369","23","164","39","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1370","23","165","40","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1371","23","166","41","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1372","23","167","42","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1373","23","168","43","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1374","23","169","44","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1375","23","170","45","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1376","23","171","46","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1377","23","172","47","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1378","23","173","48","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1379","23","174","49","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1380","23","175","50","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1381","23","176","51","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1382","23","177","52","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1383","23","178","53","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1384","23","179","54","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1385","23","180","55","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1386","23","181","56","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1387","23","182","57","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1388","23","183","58","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1389","23","184","59","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1390","23","185","60","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1391","111","1273","4","0","1","{\"show_beginn\":1,\"show_aktiv\":0,\"show_freigabe\":1,\"show_nach_bearb\":1,\"show_auto\":1}");
INSERT INTO ablauf_master VALUES("1392","115","1274","1","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1393","115","1275","2","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1394","115","1276","3","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1402","116","1277","1","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1403","116","1278","2","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1404","111","1279","5","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");
INSERT INTO ablauf_master VALUES("1405","111","1280","6","0","1","{\"show_beginn\":1,\"show_aktiv\":1,\"show_freigabe\":0,\"show_nach_bearb\":1,\"show_auto\":0}");



DROP TABLE ablauf_sync;

CREATE TABLE `ablauf_sync` (
  `kursID` int(11) NOT NULL,
  `fID` int(11) NOT NULL,
  `aktiv` int(11) NOT NULL DEFAULT '0' COMMENT '0: nicht angeheftet; 1: angeheftet',
  UNIQUE KEY `kursID` (`kursID`),
  KEY `fID` (`fID`),
  CONSTRAINT `ablauf_sync_ibfk_4` FOREIGN KEY (`kursID`) REFERENCES `kurs` (`kursID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ablauf_sync_ibfk_3` FOREIGN KEY (`fID`) REFERENCES `folien` (`fID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO ablauf_sync VALUES("1","16","0");
INSERT INTO ablauf_sync VALUES("23","42","1");
INSERT INTO ablauf_sync VALUES("25","59","0");
INSERT INTO ablauf_sync VALUES("28","105","0");
INSERT INTO ablauf_sync VALUES("111","1273","0");



DROP TABLE agb;

CREATE TABLE `agb` (
  `agbID` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `valid_from` datetime NOT NULL COMMENT 'gültig ab',
  PRIMARY KEY (`agbID`),
  UNIQUE KEY `id` (`agbID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO agb VALUES("1","&lt;div&gt;&lt;div&gt;&lt;h2 id=&quot;mcetoc_1bj9slptn0&quot;&gt;Nutzungsbedingungen&lt;/h2&gt;&lt;/div&gt;&lt;/div&gt;&lt;div&gt;&lt;h3 id=&quot;mcetoc_1bj9slptn1&quot;&gt;Nutzungsbedingungen von Mediathek, Pr&amp;uuml;fungsarchiv und Lernplattform&lt;/h3&gt;&lt;p&gt;Inhalt&lt;/p&gt;&lt;ol&gt;&lt;li&gt;&lt;a href=&quot;#2&quot;&gt;Nutzungsordnung&lt;/a&gt;&lt;ol&gt;&lt;li&gt;&lt;a href=&quot;#21&quot;&gt;Verwendungsbereich der PUMA@LMU-Angebote&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;#22&quot;&gt;Benutzerkonten und Profile&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;#23&quot;&gt;Nutzung der Mediathek (Experimentiervideos)&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;#25&quot;&gt;Nutzung der Lernplattform&lt;/a&gt;&lt;ol&gt;&lt;li&gt;Freigeben und Tauschen von Kursen&amp;nbsp;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;#251&quot;&gt;Informations&amp;uuml;bertragung ins Internet&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;#252&quot;&gt;Umgang mit E-Mail&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;#253&quot;&gt;Datenvolumen&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;#254&quot;&gt;Sonstige Regelungen&lt;/a&gt;&lt;/li&gt;&lt;/ol&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;#26&quot;&gt;Datensicherheit&lt;/a&gt;&lt;/li&gt;&lt;/ol&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;#3&quot;&gt;Zuwiderhandlungen&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;#4&quot;&gt;Einholen der Einverst&amp;auml;ndniserkl&amp;auml;rung&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;#5&quot;&gt;Haftungsausschluss&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;#6&quot;&gt;Schlussbestimmungen&lt;/a&gt;&lt;/li&gt;&lt;/ol&gt;&lt;p&gt;&lt;a name=&quot;2&quot;&gt;&lt;/a&gt;&lt;/p&gt;&lt;h3 id=&quot;mcetoc_1bj9slptn3&quot;&gt;1. Nutzungsordnung&lt;/h3&gt;&lt;p&gt;&lt;a name=&quot;21&quot;&gt;&lt;/a&gt;&lt;/p&gt;&lt;h3 id=&quot;mcetoc_1bj9slptn4&quot;&gt;1.1 Verwendungsbereich der PUMA@LMU-Angebote&lt;/h3&gt;&lt;p&gt;Alle Angebote von PUMA@LMU sowie s&amp;auml;mtliche dort zug&amp;auml;nglichen Dienste und Dateien d&amp;uuml;rfen nur f&amp;uuml;r Bildungszwecke ohne finanzielle bzw. politische Interessen oder Absichten eingesetzt werden. Die Weitergabe von Dateien aus den PUMA@LMU-Angeboten an Dritte (z. B. Filesharing-Portale, Soziale Netzwerke) ist nicht gestattet. Ausgenommen davon sind Inhalte, f&amp;uuml;r die ausdr&amp;uuml;cklich weiter gehende Nutzungsrechte einger&amp;auml;umt sind (z. B. Creative Commons).&lt;br /&gt;Ver&amp;auml;nderungen der Installation und Konfiguration der Anwendungen sowie der Serversoftware und Datenbanken der Mediathek, des Pr&amp;uuml;fungsarchivs und der Lernplattform von PUMA@LMU sind untersagt.&lt;br /&gt;&lt;a name=&quot;22&quot;&gt;&lt;/a&gt;&lt;/p&gt;&lt;h3 id=&quot;mcetoc_1bj9slptn5&quot;&gt;1.2 Benutzerkonten und Profile&lt;/h3&gt;&lt;p&gt;Voraussetzung f&amp;uuml;r die Verwendung von PUMA@LMU ist die ordnungsgem&amp;auml;&amp;szlig;e Registrierung bei PUMA@LMU.&amp;nbsp;Dabei werden durch den automatisierten Registrierungsprozess folgende Daten gespeichert:&lt;br /&gt;&lt;br /&gt;&lt;strong&gt;Nachname, Vorname, Geschlecht, E-Mail-Adresse, Schulnummer, Benutzername und Kennwort.&lt;br /&gt;&lt;/strong&gt;&lt;br /&gt;Benutzername und Kennwort wird von PUMA@LMU&amp;nbsp;per E-Mail an den jeweiligen Nutzer oder die&amp;nbsp;Nutzerin versendet. Das Passwort wird verschl&amp;uuml;sselt abgelegt und ist weder der LMU noch dem Administrator von &lt;a href=&quot;mailto:PUMA@LMU&quot;&gt;PUMA@LMU&lt;/a&gt;&amp;nbsp;bekannt. Wird das Kennwort vergessen, m&amp;uuml;ssen sich die Nutzer &amp;uuml;ber die&amp;nbsp;Lernplattform ein neues Kennwort generieren.&lt;br /&gt;Die Vergabe von Zug&amp;auml;ngen, die von mehr als einer Person genutzt werden, ist nicht zul&amp;auml;ssig. Nutzerinnen und Nutzer d&amp;uuml;rfen sich nur unter ihrem pers&amp;ouml;nlichen Benutzernamen anmelden. Sie sind f&amp;uuml;r alle Aktivit&amp;auml;ten verantwortlich, die unter ihrem pers&amp;ouml;nlichen Nutzernamen ablaufen. Die Arbeitsstation, an der sie sich bei PUMA@LMU eingeloggt haben, d&amp;uuml;rfen sie nicht unbeaufsichtigt lassen. Nach Nutzungsende m&amp;uuml;ssen sie sich von den PUMA@LMU-Angeboten abmelden.&lt;br /&gt;Passw&amp;ouml;rter sind geheim zu halten. Jede Nutzerin und jeder Nutzer ist daf&amp;uuml;r verantwortlich, dass nur sie/er allein das pers&amp;ouml;nliche Passwort kennt bzw. ein zugewiesenes Passwort nicht weitergibt.&lt;br /&gt;Das Ausprobieren, das Ausforschen und die Benutzung fremder Zugriffsberechtigungen und sonstiger Authentifizierungsmittel f&amp;uuml;hren zum Nutzungsausschluss von allen Angeboten von PUMA@LMU. Zugriffe auf fremde Inhalte und Daten der PUMA@LMU-Angebote ohne ausdr&amp;uuml;ckliche Zustimmung des Eigent&amp;uuml;mers sind ebenfalls unzul&amp;auml;ssig und werden bei Bekanntwerden verfolgt. Der Einsatz von sog. Spyware (z. B. Sniffer) oder Schadsoftware (z. B. Viren, W&amp;uuml;rmer) ist untersagt.&lt;/p&gt;&lt;p&gt;&lt;a name=&quot;23&quot;&gt;&lt;/a&gt;&lt;/p&gt;&lt;h3 id=&quot;mcetoc_1bj9slptn6&quot;&gt;1.3 Nutzung der Mediathek (Experimentiervideos der LMU)&lt;/h3&gt;&lt;p&gt;Medien der PUMA@LMU-Mediathek d&amp;uuml;rfen nur f&amp;uuml;r Unterrichts- und schulische &amp;Uuml;bungszwecke genutzt werden.&lt;br /&gt;Lehrkr&amp;auml;fte d&amp;uuml;rfen Medien der PUMA@LMU-Mediathek&lt;/p&gt;&lt;ul&gt;&lt;li&gt;in Abh&amp;auml;ngigkeit von der jeweils angebotenen Nutzungsform als Stream und/oder Download verwenden. Video-Inhalte werden Sch&amp;uuml;lerinnen und Sch&amp;uuml;lern nur via Stream zur Verf&amp;uuml;gung gestellt.&lt;/li&gt;&lt;li&gt;auf dem Server der Schule speichern.&lt;/li&gt;&lt;li&gt;auf optische und/oder magnetische Datentr&amp;auml;ger kopieren, soweit dies im Rahmen der schulischen Nutzung erforderlich ist.&lt;/li&gt;&lt;li&gt;den Sch&amp;uuml;lerinnen und Sch&amp;uuml;lern zur Anfertigung von Seminararbeiten, Referaten etc. auf mobilen Datentr&amp;auml;gern in die Hand geben, wobei darauf zu achten ist, dass die Medien nach der Fertigstellung der Arbeit bzw. nach Ablauf des Projektes zur&amp;uuml;ckgegeben werden.&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;Sch&amp;uuml;lerinnen und Sch&amp;uuml;ler d&amp;uuml;rfen Medien der PUMA@LMU-Mediathek&lt;/p&gt;&lt;ul&gt;&lt;li&gt;in Abh&amp;auml;ngigkeit von der jeweils angebotenen Nutzungsform als Stream und/oder Download verwenden. Video-Inhalte werden Sch&amp;uuml;lerinnen und Sch&amp;uuml;lern nur via Stream zur Verf&amp;uuml;gung gestellt.&lt;/li&gt;&lt;li&gt;zur Anfertigung von Seminararbeiten, Referaten etc. nutzen, wobei darauf zu achten ist, dass die Medien nach der Fertigstellung der Arbeit bzw. nach Ablauf des Projektes gel&amp;ouml;scht werden.&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;Bei der Verwendung von Medien ist stets auf die Angabe der in der Mediathek zur Verf&amp;uuml;gung gestellten, auf die einzelnen Medien bezogenen Herkunfts- bzw. Quellenangaben und ggf. Lizenzformen (z. B. bei Creative-Commons-Lizenzen) zu achten. Eine etwaige Ver&amp;ouml;ffentlichung auf der Homepage oder in Printprodukten der Schule sowie eine Weitergabe an Dritte ist nicht zul&amp;auml;ssig. Ausgenommen davon sind Medien, f&amp;uuml;r die ausdr&amp;uuml;cklich weiter gehende Nutzungsrechte einger&amp;auml;umt sind (z. B. Creative Commons).&lt;br /&gt;Soweit die Lizenz zeitlich befristet ist, d&amp;uuml;rfen die Medien der PUMA@LMU-Mediathek in dem beschriebenen Umfang nur f&amp;uuml;r die Dauer des jeweils g&amp;uuml;ltigen Lizenzzeitraumes genutzt werden. Nach Ablauf der Lizenzzeit ist das Medium in der Mediathek nicht mehr abrufbar. Es darf nicht mehr eingesetzt werden und die Nutzerinnen und Nutzer sind verpflichtet, alle auf optischen und/oder magnetischen Datentr&amp;auml;gern abgelegten Kopien zu l&amp;ouml;schen.&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&lt;a name=&quot;25&quot;&gt;&lt;/a&gt;&lt;/p&gt;&lt;h3 id=&quot;mcetoc_1bj9slptn8&quot;&gt;1.4 Nutzung der Lernplattform&lt;/h3&gt;&lt;p&gt;Die Lernplattform bietet virtuelle R&amp;auml;ume zum Online-Lernen, welche die Lehrkr&amp;auml;fte selbst gestalten k&amp;ouml;nnen, indem sie Lerninhalte zur Verf&amp;uuml;gung stellen und Lernaktivit&amp;auml;ten f&amp;uuml;r die Sch&amp;uuml;lerinnen und Sch&amp;uuml;ler organisieren.&lt;br /&gt;Lehrkr&amp;auml;fte k&amp;ouml;nnen innerhalb der Lernplattform Kurse f&amp;uuml;r andere &lt;a href=&quot;mailto:PUMA@LMU&quot;&gt;PUMA@LMU&lt;/a&gt;&amp;nbsp;Mitglieder freigeben (tauschen). Hierzu gelten folgende Erg&amp;auml;nzungen:&lt;/p&gt;&lt;p style=&quot;padding-left: 60px;&quot;&gt;&amp;nbsp;&lt;/p&gt;&lt;h4&gt;1.4.1&amp;nbsp;Freigeben und Tauschen von Kursen&lt;/h4&gt;&lt;p&gt;PUMA@LMU&amp;nbsp;dient dem Austausch von bew&amp;auml;hrten Kursen. Alle in PUMA@LMU angemeldeten Lehrkr&amp;auml;fte k&amp;ouml;nnen entweder eigene Kurse erstellen oder verf&amp;uuml;gbare freigegebene Kurse kopieren.&lt;/p&gt;&lt;h5&gt;1.4.1.1&amp;nbsp;Freigeben von Kursen&lt;/h5&gt;&lt;p&gt;Erfolgreich im Unterricht erprobte PUMA@LMU-Kurse k&amp;ouml;nnen anderen an PUMA@LMU teilnehmenden Lehrkr&amp;auml;ften zum kostenlosen kopieren angeboten werden.&lt;/p&gt;&lt;h5&gt;1.4.1.2 Schutzrechte von Dritten&lt;/h5&gt;&lt;p&gt;Die Nutzung der PUMA@LMU&amp;nbsp;Kurs Freigabe hat unter Wahrung s&amp;auml;mtlicher Schutzrechte von Dritten zu erfolgen. Das Anbieten, Hochladen oder Verbreiten von rechtswidrigen Inhalten, insbesondere solchen, die gegen strafrechtliche, datenschutz-rechtliche, pers&amp;ouml;nlichkeitsrechtliche, lizenzrechtliche oder urheberrechtliche Bestimmungen versto&amp;szlig;en, ist unzul&amp;auml;ssig.&lt;br /&gt;Die Ver&amp;ouml;ffentlichung von Stimmaufnahmen und Bildnissen im Sinne des &amp;sect; 22 KunstUrhG auf PUMA@LMU setzt bei der betroffenen Person und/oder deren Erziehungsberechtigte(n) die informierte und freiwillige Zustimmung voraus. F&amp;uuml;r Personen unter 14 Jahren m&amp;uuml;ssen die Erziehungsberechtigten, bei Personen von 14 bis einschlie&amp;szlig;lich 17 Jahren m&amp;uuml;ssen diese selbst und die Erziehungsberechtigten, bei Personen ab 18 Jahren m&amp;uuml;ssen diese selbst wirksam einwilligen. Zuwiderhandlungen k&amp;ouml;nnen zum Ausschluss von der Nutzung der Plattform f&amp;uuml;hren, unbeschadet sonstiger straf- oder zivilrechtlicher Konsequenzen.&lt;/p&gt;&lt;h5&gt;1.4.1.3 Datenvolumen&lt;/h5&gt;&lt;p&gt;Um unn&amp;ouml;tiges Datenaufkommen zu vermeiden,&amp;nbsp;werden Medien nur einmal hochgeladen (vom urspr&amp;uuml;nglichen Ersteller des Kurses). Im Anschluss werden diese Medien allen Teilnehmern, die diesen Kurs kopiert haben per Datenbankverweis zug&amp;auml;nglich gemacht.&lt;/p&gt;&lt;h5&gt;1.4.1.4 Rechtfertigungsnachweis&lt;/h5&gt;&lt;p&gt;Innerhalb der bereitgestellten Kurse sollten als Fremdinhalte vornehmlich freie Werke verwendet werden (z. B. Inhalte, die unter einer Lizenz von Creative Commons (CC) stehen). Derjenige, der den PUMA@LMU-Kurses ver&amp;ouml;ffentlicht, ist verpflichtet, f&amp;uuml;r jeden Eigen- und Fremdinhalt den Urheber sowie die entsprechende Herkunft und Lizenz anzugeben. Bei Fremdinhalten, die nicht unter einer freien Lizenz stehen, sondern mit freundlicher Genehmigung des Urhebers verwendet werden d&amp;uuml;rfen, ist der Ersteller des Kurses verpflichtet, eine Weiterverbreitungserlaubnis einzuholen. Falls der Urheber das Werk Dritten zugeschrieben hat (z. B. einer Zeitung oder einer Stiftung), m&amp;uuml;ssen diese ebenfalls genannt werden. Wurde der Fremdinhalt zul&amp;auml;ssigerweise ver&amp;auml;ndert, muss gekennzeichnet werden, dass eine Bearbeitung stattgefunden hat.&lt;/p&gt;&lt;p&gt;Sollten Quellen falsch angegeben und/oder urheberrechtlich gesch&amp;uuml;tztes Material widerrechtlich eingesetzt werden, so haftet derjenige, der den Kurs freigegen hat, f&amp;uuml;r etwaige Anspr&amp;uuml;che Dritter.&lt;br /&gt;&lt;br /&gt;&lt;/p&gt;&lt;p&gt;&lt;a name=&quot;251&quot;&gt;&lt;/a&gt;&lt;/p&gt;&lt;h4&gt;1.4.2 Informations&amp;uuml;bertragung ins Internet&lt;/h4&gt;&lt;p&gt;Der Kursleiter eines Kurses der Lernplattform ist verantwortlich f&amp;uuml;r das Angebot in seinem Kursraum. Es ist verboten, &amp;uuml;ber die Lernplattform von PUMA@LMU Informationen zur Verf&amp;uuml;gung zu stellen, die rechtlichen Grunds&amp;auml;tzen widersprechen. Dies gilt insbesondere f&amp;uuml;r rassistische, ehrverletzende, beleidigende oder aus anderen Gr&amp;uuml;nden gegen geltendes Recht versto&amp;szlig;ende Inhalte. Die Bestimmungen des Bayerischen Datenschutzgesetzes (BayDSG) sind einzuhalten. Dies gilt insbesondere f&amp;uuml;r die Bekanntgabe von Namen, Adressdaten und Fotografien von Personen. Das Erstellen von Audiobeitr&amp;auml;gen mit der eigenen Stimme und deren Ver&amp;ouml;ffentlichung in einem Kurs der Lernplattform setzt bei der betroffenen Person die Freiwilligkeit voraus.&lt;/p&gt;&lt;h4&gt;1.4.3 Umgang mit E-Mail&lt;/h4&gt;&lt;p&gt;Die Angabe einer ung&amp;uuml;ltigen E-Mail-Adresse ist nicht zul&amp;auml;ssig und kann zum Ausschluss von der Nutzung der PUMA@LMU-Angebote f&amp;uuml;hren.&lt;/p&gt;&lt;p&gt;&lt;a name=&quot;253&quot;&gt;&lt;/a&gt;&lt;/p&gt;&lt;h4&gt;1.4.4 Datenvolumen&lt;/h4&gt;&lt;p&gt;Unn&amp;ouml;tiges Datenaufkommen durch Laden von gro&amp;szlig;en Dateien (z. B. Grafiken, Videos oder Audiodateien) &amp;uuml;ber die Lernplattform von PUMA@LMU ist zu vermeiden. Sollte eine Nutzerin / ein Nutzer unberechtigt gr&amp;ouml;&amp;szlig;ere Datenmengen in seinem Arbeitsbereich ablegen, so sind die Administratoren der Lernplattform berechtigt, diese Daten zu l&amp;ouml;schen.&lt;br /&gt;&lt;a name=&quot;254&quot;&gt;&lt;/a&gt;&lt;/p&gt;&lt;h4&gt;1.4.5 Sonstige Regelungen&lt;/h4&gt;&lt;p&gt;Der Zugang zu fragw&amp;uuml;rdigen Informationen im Internet kann aus verschiedenen Gr&amp;uuml;nden nicht immer verhindert werden. Die Leiter der Kurse auf der PUMA@LMU-Lernplattform kommen ihrer Aufsichtspflicht gegen&amp;uuml;ber Minderj&amp;auml;hrigen durch regelm&amp;auml;&amp;szlig;ige Kontrolle der in ihren Kursr&amp;auml;umen zur Verf&amp;uuml;gung gestellten Module nach.&lt;/p&gt;&lt;p&gt;&lt;a name=&quot;26&quot;&gt;&lt;/a&gt;&lt;/p&gt;&lt;h3 id=&quot;mcetoc_1bj9slptn9&quot;&gt;1.5 Datensicherheit&lt;/h3&gt;&lt;p&gt;Alle von PUMA@LMU erfassten Daten unterliegen dem Zugriff der Administratoren. Diese k&amp;ouml;nnen bei dringendem Handlungsbedarf unangemeldet Daten einsehen, l&amp;ouml;schen oder ver&amp;auml;ndern. Die Nutzerin / der Nutzer wird &amp;uuml;ber einen solchen Eingriff &amp;ndash; notfalls nachtr&amp;auml;glich &amp;ndash; angemessen informiert.&lt;/p&gt;&lt;p&gt;Ein Rechtsanspruch auf die Sicherung, Speicherung und Verf&amp;uuml;gbarkeit pers&amp;ouml;nlicher Daten (auch: Kurse oder Teile hiervon) besteht gegen&amp;uuml;ber PUMA@LMU nicht. Nur vom System automatisch erstellte Sicherungen von Kursen, die in regelm&amp;auml;&amp;szlig;igen Abst&amp;auml;nden durch das durch die f&amp;uuml;r PUMA@LMU-Verantwortlichen vorgenommen werden, d&amp;uuml;rfen in der Lernplattform von PUMA@LMU gespeichert werden. F&amp;uuml;r Datenverlust durch h&amp;ouml;here Gewalt (z. B. Wasser- oder Brandschaden im IT-DLZ) wird nicht gehaftet.&lt;/p&gt;&lt;p&gt;&lt;a name=&quot;3&quot;&gt;&lt;/a&gt;&lt;/p&gt;&lt;h3 id=&quot;mcetoc_1bj9slptna&quot;&gt;2. Zuwiderhandlungen&lt;/h3&gt;&lt;p&gt;Zuwiderhandlungen gegen diese Ordnung oder ein Missbrauch des Zugangs zu den Angeboten von PUMA@LMU k&amp;ouml;nnen neben dem Entzug der Nutzungsberechtigung auch Schadensersatzforderungen nach sich ziehen.&lt;br /&gt;&lt;a name=&quot;4&quot;&gt;&lt;/a&gt;&lt;/p&gt;&lt;h3 id=&quot;mcetoc_1bj9slptnb&quot;&gt;3. Einholen der Einverst&amp;auml;ndniserkl&amp;auml;rung&lt;/h3&gt;&lt;p&gt;Die Nutzung der Angebote von PUMA@LMU ist regelm&amp;auml;&amp;szlig;ig mit einer Erhebung, Verarbeitung und Nutzung personenbezogener Daten verbunden. Gem&amp;auml;&amp;szlig; dem Bayerischen Gesetz &amp;uuml;ber das Erziehungs- und Unterrichtswesen, den Schulordnungen, dem Bayerischen Datenschutzgesetz und der Anlage 10 der Verordnung des Bayerischen Staatsministeriums f&amp;uuml;r Unterricht und Kultus zur Durchf&amp;uuml;hrung des Art. 28 Abs. 2 des Bayerischen Datenschutzgesetzes setzt die Nutzung passwortgesch&amp;uuml;tzter Internetangebote und Lernplattformen die schriftliche Einwilligung durch die Erziehungsberechtigten der Nutzerinnen und Nutzer, die das 14. Lebensjahr noch nicht vollendet haben, bzw. durch die &amp;uuml;ber 14-j&amp;auml;hrigen Nutzerinnen und Nutzer und deren Erziehungsberechtigte voraus. Diese wird&amp;nbsp;&lt;strong&gt;durch die nutzende Schule&lt;/strong&gt;&amp;nbsp;eingeholt.&lt;/p&gt;&lt;p&gt;Die Einholung von Einwilligungen ist nicht erforderlich, wenn der Einsatz von PUMA@LMU zum verpflichtenden Bestandteil des Unterrichts an einer Schule oder in einzelnen Klassen oder Kursen der Schule erkl&amp;auml;rt wird.&lt;/p&gt;&lt;p&gt;Dies ist der Fall, wenn&lt;/p&gt;&lt;ul&gt;&lt;li&gt;ein entsprechender Beschluss der Lehrerkonferenz in Abstimmung mit den ma&amp;szlig;geblichen Schulgremien (insbesondere dem Schulforum) sowie dem Schulaufwandstr&amp;auml;ger vorliegt und&lt;/li&gt;&lt;li&gt;sichergestellt ist, dass betroffenen Sch&amp;uuml;lerinnen und Sch&amp;uuml;lern ohne h&amp;auml;uslichen Internetanschluss kein Nachteil erw&amp;auml;chst. Dies kann beispielsweise dadurch erreicht werden, dass alternative Zugangsm&amp;ouml;glichkeiten in der Schule auch au&amp;szlig;erhalb des Unterrichts zur Verf&amp;uuml;gung gestellt werden.&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;a name=&quot;5&quot;&gt;&lt;/a&gt;&lt;/p&gt;&lt;h3 id=&quot;mcetoc_1bj9slptnc&quot;&gt;4. Haftungsausschluss&lt;/h3&gt;&lt;p&gt;F&amp;uuml;r den Betrieb der Angebote von PUMA@LMU ist das LRZ&amp;nbsp;verantwortlich. F&amp;uuml;r Ausf&amp;auml;lle von PUMA@LMU, z. B. durch technische Probleme im LRZ, St&amp;ouml;rungen innerhalb des Internets oder w&amp;auml;hrend Wartungsarbeiten, wird keinerlei Haftung &amp;uuml;bernommen.&lt;br /&gt;&lt;a name=&quot;6&quot;&gt;&lt;/a&gt;&lt;/p&gt;&lt;h3 id=&quot;mcetoc_1bj9slptnd&quot;&gt;5. Schlussbestimmungen&lt;/h3&gt;&lt;p&gt;Sollten einzelne Bestimmungen dieser Nutzungsbedingungen ganz oder teilweise unwirksam sein oder werden, ber&amp;uuml;hrt dies die Wirksamkeit der &amp;uuml;brigen Bestimmungen nicht.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;Stand:&amp;nbsp;23.06.2017&lt;br /&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/div&gt;","2017-06-22 00:00:00");



DROP TABLE agb_user_confirm;

CREATE TABLE `agb_user_confirm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agbID` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  `datum` datetime NOT NULL COMMENT 'eingetragen am',
  `status` int(11) NOT NULL COMMENT '1: akzeptiert; 0:abgelehnt',
  PRIMARY KEY (`id`),
  UNIQUE KEY `agbID_uID` (`agbID`,`uID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

INSERT INTO agb_user_confirm VALUES("11","1","1","2017-06-23 09:07:39","1");
INSERT INTO agb_user_confirm VALUES("14","1","5","2017-06-24 11:34:18","1");
INSERT INTO agb_user_confirm VALUES("15","1","37","2017-06-26 07:40:31","1");



DROP TABLE baustein_folie_position_match;

CREATE TABLE `baustein_folie_position_match` (
  `fID` int(11) NOT NULL,
  `bID` int(11) NOT NULL,
  `blockID` varchar(25) NOT NULL,
  UNIQUE KEY `fID_blockID` (`fID`,`blockID`),
  KEY `bID` (`bID`),
  CONSTRAINT `baustein_folie_position_match_ibfk_1` FOREIGN KEY (`fID`) REFERENCES `folien` (`fID`),
  CONSTRAINT `baustein_folie_position_match_ibfk_2` FOREIGN KEY (`bID`) REFERENCES `bausteine` (`bID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO baustein_folie_position_match VALUES("37","1","bID_2");
INSERT INTO baustein_folie_position_match VALUES("42","1","bID_2");
INSERT INTO baustein_folie_position_match VALUES("59","1","bID_1");
INSERT INTO baustein_folie_position_match VALUES("101","1","bID_2");
INSERT INTO baustein_folie_position_match VALUES("108","1","bID_2");
INSERT INTO baustein_folie_position_match VALUES("114","1","bID_2");
INSERT INTO baustein_folie_position_match VALUES("126","1","bID_1");
INSERT INTO baustein_folie_position_match VALUES("160","1","bID_2");
INSERT INTO baustein_folie_position_match VALUES("175","1","bID_2");
INSERT INTO baustein_folie_position_match VALUES("1261","5","bID_1");
INSERT INTO baustein_folie_position_match VALUES("37","6","bID_1");
INSERT INTO baustein_folie_position_match VALUES("108","6","bID_1");
INSERT INTO baustein_folie_position_match VALUES("1268","6","bID_2");
INSERT INTO baustein_folie_position_match VALUES("41","7","bID_2");
INSERT INTO baustein_folie_position_match VALUES("107","7","bID_1");
INSERT INTO baustein_folie_position_match VALUES("113","7","bID_2");
INSERT INTO baustein_folie_position_match VALUES("159","7","bID_2");
INSERT INTO baustein_folie_position_match VALUES("174","7","bID_2");
INSERT INTO baustein_folie_position_match VALUES("1269","7","bID_2");
INSERT INTO baustein_folie_position_match VALUES("43","8","bID_1");
INSERT INTO baustein_folie_position_match VALUES("59","8","bID_2");
INSERT INTO baustein_folie_position_match VALUES("115","8","bID_1");
INSERT INTO baustein_folie_position_match VALUES("126","8","bID_2");
INSERT INTO baustein_folie_position_match VALUES("161","8","bID_1");
INSERT INTO baustein_folie_position_match VALUES("176","8","bID_1");
INSERT INTO baustein_folie_position_match VALUES("51","9","bID_2");
INSERT INTO baustein_folie_position_match VALUES("51","10","bID_1");
INSERT INTO baustein_folie_position_match VALUES("60","10","bID_2");
INSERT INTO baustein_folie_position_match VALUES("127","10","bID_2");
INSERT INTO baustein_folie_position_match VALUES("1261","10","bID_2");
INSERT INTO baustein_folie_position_match VALUES("89","17","bID_1");
INSERT INTO baustein_folie_position_match VALUES("146","17","bID_1");
INSERT INTO baustein_folie_position_match VALUES("99","19","bID_2");
INSERT INTO baustein_folie_position_match VALUES("105","19","bID_top");
INSERT INTO baustein_folie_position_match VALUES("1267","19","bID_bottom");
INSERT INTO baustein_folie_position_match VALUES("1267","20","bID_1");



DROP TABLE bausteine;

CREATE TABLE `bausteine` (
  `bID` int(11) NOT NULL AUTO_INCREMENT,
  `bTypID` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  `parameter` text NOT NULL,
  PRIMARY KEY (`bID`),
  KEY `bTypID` (`bTypID`),
  KEY `uID` (`uID`),
  CONSTRAINT `bausteine_ibfk_1` FOREIGN KEY (`bTypID`) REFERENCES `bausteine_typen` (`bTypID`) ON DELETE CASCADE,
  CONSTRAINT `bausteine_ibfk_2` FOREIGN KEY (`uID`) REFERENCES `user` (`uID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

INSERT INTO bausteine VALUES("1","2","1","{\"titel\":\"Wortcloud - Schattenwurf mit Kerze\",\"beschreibung\":\"&lt;p&gt;Gib Begriffe ein, die dir zum Themengebiet des nebenstehenden Videos einfallen.&lt;/p&gt;\",\"smBut\":\"1\"}");
INSERT INTO bausteine VALUES("4","1","1","{\"titel\":\"Frage 1\",\"beschreibung\":\"&lt;p&gt;Welche Antwort ist richtig?&lt;/p&gt;\",\"antwortOption\":[\"Antwort 1\",\"Antwort 2\",\"Antwort 3\",\"Antwort 4\",\"Antwort 5\",\"Antwort 6\"],\"erlaeuterung\":[\"&lt;p&gt;Begr&amp;uuml;ndung 1&lt;/p&gt;\",\"\",\"&lt;p&gt;Begr&amp;uuml;ndung &amp;nbsp;3&lt;/p&gt;\",\"&lt;p&gt;Begr&amp;uuml;ndung &amp;nbsp;4&lt;/p&gt;\",\"&lt;p&gt;Begr&amp;uuml;ndung &amp;nbsp;5&lt;/p&gt;\",\"&lt;p&gt;Begr&amp;uuml;ndung 6&lt;/p&gt;\"],\"richtigeOption\":[\"3\",\"5\",\"6\"],\"smBut\":\"1\"}");
INSERT INTO bausteine VALUES("5","1","1","{\"titel\":\"Test 2\",\"beschreibung\":\"&lt;p&gt;Frage 2&lt;/p&gt;\",\"antwortOption\":[\"AO1\",\"AO3\",\"\",\"\"],\"richtigeOption\":[\"1\"],\"erlaeuterung\":[\"&lt;p&gt;Erl1&lt;/p&gt;\",\"&lt;p&gt;Erl3&lt;/p&gt;\",\"\",\"\"],\"smBut\":\"1\"}");
INSERT INTO bausteine VALUES("6","3","1","{\"titel\":\"Umfrage 1\",\"beschreibung\":\"&lt;p&gt;Das ist meine erste Umfrage, was h&amp;auml;lltst du davon?&lt;/p&gt;\",\"multiple_abstOption\":\"1\",\"showAuswertung\":\"off\",\"abstOption\":[\"Super\",\"gut\",\"ganz ok\",\"schlecht\",\"funktioniert gar nicht!\"],\"smBut\":\"1\"}");
INSERT INTO bausteine VALUES("7","1","1","{\"titel\":\"Kraft\",\"beschreibung\":\"&lt;p&gt;Finde die richtigen Aussagen &amp;uuml;ber Kr&amp;auml;fte im Alltag&lt;/p&gt;\",\"antwortOption\":[\"F&uuml;r ein konstantes Temp ist eine konstante Antriebskraft n&ouml;tig.\",\"Das Tempo ist proportional zur antreibenden Kraft\",\"Versetzen wir einen K&ouml;rper durch das Wirken einer Kraft in Bewegung, erhalten wir diese Kraft beim Abbremsen wieder zur&uuml;ck. \",\"Ein K&ouml;rper &auml;ndert seinen Bewegungszustand nicht, solange keine Kraft auf Ihn wirkt\",\"Bewegte K&ouml;rper besitzen eine Kraft.\"],\"erlaeuterung\":[\"&lt;p&gt;Ein fahrendes Auto wird ohne Antrieb auf der Stra&amp;szlig;e zwar abgebremst, das liegt allerdings an der Luftreibung und an der Reibung der Reifen auf der Stra&amp;szlig;e. Diese bremsende Kraft muss kompensiert werden um ein konstantes Tempo aufrecht zu halten.&lt;/p&gt;&lt;p&gt;Vernachl&amp;auml;ssigen wir allerdings s&amp;auml;mtliche Reibungseinfl&amp;uuml;sse, dann muss keine Kraft kompensiert werden um ein konstantes Tempo zu halten.&lt;/p&gt;\",\"&lt;p&gt;Die Beschleunigung a ist proportional zur Kraft F $%F=m \\\\cdot a$%&lt;/p&gt;\",\"&lt;p&gt;W&amp;auml;hrend der Beschleunigung f&amp;uuml;hren wir einem K&amp;ouml;rper kinetische Energie zu. Beim Abbremsen erhalten wird diese kinetische Energie wieder in eine andere Energieform umgewandelt.&amp;nbsp;&lt;/p&gt;&lt;p&gt;Kr&amp;auml;fte hingegen erhalten wir nicht wieder zur&amp;uuml;ck!&lt;/p&gt;\",\"\",\"&lt;p&gt;Bewegte K&amp;ouml;rper besitzen kinetische Energie.&lt;/p&gt;\"],\"richtigeOption\":[\"4\"],\"smBut\":\"1\"}");
INSERT INTO bausteine VALUES("8","3","1","{\"titel\":\"Umfrage\",\"beschreibung\":\"&lt;p&gt;Wie hat Ihnen diese Pr&amp;auml;sentation gefallen&lt;/p&gt;\",\"multiple_abstOption\":\"off\",\"showAuswertung\":\"off\",\"abstOption\":[\"sehr gut\",\"gut\",\"neutral\",\"schlecht\",\"&uuml;berhaupt nicht\"],\"smBut\":\"1\"}");
INSERT INTO bausteine VALUES("9","3","1","{\"titel\":\"Testabstimmung\",\"beschreibung\":\"&lt;p&gt;Was h&amp;auml;ltst du davon?&lt;/p&gt;\",\"multiple_abstOption\":\"off\",\"showAuswertung\":\"on\",\"abstOption\":[\"genial\",\"super\",\"passt\",\"naja\",\"geht gar nicht\"],\"smBut\":\"1\"}");
INSERT INTO bausteine VALUES("10","4","1","{\"titel\":\"FCB - FCA\",\"ytlink\":\"https://www.youtube.com/watch?v=tEG_HZoxvgw\",\"smBut\":\"1\",\"ytID\":\"tEG_HZoxvgw\"}");
INSERT INTO bausteine VALUES("13","6","1","{\"titel\":\"DPG\",\"webUrl\":\"http://dpg-physik.de/index.html\",\"smBut\":\"1\"}");
INSERT INTO bausteine VALUES("14","7","1","{\"titel\":\"Registrierung\",\"embLink\":\"/module/user/user_registration_form.php\",\"smBut\":\"1\"}");
INSERT INTO bausteine VALUES("15","6","1","{\"titel\":\"LMU Didaktik Physik\",\"webUrl\":\"http://www.didaktik.physik.uni-muenchen.de/\",\"smBut\":\"1\"}");
INSERT INTO bausteine VALUES("17","6","1","{\"titel\":\"FM\",\"webUrl\":\"http://www.fast-mirror.de\",\"smBut\":\"1\"}");
INSERT INTO bausteine VALUES("18","4","1","{\"titel\":\"Lesch: Magnetfelder\",\"ytlink\":\"https://www.youtube.com/watch?v=hZEv04ibjKI\",\"smBut\":\"1\",\"ytID\":\"hZEv04ibjKI\"}");
INSERT INTO bausteine VALUES("19","5","1","{\"titel\":\"Test Eval 1\",\"beschreibung\":\"&lt;p&gt;Test&lt;/p&gt;\",\"FrageGroupsSel\":[\"1\",\"2\",\"3\",\"4\"],\"smBut\":\"1\"}");
INSERT INTO bausteine VALUES("20","5","1","{\"titel\":\"Test 2\",\"beschreibung\":\"&lt;p&gt;tEST &quot;&lt;/p&gt;\",\"FrageGroupsSel\":[\"1\",\"3\",\"4\"],\"smBut\":\"1\"}");
INSERT INTO bausteine VALUES("21","4","1","{\"titel\":\"FCB-SCF\",\"ytlink\":\"https://www.youtube.com/watch?v=14nG5_8sQM0\",\"von\":\"10\",\"bis\":\"70\",\"smBut\":\"1\",\"ytID\":\"14nG5_8sQM0\"}");



DROP TABLE bausteine_typen;

CREATE TABLE `bausteine_typen` (
  `bTypID` int(11) NOT NULL AUTO_INCREMENT,
  `titel` tinytext NOT NULL,
  `bs_dir` tinytext NOT NULL,
  `bs_add` tinytext NOT NULL,
  `bs_show` tinytext NOT NULL,
  `aktiv` tinyint(4) NOT NULL DEFAULT '1',
  `show` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`bTypID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

INSERT INTO bausteine_typen VALUES("1","Kontrollfragen","/module/mod_bausteine","add_kontrollfragen.php","show_kontrollfrage.php","1","1");
INSERT INTO bausteine_typen VALUES("2","Word Cloud","/module/mod_bausteine","add_wordcloud.php","show_wordcloud.php","1","1");
INSERT INTO bausteine_typen VALUES("3","Abstimmung","/module/mod_bausteine","add_abstimmung.php","show_abstimmung.php","1","1");
INSERT INTO bausteine_typen VALUES("4","YouTube Videos","/module/mod_bausteine","add_YouTube.php","show_YouTube.php","1","1");
INSERT INTO bausteine_typen VALUES("5","Evaluation","/module/mod_bausteine","add_evaluation.php","show_evaluation.php","1","1");
INSERT INTO bausteine_typen VALUES("6","Webpage einbinden","/module/mod_bausteine","add_webpage.php","show_webpage.php","1","1");
INSERT INTO bausteine_typen VALUES("7","Registrierung einbinden","/module/mod_bausteine","add_embed_registration.php","show_embed_registration.php","1","0");



DROP TABLE folien;

CREATE TABLE `folien` (
  `fID` int(11) NOT NULL AUTO_INCREMENT,
  `uID` int(11) NOT NULL COMMENT 'uID des Erstellers',
  `kursID` int(11) NOT NULL COMMENT 'zugeordneter Kurs',
  `modID` int(11) NOT NULL,
  `aTyp` int(11) NOT NULL DEFAULT '1' COMMENT '1: Aufgabe; 2:Korrektur; 3:Feedback',
  `zu_fID` int(11) NOT NULL DEFAULT '0' COMMENT 'zugeordnete fID',
  `viewTyp` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:alle; 2:Auswahl 3: alle bis auf',
  `parameter` text NOT NULL COMMENT 'aktivStatus:0:deaktiviert; 1:immer anzeigen; 2: anzeigen nach Reihenfolge; 3: keine Anzeige nach Bearbeitung; 4:inaktiv; 5: aktiv nach Freigabe',
  `cp_fID` int(11) NOT NULL COMMENT 'fID der ursprünglichen Folie',
  PRIMARY KEY (`fID`),
  KEY `uID` (`uID`),
  KEY `kursID` (`kursID`),
  KEY `modID` (`modID`),
  CONSTRAINT `folien_ibfk_1` FOREIGN KEY (`uID`) REFERENCES `user` (`uID`) ON DELETE CASCADE,
  CONSTRAINT `folien_ibfk_2` FOREIGN KEY (`kursID`) REFERENCES `kurs` (`kursID`) ON DELETE CASCADE,
  CONSTRAINT `folien_ibfk_3` FOREIGN KEY (`modID`) REFERENCES `module` (`modID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1281 DEFAULT CHARSET=utf8;

INSERT INTO folien VALUES("1","1","21","2","1","0","2","{\"ytID\":\"lQDao4Kjd9E\",\"ytlink\":\"https://www.youtube.com/watch?v=lQDao4Kjd9E\",\"titel\":\"Testtitel\",\"beschreibung\":\"Testbeschreibung\",\"tnarr\":[\"39\",\"41\",\"42\"]}","0");
INSERT INTO folien VALUES("4","1","21","1","1","0","1","{\"vID\":24,\"titel\":\"Videovertonung Test1\",\"beschreibung\":\"&lt;p&gt;Sie sollen nachfolgenden Stummfilm eines Experiments vertonen. Legen Sie dabei besonders Wert auf folgende Punkte:&lt;\\/p&gt;&lt;ul&gt;&lt;li&gt;Beschreiben Sie Aufbau und ben&amp;ouml;tigte Ger&amp;auml;te.&lt;\\/li&gt;&lt;li&gt;Formulieren Sie die durch das Experiment zu &amp;uuml;berpr&amp;uuml;fenden Hypothesen.&lt;\\/li&gt;&lt;li&gt;Erl&amp;auml;utern Sie alle Schritte w&amp;auml;hrend des Experimentiervorgangs OHNE dabei Erklu&amp;auml;rungen zu liefern.&lt;\\/li&gt;&lt;li&gt;Lenken Sie durch gezielte Impulse die Aufmerksamkeit der Sch&amp;uuml;lerinnen und Sch&amp;uuml;ler auf den gerade aktuellen Gegenstand.&lt;\\/li&gt;&lt;li&gt;Sichern Sie die Beobachtungen nach kurzer Bedenkzeit.&lt;\\/li&gt;&lt;\\/ul&gt;&lt;p&gt;Ziel soll es sein, dass Sch&amp;uuml;lerinnen und Sch&amp;uuml;ler, die dieses Experiment mit Ihrer Vertonung ansehen, im Anschluss auf Fragen wie:&lt;\\/p&gt;&lt;ul&gt;&lt;li&gt;Beschreibe deine Beobachtungen.&lt;\\/li&gt;&lt;li&gt;Beschreibe das Vorgehen beim Experimentieren.&lt;\\/li&gt;&lt;li&gt;...&lt;\\/li&gt;&lt;\\/ul&gt;&lt;p&gt;antworten k&amp;ouml;nnen.&lt;\\/p&gt;&lt;p&gt;&lt;span style=&quot;color: #ff0000;&quot;&gt;&lt;strong&gt;Eine Erkl&amp;auml;rung des Ph&amp;auml;nomens oder eines Zusammenhangs ist NICHT Teil der Aufgabe! Es geht ausschlie&amp;szlig;flich um die Lenkung der Aufmerksamkeit der Sch&amp;uuml;lerinnen und Sch&amp;uuml;ler auf den jeweils aktuell wichtigen Experimentteil!&lt;\\/strong&gt;&lt;\\/span&gt;&lt;\\/p&gt;\"}","0");
INSERT INTO folien VALUES("5","1","21","2","1","0","1","{\"vID\":31,\"titel\":\"Test 2\",\"beschreibung\":\"Testbeschreibung 2\",\"aktivStatus\":1,\"tnarr\":[]}","0");
INSERT INTO folien VALUES("10","1","21","4","2","4","1","{\"titel\":\"Testkorr1\",\"beschreibung\":\"Testbeschreibung Korr 1\",\"fGroupsArr\":[2],\"fArr\":[17,18,19]}","0");
INSERT INTO folien VALUES("12","1","21","5","3","4","1","{\"titel\":\"Testfeedback 0815\",\"beschreibung\":\"Feedback 1\"}","0");
INSERT INTO folien VALUES("13","1","1","1","1","0","1","{\"vID\":37,\"titel\":\"Brechung - M&uuml;nze\",\"inhalt\":\"\"}","0");
INSERT INTO folien VALUES("14","1","1","1","1","0","1","{\"vID\":49,\"titel\":\"Absorption\",\"beschreibung\":\"&lt;p&gt;Sie sollen nachfolgenden Stummfilm eines Experiments vertonen. Legen Sie dabei besonders Wert auf folgende Punkte:&lt;\\/p&gt;\\r\\n&lt;ul&gt;\\r\\n&lt;li&gt;Beschreiben Sie Aufbau und benu00f6tigte Geru00e4te.&lt;\\/li&gt;\\r\\n&lt;li&gt;Formulieren Sie die durch das Experiment zu u00fcberpru00fcfenden Hypothesen.&lt;\\/li&gt;\\r\\n&lt;li&gt;Erlu00e4utern Sie alle Schritte wu00e4hrend des Experimentiervorgangs OHNE dabei Erklu00e4rungen zu liefern.&lt;\\/li&gt;\\r\\n&lt;li&gt;Lenken Sie durch gezielte Impulse die Aufmerksamkeit der Schu00fclerinnen und Schu00fcler auf den gerade aktuellen Gegenstand.&lt;\\/li&gt;\\r\\n&lt;li&gt;Sichern Sie die Beobachtungen nach kurzer Bedenkzeit.&lt;\\/li&gt;\\r\\n&lt;\\/ul&gt;\\r\\n&lt;p&gt;Ziel soll es sein, dass Schu00fclerinnen und Schu00fcler, die dieses Experiment mit Ihrer Vertonung ansehen, im Anschluss auf Fragen wie:&lt;\\/p&gt;\\r\\n&lt;ul&gt;\\r\\n&lt;li&gt;Beschreibe deine Beobachtungen.&lt;\\/li&gt;\\r\\n&lt;li&gt;Beschreibe das Vorgehen beim Experimentieren.&lt;\\/li&gt;\\r\\n&lt;li&gt;...&lt;\\/li&gt;\\r\\n&lt;\\/ul&gt;\\r\\n&lt;p&gt;antworten ku00f6nnen.&lt;\\/p&gt;\\r\\n&lt;p&gt;&lt;span style=&quot;color: #ff0000;&quot;&gt;&lt;strong&gt;Eine Erklu00e4rung des Phu00e4nomens oder eines Zusammenhangs ist NICHT Teil der Aufgabe! Es geht ausschlieu00dflich um die Lenkung der Aufmerksamkeit der Schu00fclerinnen und Schu00fcler auf den jeweils aktuell wichtigen Experimentteil!&lt;\\/strong&gt;&lt;\\/span&gt;&lt;\\/p&gt;\"}","0");
INSERT INTO folien VALUES("15","1","1","1","1","0","1","{\"vID\":50,\"titel\":\"Beugung am Spalt\",\"beschreibung\":\"&lt;p&gt;Sie sollen nachfolgenden Stummfilm eines Experiments vertonen. Legen Sie dabei besonders Wert auf folgende Punkte:&lt;\\/p&gt;\\r\\n&lt;ul&gt;\\r\\n&lt;li&gt;Beschreiben Sie Aufbau und ben&ouml;tigte Ger&auml;te.&lt;\\/li&gt;\\r\\n&lt;li&gt;Formulieren Sie die durch das Experiment zu &uuml;berpr&uuml;fenden Hypothesen.&lt;\\/li&gt;\\r\\n&lt;li&gt;Erl&auml;utern Sie alle Schritte w&auml;hrend des Experimentiervorgangs OHNE dabei Erkl&auml;rungen zu liefern.&lt;\\/li&gt;\\r\\n&lt;li&gt;Lenken Sie durch gezielte Impulse die Aufmerksamkeit der Sch&uuml;lerinnen und Sch&uuml;ler auf den gerade aktuellen Gegenstand.&lt;\\/li&gt;\\r\\n&lt;li&gt;Sichern Sie die Beobachtungen nach kurzer Bedenkzeit.&lt;\\/li&gt;\\r\\n&lt;\\/ul&gt;\\r\\n&lt;p&gt;Ziel soll es sein, dass Sch&uuml;lerinnen und Sch&uuml;ler, die dieses Experiment mit Ihrer Vertonung ansehen, im Anschluss auf Fragen wie:&lt;\\/p&gt;\\r\\n&lt;ul&gt;\\r\\n&lt;li&gt;Beschreibe deine Beobachtungen.&lt;\\/li&gt;\\r\\n&lt;li&gt;Beschreibe das Vorgehen beim Experimentieren.&lt;\\/li&gt;\\r\\n&lt;li&gt;...&lt;\\/li&gt;\\r\\n&lt;\\/ul&gt;\\r\\n&lt;p&gt;antworten k&ouml;nnen.&lt;\\/p&gt;\\r\\n&lt;p&gt;&lt;span style=&quot;color: #ff0000;&quot;&gt;&lt;strong&gt;Eine Erkl&auml;rung des Ph&auml;nomens oder eines Zusammenhangs ist NICHT Teil der Aufgabe! Es geht ausschlie&szlig;lich um die Lenkung der Aufmerksamkeit der Sch&uuml;lerinnen und Sch&uuml;ler auf den jeweils aktuell wichtigen Experimentteil!&lt;\\/strong&gt;&lt;\\/span&gt;&lt;\\/p&gt;\"}","0");
INSERT INTO folien VALUES("16","1","1","1","1","0","2","{\"vID\":\"51\",\"titel\":\"Konvektion\",\"beschreibung\":\"&lt;p&gt;Sie sollen nachfolgenden Stummfilm eines Experiments vertonen. Legen Sie dabei besonders Wert auf folgende Punkte:&lt;\\/p&gt;\\r\\n&lt;ul&gt;\\r\\n&lt;li&gt;Beschreiben Sie Aufbau und ben&ouml;tigte Ger&auml;te.&lt;\\/li&gt;\\r\\n&lt;li&gt;Formulieren Sie die durch das Experiment zu &uuml;berpr&uuml;fenden Hypothesen.&lt;\\/li&gt;\\r\\n&lt;li&gt;Erl&auml;utern Sie alle Schritte w&auml;hrend des Experimentiervorgangs OHNE dabei Erkl&auml;rungen zu liefern.&lt;\\/li&gt;\\r\\n&lt;li&gt;Lenken Sie durch gezielte Impulse die Aufmerksamkeit der Sch&uuml;lerinnen und Sch&uuml;ler auf den gerade aktuellen Gegenstand.&lt;\\/li&gt;\\r\\n&lt;li&gt;Sichern Sie die Beobachtungen nach kurzer Bedenkzeit.&lt;\\/li&gt;\\r\\n&lt;\\/ul&gt;\\r\\n&lt;p&gt;Ziel soll es sein, dass Sch&uuml;lerinnen und Sch&uuml;ler, die dieses Experiment mit Ihrer Vertonung ansehen, im Anschluss auf Fragen wie:&lt;\\/p&gt;\\r\\n&lt;ul&gt;\\r\\n&lt;li&gt;Beschreibe deine Beobachtungen.&lt;\\/li&gt;\\r\\n&lt;li&gt;Beschreibe das Vorgehen beim Experimentieren.&lt;\\/li&gt;\\r\\n&lt;li&gt;...&lt;\\/li&gt;\\r\\n&lt;\\/ul&gt;\\r\\n&lt;p&gt;antworten k&ouml;nnen.&lt;\\/p&gt;\\r\\n&lt;p&gt;&lt;span style=&quot;color: #ff0000;&quot;&gt;&lt;strong&gt;Eine Erkl&auml;rung des Ph&auml;nomens oder eines Zusammenhangs ist NICHT Teil der Aufgabe! Es geht ausschlie&szlig;lich um die Lenkung der Aufmerksamkeit der Sch&uuml;lerinnen und Sch&uuml;ler auf den jeweils aktuell wichtigen Experimentteil!&lt;\\/strong&gt;&lt;\\/span&gt;&lt;\\/p&gt;\",\"tnarr\":[110,118,124,132]}","0");
INSERT INTO folien VALUES("17","1","1","1","1","0","2","{\"titel\":\"Multimediaprinzip\",\"inhalt\":\"<p>&lt;iframe class=\\\"iframe70\\\" src=\\\"<a href=\\\"http://www.didaktik.physik.uni-muenchen.de/elektronenbahnen/e-feld/hypothesen/Versuchsaufbau.php\\\">http://www.didaktik.physik.uni-muenchen.de/elektronenbahnen/e-feld/hypothesen/Versuchsaufbau.php</a>\\\" name=\\\"SELFHTML_in_a_box\\\" width=\\\"900px\\\" height=\\\"1000px\\\"&gt;<br /> &amp;lt;p&amp;gt;Ihr Browser kann leider keine eingebetteten Frames anzeigen:<br /> Sie k&ouml;nnen die eingebettete Seite &uuml;ber den folgenden Verweis<br /> aufrufen: &amp;lt;a href=\\\"<a href=\\\"http://www.didaktik.physik.uni-muenchen.de/elektronenbahnen/e-feld/hypothesen/Versuchsaufbau.php\\\">http://www.didaktik.physik.uni-muenchen.de/elektronenbahnen/e-feld/hypothesen/Versuchsaufbau.php</a>\\\"&amp;gt;Kondensator laden&amp;lt;/a&amp;gt;&amp;lt;/p&amp;gt;&lt;/iframe&gt;</p>\",\"tnarr\":[111,119,125]}","0");
INSERT INTO folien VALUES("18","1","1","1","1","0","2","{\"vID\":\"54\",\"titel\":\"Reihenschaltung\",\"beschreibung\":\"&lt;p&gt;Sie sollen nachfolgenden Stummfilm eines Experiments vertonen. Legen Sie dabei besonders Wert auf folgende Punkte:&lt;\\/p&gt;\\r\\n&lt;ul&gt;\\r\\n&lt;li&gt;Beschreiben Sie Aufbau und ben&ouml;tigte Ger&auml;te.&lt;\\/li&gt;\\r\\n&lt;li&gt;Formulieren Sie die durch das Experiment zu &uuml;berpr&uuml;fenden Hypothesen.&lt;\\/li&gt;\\r\\n&lt;li&gt;Erl&auml;utern Sie alle Schritte w&auml;hrend des Experimentiervorgangs OHNE dabei Erkl&auml;rungen zu liefern.&lt;\\/li&gt;\\r\\n&lt;li&gt;Lenken Sie durch gezielte Impulse die Aufmerksamkeit der Sch&uuml;lerinnen und Sch&uuml;ler auf den gerade aktuellen Gegenstand.&lt;\\/li&gt;\\r\\n&lt;li&gt;Sichern Sie die Beobachtungen nach kurzer Bedenkzeit.&lt;\\/li&gt;\\r\\n&lt;\\/ul&gt;\\r\\n&lt;p&gt;Ziel soll es sein, dass Sch&uuml;lerinnen und Sch&uuml;ler, die dieses Experiment mit Ihrer Vertonung ansehen, im Anschluss auf Fragen wie:&lt;\\/p&gt;\\r\\n&lt;ul&gt;\\r\\n&lt;li&gt;Beschreibe deine Beobachtungen.&lt;\\/li&gt;\\r\\n&lt;li&gt;Beschreibe das Vorgehen beim Experimentieren.&lt;\\/li&gt;\\r\\n&lt;li&gt;...&lt;\\/li&gt;\\r\\n&lt;\\/ul&gt;\\r\\n&lt;p&gt;antworten k&ouml;nnen.&lt;\\/p&gt;\\r\\n&lt;p&gt;&lt;span style=&quot;color: #ff0000;&quot;&gt;&lt;strong&gt;Eine Erkl&auml;rung des Ph&auml;nomens oder eines Zusammenhangs ist NICHT Teil der Aufgabe! Es geht ausschlie&szlig;lich um die Lenkung der Aufmerksamkeit der Sch&uuml;lerinnen und Sch&uuml;ler auf den jeweils aktuell wichtigen Experimentteil!&lt;\\/strong&gt;&lt;\\/span&gt;&lt;\\/p&gt;\",\"tnarr\":[112,120,126]}","0");
INSERT INTO folien VALUES("19","1","1","1","1","0","2","{\"vID\":\"56\",\"titel\":\"Spannungsabfall\",\"beschreibung\":\"&lt;p&gt;Sie sollen nachfolgenden Stummfilm eines Experiments vertonen. Legen Sie dabei besonders Wert auf folgende Punkte:&lt;\\/p&gt;\\r\\n&lt;ul&gt;\\r\\n&lt;li&gt;Beschreiben Sie Aufbau und ben&ouml;tigte Ger&auml;te.&lt;\\/li&gt;\\r\\n&lt;li&gt;Formulieren Sie die durch das Experiment zu &uuml;berpr&uuml;fenden Hypothesen.&lt;\\/li&gt;\\r\\n&lt;li&gt;Erl&auml;utern Sie alle Schritte w&auml;hrend des Experimentiervorgangs OHNE dabei Erkl&auml;rungen zu liefern.&lt;\\/li&gt;\\r\\n&lt;li&gt;Lenken Sie durch gezielte Impulse die Aufmerksamkeit der Sch&uuml;lerinnen und Sch&uuml;ler auf den gerade aktuellen Gegenstand.&lt;\\/li&gt;\\r\\n&lt;li&gt;Sichern Sie die Beobachtungen nach kurzer Bedenkzeit.&lt;\\/li&gt;\\r\\n&lt;\\/ul&gt;\\r\\n&lt;p&gt;Ziel soll es sein, dass Sch&uuml;lerinnen und Sch&uuml;ler, die dieses Experiment mit Ihrer Vertonung ansehen, im Anschluss auf Fragen wie:&lt;\\/p&gt;\\r\\n&lt;ul&gt;\\r\\n&lt;li&gt;Beschreibe deine Beobachtungen.&lt;\\/li&gt;\\r\\n&lt;li&gt;Beschreibe das Vorgehen beim Experimentieren.&lt;\\/li&gt;\\r\\n&lt;li&gt;...&lt;\\/li&gt;\\r\\n&lt;\\/ul&gt;\\r\\n&lt;p&gt;antworten k&ouml;nnen.&lt;\\/p&gt;\\r\\n&lt;p&gt;&lt;span style=&quot;color: #ff0000;&quot;&gt;&lt;strong&gt;Eine Erkl&auml;rung des Ph&auml;nomens oder eines Zusammenhangs ist NICHT Teil der Aufgabe! Es geht ausschlie&szlig;lich um die Lenkung der Aufmerksamkeit der Sch&uuml;lerinnen und Sch&uuml;ler auf den jeweils aktuell wichtigen Experimentteil!&lt;\\/strong&gt;&lt;\\/span&gt;&lt;\\/p&gt;\",\"tnarr\":[113,127]}","0");
INSERT INTO folien VALUES("20","1","1","1","1","0","2","{\"vID\":\"52\",\"titel\":\"Volumenausdehnung\",\"beschreibung\":\"&lt;p&gt;Sie sollen nachfolgenden Stummfilm eines Experiments vertonen. Legen Sie dabei besonders Wert auf folgende Punkte:&lt;\\/p&gt;\\r\\n&lt;ul&gt;\\r\\n&lt;li&gt;Beschreiben Sie Aufbau und ben&ouml;tigte Ger&auml;te.&lt;\\/li&gt;\\r\\n&lt;li&gt;Formulieren Sie die durch das Experiment zu &uuml;berpr&uuml;fenden Hypothesen.&lt;\\/li&gt;\\r\\n&lt;li&gt;Erl&auml;utern Sie alle Schritte w&auml;hrend des Experimentiervorgangs OHNE dabei Erkl&auml;rungen zu liefern.&lt;\\/li&gt;\\r\\n&lt;li&gt;Lenken Sie durch gezielte Impulse die Aufmerksamkeit der Sch&uuml;lerinnen und Sch&uuml;ler auf den gerade aktuellen Gegenstand.&lt;\\/li&gt;\\r\\n&lt;li&gt;Sichern Sie die Beobachtungen nach kurzer Bedenkzeit.&lt;\\/li&gt;\\r\\n&lt;\\/ul&gt;\\r\\n&lt;p&gt;Ziel soll es sein, dass Sch&uuml;lerinnen und Sch&uuml;ler, die dieses Experiment mit Ihrer Vertonung ansehen, im Anschluss auf Fragen wie:&lt;\\/p&gt;\\r\\n&lt;ul&gt;\\r\\n&lt;li&gt;Beschreibe deine Beobachtungen.&lt;\\/li&gt;\\r\\n&lt;li&gt;Beschreibe das Vorgehen beim Experimentieren.&lt;\\/li&gt;\\r\\n&lt;li&gt;...&lt;\\/li&gt;\\r\\n&lt;\\/ul&gt;\\r\\n&lt;p&gt;antworten k&ouml;nnen.&lt;\\/p&gt;\\r\\n&lt;p&gt;&lt;span style=&quot;color: #ff0000;&quot;&gt;&lt;strong&gt;Eine Erkl&auml;rung des Ph&auml;nomens oder eines Zusammenhangs ist NICHT Teil der Aufgabe! Es geht ausschlie&szlig;lich um die Lenkung der Aufmerksamkeit der Sch&uuml;lerinnen und Sch&uuml;ler auf den jeweils aktuell wichtigen Experimentteil!&lt;\\/strong&gt;&lt;\\/span&gt;&lt;\\/p&gt;\",\"tnarr\":[114,128]}","0");
INSERT INTO folien VALUES("21","1","1","1","1","0","1","{\"vID\":49,\"titel\":\"Abs2\",\"beschreibung\":\"\"}","0");
INSERT INTO folien VALUES("22","1","1","6","1","0","1","{\"titel\":\"Test\",\"inhalt\":\"&lt;h1 id=&quot;mcetoc_1b8brplg31&quot;&gt;Das Multimediaprinzip&lt;/h1&gt;&lt;p&gt;stellt heraus, dass die Kombination von Text und Grafik f&amp;uuml;r den Lernerfolg der Lernenden besser ist als der Text oder die Grafik alleine. (multiple Repr&amp;auml;sentationen)&lt;/p&gt;&lt;p&gt;&amp;nbsp;&amp;ldquo;Students learn better from words and pictures than from words alone.&amp;rdquo; &amp;nbsp;&amp;nbsp;(Mayer, 2001, S. 63),&lt;/p&gt;&lt;p&gt;&amp;ldquo;However, simply adding pictures to words does not guarantee an improvement in learning&amp;nbsp;- that is, all multimedia presentations are not equally effective.&amp;ldquo;&amp;nbsp;(Mayer, 2005, S. 31)&lt;/p&gt;\"}","0");
INSERT INTO folien VALUES("29","1","1","6","1","0","1","{\"titel\":\"Test4\",\"inhalt\":\"&lt;h1&gt;Das Multimediaprinzip&lt;&sol;h1&gt;&lt;br &sol;&gt;&lt;p&gt;stellt heraus&comma; dass die Kombination von Text und Grafik f&amp;uuml&semi;r den Lernerfolg der Lernenden besser ist als der Text oder die Grafik alleine&period; &lpar;multiple Repr&amp;auml&semi;sentationen&rpar;&lt;&sol;p&gt;&lt;br &sol;&gt;&lt;p&gt;&lt;em&gt;&amp;ldquo&semi;Students learn better from words and pictures than from words alone&period;&amp;rdquo&semi; &amp;nbsp&semi;&amp;nbsp&semi;&lt;&sol;em&gt;&lpar;Mayer&comma; 2001&comma; S&period; 63&rpar;&comma;&lt;&sol;p&gt;&lt;br &sol;&gt;&lt;p&gt;&lt;em&gt;&amp;ldquo&semi;However&comma; simply adding pictures to words does not guarantee an improvement in learning&amp;nbsp&semi;- that is&comma; all multimedia presentations are not equally effective&period;&amp;ldquo&semi;&lt;&sol;em&gt;&amp;nbsp&semi;&lpar;Mayer&comma; 2005&comma; S&period; 31&rpar;&lt;&sol;p&gt;\"}","0");
INSERT INTO folien VALUES("31","1","1","6","1","0","1","{\"titel\":\"Herzlich Willkommen\",\"inhalt\":\"<h2 align=\\\"center\\\">Herzlich Willkommen zum Workshop 7</h2><h3 align=\\\"center\\\">Multimediaanwendungen im Physikunterricht</h3><h3 align=\\\"center\\\">Simulationen und Animationen ausw&auml;hlen, bewerten und einsetzen</h3><p align=\\\"center\\\">28. September 2016</p><p align=\\\"center\\\">LMU M&uuml;nchen</p><p align=\\\"center\\\">StR Peter Mayer</p><h4 align=\\\"center\\\"><span style=\\\"color: #000000;\\\"><strong>WLAN-Zugang</strong></span></h4><p align=\\\"center\\\">SSID: &nbsp;<span style=\\\"color: #ff0000;\\\"><strong>Eduroam</strong></span></p><p align=\\\"center\\\">Benutzername: &nbsp;<strong><span style=\\\"color: #ff0000;\\\">di49hig@eduroam.mwn.de</span></strong></p><p align=\\\"center\\\">Passwort:&nbsp;<strong><span style=\\\"color: #ff0000;\\\">Lehrertag16</span></strong></p><p>&nbsp;</p>\"}","0");
INSERT INTO folien VALUES("32","1","1","6","1","0","1","{\"titel\":\"Multimediaprinzip\",\"inhalt\":\"<p><iframe src=\\\"https://phet.colorado.edu/sims/html/states-of-matter/latest/states-of-matter_de.html\\\" width=\\\"800\\\" height=\\\"600\\\" scrolling=\\\"no\\\" allowfullscreen=\\\"allowfullscreen\\\"></iframe></p>\"}","0");
INSERT INTO folien VALUES("33","1","1","4","2","13","1","{\"titel\":\"Testkorrektur 1\",\"beschreibung\":\"Korrigieren Sie die Lu00f6sung.\",\"fGroupsArr\":[1,2,3,4],\"fArr\":[]}","0");
INSERT INTO folien VALUES("34","1","22","6","1","0","1","{\"titel\":\"Testfolie einspaltig\",\"inhalt\":\"&lt;p&gt;Testinhalt einspaltig&lt;/p&gt;\",\"DesignTyp\":1}","0");
INSERT INTO folien VALUES("35","1","22","6","1","0","1","{\"DesignTyp\":\"2\",\"titel\":\"Testtitel\",\"fID\":\"35\",\"Baustein_1\":\"1\",\"inhalt_1\":\"&lt;p&gt;Block 1&lt;/p&gt;\",\"Baustein_2\":\"2\",\"tem_vID_2\":\"24\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("37","1","22","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Testtitel 15:11\",\"fID\":\"37\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Aufgabenbeschreibung&lt;/p&gt;\",\"Baustein_1\":\"5\",\"bID_1\":\"6\",\"Baustein_2\":\"5\",\"bID_2\":\"1\",\"Baustein_bottom\":\"1\",\"inhalt_bottom\":\"&lt;p&gt;Abspann&lt;/p&gt;\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("38","1","23","6","1","0","1","{\"DesignTyp\":1,\"titel\":\"Begr&uuml;&szlig;ung\",\"fID\":\"38\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;mit dieser Pr&amp;auml;sentation k&amp;ouml;nnen Sie sich einen &amp;Uuml;berblick &amp;uuml;ber die&amp;nbsp;M&amp;ouml;glichkeiten die Ihnen dieses&amp;nbsp;Programm liefert, verschaffen.&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&lt;img style=&quot;display: block; margin-left: auto; margin-right: auto; max-width: 400px;&quot; src=&quot;uploads/1/58a8b3b12fb23.png&quot; width=&quot;100%&quot; /&gt;&lt;/p&gt;\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("39","1","23","6","1","0","1","{\"DesignTyp\":1,\"titel\":\"Experimentvideos\",\"fID\":\"39\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Sie k&amp;ouml;nnen Ihren Sch&amp;uuml;lern / Studenten Videos von Experimenten zeigen um auf wichtige Aspekte des Experimentierens hinzuweisen.&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"31\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("40","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Multimodale Darstellung\",\"fID\":\"0\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Sie k&amp;ouml;nnen verschiedene Darstellunsformen - z.B. Video und Simulation - gegen&amp;uuml;berstellen um so eine gr&amp;ouml;&amp;szlig;ere Verarbeitungstiefe des Lerninhalts zu erreichen.&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"35\",\"Baustein_2\":\"3\",\"tem_simID_2\":\"10\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("41","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Kontrollfragen\",\"fID\":\"41\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Den Sch&amp;uuml;lern / Studenten k&amp;ouml;nnen Kontrollfragen angezeigt werden um den Leistungsstand zu kontrollieren.&lt;/p&gt;\",\"Baustein_1\":\"3\",\"tem_simID_1\":\"8\",\"Baustein_2\":\"5\",\"bID_2\":\"7\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("42","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Begriffssammlung\",\"fID\":\"42\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Aufgabe:&amp;nbsp;&lt;/p&gt;&lt;p&gt;Schaue dir zun&amp;auml;chst das Video an und gebe&amp;nbsp;dann im nebenstehendem Eingabefeld Begriffe ein, die dir zu diesem Themengebiet einfallen.&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"45\",\"Baustein_2\":\"5\",\"bID_2\":\"1\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("43","1","23","6","1","0","1","{\"DesignTyp\":2,\"savePraes\":\"3\",\"titel\":\"Umfrage\",\"fID\":\"43\",\"Baustein_1\":\"5\",\"bID_1\":\"8\",\"Baustein_2\":\"1\",\"inhalt_2\":\"&lt;p style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&amp;nbsp;&lt;img src=&quot;uploads/1/58a8b2330c6dc.png&quot; width=&quot;248&quot; height=&quot;398&quot; /&gt;&lt;/p&gt;\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("44","1","23","1","1","0","1","{\"vID\":37,\"titel\":\"Vertonung - M&uuml;nze in der Tasse\",\"beschreibung\":\"&lt;p&gt;Vertonen Sie nachfolgendes Experiment.&lt;\\/p&gt;\"}","0");
INSERT INTO folien VALUES("45","1","23","1","2","44","1","{\"titel\":\"Korrektur der Videovertonung\",\"beschreibung\":\"Korrigieren Sie die Videovertonung\",\"fGroupsArr\":[1],\"fArr\":[16,17]}","0");
INSERT INTO folien VALUES("46","1","23","5","3","44","1","{\"titel\":\"Feedback zur Vertonung\",\"beschreibung\":\"Nachfolgend finden Sie das Feedback zur Videovertonung\"}","0");
INSERT INTO folien VALUES("47","1","23","6","1","0","1","{\"DesignTyp\":1,\"titel\":\"Dipolstrahlung\",\"fID\":\"47\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Beschreiben Sie, die Energiestr&amp;ouml;mungsrichtung in Abh&amp;auml;ngigkeit von der Zeit.&lt;/p&gt;\",\"Baustein_1\":\"3\",\"tem_simID_1\":\"13\",\"Baustein_bottom\":\"4\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("48","1","24","1","1","0","1","{\"vID\":31,\"titel\":\"Geknickter Stab\",\"beschreibung\":\"&lt;p class=&quot;&quot;&gt;&amp;nbsp;Sie sollen nachfolgenden Stummfilm eines Experiments vertonen. Legen Sie dabei besonders Wert auf folgende Punkte:&lt;\\/p&gt;&lt;ul&gt;&lt;li&gt;Beschreiben Sie Aufbau und ben&amp;ouml;tigte Ger&amp;auml;te.&lt;\\/li&gt;&lt;li&gt;Formulieren Sie die durch das Experiment zu &amp;uuml;berpr&amp;uuml;fenden Hypothesen.&lt;\\/li&gt;&lt;li&gt;Erl&amp;auml;utern Sie alle Schritte w&amp;auml;hrend des Experimentiervorgangs OHNE dabei Erkl&amp;auml;rungen zu liefern.&lt;\\/li&gt;&lt;li&gt;Lenken Sie durch gezielte Impulse die Aufmerksamkeit der Sch&amp;uuml;lerinnen und Sch&amp;uuml;ler auf den gerade aktuellen Gegenstand.&lt;\\/li&gt;&lt;li&gt;Sichern Sie die Beobachtungen nach kurzer Bedenkzeit.&lt;\\/li&gt;&lt;\\/ul&gt;&lt;p&gt;Ziel soll es sein, dass Sch&amp;uuml;lerinnen und Sch&amp;uuml;ler, die dieses Experiment mit Ihrer Vertonung ansehen, im Anschluss auf Fragen wie:&lt;\\/p&gt;&lt;ul&gt;&lt;li&gt;Beschreibe deine Beobachtungen.&lt;\\/li&gt;&lt;li&gt;Beschreibe das Vorgehen beim Experimentieren.&lt;\\/li&gt;&lt;li&gt;...&lt;\\/li&gt;&lt;\\/ul&gt;&lt;p&gt;antworten k&amp;ouml;nnen.&lt;\\/p&gt;&lt;p&gt;&lt;span style=&quot;color: #ff0000;&quot;&gt;&lt;strong&gt;Eine Erkl&amp;auml;rung des Ph&amp;auml;nomens oder eines Zusammenhangs ist NICHT Teil der Aufgabe! Es geht ausschlie&amp;szlig;lich um die Lenkung der Aufmerksamkeit der Sch&amp;uuml;lerinnen und Sch&amp;uuml;ler auf den jeweils aktuell wichtigen Experimentteil!&lt;\\/strong&gt;&lt;\\/span&gt;&lt;\\/p&gt;\"}","0");
INSERT INTO folien VALUES("49","1","24","4","2","48","1","{\"titel\":\"Bewertung - Geknickter Stab\",\"beschreibung\":\"Bewerten Sie die Leistung Ihres Kommilitionen\",\"fGroupsArr\":[1,2],\"fArr\":[]}","0");
INSERT INTO folien VALUES("50","1","24","5","3","48","2","{\"titel\":\"Feedback - Gecknickter Stab\",\"beschreibung\":\"Nachfolgend finden Sie das Feedback zur Vertonung Ihres Experimentiervideos\",\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("51","1","21","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Testumfrage 14:57\",\"fID\":\"51\",\"Baustein_1\":\"5\",\"bID_1\":\"10\",\"Baustein_2\":\"5\",\"bID_2\":\"9\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("52","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Kreisbewegung\",\"fID\":\"52\",\"Baustein_1\":\"3\",\"tem_simID_1\":\"16\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("53","1","22","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Kreisbewegung\",\"fID\":\"53\",\"Baustein_1\":\"3\",\"tem_simID_1\":\"16\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("54","1","24","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"TestFolie\",\"fID\":\"54\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"24\",\"viewTyp\":\"1\",\"CopyToKursID\":\"25\"}","0");
INSERT INTO folien VALUES("55","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test Folie\",\"fID\":\"0\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"24\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("56","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test Folie\",\"fID\":\"0\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"24\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("57","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test 2\",\"fID\":\"0\",\"Baustein_1\":\"1\",\"inhalt_1\":\"&lt;p&gt;sdfsd sdf assdf sadfsd ter g sdfa stehfdgsdaf wretwsdf geawesfdvx&lt;/p&gt;\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("58","1","25","2","1","0","1","{\"vID\":41,\"titel\":\"Testtitel 15:11\",\"beschreibung\":\"\",\"aktivStatus\":1,\"tnarr\":[]}","0");
INSERT INTO folien VALUES("59","1","25","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Wordcloud &amp; Abstimmung\",\"fID\":\"59\",\"Baustein_1\":\"5\",\"bID_1\":\"1\",\"Baustein_2\":\"5\",\"bID_2\":\"8\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("60","1","25","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Konzentration FCB-HSV\",\"fID\":\"60\",\"Baustein_1\":\"3\",\"tem_simID_1\":\"9\",\"Baustein_2\":\"5\",\"bID_2\":\"10\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("61","1","24","1","1","0","1","{\"vID\":31,\"titel\":\"Geknickter Stab\",\"beschreibung\":\"&lt;p class=&quot;&quot;&gt;&amp;nbsp;Sie sollen nachfolgenden Stummfilm eines Experiments vertonen. Legen Sie dabei besonders Wert auf folgende Punkte:&lt;\\/p&gt;&lt;ul&gt;&lt;li&gt;Beschreiben Sie Aufbau und ben&amp;ouml;tigte Ger&amp;auml;te.&lt;\\/li&gt;&lt;li&gt;Formulieren Sie die durch das Experiment zu &amp;uuml;berpr&amp;uuml;fenden Hypothesen.&lt;\\/li&gt;&lt;li&gt;Erl&amp;auml;utern Sie alle Schritte w&amp;auml;hrend des Experimentiervorgangs OHNE dabei Erkl&amp;auml;rungen zu liefern.&lt;\\/li&gt;&lt;li&gt;Lenken Sie durch gezielte Impulse die Aufmerksamkeit der Sch&amp;uuml;lerinnen und Sch&amp;uuml;ler auf den gerade aktuellen Gegenstand.&lt;\\/li&gt;&lt;li&gt;Sichern Sie die Beobachtungen nach kurzer Bedenkzeit.&lt;\\/li&gt;&lt;\\/ul&gt;&lt;p&gt;Ziel soll es sein, dass Sch&amp;uuml;lerinnen und Sch&amp;uuml;ler, die dieses Experiment mit Ihrer Vertonung ansehen, im Anschluss auf Fragen wie:&lt;\\/p&gt;&lt;ul&gt;&lt;li&gt;Beschreibe deine Beobachtungen.&lt;\\/li&gt;&lt;li&gt;Beschreibe das Vorgehen beim Experimentieren.&lt;\\/li&gt;&lt;li&gt;...&lt;\\/li&gt;&lt;\\/ul&gt;&lt;p&gt;antworten k&amp;ouml;nnen.&lt;\\/p&gt;&lt;p&gt;&lt;span style=&quot;color: #ff0000;&quot;&gt;&lt;strong&gt;Eine Erkl&amp;auml;rung des Ph&amp;auml;nomens oder eines Zusammenhangs ist NICHT Teil der Aufgabe! Es geht ausschlie&amp;szlig;lich um die Lenkung der Aufmerksamkeit der Sch&amp;uuml;lerinnen und Sch&amp;uuml;ler auf den jeweils aktuell wichtigen Experimentteil!&lt;\\/strong&gt;&lt;\\/span&gt;&lt;\\/p&gt;\",\"CopyToKursID\":24}","0");
INSERT INTO folien VALUES("62","1","25","1","1","0","1","{\"vID\":24,\"titel\":\"Videovertonung Test1\",\"beschreibung\":\"&lt;p&gt;Sie sollen nachfolgenden Stummfilm eines Experiments vertonen. Legen Sie dabei besonders Wert auf folgende Punkte:&lt;\\/p&gt;&lt;ul&gt;&lt;li&gt;Beschreiben Sie Aufbau und ben&amp;ouml;tigte Ger&amp;auml;te.&lt;\\/li&gt;&lt;li&gt;Formulieren Sie die durch das Experiment zu &amp;uuml;berpr&amp;uuml;fenden Hypothesen.&lt;\\/li&gt;&lt;li&gt;Erl&amp;auml;utern Sie alle Schritte w&amp;auml;hrend des Experimentiervorgangs OHNE dabei Erklu&amp;auml;rungen zu liefern.&lt;\\/li&gt;&lt;li&gt;Lenken Sie durch gezielte Impulse die Aufmerksamkeit der Sch&amp;uuml;lerinnen und Sch&amp;uuml;ler auf den gerade aktuellen Gegenstand.&lt;\\/li&gt;&lt;li&gt;Sichern Sie die Beobachtungen nach kurzer Bedenkzeit.&lt;\\/li&gt;&lt;\\/ul&gt;&lt;p&gt;Ziel soll es sein, dass Sch&amp;uuml;lerinnen und Sch&amp;uuml;ler, die dieses Experiment mit Ihrer Vertonung ansehen, im Anschluss auf Fragen wie:&lt;\\/p&gt;&lt;ul&gt;&lt;li&gt;Beschreibe deine Beobachtungen.&lt;\\/li&gt;&lt;li&gt;Beschreibe das Vorgehen beim Experimentieren.&lt;\\/li&gt;&lt;li&gt;...&lt;\\/li&gt;&lt;\\/ul&gt;&lt;p&gt;antworten k&amp;ouml;nnen.&lt;\\/p&gt;&lt;p&gt;&lt;span style=&quot;color: #ff0000;&quot;&gt;&lt;strong&gt;Eine Erkl&amp;auml;rung des Ph&amp;auml;nomens oder eines Zusammenhangs ist NICHT Teil der Aufgabe! Es geht ausschlie&amp;szlig;flich um die Lenkung der Aufmerksamkeit der Sch&amp;uuml;lerinnen und Sch&amp;uuml;ler auf den jeweils aktuell wichtigen Experimentteil!&lt;\\/strong&gt;&lt;\\/span&gt;&lt;\\/p&gt;\",\"CopyToKursID\":25}","0");
INSERT INTO folien VALUES("63","1","25","2","1","0","2","{\"ytID\":\"lQDao4Kjd9E\",\"ytlink\":\"https://www.youtube.com/watch?v=lQDao4Kjd9E\",\"vID\":24,\"titel\":\"Testtitel\",\"beschreibung\":\"Testbeschreibung\",\"CopyToKursID\":25,\"aktivStatus\":1,\"tnarr\":[]}","0");
INSERT INTO folien VALUES("64","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test Pr&auml;sfolie im Einzelmodus\",\"fID\":\"0\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Testaufgabe&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"24\",\"Baustein_2\":\"4\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("65","1","1","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test Pr&auml;sfolie im Einzelmodus\",\"fID\":\"64\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Testaufgabe&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"24\",\"Baustein_2\":\"4\",\"viewTyp\":\"1\",\"CopyToKursID\":\"1\"}","0");
INSERT INTO folien VALUES("66","1","21","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test Pr&auml;sfolie im Einzelmodus\",\"fID\":\"65\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Testaufgabe&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"24\",\"Baustein_2\":\"4\",\"viewTyp\":\"1\",\"CopyToKursID\":\"21\"}","0");
INSERT INTO folien VALUES("72","1","25","1","1","0","2","{\"vID\":51,\"titel\":\"Konvektion\",\"beschreibung\":\"&lt;p&gt;Vertonen Sie&lt;\\/p&gt;\",\"CopyToKursID\":0,\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("73","1","25","4","2","72","1","{\"titel\":\"TEST 123456 Besprechung 123456\",\"beschreibung\":\"Geben Sie Ihrem Kommilitonen eine konkrete R&uuml;ckmeldung zu seiner Experimentvertonung.\",\"fGroupsArr\":[1],\"fArr\":[16]}","0");
INSERT INTO folien VALUES("74","1","25","5","3","73","1","{\"titel\":\"Feedback 1\",\"beschreibung\":\"Hier finden Sie das Feedback zu Ihrer Vertonung\"}","0");
INSERT INTO folien VALUES("75","1","25","4","2","72","1","{\"titel\":\"Testkorr\",\"beschreibung\":\"Test\",\"fGroupsArr\":[2],\"fArr\":[16]}","0");
INSERT INTO folien VALUES("77","1","25","5","3","75","1","{\"titel\":\"Testfeedback 2\",\"beschreibung\":\"FB\"}","0");
INSERT INTO folien VALUES("78","1","25","4","2","62","1","{\"titel\":\"Bewertung Konvektion TEST 12345467\",\"beschreibung\":\"Bewerten Sie die Vertonung\",\"fGroupsArr\":[1],\"fArr\":[]}","0");
INSERT INTO folien VALUES("79","1","25","5","3","62","1","{\"titel\":\"Feedback der Vertonung\",\"beschreibung\":\"Feedback\"}","0");
INSERT INTO folien VALUES("80","1","25","5","3","78","1","{\"titel\":\"TB Feedback\",\"beschreibung\":\"TBBem\"}","0");
INSERT INTO folien VALUES("81","1","25","1","1","0","2","{\"vID\":35,\"titel\":\"Testvertonung\",\"beschreibung\":\"\",\"CopyToKursID\":0,\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("82","1","25","4","2","81","1","{\"titel\":\"Testbewertung\",\"beschreibung\":\"Bewerteb Sie\",\"fGroupsArr\":[1],\"fArr\":[16,17]}","0");
INSERT INTO folien VALUES("83","1","25","5","3","82","1","{\"titel\":\"Testfeedback\",\"beschreibung\":\"\"}","0");
INSERT INTO folien VALUES("84","1","25","1","1","0","2","{\"vID\":49,\"titel\":\"Absorption\",\"beschreibung\":\"&lt;p&gt;Test&lt;\\/p&gt;\",\"CopyToKursID\":0,\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("85","1","25","3","1","0","2","{\"vID\":0,\"titel\":\"Testvideoanalyse 1\",\"beschreibung\":\"&lt;p&gt;Test VA1&lt;\\/p&gt;\",\"CopyToKursID\":0,\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("86","1","25","3","1","0","1","{\"eig_vID\":14,\"titel\":\"Testvideoanalyse 2\",\"beschreibung\":\"&lt;p&gt;TVa2&lt;\\/p&gt;\",\"CopyToKursID\":0,\"fGroupsArr\":[2,3],\"fArr\":[]}","0");
INSERT INTO folien VALUES("87","1","25","8","3","86","1","{\"titel\":\"Feedback VA2\",\"beschreibung\":\"Feedback Beschreibung VA2\"}","0");
INSERT INTO folien VALUES("88","1","25","6","1","0","0","{\"DesignTyp\":2,\"titel\":\"DPG\",\"webUrl\":\"http://dpg-physik.de/index.html\",\"smBut\":\"1\",\"tnarr\":[]}","0");
INSERT INTO folien VALUES("89","1","25","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test 28.03.2017\",\"fID\":\"89\",\"Baustein_1\":\"5\",\"bID_1\":\"17\",\"Baustein_2\":\"3\",\"tem_simID_2\":\"6\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("90","1","25","1","1","0","2","{\"vID\":31,\"titel\":\"Test (NEUE FOLIE)\",\"beschreibung\":\"\",\"CopyToKursID\":0,\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("91","1","25","1","1","0","2","{\"vID\":52,\"titel\":\"Test 2 (NEUE FOLIE)\",\"beschreibung\":\"\",\"CopyToKursID\":0,\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("92","1","25","4","2","90","1","{\"titel\":\"Test - NF 1\",\"beschreibung\":\"\",\"fGroupsArr\":[1,3],\"fArr\":[]}","0");
INSERT INTO folien VALUES("93","1","25","5","3","92","1","{\"titel\":\"Test - FB NF 1\",\"beschreibung\":\"\"}","0");
INSERT INTO folien VALUES("94","1","25","4","2","91","1","{\"titel\":\"Test Bew Neue Folie\",\"beschreibung\":\"\",\"fGroupsArr\":[2,3],\"fArr\":[17]}","0");
INSERT INTO folien VALUES("99","1","28","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test Eval 1\",\"fID\":\"99\",\"Baustein_1\":\"1\",\"inhalt_1\":\"\",\"Baustein_2\":\"5\",\"bID_2\":\"19\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("100","1","21","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test\",\"fID\":\"100\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"24\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("101","1","28","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test\",\"fID\":\"101\",\"Baustein_1\":\"1\",\"inhalt_1\":\"&lt;p&gt;&lt;img src=&quot;../../media/uploads/1_5902702ec75d6.png&quot; width=&quot;240&quot; height=&quot;173&quot; /&gt;&lt;/p&gt;\",\"Baustein_2\":\"5\",\"bID_2\":\"1\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("102","1","28","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test2\",\"fID\":\"0\",\"Baustein_1\":\"1\",\"inhalt_1\":\"&lt;p&gt;&lt;img src=&quot;../../media/uploads/1_5902758e69f4d.png&quot; width=&quot;588&quot; height=&quot;423&quot; /&gt;&lt;/p&gt;\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("104","1","28","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test4\",\"fID\":\"0\",\"Baustein_1\":\"1\",\"inhalt_1\":\"&lt;p&gt;&lt;img src=&quot;../../media/uploads/1_590276dfdc76a.png&quot; /&gt;&lt;/p&gt;\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("105","1","28","6","1","0","1","{\"DesignTyp\":1,\"titel\":\"Evaluation zum testen\",\"fID\":\"105\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("107","1","28","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Testfrage\",\"fID\":\"107\",\"Baustein_1\":\"5\",\"bID_1\":\"7\",\"Baustein_2\":\"4\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("108","1","28","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Testfolie 2\",\"fID\":\"0\",\"Baustein_1\":\"5\",\"bID_1\":\"6\",\"Baustein_2\":\"5\",\"bID_2\":\"1\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("109","1","28","6","1","0","1","{\"DesignTyp\":1,\"titel\":\"Matjax Test\",\"fID\":\"109\",\"Baustein_1\":\"1\",\"inhalt_1\":\"&lt;p&gt;$$x^2+3x+5x$$&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;lorem&amp;nbsp;%% x^2+3x+5x&amp;nbsp;%% ipsum&lt;/p&gt;&lt;p&gt;lorem &amp;sect;&amp;sect;&amp;nbsp;x^2+3x+5x &amp;sect;&amp;sect;&amp;nbsp;ipsum&lt;/p&gt;&lt;p&gt;lorem $x^2+3x+5x$ ipsum&lt;/p&gt;&lt;p&gt;lorem \\\\(x^2+3x+5x\\\\) ipsum&lt;img src=&quot;../../media/uploads/1_5922e7845c346.jpg&quot; /&gt;&lt;/p&gt;\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("110","1","23","6","1","0","1","{\"DesignTyp\":1,\"savePraes\":\"3\",\"titel\":\"Begr&uuml;&szlig;ung\",\"fID\":\"110\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;mit dieser Pr&amp;auml;sentation k&amp;ouml;nnen Sie sich einen &amp;Uuml;berblick &amp;uuml;ber die&amp;nbsp;M&amp;ouml;glichkeiten die Ihnen dieses&amp;nbsp;Programm liefert, verschaffen.&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&lt;img style=&quot;display: block; margin-left: auto; margin-right: auto; max-width: 400px;&quot; src=&quot;uploads/1/58a8b3b12fb23.png&quot; width=&quot;100%&quot; /&gt;&lt;/p&gt;\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("111","1","23","6","1","0","1","{\"DesignTyp\":1,\"titel\":\"Experimentvideos\",\"fID\":\"39\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Sie k&amp;ouml;nnen Ihren Sch&amp;uuml;lern / Studenten Videos von Experimenten zeigen um auf wichtige Aspekte des Experimentierens hinzuweisen.&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"31\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("112","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Multimodale Darstellung\",\"fID\":\"0\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Sie k&amp;ouml;nnen verschiedene Darstellunsformen - z.B. Video und Simulation - gegen&amp;uuml;berstellen um so eine gr&amp;ouml;&amp;szlig;ere Verarbeitungstiefe des Lerninhalts zu erreichen.&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"35\",\"Baustein_2\":\"3\",\"tem_simID_2\":\"10\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("113","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Kontrollfragen\",\"fID\":\"41\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Den Sch&amp;uuml;lern / Studenten k&amp;ouml;nnen Kontrollfragen angezeigt werden um den Leistungsstand zu kontrollieren.&lt;/p&gt;\",\"Baustein_1\":\"3\",\"tem_simID_1\":\"8\",\"Baustein_2\":\"5\",\"bID_2\":\"7\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("114","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Begriffssammlung\",\"fID\":\"42\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Aufgabe:&amp;nbsp;&lt;/p&gt;&lt;p&gt;Schaue dir zun&amp;auml;chst das Video an und gebe&amp;nbsp;dann im nebenstehendem Eingabefeld Begriffe ein, die dir zu diesem Themengebiet einfallen.&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"45\",\"Baustein_2\":\"5\",\"bID_2\":\"1\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("115","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Umfrage\",\"fID\":\"43\",\"Baustein_1\":\"5\",\"bID_1\":\"8\",\"Baustein_2\":\"1\",\"inhalt_2\":\"&lt;p style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&amp;nbsp;&lt;img src=&quot;uploads/1/58a8b2330c6dc.png&quot; width=&quot;248&quot; height=&quot;398&quot; /&gt;&lt;/p&gt;\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("116","1","23","1","1","0","1","{\"vID\":37,\"titel\":\"Vertonung - M&uuml;nze in der Tasse\",\"beschreibung\":\"&lt;p&gt;Vertonen Sie nachfolgendes Experiment.&lt;\\/p&gt;\"}","0");
INSERT INTO folien VALUES("117","1","23","1","2","44","1","{\"titel\":\"Korrektur der Videovertonung\",\"beschreibung\":\"Korrigieren Sie die Videovertonung\",\"fGroupsArr\":[1],\"fArr\":[16,17]}","0");
INSERT INTO folien VALUES("118","1","23","5","3","44","1","{\"titel\":\"Feedback zur Vertonung\",\"beschreibung\":\"Nachfolgend finden Sie das Feedback zur Videovertonung\"}","0");
INSERT INTO folien VALUES("119","1","23","6","1","0","1","{\"DesignTyp\":1,\"titel\":\"Dipolstrahlung\",\"fID\":\"47\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Beschreiben Sie, die Energiestr&amp;ouml;mungsrichtung in Abh&amp;auml;ngigkeit von der Zeit.&lt;/p&gt;\",\"Baustein_1\":\"3\",\"tem_simID_1\":\"13\",\"Baustein_bottom\":\"4\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("120","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Kreisbewegung\",\"fID\":\"52\",\"Baustein_1\":\"3\",\"tem_simID_1\":\"16\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("121","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test Folie\",\"fID\":\"0\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"24\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("122","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test Folie\",\"fID\":\"0\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"24\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("123","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test 2\",\"fID\":\"0\",\"Baustein_1\":\"1\",\"inhalt_1\":\"&lt;p&gt;sdfsd sdf assdf sadfsd ter g sdfa stehfdgsdaf wretwsdf geawesfdvx&lt;/p&gt;\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("124","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test Pr&auml;sfolie im Einzelmodus\",\"fID\":\"0\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Testaufgabe&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"24\",\"Baustein_2\":\"4\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("125","1","25","2","1","0","1","{\"vID\":41,\"titel\":\"Testtitel 15:11\",\"beschreibung\":\"\",\"CopyToKursID\":0,\"aktivStatus\":1,\"tnarr\":[]}","0");
INSERT INTO folien VALUES("126","1","25","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Wordcloud &amp; Abstimmung\",\"fID\":\"59\",\"Baustein_1\":\"5\",\"bID_1\":\"1\",\"Baustein_2\":\"5\",\"bID_2\":\"8\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("127","1","25","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Konzentration FCB-HSV\",\"fID\":\"60\",\"Baustein_1\":\"3\",\"tem_simID_1\":\"9\",\"Baustein_2\":\"5\",\"bID_2\":\"10\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("128","1","25","1","1","0","1","{\"vID\":24,\"titel\":\"Videovertonung Test1\",\"beschreibung\":\"&lt;p&gt;Sie sollen nachfolgenden Stummfilm eines Experiments vertonen. Legen Sie dabei besonders Wert auf folgende Punkte:&lt;\\/p&gt;&lt;ul&gt;&lt;li&gt;Beschreiben Sie Aufbau und ben&amp;ouml;tigte Ger&amp;auml;te.&lt;\\/li&gt;&lt;li&gt;Formulieren Sie die durch das Experiment zu &amp;uuml;berpr&amp;uuml;fenden Hypothesen.&lt;\\/li&gt;&lt;li&gt;Erl&amp;auml;utern Sie alle Schritte w&amp;auml;hrend des Experimentiervorgangs OHNE dabei Erklu&amp;auml;rungen zu liefern.&lt;\\/li&gt;&lt;li&gt;Lenken Sie durch gezielte Impulse die Aufmerksamkeit der Sch&amp;uuml;lerinnen und Sch&amp;uuml;ler auf den gerade aktuellen Gegenstand.&lt;\\/li&gt;&lt;li&gt;Sichern Sie die Beobachtungen nach kurzer Bedenkzeit.&lt;\\/li&gt;&lt;\\/ul&gt;&lt;p&gt;Ziel soll es sein, dass Sch&amp;uuml;lerinnen und Sch&amp;uuml;ler, die dieses Experiment mit Ihrer Vertonung ansehen, im Anschluss auf Fragen wie:&lt;\\/p&gt;&lt;ul&gt;&lt;li&gt;Beschreibe deine Beobachtungen.&lt;\\/li&gt;&lt;li&gt;Beschreibe das Vorgehen beim Experimentieren.&lt;\\/li&gt;&lt;li&gt;...&lt;\\/li&gt;&lt;\\/ul&gt;&lt;p&gt;antworten k&amp;ouml;nnen.&lt;\\/p&gt;&lt;p&gt;&lt;span style=&quot;color: #ff0000;&quot;&gt;&lt;strong&gt;Eine Erkl&amp;auml;rung des Ph&amp;auml;nomens oder eines Zusammenhangs ist NICHT Teil der Aufgabe! Es geht ausschlie&amp;szlig;flich um die Lenkung der Aufmerksamkeit der Sch&amp;uuml;lerinnen und Sch&amp;uuml;ler auf den jeweils aktuell wichtigen Experimentteil!&lt;\\/strong&gt;&lt;\\/span&gt;&lt;\\/p&gt;\",\"CopyToKursID\":25}","0");
INSERT INTO folien VALUES("129","1","25","2","1","0","2","{\"ytID\":\"lQDao4Kjd9E\",\"ytlink\":\"https://www.youtube.com/watch?v=lQDao4Kjd9E\",\"vID\":24,\"titel\":\"Testtitel\",\"beschreibung\":\"Testbeschreibung\",\"CopyToKursID\":25,\"aktivStatus\":1,\"tnarr\":[]}","0");
INSERT INTO folien VALUES("130","1","25","1","1","0","2","{\"vID\":51,\"titel\":\"Konvektion\",\"beschreibung\":\"&lt;p&gt;Vertonen Sie&lt;\\/p&gt;\",\"CopyToKursID\":0,\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("131","1","25","4","2","72","1","{\"titel\":\"TEST 123456 Besprechung 123456\",\"beschreibung\":\"Geben Sie Ihrem Kommilitonen eine konkrete R&uuml;ckmeldung zu seiner Experimentvertonung.\",\"fGroupsArr\":[1],\"fArr\":[16]}","0");
INSERT INTO folien VALUES("132","1","25","5","3","73","1","{\"titel\":\"Feedback 1\",\"beschreibung\":\"Hier finden Sie das Feedback zu Ihrer Vertonung\"}","0");
INSERT INTO folien VALUES("133","1","25","4","2","72","1","{\"titel\":\"Testkorr\",\"beschreibung\":\"Test\",\"fGroupsArr\":[2],\"fArr\":[16]}","0");
INSERT INTO folien VALUES("134","1","25","5","3","75","1","{\"titel\":\"Testfeedback 2\",\"beschreibung\":\"FB\"}","0");
INSERT INTO folien VALUES("135","1","25","4","2","62","1","{\"titel\":\"Bewertung Konvektion TEST 12345467\",\"beschreibung\":\"Bewerten Sie die Vertonung\",\"fGroupsArr\":[1],\"fArr\":[]}","0");
INSERT INTO folien VALUES("136","1","25","5","3","62","1","{\"titel\":\"Feedback der Vertonung\",\"beschreibung\":\"Feedback\"}","0");
INSERT INTO folien VALUES("137","1","25","5","3","78","1","{\"titel\":\"TB Feedback\",\"beschreibung\":\"TBBem\"}","0");
INSERT INTO folien VALUES("138","1","25","1","1","0","2","{\"vID\":35,\"titel\":\"Testvertonung\",\"beschreibung\":\"\",\"CopyToKursID\":0,\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("139","1","25","4","2","81","1","{\"titel\":\"Testbewertung\",\"beschreibung\":\"Bewerteb Sie\",\"fGroupsArr\":[1],\"fArr\":[16,17]}","0");
INSERT INTO folien VALUES("140","1","25","5","3","82","1","{\"titel\":\"Testfeedback\",\"beschreibung\":\"\"}","0");
INSERT INTO folien VALUES("141","1","25","1","1","0","2","{\"vID\":49,\"titel\":\"Absorption\",\"beschreibung\":\"&lt;p&gt;Test&lt;\\/p&gt;\",\"CopyToKursID\":0,\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("142","1","25","3","1","0","2","{\"vID\":0,\"titel\":\"Testvideoanalyse 1\",\"beschreibung\":\"&lt;p&gt;Test VA1&lt;\\/p&gt;\",\"CopyToKursID\":0,\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("143","1","25","3","1","0","1","{\"eig_vID\":14,\"titel\":\"Testvideoanalyse 2\",\"beschreibung\":\"&lt;p&gt;TVa2&lt;\\/p&gt;\",\"CopyToKursID\":0,\"fGroupsArr\":[2,3],\"fArr\":[]}","0");
INSERT INTO folien VALUES("144","1","25","8","3","86","1","{\"titel\":\"Feedback VA2\",\"beschreibung\":\"Feedback Beschreibung VA2\"}","0");
INSERT INTO folien VALUES("145","1","25","6","1","0","0","{\"DesignTyp\":2,\"titel\":\"DPG\",\"webUrl\":\"http://dpg-physik.de/index.html\",\"smBut\":\"1\",\"tnarr\":[]}","0");
INSERT INTO folien VALUES("146","1","25","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test 28.03.2017\",\"fID\":\"89\",\"Baustein_1\":\"5\",\"bID_1\":\"17\",\"Baustein_2\":\"3\",\"tem_simID_2\":\"6\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("147","1","25","1","1","0","2","{\"vID\":31,\"titel\":\"Test (NEUE FOLIE)\",\"beschreibung\":\"\",\"CopyToKursID\":0,\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("148","1","25","1","1","0","2","{\"vID\":52,\"titel\":\"Test 2 (NEUE FOLIE)\",\"beschreibung\":\"\",\"CopyToKursID\":0,\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("149","1","25","4","2","90","1","{\"titel\":\"Test - NF 1\",\"beschreibung\":\"\",\"fGroupsArr\":[1,3],\"fArr\":[]}","0");
INSERT INTO folien VALUES("150","1","25","5","3","92","1","{\"titel\":\"Test - FB NF 1\",\"beschreibung\":\"\"}","0");
INSERT INTO folien VALUES("151","1","25","4","2","91","1","{\"titel\":\"Test Bew Neue Folie\",\"beschreibung\":\"\",\"fGroupsArr\":[2,3],\"fArr\":[17]}","0");
INSERT INTO folien VALUES("156","1","23","6","1","0","1","{\"DesignTyp\":1,\"titel\":\"Begr&uuml;&szlig;ung\",\"fID\":\"38\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;mit dieser Pr&amp;auml;sentation k&amp;ouml;nnen Sie sich einen &amp;Uuml;berblick &amp;uuml;ber die&amp;nbsp;M&amp;ouml;glichkeiten die Ihnen dieses&amp;nbsp;Programm liefert, verschaffen.&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&lt;img style=&quot;display: block; margin-left: auto; margin-right: auto; max-width: 400px;&quot; src=&quot;uploads/1/58a8b3b12fb23.png&quot; width=&quot;100%&quot; /&gt;&lt;/p&gt;\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("157","1","23","6","1","0","1","{\"DesignTyp\":1,\"titel\":\"Experimentvideos\",\"fID\":\"39\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Sie k&amp;ouml;nnen Ihren Sch&amp;uuml;lern / Studenten Videos von Experimenten zeigen um auf wichtige Aspekte des Experimentierens hinzuweisen.&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"31\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("158","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Multimodale Darstellung\",\"fID\":\"0\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Sie k&amp;ouml;nnen verschiedene Darstellunsformen - z.B. Video und Simulation - gegen&amp;uuml;berstellen um so eine gr&amp;ouml;&amp;szlig;ere Verarbeitungstiefe des Lerninhalts zu erreichen.&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"35\",\"Baustein_2\":\"3\",\"tem_simID_2\":\"10\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("159","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Kontrollfragen\",\"fID\":\"41\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Den Sch&amp;uuml;lern / Studenten k&amp;ouml;nnen Kontrollfragen angezeigt werden um den Leistungsstand zu kontrollieren.&lt;/p&gt;\",\"Baustein_1\":\"3\",\"tem_simID_1\":\"8\",\"Baustein_2\":\"5\",\"bID_2\":\"7\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("160","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Begriffssammlung\",\"fID\":\"42\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Aufgabe:&amp;nbsp;&lt;/p&gt;&lt;p&gt;Schaue dir zun&amp;auml;chst das Video an und gebe&amp;nbsp;dann im nebenstehendem Eingabefeld Begriffe ein, die dir zu diesem Themengebiet einfallen.&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"45\",\"Baustein_2\":\"5\",\"bID_2\":\"1\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("161","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Umfrage\",\"fID\":\"43\",\"Baustein_1\":\"5\",\"bID_1\":\"8\",\"Baustein_2\":\"1\",\"inhalt_2\":\"&lt;p style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&amp;nbsp;&lt;img src=&quot;uploads/1/58a8b2330c6dc.png&quot; width=&quot;248&quot; height=&quot;398&quot; /&gt;&lt;/p&gt;\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("162","1","23","1","1","0","1","{\"vID\":37,\"titel\":\"Vertonung - M&uuml;nze in der Tasse\",\"beschreibung\":\"&lt;p&gt;Vertonen Sie nachfolgendes Experiment.&lt;\\/p&gt;\"}","0");
INSERT INTO folien VALUES("163","1","23","1","2","44","1","{\"titel\":\"Korrektur der Videovertonung\",\"beschreibung\":\"Korrigieren Sie die Videovertonung\",\"fGroupsArr\":[1],\"fArr\":[16,17]}","0");
INSERT INTO folien VALUES("164","1","23","5","3","44","1","{\"titel\":\"Feedback zur Vertonung\",\"beschreibung\":\"Nachfolgend finden Sie das Feedback zur Videovertonung\"}","0");
INSERT INTO folien VALUES("165","1","23","6","1","0","1","{\"DesignTyp\":1,\"titel\":\"Dipolstrahlung\",\"fID\":\"47\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Beschreiben Sie, die Energiestr&amp;ouml;mungsrichtung in Abh&amp;auml;ngigkeit von der Zeit.&lt;/p&gt;\",\"Baustein_1\":\"3\",\"tem_simID_1\":\"13\",\"Baustein_bottom\":\"4\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("166","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Kreisbewegung\",\"fID\":\"52\",\"Baustein_1\":\"3\",\"tem_simID_1\":\"16\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("167","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test Folie\",\"fID\":\"0\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"24\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("168","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test Folie\",\"fID\":\"0\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"24\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("169","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test 2\",\"fID\":\"0\",\"Baustein_1\":\"1\",\"inhalt_1\":\"&lt;p&gt;sdfsd sdf assdf sadfsd ter g sdfa stehfdgsdaf wretwsdf geawesfdvx&lt;/p&gt;\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("170","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test Pr&auml;sfolie im Einzelmodus\",\"fID\":\"0\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Testaufgabe&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"24\",\"Baustein_2\":\"4\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("171","1","23","6","1","0","1","{\"DesignTyp\":1,\"titel\":\"Begr&uuml;&szlig;ung\",\"fID\":\"38\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;mit dieser Pr&amp;auml;sentation k&amp;ouml;nnen Sie sich einen &amp;Uuml;berblick &amp;uuml;ber die&amp;nbsp;M&amp;ouml;glichkeiten die Ihnen dieses&amp;nbsp;Programm liefert, verschaffen.&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&lt;img style=&quot;display: block; margin-left: auto; margin-right: auto; max-width: 400px;&quot; src=&quot;uploads/1/58a8b3b12fb23.png&quot; width=&quot;100%&quot; /&gt;&lt;/p&gt;\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("172","1","23","6","1","0","1","{\"DesignTyp\":1,\"titel\":\"Experimentvideos\",\"fID\":\"39\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Sie k&amp;ouml;nnen Ihren Sch&amp;uuml;lern / Studenten Videos von Experimenten zeigen um auf wichtige Aspekte des Experimentierens hinzuweisen.&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"31\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("173","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Multimodale Darstellung\",\"fID\":\"0\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Sie k&amp;ouml;nnen verschiedene Darstellunsformen - z.B. Video und Simulation - gegen&amp;uuml;berstellen um so eine gr&amp;ouml;&amp;szlig;ere Verarbeitungstiefe des Lerninhalts zu erreichen.&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"35\",\"Baustein_2\":\"3\",\"tem_simID_2\":\"10\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("174","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Kontrollfragen\",\"fID\":\"41\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Den Sch&amp;uuml;lern / Studenten k&amp;ouml;nnen Kontrollfragen angezeigt werden um den Leistungsstand zu kontrollieren.&lt;/p&gt;\",\"Baustein_1\":\"3\",\"tem_simID_1\":\"8\",\"Baustein_2\":\"5\",\"bID_2\":\"7\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("175","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Begriffssammlung\",\"fID\":\"42\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Aufgabe:&amp;nbsp;&lt;/p&gt;&lt;p&gt;Schaue dir zun&amp;auml;chst das Video an und gebe&amp;nbsp;dann im nebenstehendem Eingabefeld Begriffe ein, die dir zu diesem Themengebiet einfallen.&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"45\",\"Baustein_2\":\"5\",\"bID_2\":\"1\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("176","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Umfrage\",\"fID\":\"43\",\"Baustein_1\":\"5\",\"bID_1\":\"8\",\"Baustein_2\":\"1\",\"inhalt_2\":\"&lt;p style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&amp;nbsp;&lt;img src=&quot;uploads/1/58a8b2330c6dc.png&quot; width=&quot;248&quot; height=&quot;398&quot; /&gt;&lt;/p&gt;\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("177","1","23","1","1","0","1","{\"vID\":37,\"titel\":\"Vertonung - M&uuml;nze in der Tasse\",\"beschreibung\":\"&lt;p&gt;Vertonen Sie nachfolgendes Experiment.&lt;\\/p&gt;\"}","0");
INSERT INTO folien VALUES("178","1","23","1","2","44","1","{\"titel\":\"Korrektur der Videovertonung\",\"beschreibung\":\"Korrigieren Sie die Videovertonung\",\"fGroupsArr\":[1],\"fArr\":[16,17]}","0");
INSERT INTO folien VALUES("179","1","23","5","3","44","1","{\"titel\":\"Feedback zur Vertonung\",\"beschreibung\":\"Nachfolgend finden Sie das Feedback zur Videovertonung\"}","0");
INSERT INTO folien VALUES("180","1","23","6","1","0","1","{\"DesignTyp\":1,\"titel\":\"Dipolstrahlung\",\"fID\":\"47\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Beschreiben Sie, die Energiestr&amp;ouml;mungsrichtung in Abh&amp;auml;ngigkeit von der Zeit.&lt;/p&gt;\",\"Baustein_1\":\"3\",\"tem_simID_1\":\"13\",\"Baustein_bottom\":\"4\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("181","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Kreisbewegung\",\"fID\":\"52\",\"Baustein_1\":\"3\",\"tem_simID_1\":\"16\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("182","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test Folie\",\"fID\":\"0\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"24\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("183","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test Folie\",\"fID\":\"0\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"24\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("184","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test 2\",\"fID\":\"0\",\"Baustein_1\":\"1\",\"inhalt_1\":\"&lt;p&gt;sdfsd sdf assdf sadfsd ter g sdfa stehfdgsdaf wretwsdf geawesfdvx&lt;/p&gt;\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("185","1","23","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test Pr&auml;sfolie im Einzelmodus\",\"fID\":\"0\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Testaufgabe&lt;/p&gt;\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"24\",\"Baustein_2\":\"4\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("1261","1","28","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test_bsMatch_1\",\"fID\":\"1261\",\"Baustein_1\":\"5\",\"bID_1\":\"5\",\"Baustein_2\":\"5\",\"bID_2\":\"10\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("1262","1","25","1","1","0","2","{\"vID\":24,\"titel\":\"Test\",\"beschreibung\":\"\",\"CopyToKursID\":0,\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("1263","1","25","1","1","0","2","{\"vID\":24,\"titel\":\"Test\",\"beschreibung\":\"\",\"CopyToKursID\":0,\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("1264","1","25","1","1","0","2","{\"vID\":24,\"titel\":\"Test\",\"beschreibung\":\"\",\"CopyToKursID\":0,\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("1265","1","25","1","1","0","2","{\"vID\":24,\"titel\":\"Test\",\"beschreibung\":\"\",\"CopyToKursID\":0,\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("1266","1","25","1","1","0","2","{\"vID\":51,\"titel\":\"Videovertonung 13.06.2017\",\"beschreibung\":\"\",\"CopyToKursID\":0,\"tnarr\":[35]}","0");
INSERT INTO folien VALUES("1267","1","111","6","1","0","1","{\"DesignTyp\":2,\"savePraes\":\"1\",\"titel\":\"Evaluation\",\"fID\":\"1267\",\"Baustein_1\":\"5\",\"bID_1\":\"20\",\"FrageVal_1\":\"\",\"Baustein_2\":\"1\",\"inhalt_2\":\"&lt;p&gt;&lt;img src=&quot;../../media/uploads/1_594e772a13fed.jpg&quot; /&gt;&lt;math xmlns=&quot;http://www.w3.org/1998/Math/MathML&quot;&gt;&lt;msup&gt;&lt;mi&gt;x&lt;/mi&gt;&lt;mn&gt;2&lt;/mn&gt;&lt;/msup&gt;&lt;/math&gt;&lt;/p&gt;\",\"Baustein_bottom\":\"5\",\"bID_bottom\":\"19\",\"FrageVal_bottom\":\"\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("1268","1","111","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test 2 (nicht nach Bearbeitung)\",\"fID\":\"1268\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"51\",\"Baustein_2\":\"1\",\"inhalt_2\":\"\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\",\"savePraes\":\"2\"}","0");
INSERT INTO folien VALUES("1269","1","111","6","1","0","1","{\"DesignTyp\":2,\"savePraes\":\"2\",\"titel\":\"Folie 3\",\"fID\":\"1269\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"51\",\"Baustein_2\":\"1\",\"inhalt_2\":\"&lt;p&gt;&lt;img src=&quot;../../media/uploads/1_594e772a13fed.jpg&quot; /&gt;&lt;math xmlns=&quot;http://www.w3.org/1998/Math/MathML&quot;&gt;&lt;msup&gt;&lt;mi&gt;x&lt;/mi&gt;&lt;mn&gt;2&lt;/mn&gt;&lt;/msup&gt;&lt;/math&gt;&lt;/p&gt;\",\"viewTyp\":\"1\"}","0");
INSERT INTO folien VALUES("1270","1","113","1","1","0","2","{\"vID\":24,\"titel\":\"Test\",\"beschreibung\":\"\",\"CopyToKursID\":0,\"tnarr\":[239]}","0");
INSERT INTO folien VALUES("1271","1","113","1","1","0","2","{\"vID\":51,\"titel\":\"Folie 2\",\"beschreibung\":\"\",\"CopyToKursID\":0,\"tnarr\":[240]}","0");
INSERT INTO folien VALUES("1272","1","113","1","1","0","2","{\"vID\":53,\"titel\":\"Folie 3\",\"beschreibung\":\"\",\"CopyToKursID\":0,\"tnarr\":[241]}","0");
INSERT INTO folien VALUES("1273","1","111","6","1","0","1","{\"DesignTyp\":2,\"savePraes\":\"3\",\"titel\":\"Folie 4\",\"fID\":\"1273\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"51\",\"Baustein_2\":\"1\",\"inhalt_2\":\"&lt;p&gt;&lt;math xmlns=&quot;http://www.w3.org/1998/Math/MathML&quot;&gt;&lt;msup&gt;&lt;mi&gt;x&lt;/mi&gt;&lt;mn&gt;2&lt;/mn&gt;&lt;/msup&gt;&lt;mo&gt;+&lt;/mo&gt;&lt;mfrac&gt;&lt;mi&gt;x&lt;/mi&gt;&lt;mn&gt;3&lt;/mn&gt;&lt;/mfrac&gt;&lt;/math&gt;&lt;/p&gt;&lt;p&gt;\\\\(x^2\\\\)&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("1274","5","115","6","1","0","1","{\"DesignTyp\":2,\"savePraes\":\"0\",\"titel\":\"Test 1\",\"fID\":\"1274\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;Futizzivutccgjvhkh ghivkhfitkh iffizhkhkvvo&lt;/p&gt;\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("1275","5","115","6","1","0","1","{\"DesignTyp\":2,\"titel\":\"Test 2\",\"fID\":\"1275\",\"Baustein_top\":\"1\",\"inhalt_top\":\"&lt;p&gt;&lt;math xmlns=&quot;http://www.w3.org/1998/Math/MathML&quot;&gt;&lt;msup&gt;&lt;mi&gt;x&lt;/mi&gt;&lt;mn&gt;2&lt;/mn&gt;&lt;/msup&gt;&lt;/math&gt;&lt;/p&gt;\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\",\"savePraes\":\"1\"}","0");
INSERT INTO folien VALUES("1276","5","115","6","1","0","1","{\"DesignTyp\":2,\"savePraes\":\"2\",\"titel\":\"Test 3\",\"fID\":\"1276\",\"Baustein_top\":\"1\",\"inhalt_top\":\"\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("1277","37","116","6","1","0","1","{\"DesignTyp\":1,\"savePraes\":\"3\",\"titel\":\"Kurs 1 - Folie 1\",\"fID\":\"1277\",\"Baustein_top\":\"3\",\"tem_simID_top\":\"16\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("1278","37","116","6","1","0","1","{\"DesignTyp\":2,\"savePraes\":\"2\",\"titel\":\"Kurs 1 - Folie 2\",\"fID\":\"1278\",\"Baustein_1\":\"2\",\"tem_vID_1\":\"51\",\"Baustein_2\":\"4\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("1279","1","111","6","1","0","1","{\"DesignTyp\":2,\"savePraes\":\"1\",\"titel\":\"Folie 3\",\"fID\":\"1279\",\"Baustein_1\":\"1\",\"inhalt_1\":\"&lt;p&gt;&lt;math xmlns=&quot;http://www.w3.org/1998/Math/MathML&quot;&gt;&lt;mfrac&gt;&lt;mn&gt;3&lt;/mn&gt;&lt;mn&gt;4&lt;/mn&gt;&lt;/mfrac&gt;&lt;/math&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;../../media/uploads/1_5950fce0733b7.png&quot; width=&quot;142&quot; height=&quot;142&quot; /&gt;&lt;/p&gt;\",\"viewTyp\":\"1\",\"CopyToKursID\":\"\"}","0");
INSERT INTO folien VALUES("1280","1","111","6","1","0","1","{\"DesignTyp\":1,\"savePraes\":\"2\",\"titel\":\"Test\",\"fID\":\"1280\",\"viewTyp\":\"1\"}","0");



DROP TABLE fragen;

CREATE TABLE `fragen` (
  `FrageID` int(11) NOT NULL AUTO_INCREMENT,
  `SkalaTyp` int(11) NOT NULL DEFAULT '1' COMMENT '1: kontinuierlich; 2:Lickert; 3: input Feld',
  `uID` int(11) NOT NULL,
  `parameter` text NOT NULL,
  PRIMARY KEY (`FrageID`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;

INSERT INTO fragen VALUES("18","1","1","{\"titel\":\"Testtitel3\",\"FrageTXT\":\"TestTXT3\",\"FrageTipp\":\"Test Hinweis\",\"FrageLabMax\":\"Max\",\"FrageMax\":\"14\",\"FrageLabMin\":\"Min\",\"FrageMin\":\"2\"}");
INSERT INTO fragen VALUES("19","1","1","{\"titel\":\"Testtitel4\",\"FrageTXT\":\"TestTXT4\",\"FrageTipp\":\"Test Hinweis\",\"FrageLabMax\":\"Max\",\"FrageMax\":\"50\",\"FrageLabMin\":\"Min\",\"FrageMin\":\"2\"}");
INSERT INTO fragen VALUES("21","1","1","{\"titel\":\"Testtitel6\",\"FrageTXT\":\"TestTXT6\",\"FrageTipp\":\"Test Hinweis\",\"FrageLabMax\":\"Max\",\"FrageMax\":\"14\",\"FrageLabMin\":\"Min\",\"FrageMin\":\"2\",\"initVal\":\"on\"}");
INSERT INTO fragen VALUES("22","1","1","{\"titel\":\"Testtitel7\",\"FrageTXT\":\"TestTXT7\",\"FrageTipp\":\"Test Hinweis\",\"FrageLabMax\":\"Max\",\"FrageMax\":\"14\",\"FrageLabMin\":\"Min\",\"FrageMin\":\"2\"}");
INSERT INTO fragen VALUES("23","1","1","{\"titel\":\"Testtitel8\",\"FrageTXT\":\"TestTXT8\",\"FrageTipp\":\"Test Hinweis\",\"FrageLabMax\":\"Max\",\"FrageMax\":\"14\",\"FrageLabMin\":\"Min\",\"FrageMin\":\"2\"}");
INSERT INTO fragen VALUES("24","1","1","{\"titel\":\"Testtitel9\",\"FrageTXT\":\"TestTXT9\",\"FrageTipp\":\"Test Hinweis\",\"FrageLabMax\":\"Max\",\"FrageMax\":\"14\",\"FrageLabMin\":\"Min\",\"FrageMin\":\"2\"}");
INSERT INTO fragen VALUES("25","1","1","{\"titel\":\"Testtitel10\",\"FrageTXT\":\"TestTXT10\",\"FrageTipp\":\"Test Hinweis\",\"FrageLabMax\":\"Max\",\"FrageMax\":\"14\",\"FrageLabMin\":\"Min\",\"FrageMin\":\"2\"}");
INSERT INTO fragen VALUES("27","1","1","{\"titel\":\"Testtitel12\",\"FrageTXT\":\"TestTXT12\",\"FrageTipp\":\"Test Hinweis\",\"FrageLabMax\":\"Max\",\"FrageMax\":\"14\",\"FrageLabMin\":\"Min\",\"FrageMin\":\"2\"}");
INSERT INTO fragen VALUES("90","1","1","{\"action\":\"range\",\"SkalaTyp\":\"1\",\"titel\":\"Frage Import 1a\",\"FrageTXT\":\"Das ist Frage 1\",\"FrageTipp\":\"Das ist der Hinweis 1\",\"FrageLabMax\":\"voll und&lt;br&gt;ganz\",\"FrageMax\":\"7\",\"FrageLabMin\":\"&uuml;berhaupt&lt;br&gt;nicht\",\"FrageMin\":\"1\",\"initVal\":\"off\",\"initToolTip\":\"off\",\"noAnswer\":\"off\",\"hideTrack\":\"on\",\"hideSelection\":\"on\"}");
INSERT INTO fragen VALUES("91","1","1","{\"action\":\"range\",\"SkalaTyp\":\"1\",\"titel\":\"Frage Import 2\",\"FrageTXT\":\"Das ist Frage 2\",\"FrageTipp\":\"Das ist der Hinweis 2\",\"FrageLabMax\":\"voll und&lt;br&gt;ganz\",\"FrageMax\":\"6\",\"FrageLabMin\":\"&uuml;berhaupt&lt;br&gt;nicht\",\"FrageMin\":\"1\",\"initVal\":\"off\",\"initToolTip\":\"off\",\"noAnswer\":\"on\",\"hideTrack\":\"on\",\"hideSelection\":\"off\"}");
INSERT INTO fragen VALUES("92","1","1","{\"action\":\"range\",\"SkalaTyp\":\"1\",\"titel\":\"Frage Import 3\",\"FrageTXT\":\"Das ist Frage 3\",\"FrageTipp\":\"Das ist der Hinweis 3\",\"FrageLabMax\":\"voll und&lt;br&gt;ganz\",\"FrageMax\":\"5\",\"FrageLabMin\":\"&uuml;berhaupt&lt;br&gt;nicht\",\"FrageMin\":\"1\",\"initVal\":\"off\",\"initToolTip\":\"off\",\"noAnswer\":\"on\",\"hideTrack\":\"on\",\"hideSelection\":\"off\"}");
INSERT INTO fragen VALUES("93","1","1","{\"SkalaTyp\":\"1\",\"FrageTXT\":\"Das ist Frage 4\",\"FrageTipp\":\"Das ist der Hinweis 4\",\"FrageLabMax\":\"voll und&lt;br&gt;ganz\",\"FrageMax\":\"10\",\"FrageLabMin\":\"&uuml;berhaupt&lt;br&gt;nicht\",\"FrageMin\":\"1\",\"initVal\":\"off\",\"initToolTip\":\"off\",\"noAnswer\":\"on\",\"ufeffSkalaTyp\":\"1\",\"titel\":\"Frage Import 4\"}");
INSERT INTO fragen VALUES("94","1","1","{\"SkalaTyp\":\"1\",\"FrageTXT\":\"Das ist Frage 5\",\"FrageTipp\":\"Das ist der Hinweis 5\",\"FrageLabMax\":\"voll und&lt;br&gt;ganz\",\"FrageMax\":\"100\",\"FrageLabMin\":\"&uuml;berhaupt&lt;br&gt;nicht\",\"FrageMin\":\"1\",\"initVal\":\"off\",\"initToolTip\":\"off\",\"noAnswer\":\"on\",\"ufeffSkalaTyp\":\"1\",\"titel\":\"Frage Import 5\"}");
INSERT INTO fragen VALUES("95","1","1","{\"SkalaTyp\":\"1\",\"FrageTXT\":\"Das ist Frage 6\",\"FrageTipp\":\"Das ist der Hinweis 6\",\"FrageLabMax\":\"voll und&lt;br&gt;ganz\",\"FrageMax\":\"7\",\"FrageLabMin\":\"&uuml;berhaupt&lt;br&gt;nicht\",\"FrageMin\":\"1\",\"initVal\":\"off\",\"initToolTip\":\"off\",\"noAnswer\":\"on\",\"ufeffSkalaTyp\":\"1\",\"titel\":\"Frage Import 6\"}");
INSERT INTO fragen VALUES("96","1","1","{\"SkalaTyp\":\"1\",\"FrageTXT\":\"Das ist Frage 7\",\"FrageTipp\":\"Das ist der Hinweis 7\",\"FrageLabMax\":\"voll und&lt;br&gt;ganz\",\"FrageMax\":\"7\",\"FrageLabMin\":\"&uuml;berhaupt&lt;br&gt;nicht\",\"FrageMin\":\"1\",\"initVal\":\"off\",\"initToolTip\":\"off\",\"noAnswer\":\"on\",\"ufeffSkalaTyp\":\"1\",\"titel\":\"Frage Import 7\"}");
INSERT INTO fragen VALUES("97","1","1","{\"SkalaTyp\":\"1\",\"FrageTXT\":\"Das ist Frage 8\",\"FrageTipp\":\"Das ist der Hinweis 8\",\"FrageLabMax\":\"voll und&lt;br&gt;ganz\",\"FrageMax\":\"7\",\"FrageLabMin\":\"&uuml;berhaupt&lt;br&gt;nicht\",\"FrageMin\":\"1\",\"initVal\":\"off\",\"initToolTip\":\"off\",\"noAnswer\":\"on\",\"ufeffSkalaTyp\":\"1\",\"titel\":\"Frage Import 8\"}");
INSERT INTO fragen VALUES("98","1","1","{\"SkalaTyp\":\"1\",\"FrageTXT\":\"Das ist Frage 9\",\"FrageTipp\":\"Das ist der Hinweis 9\",\"FrageLabMax\":\"voll und&lt;br&gt;ganz\",\"FrageMax\":\"7\",\"FrageLabMin\":\"&uuml;berhaupt&lt;br&gt;nicht\",\"FrageMin\":\"1\",\"initVal\":\"off\",\"initToolTip\":\"off\",\"noAnswer\":\"on\",\"ufeffSkalaTyp\":\"1\",\"titel\":\"Frage Import 9\"}");
INSERT INTO fragen VALUES("99","1","1","{\"SkalaTyp\":\"1\",\"FrageTXT\":\"Das ist Frage 10\",\"FrageTipp\":\"Das ist der Hinweis 10\",\"FrageLabMax\":\"voll und&lt;br&gt;ganz\",\"FrageMax\":\"7\",\"FrageLabMin\":\"&uuml;berhaupt&lt;br&gt;nicht\",\"FrageMin\":\"1\",\"initVal\":\"off\",\"initToolTip\":\"off\",\"noAnswer\":\"on\",\"ufeffSkalaTyp\":\"1\",\"titel\":\"Frage Import 10\"}");
INSERT INTO fragen VALUES("100","1","1","{\"SkalaTyp\":\"1\",\"FrageTXT\":\"Das ist Frage 11\",\"FrageTipp\":\"Das ist der Hinweis 11\",\"FrageLabMax\":\"voll und&lt;br&gt;ganz\",\"FrageMax\":\"7\",\"FrageLabMin\":\"&uuml;berhaupt&lt;br&gt;nicht\",\"FrageMin\":\"1\",\"initVal\":\"off\",\"initToolTip\":\"off\",\"noAnswer\":\"on\",\"ufeffSkalaTyp\":\"1\",\"titel\":\"Frage Import 11\"}");
INSERT INTO fragen VALUES("101","1","1","{\"SkalaTyp\":\"1\",\"FrageTXT\":\"Das ist Frage 12\",\"FrageTipp\":\"Das ist der Hinweis 12\",\"FrageLabMax\":\"voll und&lt;br&gt;ganz\",\"FrageMax\":\"7\",\"FrageLabMin\":\"&uuml;berhaupt&lt;br&gt;nicht\",\"FrageMin\":\"1\",\"initVal\":\"off\",\"initToolTip\":\"off\",\"noAnswer\":\"on\",\"ufeffSkalaTyp\":\"1\",\"titel\":\"Frage Import 12\"}");
INSERT INTO fragen VALUES("102","1","1","{\"action\":\"range\",\"SkalaTyp\":\"1\",\"titel\":\"Frage Import 2\",\"FrageTXT\":\"Das ist Frage 2\",\"FrageTipp\":\"Das ist der Hinweis 2\",\"FrageLabMax\":\"voll und&lt;br&gt;ganz\",\"FrageMax\":\"6\",\"FrageLabMin\":\"&uuml;berhaupt&lt;br&gt;nicht\",\"FrageMin\":\"1\",\"initVal\":\"off\",\"initToolTip\":\"off\",\"noAnswer\":\"on\",\"showTrack\":\"on\"}");
INSERT INTO fragen VALUES("103","1","1","{\"action\":\"range\",\"SkalaTyp\":\"1\",\"titel\":\"Frage Import 2\",\"FrageTXT\":\"Das ist Frage 2\",\"FrageTipp\":\"Das ist der Hinweis 2\",\"FrageLabMax\":\"voll und&lt;br&gt;ganz\",\"FrageMax\":\"6\",\"FrageLabMin\":\"&uuml;berhaupt&lt;br&gt;nicht\",\"FrageMin\":\"1\",\"initVal\":\"off\",\"initToolTip\":\"off\",\"noAnswer\":\"on\",\"showTrack\":\"on\"}");
INSERT INTO fragen VALUES("104","1","1","{\"action\":\"range\",\"SkalaTyp\":\"1\",\"titel\":\"Frage Import 2\",\"FrageTXT\":\"Das ist Frage 2\",\"FrageTipp\":\"Das ist der Hinweis 2\",\"FrageLabMax\":\"voll und&lt;br&gt;ganz\",\"FrageMax\":\"6\",\"FrageLabMin\":\"&uuml;berhaupt&lt;br&gt;nicht\",\"FrageMin\":\"1\",\"initVal\":\"off\",\"initToolTip\":\"off\",\"noAnswer\":\"on\",\"showTrack\":\"on\"}");
INSERT INTO fragen VALUES("105","1","1","{\"action\":\"range\",\"SkalaTyp\":\"1\",\"titel\":\"Frage Import 2\",\"FrageTXT\":\"Das ist Frage 2\",\"FrageTipp\":\"Das ist der Hinweis 2\",\"FrageLabMax\":\"voll und&lt;br&gt;ganz\",\"FrageMax\":\"6\",\"FrageLabMin\":\"&uuml;berhaupt&lt;br&gt;nicht\",\"FrageMin\":\"1\",\"initVal\":\"off\",\"initToolTip\":\"off\",\"noAnswer\":\"on\",\"showTrack\":\"on\"}");



DROP TABLE fragen_groups;

CREATE TABLE `fragen_groups` (
  `FGroupID` int(11) NOT NULL AUTO_INCREMENT,
  `uID` int(11) NOT NULL,
  `parameter` text NOT NULL,
  PRIMARY KEY (`FGroupID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

INSERT INTO fragen_groups VALUES("1","1","{\"GroupTitel\":\"Testgruppe1\"}");
INSERT INTO fragen_groups VALUES("2","1","{\"GroupTitel\":\"Testgruppe2\"}");
INSERT INTO fragen_groups VALUES("3","1","{\"GroupTitel\":\"Testgruppe3\"}");
INSERT INTO fragen_groups VALUES("4","1","{\"GroupTitel\":\"Testgruppe4\"}");
INSERT INTO fragen_groups VALUES("5","0","{\"GroupTitel\":\"Testgruppe1b\"}");
INSERT INTO fragen_groups VALUES("6","1","{\"GroupTitel\":null}");
INSERT INTO fragen_groups VALUES("7","1","{\"GroupTitel\":\"Test\"}");



DROP TABLE fragen_groups_fragen_match;

CREATE TABLE `fragen_groups_fragen_match` (
  `FrageID` int(11) NOT NULL,
  `FGroupID` int(11) NOT NULL,
  UNIQUE KEY `FrageID_FGroupID` (`FrageID`,`FGroupID`),
  KEY `FGroupID` (`FGroupID`),
  CONSTRAINT `fragen_groups_fragen_match_ibfk_3` FOREIGN KEY (`FrageID`) REFERENCES `fragen` (`FrageID`) ON DELETE CASCADE,
  CONSTRAINT `fragen_groups_fragen_match_ibfk_4` FOREIGN KEY (`FGroupID`) REFERENCES `fragen_groups` (`FGroupID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO fragen_groups_fragen_match VALUES("90","1");
INSERT INTO fragen_groups_fragen_match VALUES("91","1");
INSERT INTO fragen_groups_fragen_match VALUES("92","1");
INSERT INTO fragen_groups_fragen_match VALUES("93","1");
INSERT INTO fragen_groups_fragen_match VALUES("94","1");
INSERT INTO fragen_groups_fragen_match VALUES("95","1");
INSERT INTO fragen_groups_fragen_match VALUES("96","1");
INSERT INTO fragen_groups_fragen_match VALUES("97","1");
INSERT INTO fragen_groups_fragen_match VALUES("98","1");
INSERT INTO fragen_groups_fragen_match VALUES("99","1");
INSERT INTO fragen_groups_fragen_match VALUES("100","1");
INSERT INTO fragen_groups_fragen_match VALUES("101","1");
INSERT INTO fragen_groups_fragen_match VALUES("102","1");
INSERT INTO fragen_groups_fragen_match VALUES("103","1");
INSERT INTO fragen_groups_fragen_match VALUES("104","1");
INSERT INTO fragen_groups_fragen_match VALUES("105","1");
INSERT INTO fragen_groups_fragen_match VALUES("93","2");
INSERT INTO fragen_groups_fragen_match VALUES("95","2");
INSERT INTO fragen_groups_fragen_match VALUES("96","2");



DROP TABLE kurs;

CREATE TABLE `kurs` (
  `kursID` int(11) NOT NULL AUTO_INCREMENT,
  `titel` tinytext NOT NULL,
  `beschreibung` text NOT NULL,
  `kTyp` int(11) NOT NULL COMMENT '1:Einzelaufgaben 2: Präsentation',
  `kursToken` tinytext NOT NULL,
  PRIMARY KEY (`kursID`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;

INSERT INTO kurs VALUES("1","Schulbezogenes Experimentieren II WiSe 2016/2017	","Beschreibung Kurs 1","2","593d420d59179");
INSERT INTO kurs VALUES("21","Kurs 3","Beschreibung Kurs 3","2","593d42293b830");
INSERT INTO kurs VALUES("22","Kurs 4","Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.","2","593d42293cde2");
INSERT INTO kurs VALUES("23","Pr&auml;sentation aller M&ouml;glichkeiten","Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.","2","593d42293d97a");
INSERT INTO kurs VALUES("24","Seminarkurse","Lorem ipsum PETER dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.","2","593d42293e5ab");
INSERT INTO kurs VALUES("25","Test","","1","593d42293f4da");
INSERT INTO kurs VALUES("28","TestPr&auml;sentation","","2","593d42293fe6e");
INSERT INTO kurs VALUES("110","Test neu","Hallo","2","593d4a3088917");
INSERT INTO kurs VALUES("111","Test neu","","2","593d4a39b5f07");
INSERT INTO kurs VALUES("113","Videovertonung","","1","59493802334bf");
INSERT INTO kurs VALUES("114","Test - leerer Kurs","","2","59496e6ec8068");
INSERT INTO kurs VALUES("115","Kurs 1","","2","594e322f423ac");
INSERT INTO kurs VALUES("116","Kurs 1","","2","59509e6031387");
INSERT INTO kurs VALUES("117","Kurs 2","","2","59509e776d9cb");



DROP TABLE kurs_share;

CREATE TABLE `kurs_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kursID` int(11) NOT NULL,
  `share_group` int(11) NOT NULL COMMENT '1: für alle Kollegen gleicher Schule; 2:für alle 3: per Email',
  `SchulNr` int(11) NOT NULL,
  `share_to_mail` text NOT NULL,
  `uID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kursID` (`kursID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

INSERT INTO kurs_share VALUES("6","1","3","0","pe.mayer@lmu.de","1");
INSERT INTO kurs_share VALUES("8","22","1","175","","1");
INSERT INTO kurs_share VALUES("16","25","2","0","","1");
INSERT INTO kurs_share VALUES("18","27","1","0","","1");
INSERT INTO kurs_share VALUES("19","28","1","175","","1");



DROP TABLE kurs_uID_match;

CREATE TABLE `kurs_uID_match` (
  `kursID` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  UNIQUE KEY `uID_kursID` (`uID`,`kursID`),
  KEY `kursID` (`kursID`),
  CONSTRAINT `kurs_uID_match_ibfk_3` FOREIGN KEY (`kursID`) REFERENCES `kurs` (`kursID`) ON DELETE CASCADE,
  CONSTRAINT `kurs_uID_match_ibfk_4` FOREIGN KEY (`uID`) REFERENCES `user` (`uID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO kurs_uID_match VALUES("1","1");
INSERT INTO kurs_uID_match VALUES("21","1");
INSERT INTO kurs_uID_match VALUES("22","1");
INSERT INTO kurs_uID_match VALUES("23","1");
INSERT INTO kurs_uID_match VALUES("24","1");
INSERT INTO kurs_uID_match VALUES("25","1");
INSERT INTO kurs_uID_match VALUES("28","1");
INSERT INTO kurs_uID_match VALUES("111","1");
INSERT INTO kurs_uID_match VALUES("113","1");
INSERT INTO kurs_uID_match VALUES("114","1");
INSERT INTO kurs_uID_match VALUES("115","5");
INSERT INTO kurs_uID_match VALUES("116","37");
INSERT INTO kurs_uID_match VALUES("117","37");



DROP TABLE media;

CREATE TABLE `media` (
  `mediaID` int(11) NOT NULL AUTO_INCREMENT,
  `uID` int(11) DEFAULT NULL,
  `fID` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `dateiname` tinytext,
  `titel` tinytext,
  `inserted` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleteDate` datetime DEFAULT NULL,
  `cp_mediaID` int(11) DEFAULT NULL,
  PRIMARY KEY (`mediaID`),
  KEY `fID` (`fID`),
  CONSTRAINT `media_ibfk_1` FOREIGN KEY (`fID`) REFERENCES `folien` (`fID`)
) ENGINE=InnoDB AUTO_INCREMENT=627 DEFAULT CHARSET=utf8;

INSERT INTO media VALUES("14","1","","4246629","58d8e1cd62bac.mov","TEST","2017-03-27 09:56:29","0000-00-00 00:00:00","");
INSERT INTO media VALUES("15","1","","4205287","58d8e385248c0.mov","TEST","2017-03-27 10:03:49","0000-00-00 00:00:00","");
INSERT INTO media VALUES("16","1","","4246629","58d8e515ee2a7.mov","TEST","2017-03-27 10:10:29","0000-00-00 00:00:00","");
INSERT INTO media VALUES("17","1","","4246629","58d8e5597ef03.mov","mov","2017-03-27 10:11:37","0000-00-00 00:00:00","");
INSERT INTO media VALUES("18","1","","4205287","58d8e57507f3e.mov","Experiment-10.mov","2017-03-27 10:12:05","0000-00-00 00:00:00","");
INSERT INTO media VALUES("19","1","","5818265","58d9f328a8cde.mp4","FC Bayern ist Leidenschaft.mp4","2017-03-28 05:22:48","","");
INSERT INTO media VALUES("20","1","","0","1_58ff4c85adbc6.png","blobid0.png","2017-04-25 13:17:57","","");
INSERT INTO media VALUES("21","1","","0","1_58ff4ccd01937.png","blobid0.png","2017-04-25 13:19:09","","");
INSERT INTO media VALUES("22","1","","0","1_58ff4d1ccfdaa.png","blobid0.png","2017-04-25 13:20:28","","");
INSERT INTO media VALUES("23","1","","0","1_58ff4d2bda503.png","blobid0.png","2017-04-25 13:20:43","","");
INSERT INTO media VALUES("24","1","","0","1_58ff4d685bde0.png","blobid0.png","2017-04-25 13:21:44","","");
INSERT INTO media VALUES("25","1","","0","1_58ff4d881ef82.png","blobid0.png","2017-04-25 13:22:16","","");
INSERT INTO media VALUES("26","1","","0","1_58ff4df559e2d.png","blobid0.png","2017-04-25 13:24:05","","");
INSERT INTO media VALUES("27","1","","0","1_58ff4e8d36b37.png","blobid0.png","2017-04-25 13:26:37","","");
INSERT INTO media VALUES("28","1","","0","1_58ff4ed582168.png","blobid0.png","2017-04-25 13:27:49","","");
INSERT INTO media VALUES("29","1","","56719","1_58ff4f04e3bb5.png","blobid0.png","2017-04-25 13:28:36","","");
INSERT INTO media VALUES("30","1","","56719","1_58ff4f9c8b14e.png","blobid0.png","2017-04-25 13:31:08","","");
INSERT INTO media VALUES("31","1","","56719","1_58ff4fe473dfc.png","blobid0.png","2017-04-25 13:32:20","","");
INSERT INTO media VALUES("32","1","","5125758","1_58ff50a2b76fc.jpg","blobid0.jpg","2017-04-25 13:35:30","","");
INSERT INTO media VALUES("33","1","","4139","1_58ffb1c34e2d5.png","blobid0.png","2017-04-25 20:29:55","","");
INSERT INTO media VALUES("34","1","","2622","1_58ffb1ea8c96b.png","blobid2.png","2017-04-25 20:30:34","","");
INSERT INTO media VALUES("35","1","","0","1_58ffb22be2513.png","blobid3.png","2017-04-25 20:31:39","","");
INSERT INTO media VALUES("36","1","","2622","1_58ffb2f4dbe3a.png","blobid0.png","2017-04-25 20:35:00","","");
INSERT INTO media VALUES("37","1","","2622","1_58ffb308c7b48.png","/tmp/php4x6Z8U","2017-04-25 20:35:20","","");
INSERT INTO media VALUES("38","1","","2622","1_58ffb32496159.png","blobid2.png","2017-04-25 20:35:48","","");
INSERT INTO media VALUES("39","1","","2622","1_58ffb339c07ae.png","blobid0.png","2017-04-25 20:36:09","","");
INSERT INTO media VALUES("40","1","","2622","1_58ffb3710c64a.png","blobid0.png","2017-04-25 20:37:05","","");
INSERT INTO media VALUES("41","1","","957406","1_59026d1961bfe.png","blobid0.png","2017-04-27 22:13:45","","");
INSERT INTO media VALUES("42","1","","957406","1_59026d87a9432.png","blobid0.png","2017-04-27 22:15:35","","");
INSERT INTO media VALUES("43","1","","957406","1_59026dc56d645.png","blobid0.png","2017-04-27 22:16:37","","");
INSERT INTO media VALUES("44","1","","957406","1_59026f7fd1598.png","blobid0.png","2017-04-27 22:23:59","","");
INSERT INTO media VALUES("45","1","","957406","1_5902702ec75d6.png","blobid0.png","2017-04-27 22:26:54","","");
INSERT INTO media VALUES("46","1","","957406","1_5902758e69f4d.png","blobid0.png","2017-04-27 22:49:50","","");
INSERT INTO media VALUES("47","1","","957406","1_5902761ba4d5e.png","blobid0.png","2017-04-27 22:52:11","","");
INSERT INTO media VALUES("48","1","","7314","1_590276dfdc76a.png","blobid0.png","2017-04-27 22:55:27","","");
INSERT INTO media VALUES("49","1","","508","1_591b1b2a799c9.png","blobid0.png","2017-05-16 15:30:50","","");
INSERT INTO media VALUES("50","1","","508","1_591b1b2a7ea6d.png","blobid1.png","2017-05-16 15:30:50","","");
INSERT INTO media VALUES("51","1","","508","1_591b1b2f85648.png","blobid2.png","2017-05-16 15:30:55","","");
INSERT INTO media VALUES("52","1","","18758","1_5922be7d08bad.jpg","blobid0.jpg","2017-05-22 10:33:33","","");
INSERT INTO media VALUES("53","1","","24228","1_5922e7845c346.jpg","blobid0.jpg","2017-05-22 13:28:36","","");
INSERT INTO media VALUES("615","45","1","","957406","1_5902702ec75d6.png","0000-00-00 00:00:00","2017-04-27 22:26:54","");
INSERT INTO media VALUES("616","46","1","","957406","1_5902758e69f4d.png","0000-00-00 00:00:00","2017-04-27 22:49:50","");
INSERT INTO media VALUES("617","47","1","","957406","1_5902761ba4d5e.png","0000-00-00 00:00:00","2017-04-27 22:52:11","");
INSERT INTO media VALUES("618","48","1","","7314","1_590276dfdc76a.png","0000-00-00 00:00:00","2017-04-27 22:55:27","");
INSERT INTO media VALUES("619","53","1","","24228","1_5922e7845c346.jpg","0000-00-00 00:00:00","2017-05-22 13:28:36","");
INSERT INTO media VALUES("620","1","","2640","1_594e29276986b.png","blobid0.png","2017-06-24 08:56:07","","");
INSERT INTO media VALUES("621","1","","2954915","1_594e299414f80.png","blobid0.png","2017-06-24 08:57:56","","");
INSERT INTO media VALUES("622","1","","2954915","1_594e4ec007ad3.png","blobid1.png","2017-06-24 11:36:32","","");
INSERT INTO media VALUES("623","1","","34459","1_594e76fe155b2.jpg","blobid0.jpg","2017-06-24 14:28:14","","");
INSERT INTO media VALUES("624","1","","34459","1_594e772a13fed.jpg","blobid0.jpg","2017-06-24 14:28:58","","");
INSERT INTO media VALUES("625","1","","538453","1_594e9a4342d71.png","blobid0.png","2017-06-24 16:58:43","","");
INSERT INTO media VALUES("626","1","","2833","1_5950fce0733b7.png","blobid1.png","2017-06-26 12:24:00","","");



DROP TABLE media_kurs_match;

CREATE TABLE `media_kurs_match` (
  `mediaID` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  `fID` int(11) NOT NULL,
  `kursID` int(11) NOT NULL,
  UNIQUE KEY `mediaID_uID_fID_kursID` (`mediaID`,`uID`,`fID`,`kursID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO media_kurs_match VALUES("45","1","101","28");
INSERT INTO media_kurs_match VALUES("46","1","102","28");
INSERT INTO media_kurs_match VALUES("47","1","103","28");
INSERT INTO media_kurs_match VALUES("48","1","104","28");
INSERT INTO media_kurs_match VALUES("53","1","109","28");
INSERT INTO media_kurs_match VALUES("615","1","1246","109");
INSERT INTO media_kurs_match VALUES("616","1","1247","109");
INSERT INTO media_kurs_match VALUES("617","1","1248","109");
INSERT INTO media_kurs_match VALUES("618","1","1249","109");
INSERT INTO media_kurs_match VALUES("619","1","1253","109");
INSERT INTO media_kurs_match VALUES("624","1","1267","111");
INSERT INTO media_kurs_match VALUES("624","1","1269","111");
INSERT INTO media_kurs_match VALUES("625","1","53","22");
INSERT INTO media_kurs_match VALUES("626","1","1279","111");



DROP TABLE module;

CREATE TABLE `module` (
  `modID` int(11) NOT NULL AUTO_INCREMENT,
  `mod_dir` tinytext NOT NULL COMMENT 'Ordner Name',
  `mod_show` tinytext NOT NULL COMMENT 'php Dateiname OHNE Pfad',
  `mod_titel` tinytext NOT NULL,
  `mod_add` tinytext NOT NULL,
  `for_kTyp` tinyint(4) NOT NULL DEFAULT '1',
  `show` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Sichtbar in der ErstellenListe',
  `aktiv` int(11) NOT NULL DEFAULT '1' COMMENT '1: ja; 0 nein',
  PRIMARY KEY (`modID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

INSERT INTO module VALUES("1","module/mod_videovertonung","show_aufgabe.php","Videovertonung","add_task.php","1","1","1");
INSERT INTO module VALUES("2","module/mod_videoarchiv","show_video.php","Videoarchiv","add_task.php","1","1","1");
INSERT INTO module VALUES("3","module/mod_videoanalyse","show_va.php","Videoanalyse","add_task.php","1","1","1");
INSERT INTO module VALUES("4","module/mod_videovertonung","show_bewertung.php","Videovertonung Besprechung","add_korrektur.php","1","0","1");
INSERT INTO module VALUES("5","module/mod_videovertonung","show_feedback.php","Videovertonung Feedback","add_feedback.php","1","0","1");
INSERT INTO module VALUES("6","module/mod_preasentation","show_praesentation.php","Präsentationsfolien","add_task.php","2","1","1");
INSERT INTO module VALUES("7","module/mod_bausteine","show_baustein.php","Bausteine","add_task.php","1","0","1");
INSERT INTO module VALUES("8","module/mod_videoanalyse","show_feedback.php","Videoanalyse Feedback","add_feedback.php","1","0","1");
INSERT INTO module VALUES("9","","","","","1","0","1");



DROP TABLE schule_bundesland;

CREATE TABLE `schule_bundesland` (
  `Bundesland` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`Bundesland`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO schule_bundesland VALUES("1","Bayern");



DROP TABLE schule_daten;

CREATE TABLE `schule_daten` (
  `SchulNr` int(11) NOT NULL,
  `Bundesland` int(11) NOT NULL DEFAULT '1',
  `Name` tinytext NOT NULL,
  `sTyp` tinytext NOT NULL,
  `rechtlicherStatus` tinytext NOT NULL,
  `strasse` tinytext NOT NULL,
  `plz` int(11) NOT NULL,
  `ort` tinytext NOT NULL,
  `url` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  UNIQUE KEY `SchulNr_Bundesland` (`SchulNr`,`Bundesland`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO schule_daten VALUES("1","1","Leibniz-Gymnasium Altdorf ","Gymnasium","Staatlich","Fischbacher Str. 23","90518","Altdorf","http://www.leibniz-gymnasium-altdorf.de","verwaltung@leibniz-gymnasium-altdorf.de");
INSERT INTO schule_daten VALUES("2","1","Maria-Ward-Gymnasium Alt&ouml;tting der Maria-Ward-Schulstiftung Passau","Gymnasium","Privat","Neu&ouml;ttinger Str. 8","84503","Alt&ouml;tting","http://www.mariawardschulen.de","sekretariat@mariawardschulen.de");
INSERT INTO schule_daten VALUES("3","1","Spessart-Gymnasium Alzenau ","Gymnasium","Staatlich","Brentanostr. 55","63755","Alzenau","http://www.spessart-gymnasium.de","sekretariat@spessart-gymnasium.de");
INSERT INTO schule_daten VALUES("4","1","Erasmus-Gymnasium Amberg ","Gymnasium","Staatlich","Gymnasiumstr. 7","92224","Amberg","http://www.eg-amberg.de","Erasmus.Gymnasium@eg-amberg.de");
INSERT INTO schule_daten VALUES("5","1","Gregor-Mendel-Gymnasium Amberg ","Gymnasium","Staatlich","Moritzstr. 1","92224","Amberg","http://www.gmg-amberg.de","gymnasium@gmg-amberg.de");
INSERT INTO schule_daten VALUES("6","1","Max-Reger-Gymnasium Amberg ","Gymnasium","Staatlich","Kaiser-Wilhelm-Ring 7","92224","Amberg","http://www.max-reger-gymnasium.de","mrg@asamnet.de");
INSERT INTO schule_daten VALUES("7","1","Dr.-Johanna-Decker-Gymnasium Amberg der Schulstiftung der Di&ouml;zese Regensburg ","Gymnasium","Privat","Deutsche Schulgasse 2","92224","Amberg","http://www.djds.de","gymnasium@djds.de");
INSERT INTO schule_daten VALUES("8","1","Deutschherren-Gymnasium Aichach ","Gymnasium","Staatlich","Ludwigstr. 58","86551","Aichach","https://dhg.ssl-secured-server.de/DHG/","sekretariat@dhgaic.de");
INSERT INTO schule_daten VALUES("9","1","Karl-Ernst-Gymnasium Amorbach ","Gymnasium","Staatlich","Richterstr. 1","63916","Amorbach","http://www.amorgym.de","schule@amorgym.de");
INSERT INTO schule_daten VALUES("10","1","Gymnasium Carolinum Ansbach ","Gymnasium","Staatlich","Reuterstr. 9","91522","Ansbach","http://www.gymnasium-carolinum.de","verwaltung@gymnasium-carolinum.de");
INSERT INTO schule_daten VALUES("11","1","Platen-Gymnasium Ansbach ","Gymnasium","Staatlich","Bahnhofplatz 15","91522","Ansbach","http://www.platen-gymnasium.de","info@platen-gymnasium.de");
INSERT INTO schule_daten VALUES("12","1","Theresien-Gymnasium Ansbach ","Gymnasium","Staatlich","Schreibm&uuml;llerstr. 10","91522","Ansbach","http://www.thg-ansbach.de","verwaltung@thg-ansbach.de");
INSERT INTO schule_daten VALUES("13","1","Kronberg-Gymnasium Aschaffenburg ","Gymnasium","Staatlich","Fasaneriestr. 33","63739","Aschaffenburg","http://www.kronberg-gymnasium.de","sekretariat@kronberg-gymnasium.de");
INSERT INTO schule_daten VALUES("14","1","Friedrich-Dessauer-Gymnasium Aschaffenburg","Gymnasium","Staatlich","Stadtbadstr. 4","63741","Aschaffenburg","http://www.fdg-online.de","sekretariat@fdg-online.de");
INSERT INTO schule_daten VALUES("15","1","Karl-Theodor-von-Dalberg-Gymnasium Aschaffenburg","Gymnasium","Staatlich","Gr&uuml;newaldstr. 18","63739","Aschaffenburg","http://www.dalberg-gymnasium.de","kontakt@dalberg-gymnasium.de");
INSERT INTO schule_daten VALUES("16","1","Maria-Ward-Schule M&auml;dchengymnasium der Maria-Ward-Stiftung Aschaffenburg","Gymnasium","Privat","Brentanoplatz 8-10","63739","Aschaffenburg","http://mws-ab.de","gymnasium@mws-ab.de");
INSERT INTO schule_daten VALUES("17","1","Gymnasium bei St.Anna Augsburg ","Gymnasium","Staatlich","Schertlinstr. 5-7","86159","Augsburg","http://www.gym-anna.de","gym-anna@augsburg.de");
INSERT INTO schule_daten VALUES("18","1","Gymnasium bei St.Stephan Augsburg ","Gymnasium","Staatlich","Gallusplatz 2","86152","Augsburg","http://www.st-stephan.de","st-stephan@augsburg.de");
INSERT INTO schule_daten VALUES("19","1","Peutinger-Gymnasium Augsburg ","Gymnasium","Staatlich","An der Blauen Kappe 10","86152","Augsburg","http://www.peutinger-gymnasium-augsburg.de","peutinger.stadt@augsburg.de");
INSERT INTO schule_daten VALUES("20","1","Holbein-Gymnasium Augsburg ","Gymnasium","Staatlich","Hallstr. 10","86150","Augsburg","http://www.holbein-gymnasium.de","holbein.stadt@augsburg.de");
INSERT INTO schule_daten VALUES("21","1","St&auml;dtisches Maria-Theresia- Gymnasium Augsburg","Gymnasium","Staatlich","Gutenbergstr. 1","86150","Augsburg","http://mtg-augsburg.de","mtg.stadt@augsburg.de");
INSERT INTO schule_daten VALUES("22","1","St&auml;dtisches Jakob-Fugger-Gymnasium Augsburg","Gymnasium","Staatlich","Kriemhildenstr. 5","86152","Augsburg","http://www.jakob-fugger-gymnasium.de","jfg.stadt@augsburg.de");
INSERT INTO schule_daten VALUES("23","1","Maria-Ward-Gymnasium Augsburg d. Schulwerks d. Di&ouml;zese Augsburg","Gymnasium","Privat","Frauentorstr. 26","86152","Augsburg","http://www.mwg-augsburg.de","info@mwg-augsburg.de");
INSERT INTO schule_daten VALUES("24","1","A.B. von Stettensches Institut Augsburg -Gymnasium-","Gymnasium","Privat","Am Katzenstadel 18a","86152","Augsburg","http://www.stetten-institut.de","gymnasium@stetten-institut.de");
INSERT INTO schule_daten VALUES("25","1","Franz-Miltenberger-Gymnasium Bad Br&uuml;ckenau","Gymnasium","Staatlich","R&ouml;mershager Str. 27","97769","Bad Br&uuml;ckenau","http://www.fmg-brk.de","sekretariat@fmg-brk.de");
INSERT INTO schule_daten VALUES("26","1","Jack-Steinberger-Gymnasium Bad Kissingen","Gymnasium","Staatlich","Steinstr. 18","97688","Bad Kissingen","http://www.jack-steinberger-gymnasium.de","direktorat@jack-steinberger-gymnasium.de");
INSERT INTO schule_daten VALUES("27","1","Rh&ouml;n-Gymnasium Bad Neustadt ","Gymnasium","Staatlich","Franz-Marschall-Str. 7","97616","Bad Neustadt","http://www.rhoen-gymnasium.de","direktorat@rhoen-gymnasium.de");
INSERT INTO schule_daten VALUES("28","1","Karlsgymnasium Bad Reichenhall ","Gymnasium","Staatlich","Salzburger Str. 28","83435","Bad Reichenhall","http://karlsgymnasium-bgl.de","info@karlsgymnasium-bgl.de");
INSERT INTO schule_daten VALUES("29","1","Gabriel-von-Seidl-Gymnasium Bad T&ouml;lz","Gymnasium","Staatlich","Hindenburgstr. 26","83646","Bad T&ouml;lz","http://www.gvs-gymnasium-bad-toelz.de","sekretariat@gvs-gymnasium-bad-toelz.de");
INSERT INTO schule_daten VALUES("30","1","Georg-Wilhelm-Steller-Gymnasium Bad Windsheim","Gymnasium","Staatlich","Friedensweg 24","91438","Bad Windsheim","http://www.gwsg.net","verwaltung@gwsg.net");
INSERT INTO schule_daten VALUES("31","1","Kaiser-Heinrich-Gymnasium Bamberg ","Gymnasium","Staatlich","Altenburger Str. 16","96049","Bamberg","http://www.khg.bamberg.de","khg@bnv-bamberg.de");
INSERT INTO schule_daten VALUES("32","1","Franz-Ludwig-Gymnasium Bamberg ","Gymnasium","Staatlich","Franz-Ludwig-Str. 13","96047","Bamberg","http://www.franz-ludwig-gymnasium.de","flg@franz-ludwig-gymnasium.de");
INSERT INTO schule_daten VALUES("33","1","Clavius-Gymnasium Bamberg ","Gymnasium","Staatlich","Kapuzinerstr. 29","96047","Bamberg","http://www.cg.bamberg.de","info@cg.bamberg.de");
INSERT INTO schule_daten VALUES("34","1","Dientzenhofer-Gymnasium Bamberg ","Gymnasium","Staatlich","Feldkirchenstr. 22","96052","Bamberg","http://www.dg-info.de","dg@stadt.bamberg.de");
INSERT INTO schule_daten VALUES("35","1","E.T.A.Hoffmann-Gymnasium Bamberg ","Gymnasium","Staatlich","Sternwartstr. 3","96049","Bamberg","http://www.eta-hoffmann-gymnasium.de","Info@eta-hoffmann-gymnasium.de");
INSERT INTO schule_daten VALUES("36","1","St&auml;dtisches Eichendorff-Gymnasium Bamberg","Gymnasium","Staatlich","Kloster-Langheim-Str. 10","96050","Bamberg","http://www.eg-bamberg.de","eichendorff-gymnasium@stadt.bamberg.de");
INSERT INTO schule_daten VALUES("37","1","Maria-Ward-Gymnasium Bamberg ","Gymnasium","Privat","Edelstr. 1","96047","Bamberg","http://maria-ward-gymnasium-bamberg.de","sekretariat@mws.bamberg.de");
INSERT INTO schule_daten VALUES("38","1","Theresianum Bamberg Sp&auml;tberufenengymnasium der Karmeliten ","Gymnasium","Privat","Karmelitenplatz 1-3","96049","Bamberg","http://www.theresianum.de","sekretariat@theresianum.de");
INSERT INTO schule_daten VALUES("39","1","Gymnasium Christian-Ernestinum Bayreuth","Gymnasium","Staatlich","Albrecht-D&uuml;rer-Str. 2","95448","Bayreuth","http://www.gce-bayreuth.de","sekretariat@gce-bayreuth.de");
INSERT INTO schule_daten VALUES("40","1","Graf-M&uuml;nster-Gymnasium Bayreuth ","Gymnasium","Staatlich","Sch&uuml;tzenplatz 12","95444","Bayreuth","http://www.gmg-bayreuth.de","sekretariat@gmg-bayreuth.de");
INSERT INTO schule_daten VALUES("41","1","Markgr&auml;fin-Wilhelmine-Gymnasium Bayreuth","Gymnasium","Staatlich","K&ouml;nigsallee 17","95448","Bayreuth","http://www.mwg-bayreuth.de","direktorat@mwg-bayreuth.de");
INSERT INTO schule_daten VALUES("42","1","Richard-Wagner-Gymnasium Bayreuth ","Gymnasium","Staatlich","Wittelsbacherring 9","95444","Bayreuth","http://www.rwg-bayreuth.de","schulleitung@rwg-bayreuth.de");
INSERT INTO schule_daten VALUES("43","1","St&auml;dt. Wirtschaftswissenschaftl. Gymnasium Bayreuth","Gymnasium","Staatlich","Am Sportpark 1","95448","Bayreuth","http://www.wwg-bayreuth.de/","sekretariat@wwg-bayreuth.de");
INSERT INTO schule_daten VALUES("44","1","Gymnasium Berchtesgaden ","Gymnasium","Staatlich","Am Anzenbachfeld 1","83471","Berchtesgaden","http://gymbgd.de","schule@gymbgd.de");
INSERT INTO schule_daten VALUES("45","1","CJD Christophorusschule Berchtesgaden in Sch&ouml;nau Staatl. anerk. neuspr. und math.-nat. Gymnasium","Gymnasium","Privat","Am D&uuml;rreck 4","83471","Sch&ouml;nau","http://www.gymnasium-bgd.de","gundula.huber@cjd.de");
INSERT INTO schule_daten VALUES("46","1","Gymnasium Burgkunstadt ","Gymnasium","Staatlich","Kirchleiner Str. 18","96224","Burgkunstadt","http://www.gymnasium-burgkunstadt.de","verwaltung@gymnasium-burgkunstadt.de");
INSERT INTO schule_daten VALUES("47","1","Staatl. Gymnasium Lappersdorf","Gymnasium","Staatlich","Am Sportzentrum 2","93138","Lappersdorf","www.gymnasium-lappersdorf.de","sekretariat@gymnasium-lappersdorf.de");
INSERT INTO schule_daten VALUES("48","1","Kurf&uuml;rst-Maximilian-Gymnasium Burghausen","Gymnasium","Staatlich","Kanzelm&uuml;llerstr. 90 1/2","84489","Burghausen","http://www.kumax.de","sekretariat@kumax.de");
INSERT INTO schule_daten VALUES("49","1","Aventinus-Gymnasium Burghausen ","Gymnasium","Staatlich","Adalbert-Stifter-Str. 2","84489","Burghausen","http://www.aventinus-gymnasium.de","sekretariat@aventinus-gymnasium.de");
INSERT INTO schule_daten VALUES("50","1","Johann-Michael-Fischer-Gymnasium Burglengenfeld","Gymnasium","Staatlich","Johannes-Kepler-Str. 4","93133","Burglengenfeld","http://www.jmf-gym.de","sekretariat@jmf-gymnasium.de");
INSERT INTO schule_daten VALUES("51","1","Marianum Buxheim Gymnasium des Schulwerks der Di&ouml;zese Augsburg ","Gymnasium","Privat","An der Kartause 3","87740","Buxheim","http://www.gymnasium-marianum-buxheim.de","sekretariat@gymnasium-marianum-buxheim.de");
INSERT INTO schule_daten VALUES("52","1","Robert-Schuman-Gymnasium Cham ","Gymnasium","Staatlich","Pfarrer-Lukas-Str. 36","93413","Cham","http://www.rsg-cham.de","verwaltung@rsg-cham.de");
INSERT INTO schule_daten VALUES("53","1","Joseph-von-Fraunhofer-Gymnasium Cham","Gymnasium","Staatlich","Dr.-Muggenthaler-Str. 32","93413","Cham","http://www.jvfg-cham.de","verwaltung@jvfg-cham.de");
INSERT INTO schule_daten VALUES("54","1","Gymnasium Casimirianum Coburg ","Gymnasium","Staatlich","Gymnasiumsgasse 2","96450","Coburg","http://www.casimirianum.de","Mail@Casimirianum.de");
INSERT INTO schule_daten VALUES("55","1","Gymnasium Ernestinum Coburg ","Gymnasium","Staatlich","Untere Realschulstr. 2","96450","Coburg","http://www.ernestinum-coburg.de","sekretariat@ernestinum.coburg.de");
INSERT INTO schule_daten VALUES("56","1","Gymnasium Alexandrinum Coburg ","Gymnasium","Staatlich","Seidmannsdorfer Str. 12","96450","Coburg","http://www.alexandrinum-coburg.de","sekretariat@alexandrinum.coburg.de");
INSERT INTO schule_daten VALUES("57","1","Gymnasium Albertinum Coburg ","Gymnasium","Staatlich","Untere Anlage 1","96450","Coburg","http://www.gym-albertinum.de","sekretariat@albertinum.coburg.de");
INSERT INTO schule_daten VALUES("58","1","Josef-Effner-Gymnasium Dachau ","Gymnasium","Staatlich","Erich-Ollenhauer-Str. 12","85221","Dachau","http://www.effner.de","verwaltung@effner.de");
INSERT INTO schule_daten VALUES("59","1","Comenius-Gymnasium Deggendorf ","Gymnasium","Staatlich","Jahnstr. 8","94469","Deggendorf","http://www.comenius-gymnasium-deggendorf.de","info@comenius-gymnasium-deggendorf.de");
INSERT INTO schule_daten VALUES("60","1","Johann-Michael-Sailer-Gymnasium Dillingen","Gymnasium","Staatlich","Ziegelstr. 8","89407","Dillingen","http://www.sailer-gymnasium.de","sekretariat@sailer-gymnasium.de");
INSERT INTO schule_daten VALUES("61","1","St.Bonaventura-Gymnasium Dillingen des Schulwerks der Di&ouml;zese Augsburg","Gymnasium","Privat","Konviktstr. 11a","89407","Dillingen","http://www.bonaventura-gymnasium.de","sekretariat@bonaventura-gymnasium.de");
INSERT INTO schule_daten VALUES("62","1","Gymnasium Dingolfing ","Gymnasium","Staatlich","Kerschensteinerstr. 6","84130","Dingolfing","www.gymnasium.dingolfing.de","gymnasium@gymnasium.dingolfing.de");
INSERT INTO schule_daten VALUES("63","1","Gymnasium Dinkelsb&uuml;hl ","Gymnasium","Staatlich","Ulmer Weg","91550","Dinkelsb&uuml;hl","http://www.gymnasium-dinkelsbuehl.de","sekretariat@gymnasium-dinkelsbuehl.de");
INSERT INTO schule_daten VALUES("64","1","Gymnasium Donauw&ouml;rth ","Gymnasium","Staatlich","Pyrkstockstr. 1","86609","Donauw&ouml;rth","http://www.gym-don.de","schule@gym-don.de");
INSERT INTO schule_daten VALUES("65","1","Friedrich-R&uuml;ckert-Gymnasium Ebern ","Gymnasium","Staatlich","Gymnasiumstr. 4","96106","Ebern","http://www.frg-ebern.de","pressekm@stmuk.bayern.de");
INSERT INTO schule_daten VALUES("66","1","Karl-von-Closen-Gymnasium Eggenfelden","Gymnasium","Staatlich","Gerner Allee 1","84307","Eggenfelden","http://www.closen.de","sekretariat@closen.de");
INSERT INTO schule_daten VALUES("67","1","Willibald-Gymnasium Eichst&auml;tt ","Gymnasium","Staatlich","Schottenau 16","85072","Eichst&auml;tt","http://www.willibald-gymnasium.de","sekretariat@willibald-gymnasium.de");
INSERT INTO schule_daten VALUES("68","1","Gabrieli-Gymnasium Eichst&auml;tt ","Gymnasium","Staatlich","Luitpoldstr. 40","85072","Eichst&auml;tt","http://www.gabrieli-gymnasium.de","sekretariat@gabrieli-gymnasium.de");
INSERT INTO schule_daten VALUES("70","1","Anne-Frank-Gymnasium Erding ","Gymnasium","Staatlich","Heilig Blut 8","85435","Erding","http://www.afg-erding.de","verw@afg-erding.de");
INSERT INTO schule_daten VALUES("71","1","Gymnasium Fridericianum Erlangen ","Gymnasium","Staatlich","Sebaldusstr. 37","91058","Erlangen","http://www.gymnasium-fridericianum.de","info@gymnasium-fridericianum.de");
INSERT INTO schule_daten VALUES("72","1","Albert-Schweitzer-Gymnasium Erlangen","Gymnasium","Staatlich","Dompfaffstr. 111","91056","Erlangen","http://www.asg-er.de","sekretariat@asg-er.de");
INSERT INTO schule_daten VALUES("73","1","Ohm-Gymnasium Erlangen ","Gymnasium","Staatlich","Am R&ouml;thelheim 6","91052","Erlangen","http://www.ohm-gymnasium.de","sekretariat@ohm-gymnasium.de");
INSERT INTO schule_daten VALUES("74","1","Christian-Ernst-Gymnasium Erlangen ","Gymnasium","Staatlich","Langemarckplatz 2","91054","Erlangen","http://www.ceg-erlangen.de","Sekretariat@ceg-er.de");
INSERT INTO schule_daten VALUES("75","1","St&auml;dtisches Marie-Therese- Gymnasium Erlangen","Gymnasium","Staatlich","Schillerstr. 12","91054","Erlangen","http://www.mtg-erlangen.de","mtg@stadt.erlangen.de");
INSERT INTO schule_daten VALUES("76","1","Hermann-Staudinger-Gymnasium Erlenbach a.Main","Gymnasium","Staatlich","Elsenfelder Str. 55","63906","Erlenbach","http://www.hsgerlenbach.de","sekretariat@hsgerlenbach.de");
INSERT INTO schule_daten VALUES("77","1","Gymnasium Eschenbach ","Gymnasium","Staatlich","Dr.-Friedrich-Arnold-Str. 2","92676","Eschenbach","http://www.gymnasium-eschenbach.de","poststelle@gymnasium-eschenbach.de");
INSERT INTO schule_daten VALUES("78","1","Benediktinergymnasium Ettal ","Gymnasium","Privat","Kaiser-Ludwig-Platz 1","82488","Ettal","http://www.benediktinergymnasium.de","sekretariat@internat-ettal.de");
INSERT INTO schule_daten VALUES("79","1","Schmuttertal-Gymnasium Diedorf ","Gymnasium","Staatlich","Pestalozzistr. 17","86420","Diedorf","http://www.schmuttertal-gymnasium.de/","sekretariat@gymdiedorf.de");
INSERT INTO schule_daten VALUES("80","1","Gymnasium Feuchtwangen ","Gymnasium","Staatlich","Dr.-Hans-G&uuml;thlein-Weg 10","91555","Feuchtwangen","http://gymnasium-feuchtwangen.de","post@gymnasium-feuchtwangen.de");
INSERT INTO schule_daten VALUES("81","1","Sp&auml;tberufenenschule St. Josef der Oblaten des Hl. Franz von Sales Fockenfeld ","Gymnasium","Privat","Fockenfeld 1","95692","Konnersreuth","http://www.fockenfeld.de","gymnasium@fockenfeld.de");
INSERT INTO schule_daten VALUES("82","1","Herder-Gymnasium Forchheim ","Gymnasium","Staatlich","Luitpoldstr. 1","91301","Forchheim","http://www.herder-forchheim.de","sekretariat@herder-forchheim.de");
INSERT INTO schule_daten VALUES("83","1","Gymnasium Buchloe","Gymnasium","Staatlich","Kerschensteinerstr. 8","86807","Buchloe","http://gymnasium-buchloe.de/ ","schule@gymnasium-buchloe.bayern.de");
INSERT INTO schule_daten VALUES("84","1","Dom-Gymnasium Freising ","Gymnasium","Staatlich","Domberg 3 - 5","85354","Freising","http://www.domgym-fs.de","sekretariat@domgym-fs.de");
INSERT INTO schule_daten VALUES("85","1","Josef-Hofmiller-Gymnasium Freising ","Gymnasium","Staatlich","Vimystr. 14","85354","Freising","http://www.johogym-freising.de","joho@johogym-freising.de");
INSERT INTO schule_daten VALUES("86","1","Camerloher-Gymnasium Freising","Gymnasium","Staatlich","Wippenhauser Str. 51","85354","Freising","http://www.camerloher-gymnasium.de","info@camerloher-gymnasium.de&nbsp;");
INSERT INTO schule_daten VALUES("87","1","Emmy-Noether-Gymnasium Erlangen ","Gymnasium","Staatlich","Noetherstr. 49b","91058","Erlangen","http://www.emmy-noether-gymnasium.de","sekretariat@emmy-noether-gymnasium.de");
INSERT INTO schule_daten VALUES("88","1","Gymnasium Freyung ","Gymnasium","Staatlich","St.-Gunther-Str. 52","94078","Freyung","http://www.gymnasium-freyung.de","gymnasium_freyung@t-online.dev.");
INSERT INTO schule_daten VALUES("89","1","Graf-Rasso-Gymnasium F&uuml;rstenfeldbruck","Gymnasium","Staatlich","M&uuml;nchner Str. 69","82256","F&uuml;rstenfeldbruck","http://www.graf-rasso-gymnasium.de","sekretariat@graf-rasso-gymnasium.de");
INSERT INTO schule_daten VALUES("90","1","Maristengymnasium F&uuml;rstenzell ","Gymnasium","Privat","Schulstr. 18","94081","F&uuml;rstenzell","http://www.mgfuerstenzell.de","info@mgfuerstenzell.de");
INSERT INTO schule_daten VALUES("91","1","Heinrich-Schliemann-Gymnasium F&uuml;rth","Gymnasium","Staatlich","K&ouml;nigstr. 105","90762","F&uuml;rth","http://www.schliemann-gym.de","hsg@schliemann-gym.de");
INSERT INTO schule_daten VALUES("92","1","Hardenberg-Gymnasium F&uuml;rth ","Gymnasium","Staatlich","Kaiserstr. 92","90763","F&uuml;rth","http://www.hardenberg-gymnasium.de","sekretariat.hgf@t-online.de");
INSERT INTO schule_daten VALUES("93","1","Helene-Lange-Gymnasium F&uuml;rth ","Gymnasium","Staatlich","Tannenstr. 19","90762","F&uuml;rth","http://www.hlg-fuerth.de","erhardt@hlg-fuerth.net");
INSERT INTO schule_daten VALUES("94","1","Gymnasium F&uuml;ssen ","Gymnasium","Staatlich","Dr.-Enzinger-Str. 5","87629","F&uuml;ssen","http://www.gymnasium-fuessen.de","sekretariat@gymnasium-fuessen.de&nbsp;&nbsp;");
INSERT INTO schule_daten VALUES("95","1","Maristen-Gymnasium Furth ","Gymnasium","Privat","Klosterstr. 6","84095","Furth","http://www.maristen-gymnasium.de","sekretariat@maristen-gymnasium.de");
INSERT INTO schule_daten VALUES("96","1","Franken-Landschulheim Schlo&szlig; Gaibach des Zweckverbandes bayer. Landschulheime -Gymnasium- ","Gymnasium","Staatlich","Sch&ouml;nbornstr. 2","97332","Volkach","http://www.flshgaibach.de","schule@flsh.de");
INSERT INTO schule_daten VALUES("97","1","Werdenfels-Gymnasium Garmisch-Partenkirchen","Gymnasium","Staatlich","Wettersteinstr. 30","82467","Garmisch-Partenkirchen","http://www.werdenfels-gymnasium.de","sekretariat@werdenfels-gymnasium.de");
INSERT INTO schule_daten VALUES("98","1","St.-Irmengard-Gymnasium Garmisch-Partenkirchen d. Erzdi&ouml;zese M&uuml;nchen u. Freising ","Gymnasium","Privat","Hauptstr. 45","82467","Garmisch-Partenkirchen","http://web.irmengardschule.de/","gym@irmengardschule.de");
INSERT INTO schule_daten VALUES("99","1","Gymnasium Gars a.Inn ","Gymnasium","Staatlich","Tassilostr. 1","83536","Gars","http://gymnasiumgars.de","mail@gymnasiumgars.de");
INSERT INTO schule_daten VALUES("100","1","Otto-von-Taube-Gymnasium Gauting ","Gymnasium","Staatlich","Germeringer Str. 41","82131","Gauting","http://www.ovtg.de","sekretariat@ovtg.gauting.de");
INSERT INTO schule_daten VALUES("101","1","Friedrich-List-Gymnasium Gem&uuml;nden ","Gymnasium","Staatlich","Kolpingstr. 11","97737","Gem&uuml;nden","http://www.flg-gemuenden.de","schule@f-l-g.de");
INSERT INTO schule_daten VALUES("102","1","Max-Born-Gymnasium Germering ","Gymnasium","Staatlich","Johann-Sebastian-Bach-Str. 8","82110","Germering","http://www.mbg-germering.de","mbg@mbg-germering.de");
INSERT INTO schule_daten VALUES("103","1","Gymnasium Maria Stern Augsburg des Schulwerks der Di&ouml;zese Augsburg","Gymnasium","Privat","G&ouml;gginger Str. 132","86199","Augsburg","http://www.mariastern.net","info@mariastern.net");
INSERT INTO schule_daten VALUES("104","1","Kurt-Huber-Gymnasium Gr&auml;felfing ","Gymnasium","Staatlich","Adalbert-Stifter-Platz 2","82166","Gr&auml;felfing","http://www.khg-online.de","khg-post@khg.net");
INSERT INTO schule_daten VALUES("105","1","Landgraf-Leuchtenberg-Gymnasium Grafenau","Gymnasium","Staatlich","Rachelweg 18","94481","Grafenau","http://www.llg-grafenau.de","sekretariat@llg-grafenau.de");
INSERT INTO schule_daten VALUES("106","1","Gymnasium Grafing ","Gymnasium","Staatlich","Jahnstr. 17","85567","Grafing","http://www.gymnasium-grafing.de","info@gymnasium-grafing.de");
INSERT INTO schule_daten VALUES("107","1","Dossenberger-Gymnasium G&uuml;nzburg ","Gymnasium","Staatlich","Am S&uuml;dlichen Burgfrieden 4","89312","G&uuml;nzburg","http://www.dossenberger.de","Verwaltung@dossenberger.de");
INSERT INTO schule_daten VALUES("108","1","Maria-Ward-Gymnasium G&uuml;nzburg d. Schulwerks d. Di&ouml;zese Augsburg","Gymnasium","Privat","Frauenplatz 1","89312","G&uuml;nzburg","http://www.maria-ward-gymnasium-gz.de","sekretariat@maria-ward-gymnasium-gz.de");
INSERT INTO schule_daten VALUES("109","1","Simon-Marius-Gymnasium Gunzenhausen","Gymnasium","Staatlich","Simon-Marius-Str. 3","91710","Gunzenhausen","http://www.simon-marius-gymnasium.de","direktorat@simon-marius-gymnasium.de");
INSERT INTO schule_daten VALUES("110","1","Frobenius-Gymnasium Hammelburg ","Gymnasium","Staatlich","Von-der-Tann-Str. 8-10","97762","Hammelburg","http://www.frobenius-gymnasium.de","sekretariat@fg-hab.de");
INSERT INTO schule_daten VALUES("111","1","Regiomontanus-Gymnasium Ha&szlig;furt ","Gymnasium","Staatlich","Tricastiner Platz 1","97437","Ha&szlig;furt","http://www.regiomontanus-gymnasium.de","schulleitung-gym@schulzentrum-hassfurt.de");
INSERT INTO schule_daten VALUES("112","1","Paul-Pfinzing-Gymnasium Hersbruck ","Gymnasium","Staatlich","Amberger Str. 30","91217","Hersbruck","http://www.gymnasium-hersbruck.de","verwaltung@gymnasium-hersbruck.de");
INSERT INTO schule_daten VALUES("113","1","Gymnasium Hilpoltstein ","Gymnasium","Staatlich","Patersholzer Weg 19","91161","Hilpoltstein","http://www.gym-hip.de","verwaltung@gym-hip.de");
INSERT INTO schule_daten VALUES("114","1","Gymnasium H&ouml;chstadt a.d.Aisch ","Gymnasium","Staatlich","Bergstr. 4","91315","H&ouml;chstadt","http://www.gymnasium-hoechstadt.de","verwaltung@gymnasium-hoechstadt.de");
INSERT INTO schule_daten VALUES("115","1","Jean-Paul-Gymnasium Hof ","Gymnasium","Staatlich","Gymnasiumsplatz 4-6","95028","Hof","http://www.jean-paul-gymnasium.de","schulleitung@jean-paul-gymnasium.de");
INSERT INTO schule_daten VALUES("116","1","Schiller-Gymnasium Hof ","Gymnasium","Staatlich","Schillerstr. 38","95028","Hof","http://schiller-gymnasium-hof.de","verwaltung@schiller-gymnasium-hof.de");
INSERT INTO schule_daten VALUES("117","1","Johann-Christian-Reinhart- Gymnasium Hof","Gymnasium","Staatlich","Max-Reger-Str. 71","95030","Hof","http://www.reinhart-gymnasium-hof.de","sekretariat@reinhart-gymnasium-hof.de");
INSERT INTO schule_daten VALUES("118","1","St.-Ursula-Gymnasium Hohenburg d. Erzdi&ouml;zese M&uuml;nchen u. Freising","Gymnasium","Privat","Schlo&szlig; Hohenburg","83661","Lenggries","http://www.gymnasium.st-ursula.net/","gymnasium@st-ursula.net");
INSERT INTO schule_daten VALUES("119","1","Gymnasium Hohenschwangau ","Gymnasium","Staatlich","Colomanstr. 10","87645","Schwangau","http://www.gymnasium-hohenschwangau.de","verwaltung@gymnasium-hohenschwangau.de");
INSERT INTO schule_daten VALUES("120","1","Rainer-Maria-Rilke-Gymnasium Icking ","Gymnasium","Staatlich","Ulrichstr. 1-7","82057","Icking","http://www.gym-icking.de","info@gym-icking.de");
INSERT INTO schule_daten VALUES("121","1","Kolleg der Schulbr&uuml;der Illertissen - Gymnasium - des Schulwerks der Di&ouml;zese Augsburg ","Gymnasium","Privat","Dietenheimer Str. 70","89257","Illertissen","http://www.kolleg-illertissen.de","sekretariat@kolleg-illertissen.de");
INSERT INTO schule_daten VALUES("122","1","Gymnasium Ergolding ","Gymnasium","Staatlich","Am Sportpark 8","84030","Ergolding","","");
INSERT INTO schule_daten VALUES("123","1","Reuchlin-Gymnasium Ingolstadt ","Gymnasium","Staatlich","Gymnasiumstr. 15","85049","Ingolstadt","http://www.reuchlin.ingolstadt.de","sekretariat@reuchlin.ingolstadt.de");
INSERT INTO schule_daten VALUES("124","1","Christoph-Scheiner-Gymnasium Ingolstadt","Gymnasium","Staatlich","Hartmannplatz 1","85049","Ingolstadt","http://www.christoph-scheiner-gymnasium.de","offeneganztagsschule@csg-in.de");
INSERT INTO schule_daten VALUES("125","1","Katharinen-Gymnasium Ingolstadt ","Gymnasium","Staatlich","Jesuitenstr. 10","85049","Ingolstadt","http://www.katharinengymnasium.de","verwaltung@remove-this.katharinengymnasium.de");
INSERT INTO schule_daten VALUES("126","1","Gnadenthal-Gymnasium Ingolstadt der Di&ouml;zese Eichst&auml;tt","Gymnasium","Privat","Kupferstr. 23","85049","Ingolstadt","http://www.gnadenthal-gymnasium.de","verwaltung@gnadenthal-gymnasium.de");
INSERT INTO schule_daten VALUES("127","1","Landschulheim Schlo&szlig; Ising am Chiemsee des Zweckverbands bayerischer Landschulheime ","Gymnasium","Staatlich","Schlo&szlig;str. 3","83339","Chieming","http://www.lshi.de","sekretariat@lsh-schloss-ising.de");
INSERT INTO schule_daten VALUES("129","1","Jakob-Brucker-Gymnasium Kaufbeuren ","Gymnasium","Staatlich","Neugablonzer Str. 38","87600","Kaufbeuren","http://www.jakob-brucker-gymnasium.de","schule@jakob-brucker-gymnasium.de");
INSERT INTO schule_daten VALUES("130","1","Marien-Gymnasium Kaufbeuren d. Schulwerks d. Di&ouml;zese Augsburg","Gymnasium","Privat","Kemnater Str. 19","87600","Kaufbeuren","http://www.marien-gymnasium.de","direktorat@marien-gymnasium.de");
INSERT INTO schule_daten VALUES("131","1","Donau-Gymnasium Kelheim ","Gymnasium","Staatlich","Rennweg 61","93309","Kelheim","http://www.donau-gymnasium.de","sekretariat@donau-gymnasium.de");
INSERT INTO schule_daten VALUES("132","1","Landschulheim Kempfenhausen des Zweckverbandes Bayerische Landschulheime - Gymnasium - ","Gymnasium","Staatlich","M&uuml;nchner Str. 49 - 63","82335","Berg","http://www.landschulheim-kempfenhausen.de","lsh@lshk.de");
INSERT INTO schule_daten VALUES("133","1","Carl-von-Linde-Gymnasium Kempten ","Gymnasium","Staatlich","Haubensteigweg 10","87439","Kempten","http://www.carl-von-linde-gymnasium.de","info@cvlk.de");
INSERT INTO schule_daten VALUES("134","1","Allg&auml;u-Gymnasium Kempten ","Gymnasium","Staatlich","Eberhard-Schobacher-Weg 1","87435","Kempten","http://allgaeu-gymnasium.de","ag@allgaeugymnasium.de");
INSERT INTO schule_daten VALUES("135","1","Hildegardis-Gymnasium Kempten ","Gymnasium","Staatlich","Lindauer Str. 22","87439","Kempten","http://www.hildegardis-gymnasium.de","info@hildegardis-gymnasium.de");
INSERT INTO schule_daten VALUES("136","1","Armin-Knab-Gymnasium Kitzingen ","Gymnasium","Staatlich","Kanzler-St&uuml;rtzel-Str. 15","97318","Kitzingen","http://www.armin-knab-gymnasium.de","mail@armin-knab-gymnasium.de");
INSERT INTO schule_daten VALUES("137","1","Gymnasium K&ouml;nigsbrunn ","Gymnasium","Staatlich","Alter Postweg 3","86343","K&ouml;nigsbrunn","http://www.gymnasiumkoenigsbrunn.de/","direktorat@gymkoenigsbrunn.de");
INSERT INTO schule_daten VALUES("138","1","Gymnasium Bad K&ouml;nigshofen i.Gr. ","Gymnasium","Staatlich","Dr.-Ernst-Weber-Str. 16","97631","Bad K&ouml;nigshofen","http://www.gymnasium-badkoenigshofen.de","sekretariat@gymnasium-badkoenigshofen.de");
INSERT INTO schule_daten VALUES("139","1","Benedikt-Stattler-Gymnasium Bad K&ouml;tzting","Gymnasium","Staatlich","Bgm.-Dullinger-Str. 23","93444","Bad K&ouml;tzting","http://www.bsg-koetzting.de","verwaltung.dir@bsg-koetzting.de");
INSERT INTO schule_daten VALUES("140","1","Kaspar-Zeu&szlig;-Gymnasium Kronach ","Gymnasium","Staatlich","Langer Steig 1","96317","Kronach","http://www.kzg.de","sekretariat@kzg.de");
INSERT INTO schule_daten VALUES("141","1","Simpert-Kraemer-Gymnasium Krumbach ","Gymnasium","Staatlich","Jochnerstr. 30","86381","Krumbach","http://www.skg-krumbach.de","sekretariat@skg-krumbach.de");
INSERT INTO schule_daten VALUES("142","1","Markgraf-Georg-Friedrich-Gymnasium Kulmbach","Gymnasium","Staatlich","Schie&szlig;graben 1","95326","Kulmbach","http://www.mgf-kulmbach.de","sekretariat@mgf-kulmbach.de");
INSERT INTO schule_daten VALUES("143","1","Caspar-Vischer-Gymnasium Kulmbach ","Gymnasium","Staatlich","Christian-Pertsch-Str. 4","95326","Kulmbach","http://cvg-kulmbach.de","schule@cvg-kulmbach.de");
INSERT INTO schule_daten VALUES("144","1","Gymnasium Landau a.d.Isar ","Gymnasium","Staatlich","Harburger Str. 12","94405","Landau","http://gymnasium-landau.de","kontakt@gymnasium-landau.de");
INSERT INTO schule_daten VALUES("145","1","Dominikus-Zimmermann-Gymnasium Landsberg am Lech","Gymnasium","Staatlich","Platanenstr. 2","86899","Landsberg","http://www.dzg-landsberg.de","direktorat@dzg-landsberg.de");
INSERT INTO schule_daten VALUES("146","1","Hans-Carossa-Gymnasium Landshut ","Gymnasium","Staatlich","Freyung 630a","84028","Landshut","http://www.carossa-gymnasium.de","carossagym@la-hcg.de");
INSERT INTO schule_daten VALUES("147","1","Hans-Leinberger-Gymnasium Landshut ","Gymnasium","Staatlich","J&uuml;rgen-Schumann-Str. 20","84034","Landshut","http://h-l-g.de","sekretariat@hans-leinberger-gymnasium.de");
INSERT INTO schule_daten VALUES("148","1","Gymnasium der Schulstiftung Seligenthal Landshut","Gymnasium","Privat","Bismarckplatz 14","84034","Landshut","http://www.gymnasium.seligenthal.de","seligenthal@seligenthal.de");
INSERT INTO schule_daten VALUES("149","1","Christoph-Jacob-Treu-Gymnasium Lauf a.d.Pegnitz","Gymnasium","Staatlich","Hardtstr. 37","91207","Lauf","http://www.cjt-gym-lauf.de","schule@cjt-gym-lauf.de");
INSERT INTO schule_daten VALUES("150","1","Rottmayr-Gymnasium Laufen ","Gymnasium","Staatlich","Barbarossastr. 16","83410","Laufen","http://www.rottmayr-gymnasium.de","direktorat@rottmayr-gymnasium.de");
INSERT INTO schule_daten VALUES("151","1","Albertus-Gymnasium Lauingen ","Gymnasium","Staatlich","Br&uuml;derstr. 10","89415","Lauingen","http://www.albertus-gymnasium.de","info@albertus-gymnasium.de");
INSERT INTO schule_daten VALUES("152","1","Gymnasium M&uuml;nchen-Trudering","Gymnasium","Staatlich","Friedenspromenade 64","81827","M&uuml;nchen","http://www.gymnasium-trudering.de","gymnasium-muenchen-trudering@muenchen.de");
INSERT INTO schule_daten VALUES("153","1","Meranier-Gymnasium Lichtenfels ","Gymnasium","Staatlich","Kronacher Str. 34","96215","Lichtenfels","http://www.meranier-gymnasium.de","mgl.verwaltung@meranier-gymnasium.de");
INSERT INTO schule_daten VALUES("154","1","Bodensee-Gymnasium Lindau ","Gymnasium","Staatlich","Reutiner Str. 14","88131","Lindau","http://www.bodensee-gymnasium.de","mail@bodensee-gymnasium.de");
INSERT INTO schule_daten VALUES("155","1","Valentin-Heider-Gymnasium Lindau ","Gymnasium","Staatlich","Ludwig-Kick-Str. 19","88131","Lindau","http://www.vhg-lindau.de","sekretariat@valentin-heider-gymnasium.de");
INSERT INTO schule_daten VALUES("156","1","Gymnasium Lindenberg i.Allg&auml;u ","Gymnasium","Staatlich","Blumenstr. 12","88161","Lindenberg","http://www.gymlindenberg.de","gymnasium@gymlindenberg.de");
INSERT INTO schule_daten VALUES("157","1","Franz-Ludwig-von-Erthal-Gymnasium Lohr","Gymnasium","Staatlich","N&auml;gelseestr. 8","97816","Lohr","http://www.flveg-lohr.de","sekretariat@flveg-lohr.de");
INSERT INTO schule_daten VALUES("158","1","Gabelsberger-Gymnasium Mainburg ","Gymnasium","Staatlich","Ebrantshauser Str. 70","84048","Mainburg","http://www.gabelsberger-gymnasium.de","verwaltung@gabelsberger-gymnasium.de");
INSERT INTO schule_daten VALUES("159","1","Gymnasium Marktbreit ","Gymnasium","Staatlich","Neue Obernbreiter Str. 21","97340","Marktbreit","http://www.gymnasium-marktbreit.de","mail@gymnasium-marktbreit.de");
INSERT INTO schule_daten VALUES("160","1","Gymnasium Marktoberdorf ","Gymnasium","Staatlich","M&uuml;hlsteig 23","87616","Marktoberdorf","http://www.gymnasium-marktoberdorf.de","verwaltung@gymnasium-marktoberdorf.de");
INSERT INTO schule_daten VALUES("161","1","Otto-Hahn-Gymnasium Marktredwitz ","Gymnasium","Staatlich","Schulstr. 10","95615","Marktredwitz","http://www.ohg-marktredwitz.de","direktorat@ohg-marktredwitz.de");
INSERT INTO schule_daten VALUES("162","1","Staatliches Landschulheim Marquartstein","Gymnasium","Staatlich","Neues Schlo&szlig; 1","83250","Marquartstein","http://www.lsh-marquartstein.de","kontakt@lsh-marquartstein.de");
INSERT INTO schule_daten VALUES("163","1","Martin-Pollich-Gymnasium Mellrichstadt","Gymnasium","Staatlich","Sonnenlandstr. 21","97638","Mellrichstadt","http://www.mpg-met.de","verwaltung@mpg-met.de");
INSERT INTO schule_daten VALUES("164","1","Bernhard-Strigel-Gymnasium Memmingen","Gymnasium","Staatlich","Wielandstr. 6","87700","Memmingen","http://www.bsg-memmingen.de","dir@bsg-mm.de");
INSERT INTO schule_daten VALUES("165","1","V&ouml;hlin-Gymnasium Memmingen ","Gymnasium","Staatlich","Kaisergraben 21","87700","Memmingen","http://www.voehlin.de","sekretariat@voehlin.de");
INSERT INTO schule_daten VALUES("166","1","St.-Michaels-Gymnasium der Benediktiner Metten","Gymnasium","Privat","Abteistr. 3","94526","Metten","http://www.kloster-metten.de","sekretariat@kloster-metten.de");
INSERT INTO schule_daten VALUES("167","1","Gymnasium Miesbach ","Gymnasium","Staatlich","Haidm&uuml;hlstr. 36","83714","Miesbach","http://www.gymb.de","sekretariat@gymb.de");
INSERT INTO schule_daten VALUES("168","1","Johannes-Butzbach-Gymnasium Miltenberg","Gymnasium","Staatlich","Martin-Vierengel-Str. 4","63897","Miltenberg","http://www.jbg-miltenberg.de","direktorat@jbg-miltenberg.de");
INSERT INTO schule_daten VALUES("169","1","Maristenkolleg Mindelheim -Gymnasium- des Schulwerks der Di&ouml;zese Augsburg ","Gymnasium","Privat","Champagnatplatz 1","87719","Mindelheim","http://www.maristenkolleg.de","gymnasium@maristenkolleg.de");
INSERT INTO schule_daten VALUES("170","1","Ignaz-Taschner-Gymnasium Dachau ","Gymnasium","Staatlich","Landsberger Str. 1","85221","Dachau","http://www.ignaz-taschner-gymnasium.de","sekretariat@ignaz-taschner-gymnasium.de");
INSERT INTO schule_daten VALUES("171","1","Christoph-Probst-Gymnasium Gilching","Gymnasium","Staatlich","Talhofstr. 7","82205","Gilching","http://www.cpg-gilching.de","sekretariat@cpg-gilching.de");
INSERT INTO schule_daten VALUES("172","1","Ruperti-Gymnasium M&uuml;hldorf a.Inn ","Gymnasium","Staatlich","Herzog-Friedrich-Str. 16-18","84453","M&uuml;hldorf","http://www.ruperti-gymnasium.de","sekretariat@ruperti-gymnasium.de");
INSERT INTO schule_daten VALUES("173","1","Gymnasium M&uuml;nchberg ","Gymnasium","Staatlich","Hofer Str. 41","95213","M&uuml;nchberg","http://www.gymnasium-muenchberg.de","info@gymnasium-muenchberg.de");
INSERT INTO schule_daten VALUES("174","1","Karlsgymnasium M&uuml;nchen-Pasing ","Gymnasium","Staatlich","Am Stadtpark 21","81243","M&uuml;nchen","http://www.karlsgymnasium.de","karlsgymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("175","1","Ludwigsgymnasium M&uuml;nchen ","Gymnasium","Staatlich","F&uuml;rstenrieder Str. 159a","81377","M&uuml;nchen","http://www.ludwigsgymnasium-muenchen.de","ludwigsgym@gmx.de");
INSERT INTO schule_daten VALUES("176","1","Maximiliansgymnasium M&uuml;nchen ","Gymnasium","Staatlich","Karl-Theodor-Str. 9","80803","M&uuml;nchen","http://www.maxgym.musin.de","max@maxgym.musin.de");
INSERT INTO schule_daten VALUES("177","1","Theresien-Gymnasium M&uuml;nchen ","Gymnasium","Staatlich","Kaiser-Ludwig-Platz 3","80336","M&uuml;nchen","http://www.thg.musin.de","theresien-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("178","1","Wilhelmsgymnasium M&uuml;nchen ","Gymnasium","Staatlich","Thierschstr. 46","80538","M&uuml;nchen","http://www.wilhelmsgymnasium.de","sekretariat@wig.musin.de");
INSERT INTO schule_daten VALUES("179","1","Wittelsbacher-Gymnasium M&uuml;nchen ","Gymnasium","Staatlich","Marsplatz 1","80335","M&uuml;nchen","http://www.wittelsbacher-gymnasium.de","kontakt@wittelsbacher-gymnasium.de");
INSERT INTO schule_daten VALUES("180","1","Albert-Einstein-Gymnasium M&uuml;nchen ","Gymnasium","Staatlich","Lautererstr. 2","81545","M&uuml;nchen","http://www.albert-einstein-gymnasium.com","albert-einstein-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("181","1","Oskar-von-Miller-Gymnasium M&uuml;nchen ","Gymnasium","Staatlich","Siegfriedstr. 22","80803","M&uuml;nchen","http://www.ovmg.de","ovmgm@t-online.de");
INSERT INTO schule_daten VALUES("182","1","Asam-Gymnasium M&uuml;nchen ","Gymnasium","Staatlich","Schlierseestr. 20","81539","M&uuml;nchen","http://www.asam-gymnasium.de","asam-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("183","1","Erasmus-Grasser-Gymnasium M&uuml;nchen ","Gymnasium","Staatlich","F&uuml;rstenrieder Str. 159","81377","M&uuml;nchen","http://www.dasegg.musin.de","egg@dasegg.musin.de");
INSERT INTO schule_daten VALUES("184","1","Gisela-Gymnasium M&uuml;nchen ","Gymnasium","Staatlich","Arcisstr. 65","80801","M&uuml;nchen","http://www.gisela-gymnasium.de","gisela-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("185","1","Klenze-Gymnasium M&uuml;nchen ","Gymnasium","Staatlich","Wackersberger Str. 59","81371","M&uuml;nchen","http://www.klenze-gymnasium.de","sekretariat@klg.musin.de");
INSERT INTO schule_daten VALUES("186","1","Luitpold-Gymnasium M&uuml;nchen ","Gymnasium","Staatlich","Seeaustr. 1","80538","M&uuml;nchen","http://www.luitpold-gymnasium.de","luitpold-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("187","1","Maria-Theresia-Gymnasium M&uuml;nchen ","Gymnasium","Staatlich","Regerplatz 1","81541","M&uuml;nchen","http://www.mtg.musin.de","maria-theresia-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("188","1","Max-Planck-Gymnasium M&uuml;nchen ","Gymnasium","Staatlich","Weinbergerstr. 29","81241","M&uuml;nchen","http://www.mpg-muenchen.de","sekretariat@mpg-muenchen.de");
INSERT INTO schule_daten VALUES("189","1","Rupprecht-Gymnasium M&uuml;nchen ","Gymnasium","Staatlich","Albrechtstr. 7","80636","M&uuml;nchen","http://www.rupprecht-gymnasium.de","info@rupprecht-gymnasium.de");
INSERT INTO schule_daten VALUES("190","1","Pestalozzi-Gymnasium M&uuml;nchen ","Gymnasium","Staatlich","Eduard-Schmid-Str. 1","81541","M&uuml;nchen","http://www.pgm.musin.de","pestalozzi-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("191","1","Max-Josef-Stift M&uuml;nchen ","Gymnasium","Staatlich","M&uuml;hlbaurstr. 15","81677","M&uuml;nchen","http://www.maxjosefstift.de","sekretariat@maxjosefstift.de");
INSERT INTO schule_daten VALUES("192","1","St&auml;dtisches Luisengymnasium M&uuml;nchen","Gymnasium","Staatlich","Luisenstr. 7","80333","M&uuml;nchen","http://www.staedtisches-luisengymnasium.de","luisengymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("193","1","St&auml;dtisches Elsa-Br&auml;ndstr&ouml;m- Gymnasium M&uuml;nchen","Gymnasium","Staatlich","Ebenb&ouml;ckstr. 1","81241","M&uuml;nchen","http://www.elsa.musin.de","elsa-braendstroem-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("194","1","St&auml;dtisches Louise-Schroeder Gymnasium M&uuml;nchen","Gymnasium","Staatlich","Pfarrer-Grimm-Str. 1","80999","M&uuml;nchen","http://www.lsg.musin.de","sekretariat@lsg.musin.de");
INSERT INTO schule_daten VALUES("195","1","St&auml;dtisches Sophie-Scholl- Gymnasium M&uuml;nchen","Gymnasium","Staatlich","Karl-Theodor-Str. 92","80796","M&uuml;nchen","http://www.ssg.musin.de","sophie-scholl-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("196","1","St&auml;dtisches Theodolinden-Gymnasium M&uuml;nchen","Gymnasium","Staatlich","Am Staudengarten 2","81547","M&uuml;nchen","http://www.tlg.musin.de","sekretariat@tlg.musin.de");
INSERT INTO schule_daten VALUES("197","1","St&auml;dtisches Willi-Graf-Gymnasium M&uuml;nchen","Gymnasium","Staatlich","Borschtallee 26","80804","M&uuml;nchen","http://www.wgg.musin.de","willi-graf-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("198","1","St&auml;dtisches Thomas-Mann-Gymnasium M&uuml;nchen","Gymnasium","Staatlich","Drygalski-Allee 2","81477","M&uuml;nchen","http://www.tmg.musin.de","thomas-mann-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("199","1","St&auml;dtisches St.-Anna-Gymnasium M&uuml;nchen","Gymnasium","Staatlich","St.-Anna-Str. 20","80538","M&uuml;nchen","http://www.sag.musin.de","st-anna-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("200","1","Michaeli-Gymnasium M&uuml;nchen ","Gymnasium","Staatlich","Hachinger-Bach-Str. 25","81671","M&uuml;nchen","http://www.michaeli-gymnasium.de","michaeli-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("201","1","St&auml;dtisches Adolf-Weber-Gymnasium M&uuml;nchen","Gymnasium","Staatlich","Kapschstr. 4","80636","M&uuml;nchen","http://www.awg.musin.de","adolf-weber-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("202","1","St&auml;dtisches K&auml;the-Kollwitz- Gymnasium M&uuml;nchen","Gymnasium","Staatlich","Nibelungenstr. 51a","80639","M&uuml;nchen","http://www.kkg.musin.de","kaethe-kollwitz-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("203","1","St&auml;dtisches Bertolt-Brecht- Gymnasium M&uuml;nchen","Gymnasium","Staatlich","Peslm&uuml;llerstr. 6","81243","M&uuml;nchen","http://www.bbg.musin.de","bertolt-brecht-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("204","1","Theresia-Gerhardinger-Gymnasium am Anger M&uuml;nchen","Gymnasium","Privat","Blumenstr. 26","80331","M&uuml;nchen","http://www.tggaa.de","info@tggaa.de");
INSERT INTO schule_daten VALUES("206","1","Maria-Ward-Schulen Nymphenburg der Erzdi&ouml;zese M&uuml;nchen und Freising","Gymnasium","Privat","Maria-Ward-Str. 5","80638","M&uuml;nchen","http://www.maria-ward-schulen.de","sekretariat@maria-ward-gymnasium.de");
INSERT INTO schule_daten VALUES("207","1","Edith-Stein-Gymnasium der Erzdi&ouml;zese M&uuml;nchen und Freising","Gymnasium","Privat","Preysingstr. 105","81667","M&uuml;nchen","http://www.esg-muenchen.de","Edith-Stein-Gymnasium@t-online.de");
INSERT INTO schule_daten VALUES("208","1","Nymphenburger Gymnasium M&uuml;nchen des Schulvereins Ernst Adam e.V.","Gymnasium","Privat","Sadelerstr. 10","80638","M&uuml;nchen","http://www.nymphenburger-schulen.de","ulrich.kretzinger@nymphenburger-schulen.de");
INSERT INTO schule_daten VALUES("209","1","Karl-Ritter-von-Frisch-Gymnasium Moosburg","Gymnasium","Staatlich","Albinstr. 5","85368","Moosburg","http://www.gymnasium-moosburg.de","info@gymnasium-moosburg.de");
INSERT INTO schule_daten VALUES("210","1","Obermenzinger Gymnasium M&uuml;nchen ","Gymnasium","Privat","Freseniusstr. 47-49","81247","M&uuml;nchen","http://www.obermenzinger.de","verwaltung@obermenzinger.de");
INSERT INTO schule_daten VALUES("211","1","Kleines privates Lehrinstitut Derksen M&uuml;nchen -Gymnasium-","Gymnasium","Privat","Pfingstrosenstr. 73","81377","M&uuml;nchen","http://www.obermenzinger.de/","verwaltung@obermenzinger.de");
INSERT INTO schule_daten VALUES("213","1","Gymnasium Gr&uuml;nwald","Gymnasium","Staatlich","Laufzorner Stra&szlig;e 1","82031","Gr&uuml;nwald","http://www.gymnasium-gruenwald.de/","&nbsp;sekretariat@gymnasium-gruenwald.de");
INSERT INTO schule_daten VALUES("214","1","Privatgymnasium Dr. Florian &Uuml;berreiter M&uuml;nchen","Gymnasium","Privat","Pariser Str. 30","81667","M&uuml;nchen","http://www.ueberreiter.de","verwaltung@ueberreiter.de");
INSERT INTO schule_daten VALUES("215","1","Joh.-Philipp-v.-Sch&ouml;nborn-Gymnasium M&uuml;nnerstadt","Gymnasium","Staatlich","Dr.-Ortloff-Weg 1","97702","M&uuml;nnerstadt","http://ueberreiter.rtrk.de/","verwaltung@ueberreiter.de");
INSERT INTO schule_daten VALUES("216","1","Egbert-Gymnasium d. Benediktiner M&uuml;nsterschwarzach","Gymnasium","Privat","Schweinfurter Str. 40","97359","Schwarzach","http://www.egbert-gymnasium.de","info@Egbert-Gymnasium.de");
INSERT INTO schule_daten VALUES("217","1","Staffelsee-Gymnasium Murnau ","Gymnasium","Staatlich","Weindorfer Str. 20","82418","Murnau","http://www.staffelsee-gymnasium.de","sekretariat@sgmu.de");
INSERT INTO schule_daten VALUES("218","1","Johann-Andreas-Schmeller-Gymnasium Nabburg","Gymnasium","Staatlich","Eichenweg 3","92507","Nabburg","http://www.jas-gymnasium.de","sekretariat@gymnasium-nabburg.de");
INSERT INTO schule_daten VALUES("219","1","Hochfranken-Gymnasium Naila ","Gymnasium","Staatlich","Finkenweg 15","95119","Naila","http://www.gymnaila.eu","mail@gymnaila.eu");
INSERT INTO schule_daten VALUES("220","1","Schlo&szlig; Neubeuern - Gymnasium Internatsschule f&uuml;r M&auml;dchen und Jungen ","Gymnasium","Privat","Schlo&szlig;","83115","Neubeuern","http://www.schloss-neubeuern.de","info@schloss-neubeuern.de");
INSERT INTO schule_daten VALUES("221","1","Descartes-Gymnasium Neuburg a.d.Donau","Gymnasium","Staatlich","Frauenplatz B 88","86633","Neuburg","http://www.schloss-neubeuern.de/","info@schloss-neubeuern.de");
INSERT INTO schule_daten VALUES("222","1","Laurentius-Gymnasium des Evang.-Luth. Diakoniewerkes Neuendettelsau ","Gymnasium","Privat","Waldsteig 9","91564","Neuendettelsau","http://www.laurentius-gymnasium.de","sekretariat.gymnasium@DiakonieNeuendettelsau.de");
INSERT INTO schule_daten VALUES("223","1","Willibald-Gluck-Gymnasium Neumarkt ","Gymnasium","Staatlich","Dr.-Grundler-Str. 7","92318","Neumarkt","http://www.wgg-neumarkt.de","verwaltung@wgg-neumarkt.de");
INSERT INTO schule_daten VALUES("224","1","Justus-von-Liebig-Gymnasium Neus&auml;&szlig; ","Gymnasium","Staatlich","Landrat-Dr.-Frey-Str. 4","86356","Neus&auml;&szlig;","http://www.jvlgym.de","sekretariat@gymneusaess.de");
INSERT INTO schule_daten VALUES("225","1","Friedrich-Alexander-Gymnasium Neustadt a.d.Aisch","Gymnasium","Staatlich","Comeniusstr. 4","91413","Neustadt","http://www.fag-neustadt-aisch.de","verwaltung@fag-neustadt-aisch.de");
INSERT INTO schule_daten VALUES("226","1","Arnold-Gymnasium Neustadt bei Coburg","Gymnasium","Staatlich","Pestalozzistr. 10","96465","Neustadt","http://www.arnold-gymnasium.de","verwaltung@arnold-gymnasium.de");
INSERT INTO schule_daten VALUES("227","1","Lessing-Gymnasium Neu-Ulm ","Gymnasium","Staatlich","Augsburger Str. 75","89231","Neu-Ulm","http://www.lessing.schule.neu-ulm.de","post@lessing.schule.neu-ulm.de");
INSERT INTO schule_daten VALUES("228","1","St.-Gotthard-Gymnasium der Benediktiner Niederalteich","Gymnasium","Privat","Hengersberger Str. 19","94557","Niederalteich","http://www.st-gotthard-gymnasium.de","st.-gotthard-gymnasium@t-online.de");
INSERT INTO schule_daten VALUES("229","1","Regental-Gymnasium Nittenau ","Gymnasium","Staatlich","Jahnweg 22","93149","Nittenau","http://www.regental-gymnasium.de","sekretariat@regental-gymnasium.de");
INSERT INTO schule_daten VALUES("230","1","Theodor-Heuss-Gymnasium N&ouml;rdlingen ","Gymnasium","Staatlich","Sch&auml;ufelinstr. 8","86720","N&ouml;rdlingen","http://www.thg-noe.de","info@thg-noe.de");
INSERT INTO schule_daten VALUES("231","1","Melanchthon-Gymnasium N&uuml;rnberg ","Gymnasium","Staatlich","Sulzbacher Str. 32","90489","N&uuml;rnberg","http://www.melanchthon-gymnasium.de","direktor@melanchthon-gymnasium.de");
INSERT INTO schule_daten VALUES("232","1","Neues Gymnasium N&uuml;rnberg ","Gymnasium","Staatlich","Weddigenstr. 21","90478","N&uuml;rnberg","http://www.ngn-online.de","ngn-nbg@ngn-online.de");
INSERT INTO schule_daten VALUES("233","1","Willst&auml;tter-Gymnasium N&uuml;rnberg ","Gymnasium","Staatlich","Innerer Laufer Platz 11","90403","N&uuml;rnberg","http://www.willstaetter-gymnasium.de","schulleitung@willstaetter-gymnasium.de");
INSERT INTO schule_daten VALUES("234","1","D&uuml;rer-Gymnasium N&uuml;rnberg ","Gymnasium","Staatlich","Sielstr. 17","90429","N&uuml;rnberg","http://www.duerer-gymnasium.de","sekretariat@duerer-gymnasium.de");
INSERT INTO schule_daten VALUES("235","1","Hans-Sachs-Gymnasium N&uuml;rnberg ","Gymnasium","Staatlich","L&ouml;bleinstr. 10","90409","N&uuml;rnberg","http://www.hans-sachs-gymnasium.de","sekretariat@hans-sachs-gymnasium.de");
INSERT INTO schule_daten VALUES("236","1","Martin-Behaim-Gymnasium N&uuml;rnberg ","Gymnasium","Staatlich","Schulthei&szlig;allee 1","90478","N&uuml;rnberg","http://www.martin-behaim-gymnasium.de","mbg@martin-behaim-gymnasium.de");
INSERT INTO schule_daten VALUES("237","1","Pirckheimer-Gymnasium N&uuml;rnberg ","Gymnasium","Staatlich","Gibitzenhofstr. 151","90443","N&uuml;rnberg","http://www.pirckheimer-gymnasium.de","sekretariat@pirckheimer-gymnasium.de");
INSERT INTO schule_daten VALUES("238","1","St&auml;dtisches Labenwolf-Gymnasium N&uuml;rnberg","Gymnasium","Staatlich","Labenwolfstr. 10","90409","N&uuml;rnberg","http://www.labenwolf.de","labenwolf-gymnasium@stadt.nuernberg.de");
INSERT INTO schule_daten VALUES("239","1","St&auml;dtisches Sigena-Gymnasium N&uuml;rnberg","Gymnasium","Staatlich","Gibitzenhofstr. 135","90443","N&uuml;rnberg","http://www.sigena-gymnasium.de","sigena-gymnasium@stadt.nuernberg.de");
INSERT INTO schule_daten VALUES("240","1","St&auml;dtisches Johannes-Scharrer- Gymnasium N&uuml;rnberg","Gymnasium","Staatlich","Tetzelgasse 20","90403","N&uuml;rnberg","http://www.jsg-nuernberg.de","jsg-sekretariat@stadt.nuernberg.de");
INSERT INTO schule_daten VALUES("241","1","St&auml;dtische Peter-Vischer-Schule N&uuml;rnberg -Gymnasium-","Gymnasium","Staatlich","Bielingplatz 2","90419","N&uuml;rnberg","http://www.jsg-nuernberg.de/","jsg-sekretariat@stadt.nuernberg.de");
INSERT INTO schule_daten VALUES("242","1","Maria-Ward-Gymnasium N&uuml;rnberg ","Gymnasium","Privat","Ke&szlig;lerplatz 2","90489","N&uuml;rnberg","http://www.mwgym.de","mwgym@mwgym.de");
INSERT INTO schule_daten VALUES("243","1","Wilhelm-L&ouml;he-Schule N&uuml;rnberg Evang. kooperative Gesamtschule -Gymnasium- ","Gymnasium","Privat","Deutschherrnstr. 10","90429","N&uuml;rnberg","http://www.loehe-schule.de","r.geissdoerfer@loehe-schule.de");
INSERT INTO schule_daten VALUES("245","1","Dietrich-Bonhoeffer-Gymnasium Oberasbach","Gymnasium","Staatlich","Albrecht-D&uuml;rer-Str. 9-11","90522","Oberasbach","http://www.gym-oberasbach.de","verwaltung@gym-oberasbach.de");
INSERT INTO schule_daten VALUES("246","1","Gertrud-von-le-Fort-Gymnasium Oberstdorf","Gymnasium","Staatlich","Rubinger Str. 8","87561","Oberstdorf","http://www.gymnasium-oberstdorf.com","info@gymnasium-oberstdorf.de");
INSERT INTO schule_daten VALUES("247","1","Ortenburg-Gymnasium Oberviechtach ","Gymnasium","Staatlich","Jahnstr. 18","92526","Oberviechtach","http://www.ortenburg-gymnasium.de","sekretariat@ortenburg-gymnasium.de");
INSERT INTO schule_daten VALUES("248","1","Albrecht-Ernst-Gymnasium Oettingen ","Gymnasium","Staatlich","Goethestr. 36","86732","Oettingen","http://www.gymnasiumoettingen.de","verwaltung@gymnasiumoettingen.de");
INSERT INTO schule_daten VALUES("249","1","Rupert-Ness-Gymnasium Ottobeuren","Gymnasium","Staatlich","Bergstr. 80","87724","Ottobeuren","http://www.gym-rs-ottobeuren.de","schulleitung@gym-rs-ottobeuren.de");
INSERT INTO schule_daten VALUES("250","1","Gymnasium Ottobrunn ","Gymnasium","Staatlich","Karl-Stieler-Str. 1","85521","Ottobrunn","http://www.gymnasium-ottobrunn.de","sekr@gymnasium-ottobrunn.de");
INSERT INTO schule_daten VALUES("251","1","Gymnasium Leopoldinum Passau ","Gymnasium","Staatlich","Michaeligasse 15","94032","Passau","http://www.leopoldinum-passau.de","info@leopoldinum-passau.de");
INSERT INTO schule_daten VALUES("252","1","Adalbert-Stifter-Gymnasium Passau ","Gymnasium","Staatlich","Innstr. 69","94032","Passau","http://asg-passau.de","info@asg-passau.de");
INSERT INTO schule_daten VALUES("253","1","Gisela-Gymnasium Passau-Niedernburg","Gymnasium","Privat","Klosterwinkel 1","94032","Passau","http://www.gisela-schulen.de","info@gisela-schulen.de");
INSERT INTO schule_daten VALUES("254","1","Auersperg-Gymnasium der Maria-Ward-Schulstiftung Passau Freudenhain Mus. und wirtschaftswiss. Gymnasium","Gymnasium","Privat","Freudenhain 2","94034","Passau","http://www.freudenhain.de","info@mariaward-schulstiftung-passau.de");
INSERT INTO schule_daten VALUES("255","1","Gymnasium Pegnitz ","Gymnasium","Staatlich","Wilhelm-von-Humboldt-Str. 7","91257","Pegnitz","http://www.gympeg.de","sek@gympeg.de");
INSERT INTO schule_daten VALUES("256","1","Schyren-Gymnasium Pfaffenhofen a.d.Ilm","Gymnasium","Staatlich","Niederscheyerer Str. 4","85276","Pfaffenhofen","http://www.schyren-gymnasium.de","kontakt@schyren-gymnasium.de");
INSERT INTO schule_daten VALUES("257","1","Gymnasium Pfarrkirchen ","Gymnasium","Staatlich","Arnstorfer Str. 9","84347","Pfarrkirchen","http://www.gympan.de","sekretariat@gympan.de&nbsp;");
INSERT INTO schule_daten VALUES("259","1","Wilhelm-Diess-Gymnasium Pocking ","Gymnasium","Staatlich","Dr.-Karl-Wei&szlig;-Platz 2","94060","Pocking","http://www.wdg-pocking.de","schule@wdg-pocking.de");
INSERT INTO schule_daten VALUES("260","1","Ludwig-Thoma-Gymnasium Prien ","Gymnasium","Staatlich","Seestr. 25b","83209","Prien","http://www.ltgprien.de","sekretariat@ltgprien.de");
INSERT INTO schule_daten VALUES("261","1","Gymnasium Pullach ","Gymnasium","Staatlich","Hans-Keis-Str. 61","82049","Pullach","http://www.opg-pullach.de","sekretariat@opg-pullach.de");
INSERT INTO schule_daten VALUES("262","1","Pater-Rupert-Mayer-Gymnasium Pullach der Erzdi&ouml;zese M&uuml;nchen und Freising ","Gymnasium","Privat","Wolfratshauser Str. 30","82049","Pullach","http://www.prmg.de","info@prmg.de");
INSERT INTO schule_daten VALUES("263","1","Albertus-Magnus-Gymnasium Regensburg","Gymnasium","Staatlich","Hans-Sachs-Str. 2","93049","Regensburg","http://www.schulen.regensburg.de","poststelle@rosenheim.de");
INSERT INTO schule_daten VALUES("264","1","Albrecht-Altdorfer-Gymnasium Regensburg","Gymnasium","Staatlich","Minoritenweg 33","93047","Regensburg","http://www.schulen.regensburg.de","poststelle@rosenheim.de");
INSERT INTO schule_daten VALUES("265","1","Goethe-Gymnasium Regensburg ","Gymnasium","Staatlich","Goethestr. 1","93049","Regensburg","http://www.schulen.regensburg.de","poststelle@rosenheim.de");
INSERT INTO schule_daten VALUES("266","1","Werner-von-Siemens-Gymnasium Regensburg","Gymnasium","Staatlich","Brennesstr. 4","93059","Regensburg","http://www.siemensgymnasium.de","siemensgymnasium@regensburg.de");
INSERT INTO schule_daten VALUES("267","1","St&auml;dtisches von-M&uuml;ller-Gymnasium Regensburg","Gymnasium","Staatlich","Erzbischof-Buchberger-Allee 21","93051","Regensburg","http://www.schulen.regensburg.de","poststelle@rosenheim.de");
INSERT INTO schule_daten VALUES("268","1","St.-Marien-Gymnasium der Schulstiftung der Di&ouml;zese Regensburg ","Gymnasium","Privat","Helenenstr. 2","93047","Regensburg","http://www.st-marien-schulen-regensburg.de","gymnasium@st-marien-schulen-regensburg.de");
INSERT INTO schule_daten VALUES("269","1","Musikgymnasium der Regensburger Domspatzen","Gymnasium","Privat","Reichsstr. 22","93055","Regensburg","http://www.domspatzen.de","gymnasium@domspatzen.de");
INSERT INTO schule_daten VALUES("270","1","Schlo&szlig; Reichersbeuern Max-Rill-Schule e.V. Staatl. anerk. neusprachl. und sozialwiss. Gymnasium","Gymnasium","Privat","Schlo&szlig;weg 1-11","83677","Reichersbeuern","http://www.max-rill-schule.de","carmen.mendez@max-rill-gym.de");
INSERT INTO schule_daten VALUES("272","1","Johannes-Nepomuk-Gymnasium der Benediktiner Rohr","Gymnasium","Privat","Abt-Dominik-Prokop-Platz 1","93352","Rohr","http://www.jngrohr.de","sekretariat@jngrohr.de");
INSERT INTO schule_daten VALUES("273","1","Ignaz-G&uuml;nther-Gymnasium Rosenheim ","Gymnasium","Staatlich","Prinzregentenstr. 32","83022","Rosenheim","http://www.schulen.rosenheim.de","poststelle@rosenheim.de");
INSERT INTO schule_daten VALUES("274","1","Finsterwalder-Gymnasium Rosenheim ","Gymnasium","Staatlich","K&ouml;nigstr. 25","83022","Rosenheim","http://www.finsterwalder-gymnasium.de","fwg@schulen.rosenheim.de");
INSERT INTO schule_daten VALUES("275","1","Karolinen-Gymnasium Rosenheim ","Gymnasium","Staatlich","Ebersberger Str. 3","83022","Rosenheim","http://www.schulen.rosenheim.de","poststelle@rosenheim.de");
INSERT INTO schule_daten VALUES("276","1","Gymnasium Roth ","Gymnasium","Staatlich","Brentwoodstr. 4","91154","Roth","http://www.gymnasium-roth.de","verwaltung@gymnasium-roth.de");
INSERT INTO schule_daten VALUES("277","1","Reichsstadt-Gymnasium Rothenburg o.d.Tauber","Gymnasium","Staatlich","Dinkelsb&uuml;hler Str. 5","91541","Rothenburg","http://www.rsg.rothenburg.de","direktorat@rsg.rothenburg.de");
INSERT INTO schule_daten VALUES("278","1","Rhabanus-Maurus-Gymnasium Sankt Ottilien des Schulwerks der Di&ouml;zese Augsburg ","Gymnasium","Privat","Kloster","86941","Sankt Ottilien","http://www.gym.ottilien.de","gymnasium@ottilien.de");
INSERT INTO schule_daten VALUES("279","1","Gymnasium Scheinfeld ","Gymnasium","Staatlich","Landwehrstr. 11","91443","Scheinfeld","http://www.gymnasium-scheinfeld.de","Sekretariat@Gymnasium-Scheinfeld.de");
INSERT INTO schule_daten VALUES("280","1","Welfen-Gymnasium Schongau ","Gymnasium","Staatlich","Dornauer Weg 21","86956","Schongau","http://www.welfen-gymnasium.de","sekretariat@welfen-gymnasium.de");
INSERT INTO schule_daten VALUES("281","1","Gymnasium Schrobenhausen ","Gymnasium","Staatlich","Georg-Leinfelder-Str. 14","86529","Schrobenhausen","http://www.gymsob.de","direktorat.gymnasium@neusob.de");
INSERT INTO schule_daten VALUES("282","1","Adam-Kraft-Gymnasium Schwabach ","Gymnasium","Staatlich","Bismarckstr. 6","91126","Schwabach","http://www.akg-schwabach.de","Info@AKG-Schwabach.de");
INSERT INTO schule_daten VALUES("283","1","Wolfram-von-Eschenbach-Gymnasium Schwabach","Gymnasium","Staatlich","Haydnstr. 1","91126","Schwabach","http://weg-schwabach.de","sekretariat@weg-schwabach.de");
INSERT INTO schule_daten VALUES("284","1","Carl-Friedrich-Gau&szlig;-Gymnasium Schwandorf","Gymnasium","Staatlich","Kreuzbergstr. 20","92421","Schwandorf","http://www.c-f-g.de","schulleitung@c-f-g.de");
INSERT INTO schule_daten VALUES("285","1","Bertha-von-Suttner-Gymnasium Neu-Ulm","Gymnasium","Staatlich","Heerstr. 117","89233","Neu-Ulm","http://www.bvsg-nu.de","verwaltung@bvsg-nu.de");
INSERT INTO schule_daten VALUES("287","1","Celtis-Gymnasium Schweinfurt ","Gymnasium","Staatlich","Gymnasiumstr. 15","97421","Schweinfurt","http://www.celtis.de","direktorat@celtis.de");
INSERT INTO schule_daten VALUES("288","1","Alexander-von-Humboldt-Gymnasium Schweinfurt","Gymnasium","Staatlich","Geschwister-Scholl-Str. 4","97424","Schweinfurt","http://www.avhsw.de","humboldt-gymnasium@schweinfurt.de");
INSERT INTO schule_daten VALUES("289","1","Olympia-Morata-Gymnasium Schweinfurt","Gymnasium","Staatlich","Ignaz-Sch&ouml;n-Str. 9","97421","Schweinfurt","http://www.olympia-morata-gymnasium.de","omg@schweinfurt.de");
INSERT INTO schule_daten VALUES("290","1","St&auml;dt. Walther-Rathenau-Gymnasium Schweinfurt","Gymnasium","Staatlich","Ignaz-Sch&ouml;n-Str. 7","97421","Schweinfurt","http://www.walther-rathenau-sw.de","wrg.wrr@schweinfurt.de");
INSERT INTO schule_daten VALUES("291","1","Walter-Gropius-Gymnasium Selb ","Gymnasium","Staatlich","Hohenberger Str. 90","95100","Selb","http://www.wggselb.de","sl@wggselb.de");
INSERT INTO schule_daten VALUES("294","1","Gymnasium Sonthofen ","Gymnasium","Staatlich","Albert-Schweitzer-Str. 21","87527","Sonthofen","http://www.gymnasium-sonthofen.de","sekretariat@gymnasium-sonthofen.de");
INSERT INTO schule_daten VALUES("295","1","Gymnasium Starnberg ","Gymnasium","Staatlich","Rheinlandstr. 2","82319","Starnberg","http://www.gymnasium-sonthofen.de/","sekretariat@gymnasium-sonthofen.de");
INSERT INTO schule_daten VALUES("296","1","Schule Schlo&szlig; Stein e.V. Staatl. anerk. neusprachl. und wirtschaftswiss. Gymnasium Internat f&uuml;r Jungen und M&auml;dchen","Gymnasium","Privat","Schlo&szlig;hof 4","83371","Stein a.d.Traun","http://www.schule-schloss-stein.de","info@schule-schloss-stein.de");
INSERT INTO schule_daten VALUES("297","1","Johannes-Turmair-Gymnasium Straubing","Gymnasium","Staatlich","Am Petersw&ouml;hrd 5","94315","Straubing","http://www.turmair-gymnasium.de","direktorat@turmair-gymnasium.de");
INSERT INTO schule_daten VALUES("298","1","Ludwigsgymnasium Straubing ","Gymnasium","Staatlich","Max-Planck-Str. 25","94315","Straubing","http://www.ludwigsgymnasium.de","info@ludwigsgymnasium.de");
INSERT INTO schule_daten VALUES("299","1","Anton-Bruckner-Gymnasium Straubing ","Gymnasium","Staatlich","Hans-Adlhoch-Str. 23","94315","Straubing","http://www.dasbruckner.de","schule@dasbruckner.de");
INSERT INTO schule_daten VALUES("300","1","Gymnasium d.Ursulinen-Schulstiftung Straubing","Gymnasium","Privat","Burggasse 40","94315","Straubing","http://www.ursulinen-straubing.de","gymnasium@ursulinen-straubing.de");
INSERT INTO schule_daten VALUES("301","1","Herzog-Christian-August-Gymnasium Sulzbach-Rosenberg","Gymnasium","Staatlich","Blumenaustr. 1","92237","Sulzbach-Rosenberg","http://www.hca-gymnasium.de","sekretariat@hca-gymnasium.de");
INSERT INTO schule_daten VALUES("302","1","Gymnasium Tegernsee ","Gymnasium","Staatlich","Schlo&szlig;platz 1c","83684","Tegernsee","http://www.gymnasium-tegernsee.de","Gymnasium.Tegernsee@t-online.de");
INSERT INTO schule_daten VALUES("303","1","Stiftland-Gymnasium Tirschenreuth ","Gymnasium","Staatlich","Stiftlandring 1","95643","Tirschenreuth","http://www.stiftland-gymnasium.de","sekretariat@stiftland-gymnasium.de");
INSERT INTO schule_daten VALUES("304","1","Gymnasium Puchheim ","Gymnasium","Staatlich","Bgm.-Ertl-Str. 11","82178","Puchheim","http://www.gymnasium-puchheim.de","poststelle@lra-ffb.de");
INSERT INTO schule_daten VALUES("305","1","Johannes-Heidenhain-Gymnasium Traunreut","Gymnasium","Staatlich","Adalbert-Stifter-Str. 36","83301","Traunreut","http://www.jhg-traunreut.de","sekretariat@jhg.bayern.de");
INSERT INTO schule_daten VALUES("306","1","Chiemgau-Gymnasium Traunstein ","Gymnasium","Staatlich","Brunnwiese 1","83278","Traunstein","http://www.chgtraunstein.de","sekretariat@chg.bayern.de");
INSERT INTO schule_daten VALUES("307","1","Annette-Kolb-Gymnasium Traunstein ","Gymnasium","Staatlich","G&uuml;terhallenstr. 12","83278","Traunstein","http://www.akg-traunstein.de","sekretariat@akg-traunstein.de");
INSERT INTO schule_daten VALUES("308","1","Hertzhaimer-Gymnasium Trostberg ","Gymnasium","Staatlich","Stefan-G&uuml;nthner-Weg 6","83308","Trostberg","http://www.hertzhaimer-gymnasium.de","sekretariat@hertzhaimer-gymnasium.de");
INSERT INTO schule_daten VALUES("309","1","Gymnasium Tutzing ","Gymnasium","Staatlich","Hauptstr. 20-22","82327","Tutzing","http://www.gymtutzing.de","info@gym-tutzing.de");
INSERT INTO schule_daten VALUES("310","1","Landschulheim Elkofen, naturwiss.- techn. Gymnasium z.sonderp&auml;d.F&ouml;rd., F&ouml;rderschwerp.soz.u.emot.Entwickl., Grafing d.SchulCentr.August.gGmbH","Gymnasium","Privat","Leitenstr. 2","85567","Grafing","www.augustinum-schulen.de","sekretariat@augustinum.de");
INSERT INTO schule_daten VALUES("311","1","Christian-von-Bomhard-Schule Uffenheim Evangelische Heimschule - Gymnasium -","Gymnasium","Privat","Im Kr&auml;mersgarten 10","97215","Uffenheim","http://www.bomhardschule.de","bomhard-schule@odn.de");
INSERT INTO schule_daten VALUES("312","1","Gymnasium Untergriesbach ","Gymnasium","Staatlich","Bgm.-Kainz-Str. 12","94107","Untergriesbach","http://www.gymnasium-untergriesbach.de","sekretariat@gymnasium-untergriesbach.de&nbsp;");
INSERT INTO schule_daten VALUES("313","1","Gymnasium der Benediktiner Sch&auml;ftlarn","Gymnasium","Privat","Kloster Sch&auml;ftlarn","82067","Sch&auml;ftlarn","http://www.abtei-schaeftlarn.de","gymnasium@abtei-schaeftlarn.de");
INSERT INTO schule_daten VALUES("314","1","Ernst-Reisinger-Schule Schondorf staatl. anerk. Gymnasium mit neusprachl., wirtschafts- und sozialwissenschaftl. Zweig","Gymnasium","Privat","Landheimstr. 1","86938","Schondorf","http://www.landheim-schondorf.de","landheim@landheim-schondorf.de");
INSERT INTO schule_daten VALUES("315","1","Ringeisen-Gymnasium der St. Josefskongregation Ursberg","Gymnasium","Privat","Josefsplatz 1","86513","Ursberg","http://www.ringeisen-gymnasium.de","sekretariat@ringeisen-gymnasium.de");
INSERT INTO schule_daten VALUES("316","1","Dominicus-von-Linprun-Gymnasium Viechtach","Gymnasium","Staatlich","Jahnstr. 36","94234","Viechtach","http://www.gymnasium-viechtach.de","sekretariat@gymnasium-viechtach.de&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
INSERT INTO schule_daten VALUES("317","1","Gymnasium Vilshofen ","Gymnasium","Staatlich","Prof.-Scharrer-Str. 19","94474","Vilshofen","http://www.gym-vilshofen.de","sekretariat@gym-vilshofen.de");
INSERT INTO schule_daten VALUES("318","1","Johannes-Gutenberg-Gymnasium Waldkirchen","Gymnasium","Staatlich","Schulstr. 2","94065","Waldkirchen","http://www.jgg-waldkirchen.de","sekretariat@jgg-waldkirchen.de");
INSERT INTO schule_daten VALUES("319","1","Luitpold-Gymnasium Wasserburg ","Gymnasium","Staatlich","Salzburger Str. 11","83512","Wasserburg","http://www.gymnasium.wasserburg.de","verwaltung@gymnasium.wasserburg.de");
INSERT INTO schule_daten VALUES("320","1","Augustinus-Gymnasium Weiden ","Gymnasium","Staatlich","Sebastianstr. 28","92637","Weiden","http://www.augustinus-gymnasium.de","info@augustinus-gymnasium.de");
INSERT INTO schule_daten VALUES("321","1","Kepler-Gymnasium Weiden ","Gymnasium","Staatlich","Friedrich-Ebert-Str. 21","92637","Weiden","http://www.kepler-weiden.de","sekretariat@kepler-weiden.de");
INSERT INTO schule_daten VALUES("322","1","Elly-Heuss-Gymnasium Weiden ","Gymnasium","Staatlich","Weigelstr. 26","92637","Weiden","http://www.ehg-wen.de","sekretariat@ehg-wen.de");
INSERT INTO schule_daten VALUES("323","1","Gymnasium Weilheim i.OB Sprachliches/Humanistisches und Naturwissenschaftlich-Technolog. Gymnasium","Gymnasium","Staatlich","Murnauer Str. 12","82362","Weilheim","http://www.gymnasium-weilheim.de","verwaltung@gymweilheim.de");
INSERT INTO schule_daten VALUES("324","1","Werner-von-Siemens-Gymnasium Wei&szlig;enburg","Gymnasium","Staatlich","An der Hagenau 24","91781","Wei&szlig;enburg","http://www.wvsgym.de","mail@wvsgym.de");
INSERT INTO schule_daten VALUES("325","1","Nikolaus-Kopernikus-Gymnasium Wei&szlig;enhorn","Gymnasium","Staatlich","Buchenweg 22","89264","Wei&szlig;enhorn","http://www.gymnasium-weissenhorn.de","sekretariat@gymnasium-weissenhorn.de");
INSERT INTO schule_daten VALUES("327","1","St.-Thomas-Gymnasium Wettenhausen d. Schulwerks d. Di&ouml;zese Augsburg","Gymnasium","Privat","St.-Thomas-Weg 2","89358","Kammeltal","http://www.thomas-gymnasium.de","thomas-gymnasium@gmx.net");
INSERT INTO schule_daten VALUES("329","1","Steigerwald-Landschulheim Wiesentheid des Zweckverbands Bayerische Landschulheime ","Gymnasium","Staatlich","Hans-Zander-Platz 1","97353","Wiesentheid","http://www.lsh-wiesentheid.de","sekretariat@lsh-wiesentheid.de");
INSERT INTO schule_daten VALUES("330","1","Johann-Sebastian-Bach-Gymnasium Windsbach - Musikgymnasium -","Gymnasium","Staatlich","Moosbacher Str. 9","91575","Windsbach","http://www.jsbg.de","sekretariat@jsbg.de");
INSERT INTO schule_daten VALUES("331","1","Sp&auml;tberufenengymnasium des Erzbisch&ouml;fl.Sp&auml;tberufenenseminars St. Matthias Wolfratshausen ","Gymnasium","Privat","Seminarplatz 3","82515","Wolfratshausen","http://www.sankt-matthias.de","info@sankt-matthias.de");
INSERT INTO schule_daten VALUES("332","1","Riemenschneider-Gymnasium W&uuml;rzburg ","Gymnasium","Staatlich","Rennweger Ring 12","97070","W&uuml;rzburg","http://www.riemenschneider-gymnasium.de","kontakt@riemenschneider-gymnasium.de");
INSERT INTO schule_daten VALUES("333","1","Wirsberg-Gymnasium W&uuml;rzburg ","Gymnasium","Staatlich","Am Pleidenturm 16","97070","W&uuml;rzburg","http://www.wirsberg-gymnasium.de","sekretariat@wirsberg-gymnasium.de");
INSERT INTO schule_daten VALUES("334","1","Siebold-Gymnasium W&uuml;rzburg ","Gymnasium","Staatlich","Rennweger Ring 11","97070","W&uuml;rzburg","http://www.siebold-gymnasium.de","info@siebold-gymnasium.de");
INSERT INTO schule_daten VALUES("335","1","R&ouml;ntgen-Gymnasium W&uuml;rzburg ","Gymnasium","Staatlich","Sanderring 8","97070","W&uuml;rzburg","http://www.roentgen-gym.de","mail@roentgen-gym.de");
INSERT INTO schule_daten VALUES("336","1","Matthias-Gr&uuml;newald-Gymnasium W&uuml;rzburg","Gymnasium","Staatlich","Zwerchgraben 1","97074","W&uuml;rzburg","http://www.mggw-online.de","mail@mggw-online.de");
INSERT INTO schule_daten VALUES("339","1","St.-Ursula-Schule der Ursulinen W&uuml;rzburg - Gymnasium -","Gymnasium","Privat","Augustinerstr. 17","97070","W&uuml;rzburg","http://www.st-ursula-schule-wuerzburg.de","sr.rut@st-ursula-schule-wuerzburg.de");
INSERT INTO schule_daten VALUES("340","1","Luisenburg-Gymnasium Wunsiedel ","Gymnasium","Staatlich","Burggraf-Friedrich-Str. 9","95632","Wunsiedel","http://www.lugy.de","gymnasium@lugy.de");
INSERT INTO schule_daten VALUES("341","1","Gymnasium Zwiesel ","Gymnasium","Staatlich","Dr.-Schott-Str. 54","94227","Zwiesel","http://www.gymnasium-zwiesel.de","sekretariat@gymnasium-zwiesel.de");
INSERT INTO schule_daten VALUES("342","1","Julius-Echter-Gymnasium Elsenfeld ","Gymnasium","Staatlich","Dammsfeldstr. 20","63820","Elsenfeld","http://www.julius-echter-gymnasium.de","verwaltung@julius-echter-gymnasium.de");
INSERT INTO schule_daten VALUES("343","1","Joseph-Bernhart-Gymnasium T&uuml;rkheim ","Gymnasium","Staatlich","Irsinger Str. 7","86842","T&uuml;rkheim","http://www.gymnasium-tuerkheim.de","jbg-tuerkheim@t-online.de");
INSERT INTO schule_daten VALUES("353","1","Bilinguales Gymnasium Phorms M&uuml;nchen","Gymnasium","Privat","Maria-Theresia-Str. 35","81675","M&uuml;nchen","http://muenchen.phorms.de","muenchen@phorms.de");
INSERT INTO schule_daten VALUES("354","1","Dante-Gymnasium M&uuml;nchen ","Gymnasium","Staatlich","Wackersberger Str. 61","81371","M&uuml;nchen","http://www.dante-gymnasium.de","&nbsp;dante-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("355","1","Wilhelm-Hausenstein-Gymnasium M&uuml;nchen","Gymnasium","Staatlich","Elektrastr. 61","81925","M&uuml;nchen","http://www.whg.musin.de","sekretariat@whg.musin.de");
INSERT INTO schule_daten VALUES("356","1","Veit-H&ouml;ser-Gymnasium Bogen ","Gymnasium","Staatlich","Wittelsbacherstr. 4","94327","Bogen","http://www.vhg-bogen.de","sekretariat@vhg-bogen.de");
INSERT INTO schule_daten VALUES("357","1","Robert-Koch-Gymnasium Deggendorf ","Gymnasium","Staatlich","Egger Str. 30","94469","Deggendorf","http://www.roko.sz-deg.de","rokoch@sz-deg.de");
INSERT INTO schule_daten VALUES("358","1","Gymnasium Fr&auml;nkische Schweiz Ebermannstadt","Gymnasium","Staatlich","Georg-Wagner-Str. 17","91320","Ebermannstadt","http://www.gfs-ebs.de","direktorat@gfs-ebs.de");
INSERT INTO schule_daten VALUES("359","1","Emil-von-Behring-Gymnasium Spardorf ","Gymnasium","Staatlich","Buckenhofer Str. 5","91080","Spardorf","http://www.evbg.de","schulleitung@evbg.de");
INSERT INTO schule_daten VALUES("360","1","Wernher-von-Braun-Gymnasium Friedberg","Gymnasium","Staatlich","Rothenbergstr. 3","86316","Friedberg","http://www.wvb-gym.de","verwaltung@gym-friedberg.de");
INSERT INTO schule_daten VALUES("361","1","Balthasar-Neumann-Gymnasium Marktheidenfeld","Gymnasium","Staatlich","Oberl&auml;nderstr. 29","97828","Marktheidenfeld","http://www.bng-online.de","sekretariat@bng-online.de");
INSERT INTO schule_daten VALUES("362","1","Humboldt-Gymnasium Vaterstetten in Baldham","Gymnasium","Staatlich","Johann-Strau&szlig;-Str. 41","85598","Baldham","http://www.humboldtgym-vaterstetten.de","sekretariat@humboldtgym-vaterstetten.de");
INSERT INTO schule_daten VALUES("363","1","Gymnasium Waldkraiburg ","Gymnasium","Staatlich","Ritter-von-Gluck-Weg 3a","84478","Waldkraiburg","http://www.gymnasiumwaldkraiburg.de","Gymnasium.Waldkraiburg@t-online.de");
INSERT INTO schule_daten VALUES("364","1","Gymnasium Wertingen ","Gymnasium","Staatlich","Pestalozzistr. 12","86637","Wertingen","http://www.gymnasium-wertingen.de","schule@gymnasium-wertingen.de");
INSERT INTO schule_daten VALUES("365","1","K&ouml;nig-Karlmann-Gymnasium Alt&ouml;tting ","Gymnasium","Staatlich","Kardinal-Wartenberg-Str. 30","84503","Alt&ouml;tting","http://www.koenig-karlmann-gymnasium.de","sekretariat@koenig-karlmann-gymnasium.de");
INSERT INTO schule_daten VALUES("367","1","Werner-Heisenberg-Gymnasium Garching","Gymnasium","Staatlich","Prof.-Angermair-Ring 40","85748","Garching","http://www.whg-garching.de","homepageteam@whg-garching.de");
INSERT INTO schule_daten VALUES("368","1","Gymnasium der Schwestern vom Hl. Kreuz Gem&uuml;nden","Gymnasium","Privat","Kreuzstr. 3","97737","Gem&uuml;nden","http://www.kreuzschwestern.de","info@kreuzschwestern.de");
INSERT INTO schule_daten VALUES("369","1","Gymnasium Geretsried ","Gymnasium","Staatlich","Adalbert-Stifter-Str. 14","82538","Geretsried","http://www.gymger.de","info@gymger.de");
INSERT INTO schule_daten VALUES("370","1","Paul-Klee-Gymnasium Gersthofen ","Gymnasium","Staatlich","Schubertstr. 57","86368","Gersthofen","http://www.paul-klee-gymnasium.de","sekretariat@gymgersthofen.de");
INSERT INTO schule_daten VALUES("371","1","Apian-Gymnasium Ingolstadt ","Gymnasium","Staatlich","Maximilianstr. 25","85051","Ingolstadt","http://www.apian.de","info@apian.de");
INSERT INTO schule_daten VALUES("372","1","Johann-Sch&ouml;ner-Gymnasium Karlstadt ","Gymnasium","Staatlich","Bodelschwinghstr. 29","97753","Karlstadt","http://www.jsg-karlstadt.de","info@jsg-karlstadt.de");
INSERT INTO schule_daten VALUES("373","1","St&auml;dtisches Werner-von-Siemens- Gymnasium M&uuml;nchen","Gymnasium","Staatlich","Quiddestr. 4","81735","M&uuml;nchen","http://www.wsg.musin.de","sekretariat@wsg.musin.de");
INSERT INTO schule_daten VALUES("374","1","Gymnasium M&uuml;nchen F&uuml;rstenried-West ","Gymnasium","Staatlich","Engadiner Str. 1","81475","M&uuml;nchen","http://www.gymfw.de","info@gymnasium-fuerstenried.de");
INSERT INTO schule_daten VALUES("375","1","Ostendorfer-Gymnasium Neumarkt ","Gymnasium","Staatlich","Dr.-Grundler-Str. 5","92318","Neumarkt","http://www.ostendorfer.de","sekretariat@ostendorfer.de");
INSERT INTO schule_daten VALUES("376","1","Gymnasium Olching ","Gymnasium","Staatlich","Georgenstr. 2","82140","Olching","http://www.gymolching.de","kontakt@gymolching.de");
INSERT INTO schule_daten VALUES("377","1","Gymnasium Parsberg ","Gymnasium","Staatlich","Aschenbrennerstr. 10","92331","Parsberg","http://www.gymnasium-parsberg.de","hs@gymnasium-parsberg.de");
INSERT INTO schule_daten VALUES("378","1","Lise-Meitner-Gymnasium Unterhaching ","Gymnasium","Staatlich","Jahnstr. 3","82008","Unterhaching","http://www.lmgu.de","brigitte.grams-loibl@lmgu.de");
INSERT INTO schule_daten VALUES("379","1","Maximilian-von-Montgelas-Gymnasium Vilsbiburg","Gymnasium","Staatlich","Gobener Str. 4","84137","Vilsbiburg","http://www.montgelas-gymnasium.de","montgelas-gymnasium@t-online.de");
INSERT INTO schule_daten VALUES("380","1","Ernst-Mach-Gymnasium Haar ","Gymnasium","Staatlich","Jagdfeldring 82","85540","Haar","http://www.emg-haar.de","sekretariat@emg-haar.de");
INSERT INTO schule_daten VALUES("381","1","Gymnasium Neustadt a.d.Waldnaab ","Gymnasium","Staatlich","Bildstr. 20","92660","Neustadt","http://www.gy-new.de","poststelle@gy-new.de");
INSERT INTO schule_daten VALUES("382","1","Geschwister-Scholl-Gymnasium R&ouml;thenbach a.d.Pegnitz","Gymnasium","Staatlich","Geschwister-Scholl-Platz 1","90552","R&ouml;thenbach","http://www.gymnasium.roethenbach.de","sekretariat@gsg.roethenbach.de");
INSERT INTO schule_daten VALUES("383","1","Deutschhaus-Gymnasium W&uuml;rzburg ","Gymnasium","Staatlich","Zeller Str. 41","97082","W&uuml;rzburg","http://www.gsg.roethenbach.de/","sekretariat@gsg.roethenbach.de");
INSERT INTO schule_daten VALUES("384","1","Sigmund-Schuckert-Gymnasium N&uuml;rnberg","Gymnasium","Staatlich","Pommernstr. 10","90451","N&uuml;rnberg","http://www.sigmund-schuckert-gymnasium.de","info@sigmund-schuckert-gymnasium.de");
INSERT INTO schule_daten VALUES("385","1","Gymnasium Herzogenaurach ","Gymnasium","Staatlich","Burgstaller Weg 20","91074","Herzogenaurach","http://www.gymnasium-herzogenaurach.de","sekretariat@gymnasium-herzogenaurach.de");
INSERT INTO schule_daten VALUES("386","1","Private Schulen Pindl GmbH Gymnasium Regensburg","Gymnasium","Privat","Dr.-Johann-Maier-Str. 2","93049","Regensburg","http://www.schulen-pindl.de","info@schulen-pindl.de");
INSERT INTO schule_daten VALUES("387","1","Isar-Gymnasium M&uuml;nchen - Schule in freier Tr&auml;gerschaft -","Gymnasium","Privat","Kohlstr. 5","80469","M&uuml;nchen","http://www.schulverbund.de","kontakt@schulverbund.de");
INSERT INTO schule_daten VALUES("388","1","Gymnasium Raubling ","Gymnasium","Staatlich","Kapellenweg 43","83064","Raubling","http://www.gym-raubling.de","info@gym-raubling.de");
INSERT INTO schule_daten VALUES("389","1","Viscardi-Gymnasium F&uuml;rstenfeldbruck","Gymnasium","Staatlich","Balduin-Helm-Str. 2","82256","F&uuml;rstenfeldbruck","http://www.viscardi-gymnasium.de","sekretariat@viscardi-ffb.de");
INSERT INTO schule_daten VALUES("390","1","Franz-Marc-Gymnasium Markt Schwaben","Gymnasium","Staatlich","Rektor-Haushofer-Str. 6","85570","Markt Schwaben","http://www.franz-marc-gymnasium.de","sekretariat@franz-marc-gymnasium.de");
INSERT INTO schule_daten VALUES("391","1","Gymnasium M&uuml;nchen-Moosach ","Gymnasium","Staatlich","Gerastr. 6","80993","M&uuml;nchen","http://www.gmm.musin.de","gymnasium-muenchen-moosach@muenchen.de");
INSERT INTO schule_daten VALUES("392","1","Burkhart-Gymnasium Mallersdorf-Pfaffenberg","Gymnasium","Staatlich","Burkhartstr. 3","84066","Mallersdorf-Pfaffenberg","http://www.gymnasium-mallersdorf.de","sekretariat@gymnasium-mallersdorf.de");
INSERT INTO schule_daten VALUES("393","1","Hanns-Seidel-Gymnasium H&ouml;sbach ","Gymnasium","Staatlich","An der Maas 2","63768","H&ouml;sbach","http://www.hanns-seidel-gymnasium.de","sekretariat@hanns-seidel-gymnasium.de");
INSERT INTO schule_daten VALUES("394","1","Friedrich-Koenig-Gymnasium W&uuml;rzburg","Gymnasium","Staatlich","Friedrichstr. 22","97082","W&uuml;rzburg","http://www.fkg-wuerzburg.de","fkg@fkg-wuerzburg.de");
INSERT INTO schule_daten VALUES("395","1","Illertal-Gymnasium V&ouml;hringen ","Gymnasium","Staatlich","Zum Sportplatz 17","89269","V&ouml;hringen","http://www.illertal-gymnasium.de","igv@​illertal-gym&shy;na&shy;si&shy;um.eu");
INSERT INTO schule_daten VALUES("397","1","Gymnasium Bad Aibling ","Gymnasium","Staatlich","Westendstr. 6a","83043","Bad Aibling","http://www.gymnasium-bad-aibling.de","verwaltung@gymnasium-bad-aibling.de");
INSERT INTO schule_daten VALUES("398","1","Gymnasium Dorfen ","Gymnasium","Staatlich","Josef-Martin-Bauer-Str. 18","84405","Dorfen","http://www.gymnasiumdorfen.de","sekretariat@gymnasiumdorfen.de");
INSERT INTO schule_daten VALUES("399","1","Gymnasium Neutraubling ","Gymnasium","Staatlich","Gregor-Mendel-Str. 5","93073","Neutraubling","http://www.gymnasium-neutraubling.de","direktorat@gymnasium-neutraubling.de");
INSERT INTO schule_daten VALUES("401","1","M&auml;dchenrealschule Marienburg, Abenberg. der Di&ouml;zese Eichst&auml;tt  ","Realschule","Privat","Marienburg 1","91183","Abenberg","http://mrs-abenberg.de","mrs-abenberg@t-online.de");
INSERT INTO schule_daten VALUES("402","1","Johann-Turmair-Realschule Staatliche Realschule Abensberg  ","Realschule","Staatlich","Stadionstr. 46","93326","Abensberg","http://www.rs-abensberg.de","sekretariat@rs-abensberg.de");
INSERT INTO schule_daten VALUES("403","1","Wittelsbacher-Realschule Staatliche Realschule Aichach  ","Realschule","Staatlich","Jahnstr. 2","86551","Aichach","http://www.wittelsbacher-realschule.com","sekretariat@realschule-aichach.de");
INSERT INTO schule_daten VALUES("404","1","Angela-Fraundorfer-Realschule f&uuml;r M&auml;dchen der Franziskanerinnen Aiterhofen ","Realschule","Privat","Schulgasse 9","94330","Aiterhofen","http://www.kloster-aiterhofen.de","sr.klara@kloster-aiterhofen.de");
INSERT INTO schule_daten VALUES("405","1","Herzog-Ludwig-Realschule Staatliche Realschule Alt&ouml;tting  ","Realschule","Staatlich","Justus-von-Liebig-Str. 10","84503","Alt&ouml;tting","http://www.herzog-ludwig-rs.de","sekretariat@stars-altoetting.de");
INSERT INTO schule_daten VALUES("406","1","Maria-Ward-Realschule Alt&ouml;tting der Maria-Ward-Schulstiftung Passau  ","Realschule","Privat","Neu&ouml;ttinger Str. 8","84503","Alt&ouml;tting","http://mariawardschulen.de","sekretariat@mariawardschulen.de");
INSERT INTO schule_daten VALUES("407","1","Edith-Stein-Schule Staatliche Realschule Alzenau  ","Realschule","Staatlich","Nikolaus-Fey-Str. 2a","63755","Alzenau","http://www.realschule-alzenau.de","verwaltung@realschule-alzenau.de");
INSERT INTO schule_daten VALUES("408","1","Dr.-Johanna-Decker-Realschule Amberg der Schulstiftung der Di&ouml;zese Regensburg ","Realschule","Privat","Deutsche Schulgasse 2","92224","Amberg","http://www.djds.de","realschule@djds.de");
INSERT INTO schule_daten VALUES("409","1","Theresia-Gerhardinger-Realschule der Di&ouml;zese W&uuml;rzburg Amorbach  ","Realschule","Privat","Richterstr. 6","63916","Amorbach","http://www.tgrsamorbach.de","tgrsamorbach@t-online.de");
INSERT INTO schule_daten VALUES("410","1","Staatliche Realschule f&uuml;r Knaben Aschaffenburg  ","Realschule","Staatlich","Darmst&auml;dter Str. 6","63741","Aschaffenburg","http://www.knabenrealschule.com","sekretariat@knabenrealschule.com");
INSERT INTO schule_daten VALUES("411","1","Ruth-Weiss-Realschule Staatliche Realschule f&uuml;r M&auml;dchen Aschaffenburg ","Realschule","Staatlich","Darmst&auml;dter Str. 6","63741","Aschaffenburg","http://www.rsm-ab.de","rsm-ab@t-online.de");
INSERT INTO schule_daten VALUES("412","1","Maria-Ward-Schule Aschaffenburg M&auml;dchenrealschule der Maria-Ward-Stiftung Aschaffenburg ","Realschule","Privat","Brentanoplatz 8-10","63739","Aschaffenburg","http://mwsab.de","realschule@mws-ab.de");
INSERT INTO schule_daten VALUES("413","1","Walter-Mohr-Realschule Staatl. Realschule Traunreut  ","Realschule","Staatlich","Traunring 61a","83301","Traunreut","http://www.realschule-traunreut.de","sekretariat@realschule-traunreut.de");
INSERT INTO schule_daten VALUES("414","1","Realschule des Zweckverbandes Auerbach  ","Realschule","Staatlich","Klosterweg 2","91275","Auerbach","http://www.realschule-auerbach.de","rs_auerbach@t-online.de");
INSERT INTO schule_daten VALUES("415","1","Bertolt-Brecht-Realschule Staatl. Realschule Augsburg I  ","Realschule","Staatlich","V&ouml;lkstr. 20","86150","Augsburg","http://www.bertolt-brecht-realschule.de","rs1.stadt@augsburg.de");
INSERT INTO schule_daten VALUES("416","1","Heinrich-von-Buz-Realschule Staatliche Realschule Augsburg II  ","Realschule","Staatlich","Eschenhofstr. 5","86154","Augsburg","http://www.rs2web.de","hvb-rs2.stadt@augsburg.de");
INSERT INTO schule_daten VALUES("417","1","St&auml;dtische Agnes-Bernauer-Schule Augsburg Realschule f&uuml;r M&auml;dchen  ","Realschule","Staatlich","Auf dem Kreuz 36","86152","Augsburg","http://www.agnes.de","verwaltung@agnes.de");
INSERT INTO schule_daten VALUES("418","1","M&auml;dchenrealschule St.Ursula Augsburg des Schulwerks der Di&ouml;zese Augsburg ","Realschule","Privat","Bei St. Ursula 2","86150","Augsburg","http://www.realschule-st-ursula.de","sekretariat@realschule-st-ursula.de");
INSERT INTO schule_daten VALUES("419","1","Maria-Ward-Realschule Augsburg d. Schulwerks d. Di&ouml;zese Augsburg  ","Realschule","Privat","Frauentorstr. 26","86152","Augsburg","http://maria-ward-realschule-augsburg.de","info@mw-augsburg.de");
INSERT INTO schule_daten VALUES("420","1","A.B. von Stettensches Institut Augsburg Realschule f&uuml;r M&auml;dchen  ","Realschule","Privat","Am Katzenstadel 18a","86152","Augsburg","http://www.stetten-institut.de","realschule@stetten-institut.de");
INSERT INTO schule_daten VALUES("421","1","Wilhelm-Leibl-Schule Staatliche Realschule Bad Aibling  ","Realschule","Staatlich","Westendstr. 6","83043","Bad Aibling","http://www.realschule-bad-aibling.de","wlrs@realschule-bad-aibling.de");
INSERT INTO schule_daten VALUES("422","1","Staatliche Realschule Bad Kissingen  ","Realschule","Staatlich","Valentin-Weidner-Platz 4","97688","Bad Kissingen","http://www.realschulebadkissingen.de","info@realschulebadkissingen.de");
INSERT INTO schule_daten VALUES("423","1","Staatl. Realschule Obertraubling   ","Realschule","Staatlich","Walhallastr. 24","93083","Obertraubling","http://www.rs-obertraubling.de","verwaltung@rs-obertraubling.de");
INSERT INTO schule_daten VALUES("424","1","Werner-von-Siemens-Realschule Staatl. Realschule Bad Neustadt a.d.Saale ","Realschule","Staatlich","Rh&ouml;nblick 17","97616","Bad Neustadt","http://www.rs-nes.de","verwaltung@rs-nes.de");
INSERT INTO schule_daten VALUES("425","1","Maria-Ward-Schule M&auml;dchenrealschule St. Zeno Bad Reichenhall ","Realschule","Privat","Klosterstr. 3","83435","Bad Reichenhall","http://www.mwr-reichenhall.de","info@mwr-reichenhall.de");
INSERT INTO schule_daten VALUES("426","1","St&auml;dtische Graf-Stauffenberg- Realschule Bamberg  ","Realschule","Staatlich","Kloster-Langheim-Str. 11","96050","Bamberg","http://rs.bnv-bamberg.de","verwaltung@gsr-bamberg.de");
INSERT INTO schule_daten VALUES("427","1","Maria-Ward-Realschule Bamberg   ","Realschule","Privat","Edelstr. 1","96047","Bamberg","http://maria-ward-realschule-bamberg.de","sekretariat@mws.bamberg.de");
INSERT INTO schule_daten VALUES("428","1","Alexander-von-Humboldt-Realschule Staatliche Realschule Bayreuth I  ","Realschule","Staatlich","An der B&uuml;rgerreuth 14","95445","Bayreuth","http://www.r1-bayreuth.de","sekretariat@r1-bayreuth.de");
INSERT INTO schule_daten VALUES("429","1","Johannes-Kepler-Realschule Staatliche Realschule Bayreuth II  ","Realschule","Staatlich","Adolf-W&auml;chter-Str. 8","95447","Bayreuth","http://www.r2-bayreuth.de","Verwaltung@r2-bayreuth.de");
INSERT INTO schule_daten VALUES("430","1","Altm&uuml;hltal-Realschule Staatliche Realschule Beilngries  ","Realschule","Staatlich","Ingolst&auml;dter Str. 5","92339","Beilngries","http://www.realschule-beilngries.de","sekretariat@realschule-beilngries.de");
INSERT INTO schule_daten VALUES("431","1","Staatliche Realschule Bobingen   ","Realschule","Staatlich","Krumbacher Str. 15","86399","Bobingen","http://www.realschule-bobingen.de","sekretariat@rsbobingen.de");
INSERT INTO schule_daten VALUES("432","1","Ludmilla-Schule Staatliche Realschule Bogen  ","Realschule","Staatlich","Pestalozzistr. 19","94327","Bogen","http://www.ludmilla-realschule.de","sekretariat@ludmilla-schule.de");
INSERT INTO schule_daten VALUES("433","1","Private Realschule mit Sch&uuml;ler(innen)heim Schlo&szlig; Brannenburg ","Realschule","Privat","Schlo&szlig;","83098","Brannenburg","http://www.institutschlossbrannenburg.de","sekretariat@institutschlossbrannenburg.de");
INSERT INTO schule_daten VALUES("434","1","Staatliche Realschule Bad Br&uuml;ckenau  ","Realschule","Staatlich","R&ouml;mershager Str. 29","97769","Bad Br&uuml;ckenau","http://www.rsbrk.de/","verwaltung@realschule-brk.de");
INSERT INTO schule_daten VALUES("435","1","Staatliche Realschule Buchloe   ","Realschule","Staatlich","Kerschensteinerstr. 2","86807","Buchloe","http://www.realschule-buchloe.de","verwaltung@rs-buchloe.de");
INSERT INTO schule_daten VALUES("436","1","Markgrafen-Realschule Staatliche Realschule Burgau  ","Realschule","Staatlich","Spitzstr. 1","89331","Burgau","http://www.rsburgau.de","schule@rsburgau.de");
INSERT INTO schule_daten VALUES("437","1","Maria-Ward-Realschule Burghausen der Maria-Ward-Schulstiftung Passau  ","Realschule","Privat","Stadtplatz 101","84489","Burghausen","http://www.mariaward-rs-burghausen.de","schulleitung@mariaward-rs-burghausen.de");
INSERT INTO schule_daten VALUES("438","1","Staatliche Realschule Burgkunstadt   ","Realschule","Staatlich","Kirchleiner Str. 16","96224","Burgkunstadt","http://www.realschule-burgkunstadt.de","verwaltung@realschule-burgkunstadt.de");
INSERT INTO schule_daten VALUES("439","1","Realschule am Kreuzberg Staatliche Realschule Burglengenfeld ","Realschule","Staatlich","Kreuzbergweg 4a","93133","Burglengenfeld","http://www.realschuleburglengenfeld.de/","sekretariat@realschuleburglengenfeld.de");
INSERT INTO schule_daten VALUES("440","1","Maristen-Realschule Cham der Schulstiftung der Di&ouml;zese Regensburg ","Realschule","Privat","Katzberger Str. 5","93413","Cham","http://www.maristen-realschule.de","mars@cham.maristen.de");
INSERT INTO schule_daten VALUES("441","1","Gerhardinger-Realschule Cham der Schulstiftung der Di&ouml;zese Regensburg ","Realschule","Privat","Klosterstr. 9","93413","Cham","http://www.grs-cham.de","sekretariat@grs-cham.de");
INSERT INTO schule_daten VALUES("442","1","Staatliche Realschule Coburg I   ","Realschule","Staatlich","Glockenberg 33","96450","Coburg","http://www.rscoburg1.de","verwaltung@rs1.coburg.de");
INSERT INTO schule_daten VALUES("443","1","Staatliche Realschule Coburg II   ","Realschule","Staatlich","Th&uuml;ringer Str. 5/7","96450","Coburg","http://www.rscoburg2.de","info@rscoburg2.de");
INSERT INTO schule_daten VALUES("444","1","Realschule Deggendorf der Maria-Ward-Schulstiftung Passau  ","Realschule","Privat","Maria-Ward-Platz 18","94469","Deggendorf","http://www.maria-ward-deg.de","realschule@maria-ward-deg.de");
INSERT INTO schule_daten VALUES("445","1","Liebfrauenschule Die&szlig;en M&auml;dchenrealschule des Schulwerks der Di&ouml;zese Augsburg ","Realschule","Privat","Klosterhof 4","86911","Die&szlig;en","http://www.mrs-diessen.de","mrs-diessen@t-online.de");
INSERT INTO schule_daten VALUES("446","1","Erste priv. staatl. genehmigte Realschule Schweinfurt  ","Realschule","Privat","Gorch-Fock-Str. 1 a","97421","Schweinfurt","http://privatschulen-schwarz.de","sekretariat@pws-mueller-sw.de");
INSERT INTO schule_daten VALUES("447","1","St. Bonaventura-Realschule Dillingen des Schulwerks der Di&ouml;zese Augsburg ","Realschule","Privat","Konviktstr. 11a","89407","Dillingen","http://www.bonareal.de","sekretariat@bonareal.de");
INSERT INTO schule_daten VALUES("448","1","Herzog-Tassilo-Realschule Staatliche Realschule Dingolfing  ","Realschule","Staatlich","Dr.-Josef-Hastreiter-Str. 20","84130","Dingolfing","http://www.realschule-dingolfing.de","verwaltung@rs-dingolfing.de");
INSERT INTO schule_daten VALUES("449","1","Knabenrealschule Hl. Kreuz Donauw&ouml;rth des Schulwerks der Di&ouml;zese Augsburg ","Realschule","Privat","Neudegger Allee 11","86609","Donauw&ouml;rth","http://www.heiligkreuz-donauwoerth.de","realschule@heiligkreuz-donauwoerth.de");
INSERT INTO schule_daten VALUES("450","1","M&auml;dchenrealschule St. Ursula Donauw&ouml;rth des Schulwerks der Di&ouml;zese Augsburg ","Realschule","Privat","Klostergasse 1","86609","Donauw&ouml;rth","http://www.st-ursula-donauwoerth.de","st-ursula-donauwoerth@t-online.de");
INSERT INTO schule_daten VALUES("451","1","Staatliche Realschule Ebermannstadt  ","Realschule","Staatlich","Georg-Wagner-Str. 16","91320","Ebermannstadt","http://www.rsebs.de","verwaltung@rsebs.de");
INSERT INTO schule_daten VALUES("452","1","Dr.-Ernst-Schmidt-Realschule Staatliche Realschule Ebern  ","Realschule","Staatlich","Georg-Nadler-Str. 7","96106","Ebern","http://www.rs-ebern.de","mail@rs-ebern.de");
INSERT INTO schule_daten VALUES("453","1","Dr.-Wintrich-Schule Staatliche Realschule Ebersberg  ","Realschule","Staatlich","Dr.-Wintrich-Str. 64","85560","Ebersberg","http://www.rsebe.de","sekretariat@rsebe.de");
INSERT INTO schule_daten VALUES("454","1","Steigerwaldschule Staatliche Realschule Ebrach  ","Realschule","Staatlich","Horbachweg 11","96157","Ebrach","http://www.steigerwaldschule-ebrach.de","schulleitung@steigerwaldschule-ebrach.de");
INSERT INTO schule_daten VALUES("455","1","Stefan-Krumenauer-Schule Staatliche Realschule Eggenfelden  ","Realschule","Staatlich","Feuerhausgasse 2","84307","Eggenfelden","http://www.rs-eggenfelden.de","info@rs-eggenfelden.de");
INSERT INTO schule_daten VALUES("456","1","Maria-Ward-Realschule der Di&ouml;zese Eichst&auml;tt  ","Realschule","Privat","Residenzplatz 16","85072","Eichst&auml;tt","http://www.mwrs-ei.de","sekretariat@mwrs-ei.de");
INSERT INTO schule_daten VALUES("457","1","Herzog-Tassilo-Realschule Staatliche Realschule Erding  ","Realschule","Staatlich","M&uuml;nchener Str. 134","85435","Erding","http://www.realschule-erding.de","verwaltung@realschule-erding.de");
INSERT INTO schule_daten VALUES("458","1","M&auml;dchenrealschule Heilig Blut Erding der Erzdi&ouml;zese M&uuml;nchen und Freising ","Realschule","Privat","Heilig Blut 1","85435","Erding","http://www.mrs-erding.de","verw@mrs-erding.de");
INSERT INTO schule_daten VALUES("459","1","Werner-von-Siemens-Realschule Staatliche Realschule Erlangen I  ","Realschule","Staatlich","Elise-Spaeth-Str. 7","91058","Erlangen","http://www.wvs-erlangen.de","verwaltung@wvs-erlangen.de");
INSERT INTO schule_daten VALUES("460","1","Staatliche Realschule Feucht   ","Realschule","Staatlich","Jahnstr. 32","90537","Feucht","http://www.realschule-feucht.de","verwaltung@realschule-feucht.de");
INSERT INTO schule_daten VALUES("461","1","Johann-Georg-von-Soldner-Schule Staatl. Realschule Feuchtwangen  ","Realschule","Staatlich","Dr.-Hans-G&uuml;thlein-Weg 12","91555","Feuchtwangen","http://www.realschule-feuchtwangen.de","schulleitung@realschule-feuchtwangen.de ");
INSERT INTO schule_daten VALUES("462","1","Georg-Hartmann-Realschule Staatliche Realschule Forchheim  ","Realschule","Staatlich","Pestalozzistr. 2","91301","Forchheim","http://www.rsforchheim.de","verwaltung@rsforchheim.de");
INSERT INTO schule_daten VALUES("463","1","Realschule im Rupertiwinkel Staatliche Realschule f&uuml;r Knaben Freilassing ","Realschule","Staatlich","Kerschensteinerstr. 8","83395","Freilassing","http://www.realschule-freilassing.de","kontakt@rs-rupertiwinkel.de");
INSERT INTO schule_daten VALUES("464","1","M&auml;dchenrealschule Franz von Assisi der Erzdi&ouml;zese M&uuml;nchen u. Freising in Freilassing-Salzburghofen ","Realschule","Privat","Laufener Str. 72","83395","Freilassing","http://www.mrs-freilassing.de","office@mrs-freilassing.de");
INSERT INTO schule_daten VALUES("465","1","Karl-Meichelbeck-Realschule Staatl. Realschule Freising  ","Realschule","Staatlich","D&uuml;wellstr. 22","85354","Freising","http://www.karl-meichelbeck-realschule.de","verwaltung@karl-meichelbeck-realschule.de");
INSERT INTO schule_daten VALUES("466","1","Staatliche Realschule Freyung   ","Realschule","Staatlich","Jahnstr. 8","94078","Freyung","http://www.realschule-freyung.de","sekretariat@realschule-freyung.de");
INSERT INTO schule_daten VALUES("467","1","Konradin-Realschule - Staatl. Realschule Friedberg -  ","Realschule","Staatlich","Rothenbergstr. 4","86316","Friedberg","http://www.konradin-realschule.de","verwaltung@konradin-realschule.de");
INSERT INTO schule_daten VALUES("468","1","Ferdinand-von-Miller-Realschule Staatliche Realschule F&uuml;rstenfeldbruck ","Realschule","Staatlich","Bahnhofstr. 15","82256","F&uuml;rstenfeldbruck","http://www.realschule-ffb.de","sekretariat@realschule-ffb.de");
INSERT INTO schule_daten VALUES("469","1","Leopold-Ullstein-Realschule - Staatliche Realschule F&uuml;rth -  ","Realschule","Staatlich","Sigmund-Nathan-Str. 1","90762","F&uuml;rth","http://www.ullstein-realschule-fuerth.de","sekretariat@ullstein-realschule-fuerth.de");
INSERT INTO schule_daten VALUES("470","1","Hans-B&ouml;ckler-Schule St&auml;dt. Realschule F&uuml;rth  ","Realschule","Staatlich","Fronm&uuml;llerstr. 30","90763","F&uuml;rth","http://www.hans-boeckler-schule.de","sekretariat@hans-boeckler-schule.de");
INSERT INTO schule_daten VALUES("471","1","Johann-Jakob-Herkomer-Schule Staatliche Realschule F&uuml;ssen  ","Realschule","Staatlich","Birkstr. 5","87629","F&uuml;ssen","http://www.rsfuessen.de","realschule@rsfuessen.de");
INSERT INTO schule_daten VALUES("472","1","Staatliche Realschule Furth i.Wald   ","Realschule","Staatlich","Carl-Clos-Str. 1-3","93437","Furth im Wald","http://www.realschule-furth.de","verwaltung@realschule-furth.de");
INSERT INTO schule_daten VALUES("473","1","Franken-Landschulheim Schlo&szlig; Gaibach des Zweckverbandes bayer. Landschulheime - Realschule ","Realschule","Staatlich","Sch&ouml;nbornstr. 2","97332","Volkach","http://www.flshgaibach.de","schule@flsh.de");
INSERT INTO schule_daten VALUES("474","1","St.-Irmengard--Realschule der Erzdi&ouml;zese M&uuml;nchen und Freising in Garmisch-Partenkirchen ","Realschule","Privat","Hauptstr. 45","82467","Garmisch-Partenkirchen","http://www.irmengardschule.de","rs@irmengardschule.de");
INSERT INTO schule_daten VALUES("475","1","Private Realschule des Bildungswerks Marktbreit e.V.  ","Realschule","Privat","Ochsenfurter Str. 29","97340","Marktbreit","http://www.bildungswerk-marktbreit.de","info@bildungswerk-marktbreit.de");
INSERT INTO schule_daten VALUES("476","1","Staatliche Realschule Gauting   ","Realschule","Staatlich","Birkenstr. 1","82131","Gauting","http://www.rs-gauting.de","rsgauting@t-online.de");
INSERT INTO schule_daten VALUES("477","1","Jacob-Ellrod-Realschule Evang. Ganztagsschule Gefrees  ","Realschule","Privat","Theodor-Heuss-Str. 8","95482","Gefrees","http://www.jesgefrees.de","JES@JESGefrees.de");
INSERT INTO schule_daten VALUES("478","1","Staatliche Realschule Gem&uuml;nden a.Main  ","Realschule","Staatlich","Kolpingstr. 7","97737","Gem&uuml;nden","http://www.realschule-gemuenden.de","info@realschule-gemuenden.de");
INSERT INTO schule_daten VALUES("479","1","M&auml;dchenrealschule der Schwestern vom Hl. Kreuz Gem&uuml;nden a.Main  ","Realschule","Privat","Kreuzstr. 3","97737","Gem&uuml;nden","http://www.kreuzschwestern.de","info@kreuzschwestern.de");
INSERT INTO schule_daten VALUES("480","1","Ludwig-Derleth-Realschule Staatliche Realschule Gerolzhofen  ","Realschule","Staatlich","Dr.-Georg-Sch&auml;fer-Str. 8","97447","Gerolzhofen","http://www.ldr-geo.de","verwaltung@rs-geo.de");
INSERT INTO schule_daten VALUES("481","1","Realschule Maria Stern Augsburg des Schulwerks der Di&ouml;zese Augsburg  ","Realschule","Privat","G&ouml;gginger Str. 132","86199","Augsburg","http://www.mariastern.net","realschule@mariastern.net");
INSERT INTO schule_daten VALUES("482","1","Ritter-Wirnt-Schule Staatliche Realschule Gr&auml;fenberg  ","Realschule","Staatlich","Kasberger Str. 33","91322","Gr&auml;fenberg","http://www.realschule-graefenberg.de","verwaltung@rs-graefenberg.de");
INSERT INTO schule_daten VALUES("483","1","Staatl. Realschule Grafenau   ","Realschule","Staatlich","Rachelweg 20","94481","Grafenau","http://www.realschule-grafenau.de","verwaltung@realschule-grafenau.de");
INSERT INTO schule_daten VALUES("484","1","Staatliche Realschule Bad Griesbach i.Rottal  ","Realschule","Staatlich","Seilerberg 20","94086","Bad Griesbach","http://www.rsgriesbach.de","RSGriesbach@t-online.de");
INSERT INTO schule_daten VALUES("485","1","Maria-Ward-Realschule G&uuml;nzburg des Schulwerks der Di&ouml;zese Augsburg  ","Realschule","Privat","Sch&uuml;tzenstr. 13","89312","G&uuml;nzburg","http://www.mwrs-gz.de","sekretariat@mwrs-gz.de");
INSERT INTO schule_daten VALUES("486","1","M&auml;dchenrealschule des Diakonissenmutterhauses Hensoltsh&ouml;he in Gunzenhausen ","Realschule","Privat","Lindleinswasenstr. 32","91710","Gunzenhausen","http://www.hensoltshoehe.de","verwaltungsleitung@hensoltshoehe.de");
INSERT INTO schule_daten VALUES("487","1","Dr.-Auguste-Kirchner-Realschule Staatliche Realschule Ha&szlig;furt  ","Realschule","Staatlich","Tricastiner Platz 1","97437","Ha&szlig;furt","http://www.realschule-hassfurt.de","sekretariat-rs@schulzentrum-hassfurt.de");
INSERT INTO schule_daten VALUES("488","1","Johann-Riederer-Schule Staatliche Realschule Hauzenberg  ","Realschule","Staatlich","Eckm&uuml;hlstr. 24","94051","Hauzenberg","http://www.realschule-hauzenberg.de","verwaltung@realschule-hauzenberg.de");
INSERT INTO schule_daten VALUES("489","1","Markgraf-Georg-Friedrich-Realsch. Staatliche Realschule Heilsbronn  ","Realschule","Staatlich","Ansbacher Str. 11","91560","Heilsbronn","http://www.realschule-heilsbronn.de","verwaltung@rs-heilsbronn.de");
INSERT INTO schule_daten VALUES("490","1","Staatliche Realschule Helmbrechts   ","Realschule","Staatlich","Am Pfarrteich 1","95233","Helmbrechts","http://www.realschule-helmbrechts.de","sekretariat@rs-helmbrechts.de");
INSERT INTO schule_daten VALUES("491","1","Staatliche Realschule Herrsching   ","Realschule","Staatlich","Jahnstr. 10-12","82211","Herrsching","http://www.rs-herrsching.de","sekretariat@rs-herrsching.de");
INSERT INTO schule_daten VALUES("492","1","Johannes-Scharrer-Realschule Staatliche Realschule Hersbruck  ","Realschule","Staatlich","Happurger Str. 13","91217","Hersbruck","http://jsr-hersbruck.de","Johannes-Scharrer-Realschule@t-online.de");
INSERT INTO schule_daten VALUES("493","1","Staatliche Realschule Herzogenaurach  ","Realschule","Staatlich","Burgstaller Weg 3","91074","Herzogenaurach","http://www.rsherzo.net","sekretariat@rsherzo.de");
INSERT INTO schule_daten VALUES("494","1","Staatliche Realschule Hilpoltstein   ","Realschule","Staatlich","Pestalozziweg 1","91161","Hilpoltstein","http://www.rea-hip.de","leitung@rea-hip.de");
INSERT INTO schule_daten VALUES("495","1","Staatliche Realschule Hirschaid   ","Realschule","Staatlich","Realschulstr. 2-6","96114","Hirschaid","http://rs-hirschaid.de","mail@rs-hirschaid.de");
INSERT INTO schule_daten VALUES("496","1","Joh.-Georg-August-Wirth-Realschule Staatliche Realschule Hof  ","Realschule","Staatlich","Max-Reger-Str. 71","95030","Hof","http://www.rs-hof.de","le@rs-hof.de");
INSERT INTO schule_daten VALUES("497","1","Jacob-Curio-Realschule Staatliche Realschule Hofheim  ","Realschule","Staatlich","Jahnstr. 12","97461","Hofheim","http://realschule-hofheim.de","realschule.hofheim@t-online.de");
INSERT INTO schule_daten VALUES("498","1","Johannes-von-La Salle-Realschule Illertissen des Schulwerks der D&ouml;zese Augsburg ","Realschule","Privat","Dietenheimer Str. 68","89257","Illertissen","http://www.rs-illertissen.de","info@rs-illertissen.de");
INSERT INTO schule_daten VALUES("499","1","Staatliche Realschule f&uuml;r Knaben Immenstadt  ","Realschule","Staatlich","Allg&auml;uer Str. 7","87509","Immenstadt","http://www.realschule-immenstadt.de","rektorat@realschule-immenstadt.de");
INSERT INTO schule_daten VALUES("500","1","M&auml;dchenrealschule Maria Stern Immenstadt des Schulwerks der Di&ouml;zese Augsburg ","Realschule","Privat","Bei Maria Stern 1","87509","Immenstadt","http://maria-stern.de","realschule_maria_stern@t-online.de");
INSERT INTO schule_daten VALUES("501","1","Realschule Vinzenz von Paul der Erzdi&ouml;zese M&uuml;nchen und Freising im Kloster Indersdorf ","Realschule","Privat","Marienplatz 7","85229","Markt Indersdorf","http://www.rs-indersdorf.de","verwaltung@rs-indersdorf.de");
INSERT INTO schule_daten VALUES("502","1","Freiherr-von-Ickstatt-Schule Staatliche Realschule Ingolstadt I  ","Realschule","Staatlich","Von-der-Tann-Str. 1","85049","Ingolstadt","http://www.irs.ingolstadt.de","sekretariat@ickstatt-rs.d");
INSERT INTO schule_daten VALUES("503","1","Gnadenthal-M&auml;dchenrealschule Ingolstadt der Di&ouml;zese Eichst&auml;tt  ","Realschule","Privat","Kupferstr. 23","85049","Ingolstadt","http://www.gmr.homepage.t-online.de","sekretariat@gnadenthal-realschule.de");
INSERT INTO schule_daten VALUES("504","1","Johann-Rudolph-Glauber-Schule Staatliche Realschule Karlstadt  ","Realschule","Staatlich","Kr&ouml;nleinsweg 29","97753","Karlstadt","http://www.realschule-karlstadt.de","verwaltung@realschule-karlstadt.de");
INSERT INTO schule_daten VALUES("505","1","Sophie-La-Roche-Realschule Staatl. Realschule Kaufbeuren  ","Realschule","Staatlich","Markgrafenstr. 3","87600","Kaufbeuren","http://www.realschule-kaufbeuren.de","realschule.kf@t-online.de");
INSERT INTO schule_daten VALUES("506","1","Marien-Realschule Kaufbeuren d. Schulwerks d. Di&ouml;zese Augsburg  ","Realschule","Privat","Kemnater Str. 15","87600","Kaufbeuren","http://www.marien-realschule-kaufbeuren.de","schule@marien-realschule-kaufbeuren.de");
INSERT INTO schule_daten VALUES("507","1","Staatliche Realschule Kemnath   ","Realschule","Staatlich","Schulplatz 4","95478","Kemnath","http://realschule-kemnath.de","verwaltung@realschule-kemnath.de");
INSERT INTO schule_daten VALUES("508","1","Private Realschule Gut Warnberg in M&uuml;nchen der begemann GmbH  ","Realschule","Privat","Warnbergstr. 1","81479","M&uuml;nchen","http://www.rs-gutwarnberg.de","info@rs-gutwarnberg.de");
INSERT INTO schule_daten VALUES("509","1","Realschule an der Salzstra&szlig;e Staatliche Realschule Kempten  ","Realschule","Staatlich","Salzstr. 17","87435","Kempten","http://www.staatliche-realschule-kempten.de","sekretariat@staatliche-realschule-kempten.de");
INSERT INTO schule_daten VALUES("510","1","St&auml;dtische Realschule Kempten   ","Realschule","Staatlich","Westendstr. 27","87439","Kempten","http://www.staedtische-realschule-kempten.de","sekretariat@staedtische-realschule-kempten.de");
INSERT INTO schule_daten VALUES("511","1","Maria-Ward-Schule Kempten M&auml;dchenrealschule d. Schulwerks d.Di&ouml;zese Augsburg ","Realschule","Privat","Hoffeldweg 12","87439","Kempten","http://www.mw-kempten.de","info@mw-kempten.de");
INSERT INTO schule_daten VALUES("512","1","Richard-Rother-Schule Staatliche Realschule Kitzingen  ","Realschule","Staatlich","Glauberstr. 72","97318","Kitzingen","http://www.richard-rother-schule.de","richard-rother-schule@t-online.de");
INSERT INTO schule_daten VALUES("513","1","Staatliche Realschule Kaufering   ","Realschule","Staatlich","Bayernstr. 12","86916","Kaufering","http://www.rs-kaufering.de","verwaltung@rs-kaufering.de");
INSERT INTO schule_daten VALUES("514","1","Via-Claudia-Realschule Staatliche Realschule K&ouml;nigsbrunn  ","Realschule","Staatlich","Schwabenstr. 35","86343","K&ouml;nigsbrunn","http://www.via-claudia-rs.de","sekretariat@rskoenigsbrunn.de");
INSERT INTO schule_daten VALUES("515","1","Dr.-Karl-Gr&uuml;newald-Schule Staatliche Realschule Bad K&ouml;nigshofen i.Gr. ","Realschule","Staatlich","Dr.-Ernst-Weber-Str. 28","97631","Bad K&ouml;nigshofen","http://www.rs-badkoenigshofen.de","verwaltung@rs-badkoenigshofen.de");
INSERT INTO schule_daten VALUES("516","1","Staatliche Realschule Bad K&ouml;tzting   ","Realschule","Staatlich","Bgm.-Dullinger-Str. 14","93444","Bad K&ouml;tzting","http://www.rs-koetzting.de","post@rs-koetzting.de");
INSERT INTO schule_daten VALUES("517","1","Maximilian-von-Welsch-Schule Staatliche Realschule Kronach I  ","Realschule","Staatlich","Gabelsbergerstr. 4","96317","Kronach","http://www.rs1kronach.de","verwaltung@rs1kronach.de");
INSERT INTO schule_daten VALUES("518","1","Staatliche Realschule Krumbach   ","Realschule","Staatlich","Talstr. 72","86381","Krumbach","http://www.realschule-krumbach.de","direktorat@realschule-krumbach.de");
INSERT INTO schule_daten VALUES("519","1","Carl-von-Linde-Schule Staatliche Realschule Kulmbach  ","Realschule","Staatlich","Alte Forstlahmer Str. 16","95326","Kulmbach","http://www.realschule-kulmbach.de","rs.kulmbach@kulmbach.net");
INSERT INTO schule_daten VALUES("520","1","Viktor-Karell-Schule Staatliche Realschule Landau a.d.Isar ","Realschule","Staatlich","Pfarrer-Huber-Str. 17","94405","Landau","http://www.rs-landau-isar.de","sekretariat@realschule-landau-isar.de");
INSERT INTO schule_daten VALUES("521","1","Johann-Winklhofer-Realschule Staatliche Realschule Landsberg  ","Realschule","Staatlich","Platanenstr. 2","86899","Landsberg","http://www.jwr-landsberg.de","verwaltung@jwr-landsberg.de");
INSERT INTO schule_daten VALUES("522","1","Staatliche Realschule Landshut   ","Realschule","Staatlich","Christoph-Dorner-Str. 18","84028","Landshut","http://www.rs-landshut.de","verwaltung@rs-landshut.de");
INSERT INTO schule_daten VALUES("523","1","Ursulinen-Realschule der Erzdi&ouml;zese M&uuml;nchen und Freising in Landshut ","Realschule","Privat","Bischof-Sailer-Platz 537","84028","Landshut","http://www.ursla.de","sekretariat@ursulinen-realschule-landshut.de");
INSERT INTO schule_daten VALUES("524","1","Oskar-Sembach-Realschule Staatl. Realschule Lauf a.d.Pegnitz  ","Realschule","Staatlich","Nordring 5","91207","Lauf","http://www.realschule-lauf.de","sekretariat@realschule-lauf.de");
INSERT INTO schule_daten VALUES("525","1","Staatliche Realschule Lauingen  ","Realschule","Staatlich","Friedrich-Ebert-Str. 10","89415","Lauingen","http://www.realschule-lauingen.de","sekretariat@realschule-lauingen.de");
INSERT INTO schule_daten VALUES("526","1","M&auml;dchenrealschule St. Ursula Schloss Hohenburg der Erzdi&ouml;zese M&uuml;nchen und Freising ","Realschule","Privat","Hohenburg 3","83661","Lenggries","http://www.st-ursula.net","realschule@st-ursula.net");
INSERT INTO schule_daten VALUES("527","1","Staatliche Realschule Poing   ","Realschule","Staatlich","Seerosenstr. 13 a","85586","Poing","http://www.realschule-poing.de","sekretariat@realschule-poing.de");
INSERT INTO schule_daten VALUES("528","1","Staatliche Realschule f&uuml;r Knaben Lindau  ","Realschule","Staatlich","Reutiner Str. 2","88131","Lindau","http://www.rs-lindau.de","sekretariat@rs-lindau.de");
INSERT INTO schule_daten VALUES("529","1","Maria-Ward-Schule Lindau M&auml;dchenrealschule d. Schulwerks d.Di&ouml;zese Augsburg ","Realschule","Privat","Ludwigstr. 3","88131","Lindau","http://www.mwrs-lindau.de","sekretariat@mwrs-lindau.de");
INSERT INTO schule_daten VALUES("530","1","Staatliche Realschule Lindenberg i.Allg&auml;u  ","Realschule","Staatlich","Sonnenhalde 55","88161","Lindenberg","http://realschule-lindenberg.de","verwaltung@rslin.de");
INSERT INTO schule_daten VALUES("531","1","St.-Emmeram-Realschule Staatl. Realschule Aschheim  ","Realschule","Staatlich","Eichendorffstr. 14","85609","Aschheim","http://www.rsaschheim.de","sekretariat@rs-aschheim.de");
INSERT INTO schule_daten VALUES("532","1","Nardini-Realschule f&uuml;r M&auml;dchen der Ordensgemeinschaft der Armen Franziskanerinnen von der Heiligen Familie zu Mallersdorf","Realschule","Privat","Klosterberg 1","84066","Mallersdorf-Pfaffenberg","http://www.nardini-realschule.de","nardini-realschule@web.de");
INSERT INTO schule_daten VALUES("533","1","Realschule Tegernseer Tal Staatliche Realschule Gmund a.Tegernsee ","Realschule","Staatlich","Sanktjohanserstr. 36","83707","Bad Wiessee","http://www.realschule-gmund.de","sekretariat2012@rs-gmund.de");
INSERT INTO schule_daten VALUES("534","1","Leo Weismantel-Realschule Priv. Realschule d. Realschulver. Marktbreit e.V. ","Realschule","Privat","Buheleite 20","97340","Marktbreit","http://www.realschulemarktbreit.de","realschule-marktbreit@t-online.de");
INSERT INTO schule_daten VALUES("535","1","Staatliche Realschule Marktheidenfeld  ","Realschule","Staatlich","Oberl&auml;nder Str. 28","97828","Marktheidenfeld","http://www.rsmar.de","verwaltung@rsmar.de");
INSERT INTO schule_daten VALUES("536","1","Staatl. Realschule Marktoberdorf   ","Realschule","Staatlich","M&uuml;hlsteig 19","87616","Marktoberdorf","http://www.real-mod.de","verwaltung@real-mod.de");
INSERT INTO schule_daten VALUES("537","1","Fichtelgebirgsrealschule Staatliche Realschule Marktredwitz  ","Realschule","Staatlich","Schulstr. 3","95615","Marktredwitz","http://www.realschule-mak.de","sekretariat@realschule-mak.de");
INSERT INTO schule_daten VALUES("538","1","Dr.-Max-Josef-Metzger-Schule Staatl. Realschule Meitingen  ","Realschule","Staatlich","Gartenstr. 3","86405","Meitingen","http://www.rsmeitingen.de","sekretariat@rsmeitingen.de");
INSERT INTO schule_daten VALUES("539","1","Ignaz-Reder-Realschule Staatliche Realschule Mellrichstadt  ","Realschule","Staatlich","Friedenstr. 25","97638","Mellrichstadt","http://www.rs-met.de","verwaltung@rs-met.de");
INSERT INTO schule_daten VALUES("540","1","Sebastian-Lotzer-Realschule St&auml;dt. Realschule Memmingen  ","Realschule","Staatlich","Buxacher Str. 8","87700","Memmingen","http://www.slr-mm.de","sekretariat@slr-mm.de");
INSERT INTO schule_daten VALUES("541","1","Gunetzrhainer-Schule Staatliche Realschule Miesbach  ","Realschule","Staatlich","Schlierseer Str. 18","83714","Miesbach","http://www.realschule-miesbach.de","sekretariat@realschule-miesbach.de");
INSERT INTO schule_daten VALUES("542","1","Johannes-Hartung-Realschule Staatliche Realschule Miltenberg  ","Realschule","Staatlich","Nikolaus-Fasel-Str. 12","63897","Miltenberg","http://www.realschule-miltenberg.de","sekretariat@realschule-miltenberg.de");
INSERT INTO schule_daten VALUES("543","1","Priv. staatl. gen. Rudolf-Diesel-Realschule Augsburg  ","Realschule","Privat","Riedingerstr. 26c","86153","Augsburg","http://www.hsa-akademie.de","info@hsa-akademie.de");
INSERT INTO schule_daten VALUES("544","1","Maria-Ward-Realschule Mindelheim des Schulwerks der Di&ouml;zese Augsburg  ","Realschule","Privat","Luxenhoferstr. 3","87719","Mindelheim","http://www.maria-ward-realschule-mindelheim.de","sekretariat@maria-ward-realschule-mindelheim.de");
INSERT INTO schule_daten VALUES("545","1","Maristenkolleg Mindelheim Realschule f&uuml;r Knaben des Schulwerks der Di&ouml;zese Augsburg","Realschule","Privat","Champagnatplatz 1","87719","Mindelheim","http://www.maristenkolleg.de","realschule@maristenkolleg.de");
INSERT INTO schule_daten VALUES("546","1","Kastulus-Realschule Staatliche Realschule Moosburg  ","Realschule","Staatlich","Breitenbergstr. 22","85368","Moosburg","http://www.realschulemoosburg.de","rsmoosburg@rsmoosburg.net");
INSERT INTO schule_daten VALUES("547","1","St&auml;dtische Salvator-Realschule M&uuml;nchen  ","Realschule","Staatlich","Damenstiftstr. 3","80331","M&uuml;nchen","http://www.salvator-realschule.de","salvator-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("548","1","St&auml;dtische Carl-von-Linde- Realschule M&uuml;nchen  ","Realschule","Staatlich","Ridlerstr. 26","80339","M&uuml;nchen","http://www.cvl.musin.de","carl-von-linde-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("549","1","St&auml;dtische Hermann-Frieb- Realschule M&uuml;nchen  ","Realschule","Staatlich","Hohenzollernstr. 140","80796","M&uuml;nchen","http://www.friebrs.musin.de","Hermann-Frieb-Realschule@muenchen.de");
INSERT INTO schule_daten VALUES("550","1","St&auml;dtische Elly-Heuss-Realschule M&uuml;nchen  ","Realschule","Staatlich","Ungsteiner Str. 46","81539","M&uuml;nchen","http://www.elly-heuss.musin.de","elly-heuss-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("551","1","St&auml;dtische Rudolf-Diesel- Realschule M&uuml;nchen  ","Realschule","Staatlich","Schulstr. 3","80634","M&uuml;nchen","http://www.rdr.musin.de","rudolf-diesel-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("552","1","St&auml;dtische Helen-Keller-Realschule M&uuml;nchen  ","Realschule","Staatlich","F&uuml;rkhofstr. 28","81927","M&uuml;nchen","http://www.hkrs.musin.de","helen-keller-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("553","1","St&auml;dtische Ricarda-Huch-Realschule M&uuml;nchen  ","Realschule","Staatlich","Wilhelmstr. 29","80801","M&uuml;nchen","http://www.rica.musin.de","ricarda-huch-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("554","1","St&auml;dtische Maria-Probst-Realschule M&uuml;nchen  ","Realschule","Staatlich","Gotzinger Platz 1a","81371","M&uuml;nchen","http://www.mpr.musin.de","maria-probst-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("555","1","St&auml;dtische Balthasar-Neumann- Realschule M&uuml;nchen  ","Realschule","Staatlich","Hugo-Wolf-Str. 70","80937","M&uuml;nchen","http://www.bnrs.musin.de","balthasar-neumann-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("556","1","Staatl. Realschule R&ouml;thenbach a.d.Pegnitz  ","Realschule","Staatlich","Werner-von-Siemens-Allee 50","90552","R&ouml;thenbach","http://www.realschule-roethenbach.de","rs-roeba@t-online.de");
INSERT INTO schule_daten VALUES("557","1","St&auml;dtische Anne-Frank-Realschule M&uuml;nchen  ","Realschule","Staatlich","B&auml;ckerstr. 58","81241","M&uuml;nchen","http://www.afr.musin.de","anne-frank-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("558","1","St&auml;dtische Fridtjof-Nansen- Realschule M&uuml;nchen  ","Realschule","Staatlich","Ernst-Reuter-Str. 4","81675","M&uuml;nchen","http://www.fnr.musin.de","fridtjof-nansen-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("559","1","St&auml;dtische Ludwig-Thoma-Realschule M&uuml;nchen  ","Realschule","Staatlich","Fehwiesenstr. 11","81673","M&uuml;nchen","http://www.elteer.musin.de","ludwig-thoma-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("560","1","St&auml;dtische Adalbert-Stifter- Realschule M&uuml;nchen  ","Realschule","Staatlich","Flurstr. 4","81675","M&uuml;nchen","http://www.asr.musin.de","adalbert-stifter-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("561","1","Maria-Ward-Realschule Nymphenburg der Erzdi&ouml;zese M&uuml;nchen und Freising in M&uuml;nchen ","Realschule","Privat","Maria-Ward-Str. 5","80638","M&uuml;nchen","http://www.maria-ward-schulen.de","sekretariat@maria-ward-gymnasium.de");
INSERT INTO schule_daten VALUES("562","1","Hans-Maier-Realschule Staatliche Realschule Ichenhausen  ","Realschule","Staatlich","Rohrerstr. 21","89335","Ichenhausen","http://www.rsichenhausen.de","sekretariat@rs-ichenhausen.de");
INSERT INTO schule_daten VALUES("563","1","Maria-Ward-M&auml;dchenrealschule der Erzdi&ouml;zese M&uuml;nchen und Freising, M&uuml;nchen Berg am Laim ","Realschule","Privat","Josephsburgstr. 22","81673","M&uuml;nchen","http://www.mariaward-bal.de","info@mariaward-bal.de");
INSERT INTO schule_daten VALUES("564","1","Theresia-Gerhardinger-M&auml;dchenreal- schule der Erzdi&ouml;zese M&uuml;nchen und Freising, M&uuml;nchen ","Realschule","Privat","Mariahilfplatz 13","81541","M&uuml;nchen","http://www.rs-au.de","verw@rs-au.de");
INSERT INTO schule_daten VALUES("565","1","Staatliche Realschule Langenzenn   ","Realschule","Staatlich","Klaushofer Weg 6","90579","Langenzenn","http://www.realschule-langenzenn.de","info@rs-langenzenn.de");
INSERT INTO schule_daten VALUES("566","1","Staatl. Realschule Memmingen   ","Realschule","Staatlich","Schlachthofstr. 34","87700","Memmingen","http://www.starsmm.de","info@starsmm.de");
INSERT INTO schule_daten VALUES("568","1","Naabtal-Realschule Staatliche Realschule Nabburg  ","Realschule","Staatlich","Rotb&uuml;hlring 2","92507","Nabburg","http://www.naabtal-realschule.de","sekretariat@naabtal-realschule.de");
INSERT INTO schule_daten VALUES("569","1","Staatliche Realschule Naila   ","Realschule","Staatlich","Finkenweg 17","95119","Naila","http://www.rsnaila.de","rsnaila@rsnaila.de");
INSERT INTO schule_daten VALUES("570","1","Paul-Winter-Schule Staatliche Realschule f&uuml;r Knaben Neuburg a.d.Donau ","Realschule","Staatlich","Bahnhofstr. 150","86633","Neuburg","http://www.paul-winter-schule.de","info@paul-winter-schule.de");
INSERT INTO schule_daten VALUES("571","1","Tassilo-Gymnasium","Gymnasium","Staatlich","Obersimbach 28","84359","Simbach","www.tassilo-gymnasium.de","verwaltung@tassilo-gymnasium.de");
INSERT INTO schule_daten VALUES("572","1","Laurentius-Realschule des Evang.-Luth. Diakoniewerkes Neuendettelsau ","Realschule","Privat","Waldsteig 9","91564","Neuendettelsau","http://www.laurentius-realschule.de","sekretariat?@laurentius-realschule.de");
INSERT INTO schule_daten VALUES("573","1","Staatliche Realschule Neufahrn i.NB  ","Realschule","Staatlich","Niederfeldstr. 3","84088","Neufahrn","http://www.realschule-neufahrn.de","rs.neufahrn@t-online.de");
INSERT INTO schule_daten VALUES("574","1","Maria-Ward-Realschule Neuhaus a.Inn  ","Realschule","Privat","Schlo&szlig; 1","94152","Neuhaus","http://www.mariaward-realschule-neuhaus.de","sekretariat@rs-n.de");
INSERT INTO schule_daten VALUES("575","1","Staatliche Realschule f&uuml;r Knaben Neumarkt i.d.Opf.  ","Realschule","Staatlich","M&uuml;hlstr. 44","92318","Neumarkt","http://www.knabenrealschule-neumarkt.de","verwaltung@knabenrealschule-neumarkt.de");
INSERT INTO schule_daten VALUES("576","1","Staatliche Realschule f&uuml;r M&auml;dchen Neumarkt i.d.Opf.  ","Realschule","Staatlich","M&uuml;hlstr. 30","92318","Neumarkt","http://www.maedchenrealschule-neumarkt.de","verwaltung@maedchenrealschule-neumarkt.de");
INSERT INTO schule_daten VALUES("577","1","Gregor-von-Scherr-Schule Staatliche Realschule Neunburg vorm Wald ","Realschule","Staatlich","Katzdorfer Str. 22","92431","Neunburg","http://www.rs-neunburg.de","sekretariat@rs-neunburg.de");
INSERT INTO schule_daten VALUES("578","1","Private staatl. genehmigte Realschule Krau&szlig; Aschaffenburg  ","Realschule","Privat","Erlenmeyerstr. 3-5","63741","Aschaffenburg","http://www.pwk-ev.de/","sekretariat@pwk-ev.de");
INSERT INTO schule_daten VALUES("579","1","Dietrich-Bonhoeffer-Schule Staatliche Realschule Neustadt a.d.Aisch ","Realschule","Staatlich","Comeniusstr. 4","91413","Neustadt","http://www.realschule-neustadt-aisch.de","info@realschule-neustadt-aisch.de");
INSERT INTO schule_daten VALUES("580","1","Lobkowitz-Realschule Staatliche Realschule Neustadt a.d.Waldnaab ","Realschule","Staatlich","Bildstr. 7","92660","Neustadt","http://www.rs-new.de","sekretariat@lobkowitz-realschule.de");
INSERT INTO schule_daten VALUES("581","1","Staatliche Realschule Neustadt b.Coburg  ","Realschule","Staatlich","Feldstr. 22","96465","Neustadt","http://www.realschule-neustadt.de","verwaltung@realschule-neustadt.de");
INSERT INTO schule_daten VALUES("582","1","Columba-Neef-Realschule der Benediktinerinnen der Anbetung Neustift ","Realschule","Privat","Klosterberg 27","94496","Ortenburg","http://columba-neef-realschule.de","schulleitung@columba-neef-realschule.de");
INSERT INTO schule_daten VALUES("583","1","Staatliche Realschule Neutraubling   ","Realschule","Staatlich","Johann-Michael-Sailer-Str. 20","93073","Neutraubling","http://www.rs-neutraubling.de","verwaltung@rs-neutraubling.de");
INSERT INTO schule_daten VALUES("584","1","Christoph-Probst-Realschule Staatliche Realschule Neu-Ulm  ","Realschule","Staatlich","Albert-Schweitzer-Str. 12","89231","Neu-Ulm","http://www.realschule-neu-ulm.de","rsneu-ulm.verw@t-online.de");
INSERT INTO schule_daten VALUES("585","1","Realschule der Dominikanerinnen St. Maria a.d.Isar, Niederviehbach  ","Realschule","Privat","Klosterstr. 12","84183","Niederviehbach","http://www.realschule-stmaria.de","u.grauvogl@realschule-stmaria.de");
INSERT INTO schule_daten VALUES("586","1","Realschule Maria Stern N&ouml;rdlingen des Schulwerks der Di&ouml;zese Augsburg  ","Realschule","Privat","H&uuml;ttengasse 2","86720","N&ouml;rdlingen","http://www.mariastern.de","sekr@mariastern.de");
INSERT INTO schule_daten VALUES("587","1","St&auml;dtische Peter-Vischer-Schule N&uuml;rnberg -Realschule-  ","Realschule","Staatlich","Bielingplatz 2","90419","N&uuml;rnberg","http://www.peter-vischer-schule.de","pvs@stadt.nuernberg.de");
INSERT INTO schule_daten VALUES("588","1","St&auml;dtische Veit-Sto&szlig;-Realschule N&uuml;rnberg  ","Realschule","Staatlich","Merseburger Str. 4","90491","N&uuml;rnberg","http://www.kubiss.de","postmaster@kubiss.de");
INSERT INTO schule_daten VALUES("589","1","St&auml;dtische Adam-Kraft-Realschule N&uuml;rnberg  ","Realschule","Staatlich","Lutherplatz 4","90459","N&uuml;rnberg","http://akr.nuernberg.de","akr@stadt.nuernberg.de");
INSERT INTO schule_daten VALUES("590","1","Maria-Ward-Realschule N&uuml;rnberg   ","Realschule","Privat","Ke&szlig;lerplatz 2","90489","N&uuml;rnberg","http://www.mwrsn.de","mwrsn@hotmail.com");
INSERT INTO schule_daten VALUES("591","1","Wilhelm-L&ouml;he-Schule N&uuml;rnberg - Realschule -  ","Realschule","Privat","Deutschherrnstr. 10","90429","N&uuml;rnberg","http://www.loehe-schule.de","realschule@loehe-schule.de ");
INSERT INTO schule_daten VALUES("592","1","Neue genehmigte Realschule Sabel (NgRS) N&uuml;rnberg  ","Realschule","Privat","Eilgutstr. 5, 7 + 10","90443","N&uuml;rnberg","http://www.sabel.de","info@sabel.com");
INSERT INTO schule_daten VALUES("593","1","Private Neuhof-Realschule M&uuml;nchen  ","Realschule","Privat","Steinerstr. 16","81369","M&uuml;nchen","http://www.neuhof-schulen.de","a.richter@neuhof-schulen.de");
INSERT INTO schule_daten VALUES("594","1","Main-Limes-Realschule Staatliche Realschule Obernburg  ","Realschule","Staatlich","Dekaneistr. 2","63785","Obernburg","http://www.realschule-obernburg.de","sekretariat@rsobernburg.de ");
INSERT INTO schule_daten VALUES("595","1","Realschule Oberroning der Schulstiftung d. Di&ouml;zese Regensburg in Rottenburg ","Realschule","Privat","Klosterweg 2","84056","Rottenburg","http://rs-obr.de","rs.oberroning@t-online.de");
INSERT INTO schule_daten VALUES("596","1","Realschule am Maindreieck Staatliche Realschule Ochsenfurt  ","Realschule","Staatlich","Pestalozzistr. 6","97199","Ochsenfurt","http://www.rs-ochsenfurt.de","verwaltung@rs-maindreieck.de");
INSERT INTO schule_daten VALUES("597","1","Evangelische Realschule Ortenburg der Evang. Erziehungsstiftung  ","Realschule","Privat","Frauenfeld 5-7","94496","Ortenburg","http://www.realschule-ortenburg.org","schulleitung@realschule-ortenburg.de");
INSERT INTO schule_daten VALUES("598","1","Landgraf-Leuchtenberg-Realschule Staatl. Realschule f&uuml;r Knaben Osterhofen ","Realschule","Staatlich","Seewiesen 10","94486","Osterhofen","http://www.rsosterhofen.de","verwaltung@rsosterhofen.de");
INSERT INTO schule_daten VALUES("599","1","M&auml;dchenrealschule Osterhofen der Maria-Ward-Schulstiftung Passau  ","Realschule","Privat","Hauptstr. 59","94486","Osterhofen","http://www.realschuledamenstift.de","damenstift@t-online.de");
INSERT INTO schule_daten VALUES("600","1","Edith-Stein-Realschule Staatliche Realschule Parsberg  ","Realschule","Staatlich","Aschenbrennerstr. 6","92331","Parsberg","http://www.realschule-parsberg.de","verwaltung@realschule-parsberg.de");
INSERT INTO schule_daten VALUES("601","1","Gisela-Realschule Passau-Niedernburg  ","Realschule","Privat","Klosterwinkel 1","94032","Passau","http://www.gisela-schulen.de","info@gisela-schulen.de");
INSERT INTO schule_daten VALUES("602","1","Staatliche Realschule Pegnitz   ","Realschule","Staatlich","Stadionstr. 22","91257","Pegnitz","http://www.rspegnitz.de","schulverwaltung@rspegnitz.de");
INSERT INTO schule_daten VALUES("603","1","Heinrich-Campendonk-Realschule Staatliche Realschule Penzberg  ","Realschule","Staatlich","Karlstr. 36","82377","Penzberg","http://www.realschule-penzberg.de","Sekretariat@Realschule-Penzberg.de");
INSERT INTO schule_daten VALUES("604","1","Georg-Hipp-Realschule Staatliche Realschule Pfaffenhofen a.d.Ilm ","Realschule","Staatlich","Niederscheyerer Str. 2","85276","Pfaffenhofen","http://www.georg-hipp-realschule.de","sekretariat@georg-hipp-realschule.de");
INSERT INTO schule_daten VALUES("605","1","Staatliche Realschule Pfarrkirchen   ","Realschule","Staatlich","Von-Fraunhofer-Str. 4","84347","Pfarrkirchen","http://www.rs-pan.de","info@rs-pan.de");
INSERT INTO schule_daten VALUES("606","1","Priv. staatl. genehmigte Tilly-Realschule Ingolstadt  ","Realschule","Privat","Br&uuml;ckenkopf 1 / Haus D","85051","Ingolstadt","http://www.rs-tilly.de","sekretariat@tilly-rs.de");
INSERT INTO schule_daten VALUES("607","1","Conrad-Graf-Preysing-Realschule Staatliche Realschule Plattling  ","Realschule","Staatlich","Salvatorstr. 17","94447","Plattling","http://www.realschule-plattling.de","verwaltung@realschule-plattling.de");
INSERT INTO schule_daten VALUES("608","1","Realschule Herrieden   ","Realschule","Staatlich","Steinweg 6","91567","Herrieden","http://www.realschule-herrieden.de","verwaltung@realschule-herrieden.de");
INSERT INTO schule_daten VALUES("609","1","Pater-Rupert-Mayer-Realschule der Erzdi&ouml;zese M&uuml;nchen und Freising Tagesheimschulen Pullach der Erzdi&ouml;zese M&uuml;nchen und Freising","Realschule","Privat","Wolfratshauser Str. 30","82049","Pullach","http://www.prmrs.de","info@prmrs.de ");
INSERT INTO schule_daten VALUES("610","1","Knabenrealschule Rebdorf der Di&ouml;zese Eichst&auml;tt  ","Realschule","Privat","Pater Moser-Str. 3","85072","Eichst&auml;tt","http://www.krs-rebdorf.de","buero@krs-rebdorf.de");
INSERT INTO schule_daten VALUES("611","1","Siegfried-von-Vegesack-Realschule Staatliche Realschule Regen  ","Realschule","Staatlich","Pfarrer-Biebl-Str. 20","94209","Regen","http://www.realschule-regen.de","rsr@realschule-regen.de");
INSERT INTO schule_daten VALUES("612","1","Realschule am Judenstein Staatliche Realschule Regensburg I  ","Realschule","Staatlich","Am Judenstein 1","93047","Regensburg","http://www.rsaj.de","rsaj.verwaltung@schulen.regensburg.de");
INSERT INTO schule_daten VALUES("613","1","Albert-Schweitzer-Realschule Staatl. Realschule Regensburg II  ","Realschule","Staatlich","Isarstr. 24","93057","Regensburg","http://www.asr-regensburg.de","asr.sekretariat@schulen.regensburg.de");
INSERT INTO schule_daten VALUES("614","1","M&auml;dchenrealschule der Armen Schulschwestern von Unserer Lieben Frau Regensburg-Niederm&uuml;nster","Realschule","Privat","Alter Kornmarkt 5","93047","Regensburg","http://www.niedermuenster.de","sekretariat@niedermuenster.de");
INSERT INTO schule_daten VALUES("615","1","St.-Marien-Realschule der Schulstiftung der Di&ouml;zese Regensburg ","Realschule","Privat","Helenenstr. 2","93047","Regensburg","http://www.st-marien-schulen-regensburg.de","realschule@st-marien-schulen-regensburg.de");
INSERT INTO schule_daten VALUES("616","1","Private Schulen Pindl GmbH Realschule Regensburg  ","Realschule","Privat","Wittelsbacher Str. 1","93049","Regensburg","http://www.schulen-pindl.de","realschule@schulen-pindl.de");
INSERT INTO schule_daten VALUES("617","1","Markgraf-Friedrich-Schule Staatliche Realschule Rehau  ","Realschule","Staatlich","Pilgramsreuther Str. 34","95111","Rehau","http://www.rs-rehau.de","verwaltung@rsrehau.de");
INSERT INTO schule_daten VALUES("618","1","Staatl. Realschule Haag i.OB   ","Realschule","Staatlich","Maria-Ward-Str. 24","83527","Haag","http://www.rs-haag.de","verwaltung@rs-haag.de");
INSERT INTO schule_daten VALUES("619","1","Johann-Simon-Mayr-Schule Staatliche Realschule Riedenburg  ","Realschule","Staatlich","Schulstr. 21","93339","Riedenburg","http://www.jsm-realschule.de","schulleitung@jsm-realschule.de");
INSERT INTO schule_daten VALUES("620","1","M&auml;dchenrealschule St. Anna Riedenburg der Schulstiftung der Di&ouml;zese Regensburg ","Realschule","Privat","St.-Anna-Platz 8","93339","Riedenburg","http://www.mrsstanna.de","sekretariat@mrsstanna.de");
INSERT INTO schule_daten VALUES("621","1","Konrad-Adenauer-Schule Staatliche Realschule Roding  ","Realschule","Staatlich","Mozartstr. 5","93426","Roding","http://www.rs-roding.de","sekretariat@rs-roding.de");
INSERT INTO schule_daten VALUES("622","1","Johann-Rieder-Realschule Staatliche Realschule Rosenheim  ","Realschule","Staatlich","Am N&ouml;rreut 10","83022","Rosenheim","http://www.schulen.rosenheim.de","jrrs@rosenheim.de");
INSERT INTO schule_daten VALUES("623","1","St&auml;dtische Realschule f&uuml;r M&auml;dchen Rosenheim  ","Realschule","Staatlich","Ebersberger Str. 13","83022","Rosenheim","http://www.mrs-roseheim.de","mrs@rosenheim.de");
INSERT INTO schule_daten VALUES("624","1","Wilhelm-von-Stieber-Realschule Staatliche Realschule Roth  ","Realschule","Staatlich","Brentwoodstr. 1 und 3","91154","Roth","http://www.realschule-roth.de","direktorat@rsroth.net");
INSERT INTO schule_daten VALUES("625","1","Oskar-von-Miller-Realschule Staatliche Realschule Rothenburg o.d.Tauber ","Realschule","Staatlich","Ackerweg 3","91541","Rothenburg","http://www.rs-rothenburg.de","verwaltung@rs-rothenburg.de");
INSERT INTO schule_daten VALUES("626","1","Private Realschule Schlo&szlig; Schwarzenberg der Mathilde-Zimmer-Stiftung ","Realschule","Privat","Schlo&szlig; Schwarzenberg","91443","Scheinfeld","http://www.schloss-schwarzenberg.de","sekretariat@schloss-schwarzenberg.de");
INSERT INTO schule_daten VALUES("627","1","M&auml;dchenrealschule der Erzdi&ouml;zese Bamberg Schillingsf&uuml;rst  ","Realschule","Privat","Neue Gasse 17","91583","Schillingsf&uuml;rst","http://www.maedchenrealschule-schillingsfuerst.de","verwaltung@mrs-schillingsfuerst.de");
INSERT INTO schule_daten VALUES("628","1","M&auml;dchenrealschule St. Immaculata der Erzdi&ouml;zese M&uuml;nchen und Freising Schlehdorf ","Realschule","Privat","Kirchstr. 9","82444","Schlehdorf","http://www.realschule-schlehdorf.de","rs@realschule-schlehdorf.de");
INSERT INTO schule_daten VALUES("629","1","Wolfgang-Kubelka-Realschule Staatliche Realschule f&uuml;r Knaben Schondorf a. Ammersee ","Realschule","Staatlich","Schulstr. 11","86938","Schondorf","http://www.rs-schondorf.de","sekretariat@rs-schondorf.de");
INSERT INTO schule_daten VALUES("630","1","Pfaffenwinkel-Realschule Staatl. Realschule Schongau  ","Realschule","Staatlich","Bgm.-Lechenbauer-Str. 7-9","86956","Schongau","http://www.pfaffenwinkel-realschule.de","sekretariat@pfaffenwinkel-realschule.de");
INSERT INTO schule_daten VALUES("631","1","Maria-Ward-Schule Schrobenhausen M&auml;dchenrealschule des Schulwerks der Di&ouml;zese Augsburg ","Realschule","Privat","Lenbachstr. 32","86529","Schrobenhausen","http://www.maria-ward-sob.de","realschule@maria-ward-sob.de");
INSERT INTO schule_daten VALUES("632","1","Staatl. Realschule Bruckm&uuml;hl   ","Realschule","Staatlich","Rathausplatz 3","83052","Bruckm&uuml;hl","http://www.rs-bruckmuehl.de","sekretariat@rs-bruckmuehl.de");
INSERT INTO schule_daten VALUES("633","1","Konrad-Max-Kunz-Realschule Staatl. Realschule Schwandorf  ","Realschule","Staatlich","Senefelderstr. 14","92421","Schwandorf","http://www.kmk-rs.de","info@kmk-realschule.de");
INSERT INTO schule_daten VALUES("634","1","M&auml;dchenrealschule St. Josef Schwandorf  ","Realschule","Privat","Dominikanerinnenstr. 1","92421","Schwandorf","http://www.mrsstjosef.de","mrsstjosef@t-online.de");
INSERT INTO schule_daten VALUES("635","1","Wilhelm-Sattler-Realschule Staatl. Realschule Schweinfurt  ","Realschule","Staatlich","St.-Kilian-Str. 15","97421","Schweinfurt","http://www.wsr-sw.de","wilhelm-sattler-rs@schweinfurt.de");
INSERT INTO schule_daten VALUES("636","1","Walther-Rathenau-Realschule der Stadt Schweinfurt  ","Realschule","Staatlich","Ignaz-Sch&ouml;n-Str. 7","97421","Schweinfurt","http://www.walther-rathenau-sw.de","wrg.wrr@schweinfurt.de");
INSERT INTO schule_daten VALUES("637","1","Staatliche Realschule Selb   ","Realschule","Staatlich","Jahnstr. 61","95100","Selb","http://www.rs-selb.de","rs.selb@t-online.de");
INSERT INTO schule_daten VALUES("638","1","Staatl. genehmigte Realschule der Stiftung Sabel M&uuml;nchen  ","Realschule","Privat","Schwanthalerstr. 51-53a","80336","M&uuml;nchen","http://www.sabel.com","info@sabel.com");
INSERT INTO schule_daten VALUES("639","1","Staatliche Realschule Sonthofen   ","Realschule","Staatlich","Sudetenstr. 6","87527","Sonthofen","http://www.stareso.de","verwaltung@stareso.de");
INSERT INTO schule_daten VALUES("640","1","Viktor-von-Scheffel-Schule Staatliche Realschule Bad Staffelstein ","Realschule","Staatlich","St.-Veit-Str. 10","96231","Bad Staffelstein","http://www.realschule-staffelstein.de","rs.staffelstein@t-online.de");
INSERT INTO schule_daten VALUES("641","1","Jakob-Sandtner-Schule Staatliche Realschule f&uuml;r Knaben Straubing ","Realschule","Staatlich","Innere Passauer Str. 1","94315","Straubing","http://www.jsr-straubing.de","sekretariat@jsr-straubing.de");
INSERT INTO schule_daten VALUES("642","1","M&auml;dchenrealschule der Ursulinen-Schulstiftung Straubing  ","Realschule","Privat","Burggasse 40","94315","Straubing","http://www.realschule.ursulinen-straubing.de","realschule@ursulinen-straubing.de");
INSERT INTO schule_daten VALUES("643","1","Staatliche Realschule Sulzbach-Rosenberg  ","Realschule","Staatlich","Erlheimer Weg 10","92237","Sulzbach-Rosenberg","http://www.rssuro.de","rs-su-ro@asamnet.de");
INSERT INTO schule_daten VALUES("644","1","Christoph-von-Schmid-Schule Staatliche Realschule Thannhausen  ","Realschule","Staatlich","R&ouml;schstr. 12","86470","Thannhausen","http://www.rs-thannhausen.de","sekretariat@rs-thannhausen.de");
INSERT INTO schule_daten VALUES("645","1","Staatliche Realschule Tittling   ","Realschule","Staatlich","Theodor-Heuss-Str. 11","94104","Tittling","http://www.realschule-tittling.de","sekretariat@realschule-tittling.de");
INSERT INTO schule_daten VALUES("646","1","Reiffenstuel-Realschule Staatl. Realschule Traunstein  ","Realschule","Staatlich","Wasserburger Str. 46","83278","Traunstein","http://www.realschule-traunstein.de","info@rs-traunstein.de ");
INSERT INTO schule_daten VALUES("647","1","Maria-Ward-M&auml;dchenrealschule der Erzdi&ouml;zese M&uuml;nchen und Freising Traunstein-Sparz ","Realschule","Privat","Sparz 2","83278","Traunstein","http://www.sparz.de","sekretariat@sparz.de");
INSERT INTO schule_daten VALUES("648","1","Priv. staatl. gen. Herder-Realschule Pielenhofen  ","Realschule","Privat","Schulstr. 7","93188","Pielenhofen","http://www.herder-schule.eu","sekretariat@herder-schule.eu");
INSERT INTO schule_daten VALUES("649","1","Staatliche Realschule Trostberg   ","Realschule","Staatlich","Stefan-G&uuml;nthner-Weg 8","83308","Trostberg","http://www.rs-trostberg.de","info@rstb.bayern.de");
INSERT INTO schule_daten VALUES("650","1","Benedictus-Realschule Tutzing des Schulwerks der Di&ouml;zese Augsburg  ","Realschule","Privat","Hauptstr. 12-14","82327","Tutzing","http://www.rs-tutzing.de","info@benedictus-realschule-tutzing.de");
INSERT INTO schule_daten VALUES("651","1","Christian-von-Bomhard-Schule Evang. Heimschule Uffenheim -Realschule- ","Realschule","Privat","Im Kr&auml;mersgarten 10","97215","Uffenheim","http://www.bomhardschule.de","bomhard-schule@odn.de");
INSERT INTO schule_daten VALUES("652","1","Staatl. Realschule Arnstorf   ","Realschule","Staatlich","Eggenfeldener Str. 43","94424","Arnstorf","http://www.rsarnstorf.de","verwaltung@rsarnstorf.de");
INSERT INTO schule_daten VALUES("653","1","Staatliche Realschule Viechtach   ","Realschule","Staatlich","Jahnstr. 38","94234","Viechtach","http://www.rsvit.de","rs.viechtach@t-online.de");
INSERT INTO schule_daten VALUES("654","1","Staatliche Realschule Vilsbiburg   ","Realschule","Staatlich","Amselstr. 6","84137","Vilsbiburg","http://www.realschule-vilsbiburg.de","verwaltung@realschule-vilsbiburg.de");
INSERT INTO schule_daten VALUES("655","1","Staatliche Realschule V&ouml;hringen   ","Realschule","Staatlich","Winterstr. 1","89269","V&ouml;hringen","http://www.rs-voehringen.de","kontakt@rs-voehringen.de");
INSERT INTO schule_daten VALUES("656","1","Staatliche Realschule Vohenstrau&szlig;   ","Realschule","Staatlich","Pestalozzistr. 14","92648","Vohenstrau&szlig;","http://www.realschule-vohenstrauss.de","poststelle@realschule-vohenstrauss.de");
INSERT INTO schule_daten VALUES("657","1","M&auml;dchenrealschule der Franziskanerinnen Volkach  ","Realschule","Privat","Klostergasse 1","97332","Volkach","http://mrsvo.de","mrsvo@kloster-st-maria.de");
INSERT INTO schule_daten VALUES("658","1","Ferdinand-Porsche-Schule Staatliche Realschule Waldkraiburg  ","Realschule","Staatlich","Franz-Liszt-Str. 51","84478","Waldkraiburg","http://www.realschule-waldkraiburg.de","info@realschule-waldkraiburg.de");
INSERT INTO schule_daten VALUES("659","1","Realschule im Stiftland Staatliche Realschule f&uuml;r Knaben Waldsassen ","Realschule","Staatlich","Schulstr. 11","95652","Waldsassen","http://www.knabenrealschule-waldsassen.de","krs.waldsassen@t-online.de");
INSERT INTO schule_daten VALUES("660","1","M&auml;dchenrealschule der Cistercienserinnen Waldsassen  ","Realschule","Privat","Basilikaplatz 2","95652","Waldsassen","http://www.mrs-waldsassen.de","sekretariat@mrs-waldsassen.de");
INSERT INTO schule_daten VALUES("661","1","Maria-Ward-Realschule Wallerstein des Schulwerks der Di&ouml;zese Augsburg  ","Realschule","Privat","Herrenstr. 15","86757","Wallerstein","http://www.maria-ward-wallerstein.de","mwardwallerstein@t-online.de");
INSERT INTO schule_daten VALUES("662","1","Anton-Heilingbrunner-Schule Staatliche Realschule Wasserburg  ","Realschule","Staatlich","Landwehrstr. 18","83512","Wasserburg","http://www.realschule.wasserburg.de","sekretariat@realschule-wasserburg.de");
INSERT INTO schule_daten VALUES("663","1","Imma-Mack-Realschule Staatl. Realschule Eching  ","Realschule","Staatlich","Nelkenstr. 32","85386","Eching","http://www.realschule-eching.de","verwaltung@realschule-eching.de");
INSERT INTO schule_daten VALUES("664","1","Staatliche Realschule Wassertr&uuml;dingen  ","Realschule","Staatlich","Bahnhofstr. 12","91717","Wassertr&uuml;dingen","http://www.rs-wassertruedingen.de","realschule-wassertruedingen@odn.de");
INSERT INTO schule_daten VALUES("665","1","Theresia-Gerhardinger-Realschule der Erzdi&ouml;zese M&uuml;nchen und Freising Weichs ","Realschule","Privat","Freiherrnstr. 17","85258","Weichs","http://www.tgrs-weichs.de","verwaltung@tgrsweichs.de");
INSERT INTO schule_daten VALUES("666","1","Priv. Pestalozzi Realschule M&uuml;nchen  ","Realschule","Privat","Truderinger Str. 265 b","81825","M&uuml;nchen","http://www.private-pestalozzi-realschule.de","info@pp-rs.de");
INSERT INTO schule_daten VALUES("667","1","Staatliche Realschule Weilheim   ","Realschule","Staatlich","Pr&auml;latenweg 5","82362","Weilheim","http://www.rs-weilheim.de","sekretariat@rs-weilheim.de");
INSERT INTO schule_daten VALUES("668","1","Staatliche Realschule Wei&szlig;enburg   ","Realschule","Staatlich","An der Hagenau 26","91781","Wei&szlig;enburg","http://www.rswug.de","info@rswug.de");
INSERT INTO schule_daten VALUES("669","1","St&auml;dtische Realschule Wei&szlig;enhorn   ","Realschule","Staatlich","Herzog-Ludwig-Str. 7","89264","Wei&szlig;enhorn","http://www.realschule-weissenhorn.de","sekretariat@realschule-weissenhorn.de");
INSERT INTO schule_daten VALUES("670","1","Anton-Jaumann-Realschule Staatliche Realschule Wemding  ","Realschule","Staatlich","Polsinger Weg 13","86650","Wemding","http://www.rs-wemding.de","schulleitung@rs-wemding.de");
INSERT INTO schule_daten VALUES("671","1","Anton-Rauch-Realschule Staatliche Realschule Wertingen  ","Realschule","Staatlich","Fere-Str. 3","86637","Wertingen","http://www.realschule-wertingen.de","sekretariat@rswertingen.de");
INSERT INTO schule_daten VALUES("672","1","Staatl. Realschule Bessenbach   ","Realschule","Staatlich","Ludwig-Straub-Str. 11","63856","Bessenbach","http://www.rs-bessenbach.de","mail@rs-bessenbach.de");
INSERT INTO schule_daten VALUES("673","1","Staatliche Realschule Wolfratshausen  ","Realschule","Staatlich","Franz-K&ouml;lbl-Weg 2","82515","Wolfratshausen","http://www.rs-wor.de","sekretariat@rs-wor.de");
INSERT INTO schule_daten VALUES("674","1","Jakob-Stoll-Schule Staatliche Realschule W&uuml;rzburg I  ","Realschule","Staatlich","Frankfurter Str. 71","97082","W&uuml;rzburg","http://www.jakob-stoll-realschule.de","sekretariat@jsrs.de");
INSERT INTO schule_daten VALUES("675","1","Wolffskeel-Schule Staatliche Realschule W&uuml;rzburg II  ","Realschule","Staatlich","Frankenstr. 201","97078","W&uuml;rzburg","http://www.wolffskeelschule.de","wolfskeel@t-online.de");
INSERT INTO schule_daten VALUES("677","1","Maria-Ward-Schule W&uuml;rzburg M&auml;dchenrealschule der Maria-Ward-Stiftung ","Realschule","Privat","Annastr. 6","97072","W&uuml;rzburg","http://www.mws-wuerzburg.de","mws-wue@t-online.de");
INSERT INTO schule_daten VALUES("678","1","St.-Ursula-Schule der Ursulinen W&uuml;rzburg -M&auml;dchenrealschule-  ","Realschule","Privat","Augustinerstr. 17","97070","W&uuml;rzburg","http://www.st-ursula-schule-wuerzburg.de","StUrsSchul@aol.com");
INSERT INTO schule_daten VALUES("679","1","Staatl. Realschule Holzkirchen   ","Realschule","Staatlich","Probst-Sigl-Str. 3","83607","Holzkirchen","http://www.realschule-holzkirchen.de","sekretariat@rshk.de");
INSERT INTO schule_daten VALUES("680","1","Marieluise-Flei&szlig;er-Realschule Staatl. Realschule M&uuml;nchen III  ","Realschule","Staatlich","Schwanthalerstr. 87","80336","M&uuml;nchen","http://www.mfrs.musin.de","marieluise-fleisser-schule@muenchen.de");
INSERT INTO schule_daten VALUES("685","1","Staatliche Realschule Dettelbach   ","Realschule","Staatlich","Luitpold-Baumann-Str. 37","97337","Dettelbach","http://www.realschule-dettelbach.de","buero@rs-dettelbach.de");
INSERT INTO schule_daten VALUES("686","1","Realschule am Europakanal Staatliche Realschule Erlangen II  ","Realschule","Staatlich","Schallershofer Str. 18","91056","Erlangen","http://www.real-euro.de","sekretariat@real-euro.de");
INSERT INTO schule_daten VALUES("687","1","Staatl. Realschule Geretsried   ","Realschule","Staatlich","Adalbert-Stifter-Str. 14","82538","Geretsried","http://www.rsger.de","info@rsger.de ");
INSERT INTO schule_daten VALUES("688","1","Georg-B&uuml;chner-Realschule Staatliche Realschule M&uuml;nchen I  ","Realschule","Staatlich","Droste-H&uuml;lshoff-Str. 5","80686","M&uuml;nchen","http://www.gbr-mchn.musin.de","georg-buechner-schule@web.de");
INSERT INTO schule_daten VALUES("689","1","Peter-Henlein-Realschule Staatl. Realschule N&uuml;rnberg I  ","Realschule","Staatlich","Pommernstr. 10","90451","N&uuml;rnberg","http://www.peter-henlein-realschule.de","verwaltung@peter-henlein-realschule.de");
INSERT INTO schule_daten VALUES("690","1","Staatliche Realschule Passau   ","Realschule","Staatlich","Neuburger Str. 94","94032","Passau","http://www.realschule-passau.de","verwaltung@realschule-passau.de");
INSERT INTO schule_daten VALUES("691","1","Inge-Aicher-Scholl-Realschule Staatliche Realschule Neu-Ulm-Pfuhl  ","Realschule","Staatlich","Heerstr. 115","89233","Neu-Ulm","http://www.realschule-pfuhl.de","verwaltung@realschule-pfuhl.de");
INSERT INTO schule_daten VALUES("692","1","Staatliche Realschule Rain   ","Realschule","Staatlich","Kraftwerkstr. 10","86641","Rain","http://www.realschule-rain.de","sekretariat@realschule-rain.de");
INSERT INTO schule_daten VALUES("693","1","Staatliche Realschule Sch&ouml;llnach   ","Realschule","Staatlich","Schulstr. 21","94508","Sch&ouml;llnach","http://www.realschule-schoellnach.de","sekretariat@realschule-schoellnach.de");
INSERT INTO schule_daten VALUES("694","1","Hans-Scholl-Realschule Staatliche Realschule f&uuml;r Knaben Weiden ","Realschule","Staatlich","Kurt-Schumacher-Allee 8","92637","Weiden","http://www.hans-scholl-rs.de","sekretariat@hans-scholl-rs.de");
INSERT INTO schule_daten VALUES("695","1","Priv. staatl. genehmigte Pelzl-Realschule Schweinfurt  ","Realschule","Privat","Wirsingstr. 7","97424","Schweinfurt","http://www.pelzl-online.de","pwspelzl@t-online.de");
INSERT INTO schule_daten VALUES("696","1","Wallburg-Realschule Staatliche Realschule Eltmann  ","Realschule","Staatlich","Oskar-Serrand-Str. 29","97483","Eltmann","http://www.rs-eltmann.de","schulleitung@rs-eltmann.de");
INSERT INTO schule_daten VALUES("697","1","Dominikus-Zimmermann-Realschule - Staatl. Realschule f&uuml;r Knaben G&uuml;nzburg - ","Realschule","Staatlich","Rebaystr. 9","89312","G&uuml;nzburg","http://www.dzrs.de","schule@dzrs.de");
INSERT INTO schule_daten VALUES("698","1","Jakob-Kaiser-Realschule Staatliche Realschule Hammelburg  ","Realschule","Staatlich","Von-der-Tann-Str. 1","97762","Hammelburg","http://www.rs-hab.de","verwaltung@rs-hab.de");
INSERT INTO schule_daten VALUES("699","1","Realschule am Keltenwall Staatliche Realschule Manching  ","Realschule","Staatlich","Ingolst&auml;dter Str. 100","85077","Manching","http://www.rs-manching.de","rsm@verwaltung.rs-manching.de");
INSERT INTO schule_daten VALUES("700","1","St&auml;dtische Carl-Spitzweg- Realschule M&uuml;nchen  ","Realschule","Staatlich","Zwiedineckstr. 35","80999","M&uuml;nchen","http://www.csr.musin.de","carl-spitzweg-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("701","1","Staatliche Realschule Bad T&ouml;lz   ","Realschule","Staatlich","Alter Bahnhofsplatz 5-7","83646","Bad T&ouml;lz","http://www.realschule-bad-toelz.de","lot@rs-toelz.de");
INSERT INTO schule_daten VALUES("702","1","Dr.-Josef-Schwalber-Realschule Staatliche Realschule Dachau  ","Realschule","Staatlich","Nikolaus-Deichl-Str. 1","85221","Dachau","http://www.realschuledachau.de","sekretariat@realschuledachau.de");
INSERT INTO schule_daten VALUES("703","1","Staatliche Realschule Elsenfeld   ","Realschule","Staatlich","Dammsfeldstr. 18","63820","Elsenfeld","http://rse-online.de","schulleitung@rse-online.de");
INSERT INTO schule_daten VALUES("704","1","Max-Ulrich-von-Drechsel-Realschule Staatliche Realschule Regenstauf  ","Realschule","Staatlich","Hauzensteiner Str. 54","93128","Regenstauf","http://www.rs-regenstauf.de","sekretariat@rs-regenstauf.de");
INSERT INTO schule_daten VALUES("705","1","Staatliche Realschule Rottenburg   ","Realschule","Staatlich","Pater-Wilhelm-Fink-Str. 20","84056","Rottenburg","http://www.rs-rottenburg.de","rs.rottenburg@t-online.de");
INSERT INTO schule_daten VALUES("706","1","Staatliche Realschule Schwabach   ","Realschule","Staatlich","Waikersreuther Str. 9a","91126","Schwabach","http://www.rs-schwabach.de","sekretariat@rs-schwabach.de");
INSERT INTO schule_daten VALUES("707","1","Sigmund-Wann-Realschule Staatliche Realschule Wunsiedel  ","Realschule","Staatlich","Nordendstr. 8","95632","Wunsiedel","http://www.rswun.de","verwaltung@rswun.de");
INSERT INTO schule_daten VALUES("708","1","David-Schuster-Realschule Staatl. Realschule W&uuml;rzburg III  ","Realschule","Staatlich","Sandbergerstr. 1","97074","W&uuml;rzburg","http://www.david-schuster-realschule.de","david-schuster-rs@t-online.de");
INSERT INTO schule_daten VALUES("709","1","Staatliche Realschule Ergolding   ","Realschule","Staatlich","Etzstr. 2","84030","Ergolding","http://www.rs-ergolding.de","verwaltung@rs-ergolding.de");
INSERT INTO schule_daten VALUES("710","1","St&auml;dtische Artur-Kutscher- Realschule M&uuml;nchen  ","Realschule","Staatlich","Gerastr. 6","80993","M&uuml;nchen","http://www.akr.musin.de","artur-kutscher-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("711","1","St&auml;dtische Wilhelm-R&ouml;ntgen- Realschule M&uuml;nchen  ","Realschule","Staatlich","Klabundstr. 8","81737","M&uuml;nchen","http://www.wrrs.musin.de","wilhelm-roentgen-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("712","1","Senefelder-Schule Treuchtlingen - Realschulzug -  ","Realschule","Staatlich","Bgm.-D&ouml;bler-Allee 3","91757","Treuchtlingen","http://www.sfst.de","sekretariat@senefelder-schule.de");
INSERT INTO schule_daten VALUES("713","1","Staatl. Realschule Berching   ","Realschule","Staatlich","Uferpromenade 14","92334","Berching","http://www.realschule-berching.de","sekretariat@realschule-berching.de");
INSERT INTO schule_daten VALUES("714","1","Lukas-Schule M&uuml;nchen Priv. staatl. anerkannte evang. Realschule ","Realschule","Privat","Helmpertstr. 9","80687","M&uuml;nchen","http://www.lukas-schule.de","sekretariat.rs@lukas-schule.de");
INSERT INTO schule_daten VALUES("716","1","Staatl. Realschule Geisenfeld   ","Realschule","Staatlich","Forstamtstr. 13","85290","Geisenfeld","http://www.rsgeisenfeld.de","info@rsgeisenfeld.de");
INSERT INTO schule_daten VALUES("717","1","Lena-Christ-Realschule Staatl. Realschule Markt Schwaben  ","Realschule","Staatlich","Habererweg 17","85570","Markt Schwaben","http://www.lena-christ-realschule.net","sekretariat@lena-christ-realschule.de");
INSERT INTO schule_daten VALUES("718","1","Staatliche Realschule Zirndorf   ","Realschule","Staatlich","Jakob-Wassermann-Str. 1","90513","Zirndorf","http://www.rs-zirndorf.de","realschule.zirndorf@fen-net.de");
INSERT INTO schule_daten VALUES("719","1","St&auml;dt. Rupert-Ness-Realschule Ottobeuren  ","Realschule","Staatlich","Bergstr. 80","87724","Ottobeuren","http://www.gym-rs-ottobeuren.de","schulleitung@gym-rs-ottobeuren.de");
INSERT INTO schule_daten VALUES("720","1","Staatliche Realschule Sche&szlig;litz   ","Realschule","Staatlich","Burgholzstr. 10","96110","Sche&szlig;litz","http://www.realschule-schesslitz.de","sek@rs-schesslitz.de");
INSERT INTO schule_daten VALUES("721","1","Staatliche Realschule Neubiberg   ","Realschule","Staatlich","Buchenstr. 4","85579","Neubiberg","http://www.realschule-neubiberg.de","realschule.neubiberg@t-online.de");
INSERT INTO schule_daten VALUES("722","1","Staatliche Realschule Taufkirchen (Vils)  ","Realschule","Staatlich","Attinger Weg 10","84416","Taufkirchen","http://www.rstaufkirchen.de","sekretariat@rstaufkirchen.de");
INSERT INTO schule_daten VALUES("723","1","Orlando-di-Lasso-Realschule Staatl. Realschule Maisach  ","Realschule","Staatlich","Lusstr. 36","82216","Maisach","http://www.rsmaisach.de","webmaster@rsmaisach.de");
INSERT INTO schule_daten VALUES("724","1","Georg-Ludwig-Rexroth-Realschule Staatliche Realschule Lohr  ","Realschule","Staatlich","Bgm.-Kessler-Platz 3","97816","Lohr","http://www.rs-lohr.de","verwaltung@rs-lohr.de");
INSERT INTO schule_daten VALUES("725","1","Anton-Fugger-Realschule Staatliche Realschule Babenhausen  ","Realschule","Staatlich","Pestalozzistr. 7","87727","Babenhausen","http://www.realschulebabenhausen.de","realschule.babenhausen@t-online.de");
INSERT INTO schule_daten VALUES("726","1","Staatliche Realschule Zwiesel   ","Realschule","Staatlich","Hochstr. 1","94227","Zwiesel","http://www.realschule-zwiesel.de","verwaltung@realschule-zwiesel.de");
INSERT INTO schule_daten VALUES("727","1","Johann-Steingruber-Schule Staatliche Realschule Ansbach  ","Realschule","Staatlich","Schreibm&uuml;llerstr. 12","91522","Ansbach","http://www.realschule-ansbach.de","verwaltung@realschule-ansbach.de");
INSERT INTO schule_daten VALUES("728","1","Michael-Ignaz-Schmidt-Schule Staatliche Realschule Arnstein  ","Realschule","Staatlich","Schwebenrieder Str. 22","97450","Arnstein","http://www.realschule-arnstein2.org","misr@realschule-arnstein.de");
INSERT INTO schule_daten VALUES("729","1","Leopold-Sonnemann-Realschule Staatliche Realschule H&ouml;chberg  ","Realschule","Staatlich","Rudolf-Harbig-Platz 7","97204","H&ouml;chberg","http://www.realschule-hoechberg.de","sekretariat.realschule@rs-hoechberg.bayern.de");
INSERT INTO schule_daten VALUES("730","1","Staatliche Realschule Mering   ","Realschule","Staatlich","Amberieustr. 5","86415","Mering","http://www.realschule-mering.de","sekretariat@realschule-mering.de");
INSERT INTO schule_daten VALUES("731","1","Staatliche Realschule Oberg&uuml;nzburg   ","Realschule","Staatlich","Nikolausberg 3","87634","Oberg&uuml;nzburg","http://www.realschule-oberguenzburg.de","mailto@realschule-oberguenzburg.de");
INSERT INTO schule_daten VALUES("732","1","Franz-von-Lenbach-Schule Staatliche Realschule f&uuml;r Knaben Schrobenhausen ","Realschule","Staatlich","Georg-Leinfelder-Str. 18","86529","Schrobenhausen","http://www.fvls.de","christine.gradwohl@fvls.de");
INSERT INTO schule_daten VALUES("733","1","Sophie-Scholl-Realschule Staatl. Realschule f&uuml;r M&auml;dchen Weiden ","Realschule","Staatlich","Kurt-Schumacher-Allee 8","92637","Weiden","http://www.sophie-scholl-rs.de","sekretariat@sophie-scholl-rs.de");
INSERT INTO schule_daten VALUES("735","1","St&auml;dtische Werner-von-Siemens- Realschule M&uuml;nchen  ","Realschule","Staatlich","Quiddestr. 4","81735","M&uuml;nchen","http://www.wsr.musin.de","werner-von-siemens-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("736","1","Franz-Xaver-von-Sch&ouml;nwerth- Realschule Staatliche Realschule Amberg ","Realschule","Staatlich","Fuggerstr. 15","92224","Amberg","http://www.rs-amberg.de","mail@srsamberg.de");
INSERT INTO schule_daten VALUES("737","1","Joseph-von-Fraunhofer-Schule Staatl. Realschule M&uuml;nchen II  ","Realschule","Staatlich","Engadiner Str. 1","81475","M&uuml;nchen","http://www.fraunhofer-rs.musin.de","joseph-von-fraunhofer-schule@muenchen.de");
INSERT INTO schule_daten VALUES("738","1","Staatliche Realschule Simbach a.Inn  ","Realschule","Staatlich","Kirchenplatz 2","84359","Simbach","http://www.realschule-simbach.de","sekretariat@srs-simbach.de");
INSERT INTO schule_daten VALUES("739","1","Walter-Klingenbeck-Schule Staatliche Realschule Taufkirchen  ","Realschule","Staatlich","K&ouml;glweg 104","82024","Taufkirchen","http://www.walter-klingenbeck-realschule.de","sekretariat@wkrs.de");
INSERT INTO schule_daten VALUES("740","1","Staatliche Realschule Unterpfaffenhofen in Germering  ","Realschule","Staatlich","Masurenweg 4","82110","Germering","http://www.realschule-unterpfaffenhofen.de","verwaltung@rs-unterpfaffenhofen.de");
INSERT INTO schule_daten VALUES("741","1","Private Isar-Realschule M&uuml;nchen   ","Realschule","Privat","Kohlstr. 5","80469","M&uuml;nchen","http://www.schulverbund.de/Isar-Realschule.html","kontakt@schulverbund.de");
INSERT INTO schule_daten VALUES("742","1","Adolf-Reichwein-Schule N&uuml;rnberg -Private Realschule-  ","Realschule","Privat","Schleifweg 39","90409","N&uuml;rnberg","http://www.ars-nbg.de","schulleitung@arsnbg.de");
INSERT INTO schule_daten VALUES("743","1","Staatliche Realschule H&ouml;sbach   ","Realschule","Staatlich","An der Maas","63768","H&ouml;sbach","http://www.rs-hoesbach.de","mail@rs-hoesbach.de");
INSERT INTO schule_daten VALUES("744","1","Ludwig-Fronhofer-Schule Staatl. Realschule Ingolstadt II  ","Realschule","Staatlich","Maximilianstr. 25","85051","Ingolstadt","http://www.fronhofer-realschule.de","FRI@Fronhofer-Realschule.de");
INSERT INTO schule_daten VALUES("745","1","Siegmund-Loewe-Schule Staatliche Realschule Kronach II  ","Realschule","Staatlich","Am Schulzentrum 3","96317","Kronach","http://www.rs2-kronach.de","verwaltung@rs2-kronach.de");
INSERT INTO schule_daten VALUES("746","1","Staatl. Realschule N&uuml;rnberg III   ","Realschule","Staatlich","Am Fernmeldeturm 3","90441","N&uuml;rnberg","http://www.rs-nuernberg3.de","verwaltung@rs-nuernberg3.de");
INSERT INTO schule_daten VALUES("747","1","Staatliche Realschule Pei&szlig;enberg   ","Realschule","Staatlich","Sonnenstr. 29","82380","Pei&szlig;enberg","http://rs-peissenberg.de","sekretariat@rs-peissenberg.org");
INSERT INTO schule_daten VALUES("748","1","CJD Christophorusschule Berchtesgaden Staatl. anerk. Realschule in Sch&ouml;nau","Realschule","Privat","Alte K&ouml;nigsseer Str. 35","83471","Sch&ouml;nau","http://www.realschule-bgd.de","realschule.berchtesgaden@cjd.de");
INSERT INTO schule_daten VALUES("749","1","Kommunale Realschule Prien am Chiemsee  ","Realschule","Staatlich","Valdagno-Platz 1","83209","Prien","http://www.realschule-prien.de","dorsch@realschule-prien.de");
INSERT INTO schule_daten VALUES("750","1","St&auml;dtische Realschule an der Blutenburg M&uuml;nchen  ","Realschule","Staatlich","Grandlstr. 5","81247","M&uuml;nchen","http://www.rsb.musin.de","realschule-an-der-blutenburg@muenchen.de");
INSERT INTO schule_daten VALUES("754","1","Priv. Sabel-Realschule im Zentrum M&uuml;nchen  ","Realschule","Privat","Schwanthalerstr. 51-53a","80336","M&uuml;nchen","http://www.sabel.com","info@sabel.com");
INSERT INTO schule_daten VALUES("755","1","Dientzenhofer-Schule Staatliche Realschule Brannenburg  ","Realschule","Staatlich","Kirchenstr. 40a","83098","Brannenburg","http://www.rs-brannenburg.de","sekretariat@rs-brannenburg.de");
INSERT INTO schule_daten VALUES("756","1","Therese-Giehse-Realschule Staatl. Realschule Unterschlei&szlig;heim  ","Realschule","Staatlich","M&uuml;nchner Ring 8","85716","Unterschlei&szlig;heim","http://www.tgrs.de","sekretariat@tgrs.de");
INSERT INTO schule_daten VALUES("757","1","Nymphenburger Realschule M&uuml;nchen des Schulvereins Ernst Adam e.V.  ","Realschule","Privat","Sadelerstr. 10","80638","M&uuml;nchen","http://www.nymphenburger-schulen.de","sekretariat@nymphenburger-schulen.de");
INSERT INTO schule_daten VALUES("758","1","Johann-Andreas-Schmeller-Realschule Staatliche Realschule Ismaning  ","Realschule","Staatlich","An der Torfbahn 5","85737","Ismaning","http://www.rs-ismaning.de","info@rs-ismaning.de");
INSERT INTO schule_daten VALUES("759","1","Leonhard-Wagner-Realschule Staatl. Realschule Schwabm&uuml;nchen  ","Realschule","Staatlich","Breitweg 16","86830","Schwabm&uuml;nchen","http://www.realschule-schwabmuenchen.de","sekretariat@rsschwabmuenchen.de");
INSERT INTO schule_daten VALUES("760","1","St&auml;dt. Erich K&auml;stner-Realschule M&uuml;nchen  ","Realschule","Staatlich","Petrarcastr. 1","80933","M&uuml;nchen","http://www.ekr.musin.de","erich-kaestner-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("763","1","Priv. Realschule Huber in M&uuml;nchen   ","Realschule","Privat","Kohlstr. 5, Haus 2","80469","M&uuml;nchen","http://www.schulverbund.de/Huber-Realschule.html","kontakt@schulverbund.de");
INSERT INTO schule_daten VALUES("764","1","Achental-Realschule Staatl. Realschule Marquartstein  ","Realschule","Staatlich","Lanzinger Str. 12","83250","Marquartstein","http://www.achental-realschule.de","verwaltung@rsma.bayern.de");
INSERT INTO schule_daten VALUES("765","1","Staatliche Realschule Vaterstetten in Baldham  ","Realschule","Staatlich","Neue Poststr. 6","85598","Baldham","http://www.realschule-vaterstetten.de","verwaltung@realschule-vaterstetten.de");
INSERT INTO schule_daten VALUES("766","1","Zugspitz-Realschule Staatl. Realschule f&uuml;r Knaben Garmisch-Partenkirchen ","Realschule","Staatlich","Gamsangerweg 1","82467","Garmisch-Partenkirchen","http://www.rs-gap.de","sekretariat@rs-gap.de");
INSERT INTO schule_daten VALUES("767","1","Staatliche Realschule Neus&auml;&szlig;   ","Realschule","Staatlich","Landrat-Dr.-Frey-Str. 8","86356","Neus&auml;&szlig;","http://www.realschule-neusaess.de","sekretariat@rsneusaess.de");
INSERT INTO schule_daten VALUES("768","1","Staatliche Realschule Puchheim   ","Realschule","Staatlich","Bgm.-Ertl-Str. 9","82178","Puchheim","http://www.realschule-puchheim.de","verwaltung@rs-puchheim.de");
INSERT INTO schule_daten VALUES("769","1","St&auml;dtische Wilhelm-Busch- Realschule M&uuml;nchen  ","Realschule","Staatlich","Krehlebogen 16","81737","M&uuml;nchen","http://www.wbr.musin.de","wilhelm-busch-realschule@muenchen.de");
INSERT INTO schule_daten VALUES("771","1","Vision private staatlich-genehmigte Realschule mit Internat der Vision Privatschulen GmbH Jettingen-Scheppach","Realschule","Privat","Hauptstr. 240","89343","Jettingen-Scheppach","http://www.vision-privatschulen.de","info@vision-privatschulen.de");
INSERT INTO schule_daten VALUES("772","1","St&auml;dtische Bertolt-Brecht-Schule N&uuml;rnberg - Realschule -  ","Realschule","Staatlich","Bertolt-Brecht-Str. 39","90471","N&uuml;rnberg","http://www.bbgs.de","bbs-realschule@stadt.nuernberg.de");
INSERT INTO schule_daten VALUES("773","1","Private staatl. anerkannte Sabel-Realschule N&uuml;rnberg  ","Realschule","Privat","Eilgutstr. 10","90443","N&uuml;rnberg","http://www.sabel.de","info@sabel.com");
INSERT INTO schule_daten VALUES("774","1","Private Novalis-Realschule der neuhof-Schulen M&uuml;nchen  ","Realschule","Privat","Steinerstr. 16","81369","M&uuml;nchen","http://www.neuhof-schulen.de","a.richter@neuhof-schulen.de");
INSERT INTO schule_daten VALUES("775","1","Geschwister-Scholl-Realschule Staatl. Realschule N&uuml;rnberg II  ","Realschule","Staatlich","Muggenhoferstr. 122","90429","N&uuml;rnberg","http://www.gsr-nuernberg.de","verwaltung@gsr-nuernberg.de");
INSERT INTO schule_daten VALUES("776","1","Staatl. Realschule Zusmarshausen   ","Realschule","Staatlich","Stadionstr. 4","86441","Zusmarshausen","http://www.rszusmarshausen.de","sekretariat@rszusmarshausen.de");
INSERT INTO schule_daten VALUES("777","1","Coelestin-Maier-Realschule Schweiklberg in Vilshofen  ","Realschule","Privat","Schweiklberg 1","94474","Vilshofen","http://www.realschuleschweiklberg.de","schulverwaltung@schweiklberg.de");
INSERT INTO schule_daten VALUES("778","1","Staatl. Realschule H&ouml;chstadt a.d.Aisch  ","Realschule","Staatlich","Rothenburger Str. 10","91315","H&ouml;chstadt","www.realschule-hoechstadt.de","verwaltung@realschule-hoechstadt.de");
INSERT INTO schule_daten VALUES("779","1","Staatl. Realschule K&ouml;sching   ","Realschule","Staatlich","Ingolst&auml;dter Str. 111","85092","K&ouml;sching","www.realschule-koesching.de","Post@Realschule-Koesching.de");
INSERT INTO schule_daten VALUES("950","1","Rudolf-Diesel-Gymnasium Augsburg ","Gymnasium","Staatlich","Peterhofstr. 9","86163","Augsburg","http://www.rdg-online.de","rdg@augsburg.de");
INSERT INTO schule_daten VALUES("951","1","Ignaz-K&ouml;gler-Gymnasium Landsberg am Lech","Gymnasium","Staatlich","Lechstr. 6","86899","Landsberg","http://www.ikg-landsberg.de","sekretariat@ikg-landsberg.de");
INSERT INTO schule_daten VALUES("952","1","Gymnasium Neubiberg ","Gymnasium","Staatlich","Bahnhofplatz 4","85635","H&ouml;henkirchen-Siegertsbrunn","http://www.gymnasium-neubiberg.de","wozniak@gymnasium-neubiberg.de");
INSERT INTO schule_daten VALUES("953","1","Frankenwald-Gymnasium Kronach ","Gymnasium","Staatlich","Am Schulzentrum 5","96317","Kronach","http://www.frankenwald-gymnasium.de","sekretariat@frankenwald-gymnasium.de");
INSERT INTO schule_daten VALUES("954","1","Gymnasium Oberhaching ","Gymnasium","Staatlich","Kastanienallee 20","82041","Oberhaching","http://www.gymnasium-oberhaching.de","sekretariat@ohagym.de&nbsp;");
INSERT INTO schule_daten VALUES("955","1","Feodor-Lynen-Gymnasium Planegg ","Gymnasium","Staatlich","Feodor-Lynen-Str. 2","82152","Planegg","http://www.flg-online.de","sekretariat@flg-online.de");
INSERT INTO schule_daten VALUES("956","1","Jenaplan-Gymnasium F&uuml;rth der Jenaplan Gymnasium N&uuml;rnberg gemeinn&uuml;tzige Genossenschaft ","Gymnasium","Privat","Pfisterstr. 25","90762","F&uuml;rth","http://www.jenaplangymnasium.de/","info@jenaplangymnasium.de");
INSERT INTO schule_daten VALUES("957","1","G&uuml;nter-St&ouml;hr-Gymnasium im St. Anna Schulverbund, Icking","Gymnasium","Privat","Zeller Weg 27","82057","Icking","http://www.st-anna.eu","info@st-anna.eu");
INSERT INTO schule_daten VALUES("958","1","Gymnasium Immenstadt ","Gymnasium","Staatlich","Allg&auml;uer Str. 7/9","87509","Immenstadt","http://www.gymnasium-immenstadt.de","verwaltung@gymnasium-immenstadt.de");
INSERT INTO schule_daten VALUES("959","1","Carl-Orff-Gymnasium Unterschlei&szlig;heim","Gymnasium","Staatlich","M&uuml;nchner Ring 6","85716","Unterschlei&szlig;heim","http://www.carl-orff-gym.de","sekretariat@carl-orff-gym.de");
INSERT INTO schule_daten VALUES("960","1","Leonhard-Wagner-Gymnasium Schwabm&uuml;nchen","Gymnasium","Staatlich","Breitweg 16","86830","Schwabm&uuml;nchen","http://www.lwg-smue.de","werner.altmann@lwg-smue.de");
INSERT INTO schule_daten VALUES("961","1","St&auml;dtisches Lion-Feuchtwanger- Gymnasium M&uuml;nchen","Gymnasium","Staatlich","Freiligrathstr. 71","80807","M&uuml;nchen","http://www.lfg.musin.de","lion-feuchtwanger-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("962","1","St&auml;dtisches Heinrich-Heine- Gymnasium M&uuml;nchen","Gymnasium","Staatlich","Max-Reinhardt-Weg 27","81739","M&uuml;nchen","http://www.hhg-muenchen.de","&nbsp;heinrich-heine-gymnasium@muenchen.de");
INSERT INTO schule_daten VALUES("963","1","Carl-Spitzweg-Gymnasium Unterpfaffenhofen in Germering","Gymnasium","Staatlich","Masurenweg 2","82110","Germering","http://www.csg-germering.de","sektretariat@csg-germering.de");
INSERT INTO schule_daten VALUES("964","1","Gymnasium Stein ","Gymnasium","Staatlich","Faber-Castell-Allee 10","90547","Stein","http://www.gymnasium-stein.de","verwaltung@gymnasium-stein.de.");
INSERT INTO schule_daten VALUES("965","1","Senefelder-Schule Treuchtlingen -Gymnasialzug-","Gymnasium","Staatlich","Bgm.-D&ouml;bler-Allee 3","91757","Treuchtlingen","http://www.senefelder-schule.de","M.Klischat@ZwV-SfSchule.de");
INSERT INTO schule_daten VALUES("966","1","Wolfgang-Borchert-Gymnasium Langenzenn","Gymnasium","Staatlich","Sportplatzstr. 2","90579","Langenzenn","http://www.wbg-lgz.de","verwaltung@wbg-lgz.de");
INSERT INTO schule_daten VALUES("967","1","Gymnasium Gr&ouml;benzell ","Gymnasium","Staatlich","Wildmoosstr. 34","82194","Gr&ouml;benzell","http://gymnasiumgroebenzell.de","sekretariat@gymnasiumgroebenzell.de");
INSERT INTO schule_daten VALUES("968","1","Gymnasium Penzberg ","Gymnasium","Staatlich","Karlstr. 38-42","82377","Penzberg","http://www.gymnasium-penzberg.de","Sektretariat@gymnasium-penzberg.de");
INSERT INTO schule_daten VALUES("969","1","Gymnasium Veitsh&ouml;chheim ","Gymnasium","Staatlich","G&uuml;nterslebener Str. 45","97209","Veitsh&ouml;chheim","http://www.gymnasium-veitshoechheim.de","sekretariat@gym-vhh.bayern.de");
INSERT INTO schule_daten VALUES("970","1","Ehrenb&uuml;rg-Gymnasium Forchheim ","Gymnasium","Staatlich","Ruhalmstr. 5","91301","Forchheim","http://www.egf-online.de","sekretariat@egf-online.de");
INSERT INTO schule_daten VALUES("971","1","Gymnasium Kirchheim b.M&uuml;nchen ","Gymnasium","Staatlich","Heimstettner Str. 3","85551","Kirchheim","http://www.gymnasium-kirchheim.de","mail@gymnasium-kirchheim.de");
INSERT INTO schule_daten VALUES("972","1","Oskar-Maria-Graf-Gymnasium Neufahrn b.Freising","Gymnasium","Staatlich","Keltenweg 5","85375","Neufahrn","http://www.Oskar-Maria-Graf-Gymnasium.de","Verwaltung@omg-gym.de");
INSERT INTO schule_daten VALUES("973","1","Hallertau-Gymnasium Wolnzach ","Gymnasium","Staatlich","Sportweg 10","85283","Wolnzach","http://www.hallertau-gymnasium.eu","sekretariat@hallertau-gymnasium.eu");
INSERT INTO schule_daten VALUES("974","1","Gymnasium Huber M&uuml;nchen - Schule in freier Tr&auml;gerschaft -","Gymnasium","Privat","Kohlstr. 5","80469","M&uuml;nchen","http://www.schulverbund.de/Huber-Gymnasium.html","kontakt@schulverbund.de");
INSERT INTO schule_daten VALUES("976","1","Gymnasium Eckental ","Gymnasium","Staatlich","Neunkirchener Str. 1","90542","Eckental","http://www.gymnasium-eckental.de","sekretariat@gymeck.de");
INSERT INTO schule_daten VALUES("977","1","Privates Neuhof-Gymnasium M&uuml;nchen","Gymnasium","Privat","Steinerstr. 16","81369","M&uuml;nchen","http://www.neuhof-schulen.de","info@neuhof-schulen.de");
INSERT INTO schule_daten VALUES("978","1","Gymnasium Markt Indersdorf ","Gymnasium","Staatlich","Arnbacher Str. 40","85229","Markt Indersdorf","http://www.gym-indersdorf.de","sekretariat@gym-indersdorf.de");
INSERT INTO schule_daten VALUES("979","1","St&auml;dtische Bertolt-Brecht-Schule N&uuml;rnberg -Gymnasium-","Gymnasium","Staatlich","Bertolt-Brecht-Str. 39","90471","N&uuml;rnberg","http://www.bbgs.de","bertolt-brecht-schule@stadt.nuernberg.de");
INSERT INTO schule_daten VALUES("980","1","Montessori-Schule Gut Biberkor Gymnasium Berg-H&ouml;henrain","Gymnasium","Privat","Biberkorstr. 17","82335","Berg","http://www.montessori-biberkor.de","verein@montessori-biberkor.de");
INSERT INTO schule_daten VALUES("981","1","Gymnasium Beilngries ","Gymnasium","Staatlich","Sandstr. 27","92339","Beilngries","http://www.gymnasium-beilngries.de","sekretariat@gymnasium-beilngries.de");
INSERT INTO schule_daten VALUES("982","1","Privates Novalis-Gymnasium der neuhof-Schulen M&uuml;nchen","Gymnasium","Privat","Steinerstr. 16","81369","M&uuml;nchen","http://www.neuhof-schulen.de","info@neuhof-schulen.de");
INSERT INTO schule_daten VALUES("983","1","Gymnasium Bruckm&uuml;hl ","Gymnasium","Staatlich","Kirchdorfer Str. 21","83052","Bruckm&uuml;hl","http://www.gymnasium-bruckmuehl.de","sekretariat@gymnasium-bruckmuehl.de");
INSERT INTO schule_daten VALUES("984","1","Julius-Lohmann-Gymnasium Schondorf Staatl. genehmigt (wirtschafts- u. sozialwiss. Ausbildungsrichtung)","Gymnasium","Privat","Landheimstr. 1","86938","Schondorf","http://www.landheim-schondorf.de","landheim@landheim-schondorf.de");
INSERT INTO schule_daten VALUES("985","1","Privatgymnasium Holzkirchen ","Gymnasium","Privat","Krankenhausstr. 7","83607","Holzkirchen","http://www.ganztagsschule.de","sekretariat@ganztagsschule.de");
INSERT INTO schule_daten VALUES("986","1","Korbinian-Aigner-Gymnasium Erding ","Gymnasium","Staatlich","Sigwolfstr. 50","85435","Erding","http://www.kag-erding.de","verwaltung@kag-erding.de");
INSERT INTO schule_daten VALUES("987","1","Ammersee-Gymnasium Die&szlig;en ","Gymnasium","Staatlich","Die&szlig;ener Str. 100","86911","Die&szlig;en","http://www.amseegym.de","sekretariat@amseegym.de");
INSERT INTO schule_daten VALUES("989","1","Staatliches Gymnasium Kirchseeon ","Gymnasium","Staatlich","Moosacher Str. 3","85614","Kirchseeon","http://www.gymnasium-kirchseeon.de","info@gymnasium-kirchseeon.de");
INSERT INTO schule_daten VALUES("991","1","SIS Swiss International School Ingolstadt - Gymnasium in Tr&auml;ger- schaft der SIS Swiss International School gemeinn&uuml;tzige GmbH","Gymnasium","Privat","Jurastr. 2","85049","Ingolstadt","http://www.swissinternationalschool.de/","info@swissinternationalschool.de.");
INSERT INTO schule_daten VALUES("992","1","Vision naturwissenschaftlich- technologisches Privatgymnasium mit Internat der Vision Privatschulen gemeinn. GmbH Jettingen-Scheppach","Gymnasium","Privat","Hauptstr. 240","89343","Jettingen-Scheppach","http://www.vision-privatschulen.de","info@vision-privatschulen.de");
INSERT INTO schule_daten VALUES("993","1","Gymnasium Gaimersheim ","Gymnasium","Staatlich","Am Hochholzer Berg 2","85080","Gaimersheim","http://www.gymnasium-gaimersheim.de","sekretariat@gymnasium-gaimersheim.de");
INSERT INTO schule_daten VALUES("994","1","Privates Gymnasium des Private Oberlandschulen e.V. Weilheim ","Gymnasium","Privat","Leprosenweg 14","82362","Weilheim","http://www.oberlandschulen.de","oberlandschulen@oberlandschulen.de");
INSERT INTO schule_daten VALUES("995","1","Lukas-Schule M&uuml;nchen Priv. evangelisches Gymnasium des Lukas-Schule e.V. M&uuml;nchen ","Gymnasium","Privat","Riegerhofstr. 18","80687","M&uuml;nchen","http://www.lukas-schule.de","sekretariat.gym@lukas-schule.de");
INSERT INTO schule_daten VALUES("996","1","Dag-Hammarskj&ouml;ld-Gymnasium Priv. wirtschafts- u.sozialwiss. u. naturwissenschaftlich-techn.Gymn. d.Evang.Gymn.W&uuml;rzb.gemeinn. GmbH","Gymnasium","Privat","Frauenlandplatz 5","97070","W&uuml;rzburg","http://www.evdhg.de","info@evdhg.de");
INSERT INTO schule_daten VALUES("998","1","SIS Swiss International School Regensburg in Regenstauf - Priv. Gymnasium der SIS Swiss International School gemeinn. GmbH","Gymnasium","Privat","Dr.-Robert-Eckert-Str. 3","93128","Regenstauf","http://www.swissinternationalschool.de/Schulstandorte/Regensburg","info.regensburg@swissinternationalschool.de.");



DROP TABLE studie_buchung;

CREATE TABLE `studie_buchung` (
  `BuchungsID` int(11) NOT NULL AUTO_INCREMENT,
  `TerminID` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `ende` datetime NOT NULL,
  `SchulNr` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `vname` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `tel` tinytext NOT NULL,
  `anzKollegen` tinyint(4) NOT NULL,
  `parameter` text NOT NULL,
  `confirmed` int(11) NOT NULL,
  PRIMARY KEY (`BuchungsID`),
  KEY `TerminID` (`TerminID`),
  CONSTRAINT `studie_buchung_ibfk_1` FOREIGN KEY (`TerminID`) REFERENCES `studie_termine` (`TerminID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

INSERT INTO studie_buchung VALUES("8","1","2017-06-19 13:00:00","2017-06-19 14:30:00","175","Mayer","Peter","peter.mayer@fit4exam.de","01753575666","8","{\"bem\":\"keine Bemerkungen\"}","0");
INSERT INTO studie_buchung VALUES("9","1","2017-06-19 13:00:00","2017-06-19 14:30:00","175","Mayer","Peter","peter.mayer@fit4exam.de","01753575666","8","{\"bem\":\"keine Bemerkungen\"}","0");
INSERT INTO studie_buchung VALUES("10","1","2017-06-19 13:00:00","2017-06-19 14:30:00","174","M&uuml;ller","Max","peter.mayer@fit4exam.de","01753575666","15","{\"bem\":\"Test\"}","0");
INSERT INTO studie_buchung VALUES("11","2","2017-06-20 13:00:00","2017-06-20 15:00:00","175","Mayer","Peter","pe.mayer@lmu.de","+498921802860","9","{\"bem\":\"\"}","0");
INSERT INTO studie_buchung VALUES("12","2","2017-06-20 13:00:00","2017-06-20 15:00:00","175","Mayer","Peter","peter.mayer@pemasoft.de","01753575666","5","{\"bem\":\"\"}","0");
INSERT INTO studie_buchung VALUES("13","2","2017-06-20 13:00:00","2017-06-20 15:00:00","175","Mayer","Peter","pe.mayer@lmu.de","+498921802860","5","{\"bem\":\"\"}","0");



DROP TABLE studie_termine;

CREATE TABLE `studie_termine` (
  `TerminID` int(11) NOT NULL AUTO_INCREMENT,
  `start` datetime NOT NULL,
  `ende` datetime NOT NULL,
  `aktiv` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0: Termin ausblenden',
  PRIMARY KEY (`TerminID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO studie_termine VALUES("1","2017-06-19 13:00:00","2017-06-19 16:00:00","1");
INSERT INTO studie_termine VALUES("2","2017-06-20 13:00:00","2017-06-20 17:00:00","1");
INSERT INTO studie_termine VALUES("3","2017-06-21 13:00:00","2017-06-21 17:00:00","1");



DROP TABLE user;

CREATE TABLE `user` (
  `uID` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `vname` tinytext NOT NULL,
  `geschlecht` tinytext NOT NULL COMMENT 'm oder w',
  `email` tinytext NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `resetToken` text NOT NULL,
  `bundesland` int(11) NOT NULL,
  `SchulNr` int(11) NOT NULL,
  `registered` datetime NOT NULL,
  `lastEdit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `registerToken` tinytext NOT NULL,
  PRIMARY KEY (`uID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

INSERT INTO user VALUES("1","Mayer","Peter","m","pe.mayer@lmu.de","MPe","a581df48af5a4384472e9c00ecd09413b91bd7d002d12334ae4ad85f8661cb6747053fe833d0983818a19211fa1a9161b5535774c9258e1ade88fb5929f9a3fd","588241ebeafe5","1","175","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO user VALUES("5","Test123","VTest","m","peter.mayer@mytum.de","MPe2","a581df48af5a4384472e9c00ecd09413b91bd7d002d12334ae4ad85f8661cb6747053fe833d0983818a19211fa1a9161b5535774c9258e1ade88fb5929f9a3fd","1bc182b660cac0182782e3fd6a5337b76163a212","1","33","0000-00-00 00:00:00","2017-06-24 11:33:55","");
INSERT INTO user VALUES("26","Test21","Test3","m","test@test.de","MPe3","3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2","","1","182","0000-00-00 00:00:00","2017-03-13 10:22:45","");
INSERT INTO user VALUES("27","Schweinberger","Matthias","m","M.Schweinberger1@physik.uni-muenchen.de","Sch","3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2","","1","302","2017-03-13 09:05:03","2017-03-13 10:34:59","");
INSERT INTO user VALUES("28","Testreg","Tr1","w","test@test.de","MPe_Test","3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2","","1","226","2017-03-13 10:12:57","2017-03-13 11:12:57","");
INSERT INTO user VALUES("36","TestRegToken","test","w","test@test.de","TokReg","3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2","","1","284","2017-03-13 11:00:02","2017-03-13 12:00:02","58c67b1ad2ef4");
INSERT INTO user VALUES("37","Mustermann","Max","m","admin@pemasoft.de","muster","3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2","","1","24","2017-06-26 05:40:11","2017-06-26 07:40:11","");
INSERT INTO user VALUES("38","Mayer","Peter","m","peter.mayer@mytum.de","MPe_27_06","3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2","","1","175","2017-06-27 08:23:12","2017-06-27 10:23:12","");
INSERT INTO user VALUES("39","Mayer","Peter","m","peter.mayer@fit4exam.de","MPe_0815","3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2","","1","175","2017-06-27 08:23:49","2017-06-27 10:23:49","");



DROP TABLE user_groups;

CREATE TABLE `user_groups` (
  `uGroupID` int(11) NOT NULL AUTO_INCREMENT,
  `titel` tinytext NOT NULL,
  PRIMARY KEY (`uGroupID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO user_groups VALUES("1","Admin");
INSERT INTO user_groups VALUES("2","Lehrer");
INSERT INTO user_groups VALUES("3","Fachbetreuer");
INSERT INTO user_groups VALUES("4","Lehrstuhl");



DROP TABLE user_teilnehmer;

CREATE TABLE `user_teilnehmer` (
  `tnID` int(11) NOT NULL AUTO_INCREMENT,
  `geschlecht` varchar(1) NOT NULL COMMENT 'm:Mann; w:Frau',
  `name` tinytext NOT NULL,
  `vname` tinytext NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `uID` int(11) NOT NULL COMMENT 'uID des Workshopinhabers',
  `preview_account` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1: wird automatisch für Kurseigentümer erstellt falls er nicht existiert',
  `token` tinytext NOT NULL,
  `aktualisiert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tnID`),
  KEY `uID` (`uID`),
  CONSTRAINT `user_teilnehmer_ibfk_1` FOREIGN KEY (`uID`) REFERENCES `user` (`uID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=258 DEFAULT CHARSET=utf8;

INSERT INTO user_teilnehmer VALUES("35","m","Mayer","Peter","pe.mayer@lmu.de","1","1","587cf6ad35732","2017-06-26 07:24:33");
INSERT INTO user_teilnehmer VALUES("36","m","Name_3","vName_3.2","email_3@anonymous.de","1","0","587cfb3be2c82","2017-01-16 18:17:39");
INSERT INTO user_teilnehmer VALUES("38","m","Name_3","vName_3.2","email_3@anonymous.de","1","0","587cfb68d369f","2017-01-16 18:17:39");
INSERT INTO user_teilnehmer VALUES("39","m","Name_1","vName_1","email_1@anonymous.de","1","0","587cff5edb0f4","2017-01-16 18:18:39");
INSERT INTO user_teilnehmer VALUES("40","m","Name_2xxx","vName_2","email_2@anonymous.de","1","0","587cff5edbcb5","2017-01-31 08:00:28");
INSERT INTO user_teilnehmer VALUES("41","m","Name_3","vName_3","email_3@anonymous.de","1","0","587cff5edc3cd","2017-01-16 18:18:53");
INSERT INTO user_teilnehmer VALUES("42","m","Name_4","vName_4","email_4@anonymous.de","1","0","587cff5edcb5d","2017-01-16 18:19:00");
INSERT INTO user_teilnehmer VALUES("43","m","Name_5","vName_5","email_5@anonymous.de","1","0","587cffcbc267d","2017-01-16 18:19:05");
INSERT INTO user_teilnehmer VALUES("51","m","Name_6","vName_6","email_6@anonymous.de","1","0","587d016e33149","2017-01-16 18:22:54");
INSERT INTO user_teilnehmer VALUES("86","m","Mayer","Peter","peter.mayer@test.de","1","0","587d1558a6ecc","2017-01-16 19:47:52");
INSERT INTO user_teilnehmer VALUES("102","m","Schweinberger","Matthias","M.Schweinberger1@physik.uni-muenchen.de","1","0","587e1536d41d3","2017-01-31 22:47:29");
INSERT INTO user_teilnehmer VALUES("107","W","Beyer","Veronika","V.Beyer@campus.lmu.de","1","0","58176dc7074dd","2017-02-02 20:11:40");
INSERT INTO user_teilnehmer VALUES("108","m","Jahreis","Miriam Babette","Miriam.Jahreis@campus.lmu.de","1","0","58176dc7078f6","2017-02-02 20:11:40");
INSERT INTO user_teilnehmer VALUES("109","m","Mergner","Lisa Sophia","Lisa.Mergner@campus.lmu.de","1","0","58176dc707f04","2017-02-02 20:13:39");
INSERT INTO user_teilnehmer VALUES("110","m","Schuster","Lisa Melanie","Schuster.Lisa@campus.lmu.de","1","0","58176dc708269","2017-02-02 20:13:39");
INSERT INTO user_teilnehmer VALUES("111","M","Hartmann","Frederik","Frederik.Hartmann@campus.lmu.de","1","0","58176dc708648","2017-02-02 20:13:39");
INSERT INTO user_teilnehmer VALUES("112","M","Hlatky","Stephan","S.Hlatky@campus.lmu.de","1","0","58176dc7089bb","2017-02-02 20:13:39");
INSERT INTO user_teilnehmer VALUES("113","M","Jahn","Tobias","T.Jahn@campus.lmu.de","1","0","58176dc708eca","2017-02-02 20:13:39");
INSERT INTO user_teilnehmer VALUES("114","M","Sparrer","Bernhard","Bernhard.Sparrer@campus.lmu.de","1","0","58176dc7092cd","2017-02-02 20:13:39");
INSERT INTO user_teilnehmer VALUES("115","M","Naun","Todi","Naun.Todi@campus.lmu.de","1","0","58176dc709715","2017-02-02 20:13:39");
INSERT INTO user_teilnehmer VALUES("116","M","Vorderobermeier","Andreas","A.Vorderobermeier@campus.lmu.de","1","0","58176dc709a90","2017-02-02 20:13:39");
INSERT INTO user_teilnehmer VALUES("117","m","Eichenseer","Dominikus Matthias","D.Eichenseer@campus.lmu.de","1","0","58176dc70a103","2017-02-02 20:13:39");
INSERT INTO user_teilnehmer VALUES("118","M","Perl","Tobias","Tobias.Perl@campus.lmu.de","1","0","58176dc70a458","2017-02-02 20:13:39");
INSERT INTO user_teilnehmer VALUES("119","m","Dünnbier","Nikolaus","N.Duennbier@campus.lmu.de","1","0","58176dc70a7d1","2017-02-02 20:13:39");
INSERT INTO user_teilnehmer VALUES("120","m","Fischer","Maria Franziska","Fischer_F@gmx.de","1","0","58176dc70b05b","2017-02-02 20:13:39");
INSERT INTO user_teilnehmer VALUES("121","m","Brus","Gordon Brian","Bri.Brus@campus.lmu.de","1","0","58177f62908cc","2017-02-02 20:15:32");
INSERT INTO user_teilnehmer VALUES("122","m","Schönauer","Valerie Loulou","Valerie.Schoenauer@campus.lmu.de","1","0","58177f6290dde","2017-02-02 20:15:32");
INSERT INTO user_teilnehmer VALUES("123","M","Naujoks","Andre","Andre.Naujoks@gmx.de","1","0","58177f629184a","2017-02-02 20:15:32");
INSERT INTO user_teilnehmer VALUES("124","M","Yurchak","Patrick","patrickcyurchak@aol.com","1","0","58177f6293e5b","2017-02-02 20:15:32");
INSERT INTO user_teilnehmer VALUES("125","m","Bach","Anton Michael","A.Bach@campus.lmu.de","1","0","58177f62942ac","2017-02-02 20:15:32");
INSERT INTO user_teilnehmer VALUES("126","m","Götzinger","Thomas","Thomas.Goetzinger@campus.lmu.de","1","0","58177f629478d","2017-02-02 20:15:32");
INSERT INTO user_teilnehmer VALUES("127","M","Artinger","Thomas","Thomas.Artinger@campus.lmu.de","1","0","58177f6294c4f","2017-02-02 20:15:32");
INSERT INTO user_teilnehmer VALUES("128","m","Höldrich","Christian Manfred","Christian.Hoeldrich@campus.lmu.de","1","0","58177f62950d4","2017-02-02 20:15:32");
INSERT INTO user_teilnehmer VALUES("129","M","Behrens","Sven","Sven.Behrens@campus.lmu.de","1","0","58177f6295564","2017-02-02 20:15:32");
INSERT INTO user_teilnehmer VALUES("130","m","Fischer","Yvo Valentin","Yvo.Fischer@campus.lmu.de","1","0","58177f6295bcc","2017-02-02 20:15:32");
INSERT INTO user_teilnehmer VALUES("131","m","Köbli","Adrian","koebli315@gmail.com","1","0","58177f629605f","2017-02-02 20:15:32");
INSERT INTO user_teilnehmer VALUES("132","m","Kulartz","Matthias Dominik","M.Kulartz@campus.lmu.de","1","0","58177f62966f0","2017-02-02 20:15:32");
INSERT INTO user_teilnehmer VALUES("135","m","Name_1","vName_1","email_1@anonymous.de","1","0","58a8a81f420db","2017-02-18 21:01:35");
INSERT INTO user_teilnehmer VALUES("136","m","Name_2","vName_2","email_2@anonymous.de","1","0","58a8a81f42c81","2017-02-18 21:01:35");
INSERT INTO user_teilnehmer VALUES("137","w","Name_3","vName_3","email_3@anonymous.de","1","0","58a8a81f435bf","2017-02-18 21:01:35");
INSERT INTO user_teilnehmer VALUES("138","w","Name_4","vName_4","email_4@anonymous.de","1","0","58a8a81f44108","2017-02-18 21:01:35");
INSERT INTO user_teilnehmer VALUES("139","w","Name_5","vName_5_a","email_5@anonymous.de","1","0","58a8a81f448b2","2017-02-20 09:42:20");
INSERT INTO user_teilnehmer VALUES("143","m","Name_1","vName_1","email_1@anonymous.de","1","0","58aaabf3604b7","2017-02-20 09:42:27");
INSERT INTO user_teilnehmer VALUES("144","w","Name_2","vName_2","email_2@anonymous.de","1","0","58aaabf36119b","2017-02-20 09:42:27");
INSERT INTO user_teilnehmer VALUES("145","w","Name_3","vName_3","email_3@anonymous.de","1","0","58aaabf3618ff","2017-02-20 09:42:27");
INSERT INTO user_teilnehmer VALUES("146","m","Name_4","vName_4","email_4@anonymous.de","1","0","58aaabf3620d0","2017-02-20 09:42:27");
INSERT INTO user_teilnehmer VALUES("147","w","Name_5","vName_5","email_5@anonymous.de","1","0","58aaabf3628e6","2017-02-20 09:42:27");
INSERT INTO user_teilnehmer VALUES("148","w","Name_1","vName_1","email_1@anonymous.de","1","0","58aef16689810","2017-02-23 15:27:50");
INSERT INTO user_teilnehmer VALUES("149","w","Name_2","vName_2","email_2@anonymous.de","1","0","58aef1668a5ee","2017-02-23 15:27:50");
INSERT INTO user_teilnehmer VALUES("150","w","Name_3","vName_3","email_3@anonymous.de","1","0","58aef1668afe9","2017-02-23 15:27:50");
INSERT INTO user_teilnehmer VALUES("151","m","Name_4","vName_4","email_4@anonymous.de","1","0","58aef1668ba3d","2017-02-23 15:27:50");
INSERT INTO user_teilnehmer VALUES("152","w","Name_5","vName_5","email_5@anonymous.de","1","0","58aef1668c41f","2017-02-23 15:27:50");
INSERT INTO user_teilnehmer VALUES("153","m","Name_1","vName_1","email_1@anonymous.de","1","0","58c67b1ad2ef4","2017-03-13 11:57:30");
INSERT INTO user_teilnehmer VALUES("154","m","neu_Name_1","neu_vName_1","neu_email_1@anonymous.de","1","0","58da53fa88ab9","2017-03-28 14:15:54");
INSERT INTO user_teilnehmer VALUES("155","w","neu_Name_2","neu_vName_2","neu_email_2@anonymous.de","1","0","58da53fa897af","2017-03-28 14:15:54");
INSERT INTO user_teilnehmer VALUES("156","m","neu_Name_3","neu_vName_3","neu_email_3@anonymous.de","1","0","58da53fa8a059","2017-03-28 14:15:54");
INSERT INTO user_teilnehmer VALUES("164","m","test_Name_1","test_vName_1","test_email_1@anonymous.de","1","0","58da5f3f2ca31","2017-03-28 15:03:59");
INSERT INTO user_teilnehmer VALUES("165","m","test_Name_2","test_vName_2","test_email_2@anonymous.de","1","0","58da5f3f2d67d","2017-03-28 15:03:59");
INSERT INTO user_teilnehmer VALUES("166","m","test_Name_3","test_vName_3","test_email_3@anonymous.de","1","0","58da5f3f2e12c","2017-03-28 15:03:59");
INSERT INTO user_teilnehmer VALUES("167","m","test_Name_4","test_vName_4","test_email_4@anonymous.de","1","0","58da5f3f2eb0b","2017-03-28 15:03:59");
INSERT INTO user_teilnehmer VALUES("168","w","test_Name_5","test_vName_5","test_email_5@anonymous.de","1","0","58da5f3f2f361","2017-03-28 15:03:59");
INSERT INTO user_teilnehmer VALUES("169","w","k_demo_58fcc31ae036e_Name","k_demo_58fcc31ae036e_vName","k_demo_58fcc31ae036e_email@anonymous.de","1","0","58fcc31ae069a","2017-04-23 17:07:06");
INSERT INTO user_teilnehmer VALUES("170","m","k_demo_58fcc378d41d7_Name","k_demo_58fcc378d41d7_vName","k_demo_58fcc378d41d7_email@anonymous.de","1","0","58fcc378d455d","2017-04-23 17:08:40");
INSERT INTO user_teilnehmer VALUES("171","m","k_demo_58fcc4a2a3c63_Name","k_demo_58fcc4a2a3c63_vName","k_demo_58fcc4a2a3c63_email@anonymous.de","1","0","58fcc4a2a3f03","2017-04-23 17:13:38");
INSERT INTO user_teilnehmer VALUES("172","w","k_demo_58fcc4ff5af27_Name","k_demo_58fcc4ff5af27_vName","k_demo_58fcc4ff5af27_email@anonymous.de","1","0","58fcc4ff5b119","2017-04-23 17:15:11");
INSERT INTO user_teilnehmer VALUES("173","m","k_demo_58fcc5d2ae04a_Name","k_demo_58fcc5d2ae04a_vName","k_demo_58fcc5d2ae04a_email@anonymous.de","1","0","58fcc5d2ae39b","2017-04-23 17:18:42");
INSERT INTO user_teilnehmer VALUES("174","m","k_demo_58fcc61f43d42_Name","k_demo_58fcc61f43d42_vName","k_demo_58fcc61f43d42_email@anonymous.de","1","0","58fcc61f43f7f","2017-04-23 17:19:59");
INSERT INTO user_teilnehmer VALUES("176","W","Beyer","Veronika","V.Beyer@campus.lmu.de","1","0","59088a122b14e","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("177","W","Jahreis","MiriamBabette","Miriam.Jahreis@campus.lmu.de","1","0","59088a122bd16","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("178","W","Mergner","LisaSophia","Lisa.Mergner@campus.lmu.de","1","0","59088a122c557","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("179","W","Schuster","LisaMelanie","Schuster.Lisa@campus.lmu.de","1","0","59088a122cde4","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("180","M","Hartmann","Frederik","Frederik.Hartmann@campus.lmu.de","1","0","59088a122d620","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("181","M","Hlatky","Stephan","S.Hlatky@campus.lmu.de","1","0","59088a122de02","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("182","M","Jahn","Tobias","T.Jahn@campus.lmu.de","1","0","59088a122e436","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("183","M","Sparrer","Bernhard","Bernhard.Sparrer@campus.lmu.de","1","0","59088a122eac1","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("184","M","Naun","Todi","Naun.Todi@campus.lmu.de","1","0","59088a122f2c7","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("185","M","Vorderobermeier","Andreas","A.Vorderobermeier@campus.lmu.de","1","0","59088a122fa40","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("186","M","Eichenseer","DominikusMatthias","D.Eichenseer@campus.lmu.de","1","0","59088a123020a","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("187","M","Perl","Tobias","Tobias.Perl@campus.lmu.de","1","0","59088a12309c3","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("188","M","Dünnbier","Nikolaus","N.Duennbier@campus.lmu.de","1","0","59088a1231197","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("189","W","Fischer","MariaFranziska","Fischer_F@gmx.de","1","0","59088a1231967","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("190","M","Brus","GordonBrian","Bri.Brus@campus.lmu.de","1","0","59088a1232126","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("191","W","Schönauer","ValerieLoulou","Valerie.Schoenauer@campus.lmu.de","1","0","59088a123281a","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("192","M","Naujoks","Andre","Andre.Naujoks@gmx.de","1","0","59088a1232ee6","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("193","M","Yurchak","Patrick","patrickcyurchak@aol.com","1","0","59088a12336db","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("194","M","Bach","AntonMichael","A.Bach@campus.lmu.de","1","0","59088a1234cbc","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("195","M","Götzinger","Thomas","Thomas.Goetzinger@campus.lmu.de","1","0","59088a1235411","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("196","M","Artinger","Thomas","Thomas.Artinger@campus.lmu.de","1","0","59088a1235c6c","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("197","M","Höldrich","ChristianManfred","Christian.Hoeldrich@campus.lmu.de","1","0","59088a1236528","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("198","M","Behrens","Sven","Sven.Behrens@campus.lmu.de","1","0","59088a1236f5c","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("199","M","Fischer","YvoValentin","Yvo.Fischer@campus.lmu.de","1","0","59088a12377df","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("200","M","Köbli","Adrian","koebli315@gmail.com","1","0","59088a1237ff6","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("201","M","Kulartz","MatthiasDominik","M.Kulartz@campus.lmu.de","1","0","59088a1238d8b","2017-05-02 15:30:58");
INSERT INTO user_teilnehmer VALUES("202","m","2017-06-11_11:46:04_Name","2017-06-11_11:46:04_vName","2017-06-11_11:46:04_email@anonymous.de","1","0","593d2d7c08e07","2017-06-11 13:46:04");
INSERT INTO user_teilnehmer VALUES("203","w","2017-06-11_13:53:37_Name","2017-06-11_13:53:37_vName","2017-06-11_13:53:37_email@anonymous.de","1","0","593d4b61725e3","2017-06-11 15:53:37");
INSERT INTO user_teilnehmer VALUES("204","w","2017-06-16_00:52:40_Name","2017-06-16_00:52:40_vName","2017-06-16_00:52:40_email@anonymous.de","1","0","59432bd84583b","2017-06-16 02:52:40");
INSERT INTO user_teilnehmer VALUES("205","w","2017-06-16_08:36:09_Name","2017-06-16_08:36:09_vName","2017-06-16_08:36:09_email@anonymous.de","1","0","59439879e4b6f","2017-06-16 10:36:09");
INSERT INTO user_teilnehmer VALUES("206","m","2017-06-16_08:38:29_Name","2017-06-16_08:38:29_vName","2017-06-16_08:38:29_email@anonymous.de","1","0","594399056bb1d","2017-06-16 10:38:29");
INSERT INTO user_teilnehmer VALUES("207","w","2017-06-16_15:01:30_Name","2017-06-16_15:01:30_vName","2017-06-16_15:01:30_email@anonymous.de","1","0","5943f2ca969c1","2017-06-16 17:01:30");
INSERT INTO user_teilnehmer VALUES("208","m","2017-06-16_15:02:46_Name","2017-06-16_15:02:46_vName","2017-06-16_15:02:46_email@anonymous.de","1","0","5943f31626d4d","2017-06-16 17:02:46");
INSERT INTO user_teilnehmer VALUES("209","w","2017-06-16_15:02:56_Name","2017-06-16_15:02:56_vName","2017-06-16_15:02:56_email@anonymous.de","1","0","5943f320d6611","2017-06-16 17:02:56");
INSERT INTO user_teilnehmer VALUES("210","m","2017-06-16_15:16:05_Name","2017-06-16_15:16:05_vName","2017-06-16_15:16:05_email@anonymous.de","1","0","5943f635caf4b","2017-06-16 17:16:05");
INSERT INTO user_teilnehmer VALUES("211","m","2017-06-16_15:17:36_Name","2017-06-16_15:17:36_vName","2017-06-16_15:17:36_email@anonymous.de","1","0","5943f69033a56","2017-06-16 17:17:36");
INSERT INTO user_teilnehmer VALUES("212","m","2017-06-17_11:14:01_Name","2017-06-17_11:14:01_vName","2017-06-17_11:14:01_email@anonymous.de","1","0","59450ef9906da","2017-06-17 13:14:01");
INSERT INTO user_teilnehmer VALUES("213","m","2017-06-17_20:00:55_Name","2017-06-17_20:00:55_vName","2017-06-17_20:00:55_email@anonymous.de","1","0","59458a77a3a76","2017-06-17 22:00:55");
INSERT INTO user_teilnehmer VALUES("214","w","2017-06-19_07:59:13_Name","2017-06-19_07:59:13_vName","2017-06-19_07:59:13_email@anonymous.de","1","0","5947845159232","2017-06-19 09:59:13");
INSERT INTO user_teilnehmer VALUES("215","m","2017-06-19_12:02:17_Name","2017-06-19_12:02:17_vName","2017-06-19_12:02:17_email@anonymous.de","1","0","5947bd49ba4ce","2017-06-19 14:02:17");
INSERT INTO user_teilnehmer VALUES("216","m","2017-06-19_12:03:30_Name","2017-06-19_12:03:30_vName","2017-06-19_12:03:30_email@anonymous.de","1","0","5947bd925dd5c","2017-06-19 14:03:30");
INSERT INTO user_teilnehmer VALUES("217","w","2017-06-19_12:05:47_Name","2017-06-19_12:05:47_vName","2017-06-19_12:05:47_email@anonymous.de","1","0","5947be1b2a63d","2017-06-19 14:05:47");
INSERT INTO user_teilnehmer VALUES("218","m","2017-06-19_12:07:04_Name","2017-06-19_12:07:04_vName","2017-06-19_12:07:04_email@anonymous.de","1","0","5947be681b140","2017-06-19 14:07:04");
INSERT INTO user_teilnehmer VALUES("219","m","2017-06-19_12:22:42_Name","2017-06-19_12:22:42_vName","2017-06-19_12:22:42_email@anonymous.de","1","0","5947c212bd2e2","2017-06-19 14:22:42");
INSERT INTO user_teilnehmer VALUES("220","m","2017-06-19_16:45:00_Name","2017-06-19_16:45:00_vName","2017-06-19_16:45:00_email@anonymous.de","1","0","5947ff8cad66d","2017-06-19 18:45:00");
INSERT INTO user_teilnehmer VALUES("221","w","2017-06-19_16:46:16_Name","2017-06-19_16:46:16_vName","2017-06-19_16:46:16_email@anonymous.de","1","0","5947ffd829845","2017-06-19 18:46:16");
INSERT INTO user_teilnehmer VALUES("222","w","2017-06-19_16:46:18_Name","2017-06-19_16:46:18_vName","2017-06-19_16:46:18_email@anonymous.de","1","0","5947ffdaaf09d","2017-06-19 18:46:18");
INSERT INTO user_teilnehmer VALUES("223","m","2017-06-19_18:39:17_Name","2017-06-19_18:39:17_vName","2017-06-19_18:39:17_email@anonymous.de","1","0","59481a556c4ff","2017-06-19 20:39:17");
INSERT INTO user_teilnehmer VALUES("224","m","2017-06-19_21:04:23_Name","2017-06-19_21:04:23_vName","2017-06-19_21:04:23_email@anonymous.de","1","0","59483c57145c9","2017-06-19 23:04:23");
INSERT INTO user_teilnehmer VALUES("225","m","2017-06-19_21:27:16_Name","2017-06-19_21:27:16_vName","2017-06-19_21:27:16_email@anonymous.de","1","0","594841b4e7f35","2017-06-19 23:27:16");
INSERT INTO user_teilnehmer VALUES("226","m","2017-06-20_06:10:26_Name","2017-06-20_06:10:26_vName","2017-06-20_06:10:26_email@anonymous.de","1","0","5948bc5261993","2017-06-20 08:10:26");
INSERT INTO user_teilnehmer VALUES("227","w","2017-06-20_06:10:27_Name","2017-06-20_06:10:27_vName","2017-06-20_06:10:27_email@anonymous.de","1","0","5948bc53e42e6","2017-06-20 08:10:27");
INSERT INTO user_teilnehmer VALUES("228","m","2017-06-20_06:10:28_Name","2017-06-20_06:10:28_vName","2017-06-20_06:10:28_email@anonymous.de","1","0","5948bc54e90d7","2017-06-20 08:10:28");
INSERT INTO user_teilnehmer VALUES("229","m","2017-06-20_06:13:02_Name","2017-06-20_06:13:02_vName","2017-06-20_06:13:02_email@anonymous.de","1","0","5948bceef27b5","2017-06-20 08:13:02");
INSERT INTO user_teilnehmer VALUES("230","m","2017-06-20_06:26:05_Name","2017-06-20_06:26:05_vName","2017-06-20_06:26:05_email@anonymous.de","1","0","5948bffdb4791","2017-06-20 08:26:05");
INSERT INTO user_teilnehmer VALUES("231","m","2017-06-20_08:44:24_Name","2017-06-20_08:44:24_vName","2017-06-20_08:44:24_email@anonymous.de","1","0","5948e068c5ff4","2017-06-20 10:44:24");
INSERT INTO user_teilnehmer VALUES("232","m","2017-06-20_08:48:56_Name","2017-06-20_08:48:56_vName","2017-06-20_08:48:56_email@anonymous.de","1","0","5948e178a2030","2017-06-20 10:48:56");
INSERT INTO user_teilnehmer VALUES("233","w","2017-06-20_09:23:55_Name","2017-06-20_09:23:55_vName","2017-06-20_09:23:55_email@anonymous.de","1","0","5948e9ab2753f","2017-06-20 11:23:55");
INSERT INTO user_teilnehmer VALUES("234","m","2017-06-20_09:23:58_Name","2017-06-20_09:23:58_vName","2017-06-20_09:23:58_email@anonymous.de","1","0","5948e9aee2fa6","2017-06-20 11:23:58");
INSERT INTO user_teilnehmer VALUES("235","w","2017-06-20_09:24:20_Name","2017-06-20_09:24:20_vName","2017-06-20_09:24:20_email@anonymous.de","1","0","5948e9c48ce1d","2017-06-20 11:24:20");
INSERT INTO user_teilnehmer VALUES("236","w","2017-06-20_09:34:14_Name","2017-06-20_09:34:14_vName","2017-06-20_09:34:14_email@anonymous.de","1","0","5948ec163455a","2017-06-20 11:34:14");
INSERT INTO user_teilnehmer VALUES("237","w","2017-06-20_11:31:59_Name","2017-06-20_11:31:59_vName","2017-06-20_11:31:59_email@anonymous.de","1","0","594907af9bfc5","2017-06-20 13:31:59");
INSERT INTO user_teilnehmer VALUES("238","m","2017-06-20_11:32:16_Name","2017-06-20_11:32:16_vName","2017-06-20_11:32:16_email@anonymous.de","1","0","594907c080ed9","2017-06-20 13:32:16");
INSERT INTO user_teilnehmer VALUES("239","w","demo_Name_1","demo_vName_1","demo_email_1@anonymous.de","1","0","5949381f1370a","2017-06-20 16:58:39");
INSERT INTO user_teilnehmer VALUES("240","w","demo_Name_2","demo_vName_2","demo_email_2@anonymous.de","1","0","5949381f14612","2017-06-20 16:58:39");
INSERT INTO user_teilnehmer VALUES("241","m","demo_Name_3","demo_vName_3","demo_email_3@anonymous.de","1","0","5949381f1505c","2017-06-20 16:58:39");
INSERT INTO user_teilnehmer VALUES("242","m","_Name_1","_vName_1","_email_1@anonymous.de","1","0","59493e26b0650","2017-06-20 17:24:22");
INSERT INTO user_teilnehmer VALUES("243","m","2017-06-23","06:18:28","2017-06-23_06:18:28_email@anonymous.de","1","0","594cb2b40ec55","2017-06-23 08:18:28");
INSERT INTO user_teilnehmer VALUES("244","w","2017-06-24","11:12:09","2017-06-24_11:12:09_email@anonymous.de","1","0","594e4909d5d62","2017-06-24 13:12:09");
INSERT INTO user_teilnehmer VALUES("245","w","2017-06-24","11:12:10","2017-06-24_11:12:10_email@anonymous.de","1","0","594e490a5a40c","2017-06-24 13:12:10");
INSERT INTO user_teilnehmer VALUES("246","w","2017-06-24","13:59:52","2017-06-24_13:59:52_email@anonymous.de","1","0","594e7058de95e","2017-06-24 15:59:52");
INSERT INTO user_teilnehmer VALUES("247","m","Mustermann","Max","admin@pemasoft.de","37","1","59509e6034796","2017-06-26 07:40:48");
INSERT INTO user_teilnehmer VALUES("248","m","2017-07-01","13:21:40","2017-07-01_13:21:40_email@anonymous.de","1","0","5957a1e4349cd","2017-07-01 15:21:40");
INSERT INTO user_teilnehmer VALUES("249","w","2017-07-01","13:25:35","2017-07-01_13:25:35_email@anonymous.de","1","0","5957a2cfdae04","2017-07-01 15:25:35");
INSERT INTO user_teilnehmer VALUES("250","m","2017-07-02","14:35:35","2017-07-02_14:35:35_email@anonymous.de","1","0","595904b7a2ae9","2017-07-02 16:35:35");
INSERT INTO user_teilnehmer VALUES("251","w","_Name_1","_vName_1","_email_1@anonymous.de","1","0","5959183f187a3","2017-07-02 17:58:55");
INSERT INTO user_teilnehmer VALUES("252","m","_Name_1","_vName_1","_email_1@anonymous.de","1","0","595918586ec0d","2017-07-02 17:59:20");
INSERT INTO user_teilnehmer VALUES("253","m","_Name_1","_vName_1","_email_1@anonymous.de","1","0","5959186561bd6","2017-07-02 17:59:33");
INSERT INTO user_teilnehmer VALUES("254","m","_Name_1","_vName_1","_email_1@anonymous.de","1","0","5959186e46207","2017-07-02 17:59:42");
INSERT INTO user_teilnehmer VALUES("255","w","2017-07-03","05:24:25","2017-07-03_05:24:25_email@anonymous.de","1","0","5959d5095c861","2017-07-03 07:24:25");
INSERT INTO user_teilnehmer VALUES("256","w","2017-07-03","09:51:24","2017-07-03_09:51:24_email@anonymous.de","1","0","595a139c48995","2017-07-03 11:51:24");
INSERT INTO user_teilnehmer VALUES("257","m","2017-07-03","09:51:32","2017-07-03_09:51:32_email@anonymous.de","1","0","595a13a42a4cc","2017-07-03 11:51:32");



DROP TABLE user_teilnehmer_kurs_match;

CREATE TABLE `user_teilnehmer_kurs_match` (
  `kursID` int(11) NOT NULL,
  `tnID` int(11) NOT NULL,
  `dozent` int(11) NOT NULL DEFAULT '0' COMMENT '0:nein 1:ja',
  UNIQUE KEY `kursID_tnID` (`kursID`,`tnID`),
  KEY `tnID` (`tnID`),
  CONSTRAINT `user_teilnehmer_kurs_match_ibfk_1` FOREIGN KEY (`kursID`) REFERENCES `kurs` (`kursID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO user_teilnehmer_kurs_match VALUES("1","35","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","102","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","107","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","108","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","109","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","110","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","111","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","112","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","113","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","114","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","115","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","116","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","117","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","118","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","119","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","120","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","121","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","122","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","123","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","124","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","125","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","126","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","127","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","128","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","129","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","130","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","131","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("1","132","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("21","35","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("21","38","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("21","251","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("21","252","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("21","253","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("21","254","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("22","39","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("22","40","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("22","41","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("22","42","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("22","43","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("22","51","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("23","35","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("23","36","1");
INSERT INTO user_teilnehmer_kurs_match VALUES("23","135","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("23","136","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("23","137","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("23","138","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("23","139","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("23","143","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("23","144","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("23","145","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("23","146","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("23","147","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("23","148","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("23","149","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("23","150","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("23","151","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("23","152","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("24","35","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("24","36","1");
INSERT INTO user_teilnehmer_kurs_match VALUES("24","143","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("24","144","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("24","145","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("24","146","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("24","147","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("24","169","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("24","170","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("24","171","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("24","172","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("24","173","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("24","174","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("25","35","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("25","36","1");
INSERT INTO user_teilnehmer_kurs_match VALUES("25","164","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("25","165","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("25","166","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("25","167","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","35","1");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","176","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","177","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","178","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","179","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","180","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","181","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","182","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","183","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","184","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","185","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","186","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","187","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","188","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","189","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","190","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","191","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","192","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","193","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","194","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","195","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","196","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","197","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","198","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","199","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","200","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","201","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","202","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","203","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","215","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","216","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","217","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","218","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","219","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","220","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","221","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","222","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","223","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","224","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","225","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","226","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","227","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","228","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","229","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","230","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","231","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","232","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","233","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","234","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","235","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","236","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","237","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","238","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","243","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","244","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","245","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","248","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","249","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","250","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("28","255","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("111","35","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("111","204","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("111","205","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("111","206","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("111","207","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("111","208","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("111","209","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("111","210","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("111","211","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("111","212","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("111","213","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("111","214","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("111","246","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("111","256","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("111","257","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("113","239","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("113","240","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("113","241","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("113","242","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("114","35","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("116","247","0");
INSERT INTO user_teilnehmer_kurs_match VALUES("117","247","0");



DROP TABLE user_uID_groups_match;

CREATE TABLE `user_uID_groups_match` (
  `uID` int(11) NOT NULL,
  `uGroupID` int(11) NOT NULL,
  UNIQUE KEY `uGroupID_uID` (`uGroupID`,`uID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO user_uID_groups_match VALUES("1","1");
INSERT INTO user_uID_groups_match VALUES("27","1");
INSERT INTO user_uID_groups_match VALUES("1","2");
INSERT INTO user_uID_groups_match VALUES("5","2");
INSERT INTO user_uID_groups_match VALUES("26","2");
INSERT INTO user_uID_groups_match VALUES("27","2");
INSERT INTO user_uID_groups_match VALUES("28","2");
INSERT INTO user_uID_groups_match VALUES("36","2");
INSERT INTO user_uID_groups_match VALUES("37","2");
INSERT INTO user_uID_groups_match VALUES("38","2");
INSERT INTO user_uID_groups_match VALUES("39","2");
INSERT INTO user_uID_groups_match VALUES("1","4");
INSERT INTO user_uID_groups_match VALUES("27","4");



DROP TABLE v_simulationen;

CREATE TABLE `v_simulationen` (
  `simID` int(11) NOT NULL AUTO_INCREMENT,
  `titel` tinytext NOT NULL,
  `url` text NOT NULL,
  `beschreibung` text NOT NULL,
  `poster` text NOT NULL,
  PRIMARY KEY (`simID`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;

INSERT INTO v_simulationen VALUES("2","Energieskatepark 1","https://phet.colorado.edu/sims/html/energy-skate-park-basics/latest/energy-skate-park-basics_de.html","&lt;p&gt;&lt;em&gt;Erfahren Sie mehr &amp;uuml;ber die Erhaltung der Energie mit einem Skater in einer Halfpipe! Untersuchen Sie verschiedene Halfpipes und beobachten Sie kinetische Energie, potenzielle Energie und Reibung, w&amp;auml;hrend er sich darin bewegt. Erstellen Sie eigene Halfpipes, Schr&amp;auml;gen und Rampen f&amp;uuml;r den Skater.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;br /&gt; &lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Erl&amp;auml;utern Sie das Konzept der Erhaltung der mechanischen Energie mit kinetischer und potenzieller Energie.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie, wie die Energiediagramme (Balkendiagramm und Tortendiagramm) mit Position und Geschwindigkeit zusammenh&amp;auml;ngen.&lt;/li&gt;
&lt;li&gt;Erl&amp;auml;utern Sie, wie sich eine &amp;Auml;nderung der Masse des Skaters auf die Energie auswirkt.&lt;/li&gt;
&lt;li&gt;Erl&amp;auml;utern Sie, wie sich eine Ver&amp;auml;nderung der Reibung auf die Energie auswirkt.&lt;/li&gt;
&lt;li&gt;Sch&amp;auml;tzen Sie Position und Geschwindigkeit aus den Energiediagrammen ab.&lt;/li&gt;
&lt;li&gt;Berechnen Sie Geschwindigkeit und H&amp;ouml;he an einer Position (1) aufgrund von Informationen an der Position (2).&lt;/li&gt;
&lt;li&gt;Berechnen Sie die kinetische und potenzielle Energie an einer Position (1) aufgrund von Informationen an der Position (2).&lt;/li&gt;
&lt;li&gt;Entwerfen Sie ein Skaterpark unter Ber&amp;uuml;cksichtigung des Konzepts der Erhaltung der mechanischen Energie.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("6","Farbwahrnehmung","https://phet.colorado.edu/sims/html/color-vision/latest/color-vision_de.html","&lt;p&gt;&lt;em&gt;Erzeugen Sie einen ganzen Regenbogen durch Mischen von Rot, Gr&amp;uuml;n und Blau. &amp;Auml;ndern der Wellenl&amp;auml;nge des monochromatischen Strahls oder filtern Sie wei&amp;szlig;es Licht. Machen Sie das Licht als Strahl oder als einzelne Photonen sichtbar.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Ermitteln Sie, welche Farbe ein Mensch f&amp;uuml;r verschiedene Kombinationen von rotem, gr&amp;uuml;nen und blauem Licht sieht.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie die Farbe des Lichts, welches durch verschiedene Farbfilter hindurch geht.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("7","statische Elektrizit&auml;t","https://phet.colorado.edu/sims/html/balloons-and-static-electricity/latest/balloons-and-static-electricity_de.html","","");
INSERT INTO v_simulationen VALUES("8","Hebelgesetz","https://phet.colorado.edu/sims/html/balancing-act/latest/balancing-act_de.html","&lt;p&gt;&lt;em&gt;&amp;Uuml;berpr&amp;uuml;fen Sie das Hebelgesetz, indem Sie Objekte auf einer Wippe plazieren.&amp;nbsp;&lt;/em&gt;&lt;em&gt;Wenden Sie das Gelernte im Balance-Spiel an.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Sagen Sie voraus, wie eine Wippe mit Objekten verschiedener Massen ins Gleichgewicht zu bringen ist.&lt;/li&gt;
&lt;li&gt;Sagen Sie voraus, wie die &amp;Auml;nderung der Positionen der Massen auf der Wippe deren Bewegung beeinflussen.&lt;/li&gt;
&lt;li&gt;Sagen Sie mit dem Hebelgesetz voraus, in welcher Art und Weise sich eine Wippe begegen wird, wenn Gegenst&amp;auml;nde verschiedener Masse darauf plaziert werden.&lt;/li&gt;
&lt;li&gt;L&amp;ouml;sen Sie mit Ihrem Wissen R&amp;auml;tsel.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("9","Konzentration","https://phet.colorado.edu/sims/html/concentration/latest/concentration_de.html","&lt;p&gt;Beobachten Sie, wie sich die Farbe einer L&amp;ouml;sung &amp;auml;ndert, wenn Sie Chemikalien mit Wasser mischen. &amp;Uuml;berpr&amp;uuml;fen Sie die Molarit&amp;auml;t mit der Konzentrations-Messger&amp;auml;t. Welche M&amp;ouml;glichkeiten haben Sie, die Konzentration Ihrer L&amp;ouml;sung zu &amp;auml;ndern? &amp;Auml;ndern sie die gel&amp;ouml;sten Substanzen, um verschiedene Chemikalien zu vergleichen und herauszufinden, wo deren S&amp;auml;ttigungskonzentration liegt.&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Beschreiben Sie die Beziehungen zwischen Konzentration, Volumen und Menge des gel&amp;ouml;sten Stoffes in einer L&amp;ouml;sung.&lt;/li&gt;
&lt;li&gt;Erkl&amp;auml;ren Sie, wie die Farbe der L&amp;ouml;sung und ihre Konzentration zusammenh&amp;auml;ngen.&lt;/li&gt;
&lt;li&gt;Sagen Sie voraus, wie die Konzentration der L&amp;ouml;sung durch folgende Aktionen ge&amp;auml;ndert wird: Zugabe oder Entfernen von Wasser, gel&amp;ouml;stem Stoff, L&amp;ouml;sung.&lt;/li&gt;
&lt;li&gt;Stellen Sie eine L&amp;ouml;sung mit einer bestimmten Konzentration her.&lt;/li&gt;
&lt;li&gt;Wie k&amp;ouml;nnen Sie die Konzentration einer L&amp;ouml;sung definiert &amp;auml;ndern?&lt;/li&gt;
&lt;li&gt;Identifizieren Sie, wann eine L&amp;ouml;sung ges&amp;auml;ttigt ist.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("10","Lichtbrechung","https://phet.colorado.edu/sims/html/bending-light/latest/bending-light_de.html","&lt;p&gt;&lt;em&gt;Beobachten Sie die Brechung von Licht zwischen zwei Medien mit unterschiedlichen Brechungsindizes. Sehen Sie, wie der Wechsel von Luft/Wasser auf Luft/Glas den Brechungswinkel beeinflusst. Spielen Sie mit Prismen verschiedener Formen und erzeugen Sie Regenb&amp;ouml;gen.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Erkl&amp;auml;ren Sie die Lichtbrechung an der Grenzfl&amp;auml;che zwischen zwei Medien und bestimmen Sie den Brechungswinkel.&lt;/li&gt;
&lt;li&gt;Wenden Sie das SNELLIUSsche Gesetz f&amp;uuml;r die Brechung eines Laserstrahls an der Grenzfl&amp;auml;che zwischen zwei Medien an.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie, wie sich die Geschwindigkeit und die Wellenl&amp;auml;nge des Lichts in verschiedenen Medien &amp;auml;ndert.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie die Auswirkungen der &amp;Auml;nderung der Wellenl&amp;auml;nge auf den Brechungswinkel.&lt;/li&gt;
&lt;li&gt;Erkl&amp;auml;ren Sie, wie man mit einem Prisma einen Regenbogen erzeugen kann.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("12","Schwerkraft und Umlaufbahnen","https://phet.colorado.edu/sims/html/gravity-and-orbits/latest/gravity-and-orbits_de.html","&lt;p&gt;&lt;em&gt;Bewegen Sie Sonne, Erde, Mond und Raumstation und beobachten Sie, wie die Gravitationskr&amp;auml;fte und die Umlaufbahnen beeinflusst werden. Visualisieren Sie die Gr&amp;ouml;&amp;szlig;en und Abst&amp;auml;nde verschiedener Himmelsk&amp;ouml;rper, und beobachten Sie, was passiert, wenn Sie die Schwerkraft abschalten.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Beschreiben Sie die Beziehung zwischen Sonne, Erde, Mond und Raumstation, ihre Bahnen und Positionen.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie Gr&amp;ouml;&amp;szlig;e von Sonne, Erde, Mond und Raumstation sowie deren Entfernung voneinander.&lt;/li&gt;
&lt;li&gt;Erkl&amp;auml;ren Sie, wie die Schwerkraft die Bewegung unseres Sonnensystems bestimmt.&lt;/li&gt;
&lt;li&gt;Nennen Sie die Variablen, die die St&amp;auml;rke der Gravitation beeinflussen.&lt;/li&gt;
&lt;li&gt;Sagen Sie voraus, wie sich die Bewegung ver&amp;auml;ndern w&amp;uuml;rde, wenn die Schwerkraft gr&amp;ouml;&amp;szlig;er oder schw&amp;auml;cher w&amp;auml;re.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("13","Dipolstrahlung","https://www.didaktikonline.physik.uni-muenchen.de/programme/dipolstr/Dipolstr1c.html?m=110001","","");
INSERT INTO v_simulationen VALUES("14","Elektrische Feldlinien","https://www.didaktikonline.physik.uni-muenchen.de/programme/e_feld/E_Feld_min.html","","");
INSERT INTO v_simulationen VALUES("15","Wellenwanne","https://www.didaktikonline.physik.uni-muenchen.de/programme/wellen_1d/index.html","","");
INSERT INTO v_simulationen VALUES("16","Kreisbewegung","https://www.physik-workshop.de/includes/Fendt/phde/circularmotion_de.htm","","");
INSERT INTO v_simulationen VALUES("17","Widerstand - Br&uuml;ckenschaltung","https://www.physik-workshop.de/includes/Fendt/phde/wheatstonebridge_de.htm","","");
INSERT INTO v_simulationen VALUES("18","Bewegung mit konstanter Beschleunigung","https://www.physik-workshop.de/includes/Fendt/phde/acceleration_de.htm","","");
INSERT INTO v_simulationen VALUES("19","Einfache Wechselstromkreise","","","https://www.physik-workshop.de/includes/Fendt/phde/accircuits_de.htm");
INSERT INTO v_simulationen VALUES("20","Schwebungen","https://www.physik-workshop.de/includes/Fendt/phde/beats_de.htm","","");
INSERT INTO v_simulationen VALUES("21","Bohrsches Modell des Wasserstoffatoms","https://www.physik-workshop.de/includes/Fendt/phde/bohrmodel_de.htm","","");
INSERT INTO v_simulationen VALUES("22","Auftriebskraft in Fl&uuml;ssigkeiten","https://www.physik-workshop.de/includes/Fendt/phde/buoyantforce_de.htm","","");
INSERT INTO v_simulationen VALUES("23","elastischer und unelastischer Sto&szlig;","https://www.physik-workshop.de/includes/Fendt/phde/collision_de.htm","","");
INSERT INTO v_simulationen VALUES("24","gekoppeltes Pendel","https://www.physik-workshop.de/includes/Fendt/phde/coupledpendula_de.htm","","");
INSERT INTO v_simulationen VALUES("25","Doppler-Effekt am Beispiel eines Krankenwagens","https://www.physik-workshop.de/includes/Fendt/phde/dopplereffect_de.htm","","");
INSERT INTO v_simulationen VALUES("26","Interferenz von Licht am Doppelspalt","https://www.physik-workshop.de/includes/Fendt/phde/doubleslit_de.htm","","");
INSERT INTO v_simulationen VALUES("27","Gleichstromelektromotor","https://www.physik-workshop.de/includes/Fendt/phde/electricmotor_de.htm","","");
INSERT INTO v_simulationen VALUES("28","Elektromagnetische Welle","https://www.physik-workshop.de/includes/Fendt/phde/electromagneticwave_de.htm","","");
INSERT INTO v_simulationen VALUES("29","Gleichgewicht dreier Kr&auml;fte","https://www.physik-workshop.de/includes/Fendt/phde/equilibriumforces_de.htm","","");
INSERT INTO v_simulationen VALUES("30","Zerlegung einer Kraft in zwei Komponenten","https://www.physik-workshop.de/includes/Fendt/phde/forceresolution_de.htm","","");
INSERT INTO v_simulationen VALUES("31","Generator","https://www.physik-workshop.de/includes/Fendt/phde/generator_de.htm","","");
INSERT INTO v_simulationen VALUES("32","Schiefe Ebene","https://www.physik-workshop.de/includes/Fendt/phde/inclinedplane_de.htm","","");
INSERT INTO v_simulationen VALUES("33","Interferenz zweier Kreis- oder Kugelwellen","https://www.physik-workshop.de/includes/Fendt/phde/interference_de.htm","","");
INSERT INTO v_simulationen VALUES("34","Erstes Keplersches Gesetz","https://www.physik-workshop.de/includes/Fendt/phde/keplerlaw1_de.htm","","");
INSERT INTO v_simulationen VALUES("35","Zweites Keplersches Gesetz","https://www.physik-workshop.de/includes/Fendt/phde/keplerlaw2_de.htm","","");
INSERT INTO v_simulationen VALUES("36","Zerfallsgesetz","https://www.physik-workshop.de/includes/Fendt/phde/lawdecay_de.htm","","");
INSERT INTO v_simulationen VALUES("37","Hebelgesetz","https://www.physik-workshop.de/includes/Fendt/phde/lever_de.htm","","");
INSERT INTO v_simulationen VALUES("38","Lorentzkraft auf einen stromdurchflossenen Leiter","https://www.physik-workshop.de/includes/Fendt/phde/lorentzforce_de.htm","","");
INSERT INTO v_simulationen VALUES("39","Magnetfeld eines Stabmagneten","https://www.physik-workshop.de/includes/Fendt/phde/magneticfieldbar_de.htm","","");
INSERT INTO v_simulationen VALUES("40","Magnetfeld eines geraden stromdruchflossenen Leiters","https://www.physik-workshop.de/includes/Fendt/phde/magneticfieldwire_de.htm","","");
INSERT INTO v_simulationen VALUES("41","Newtons Wiege","https://www.physik-workshop.de/includes/Fendt/phde/newtoncradle_de.htm","","");
INSERT INTO v_simulationen VALUES("42","Ohmsches Gesetz an einfachem Schaltkreis","https://www.physik-workshop.de/includes/Fendt/phde/ohmslaw_de.htm","","");
INSERT INTO v_simulationen VALUES("43","Elektromagnetischer Schwingkreis","","","https://www.physik-workshop.de/includes/Fendt/phde/oscillatingcircuit_de.htm");
INSERT INTO v_simulationen VALUES("44","Fadenpendel","https://www.physik-workshop.de/includes/Fendt/phde/pendulum_de.htm","","");
INSERT INTO v_simulationen VALUES("45","Photoeffekt","https://www.physik-workshop.de/includes/Fendt/phde/photoeffect_de.htm","","");
INSERT INTO v_simulationen VALUES("46","Potentiometerschaltung","https://www.physik-workshop.de/includes/Fendt/phde/potentiometer_de.htm","","");
INSERT INTO v_simulationen VALUES("47","Schiefer Wurf","https://www.physik-workshop.de/includes/Fendt/phde/projectile_de.htm","","");
INSERT INTO v_simulationen VALUES("48","Flaschenzug","https://www.physik-workshop.de/includes/Fendt/phde/pulleysystem_de.htm","","");
INSERT INTO v_simulationen VALUES("49","Reflexion und Brechung von Lichtwellen ( Prinzip von Huygens)","https://www.physik-workshop.de/includes/Fendt/phde/refractionhuygens_de.htm","","");
INSERT INTO v_simulationen VALUES("50","Reflexion und Brechung von Licht","https://www.physik-workshop.de/includes/Fendt/phde/refraction_de.htm","","");
INSERT INTO v_simulationen VALUES("51","Keplersches Fernrohr","https://www.physik-workshop.de/includes/Fendt/phde/refractor_de.htm","","");
INSERT INTO v_simulationen VALUES("52","Erzwungene Schwingungen (Resonanz)","https://www.physik-workshop.de/includes/Fendt/phde/resonance_de.htm","","");
INSERT INTO v_simulationen VALUES("53","Gesamtkraft (Vektoraddition)","https://www.physik-workshop.de/includes/Fendt/phde/resultant_de.htm","","");
INSERT INTO v_simulationen VALUES("54","Beugung von Licht am Einfachspalt","https://www.physik-workshop.de/includes/Fendt/phde/singleslit_de.htm","","");
INSERT INTO v_simulationen VALUES("55","Federpendel","https://www.physik-workshop.de/includes/Fendt/phde/springpendulum_de.htm","","");
INSERT INTO v_simulationen VALUES("56","Stehende L&auml;ngswellen","https://www.physik-workshop.de/includes/Fendt/phde/standinglongitudinalwaves_de.htm","","");
INSERT INTO v_simulationen VALUES("57","Stehende Welle (Erkl&auml;rung durch &Uuml;berlagerung mit der reflektierten Welle)","https://www.physik-workshop.de/includes/Fendt/phde/standingwavereflection_de.htm","","");
INSERT INTO v_simulationen VALUES("58","Ein Beispiel zur Zeitdilatation","https://www.physik-workshop.de/includes/Fendt/phde/timedilation_de.htm","","");
INSERT INTO v_simulationen VALUES("59","Aggregatszust&auml;nde","https://phet.colorado.edu/sims/html/states-of-matter/latest/states-of-matter_de.html","&lt;p&gt;Version 1.0.0&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Beobachten Sie verschiedene Molek&amp;uuml;le im festen, fl&amp;uuml;ssigen und gasf&amp;ouml;rmigen Zustand. Ver&amp;auml;ndern Sie die Temperatur und beobachten Sie Phasenwechsel. Ver&amp;auml;ndern Sie die Temperatur und das Volumen und beobachten Sie das Druck-Temperatur-Diagramm in Echtzeit. Beschreiben Sie die Potential-Abstand-Kurve mit den Kr&amp;auml;ften zwischen den Molek&amp;uuml;len.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Beschreiben Sie ein molekulares Modell f&amp;uuml;r Feststoffe, Fl&amp;uuml;ssigkeiten und Gase.&lt;/li&gt;
&lt;li&gt;Erkl&amp;auml;ren Sie Phasen&amp;auml;nderungen in diesem Modell.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie, wie Zufuhr oder Abfuhr von W&amp;auml;rme das Verhalten der Molek&amp;uuml;le ver&amp;auml;ndert.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie, wie eine Volumen&amp;auml;nderung sich auf Temperatur und Druck des Zustands aufwirkt.&lt;/li&gt;
&lt;li&gt;Erstellen Sie ein Druck-Temperatur-Diagramm, um das Verhalten der Molek&amp;uuml;le zu beschreiben.&lt;/li&gt;
&lt;li&gt;Interpretieren Sie Potenzial-Abstands-Diagramme.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie, wie die Kr&amp;auml;fte zwischen den Atomen mit dem Potenzialdiagramm zusammenh&amp;auml;ngen.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie die physikalische Bedeutung der Parameter im LENNARD-JONES-Potenzial, und wie diese bezieht sich auf das Verhalten der Molek&amp;uuml;le auswirken.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("60","Aggregatszust&auml;nde: Grundbegriffe","https://phet.colorado.edu/sims/html/states-of-matter-basics/latest/states-of-matter-basics_de.html","&lt;p&gt;Version 1.0.0&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Beobachten Sie, wie Atome und Molek&amp;uuml;le auf W&amp;auml;rme, K&amp;auml;lte und Druck reagieren und wie sie zwischen den Aggregatszust&amp;auml;nden fest, fl&amp;uuml;ssig und gasf&amp;ouml;rmig wechseln&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Beschreiben Sie Eigenschaften der drei Aggregatszust&amp;auml;nde: fest, fl&amp;uuml;ssig und gasf&amp;ouml;rmig.&lt;/li&gt;
&lt;li&gt;Sagen Sie voraus, wie eine Ver&amp;auml;nderung von Temperatur und Druck das Verhalten der Teilchen beeinflusst.&lt;/li&gt;
&lt;li&gt;Vergleichen Sie Teilchen in den drei verschiedenen Phasen.&lt;/li&gt;
&lt;li&gt;Erkl&amp;auml;ren Sie, was beim Gefrieren und Schmelzen auf molekularer Ebene geschieht.&lt;/li&gt;
&lt;li&gt;Erkennen Sie, das verschiedene Stoffe unterschiedliche Eigenschaften haben, einschlie&amp;szlig;lich Schmelztemperatur und Siedetemperatur.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("61","Arithmetik - Zahlenkunst","https://phet.colorado.edu/sims/html/arithmetic/latest/arithmetic_de.html","&lt;p&gt;Version 1.0.7&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Beherrschen Sie noch das Einmaleins? Frischen Sie Ihre Rechenf&amp;auml;higkeiten mit diesem spannenden Spiel auf (Multiplikation, Division und Faktorisieren).#&lt;/em&gt;&lt;br /&gt;&lt;em&gt;Keine Taschenrechner erlaubt!&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Lernen Sie mit dem Einmaleins multiplizieren, dividieren und faktorisieren.&lt;/li&gt;
&lt;li&gt;Erh&amp;ouml;hen Sie Ihre Genauigkeit beim Multiplizieren, Dividieren und Faktorisieren.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("62","Atomare Wechselwirkung","https://phet.colorado.edu/sims/html/atomic-interactions/latest/atomic-interactions_de.html","&lt;p&gt;Version 1.0.1&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Entdecken Sie die Wechselwirkungen zwischen zwei Atomen (verschiedene Kombinationen m&amp;ouml;glich). &lt;/em&gt;&lt;br /&gt;&lt;em&gt;Verdeutlichen Sie die Kr&amp;auml;fte auf die Atome durch Pfeile (entweder die Gesamtkraft oder anziehende und absto&amp;szlig;ende Kraft getrennt)&lt;/em&gt;&lt;br /&gt;&lt;em&gt;Justieren Sie das Lennard-Jones-Potenzial und sehen Sie, wie die &amp;Auml;nderung der Parameter die Interaktion beeinflusst.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Erkl&amp;auml;ren Sie, wie anziehende und absto&amp;szlig;ende Kr&amp;auml;fte die Wechselwirkung zwischen Atomen bestimmen.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie die Auswirkung der Tiefe der Potentialmulde auf die atomaren Wechselwirkungen.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie den Prozess der Bindung zwischen zwei Atomen energetisch.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("63","Bau ein Atom","https://phet.colorado.edu/sims/html/build-an-atom/latest/build-an-atom_de.html","&lt;p&gt;Version 1.2.3&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Bauen Sie sich ein Atom aus Protonen, Neutronen und Elektronen, und sehen Sie, wie sich das Element, dessen Ladung und Masse ver&amp;auml;ndert. Testen Sie Ihre Ideen in einem Spiel!&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Ermitteln Sie aus der Anzahl der Protonen, Neutronen und Elektronen eines Atoms das Element, dessen Masse und Ladung.&lt;/li&gt;
&lt;li&gt;Sagen Sie voraus, wie Hinzuf&amp;uuml;gen oder Wegnehmen eines Protons, Neutrons oder Elektrons das Element, dessen Ladung und dessen Masse ver&amp;auml;ndert.&lt;/li&gt;
&lt;li&gt;Ermitteln Sie aus dem Namen, der Masse und der Ladung eines Elements die Anzahl der Protonen, Neutronen und Elektronen.&lt;/li&gt;
&lt;li&gt;Definieren Sie die Begriffe Proton, Neutron, Elektron, Atom und Ion.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("64","Br&uuml;che paaren","https://phet.colorado.edu/sims/html/fraction-matcher/latest/fraction-matcher_de.html","&lt;p&gt;Version 1.1.5&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Verdienen Sie sich Sterne in diesem Bruchrechen-Spiel durch richtiges Kombinieren von Formen und Zahlen. Nehmen sie die Herausforderung auf immer schwierigeren Leveln an. Wie viele Sterne k&amp;ouml;nnen Sie sammeln?&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Finden Sie die gleichnamigen Br&amp;uuml;che durch Kombination der richtigen Zahlen und Bilder.&lt;/li&gt;
&lt;li&gt;Erzeugen Sie gleichnamige Br&amp;uuml;che durch Kombination verschiedener Zahlen.&lt;/li&gt;
&lt;li&gt;Finden Sie die gleichnamigen in unterschiedlichen Bildmustern.&lt;/li&gt;
&lt;li&gt;Vergleichen Sie Br&amp;uuml;che mit Zahlen und Bildmustern.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("65","Elektromagnetische Induktion","https://phet.colorado.edu/sims/html/faradays-law/latest/faradays-law_de.html","&lt;p&gt;Version 1.1.7&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Bringen Sie durch Bewegen eines Magnets eine Gl&amp;uuml;hbirne zum Leuchten. Diese Demonstration des FARADAYschen Gesetz k&amp;ouml;nnte Ihnen zeigen, wie Sie Ihre Stromrechnung reduzieren k&amp;ouml;nnten.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Erkl&amp;auml;ren Sie, was passiert, wenn sich der Magnet durch die Spule mit unterschiedlichen Geschwindigkeiten bewegt und welche Auswirkungen dies auf die Helligkeit der Lampe und Gr&amp;ouml;&amp;szlig;e und Vorzeichen der Spannung hat.&lt;/li&gt;
&lt;li&gt;Erl&amp;auml;utern Sie den Unterschied f&amp;uuml;r die unterschiedlichen Bewegungsrichtungen des Magneten in der Spule (von rechts nach links oder von links nach rechts).&lt;/li&gt;
&lt;li&gt;Erkl&amp;auml;ren Sie den Unterschied zwischen Magnetbewegungen in der gro&amp;szlig;e Spule gegen&amp;uuml;ber der kleineren Spule.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("66","Fl&auml;chen belegen","https://phet.colorado.edu/sims/html/area-builder/latest/area-builder_de.html","&lt;p&gt;Version 1.1.3&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Bauen Sie Ihre eigenen farbigen Bl&amp;ouml;cke und untersuchen Sie den Zusammenhang zwischen Umfang und Fl&amp;auml;che. Vergleichen Sie die Fl&amp;auml;che und en Umfang von zwei nebeneinander liegenden Formen.&lt;/em&gt;&lt;br /&gt;&lt;em&gt;Nehmen Sie die Herausforderung im Spielmodus an und ermitteln Sie die Fl&amp;auml;che von seltsamen Figuren. Versuchen Sie, m&amp;ouml;glichst viele Sterne zu sammeln.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Ermitteln Sie die Fl&amp;auml;che einer beliebigen Figur durch Ausz&amp;auml;hlen der Einheits-Quadrate.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie die Beziehung zwischen Fl&amp;auml;che und Umfang.&lt;/li&gt;
&lt;li&gt;Erstellen Sie Formen mit gegebener Fl&amp;auml;che oder Umfang.&lt;/li&gt;
&lt;li&gt;Ermitteln Sie die Fl&amp;auml;che einer unregelm&amp;auml;&amp;szlig;igen Form durch Zerlegung in kleinerer, regelm&amp;auml;&amp;szlig;igerer Formen (z.B. Rechtecke, Dreiecke, Quadrate).&lt;/li&gt;
&lt;li&gt;Ermitteln Sie den Slalierungsfakrot f&amp;uuml;r &amp;auml;hnliche Formen.&lt;/li&gt;
&lt;li&gt;Verallgemeinern Sie die Beziehung zwischen Fl&amp;auml;che und Umfang beim Skalieren.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("67","Funktionen D&uuml;se","https://phet.colorado.edu/sims/html/function-builder/latest/function-builder_de.html","&lt;p&gt;Version 1.0.1&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Spielen Sie mit Funktionen w&amp;auml;hrend Sie die Kunstgeschichte durchst&amp;ouml;bern.&lt;/em&gt;&lt;br /&gt;&lt;em&gt;Entdecken Sie geometrische Transformationen und transformieren Sie Ihr Denken &amp;uuml;ber lineare Funktionen.&lt;/em&gt;&lt;br /&gt;&lt;em&gt;K&amp;ouml;nnen Sie die geheime Funktion finden?&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Definieren Sie eine Funktion als Regel, welche einem Input Wert genau einem Output Wert zuordnet.&lt;/li&gt;
&lt;li&gt;Sagen Sie Output Werte f&amp;uuml;r gegebene Input Werte voraus.&lt;/li&gt;
&lt;li&gt;Setzen Sie Funktionen zusammen.&lt;/li&gt;
&lt;li&gt;Interpretieren, vergleichen und &amp;uuml;bersetzen Sie die verschiedenen Darstellungen von algebraischen Funktionen.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("68","Geraden ziehen","https://phet.colorado.edu/sims/html/graphing-lines/latest/graphing-lines_de.html","&lt;p&gt;Version 1.1.8&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Entdecken Sie die Welt der Geraden. Untersuchen Sie die Beziehungen zwischen den linearen Gleichungen, der Steigung und dem Graphen der Geraden. Nehmen Sie die Herausforderung eines Online-Spiels an!&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Erkl&amp;auml;ren Sie, wie die Steigung einer Gerade berechnet werden kann.&lt;/li&gt;
&lt;li&gt;Zeichnen Sie ein Gerade, wenn deren Gleichung entweder in der Punkt-Abschnitts-Form oder in der Punkt-Steigungs-Form vorliegt.&lt;/li&gt;
&lt;li&gt;Formulieren Sie die Punkt-Abschnitts-Form oder die Punkt-Steigungs-Form einer Geraden aus ihrem Graphen.&lt;/li&gt;
&lt;li&gt;Sagen Sie voraus, wie sich &amp;Auml;nderungen der Variablen in einer lineare Gleichung auf den Graphen auswirkt.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("69","Gravitationslabor","https://phet.colorado.edu/sims/html/gravity-force-lab/latest/gravity-force-lab_de.html","&lt;p&gt;Version 2.1.0&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Visualisieren Sie die Gravitationskraft, die zwei Massen aufeinander aus&amp;uuml;ben. &amp;Auml;ndern Sie die Eigenschaften der Massen, um zu sehen, wie sich die Schwerkraft &amp;auml;ndert.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Erkennen Sie den Zusammenhang zwischen Gravitationskraft, Massen der K&amp;ouml;rper und Abstand zwischen den K&amp;ouml;rpern. Wenden Sie das dritte NEWTONsche Gesetz f&amp;uuml;r Gravitationskr&amp;auml;fte an.&lt;/li&gt;
&lt;li&gt;Entwerfen Sie Experimente, die den quantitativen Zusammenhang zwischen Masse, Entfernung und Gravitationskraft bestimmen.&lt;/li&gt;
&lt;li&gt;Messen Sie die Gravitationskonstante.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("70","Isotope und Atommasse","https://phet.colorado.edu/sims/html/isotopes-and-atomic-mass/latest/isotopes-and-atomic-mass_de.html","&lt;p&gt;Version 1.0.6&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Sind alle Atome eines Elements wirklich gleich? Wie k&amp;ouml;nnen Sie Isotope unterscheiden? Verwenden Sie die Simulation, um mehr &amp;uuml;ber Isotope zu erfahren, insbesondere wie ihre relative H&amp;auml;ufigkeit mit der Atommasse eines Elements zusammenh&amp;auml;ngt.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Definieren Sie den &quot;Isotop&quot; unter Verwendeung der Begriffe Massenzahl, Ordnungszahl, Anzahl der Protonen, Neutronen und Elektronen.&lt;/li&gt;
&lt;li&gt;Ermittlen Sie f&amp;uuml;r ein gegebenes Element Masse und Name eines Isotops.&lt;/li&gt;
&lt;li&gt;Diskutieren Sie folgende Aussage &quot;Die Wahrscheinlichkeit, in der Natur ein Isotop eines Elements zu finden, ist f&amp;uuml;r alle Isotope gleich.&quot;&lt;/li&gt;
&lt;li&gt;Ermitteln Sie die durchschnittliche Atommasse eines Elements aus der H&amp;auml;ufigkeit und Masse seiner Isotope.&lt;/li&gt;
&lt;li&gt;Sagen Sie voraus, wie die Masse und der Namen eines Isotops sich ver&amp;auml;ndert, wenn sich die Anzahl der Protonen, Neutronen oder Elektronen &amp;auml;ndert.&lt;/li&gt;
&lt;li&gt;Sagen Sie voraus, wie sich die durchschnittliche Atommasse eines Elements ver&amp;auml;ndert, wenn die H&amp;auml;ufigkeit seiner Isotope &amp;auml;ndert.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("71","John Travoltage","https://phet.colorado.edu/sims/html/john-travoltage/latest/john-travoltage_de.html","&lt;p&gt;Version 1.2.4&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Lassen Sie die Funken fliegen mit John Travoltage. &lt;/em&gt;&lt;br /&gt;&lt;em&gt;Sehen Sie, wie Aufladung und Bewegungen seiner Hand ihn unterschiedlich schocken.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziel&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Erstellen Sie Modelle f&amp;uuml;r die &amp;uuml;blichen Konzepte der statischen Elektrizit&amp;auml;t (Ladungs&amp;uuml;bertragne, Anziehung, Abstossung und Erdung).&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("72","Kr&auml;fte und Bewegung: Grundlagen","https://phet.colorado.edu/sims/html/forces-and-motion-basics/latest/forces-and-motion-basics_de.html","&lt;p&gt;Version 2.1.2&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Welche Kr&amp;auml;fte wirken beim Tauziehen oder wenn Sie einen K&amp;uuml;hlschrank, eine Kiste oder eine Person verschieben? &amp;Uuml;ben Sie eine Kraft aus und beobachten Sie, wie sich das Objekt bewegt. Beeinflussen Sie die Reibungskraft und sehen Sie die Auswirkung auf die Bewegung der Objekte.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Erkl&amp;auml;ren Sie, wann sich Kr&amp;auml;fte aufheben und wann nicht.&lt;/li&gt;
&lt;li&gt;Ermitteln Sie bei mehreren Kr&amp;auml;ften die resultierende Kraft (vektorielle Summe) auf ein Objekt.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie die Bewegung eines Objektes, wenn die resultierende Kraft gleich Null ist.&lt;/li&gt;
&lt;li&gt;Sagen Sie die Bewegungsrichtung f&amp;uuml;r eine Kombination von Kr&amp;auml;ften voraus.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("73","Ladungen und Felder","https://phet.colorado.edu/sims/html/charges-and-fields/latest/charges-and-fields_de.html","&lt;p&gt;Version 1.0.1&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Bewegen Sie Punktladungen auf einem Spielfeld und beobachten Sie das elektrische Feld, Spannungen, &amp;Auml;quipotenziallinien und mehr. Bunt, dynamisch und kostenlos.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Welche Variablen bestimmen, wie geladene K&amp;ouml;rper interagieren?&lt;/li&gt;
&lt;li&gt;Sagen Sie voraus, wie geladene K&amp;ouml;rper interagieren.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie St&amp;auml;rke und Richtung des elektrischen Feldes um einen geladenen K&amp;ouml;rper.&lt;/li&gt;
&lt;li&gt;Verwenden Sie Diagramme mit Vektoren, um die Wechselwirkungen zu beschreiben.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("74","Lambert-Beer&#039;s Absorptionslabor","https://phet.colorado.edu/sims/html/beers-law-lab/latest/beers-law-lab_de.html","&lt;p&gt;Version 1.4.1&lt;/p&gt;
&lt;p&gt;&lt;em&gt;&quot;Je dicker das Glas, je dunkler das Gebr&amp;auml;u, desto weniger Licht kommt hindurch&quot;&lt;/em&gt;&lt;br /&gt;&lt;em&gt; &amp;ldquo;The thicker the glass, the darker the brew, the less the light that passes through.&amp;rdquo; Stellen Sie bunte konzentrierte und verd&amp;uuml;nnte L&amp;ouml;sungen her und messen Sie mit einer virtuellen Spektralphotometer, wie viel Licht diese absorbieren bzw. hindurchlassen,&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Beschreiben Sie die Beziehungen zwischen dem Volumen und der Menge des gel&amp;ouml;sten Stoffes und der Konzentration der L&amp;ouml;sung.&lt;/li&gt;
&lt;li&gt;Erkl&amp;auml;ren Sie qualitativ die Beziehung zwischen der Farbe der L&amp;ouml;sung und der Konzentration.&lt;/li&gt;
&lt;li&gt;Erkl&amp;auml;ren, wie sich die Konzentration der L&amp;ouml;sung &amp;auml;ndert durch: Hinzuf&amp;uuml;gen oder Entfernen von Wasser, gel&amp;ouml;stem Stoff, L&amp;ouml;sung.&lt;/li&gt;
&lt;li&gt;Berechnen Sie die Konzentration von L&amp;ouml;sungen in der Einheit der Molarit&amp;auml;t (mol/L).&lt;/li&gt;
&lt;li&gt;Stellen Sie eine L&amp;ouml;sung mit einer bestimmten Konzentration her.&lt;/li&gt;
&lt;li&gt;Erkennen Sie, wenn eine L&amp;ouml;sung ges&amp;auml;ttigt ist und sagen Sie voraus, wie sich dann die Konzentration der L&amp;ouml;sung &amp;auml;ndert durch: Hinzuf&amp;uuml;gen oder Entfernen von Wasser, gel&amp;ouml;stem Stoff, L&amp;ouml;sung.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie die Beziehung zwischen der Konzentration der L&amp;ouml;sung und der Intensit&amp;auml;t des adsorbierten bzw. hindurchgelassenen Lichts.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie die Beziehung zwischen Extinktion, molaren Extinktionskoeffizienten, Wegl&amp;auml;nge und Konzentration (LAMBERT-BEERsches Gesetz).&lt;/li&gt;
&lt;li&gt;Erkl&amp;auml;ren Sie, wie und warum sich die Intentit&amp;auml;t des adsorbierten/hindurchgelassenen Lichts ver&amp;auml;ndert bei &amp;Auml;nderung von: Art der L&amp;ouml;sung, Konzentration der L&amp;ouml;sung, Dicke der K&amp;uuml;vette, Lichtquelle.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("75","Lineare Regression","https://phet.colorado.edu/sims/html/least-squares-regression/latest/least-squares-regression_de.html","&lt;p&gt;Version 1.1.4&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Erstellen Sie einen Zufalls Punktwolke oder verwenden Sie Daten aus der realen Welt und versuchen Sie, eine Trendlinie hindurch zu zeichnen. &lt;/em&gt;&lt;br /&gt;&lt;em&gt;Erkunden Sie, wie einzelne Datenpunkte den Korrelationskoeffizient und die Trendlinie beeinflussen.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Interpretieren Sie den Korrelationskoeffizient r, wenn Datenpunkte hinzugef&amp;uuml;gt/weggenommen/verschoben werden.&lt;/li&gt;
&lt;li&gt;Interpretieren Sie die Residuensumme bei der manuellen Anpassung einer Trendlinie.&lt;/li&gt;
&lt;li&gt;Interpretieren Sie die Residuensumme der Trendlinie, wenn Datenpunkte hinzugef&amp;uuml;gt/weggenommen/verschoben werden.&lt;/li&gt;
&lt;li&gt;Vergleichen Sie die Residuensumme zwischen einer manuell angepassten Trendlinie und der berechneten besten Regressionsgerade.&lt;/li&gt;
&lt;li&gt;Sagen Sie voraus, ob eine lineare Regression angemessen ist.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("76","Molek&uuml;le und Licht","https://phet.colorado.edu/sims/html/molecules-and-light/latest/molecules-and-light_de.html","&lt;p&gt;Version 1.1.12&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Haben Sie sich jemals gefragt, wie ein Treibhausgas das Klima beeinflusst, oder warum die Ozonschicht wichtig ist? Diese Verwenden Sie diese Simulation, um die Wechselwirkung von Licht mit Molek&amp;uuml;len der Atmosph&amp;auml;re zu untersuchen.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Entdecken Sie, wie Licht mit Molek&amp;uuml;len in der Atmosph&amp;auml;re wechselwirkt und dass die die Absorption vom Molek&amp;uuml;l und der Strahlungsart abh&amp;auml;ngt.&lt;/li&gt;
&lt;li&gt;Korrelieren Sie die Energie des Lichts mit der resultierenden Bewegung (Energie steigt von Mikrowellen zur ultraviolettem Strahlung an).&lt;/li&gt;
&lt;li&gt;Sagen Sie die Bewegung eines Molek&amp;uuml;ls voraus, wenn die Art des adsorbieren Lichts gegeben ist.&lt;/li&gt;
&lt;li&gt;Korrelieren Sie die Struktur eines Molek&amp;uuml;ls mit der Art und Weise, wie es mit Licht wechselwirkt.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("77","Molek&uuml;lgeometrie - Grundlagen","https://phet.colorado.edu/sims/html/molecule-shapes-basics/latest/molecule-shapes-basics_de.html","&lt;p&gt;Version 1.1.6&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Konstruieren Sie verschiedene Molek&amp;uuml;le in 3D. Finden Sie heraus, wie ein Molek&amp;uuml;l seine Form &amp;auml;ndert, wenn Sie Atome hinzuf&amp;uuml;gen.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Erkennen Sie, dass die Form eines Molek&amp;uuml;ls aus der Absto&amp;szlig;ung zwischen Atomen resultiert.&lt;/li&gt;
&lt;li&gt;Erkennen Sie, dass die Bindungen nicht starr sind, sondern sich als Folge von Absto&amp;szlig;ungen drehen k&amp;ouml;nnen.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("78","Molek&uuml;lgeometrien","https://phet.colorado.edu/sims/html/molecule-shapes/latest/molecule-shapes_de.html","&lt;p&gt;Version 1.1.8&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Konstruieren Sie verschiedene Molek&amp;uuml;le in 3D. Wie ver&amp;auml;ndert sich die Form eines Molek&amp;uuml;ls bei unterschiedlicher Anzahl von Bndungen und Elektronenpaaren?&lt;/em&gt;&lt;br /&gt;&lt;em&gt;Erg&amp;auml;nzen Sie Einfach- Doppel- oder Dreifachbindungen und einsame Elektronenpaare. Vergleichen sie Modelle mit realen Molek&amp;uuml;len.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Erkennen Sie, dass die Form eines Molek&amp;uuml;ls aus der Absto&amp;szlig;ung zwischen Elektronengruppen resultiert.&lt;/li&gt;
&lt;li&gt;Erkennen Sie den Unterschied zwischen Elektronen- und molekularer Geometrie.&lt;/li&gt;
&lt;li&gt;Benennen Sie Molek&amp;uuml;l und Elektronen Geometrie f&amp;uuml;r Molek&amp;uuml;le mit bis zu sechs Elektronengruppen um ein Zentralatom.&lt;/li&gt;
&lt;li&gt;Vergleichen Sie Voraussagen von Bindungswinkeln nach dem VSEPR-Modell mit realen Molek&amp;uuml;len.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie, wie Elektronenpaare Bindungswinkel in realen Molek&amp;uuml;len beeinflussen.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("79","Ohmsches Gesetz","https://phet.colorado.edu/sims/html/ohms-law/latest/ohms-law_de.html","&lt;p&gt;Version 1.3.5&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Sehen Sie, wie das OHMsche Gesetz bei einer einfachen Schaltung funktioniert. Stellen Sie Spannung und Widerstand ein und beobachten Sie den Strom, der sich entsprechend dem OHMschen Gesetz einstellt. Die Symbole in der Gleichung &amp;auml;ndern ihre Gr&amp;ouml;&amp;szlig;e je nach den eingstellten Werten.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziel&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Wie &amp;auml;ndert sich der Strom durch den Widerstand, wenn Sie die Batteriespannung &amp;auml;ndern? Kann es sein, dass Strom und Widerstand konstant bleiben? Wie ver&amp;auml;ndert sich die Stromst&amp;auml;rke und die Batteriespannung, wenn Sie den Wert der Widerstands &amp;auml;ndern? Kann es sein, dass Strom und Spannung konstant bleiben?&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("80","pH Skala","https://phet.colorado.edu/sims/html/ph-scale/latest/ph-scale_de.html","&lt;p&gt;Version 1.2.8&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Testen Sie den pH-Wert verschiedener Fl&amp;uuml;ssigkeiten wie Kaffee, Speichel oder Seife, um zu bestimmen, ob sie sauer, basisch oder neutral sind. Visualisieren Sie die relative Anzahl der Hydroxid-Ionen und Hydronium-Ionen in der L&amp;ouml;sung. Wechseln Sie zwischen logarithmischen und linearen Skalen. Untersuchen Sie, ob eine Ver&amp;auml;nderung des Volumens oder Verd&amp;uuml;nnen mit Wasser den pH-Wert beeinflusst. Oder kreieren Sie Ihre eigenen Fl&amp;uuml;ssigkeit!&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Bestimmen Sie, ob eine L&amp;ouml;sung sauer oder basisch ist.&lt;/li&gt;
&lt;li&gt;Ordnen Sie S&amp;auml;uren oder Basen nach ihrer St&amp;auml;rke&lt;/li&gt;
&lt;li&gt;Beschreiben Sie auf molekularer Ebene (mit Abbildungen) wie sich das Ionenprodukt des Wassers mit dem pH-Wert &amp;auml;ndert.&lt;/li&gt;
&lt;li&gt;Bestimmen Sie die Konzentration von Hydroxidionen, Hydroniumionen und Wasser bei einem gegebenen pH-Wert.&lt;/li&gt;
&lt;li&gt;Sagen Sie voraus (qualitativ und quantitativ), wie Verd&amp;uuml;nnung und Volumen den pH-Wert und die Konzentrationen der Hydroxidionen, Hydroniumionen und Wasser beeinflussen.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("81","Plinko Nagelbrett","https://phet.colorado.edu/sims/html/plinko-probability/latest/plinko-probability_de.html","&lt;p&gt;Version 1.0.1&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Spielen Sie &quot;Plinko&quot; und lernen Sie dabei Statistik. Lassen Sie Kugeln durch ein dreieckiges Gitter von Zapfen fallen und beobachten Sie die Kugeln auf ihrer Irrfahrt durch das Gitter. Beobachten Sie, wie sich das Histogramm der Endlagen aufzubaut und sich der Binomialverteilung n&amp;auml;hert. Inspiriert von der &quot;Virtual Lab in Probability and Statistics&quot; von der Universit&amp;auml;t von Alabama in Huntsville (&lt;a href=&quot;www.math.uah.edu/stat)&quot;&gt;www.math.uah.edu/stat)&lt;/a&gt;&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Sagen Sie voraus, in welchen Beh&amp;auml;lter eine einzelne Kugel f&amp;auml;llt&lt;/li&gt;
&lt;li&gt;Werfen Sie 100 Kugeln und vergleichen Sie die Ergebnisse&lt;/li&gt;
&lt;li&gt;Z&amp;auml;hlen Sie die Kugeln in einem Beh&amp;auml;lter und setzen Sie diese in Beziehung zur Wahrscheinlichkeit, dass eine Kugel in diesen Beh&amp;auml;lter f&amp;auml;llt.&lt;/li&gt;
&lt;li&gt;Vergleichen und interpretieren Sie empirische und theoretische Statistik&lt;/li&gt;
&lt;li&gt;Nutzen Sie die Plinko Simulation als ein Modell f&amp;uuml;r andere Szenarios mit Verteilungsfunktionen.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("82","Reaktanden, Produkte und &Uuml;berresten","https://phet.colorado.edu/sims/html/reactants-products-and-leftovers/latest/reactants-products-and-leftovers_de.html","&lt;p&gt;Version 1.1.7&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Erstellen Sie Ihr eigenes Sandwichrezept und sehen Sie, wie viele Sandwiches Sie aus unterschiedlichen Mengen an Zutaten machen k&amp;ouml;nnen. Machen Sie dasselbe mit chemischen Reaktionen. Sehen Sie, wie viele Produkte Sie mit unterschiedlichen Mengen an Reaktanten (Edukten) machen k&amp;ouml;nnen. Spielen Sie ein Spiel, um Ihr Wissen von Reaktanten, Produkten und &amp;Uuml;berschu&amp;szlig;reagentien zu testen.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Verkn&amp;uuml;pfen Sie Sandwichrezepte mit der St&amp;ouml;chiometrie chemischer Reaktionen.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie, was &quot;limitierendes Reagenz&quot; f&amp;uuml;r ein Sandwichrezept und f&amp;uuml;r eine chemische Reaktion bedeutet.&lt;/li&gt;
&lt;li&gt;Identifizieren Sie limitierende Reagenzien bei einer chemischen Reaktion.&lt;/li&gt;
&lt;li&gt;Formulieren Sie das Gesetz der Erhaltung der Massen in eigenen Worten (mit Beispielen von Sandwichrezepten und chemische Reaktion).&lt;/li&gt;
&lt;li&gt;Sagen Sie die Mengen an Produkt und &amp;Uuml;berschu&amp;szlig;reagenz nach einer Reaktion voraus.&lt;/li&gt;
&lt;li&gt;Ermitteln Sie die Anfangsmengen der Reaktanten, wenn die Mengen der Produkte und &amp;Uuml;berschu&amp;szlig;reagenzien gegeben sind.&lt;/li&gt;
&lt;li&gt;&amp;Uuml;bersetzen Sie chemische Formel in bildhafte Darstellungen.&lt;/li&gt;
&lt;li&gt;Erkl&amp;auml;ren Sie, wie Indizes und Koeffizienten verwendet werden, um st&amp;ouml;chiometrische Rechnungen durchzuf&amp;uuml;hren.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("83","Reaktionsgleichungen ausgleichen","https://phet.colorado.edu/sims/html/balancing-chemical-equations/latest/balancing-chemical-equations_de.html","&lt;p&gt;Version 1.1.7&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Wie wissen Sie, ob eine chemische Gleichung ausgeglichen ist? Was k&amp;ouml;nnen Sie ver&amp;auml;ndern, um eine Gleichung auszugleichen? Spielen Sie ein Spiel, um Ihre Ideen zu testen!&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Gleichen Sie eine chemische Gleichung aus.&lt;/li&gt;
&lt;li&gt;Erkennen Sie, dass die Anzahl der Atome der einzelnen Elemente bei einer chemischen Reaktion erhalten bleibt.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie den Unterschied zwischen den Koeffizienten und Indizes in einer chemischen Gleichung.&lt;/li&gt;
&lt;li&gt;&amp;Uuml;bersetzen Sie symbolische Darstellungen in Formelschreibweise.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("84","Reibung","https://phet.colorado.edu/sims/html/friction/latest/friction_de.html","&lt;p&gt;Version 1.3.1&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Beobachten Sie, wie Reibung ein Material erw&amp;auml;rmen oder schmelzen kann. Reiben Sie zwei Objekte aneinander, um sie zu erw&amp;auml;rmen. Wenn Sie die Schmelztemperatur erreichen, werden die Molek&amp;uuml;le des Materials beweglicher und das das Material schmilzt.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Beschreiben Sie das Ph&amp;auml;nomen der Reibung auf molekularer Ebene.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie die Molekularbewegung in Materie. Verwenden Sie dazu Diagramme, erl&amp;auml;utern Sie den Einflu&amp;szlig; von Teilchenmassse und Temperatur auf die Bewegung, erkl&amp;auml;ren Sie die Unterschiede und Gemeinsamkeiten der Bewegung in Feststoffen, Fl&amp;uuml;ssigkeiten und Gasen und erl&amp;auml;utern Sie, wie Gr&amp;ouml;&amp;szlig;e und Geschwindigkeit der Gasmolek&amp;uuml;le mit allt&amp;auml;glichen Ph&amp;auml;nomenen zusammenh&amp;auml;ngen.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("85","Rutherford Streuung","https://phet.colorado.edu/sims/html/rutherford-scattering/latest/rutherford-scattering_de.html","&lt;p&gt;Version 1.0.4&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Wie hat RUTHERFORD die Struktur des Atoms herauszufinden, ohne es tats&amp;auml;chlich zu sehen? Simulieren Sie das ber&amp;uuml;hmte Experiment, in dem er das THOMSONsche Modell (Plumpuddingmodell oder Rosinenkuchenmodell) widerlegt: Die Streuung der Alphateilchen weist auf einen sehr kleinen Atomkern hin.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Beschreiben Sie den qualitativen Unterschied zwischen Streuung an einem positiv geladenen Kern und einem elektrisch neutralen THOMSONschen Plumpudding-Atom&lt;/li&gt;
&lt;li&gt;Beschreiben Sie qualitativ, wie der Ablenkwinkel abh&amp;auml;ngt von: Energie der ankommenden Teilchen, Aufprallparameter, Ladung des Kerns&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("86","Saure &amp; basische L&ouml;sungen","https://phet.colorado.edu/sims/html/acid-base-solutions/latest/acid-base-solutions_de.html","&lt;p&gt;Version 1.2.8&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Wie unterscheiden sich starke und schwache S&amp;auml;uren? Verwenden Sie Laborger&amp;auml;te mit Ihrem Computer, um dies heraus zu finden. Tauchen Sie das pH-Papier oder die Elektrode in die L&amp;ouml;sung, um den pH-Wert zu messen, oder nutzen Sie die Elektroden, um die Leitf&amp;auml;higkeit zu messen. Ermitteln Sie, wie Konzentration und St&amp;auml;rke den pH-Wert beeinflussen. Kann eine schwache S&amp;auml;ure denselben pH-Wert haben wie eine starke S&amp;auml;ure?&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Gegeben sind S&amp;auml;uren oder Basen in der gleichen Konzentration. K&amp;ouml;nnen Sie ihre S&amp;auml;ure- bzw. Basenst&amp;auml;rke zuordnen?&lt;/li&gt;
&lt;li&gt;1. Setzen Sie die St&amp;auml;rke einer S&amp;auml;ure oder Base in Beziehung zu ihrem Dissoziationsgrad&lt;/li&gt;
&lt;li&gt;2. Identifizieren Sie alle Molek&amp;uuml;le und Ionen, die in einer bestimmten S&amp;auml;ure-oder Base-L&amp;ouml;sung vorhanden sind.&lt;/li&gt;
&lt;li&gt;3. Vergleichen Sie die relativen Konzentrationen von Molek&amp;uuml;len und Ionen in schwachen und starken S&amp;auml;ure (oder Basen)&lt;/li&gt;
&lt;li&gt;4. Beschreiben Sie Gemeinsamkeiten und Unterschieden zwischen starken S&amp;auml;uren und schwachen S&amp;auml;uren oder starken Basen und schwachen Basen.&lt;/li&gt;
&lt;li&gt;Erkennen Sie die Bedeutung der Konzentration der L&amp;ouml;sung:&lt;/li&gt;
&lt;li&gt;1. Beschreiben Sie die Gemeinsamkeiten und Unterschiede zwischen konzentrierter und verd&amp;uuml;nnter L&amp;ouml;sungen.&lt;/li&gt;
&lt;li&gt;2. Vergleichen Sie die Konzentrationen aller Molek&amp;uuml;le und Ionen in konzentrierter und verd&amp;uuml;nnten L&amp;ouml;sungen einer bestimmten S&amp;auml;ure oder Base.&lt;/li&gt;
&lt;li&gt;Verwenden sowohl die St&amp;auml;rke der S&amp;auml;ure oder Base als auch deren Konzentration:&lt;/li&gt;
&lt;li&gt;1. Beschreiben Sie in Worten und Bildern (Grafiken oder Formeln):&lt;/li&gt;
&lt;li&gt;Konzentrierte L&amp;ouml;sung einer schwachen S&amp;auml;ure (oder Base)&lt;/li&gt;
&lt;li&gt;konzentrierte L&amp;ouml;sung einer starken S&amp;auml;ure (oder Base)&lt;/li&gt;
&lt;li&gt;2. Untersuchen Sie verschiedene Kombinationen von S&amp;auml;urest&amp;auml;rke und Konzentrationen, die zu gleichen pH-Werten f&amp;uuml;hren.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie, wie Sie mit den &amp;uuml;blichen Instrumenten (pH-Meter, Konduktometer, pH-Papier) die St&amp;auml;rke und Konzentration einer S&amp;auml;ure (bzw. Base) identifizierern k&amp;ouml;nnen.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("87","Seilwelle","https://phet.colorado.edu/sims/html/wave-on-a-string/latest/wave-on-a-string_de.html","&lt;p&gt;Version 1.1.6&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Beobachten Sie, wie ein Seil in Zeitlupe schwingt. Erzeugen Sie Wellen, indem Sie das Seilende manuell bewegen oder mittels eines Oszillators (Frequenz und Amplitude einstellbar). Ver&amp;auml;ndern Sie die D&amp;auml;mpfung und die Spannung des Seils. Das Seilende kann fest, lose oder offen sein.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Nennen Sie charakteristische Welleneigenschaften in allgemein verst&amp;auml;ndlicher Sprache.&lt;/li&gt;
&lt;li&gt;Sagen Sie das Verhalten von Wellen in unterschiedliche Medium und bei Reflexion voraus.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("88","Stimulation eines Neurons","https://phet.colorado.edu/sims/html/neuron/latest/neuron_de.html","&lt;p&gt;Version 1.1.1&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Stimulieren Sie ein Neurons und beobachten Sie, was passiert. Beobachten Sie im Detail, wie sich die Ionen durch die Membran bewegen (Vorlauf, R&amp;uuml;cklauf, Pause m&amp;ouml;glich).&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Beschreiben Sie, wann sich Ionen durch eine Neuron-Membran bewegen k&amp;ouml;nnen und wann nicht.&lt;/li&gt;
&lt;li&gt;Identifizieren Sie die verschiedenen Ionenkan&amp;auml;le und beschreiben Sie deren Funktion.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie, wie sich die Membranpermeabilit&amp;auml;t bei den verschiedenen Arten von Ionenkan&amp;auml;len &amp;auml;ndert.&lt;/li&gt;
&lt;li&gt;Beschreiben Sie die Abfolge der Ereignisse, die ein Aktionspotential erzeugt.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("89","Stoffmengenkonzentration","https://phet.colorado.edu/sims/html/molarity/latest/molarity_de.html","&lt;p&gt;Version 1.2.8&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Was bestimmt die Konzentration einer L&amp;ouml;sung? Lernen Sie den Zusammenhang zwischen Stoffmenge, Volumen, Molarit&amp;auml;t und der Menge an gel&amp;ouml;stem Stoff und L&amp;ouml;semittel.&lt;/em&gt;&lt;br /&gt;&lt;em&gt;Vergleichen Sie das Verhalten verschiedener chemischer Verbindungen in Wasser.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Beschreiben Sie die Beziehung zwischen Volumen und Menge des gel&amp;ouml;sten Stoffes sowie der Konzentration.&lt;/li&gt;
&lt;li&gt;Erkl&amp;auml;ren Sie, wie die Farbe der L&amp;ouml;sung und ihre Konzentration in Zusammenhang stehen.&lt;/li&gt;
&lt;li&gt;Berechnen Sie die Konzentration von L&amp;ouml;sungen in der Einheiten der Molarit&amp;auml;t (mol/L).&lt;/li&gt;
&lt;li&gt;Verwenden Sie die Molarit&amp;auml;t, um die Verd&amp;uuml;nnung von L&amp;ouml;sungen zu berechnen.&lt;/li&gt;
&lt;li&gt;Vergleichen Sie die L&amp;ouml;slichkeitsgrenzen verschiedener Stoffe.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("90","Trigonometrie Tour","https://phet.colorado.edu/sims/html/trig-tour/latest/trig-tour_de.html","&lt;p&gt;Version 1.0.6&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Gehen Sie auf eine trigonometrische Reise mit Gradmass und Bogenmass. Suchen Sie Muster in den Werten und in den Graphen wenn Sie den Winkel &amp;auml;ndern. Vergleichen Sie Sinus, Cosines und Tangens.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Definieren Sie trigonometrische Funktionen f&amp;uuml;r negative Winkel und Winkel gr&amp;ouml;&amp;szlig;er als 90 Grad.&lt;/li&gt;
&lt;li&gt;Wandeln Sie die verschiedenen Darstellungen von trigonometrischen Funktionen ineinander um: als Seite eines rechtwinkligen Dreiecks im Einheitskreis, als graphische Darstellung (Funktion des Winkels) oder als numerischer Wert der Funktion.&lt;/li&gt;
&lt;li&gt;Ermitteln Sie das Vorzeichen der trigonometrischen Funktion (+, -, 0) f&amp;uuml;r beliebige Winkel ohne Taschenrechner am Einheitskreis.&lt;/li&gt;
&lt;li&gt;Ermitteln Sie den Wert der trigonometrischen Funktion f&amp;uuml;r beliebige Winkel ohne Taschenrechner am Einheitskreis.&lt;/li&gt;
&lt;li&gt;Definieren Sie exakte trigonometrische Funktionen f&amp;uuml;r spezielle Winkel mit Grad und Bogenmass Angaben.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("91","Unter Druck","https://phet.colorado.edu/sims/html/under-pressure/latest/under-pressure_de.html","&lt;p&gt;Version 1.1.2&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Untersuchen Sie den Druck unter und &amp;uuml;ber Wasser. Beobachten Sie die Ver&amp;auml;nderungen des Drucks, wenn Sie folgende Parameter &amp;auml;ndern: Fl&amp;uuml;ssigkeit, Schwerkraft, Beh&amp;auml;lterform, Beh&amp;auml;ltervolumen.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Untersuchen Sie, wie sich der Druck in Luft und Wasser ver&amp;auml;ndert.&lt;/li&gt;
&lt;li&gt;Welche M&amp;ouml;glichkeiten gibt es, den Druck zu &amp;auml;ndern?&lt;/li&gt;
&lt;li&gt;Sagen Sie den Druck f&amp;uuml;r eine Vielzahl von Situationen voraus.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("92","Widerstand in einem Kabel","https://phet.colorado.edu/sims/html/resistance-in-a-wire/latest/resistance-in-a-wire_de.html","&lt;p&gt;Version 1.2.6&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Erfahren Sie mehr &amp;uuml;ber die Physik des elektrischen Widerstands in einem Draht. &amp;Auml;ndern Sie den spezifischen Widerstand, die L&amp;auml;nge und den Querschnitt des Drahtes und beobachten Sie den Einflu&amp;szlig; auf den Widerstand des Drahtes. Die Symbole in der Gleichung &amp;auml;ndern ihre Gr&amp;ouml;&amp;szlig;e entsprechend den eingestellten Werten.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Welche Parameter eines Widerstandes sind variabel in diesem Modell?&lt;/li&gt;
&lt;li&gt;Wie beeinflusst jeder Parameter den Widerstand?&lt;/li&gt;
&lt;li&gt;Versuchen Sie dieses Verhalten zu erkl&amp;auml;ren.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("93","Hooke&#039;s Law","https://phet.colorado.edu/sims/html/hookes-law/latest/hookes-law_en.html","&lt;p&gt;Version 1.0.7&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Dehnen und komprimieren Sie Federn, um den Zusammenhang zwischen Kraft, Federkonstante, Federl&amp;auml;nge und potenzieller Energie zu finden.&lt;/em&gt;&lt;br /&gt;&lt;em&gt;Untersuchen Sie, was passiert wenn zwei Federn hintereinander oder parallel geschaltet werden.&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Untersuchen Sie den Zusammenhang zwischen Kraftaufwand, Federkraft, Federkonstante, Federl&amp;auml;nge und potenzieller Energie.&lt;/li&gt;
&lt;li&gt;Erkl&amp;auml;ren Sie wie die Zusammenschaltung von zwei Federn (hintereinander oder parallel) die effektive Federkonstante und die Federkr&amp;auml;fte ver&amp;auml;ndert.&lt;/li&gt;
&lt;li&gt;Sagen Sie voraus, wie die in der Feder gespeicherte potenzielle Energie sich mit der Federkonstante und die Federl&amp;auml;nge ver&amp;auml;ndert.&lt;/li&gt;
&lt;/ul&gt;","");
INSERT INTO v_simulationen VALUES("94","Make a Ten","https://phet.colorado.edu/sims/html/make-a-ten/latest/make-a-ten_en.html","&lt;p&gt;Version 1.0.1&lt;/p&gt;
&lt;p&gt;&lt;em&gt;Add numbers by making tens. Break apart and combine numbers while focusing on place value. Use the adding screen to add any two numbers. Use the game screen to apply your make-a-ten strategies!&lt;/em&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Lernziele&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Improve understanding of place value by using different sizes of papers for ones, tens, and hundreds.&lt;/li&gt;
&lt;li&gt;Develop mental math strategies when taking apart and putting together numbers.&lt;/li&gt;
&lt;li&gt;Use the &amp;ldquo;make a ten&amp;rdquo; strategy when counting and doing addition.&lt;/li&gt;
&lt;li&gt;Develop a mental model of the basic properties of numbers including commutativity, associativity, and closure.&lt;/li&gt;
&lt;/ul&gt;","");



DROP TABLE v_simulationen_themen_match;

CREATE TABLE `v_simulationen_themen_match` (
  `simID` int(11) NOT NULL,
  `themaID` int(11) NOT NULL,
  UNIQUE KEY `simID_themaID` (`simID`,`themaID`),
  KEY `themaID` (`themaID`),
  CONSTRAINT `v_simulationen_themen_match_ibfk_1` FOREIGN KEY (`simID`) REFERENCES `v_simulationen` (`simID`),
  CONSTRAINT `v_simulationen_themen_match_ibfk_2` FOREIGN KEY (`themaID`) REFERENCES `videos_themen` (`themaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO v_simulationen_themen_match VALUES("6","1");
INSERT INTO v_simulationen_themen_match VALUES("9","1");
INSERT INTO v_simulationen_themen_match VALUES("10","1");
INSERT INTO v_simulationen_themen_match VALUES("49","1");
INSERT INTO v_simulationen_themen_match VALUES("50","1");
INSERT INTO v_simulationen_themen_match VALUES("51","1");
INSERT INTO v_simulationen_themen_match VALUES("54","1");
INSERT INTO v_simulationen_themen_match VALUES("74","1");
INSERT INTO v_simulationen_themen_match VALUES("2","2");
INSERT INTO v_simulationen_themen_match VALUES("8","2");
INSERT INTO v_simulationen_themen_match VALUES("12","2");
INSERT INTO v_simulationen_themen_match VALUES("16","2");
INSERT INTO v_simulationen_themen_match VALUES("18","2");
INSERT INTO v_simulationen_themen_match VALUES("22","2");
INSERT INTO v_simulationen_themen_match VALUES("23","2");
INSERT INTO v_simulationen_themen_match VALUES("29","2");
INSERT INTO v_simulationen_themen_match VALUES("30","2");
INSERT INTO v_simulationen_themen_match VALUES("32","2");
INSERT INTO v_simulationen_themen_match VALUES("34","2");
INSERT INTO v_simulationen_themen_match VALUES("35","2");
INSERT INTO v_simulationen_themen_match VALUES("37","2");
INSERT INTO v_simulationen_themen_match VALUES("41","2");
INSERT INTO v_simulationen_themen_match VALUES("44","2");
INSERT INTO v_simulationen_themen_match VALUES("47","2");
INSERT INTO v_simulationen_themen_match VALUES("48","2");
INSERT INTO v_simulationen_themen_match VALUES("53","2");
INSERT INTO v_simulationen_themen_match VALUES("69","2");
INSERT INTO v_simulationen_themen_match VALUES("72","2");
INSERT INTO v_simulationen_themen_match VALUES("84","2");
INSERT INTO v_simulationen_themen_match VALUES("91","2");
INSERT INTO v_simulationen_themen_match VALUES("93","2");
INSERT INTO v_simulationen_themen_match VALUES("59","3");
INSERT INTO v_simulationen_themen_match VALUES("60","3");
INSERT INTO v_simulationen_themen_match VALUES("21","4");
INSERT INTO v_simulationen_themen_match VALUES("36","4");
INSERT INTO v_simulationen_themen_match VALUES("45","4");
INSERT INTO v_simulationen_themen_match VALUES("62","4");
INSERT INTO v_simulationen_themen_match VALUES("63","4");
INSERT INTO v_simulationen_themen_match VALUES("70","4");
INSERT INTO v_simulationen_themen_match VALUES("76","4");
INSERT INTO v_simulationen_themen_match VALUES("77","4");
INSERT INTO v_simulationen_themen_match VALUES("78","4");
INSERT INTO v_simulationen_themen_match VALUES("80","4");
INSERT INTO v_simulationen_themen_match VALUES("81","4");
INSERT INTO v_simulationen_themen_match VALUES("85","4");
INSERT INTO v_simulationen_themen_match VALUES("88","4");
INSERT INTO v_simulationen_themen_match VALUES("89","4");
INSERT INTO v_simulationen_themen_match VALUES("7","5");
INSERT INTO v_simulationen_themen_match VALUES("14","5");
INSERT INTO v_simulationen_themen_match VALUES("17","5");
INSERT INTO v_simulationen_themen_match VALUES("27","5");
INSERT INTO v_simulationen_themen_match VALUES("31","5");
INSERT INTO v_simulationen_themen_match VALUES("38","5");
INSERT INTO v_simulationen_themen_match VALUES("39","5");
INSERT INTO v_simulationen_themen_match VALUES("40","5");
INSERT INTO v_simulationen_themen_match VALUES("42","5");
INSERT INTO v_simulationen_themen_match VALUES("46","5");
INSERT INTO v_simulationen_themen_match VALUES("65","5");
INSERT INTO v_simulationen_themen_match VALUES("71","5");
INSERT INTO v_simulationen_themen_match VALUES("73","5");
INSERT INTO v_simulationen_themen_match VALUES("79","5");
INSERT INTO v_simulationen_themen_match VALUES("92","5");
INSERT INTO v_simulationen_themen_match VALUES("13","6");
INSERT INTO v_simulationen_themen_match VALUES("15","6");
INSERT INTO v_simulationen_themen_match VALUES("19","6");
INSERT INTO v_simulationen_themen_match VALUES("20","6");
INSERT INTO v_simulationen_themen_match VALUES("24","6");
INSERT INTO v_simulationen_themen_match VALUES("25","6");
INSERT INTO v_simulationen_themen_match VALUES("26","6");
INSERT INTO v_simulationen_themen_match VALUES("28","6");
INSERT INTO v_simulationen_themen_match VALUES("33","6");
INSERT INTO v_simulationen_themen_match VALUES("43","6");
INSERT INTO v_simulationen_themen_match VALUES("52","6");
INSERT INTO v_simulationen_themen_match VALUES("55","6");
INSERT INTO v_simulationen_themen_match VALUES("56","6");
INSERT INTO v_simulationen_themen_match VALUES("57","6");
INSERT INTO v_simulationen_themen_match VALUES("87","6");



DROP TABLE videos;

CREATE TABLE `videos` (
  `vID` int(11) NOT NULL AUTO_INCREMENT,
  `titel` text NOT NULL,
  `beschreibung` text NOT NULL,
  `code` tinytext NOT NULL,
  `link_webpage` text NOT NULL,
  `pfad` text NOT NULL COMMENT 'Hauptablageordner des Videos',
  `dateiname` text NOT NULL,
  `parameter` text NOT NULL COMMENT 'sonstige Einstellungen',
  PRIMARY KEY (`vID`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

INSERT INTO videos VALUES("24","Brechung - optisch dünn zu dicht","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/brechung/brechung1/index.html","Optik","brechung_duenn_dicht.m4v","");
INSERT INTO videos VALUES("31","Geknickter Stab","Stab in wassergefülltem Aquarium","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/videos-zur-reflexion/reflexion2/index.html","Optik","brechung_geknickter.m4v","");
INSERT INTO videos VALUES("32","Brechung - optisch dicht nach dünn","Plexiglas","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/brechung/brechung1/index.html","Optik","brechung_dicht_dünn.m4v","");
INSERT INTO videos VALUES("33","Anvisieren durch Oberfläche","Jagd","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/brechung/brechung1/index.html","Optik","brechung_visieren.m4v","");
INSERT INTO videos VALUES("34","Regenbogen","Plexiglas","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/brechung/brechung4/index.html","Optik","brechung_regenbogen.m4v","");
INSERT INTO videos VALUES("35","Brechung am Prisma","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/brechung/brechung5/index.html","Optik","brechung_prisma_1strahl.m4v","");
INSERT INTO videos VALUES("36","Planparallele Platte","Plexiglas","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/brechung/brechung6/index.html","Optik","brechung_planparallele_platte.m4v","");
INSERT INTO videos VALUES("37","Münze in der Tasse","Tasse","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/brechung/brechung7/index.html","Optik","brechung_muenze.m4v","");
INSERT INTO videos VALUES("38","Brechung an Prisma 5 Strahlen","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/brechung/brechung1/index.html","Optik","brechung_prisma_5strahlen.m4v","");
INSERT INTO videos VALUES("39","Linsen","Zerstreuungs und Sammellinse","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/brechung/linsen/index.html","Optik","brechung_linsen.m4v","");
INSERT INTO videos VALUES("40","Entstehung Lichstrahl","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/lichtausbreitung/lichtbuendel_lichtstrahl/index.html","Optik","lichtstrahl.m4v","");
INSERT INTO videos VALUES("41","Reflexion Spiegel","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/videos-zur-reflexion/reflexion1/index.html","Optik","spiegel.m4v","");
INSERT INTO videos VALUES("42","Reflexion Umkehrspiegel","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/videos-zur-reflexion/reflexion2/index.html","Optik","umkehrspiegel.m4v","");
INSERT INTO videos VALUES("43","Reflexion Hohlspiegel","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/videos-zur-reflexion/reflexion3/index.html","Optik","hohlspiegel.m4v","");
INSERT INTO videos VALUES("44","Schatten","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/lichtausbreitung/schatten/index.html","Optik","schatten.m4v","");
INSERT INTO videos VALUES("45","Schatten mit Kerzen","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/lichtausbreitung/schatten/index.html","Optik","schatten_kerze.m4v","");
INSERT INTO videos VALUES("46","Totalreflexion Grundversuch","Plexiglaskörper","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/videos-zur-totalreflexion/totalreflexion1/index.html","Optik","totalreflexion_am_glaskoerper.m4v","");
INSERT INTO videos VALUES("47","Totalreflexion Wasser/Luft","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/videos-zur-totalreflexion/totalreflexion2/index.html","Optik","totalreflexion_wasser.m4v","");
INSERT INTO videos VALUES("48","Totalrerflexion: Laser im Wasserstrahl","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/videos-zur-totalreflexion/totalreflexion3/index.html","Optik","lichtleiter.m4v","");
INSERT INTO videos VALUES("49","Absorption","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/atomphysik/absorption/index.html","atomphysik","absorption.m4v","");
INSERT INTO videos VALUES("50","Beugung am Spalt","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/optik/videos-zur-beugung/beugung_doppelspalt/index.html","Optik","beugung_spalt.m4v","");
INSERT INTO videos VALUES("51","Konvektionsströmung","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/waermelehre/index.html","waermelehre","konvektionsstroemung.m4v","");
INSERT INTO videos VALUES("52","Volumenausdehnung bei Gasen","","","","waermelehre","volumenausdehnung_bei_gasen.m4v","");
INSERT INTO videos VALUES("53","Parallelschaltung von Widerständen","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/e-lehre/index.html","e_lehre","parallelschaltung.m4v","");
INSERT INTO videos VALUES("54","Reihenschaltung von Widerständen","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/e-lehre/index.html","e_lehre","reihenschaltung.m4v","");
INSERT INTO videos VALUES("55","Ohmsches Gesetz","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/e-lehre/index.html","e_lehre","ohmsches_Gesetz.m4v","");
INSERT INTO videos VALUES("56","Spannungsabfall","","","http://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/e-lehre/index.html","e_lehre","spannungsabfall.m4v","");
INSERT INTO videos VALUES("57","Konvektionsströmung","","","https://www.didaktik.physik.uni-muenchen.de/lehrerbildung/lehrerbildung_lmu/video/waermelehre/index.html","waermelehre","konvektionsstroemung.m4v","");
INSERT INTO videos VALUES("58","Das ohmsche Gesetz - Abweichung von der direkten Proportionalität","","","","e_lehre","abweichung_vom_ohmschen_gesetz.m4v","");
INSERT INTO videos VALUES("59","Das ohmsche Gesetz - Gekühlter Leiter","","","","e_lehre","gekühlter_draht.m4v","");
INSERT INTO videos VALUES("60","Elektrischer Leiter - Glühender Draht","","","","e_lehre","glühender_draht.m4v","");
INSERT INTO videos VALUES("61","Stromdurchflossener Leiter - Kennlinienen einer Glühbirne","","","","e_lehre","kennlinie_einer_glühbirne.m4v","");
INSERT INTO videos VALUES("62","Das Ohmsche Gesetz - Teil1: Kennlinien einer Drahtspule","","","","e_lehre","kennlinie_eines_leiters.m4v","");
INSERT INTO videos VALUES("63","Stromdurchflossener Leiter - Strom durch eine Glühlampe","","","","e_lehre","strom_durch_eine_glühlampe.m4v","");
INSERT INTO videos VALUES("64","Reflexionsgitter - Wellenlängenmessung mit dem Lineal","","","","Optik","beugung_reflexionsgitter_schieblehre.m4v","");
INSERT INTO videos VALUES("65","Regenbogen - Simulation am Wassertropfen","","","","Optik","brechung_regenbogensimulation_am_tropfen.m4v","");
INSERT INTO videos VALUES("66","Reflexionsgesetz - Reflexion am ebenen Spiegel","","","","Optik","spiegel2.m4v","");
INSERT INTO videos VALUES("67","Volumenänderung - Längenausdehnung bei Erwärmung","","","","waermelehre","laengenausdehnung.m4v","");
INSERT INTO videos VALUES("68","Volumenänderung - Ausdehnung einer Metallkugel beim Erhitzen","","","","waermelehre","metallkugel.m4v","");
INSERT INTO videos VALUES("69","Volumenänderung - Eichen eines Thermometers","","","","waermelehre","thermometer.m4v","");
INSERT INTO videos VALUES("70","Volumenausdehnung - Steigrohr mit Thermometer","","","","waermelehre","volumen_thermometer.m4v","");
INSERT INTO videos VALUES("71","Volumenänderung bei Flüssigkeiten - Steigrohr","","","","waermelehre","volumenaenderung_bei_flüssigkeiten.m4v","");
INSERT INTO videos VALUES("72","Volumenänderung - Erwärmen und Abkühlen von Gasen","","","","waermelehre","volumenausdehnung_bei_gasen.m4v","");



DROP TABLE videos_sessions;

CREATE TABLE `videos_sessions` (
  `sessionID` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO videos_sessions VALUES("");
INSERT INTO videos_sessions VALUES("587e246267c0a");
INSERT INTO videos_sessions VALUES("587e6eac3de14");
INSERT INTO videos_sessions VALUES("587f93229ed7b");
INSERT INTO videos_sessions VALUES("587ff601b57b4");
INSERT INTO videos_sessions VALUES("5885a32c66130");
INSERT INTO videos_sessions VALUES("5885a91ec4978");
INSERT INTO videos_sessions VALUES("5885cd1bc29c1");
INSERT INTO videos_sessions VALUES("58874a3bdd0bb");
INSERT INTO videos_sessions VALUES("5889b4e68e3c6");
INSERT INTO videos_sessions VALUES("5889f9226969e");
INSERT INTO videos_sessions VALUES("5890760e177b4");
INSERT INTO videos_sessions VALUES("5892f866e477a");
INSERT INTO videos_sessions VALUES("5893449d6e4ea");
INSERT INTO videos_sessions VALUES("58a08169482c1");
INSERT INTO videos_sessions VALUES("58a14fc8eaa1b");
INSERT INTO videos_sessions VALUES("58a1501070ef5");
INSERT INTO videos_sessions VALUES("58a8d80172c15");
INSERT INTO videos_sessions VALUES("58aa9483dc3f5");
INSERT INTO videos_sessions VALUES("58b4001155ca8");
INSERT INTO videos_sessions VALUES("58bb33c5ba91c");
INSERT INTO videos_sessions VALUES("58bfcd9880e31");
INSERT INTO videos_sessions VALUES("58c7ffd1c485f");
INSERT INTO videos_sessions VALUES("58c81ce781f0a");
INSERT INTO videos_sessions VALUES("58d0e20579e17");
INSERT INTO videos_sessions VALUES("58da0fa407aa5");
INSERT INTO videos_sessions VALUES("58da11de3cd99");
INSERT INTO videos_sessions VALUES("58da28b0b1515");



DROP TABLE videos_themen;

CREATE TABLE `videos_themen` (
  `themaID` int(11) NOT NULL AUTO_INCREMENT,
  `titel` tinytext NOT NULL,
  PRIMARY KEY (`themaID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO videos_themen VALUES("1","Optik");
INSERT INTO videos_themen VALUES("2","Mechanik");
INSERT INTO videos_themen VALUES("3","Wärmelehre");
INSERT INTO videos_themen VALUES("4","Atomphysik");
INSERT INTO videos_themen VALUES("5","Elektrizitätslehre");
INSERT INTO videos_themen VALUES("6","Schwingungen und Wellen");



DROP TABLE videos_themen_match;

CREATE TABLE `videos_themen_match` (
  `vID` int(11) NOT NULL,
  `themaID` int(11) NOT NULL,
  UNIQUE KEY `vID_themaID` (`vID`,`themaID`),
  KEY `themaID` (`themaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO videos_themen_match VALUES("24","1");
INSERT INTO videos_themen_match VALUES("31","1");
INSERT INTO videos_themen_match VALUES("32","1");
INSERT INTO videos_themen_match VALUES("33","1");
INSERT INTO videos_themen_match VALUES("34","1");
INSERT INTO videos_themen_match VALUES("35","1");
INSERT INTO videos_themen_match VALUES("36","1");
INSERT INTO videos_themen_match VALUES("37","1");
INSERT INTO videos_themen_match VALUES("38","1");
INSERT INTO videos_themen_match VALUES("39","1");
INSERT INTO videos_themen_match VALUES("40","1");
INSERT INTO videos_themen_match VALUES("41","1");
INSERT INTO videos_themen_match VALUES("42","1");
INSERT INTO videos_themen_match VALUES("43","1");
INSERT INTO videos_themen_match VALUES("44","1");
INSERT INTO videos_themen_match VALUES("45","1");
INSERT INTO videos_themen_match VALUES("46","1");
INSERT INTO videos_themen_match VALUES("47","1");
INSERT INTO videos_themen_match VALUES("48","1");
INSERT INTO videos_themen_match VALUES("64","1");
INSERT INTO videos_themen_match VALUES("65","1");
INSERT INTO videos_themen_match VALUES("66","1");
INSERT INTO videos_themen_match VALUES("51","3");
INSERT INTO videos_themen_match VALUES("52","3");
INSERT INTO videos_themen_match VALUES("57","3");
INSERT INTO videos_themen_match VALUES("67","3");
INSERT INTO videos_themen_match VALUES("68","3");
INSERT INTO videos_themen_match VALUES("69","3");
INSERT INTO videos_themen_match VALUES("70","3");
INSERT INTO videos_themen_match VALUES("71","3");
INSERT INTO videos_themen_match VALUES("72","3");
INSERT INTO videos_themen_match VALUES("49","4");
INSERT INTO videos_themen_match VALUES("50","4");
INSERT INTO videos_themen_match VALUES("53","5");
INSERT INTO videos_themen_match VALUES("54","5");
INSERT INTO videos_themen_match VALUES("55","5");
INSERT INTO videos_themen_match VALUES("56","5");
INSERT INTO videos_themen_match VALUES("58","5");
INSERT INTO videos_themen_match VALUES("59","5");
INSERT INTO videos_themen_match VALUES("60","5");
INSERT INTO videos_themen_match VALUES("61","5");
INSERT INTO videos_themen_match VALUES("62","5");
INSERT INTO videos_themen_match VALUES("63","5");



DROP TABLE z_klassenbesuch_buchung;

CREATE TABLE `z_klassenbesuch_buchung` (
  `BuchungsID` int(11) NOT NULL AUTO_INCREMENT,
  `TerminID` int(11) NOT NULL,
  `SchulNr` int(11) NOT NULL,
  `anzSchueler` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `vname` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `tel` tinytext NOT NULL,
  `parameter` text NOT NULL,
  `confirmed` int(11) NOT NULL,
  PRIMARY KEY (`BuchungsID`),
  KEY `TerminID` (`TerminID`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

INSERT INTO z_klassenbesuch_buchung VALUES("27","1","175","25","Mayer","Peter","peter.mayer@fit4exam.de","01753575666","{\"bem\":\"keine\",\"JgSt\":\"9\"}","0");
INSERT INTO z_klassenbesuch_buchung VALUES("28","1","175","25","M&uuml;ller","Max","peter.mayer@pemasoft.de","01753575666","{\"bem\":\"keine\",\"JgSt\":\"10\"}","0");
INSERT INTO z_klassenbesuch_buchung VALUES("29","1","175","25","M&uuml;ller","Max","peter.mayer@csu-rosenheim.de","01753575666","{\"bem\":\"terst 1234\",\"JgSt\":\"10\"}","0");



DROP TABLE z_klassenbesuche_termine;

CREATE TABLE `z_klassenbesuche_termine` (
  `TerminID` int(11) NOT NULL AUTO_INCREMENT,
  `start` datetime NOT NULL,
  `ende` datetime NOT NULL,
  `titel` tinytext NOT NULL,
  `parameter` text NOT NULL,
  `betreuer` text NOT NULL,
  `betreuer_mail` text NOT NULL,
  `aktiv` tinyint(4) NOT NULL DEFAULT '1',
  KEY `TerminID` (`TerminID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO z_klassenbesuche_termine VALUES("1","2017-06-27 09:00:00","2017-06-27 12:00:00","Radioaktivität","{\"maxTN\":25, \"Gym\":{\"JgSt\":[9,10]},\"RS\":{\"JgSt\":[9]}}","Herr Thoms","pe.mayer@lmu.de","1");
INSERT INTO z_klassenbesuche_termine VALUES("2","2017-06-27 09:00:00","2017-06-27 12:00:00","Bio Physik","{\"maxTN\":25, \"Gym\":{\"JgSt\":[9,10]},\"RS\":{\"JgSt\":[9]}}","Herr Thoms","pe.mayer@lmu.de","1");



