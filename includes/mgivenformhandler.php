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

        //ensure value is not reduced below zero
        //get current quantity_needed from table
        // $query1 = "SELECT quantity_needed FROM materials where material_name = (:material_name)";
        $query1 = "SELECT quantity_needed FROM materials where material_name = \"Poutine\"";
        $stmt1 = $pdo->prepare($query1);
        // $stmt1->bindParam(":material_name", $poutine);

        $stmt1->execute();

        $result = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        //if value trying to be "given" (and subtracted from total qty in db is negative, stop script and send user back to page)
        foreach($result as $row){
            $item_number = $row["quantity_needed"];
            echo $item_number;
            if(intval($item_number) - intval($poutine_qty) < 0){
                // echo "less!";
                // $msg = "message";
                $msg = array('name' => 'Nic');
                header('Content-Type: application/json');
                echo json_encode($msg);
                header(('Location: ../index.php'));
                die();
            }
        }

        //don't insert data into db directly, less secure
        // $query = "INSERT into materials (material_name, quantity_needed) VALUES (:material_name, :quantity_needed)";
        $query2 = "UPDATE materials
        SET quantity_needed = quantity_needed - (:qty_added)
        WHERE material_name = (:material_name); 
        ";

        // prepared stmt
        $stmt2 = $pdo->prepare($query2);
        
        $stmt2->bindParam(":qty_added", $poutine_qty);
        $stmt2->bindParam(":material_name", $poutine);

        $stmt2->execute();

        $pdo = null;
        $stmt2 = null;

        // send user back to main page
        $msg2 = array('name' => 'Bob');

        header('Content-Type: application/json');
        echo json_encode($msg2);
        header(('Location: ../index.php'));

        die();
    }
    catch (PDOException $error){
        die($error->getMessage());
    }
