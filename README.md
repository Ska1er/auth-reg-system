# auth-reg-system
Simple system of authorization and registration with a profile of user in PHP

The MySql dbms with the auth_system database is used to store users.
There is only one table in the database - user. The table contains the following fields: name, surname, patronymic, sex, characters, speciality, login, password, id.

Script to create the table:

CREATE TABLE `user` (
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `patronymic` varchar(30) NOT NULL,
  `sex` char(1) NOT NULL,
  `characters` varchar(250) NOT NULL,
  `speciality` varchar(60) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_login_unique` (`login`)
)

