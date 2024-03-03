<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // echo $_SERVER["SERVER_NAME"];
        // $mens = htmlspecialchars($_POST["mens"]);
        // $mens_qty = htmlspecialchars($_POST["mens-qty"]);
        // $womens = htmlspecialchars($_POST["womens"]);
        // $womens_qty = htmlspecialchars($_POST["womens-qty"]);
        // $teens = htmlspecialchars($_POST["teens"]);
        // $teens_qty = htmlspecialchars($_POST["teens-qty"]);
        // $toddlers = htmlspecialchars($_POST["toddlers"]);
        // $toddlers_qty = htmlspecialchars($_POST["toddlers-qty"]);
        $materials = $_POST;


    }
    else {
        header(('Location: ../index.html'));
    }

    try{
        require_once "db.php";

        //list of materials that will be updated as necessary to remove blank fields
        $valid_materials = [];

        //remove blank fields, such as quantity = ""
        foreach($materials as $label => $value){
            if(!(substr($label, -3) == "qty" && $value == "")){
                // echo $label . ": " . $value . "\n";
                // unset($valid_materials[$label]);
                array_push($valid_materials, $value);
            }
        }

        // echo var_dump($valid_materials);
        
        for($x=0; $x<sizeof($valid_materials); $x += 2){
            //update DB
            $query = "UPDATE materials
            SET quantity_needed = (:qty_added) + quantity_needed
            WHERE material_name = (:material_name); 
            ";
            // // prepared stmt
            $stmt = $pdo->prepare($query);
            
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
