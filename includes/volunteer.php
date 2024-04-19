<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //set materials variable equal to POST assoc array (containing form data)
        $vol_position_id = $_POST["volunteer-list"];
        echo $vol_position_id;
    }
    else {
        header(('Location: ../home.php'));
    }

    try{
        require_once "db.php";

        $query = "UPDATE volunteers
            SET quantity_needed = quantity_needed - 1
            WHERE position_id = (:pos_id)";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":pos_id", $vol_position_id);
        $stmt->execute();

        $stmt = null;
        $pdo = null;

        echo "successful";
        // // send user back to main page
        header(('Location: ../home.php'));

        die();
    }
    catch (PDOException $error){
        die($error->getMessage());
    }
