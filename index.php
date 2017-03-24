<?php 
session_start();

if (isset($_SESSION['logged']) && ($_SESSION['logged']==true)) {
    header('Location: ./views/main.php');
    exit();
}

?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>MyTwitter - login page</title>

        <link rel="stylesheet" href="views/login.css">
        <link rel="stylesheet" href="views/fontello-773d6be7/css/fontello.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>

    </head>
    
    <body> 
        <div class="form-style-10">
            <h1>Log in!<span>Discover the power of MyTwitter!</span></h1>
            <form action="controller/login.php" method="post">
                <div class="section">
                    <span><i class="demo-icon icon-twitter"></i></span>E-mail &amp; password
                </div>
                <div class="inner-wrap">
                    <label>Your e-mail <input type="email" name="email"></label>
                    <label>Password <input type="password" name="password"></label>
                    
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    }
                    if (isset($_SESSION['empty'])) {
                        echo $_SESSION['empty'];
                        unset($_SESSION['empty']);
                    }
                    ?>
                    
                </div>
                <div class="button-section">
                    <button type="submit" name="submit">Ready!</button>
                    <span class="new-user">
                        <a href="views/sign-up.php" alt="create account">I don't have an account yet. Create it!</a>
                    </span>
                </div>
            </form>
        </div>
    </body>
</html>
