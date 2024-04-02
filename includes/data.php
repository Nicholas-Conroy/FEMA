<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);

require_once "config_session.inc.php";

function get_materials_needed(){
    require "db.php";

    $query = "SELECT material_name, quantity_needed FROM materials";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    //get all rows of data returned from query as associative array 
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row) {
        echo "
            <tr>
                <td><p>" . $row['material_name'] . " Clothes</p></td>
                <td><p>" . $row['quantity_needed'] . "</p></td>
            </tr>
        ";

    }
}

//display missing persons in a table
function get_missing_persons() {
    require "db.php";

    $query = "SELECT fname, lname, date_last_seen FROM missing_persons ORDER BY date_last_seen";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    //get all rows of data returned from query as associative array 
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row) {
        if($_SESSION["user_username"] === "fema") {
            echo '
                <tr>
                    <td><p>' . $row["fname"] . '</p></td>
                    <td><p>' . $row["lname"] . '</p></td>
                    <td><p>' . $row["date_last_seen"] . '</p></td>               
                    <td> <input type="checkbox" class="found-chbox"><td>
                </tr>
            ';
        }
        else {
            echo '
                <tr>
                    <td><p>' . $row["fname"] . '</p></td>
                    <td><p>' . $row["lname"] . '</p></td>
                    <td><p>' . $row["date_last_seen"] . '</p></td>                   
                </tr>
            ';
        }

    }
    // echo json_encode($result);
}


function get_comm_center_data() {
    require "db.php";
    
    $query = "SELECT center_name, mens_clothes_qty, womens_clothes_qty, teens_clothes_qty, toddlers_clothes_qty 
    FROM comm_centers;";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    //get all rows of data returned from query as associative array 
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row) {
        echo '
            <tr>
                <td><p>' . $row["center_name"] . '</p></td>
                <td><p>' . $row["mens_clothes_qty"] . '</p></td>
                <td><p>' . $row["womens_clothes_qty"] . '</p></td>   
                <td><p>' . $row["teens_clothes_qty"] . '</p></td>   
                <td><p>' . $row["toddlers_clothes_qty"] . '</p></td>    
            </tr>
        ';
    }
}