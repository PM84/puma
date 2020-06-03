INSERT INTO `module` (`mod_dir`, `mod_show`, `mod_titel`, `show`, `aktiv`)VALUES ('module/mod_preasentation', 'show_praesentation.php', 'Präsentationsfolien', '1', '1');

CREATE TABLE `ablauf_master` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `KursID` int NOT NULL,
  `fID` int(11) NOT NULL,
  `OrderID` int NOT NULL,
  `parameter` text NOT NULL COMMENT 'Einstellungen zur jeweiligen Folie',
  FOREIGN KEY (`fID`) REFERENCES `folien` (`fID`)
);


CREATE TABLE `ablauf_individuell` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `kursID` int(11) NOT NULL,
  `fID` int(11) NOT NULL,
  `token` int(11) NOT NULL,
  `OrderID` int NOT NULL,
  `parameter` text NOT NULL COMMENT 'Einstellungen zur jeweiligen Folie',
  FOREIGN KEY (`kursID`) REFERENCES `kurs` (`kursID`),
  FOREIGN KEY (`fID`) REFERENCES `folien` (`fID`),
  FOREIGN KEY (`token`) REFERENCES `user_teilnehmer` (`tnID`)
);