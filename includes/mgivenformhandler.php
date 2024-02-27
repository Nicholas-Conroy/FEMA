<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // echo $_SERVER["SERVER_NAME"];
        $poutine = htmlspecialchars($_POST["poutine"]);
        $poutine_qty = htmlspecialchars($_POST["poutine-qty"]);

    }
    else {
        header(('Location: ../index.html'));
    }

    try{
        require_once "db.php";

        //don't insert data into db directly, less secure
        // $query = "INSERT into materials (material_name, quantity_needed) VALUES (:material_name, :quantity_needed)";
        $query = "UPDATE materials
        SET quantity_needed = quantity_needed - (:qty_added)
        WHERE material_name = (:material_name); 
        ";

        // prepared stmt
        $stmt = $pdo->prepare($query);
        
        $stmt->bindParam(":qty_added", $poutine_qty);
        $stmt->bindParam(":material_name", $poutine);

        $stmt->execute();

        $pdo = null;
        $stmt = null;

        // send user back to main page
        header(('Location: ../index.php'));

        die();
    }
    catch (PDOException $error){
        die($error->getMessage());
    }
