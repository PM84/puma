ALTER TABLE `Sessions` ADD `test` tinytext COLLATE 'utf8_general_ci' NOT NULL;
ALTER TABLE `Sessions` CHANGE `test` text COLLATE 'utf8_general_ci' NOT NULL;

/*ALTER TABLE `Sessions` DROP `test`;*/