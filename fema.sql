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

 CREATE comm_centers 
 (`ID` INT NOT NULL AUTO_INCREMENT , 
 `center_name` VARCHAR(255) NOT NULL , 
 `mens_clothes_qty` INT NOT NULL , 
 `womens_clothes_qty` INT NOT NULL ,
 `teens_clothes_qty` INT NOT NULL ,
 `toddlers_clothes_qty` INT NOT NULL , 
 PRIMARY KEY (`ID`));