<?php 

    if($_SERVER["REQUEST_METHOD"] == 'POST'){
        $type = $_POST['message'];
    }
    else {
        header('Location: ../index.php');
    }

    try {
        //database connection from db.php file
        require_once "db.php";

        //get and return materials data
        if ($type == 'materials'){

            $query = "SELECT material_name, quantity_needed FROM materials";
    
            $stmt = $pdo->prepare($query);
            $stmt->execute();
    
            //get all rows of data returned from query as associative array 
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode($result);
        }
        //get and return missing persons data. Sorts it from least recent to recent. add "DESC" to the end to reverse the order
        else if ($type == 'persons'){
            $query = "SELECT fname, lname, date_last_seen FROM missing_persons ORDER BY date_last_seen";

            $stmt = $pdo->prepare($query);
            $stmt->execute();

            //get all rows of data returned from query as associative array 
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($result);
        }
        else {
            header('Location: ../index.php');
            die();
        }

        $pdo = null;
        $stmt = null;
    }
    catch(PDOException $e) {
        die("Query failed : " . $e->getMessage());
    }