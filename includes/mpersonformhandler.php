<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // echo $_SERVER["SERVER_NAME"];

        $fname = htmlspecialchars($_POST['fname']);
        $lname = htmlspecialchars($_POST['lname']); 
        $date_seen = htmlspecialchars($_POST['date-seen']);

    }
    else {
            header('location: ../index.php');
    }

    try {
        require_once "db.php";

            // echo "$fname, $lname, " . gettype($date_seen);
    
            $query = "INSERT INTO missing_persons (fname, lname, date_last_seen) VALUES (:fname, :lname, :date_seen)";
            $stmt = $pdo->prepare($query);
    
            $stmt->bindParam(":fname", $fname);
            $stmt->bindParam(":lname", $lname);
            $stmt->bindParam(":date_seen", $date_seen);
    
            $stmt->execute();
    
            $stmt = null;
            $pdo = null;
    
            header('Location: ../index.php');
    }
    catch(PDOException $error) {
        die($error->getMessage());
    }
