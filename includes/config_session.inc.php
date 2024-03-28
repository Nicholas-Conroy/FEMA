<?php

// *********************
// secure session setup
// *********************

//ensures any session id can only be passed through cookies, and not through ways like the url of the site
//(other sites could have a link to maliciously send session IDs through url)
ini_set('session.use_only_cookies', 1);

//ensures site only uses session ID only created through server in site
//also makes session ID more secure/complex
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 1800, //after 30 mins, cookie is destroyed (good to do after a certain time to avoid cookie being stolen)
    'domain' => 'localhost', //cookie will only work in localhost domain
    'path' => '/', //cookie will work in all paths in domain
    'secure' => true, //only https
    'httponly' => true //restricts script access from client
]);

session_start(); //start session

//regenerate session ID every 30 mins, but if user is logged in, regenerate it with user's id appended to it, for associating data with user
if (isset($_SESSION["user_id"])) {
    if (!isset($_SESSION["last_regen"])) {
        regenerate_session_id_loggedin();    
    }
    else {
        $interval = 60 * 30; //30 mins
        if(time() - $_SESSION["last_regen"] >= $interval) { //current time since last regen is bigger than set interval
            regenerate_session_id_loggedin();
        }
    }
}
else {
    if (!isset($_SESSION["last_regen"])) {
        regenerate_session_id();    
    }
    else {
        $interval = 60 * 30; //30 mins
        if(time() - $_SESSION["last_regen"] >= $interval) { //current time since last regen is bigger than set interval
            regenerate_session_id();
        }
    }
}

function regenerate_session_id() {
    session_regenerate_id(true); //regenerate session ID (and more securely)
    $_SESSION["last_regen"] = time(); //sets last regen session variable to current time
}

function regenerate_session_id_loggedin() {
    session_regenerate_id(true); //regenerate session ID (and more securely)
    
     //create new session id with user's id appended, so data can be associated with dif users depending on IDs
     $userId = $_SESSION["user_id"];
     $newSesssionId = session_create_id();
     $sessionId = $newSesssionId . "_" . $userId;
     session_id($sessionId); //set current session id to id just created

    $_SESSION["last_regen"] = time(); //sets last regen session variable to current time
}