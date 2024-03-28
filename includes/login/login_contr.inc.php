<?php

declare(strict_types=1);

function is_input_empty(string $username, string $pwd) {
    if (empty($username) || empty($pwd)) {
        return true;
    }
    else {
        return false;
    }
}

//if data is returned from db query, then there must have been a match for the usernames
function is_username_wrong(bool|array $result){ //$result can be a bool if empty and an array if data is found in db
    if(!$result) {
        return true; //username is wrong
    }
    else {
        return false; //username is not wrong
    }
}

function is_password_wrong(string $pwd, string $hashedPwd){ //$result can be a bool if empty and an array if data is found in db
    if(!password_verify($pwd, $hashedPwd)) {
        return true; //password is wrong
    }
    else {
        return false; //password is not wrong
    }
}