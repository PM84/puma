

ALTER TABLE `Sessions` (
  `uID` int(11) NOT NULL,
  `SessionID` text NOT NULL,
  `SessionStart` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `uGroupIDs` text NOT NULL,
  UNIQUE KEY `uID` (`uID`),
  CONSTRAINT `Sessions_ibfk_1` FOREIGN KEY (`uID`) REFERENCES `user` (`uID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






ALTER TABLE `abgabe` (
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






ALTER TABLE `ablauf_individuell` (
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






ALTER TABLE `ablauf_master` (
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






ALTER TABLE `ablauf_sync` (
  `kursID` int(11) NOT NULL,
  `fID` int(11) NOT NULL,
  `aktiv` int(11) NOT NULL DEFAULT '0' COMMENT '0: nicht angeheftet; 1: angeheftet',
  UNIQUE KEY `kursID` (`kursID`),
  KEY `fID` (`fID`),
  CONSTRAINT `ablauf_sync_ibfk_4` FOREIGN KEY (`kursID`) REFERENCES `kurs` (`kursID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ablauf_sync_ibfk_3` FOREIGN KEY (`fID`) REFERENCES `folien` (`fID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






ALTER TABLE `agb` (
  `agbID` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `valid_from` datetime NOT NULL COMMENT 'gültig ab',
  PRIMARY KEY (`agbID`),
  UNIQUE KEY `id` (`agbID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;






ALTER TABLE `agb_user_confirm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agbID` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  `datum` datetime NOT NULL COMMENT 'eingetragen am',
  `status` int(11) NOT NULL COMMENT '1: akzeptiert; 0:abgelehnt',
  PRIMARY KEY (`id`),
  UNIQUE KEY `agbID_uID` (`agbID`,`uID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;






ALTER TABLE `baustein_folie_position_match` (
  `fID` int(11) NOT NULL,
  `bID` int(11) NOT NULL,
  `blockID` varchar(25) NOT NULL,
  UNIQUE KEY `fID_blockID` (`fID`,`blockID`),
  KEY `bID` (`bID`),
  CONSTRAINT `baustein_folie_position_match_ibfk_1` FOREIGN KEY (`fID`) REFERENCES `folien` (`fID`),
  CONSTRAINT `baustein_folie_position_match_ibfk_2` FOREIGN KEY (`bID`) REFERENCES `bausteine` (`bID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






ALTER TABLE `bausteine` (
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






ALTER TABLE `bausteine_typen` (
  `bTypID` int(11) NOT NULL AUTO_INCREMENT,
  `titel` tinytext NOT NULL,
  `bs_dir` tinytext NOT NULL,
  `bs_add` tinytext NOT NULL,
  `bs_show` tinytext NOT NULL,
  `aktiv` tinyint(4) NOT NULL DEFAULT '1',
  `show` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`bTypID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;






ALTER TABLE `folien` (
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






ALTER TABLE `fragen` (
  `FrageID` int(11) NOT NULL AUTO_INCREMENT,
  `SkalaTyp` int(11) NOT NULL DEFAULT '1' COMMENT '1: kontinuierlich; 2:Lickert; 3: input Feld',
  `uID` int(11) NOT NULL,
  `parameter` text NOT NULL,
  PRIMARY KEY (`FrageID`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;






ALTER TABLE `fragen_groups` (
  `FGroupID` int(11) NOT NULL AUTO_INCREMENT,
  `uID` int(11) NOT NULL,
  `parameter` text NOT NULL,
  PRIMARY KEY (`FGroupID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;






ALTER TABLE `fragen_groups_fragen_match` (
  `FrageID` int(11) NOT NULL,
  `FGroupID` int(11) NOT NULL,
  UNIQUE KEY `FrageID_FGroupID` (`FrageID`,`FGroupID`),
  KEY `FGroupID` (`FGroupID`),
  CONSTRAINT `fragen_groups_fragen_match_ibfk_3` FOREIGN KEY (`FrageID`) REFERENCES `fragen` (`FrageID`) ON DELETE CASCADE,
  CONSTRAINT `fragen_groups_fragen_match_ibfk_4` FOREIGN KEY (`FGroupID`) REFERENCES `fragen_groups` (`FGroupID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






ALTER TABLE `kurs` (
  `kursID` int(11) NOT NULL AUTO_INCREMENT,
  `titel` tinytext NOT NULL,
  `beschreibung` text NOT NULL,
  `kTyp` int(11) NOT NULL COMMENT '1:Einzelaufgaben 2: Präsentation',
  `kursToken` tinytext NOT NULL,
  PRIMARY KEY (`kursID`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;






ALTER TABLE `kurs_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kursID` int(11) NOT NULL,
  `share_group` int(11) NOT NULL COMMENT '1: für alle Kollegen gleicher Schule; 2:für alle 3: per Email',
  `SchulNr` int(11) NOT NULL,
  `share_to_mail` text NOT NULL,
  `uID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kursID` (`kursID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;






ALTER TABLE `kurs_uID_match` (
  `kursID` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  UNIQUE KEY `uID_kursID` (`uID`,`kursID`),
  KEY `kursID` (`kursID`),
  CONSTRAINT `kurs_uID_match_ibfk_3` FOREIGN KEY (`kursID`) REFERENCES `kurs` (`kursID`) ON DELETE CASCADE,
  CONSTRAINT `kurs_uID_match_ibfk_4` FOREIGN KEY (`uID`) REFERENCES `user` (`uID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






ALTER TABLE `media` (
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






ALTER TABLE `media_kurs_match` (
  `mediaID` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  `fID` int(11) NOT NULL,
  `kursID` int(11) NOT NULL,
  UNIQUE KEY `mediaID_uID_fID_kursID` (`mediaID`,`uID`,`fID`,`kursID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






ALTER TABLE `module` (
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






ALTER TABLE `schule_bundesland` (
  `Bundesland` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`Bundesland`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;






ALTER TABLE `schule_daten` (
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






ALTER TABLE `studie_buchung` (
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






ALTER TABLE `studie_termine` (
  `TerminID` int(11) NOT NULL AUTO_INCREMENT,
  `start` datetime NOT NULL,
  `ende` datetime NOT NULL,
  `aktiv` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0: Termin ausblenden',
  PRIMARY KEY (`TerminID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;






ALTER TABLE `user` (
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






ALTER TABLE `user_groups` (
  `uGroupID` int(11) NOT NULL AUTO_INCREMENT,
  `titel` tinytext NOT NULL,
  PRIMARY KEY (`uGroupID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;






ALTER TABLE `user_teilnehmer` (
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






ALTER TABLE `user_teilnehmer_kurs_match` (
  `kursID` int(11) NOT NULL,
  `tnID` int(11) NOT NULL,
  `dozent` int(11) NOT NULL DEFAULT '0' COMMENT '0:nein 1:ja',
  UNIQUE KEY `kursID_tnID` (`kursID`,`tnID`),
  KEY `tnID` (`tnID`),
  CONSTRAINT `user_teilnehmer_kurs_match_ibfk_1` FOREIGN KEY (`kursID`) REFERENCES `kurs` (`kursID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






ALTER TABLE `user_uID_groups_match` (
  `uID` int(11) NOT NULL,
  `uGroupID` int(11) NOT NULL,
  UNIQUE KEY `uGroupID_uID` (`uGroupID`,`uID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






ALTER TABLE `v_simulationen` (
  `simID` int(11) NOT NULL AUTO_INCREMENT,
  `titel` tinytext NOT NULL,
  `url` text NOT NULL,
  `beschreibung` text NOT NULL,
  `poster` text NOT NULL,
  PRIMARY KEY (`simID`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;






ALTER TABLE `v_simulationen_themen_match` (
  `simID` int(11) NOT NULL,
  `themaID` int(11) NOT NULL,
  UNIQUE KEY `simID_themaID` (`simID`,`themaID`),
  KEY `themaID` (`themaID`),
  CONSTRAINT `v_simulationen_themen_match_ibfk_1` FOREIGN KEY (`simID`) REFERENCES `v_simulationen` (`simID`),
  CONSTRAINT `v_simulationen_themen_match_ibfk_2` FOREIGN KEY (`themaID`) REFERENCES `videos_themen` (`themaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






ALTER TABLE `videos` (
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






ALTER TABLE `videos_sessions` (
  `sessionID` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






ALTER TABLE `videos_themen` (
  `themaID` int(11) NOT NULL AUTO_INCREMENT,
  `titel` tinytext NOT NULL,
  PRIMARY KEY (`themaID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;






ALTER TABLE `videos_themen_match` (
  `vID` int(11) NOT NULL,
  `themaID` int(11) NOT NULL,
  UNIQUE KEY `vID_themaID` (`vID`,`themaID`),
  KEY `themaID` (`themaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






ALTER TABLE `z_klassenbesuch_buchung` (
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






ALTER TABLE `z_klassenbesuche_termine` (
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




