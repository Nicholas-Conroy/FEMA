<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];


    try {  
        require_once "../db.php";
        require_once "login_model.inc.php";
        require_once "login_contr.inc.php";

        //**************/
        // ERROR HANDLERS
        //**************/
        $errors = [];

        if (is_input_empty($username, $pwd)) {
            $errors["empty_input"] = "Fill in all fields!"; //assoc array: arr[key] = "value";
        }
        
        $result = get_user($pdo, $username);
        
        //username can be wrong or password can be wrong
        if (is_username_wrong($result)) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }
        if (!is_username_wrong($result) && is_password_wrong($pwd, $result["pwd"])){
            $errors["login_incorrect"] = "Incorrect login info!";
        }
        //start safe session from config file
        //******* This should work but it doesn't for some reason */
        // require_once "config_session.inc.php"; 
        session_start();
        
        if($errors) { //returns true if array is not empty, stop script and return to index page
            $_SESSION['errors_signup'] = $errors;
             
            header("Location: ../../index.php");
            die();
        }

        //create new session id with user's id appended, so data can be associated with dif users depending on IDs
        $newSesssionId = session_create_id();
        $sessionId = $newSesssionId . "_" . $result["id"];
        session_id($sessionId); //set current session id to id just created

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);

        //reset session regeneration time as we just regenerated a new session id
        $_SESSION["last_regen"] = time();

        header("Location: ../../home.php");

        $pdo = null;
        $stmt = null;

        die();
        
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
else {
    header("Location: ../../index.php");
    die();
}