<?php

   //***** DB Connection */
    //params necessary for connecting using PDO object
    $dsn = "mysql:host:=localhost;dbname=FEMA";
    $dbusername = "Test1";
    $dbpassword = "myDB#2023";


    try {
        $pdo = new PDO($dsn, $dbusername, $dbpassword); //connection to database
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //if we get an error, throw an exception
    } catch (PDOException $e) {
        echo "connection failed: " . $e->getMessage();
    }