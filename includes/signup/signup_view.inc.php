<?php
//MVC pattern/structure: view is for presentation and interaction

declare(strict_types=1);
error_reporting(E_ALL); 
ini_set('display_errors', 1);

function signup_inputs() {
    //check if username data was submitted and no username taken error exists
    //if so, display input with username data still in place (otherwise, display blank input)
    if (isset($_SESSION["signup_data"]["username"]) && 
    !isset($_SESSION["errors_signup"]["username_taken"])) {
        echo '<input type="text" name="username" placeholder="Username"
        value="' . $_SESSION["signup_data"]["username"] . '">';
    }
    else {
        echo '<input type="text" name="username" placeholder="Username">';
    }

    //always return empty password input for security
    echo '<input type="password" name="pwd" placeholder="Password">';

    //check if email data was submitted and no email used and no invalid email error error exists
    //if so, display input with email data still in place (otherwise, display blank input)
    if (isset($_SESSION["signup_data"]["email"]) && 
    !isset($_SESSION["errors_signup"]["email_used"]) && 
    !isset($_SESSION["errors_signup"]["invalid_email"])) {
        echo '<input type="text" name="email" placeholder="Email" 
        value="' . $_SESSION["signup_data"]["email"] . '">';
    }
    else {
        echo '<input type="text" name="email" placeholder="Email">';
    }
}
function check_signup_errors() {
    if(isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION["errors_signup"];

        echo " <br> ";
        
        foreach ($errors as $error) {
            echo "<p>" . $error . "</p>";
        }

        // echo var_dump($_SESSION['errors_signup']);

        //session variable no longer needed, good safety practice to remove it
        unset($_SESSION["errors_signup"]);
    }
    //if url has get method with signup key equal to success, display success message
    else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo "<br>";
        echo "<p>Signup success</p>";
    }

    if (isset($_GET["signup"]) && $_GET["signup"] === "fail") {
        echo "<br>";
        echo "<p>Signup FAIL</p>";
    }
}