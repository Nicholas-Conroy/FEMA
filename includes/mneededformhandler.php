<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //set materials variable equal to POST assoc array (containing form data)
        $materials = $_POST;
    }
    else {
        header(('Location: ../index.html'));
    }

    try{
        require_once "db.php";

        //will contain only non-empty values, excluding things like quanitity = ""
        $valid_materials = [];

        //add non-empty fields to valid_materials
        foreach($materials as $label => $value){
            //excludes empty quantity values (empty checkboxes are not sent as POST data)
            if(!(substr($label, -3) == "qty" && $value == "")){
                // echo $label . ": " . $value . "\n";
                array_push($valid_materials, htmlspecialchars($value));
            }
        }

        // echo var_dump($valid_materials);
        
        //update DB with new values
        for($x=0; $x<sizeof($valid_materials); $x += 2){
            //update DB
            $query = "UPDATE materials
            SET quantity_needed = (:qty_added) + quantity_needed
            WHERE material_name = (:material_name); 
            ";
            // prepared stmt
            $stmt = $pdo->prepare($query);
            
            //
            $stmt->bindParam(":material_name", $valid_materials[$x]);
            $stmt->bindParam(":qty_added", $valid_materials[$x+1]);
    
            $stmt->execute();
    
            $stmt = null;
        }
        //     echo "\n" . $valid_materials[$x];
            
        
        //don't insert data into db directly, less secure
        // $query = "INSERT into materials (material_name, quantity_needed) VALUES (:material_name, :quantity_needed)";
        
        
        $pdo = null;

        echo "successful";
        // // send user back to main page
        // header(('Location: ../index.php'));

        die();
    }
    catch (PDOException $error){
        die($error->getMessage());
    }
