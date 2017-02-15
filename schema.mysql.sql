/*Table structure for table `client` */

DROP TABLE IF EXISTS `msg`;
CREATE TABLE `msg` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Yandex_login` VARCHAR(255) NOT NULL,
  `Date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Days_left` INT (3) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `users`; /*данные для авторизации */

CREATE TABLE `users` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE (`username`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `campaigns`;

CREATE TABLE `campaigns` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Yandex_login` VARCHAR(255) NOT NULL,
  `Campaign_name` VARCHAR(255) NOT NULL,
  `Id_campaign` INT(11) NOT NULL,
  `Date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  UNIQUE (`Id_campaign`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `client`;

CREATE TABLE `client` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Yandex_login` VARCHAR(255) NOT NULL,
  `Password` VARCHAR(255) NOT NULL,
  `Email_for_notifications` VARCHAR(255) NOT NULL,
  `Phone_for_notifications` VARCHAR(255) NOT NULL,
  `Company_name` VARCHAR(255) DEFAULT NULL,
  `Name_marketer` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE (`Yandex_login`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `marketer` */

DROP TABLE IF EXISTS `marketer`;

CREATE TABLE `marketer` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(255) NOT NULL,
  `Phone` VARCHAR(255) NOT NULL,
  `Email` VARCHAR(255) NOT NULL,
  `Photo` TEXT NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE (`Name`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `balance`;

CREATE TABLE `balance` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Id_campaign` INT(11) NOT NULL,
  `Balance` INT(11) NOT NULL,
  `Shared_balance` BOOLEAN NOT NULL,
  `Date_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  UNIQUE (`Id_campaign`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `api` */

DROP TABLE IF EXISTS `api`;

CREATE TABLE `api` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Id_campaign` INT(11) NOT NULL,
  `Date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Sum_search` DOUBLE(11,4) NOT NULL,
  `Sum_context` DOUBLE(11,4) NOT NULL,
  `Shows_search` INT(11) NOT NULL,
  `Shows_context` INT(11) NOT NULL,
  `Clicks_search` INT(11) NOT NULL,
  `Clicks_context` INT(11) NOT NULL,
   PRIMARY KEY (`Id`)
   /*CONSTRAINT `uc_api` UNIQUE (`Date`, `Id_campaign`)*/
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `client` */
/*
INSERT  INTO `client`(`Yandex_login`,`Password`,`Email_for_notifications`,`Phone_for_notifications`,`Company_name`,`Name_marketer`) VALUES
('sbx-mik-taPMezgC','sbx-mik-taPMezgC','sbx-mik-taPMezgC@yandex.ru','+43521','ОООПаньки','neOlga1'),
('sbx-mik-ta00cPyX','sbx-mik-ta00cPyX','sdfdW@mail.ru','+64235231','neОООПаньки','Olga'),
('sbx-mik-tavJRvS4','sbx-mik-tavJRvS4','qerqw@mail.ru','+098743521','','Olga1'),
('erertr','erertr','qerqw@mail.ru','+098743521','','Olga1'),
('ererw','ererw','qerqw@mail.ru','+098743521','','Olga1'),
('erter','erter','qeytutyrqw@mail.ru','+09874erter3521','','Olga1');

/*Data for the table `users` */
/*
INSERT  INTO `users`(`username`,`password`) VALUES ('sbx-mik-taPMezgC','Beaches@yandex.login');
INSERT  INTO `users`(`username`,`password`) VALUES ('admin','superaxora');
INSERT  INTO `users`(`username`,`password`) VALUES ('TGgdfFDS@yandex.login','TGgdfFDS@yandex.login');
INSERT  INTO `users`(`username`,`password`) VALUES ('werYeacrytryhes@yandex','werYeacrytryhes@yandex');
INSERT  INTO `users`(`username`,`password`) VALUES ('werYeacrytryhes@yandex.login','werYeacrytryhes@yandex.login');

/*Data for the table `campaigns` */
/*
INSERT  INTO `campaigns`(`Yandex_login`,`Id_campaign`) VALUES ('erter', '87654');
INSERT  INTO `campaigns`(`Yandex_login` ,`Id_campaign`) VALUES ('ererw', '347654');
INSERT  INTO `campaigns`(`Yandex_login`,`Id_campaign`) VALUES ('erertr', '3357654');
INSERT  INTO `campaigns`(`Yandex_login` ,`Id_campaign`) VALUES ('sbx-mik-taPMezgC', '511654');
INSERT  INTO `campaigns`(`Yandex_login` ,`Id_campaign`) VALUES ('sbx-mik-ta00cPyX', '8711654');
/*Data for the table `marketer` */
/*
INSERT  INTO `marketer`(`Name`,`Phone`,`Email`) VALUES ('Olga','+3678900','Olga@mail.ru');
INSERT  INTO `marketer`(`Name`,`Phone`,`Email`) VALUES ('Olga1','+37593228600','Retqew@mail.ru');
INSERT  INTO `marketer`(`Name`,`Phone`,`Email`) VALUES ('neOlga1','+37598600','Retqeлоорw@mail.ru');


/*Data for the table `balance` */
/*
INSERT  INTO `balance`(`Id_campaign`,`Campaign_name`,`Balance`,`Shared_balance`) VALUES (87654,'Beaches@yandex.login','87654',TRUE);
INSERT  INTO `balance`(`Id_campaign`,`Campaign_name`,`Balance`,`Shared_balance`) VALUES (347654,'TGgdfFDS@yandex.login','347654',FALSE);
INSERT  INTO `balance`(`Id_campaign`,`Campaign_name`,`Balance`,`Shared_balance`) VALUES (3357654,'werYeaches@yandex.login','3357654',TRUE);
INSERT  INTO `balance`(`Id_campaign`,`Campaign_name`,`Balance`,`Shared_balance`) VALUES (511654,'werYeacrytryhes@yandex.login','8711654',TRUE);
INSERT  INTO `balance`(`Id_campaign`,`Campaign_name`,`Balance`,`Shared_balance`) VALUES (8711654,'werYeacrytryhes@yandex.login','511654',TRUE);*/

/*Data for the table `api` */

INSERT  INTO `api`(`Id_campaign`,`Sum_search`,`Sum_context`,`Show_search`,`Show_context`,
`Clicks_search`,`Clicks_context`) VALUES
(87654, 1234.76 ,965.24 ,45, 10 ,15,2);

ALTER TABLE `client` ADD CONSTRAINT `client-marketer` FOREIGN KEY (`Name_marketer`) REFERENCES `marketer` (`Name`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `balance` ADD CONSTRAINT `balance-campaigns` FOREIGN KEY (`Id_campaign`) REFERENCES `campaigns` (`Id_campaign`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `api` ADD CONSTRAINT `api_campaigns` FOREIGN KEY (`Id_campaign`) REFERENCES `campaigns` (`Id_campaign`) ON DELETE CASCADE ON UPDATE CASCADE;
/*ALTER TABLE `users` ADD CONSTRAINT `client-user` FOREIGN KEY (`username`) REFERENCES `client` (`Yandex_login`) /*ON DELETE CASCADE ON UPDATE CASCADE;*/
ALTER TABLE `campaigns` ADD CONSTRAINT `client-campaigns` FOREIGN KEY (`Yandex_login`) REFERENCES `client` (`Yandex_login`) ON DELETE CASCADE ON UPDATE CASCADE;
