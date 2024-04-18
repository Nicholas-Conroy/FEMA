<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //set materials variable equal to POST assoc array (containing form data)
        $volunteers = $_POST;
    }
    else {
        header(('Location: ../home.php'));
    }

    try{
        require_once "db.php";

        //will contain only non-empty values, excluding things like quantity = ""
        $valid_volunteers = [];

        //add non-empty fields to valid_volunteers
        foreach($volunteers as $label => $value){
            //excludes empty quantity values (empty checkboxes are not sent as POST data)
            if(!(substr($label, -3) == "qty" && $value == "")){
                // echo $label . ": " . $value . "\n";
                array_push($valid_volunteers, htmlspecialchars($value));
            }
        }

        // echo var_dump($valid_volunteers);
        
        //update DB with new values
        for($x=0; $x<sizeof($valid_volunteers); $x += 2){
            //update DB
            $query = "UPDATE volunteers
            SET quantity_needed = (:qty_added) + quantity_needed
            WHERE position_name = (:position_name); 
            ";
            // prepared stmt
            $stmt = $pdo->prepare($query);
            
            //
            $stmt->bindParam(":position_name", $valid_volunteers[$x]);
            $stmt->bindParam(":qty_added", $valid_volunteers[$x+1]);
    
            $stmt->execute();
    
            $stmt = null;
        }
        
        
        $pdo = null;

        echo "successful";
        // // send user back to main page
        // header(('Location: ../home.php'));

        die();
    }
    catch (PDOException $error){
        die($error->getMessage());
    }
