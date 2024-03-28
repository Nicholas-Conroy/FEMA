<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Takes raw data from the request
    $json = file_get_contents('php://input');

    // Converts it into a PHP object
    $personData = json_decode($json, true);

    $fname = $personData["personFields"]["fname"];
    $lname = $personData["personFields"]["lname"];
    $date_seen = $personData["personFields"]["date_seen"];

    echo $fname . $lname . $date_seen;
}
else {
    header('location: ../home.php');
}
try {
    require_once "db.php";

    //remove person who has now been "found" from db"
    $query = "DELETE from missing_persons where fname = :fname AND lname = :lname AND date_last_seen = :date_seen";
    $stmt = $pdo->prepare($query);
    
    $stmt->bindParam(":fname", $fname);
    $stmt->bindParam(":lname", $lname);
    $stmt->bindParam(":date_seen", $date_seen);
    
    $stmt->execute();
    
    $stmt = null;
    $pdo = null;
    
    header('Location: ../home.php');      
        
}
catch(PDOException $error) {
    die($error->getMessage());
}

