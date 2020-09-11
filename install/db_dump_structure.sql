DROP TABLE IF EXISTS `bausteine`;
DROP TABLE IF EXISTS `agb_user_confirm`;
DROP TABLE IF EXISTS `ablauf_sync`;
DROP TABLE IF EXISTS `agb`;
DROP TABLE IF EXISTS `ablauf_master`;
DROP TABLE IF EXISTS `ablauf_individuell`;
DROP TABLE IF EXISTS `abgabe`;
DROP TABLE IF EXISTS `bausteine_typen`;
DROP TABLE IF EXISTS `baustein_folie_position_match`;
DROP TABLE IF EXISTS `folien`;
DROP TABLE IF EXISTS `fragen`;
DROP TABLE IF EXISTS `fragen_groups`;
DROP TABLE IF EXISTS `fragen_groups_fragen_match`;
DROP TABLE IF EXISTS `kurs`;
DROP TABLE IF EXISTS `kurs_share`;
DROP TABLE IF EXISTS `media_kurs_match`;
DROP TABLE IF EXISTS `schule_daten`;
DROP TABLE IF EXISTS `Newsletter`;
DROP TABLE IF EXISTS `module`;
DROP TABLE IF EXISTS `schule_bundesland`;
DROP TABLE IF EXISTS `Sessions`;
DROP TABLE IF EXISTS `v_simulationen_themen_match`;
DROP TABLE IF EXISTS `videos_themen`;
DROP TABLE IF EXISTS `z_klassenbesuch_buchung`;
DROP TABLE IF EXISTS `videos_themen_match`;
DROP TABLE IF EXISTS `v_simulationen`;
DROP TABLE IF EXISTS `z_klassenbesuche_termine`;
DROP TABLE IF EXISTS `user_teilnehmer`;
DROP TABLE IF EXISTS `videos`;
DROP TABLE IF EXISTS `videos_sessions`;
DROP TABLE IF EXISTS `user_teilnehmer_kurs_match`;
DROP TABLE IF EXISTS `user_uID_groups_match`;
DROP TABLE IF EXISTS `studie_termine`;
DROP TABLE IF EXISTS `studie_buchung`;
DROP TABLE IF EXISTS `user_groups`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `kurs_uID_match`;
DROP TABLE IF EXISTS `media`;
SET SESSION sql_mode = '';
CREATE TABLE `kurs` (
  `kursID` int(11) NOT NULL AUTO_INCREMENT,
  `titel` tinytext NOT NULL,
  `beschreibung` text NOT NULL,
  `kTyp` int(11) NOT NULL COMMENT '1:Einzelaufgaben 2: Präsentation',
  `kursToken` tinytext NOT NULL,
  PRIMARY KEY (`kursID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `user` (
  `uID` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `vname` tinytext NOT NULL,
  `geschlecht` tinytext NOT NULL COMMENT 'm oder w',
  `email` tinytext NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `resetToken` text NOT NULL,
  `bundesland` int(11) NOT NULL DEFAULT '1',
  `SchulNr` int(11) NOT NULL,
  `registered` datetime NOT NULL,
  `lastEdit` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `registerToken` tinytext NOT NULL,
  PRIMARY KEY (`uID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `folien` (
  `fID` int(11) NOT NULL AUTO_INCREMENT,
  `uID` int(11) NOT NULL COMMENT 'uID des Erstellers',
  `kursID` int(11) NOT NULL COMMENT 'zugeordneter Kurs',
  `modID` int(11) NOT NULL,
  `aTyp` int(11) NOT NULL DEFAULT '1' COMMENT '1: Aufgabe; 2:Korrektur; 3:Feedback',
  `zu_fID` int(11) NOT NULL DEFAULT '0' COMMENT 'zugeordnete fID',
  `viewTyp` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:alle; 2:Auswahl 3: alle bis auf',
  `parameter` text NOT NULL COMMENT 'aktivStatus:0:deaktiviert; 1:immer anzeigen; 2: anzeigen nach Reihenfolge; 3: keine Anzeige nach Bearbeitung; 4:inaktiv; 5: aktiv nach Freigabe',
  `cp_fID` int(11) NOT NULL,
  `tnArr` text NOT NULL,
  `ftoken` tinytext NOT NULL,
  PRIMARY KEY (`fID`),
  KEY `uID` (`uID`),
  KEY `kursID` (`kursID`),
  KEY `modID` (`modID`),
  CONSTRAINT `folien_ibfk_1` FOREIGN KEY (`uID`) REFERENCES `user` (`uID`) ON DELETE CASCADE,
  CONSTRAINT `folien_ibfk_2` FOREIGN KEY (`kursID`) REFERENCES `kurs` (`kursID`) ON DELETE CASCADE,
  CONSTRAINT `folien_ibfk_3` FOREIGN KEY (`modID`) REFERENCES `module` (`modID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `abgabe` (
  `abID` int(11) NOT NULL AUTO_INCREMENT,
  `fID` int(11) NOT NULL,
  `abTyp` int(11) NOT NULL COMMENT '1:Videovertonung; 2:Videovertonung Bewertung; 3:...',
  `token` varchar(25) NOT NULL COMMENT 'TN Token, der die Abgabe gemacht hat',
  `zu_abID` varchar(25) NOT NULL COMMENT 'bei Korrektur: zugehöriger Token der ursprünglichen Abgabe',
  `parameter` text NOT NULL,
  `datum` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`abID`),
  UNIQUE KEY `fID_token_zu_token` (`fID`,`token`,`zu_abID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `ablauf_sync` (
  `kursID` int(11) NOT NULL,
  `fID` int(11) NOT NULL,
  `aktiv` int(11) NOT NULL DEFAULT '0' COMMENT '0: nicht angeheftet; 1: angeheftet',
  UNIQUE KEY `kursID` (`kursID`),
  KEY `fID` (`fID`),
  CONSTRAINT `ablauf_sync_ibfk_4` FOREIGN KEY (`fID`) REFERENCES `folien` (`fID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ablauf_sync_ibfk_5` FOREIGN KEY (`kursID`) REFERENCES `kurs` (`kursID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `agb` (
  `agbID` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `valid_from` datetime NOT NULL COMMENT 'gültig ab',
  PRIMARY KEY (`agbID`),
  UNIQUE KEY `id` (`agbID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `agb_user_confirm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agbID` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  `datum` datetime NOT NULL COMMENT 'eingetragen am',
  `status` int(11) NOT NULL COMMENT '1: akzeptiert; 0:abgelehnt',
  PRIMARY KEY (`id`),
  UNIQUE KEY `agbID_uID` (`agbID`,`uID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `bausteine_typen` (
  `bTypID` int(11) NOT NULL AUTO_INCREMENT,
  `titel` tinytext NOT NULL,
  `bs_dir` tinytext NOT NULL,
  `bs_add` tinytext NOT NULL,
  `bs_show` tinytext NOT NULL,
  `aktiv` tinyint(4) NOT NULL DEFAULT '1',
  `show` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`bTypID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `baustein_folie_position_match` (
  `fID` int(11) NOT NULL,
  `bID` int(11) NOT NULL,
  `blockID` varchar(25) NOT NULL,
  UNIQUE KEY `fID_blockID` (`fID`,`blockID`),
  KEY `bID` (`bID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `fragen` (
  `FrageID` int(11) NOT NULL AUTO_INCREMENT,
  `SkalaTyp` int(11) NOT NULL DEFAULT '1' COMMENT '1: kontinuierlich; 2:Lickert',
  `uID` int(11) NOT NULL,
  `parameter` text NOT NULL,
  PRIMARY KEY (`FrageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `fragen_groups` (
  `FGroupID` int(11) NOT NULL AUTO_INCREMENT,
  `uID` int(11) NOT NULL,
  `parameter` text NOT NULL,
  PRIMARY KEY (`FGroupID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `fragen_groups_fragen_match` (
  `FrageID` int(11) NOT NULL,
  `FGroupID` int(11) NOT NULL,
  UNIQUE KEY `FrageID_FGroupID` (`FrageID`,`FGroupID`),
  KEY `FGroupID` (`FGroupID`),
  CONSTRAINT `fragen_groups_fragen_match_ibfk_3` FOREIGN KEY (`FrageID`) REFERENCES `fragen` (`FrageID`) ON DELETE CASCADE,
  CONSTRAINT `fragen_groups_fragen_match_ibfk_4` FOREIGN KEY (`FGroupID`) REFERENCES `fragen_groups` (`FGroupID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `kurs_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kursID` int(11) NOT NULL,
  `share_group` int(11) NOT NULL,
  `SchulNr` int(11) NOT NULL,
  `share_to_mail` text NOT NULL,
  `uID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kursID` (`kursID`),
  CONSTRAINT `kurs_share_ibfk_1` FOREIGN KEY (`kursID`) REFERENCES `kurs` (`kursID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `kurs_uID_match` (
  `kursID` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  UNIQUE KEY `uID_kursID` (`uID`,`kursID`),
  KEY `kursID` (`kursID`),
  CONSTRAINT `kurs_uID_match_ibfk_3` FOREIGN KEY (`kursID`) REFERENCES `kurs` (`kursID`) ON DELETE CASCADE,
  CONSTRAINT `kurs_uID_match_ibfk_4` FOREIGN KEY (`uID`) REFERENCES `user` (`uID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `media` (
  `mediaID` int(11) NOT NULL AUTO_INCREMENT,
  `uID` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `dateiname` tinytext,
  `titel` tinytext,
  `inserted` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleteDate` datetime DEFAULT NULL,
  `cp_mediaID` datetime DEFAULT NULL,
  PRIMARY KEY (`mediaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `media_kurs_match` (
  `mediaID` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  `fID` int(11) NOT NULL,
  `kursID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `Newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(255) NOT NULL,
  `SchulNr` int(11) NOT NULL,
  `Geschlecht` int(11) NOT NULL,
  `Titel` tinytext NOT NULL,
  `vName` tinytext NOT NULL,
  `nName` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `response` tinyint(4) NOT NULL,
  `response_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `schule_bundesland` (
  `Bundesland` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`Bundesland`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
CREATE TABLE `Sessions` (
  `uID` int(11) NOT NULL,
  `SessionID` text NOT NULL,
  `SessionStart` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `uGroupIDs` text NOT NULL,
  UNIQUE KEY `uID` (`uID`),
  CONSTRAINT `Sessions_ibfk_1` FOREIGN KEY (`uID`) REFERENCES `user` (`uID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `studie_termine` (
  `TerminID` int(11) NOT NULL AUTO_INCREMENT,
  `start` datetime NOT NULL,
  `ende` datetime NOT NULL,
  `aktiv` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0: Termin ausblenden',
  PRIMARY KEY (`TerminID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `user_groups` (
  `uGroupID` int(11) NOT NULL AUTO_INCREMENT,
  `titel` tinytext NOT NULL,
  PRIMARY KEY (`uGroupID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `user_teilnehmer` (
  `tnID` int(11) NOT NULL AUTO_INCREMENT,
  `geschlecht` varchar(1) NOT NULL COMMENT 'm:Mann; w:Frau',
  `name` tinytext NOT NULL,
  `vname` tinytext NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `uID` int(11) NOT NULL COMMENT 'uID des Workshopinhabers',
  `preview_account` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1: wird automatisch für Kurseigentümer erstellt falls er nicht existiert',
  `token` varchar(25) NOT NULL,
  `aktualisiert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tnID`),
  KEY `uID` (`uID`),
  KEY `tnID` (`tnID`),
  KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `user_teilnehmer_kurs_match` (
  `kursID` int(11) NOT NULL,
  `tnID` int(11) NOT NULL,
  `dozent` int(11) NOT NULL DEFAULT '0' COMMENT '0: nein; 1:ja',
  UNIQUE KEY `kursID_tnID` (`kursID`,`tnID`),
  KEY `tnID` (`tnID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `user_uID_groups_match` (
  `uID` int(11) NOT NULL,
  `uGroupID` int(11) NOT NULL,
  UNIQUE KEY `uGroupID_uID` (`uGroupID`,`uID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `videos_sessions` (
  `sessionID` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `videos_themen` (
  `themaID` int(11) NOT NULL AUTO_INCREMENT,
  `titel` tinytext NOT NULL,
  PRIMARY KEY (`themaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `videos_themen_match` (
  `vID` int(11) NOT NULL,
  `themaID` int(11) NOT NULL,
  UNIQUE KEY `vID_themaID` (`vID`,`themaID`),
  KEY `themaID` (`themaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `v_simulationen` (
  `simID` int(11) NOT NULL AUTO_INCREMENT,
  `titel` tinytext NOT NULL,
  `url` text NOT NULL,
  `beschreibung` text NOT NULL,
  `poster` text NOT NULL,
  PRIMARY KEY (`simID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `v_simulationen_themen_match` (
  `simID` int(11) NOT NULL,
  `themaID` int(11) NOT NULL,
  UNIQUE KEY `simID_themaID` (`simID`,`themaID`),
  KEY `themaID` (`themaID`),
  CONSTRAINT `v_simulationen_themen_match_ibfk_1` FOREIGN KEY (`simID`) REFERENCES `v_simulationen` (`simID`),
  CONSTRAINT `v_simulationen_themen_match_ibfk_2` FOREIGN KEY (`themaID`) REFERENCES `videos_themen` (`themaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `z_klassenbesuche_termine` (
  `TerminID` int(11) NOT NULL AUTO_INCREMENT,
  `termin_token` varchar(25) NOT NULL,
  `start` datetime NOT NULL,
  `ende` datetime NOT NULL,
  `titel` tinytext NOT NULL,
  `parameter` text NOT NULL,
  `betreuer` text NOT NULL,
  `betreuer_mail` text NOT NULL,
  `aktiv` tinyint(4) NOT NULL DEFAULT '1',
  KEY `TerminID` (`TerminID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;