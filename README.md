# auth-reg-system
Simple system of authorization and registration with a profile of user in PHP

The MySql dbms with the auth_system database is used to store users.
There is only one table in the database - user. The table contains the following fields: name, surname, patronymic, sex, characters, speciality, login, password, id.

Script to create the table:

CREATE TABLE user (<br />
  name varchar(30) NOT NULL,<br />
  surname varchar(30) NOT NULL,<br />
  patronymic varchar(30) NOT NULL,<br />
  sex char(1) NOT NULL,<br />
  characters varchar(250) NOT NULL,<br />
  speciality varchar(60) NOT NULL,<br />
  login varchar(50) NOT NULL,<br />
  password varchar(60) NOT NULL,<br />
  id int NOT NULL AUTO_INCREMENT,<br />
  PRIMARY KEY (id),<br />
  UNIQUE KEY user_login_unique (login)<br />
)

