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