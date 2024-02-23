<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // echo $_SERVER["SERVER_NAME"];
        $poutine = htmlspecialchars($_POST["poutine"]);
        $poutine_qty = htmlspecialchars($_POST["poutine-qty"]);

        // echo gettype($poutine_qty);
    }
    else {
        header(('Location: ../index.html'));
    }

    try{
        require_once "db.php";

        //don't insert data into db directly, less secure
        $query = "INSERT into materials (material_name, quantity_needed) VALUES (:material_name, :quantity_needed)";

        // prepared stmt
        $stmt = $pdo->prepare($query);
        
        $stmt->bindParam(":material_name", $poutine);
        $stmt->bindParam(":quantity_needed", $poutine_qty);

        $stmt->execute();

        $pdo = null;
        $stmt = null;

        // send user back to main page
        header(('Location: ../index.html'));

        die();
    }
    catch (PDOException $error){
        die($error->getMessage());
    }
