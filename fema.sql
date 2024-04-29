-- create database
CREATE DATABASE FEMA;

-- create table materials
CREATE table materials 
(`material_id` INT NOT NULL AUTO_INCREMENT ,
 `material_name` VARCHAR(30) NOT NULL , 
 `quantity_needed` INT NOT NULL , 
 PRIMARY KEY (`material_id`));

-- create table missing_persons
CREATE table missing_persons 
(`ID` INT NOT NULL AUTO_INCREMENT ,
 `fname` VARCHAR(30) NOT NULL , 
 `lname` VARCHAR(30) NOT NULL , 
 `date_last_seen` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP , 
 PRIMARY KEY (`ID`));

 -- create table users
 CREATE table users 
(`ID` INT NOT NULL AUTO_INCREMENT ,
 `username` VARCHAR(30) NOT NULL , 
 `pwd` VARCHAR(255) NOT NULL , 
 `email` VARCHAR(100) NOT NULL,
 `created_at` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP , 
 PRIMARY KEY (`ID`));

-- **fix/update this**
 CREATE TABLE comm_centers 
 (`center_id` INT NOT NULL AUTO_INCREMENT , 
 `center_name` VARCHAR(255) NOT NULL , 
 `material_id` INT NOT NULL , 
 `material_name` VARCHAR(30) NOT NULL ,
 `quantity` INT NOT NULL , 
 PRIMARY KEY (`center_id`, `material_id`)),
 CONSTRAINT `FK_materialID` FOREIGN KEY (`material_id`)
 REFERENCES materials(`material_id`)
 ;

 -- create table volunteers -- 
 CREATE TABLE volunteers 
 (`position_id` INT NOT NULL AUTO_INCREMENT , 
 `position_name` VARCHAR(255) NOT NULL , 
 `quantity_needed` INT NOT NULL , 
 PRIMARY KEY (`position_id`));