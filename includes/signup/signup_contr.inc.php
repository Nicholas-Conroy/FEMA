<?php
//MVC pattern/structure: controller is for taking in input and sending it to model

declare(strict_types=1);

//ensure data was actually entered
function is_input_empty(string $username, string $pwd, string $email) {
    if (empty($username) || empty($pwd) || empty($email)) {
        return true;
    }
    else {
        return false;
    }
}

//validate email
function is_email_invalid(string $email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    else {
        return false;
    }
}

//check if username already exists in db
function is_username_taken(object $pdo, string $username) {
    //uses function in signup_model file
    if (get_username($pdo, $username)) {
        return true;
    }
    else {
        return false;
    }
}

//check if email already exists in db
function is_email_registered(object $pdo, string $email) {
    //uses function in signup_model file
    if (get_email($pdo, $email)) {
        return true;
    }
    else {
        return false;
    }
}

function create_user(object $pdo, string $pwd, string $username, string $email){
    set_user($pdo, $pwd, $username, $email);
}