<?php


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // echo $_SERVER["SERVER_NAME"];
        $materials = $_POST;
        }
    else {
            header('location: ../index.php');
        }
            
    try {
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

        
        //update DB with new values
        //valid materials array has pattern of [material name, qty, material name, qty, ...]
        for($x=0; $x<sizeof($valid_materials); $x += 2){
            $cur_material_name = $valid_materials[$x];
            $cur_qty = $valid_materials[$x+1];

            //*************************/
            //Ensure quantity values in DB are not reduced below zero
            //*************************/
    
            //get current quantity_needed from table
            $query1 = "SELECT quantity_needed FROM materials where material_name = :material_name";
            $stmt1 = $pdo->prepare($query1);
            $stmt1->bindParam(":material_name", $cur_material_name);
    
            $stmt1->execute();
    
            $result = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    
            //if qty value, when subtracted from total qty in db, is negative, stop script and send user back to page
            foreach($result as $row){
                $item_number = $row["quantity_needed"];
                if(intval($item_number) - intval($cur_qty) < 0){
                    // echo "less!";
                    // $msg = "message";
                    echo "invalid";
                    // header(('Location: ../index.php'));
                    die();
                }
            }

            //***********************/
            // Update values in DB
            //***********************/
    
            $query2 = "UPDATE materials
            SET quantity_needed = quantity_needed - (:qty_added)
            WHERE material_name = (:material_name); 
            ";
    
            // prepared stmt
            $stmt2 = $pdo->prepare($query2);
            
            $stmt2->bindParam(":material_name", $cur_material_name);
            $stmt2->bindParam(":qty_added", $cur_qty);
    
            $stmt2->execute();
    
            $stmt1 = null;
            $stmt2 = null;
            
            
        }
        
        $pdo = null;

        echo "successful";

        //no need to use header to send back to index.php, reload happens through JS

        die();
    }
    catch (PDOException $error){
        die($error->getMessage());
    }
