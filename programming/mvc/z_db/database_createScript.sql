DROP DATABASE IF EXISTS MVC;

CREATE DATABASE IF NOT EXISTS MVC;

USE MVC;

CREATE TABLE contacts (
	ID INT	NOT NULL AUTO_INCREMENT,
	name VARCHAR(128) NOT NULL,
	phone VARCHAR(64),
	email VARCHAR(255),
	location VARCHAR(255),

	PRIMARY KEY (ID)
);

INSERT INTO `contacts` (`name`,`phone`,`email`,`location`)
VALUES ("Nehru","09 91 55 73 94","Phasellus.dolor@nunc.edu","Netherlands"),

("Nasim","08 98 38 81 92","Duis@Maecenas.com","Namibia"),
("Mufutau","03 44 88 09 86","tellus.eu.augue@in.net","South Georgia and The South Sandwich Islands"),
("Norman","08 79 72 57 73","Nunc.ullamcorper.velit@ProinvelitSed.com","Taiwan"),
("Oliver","09 35 81 97 07","Donec@nec.net","Chile"),
("Callum","06 15 23 88 99","lorem.eget@semperegestas.co.uk","Cook Islands"),
("Eagan","08 85 54 85 93","eget@nisinibh.org","Burkina Faso"),
("Lane","01 56 97 54 86","sed.libero@dictumauguemalesuada.ca","China"),
("Eric","09 41 26 29 35","lacus.varius@at.org","Kenya"),
("Amir","01 48 31 01 31","ac.facilisis@metus.net","Finland");


CREATE user 'MVC'
