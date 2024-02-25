<?php 
    // $var = "testing";

    // header('Content-type: application-json');

    // echo json_encode($var);

    //something like this for security/access denying?

    // if(!defined('_BASEPAGE')){
    //     // die("Access Denied");
    //     echo json_encode("yo");
    // }

    // if($_SERVER["REQUEST_METHOD"] != "GET"){
    //     echo "null";
    // }

    try {
        //database connection from db.php file
        require_once "db.php";

        $query = "SELECT material_name, quantity_needed FROM materials";

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        //get all rows of data returned from query as associative array 
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);

        $pdo = null;
        $stmt = null;
    }
    catch(PDOException $e) {
        die("Query failed : " . $e->getMessage());
    }