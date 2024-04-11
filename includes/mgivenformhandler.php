<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // echo $_SERVER["SERVER_NAME"];
        $materials = $_POST;
        $center_name = $_POST["cc-names"];
    }
    else {
            header('location: ../');
    }
            
    try {
        require_once "db.php";

        //*** not actually doing anything yet */
        // if(!isset($center_name)) {
        //     echo "no center chosen";
        //     header(('Location: ../home.php'));
        //     die();
        // }
        
        //remove first item from materials array, which is community center ID (only want material info in this array)
        array_shift($materials);

        //will contain only non-empty values, excluding things like quantity = ""
        $valid_materials = [];

        //add non-empty fields to valid_materials
        foreach($materials as $label => $value){
            //excludes empty quantity values (empty checkboxes are not sent as POST data)
            if(!(substr($label, -3) == "qty" && $value == "")){
                // echo $label . ": " . $value . "\n";
                array_push($valid_materials, htmlspecialchars($value));
            }
        }

        //***********************/
        // Check potential resulting values after using DB values
        //***********************/

        //valid materials array has pattern of [material name, qty, material name, qty, ...]
        for($x=0; $x<sizeof($valid_materials); $x += 2){
            $cur_material_name = $valid_materials[$x];
            $cur_qty = $valid_materials[$x+1];

            //*************************/
            // Ensure quantity values in ccenter table are not reduced below zero
            //*************************/
            $query1 = "SELECT quantity FROM comm_centers where material_name = :material_name AND center_id = :center_id";
            $stmt1 = $pdo->prepare($query1);
            $stmt1->bindParam(":material_name", $cur_material_name);
            $stmt1->bindParam(":center_id", $center_name);

    
            $stmt1->execute();
    
            $results = $stmt1->fetchAll(PDO::FETCH_ASSOC);
            
            //if qty value, when subtracted from total qty in db, is negative, stop script and send user back to page
            foreach($results as $row){
                $item_number = $row["quantity"];
                if(intval($item_number) - intval($cur_qty) < 0){
                    echo "not_enough_resources";
                    // header(('Location: ../'));
                    die();
                }
            }
            //*************************/
            // Ensure quantity values in FEMA materials table are not reduced below zero
            //*************************/
    
            //get current quantity_needed from table
            $query2 = "SELECT quantity_needed FROM materials where material_name = :material_name";
            $stmt2 = $pdo->prepare($query2);
            $stmt2->bindParam(":material_name", $cur_material_name);
    
            $stmt2->execute();
    
            $result = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
            //if qty value, when subtracted from total qty in db, is negative, stop script and send user back to page
            foreach($result as $row){
                $item_number = $row["quantity_needed"];
                if(intval($item_number) - intval($cur_qty) < 0){
                    // $msg = "message";
                    echo "invalid";
                    // header(('Location: ../'));
                    die();
                }
            }

            //***********************/
            // Update values in FEMA materials table
            //***********************/
    
            $query3 = "UPDATE materials
            SET quantity_needed = quantity_needed - (:qty_added)
            WHERE material_name = (:material_name); 
            ";
    
            // prepared stmt
            $stmt3 = $pdo->prepare($query3);
            
            $stmt3->bindParam(":material_name", $cur_material_name);
            $stmt3->bindParam(":qty_added", $cur_qty);
    
            $stmt3->execute();
    
            
            
            //***********************/
            // Remove items from ccenter table
            //***********************/
            
            $query4 = "UPDATE comm_centers
            SET quantity = quantity - (:quantity)
            WHERE material_name = :material_name AND center_id = :center_id";
    
            // prepared stmt
            $stmt4 = $pdo->prepare($query4);
            
            $stmt4->bindParam(":material_name", $cur_material_name);
            $stmt4->bindParam(":quantity", $cur_qty);
            $stmt4->bindParam(":center_id", $center_name);
    
            $stmt4->execute();

            
            $stmt1 = null;
            $stmt2 = null;
            $stmt3 = null;
            $stmt4 = null;
        }
        
        $pdo = null;

        echo "successful";

        //no need to use header to send back to , reload happens through JS

        die();
    }
    catch (PDOException $error){
        die($error->getMessage());
    }
