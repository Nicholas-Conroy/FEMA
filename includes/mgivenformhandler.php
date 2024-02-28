<?php


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // echo $_SERVER["SERVER_NAME"];
        $poutine = htmlspecialchars($_POST["poutine"]);
        $poutine_qty = htmlspecialchars($_POST["poutine-qty"]);
        }
    else {
            header('location: ../index.php');
        }
            
    try {
        require_once "db.php";
        
        //*************************/
        //Ensure quantity values in DB are not reduced below zero
        //*************************/

        //get current quantity_needed from table
        //temp for just one time, expand later
        $query1 = "SELECT quantity_needed FROM materials where material_name = \"Poutine\"";
        $stmt1 = $pdo->prepare($query1);

        $stmt1->execute();

        $result = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        //if value trying to be "given" (and subtracted from total qty in db is negative, stop script and send user back to page)
        foreach($result as $row){
            $item_number = $row["quantity_needed"];
            if(intval($item_number) - intval($poutine_qty) < 0){
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

        //don't insert/update data into db directly, less secure
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

        echo "successful";

        //no need to use header to send back to index.php, reload happens through JS

        die();
    }
    catch (PDOException $error){
        die($error->getMessage());
    }
