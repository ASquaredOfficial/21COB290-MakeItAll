/*sql code*/

use teamb004;

CREATE TABLE `test`.`users` ( `email` VARCHAR(320) NOT NULL , `password` VARCHAR(100) NOT NULL , `first_name` VARCHAR(40) NOT NULL , `last_name` VARCHAR(40) NOT NULL , `role` ENUM('Employee','Specialist','External','Admin') NOT NULL , PRIMARY KEY (`email`)) ENGINE = InnoDB; 

CREATE TABLE `test`.`specialist_info` ( `email` VARCHAR(320) NOT NULL , `types` TEXT NULL DEFAULT NULL, `available` TINYINT(1) DEFAULT 1) ENGINE = InnoDB; 
ALTER TABLE `specialist_info` ADD CONSTRAINT `specialist_info_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users`(`email`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE `test`.`problem_type` ( `id` INT NOT NULL AUTO_INCREMENT , `name` INT(255) NOT NULL , `parent_type` INT NULL DEFAULT NULL , PRIMARY KEY (`id`), UNIQUE (`name`)) ENGINE = InnoDB;

CREATE TABLE `test`.`external_info` ( `email` INT NOT NULL , `types` JSON NOT NULL , `expire` DATE NOT NULL , PRIMARY KEY (`email`)) ENGINE = InnoDB; 

CREATE TABLE `test`.`employees` ( `email` VARCHAR(320) NOT NULL , `department` VARCHAR(255) NOT NULL , `phone_number` VARCHAR(15) NOT NULL , `job_title` VARCHAR(255) NOT NULL , PRIMARY KEY (`email`)) ENGINE = InnoDB; 

CREATE TABLE `test`.`software` ( `id` INT NOT NULL , `name` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB; 

CREATE TABLE `test`.`hardware` ( `id` INT NOT NULL , `name` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `test`.`log` ( `id` INT NOT NULL AUTO_INCREMENT , `employee_email` VARCHAR(320) NOT NULL ,  `specialist_email` VARCHAR(320) NOT NULL , `description` TEXT NOT NULL , `type` VARCHAR(255) NOT NULL , `hardware_id` INT NOT NULL , `software_id` INT NOT NULL , `created_on` DATETIME NOT NULL , `os` VARCHAR(255) NOT NULL , `notes` JSON NULL DEFAULT NULL , `archive` JSON NULL DEFAULT NULL , `Solved_on` DATETIME NOT NULL , `status` ENUM('Open','Pending','Solved','') NOT NULL DEFAULT 'Open' , `priority` enum('LOW','MEDIUM','HIGH','-') NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `test`.`faqs` ( `faq_id` INT NOT NULL , `faq_question` VARCHAR(480) NOT NULL , `faq_answer` VARCHAR(960) NOT NULL , `problem_type` INT NOT NULL , PRIMARY KEY (`faq_id`)) ENGINE = InnoDB;

CREATE TABLE `test`.`resetUrl` ( `employee_email` VARCHAR(320) NOT NULL , `reset_url` VARCHAR(255) NOT NULL , `expire` DATETIME NOT NULL , PRIMARY KEY (`employee_email`)) ENGINE = InnoDB;
