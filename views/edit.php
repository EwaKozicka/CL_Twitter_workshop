<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
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
        <title>MyTwitter - edit profile</title>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <script src="edit.js" type="text/javascript"></script>
        <link href="../views/login.css" rel="stylesheet" type="text/css"/>
        <link href="../views/fontello-773d6be7/css/fontello.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>

    </head>
    <body>

        <div class="form-style-10">
            <h1>Edit profile!</h1>
            <form action="../controller/user.php" method="post">
                <div class="section">
                    <span><i class="demo-icon icon-twitter"></i></span>Edit your details
                </div>
                <div class="inner-wrap">

                    <!--username-->

                    <label>Change username <input type="text" name="name" placeholder="Your nickname..." value="<?php
                        if (isset($_SESSION['username'])) {
                            echo $_SESSION['username'];
                        }
                        ?>"></label>

                    <?php
                    if (isset($_SESSION['error2'])) {
                        echo $_SESSION['error2'];
                        unset($_SESSION['error2']);
                    }
                    if (isset($_SESSION['error8b'])) {
                        echo $_SESSION['error8b'];
                        unset($_SESSION['error8b']);
                    }
                    ?>
                    <!--email-->
                    <label>Change e-mail 
                        <input type="email" name="email" placeholder="Your e-mail..." value="<?php
                        if (isset($_SESSION['email'])) {
                            echo $_SESSION['email'];
                        }
                        ?>"></label>

                    <?php
                    if (isset($_SESSION['error3'])) {
                        echo $_SESSION['error3'];
                        unset($_SESSION['error3']);
                    }
                    if (isset($_SESSION['error8a'])) {
                        echo $_SESSION['error8a'];
                        unset($_SESSION['error8a']);
                    }
                    ?>

                    <!--password-->
                    <label>Change password <input type="password" name="password1" value="<?php ?>"></label>

                    <?php
                    if (isset($_SESSION['error4'])) {
                        echo $_SESSION['error4'];
                        unset($_SESSION['error4']);
                    }
                    ?>

                    <!--password confirmation-->
                    <label>Confirm password<input type="password" name="password2"></label>
                    <?php
                    if (isset($_SESSION['error0'])) {
                        echo $_SESSION['error0'];
                        unset($_SESSION['error0']);
                    }

                    if (isset($_SESSION['error5'])) {
                        echo $_SESSION['error5'];
                        unset($_SESSION['error5']);
                    }
                    ?>

                    <!--submit-->
                    <div class="button-section">
                        <button class="edit-button" type="submit" name="submit">Submit changes!</button>
                    </div>
            </form>
        </div>

        <!--go back-->
        <form action="../views/main.php">
            <button type="submit"><span class='glyphicon glyphicon-arrow-left'></span> Go back!</button>
        </form>
    </body>
</html>

