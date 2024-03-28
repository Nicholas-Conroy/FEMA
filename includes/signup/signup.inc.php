<?php 

error_reporting(E_ALL); 
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];
    //better to sanitize data using htmlspecialchars once we actually output something (?)
    
    try {
        require_once "../db.php";
        require_once "signup_model.inc.php";
        require_once "signup_contr.inc.php";

        //**************/
        // ERROR HANDLERS
        //**************/
        $errors = [];

        if (is_input_empty($username, $pwd, $email)) {
            $errors["empty_input"] = "Fill in all fields!"; //assoc array: arr[key] = "value";
        }
        if (is_email_invalid($email)) {
            $errors["invalid_email"] = "Invalid email used!"; //assoc array: arr[key] = "value";
        }
        if (is_username_taken($pdo, $username)) {
            $errors["username_taken"] = "Username already taken!"; //assoc array: arr[key] = "value";
        }
        if (is_email_registered($pdo, $username)) {
            echo "hi4";
            $errors["email_used"] = "Email already registered!"; //assoc array: arr[key] = "value";
        }

        //start safe session from config file
        //******* This should work but it doesn't for some reason */
        // require_once "config_session.inc.php"; 
        session_start();
        
        if($errors) { //returns true if array is not empty, stop script and return to index page
            $_SESSION['errors_signup'] = $errors;

            //save data entered by user, so they do not have to retype info on each attempt
            $signupData = [
                "username" => $username,
                "email" => $email
            ];
            $_SESSION["signup_data"] = $signupData;

            header("Location: ../../index.php?signup=fail");
            die();
        }

        //no errors, then create user
        create_user($pdo, $pwd, $username, $email);

        //return to index page with success message
        header('Location: ../../index.php?signup=success');

        $pdo = null;
        $stmt = null;
        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

}
else {
    header('Location: ../../index.php');
    die();
}