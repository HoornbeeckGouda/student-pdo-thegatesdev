SET @today = curdate();
SET @result_1 = date_add(@today, INTERVAL -10 day);
SET @result_2 = date_add(@today, INTERVAL -5 day);

DROP DATABASE IF EXISTS student;

CREATE DATABASE student;

USE student; 

DROP TABLE IF EXISTS student;
CREATE TABLE student (
  id int(11) NOT NULL AUTO_INCREMENT,
  voornaam varchar(15) NOT NULL,
  tussenvoegsel varchar(10) DEFAULT NULL,
  achternaam varchar(25) NOT NULL,
  straat varchar(35) NOT NULL,
  postcode varchar(6) NOT NULL,
  woonplaats varchar(50) NOT NULL,
  email varchar(50) NOT NULL,
  klas varchar(10) NOT NULL,
  geboortedatum date NULL,
  createdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  changedate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ;
DROP TABLE IF EXISTS resultaat;
CREATE TABLE resultaat (
  id int(11) NOT NULL AUTO_INCREMENT,
  student_id int(11) NOT NULL,
  vak_id int(11) NOT NULL,
  resultaat DECIMAL(2,1) DEFAULT NULL,
  datum datetime NOT NULL,
  createdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  changedate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ;
DROP TABLE IF EXISTS vak;
CREATE TABLE vak (
  id int(11) NOT NULL AUTO_INCREMENT,
  afkorting varchar(45) NOT NULL,
  naam varchar(45) NOT NULL,
  createdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  changedate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ;
INSERT INTO student
(voornaam, tussenvoegsel, achternaam, straat, postcode, woonplaats, email, klas, geboortedatum)
values
('Dylan', NULL, 'Huiser', 'Middenweg 11', '1088VV', 'Amsterdam', 'dhuisden@roc.nl', 'T4I2AD', '2002-01-01'),
('Nitin', NULL, 'Bosman', 'Leidseweg 22', '9900BB', 'Amsterdam', 'nbosman@roc.nl', 'T4I2AD', '2002-03-31'),
('Joseph', NULL, 'Demirel', 'Leidseplein 33', '9988BB', 'Utrecht', 'Josdem@hotmail.com', 'T4I2AD', '2002-07-03'),
('Franco', 'van der', 'Gouwe', 'Kruislaan 444', '3300VV', 'Utrecht', 'frantas@wanadoo.nl', 'T4I2BD', '2000-07-15'),
('Akash', NULL, 'Kabli', 'Galileiplanstoen 333', '2299NN', 'Amstelveen', 'aka@hetnet.nl', 'T4I2BD', '2002-10-15'),
('Tamara', 'ter', 'Schuur', 'Mozartstraat 22', '3388XX', 'Amsterdam', 'tamka@hotmail.com', 'T4I2AD', '2002-10-30'),
('Arnold', NULL, 'Shaw', 'Kruislaan 1', '9876FF', 'Rotterdam', 'asha@roc.nl', 'T4I2AD', '2001-10-06');
INSERT INTO vak
(afkorting, naam)
values
(1, 'PGB', 'Programmeren Backend'),
(2, 'DAB', 'Databases'),
(3, 'PRO', 'Project'),
(4, 'BUR', 'Burgerschap'),
(5, 'WDM', 'Webdesign'),
(6, 'GBO', 'Gebruikersondersteuning');
INSERT INTO resultaat
(student_id, vak_id, resultaat, datum)
VALUES
-- student 1
(1, 1, '4.5', @result_1),
(1, 1, '6.2', @result_2),
(1, 2, '8.5', @result_1),
(1, 3, '6.5', @result_1),
(1, 4, '8.3', @result_1),
-- student 2
(2, 1, '6.5', @result_1),
(2, 1, '4.2', @result_2),
(2, 2, '6.5', @result_1),
(2, 3, '6.5', @result_1),
(2, 4, '6.4', @result_1),
-- student 3
(3, 1, '5.4', @result_1),
(3, 1, '6.3', @result_2),
(3, 2, '7.3', @result_1),
(3, 3, '5.6', @result_1),
(3, 4, '7.2', @result_1),
-- student 4 (BD)
(4, 3, '6.5', @result_1),
(4, 4, '8.3', @result_1),
(4, 6, '9.3', @result_1),
-- student 5 (BD)
(5, 3, '4.5', @result_1),
(5, 4, '3.3', @result_1),
(5, 6, '6.3', @result_2),
-- student 6
(6, 1, '5.5', @result_1),
(6, 1, '6.6', @result_2),
(6, 2, '7.7', @result_1),
(6, 3, '7.6', @result_1),
(6, 4, '6.7', @result_1);
