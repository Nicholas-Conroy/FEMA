<?php

    //TODO: when community center name isn't chosen, it breaks (currently using JS solution)
    //

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //set materials variable equal to POST assoc array (containing form data)
        $materials = $_POST;
        $center_name = $_POST["cc-names"];
    }
    else {
        header(('Location: ../home.php'));
    }

    try{
        require_once "db.php";

        //*** not actually doing anything yet */
        if(!isset($center_name)) {
            echo "no center chosen";
            header(('Location: ../home.php'));
            die();
        }

        array_shift($materials);

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

        // echo "center name:" . $center_name . "<br>  " . var_dump($valid_materials);

        
        //update DB with new values
        for($x=0; $x<sizeof($valid_materials); $x += 2){
            echo $valid_materials[$x];
            echo $valid_materials[$x+1];

            //update DB
            $query = "UPDATE comm_centers
            SET quantity = (:qty_added) + quantity
            WHERE material_name = (:material_name) AND center_id = (:center_id); 
            ";
            // prepared stmt
            $stmt = $pdo->prepare($query);
            
            $stmt->bindParam(":material_name", $valid_materials[$x]);
            $stmt->bindParam(":qty_added", $valid_materials[$x+1]);
            $stmt->bindParam(":center_id", $center_name);
    
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
