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
        echo '
            <tr>
                <td><p>' . $row['material_name'] . ' Clothes</p></td>
                <td class="fema-materials-qty"><p>' . $row['quantity_needed'] . '</p></td>
            </tr>
        ';

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
                    <td><input type="checkbox" class="found-chbox"></td>
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
}

//populate community center materials table
function get_comm_center_data() {
    require "db.php";
    
    // $query = "SELECT center_name, mens_clothes_qty, womens_clothes_qty, teens_clothes_qty, toddlers_clothes_qty 
    // FROM comm_centers;";
    
    
    $query1 = "SELECT center_name FROM comm_centers GROUP BY center_id;";
    
    $stmt1 = $pdo->prepare($query1);
    $stmt1->execute();
    
    //get all rows of data returned from query as associative array 
    $names = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($names as $name){
        
        $query2 = "SELECT material_name, quantity FROM comm_centers WHERE center_name = :center_name";
        
        $stmt2 = $pdo->prepare($query2);
        $stmt2->bindParam(":center_name", $name["center_name"]);
        $stmt2->execute();
        
        $results = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
        $center_materials = [];

        foreach ($results as $row) {
           array_push($center_materials, $row["quantity"]);
        }

        echo '
            <tr>
                <td><p>' . $name["center_name"] . '</p></td>
                <td><p>' . $center_materials[0] . '</p></td>
                <td><p>' . $center_materials[1] . '</p></td>
                <td><p>' . $center_materials[2] . '</p></td>
                <td><p>' . $center_materials[3] . '</p></td>
            </tr>
        ';
    }
}

//get names of community center and output them as options for user to select
function get_comm_center_names() {
    require "db.php";
    
    //use group by to only have each name return once
    $query = "SELECT center_id, center_name FROM comm_centers GROUP BY center_id;";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    //get all rows of data returned from query as associative array 
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<option selected disabled>Choose Community Center</option>';

    foreach ($results as $row) {
        echo '
            <option value="' . $row["center_id"] . '">' . $row["center_name"] . '</option>
        ';
    }
}

//populate volunteers needed table
function get_volunteers_info() {
    require "db.php";

    $query = "SELECT position_name, quantity_needed FROM volunteers ORDER BY position_name";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    //get all rows of data returned from query as associative array 
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($results as $row) {
        echo '
            <tr>
                <td><p>' . $row["position_name"] . '</p></td>
                <td><p>' . $row["quantity_needed"] . '</p></td>
            </tr>
        ';
    }
}

//get names of volunteers and output table rows with position names and a input for adding quantity needed
function get_volunteers_names(){
    require "db.php";

    $query = "SELECT position_name FROM volunteers ORDER BY position_name";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    //get all rows of data returned from query as associative array 
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($results as $row) { 
        echo '
            <tr>
                <td>
                    <label for="rq-volunteers-' . strtolower($row["position_name"]) .'"> '. $row["position_name"] . '</label>
                    <input type="checkbox" name="rq-volunteers-' . strtolower($row["position_name"]) .'" 
                    id="rq-volunteers-' . strtolower($row["position_name"]) .'" class="chkbox" value="'. $row["position_name"] .'">
                </td>
                <td>
                    <label for="rq-volunteers-'. strtolower($row["position_name"]) .'-qty">Quantity</label>
                    <input type="number" class="quantity-input" min="0" name="rq-volunteers-'. strtolower($row["position_name"]) .'-qty" 
                    id="rq-volunteers-'. strtolower($row["position_name"]) .'-qty">
                </td>
            </tr>
        ';
    }
}

//return option list of all volunteer names
function get_volunteers_list(){
    require "db.php";

    $query = "SELECT position_id, position_name FROM volunteers ORDER BY position_name";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    //get all rows of data returned from query as associative array 
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //option to "explain" list to user, disabled
    echo '<option selected disabled>Choose Position &#x25BC;</option>';

    foreach ($results as $row) {
        echo '
            <option value="' . $row["position_id"] . '">' . $row["position_name"] . '</option>
        ';
    }
}