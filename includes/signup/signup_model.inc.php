<?php
//MVC pattern/structure: model is for database queries

declare(strict_types=1);

//get and return username if it exists in db, returns empty string (false) otherwise
 function get_username(object $pdo, string $username) { //pass pdo object as arg for connection to database
    $query = "SELECT username FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC); //easier to use assoc array with col names than just indexed array
    return $result;
}

//get and return email if it exists in db, returns empty string (false) otherwise
function get_email(object $pdo, string $email) { //pass pdo object as arg for connection to database
    $query = "SELECT email FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC); //easier to use assoc array with col names than just indexed array
    return $result;
}

function set_user(object $pdo, string $pwd, string $username, string $email){
    $query = "INSERT INTO users (username, pwd, email) VALUES 
    (:username, :pwd, :email)";
    $stmt = $pdo->prepare($query);

    //hash password for security

    $options = [
        'cost' => 12 //costs more to run this hash, prevents brute forcing to an extent
    ];

    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options); //BCRYPT is a hashing algo

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":email", $email);

    $stmt->execute();

}