<?php
    require_once "includes/config_session.inc.php";
    require_once "includes/signup/signup_view.inc.php";
    // require_once "includes/signup_contr.inc.php";
    require_once "includes/login/login_view.inc.php";

?>
<!-- TODO: can remove login page display stuff -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>
        <?php
            output_username();
        ?>  
    </h3>

    <!-- display login form if user is not logged in -->
    <?php
        if(!isset($_SESSION["user_id"])) { ?>
            <h3>Login</h3>
        
            <form action="includes/login/login.inc.php" method="post">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="pwd" placeholder="Password">
                <button>Login</button>
            </form>
        
     <?php } ?>
    

    <?php
        check_login_errors();
    ?>

    <h3>Signup</h3>

    <form action="includes/signup/signup.inc.php" method="post">
        <!-- <input type="text" name="username" placeholder="Username">
        <input type="password" name="pwd" placeholder="Password">
        <input type="text" name="email" placeholder="Email"> -->
        <?php
            signup_inputs();
        ?>
        <button>Signup</button>
    </form>

    <?php
    check_signup_errors();
    ?>

<h3>Logout</h3>


</body>
</html>