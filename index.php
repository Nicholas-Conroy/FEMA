<?php
    require_once "includes/config_session.inc.php";
    require_once "includes/signup/signup_view.inc.php";
    // require_once "includes/signup_contr.inc.php";
    require_once "includes/login/login_view.inc.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/login_styles.css">
    <title>Document</title>
</head>
<body>
    
    <div id="user-auth">
        <h3>Login</h3>
        <form action="includes/login/login.inc.php" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="pwd" placeholder="Password">
            <button>Login</button>
        </form>
        <?php
            check_login_errors();
        ?>
        <h3>Signup</h3>
        <form action="includes/signup/signup.inc.php" method="post">
            <?php
                signup_inputs();
            ?>
            <button>Signup</button>
        </form>
        <?php
        check_signup_errors();
        ?>
    </div>

</body>
</html>