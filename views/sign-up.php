<?php
session_start();
?>


<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>MyTwitter - sign up page</title>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <link href="../views/login.css" rel="stylesheet" type="text/css"/>
        <link href="../views/fontello-773d6be7/css/fontello.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>

    </head>
    <body>

        <div class="form-style-10">
            <h1>Sign up!<span>Join MyTwitter!</span></h1>
            <form action="../controller/signup.php" method="post">
                <div class="section">
                    <span><i class="demo-icon icon-twitter"></i></span>Enter your details
                </div>
                <div class="inner-wrap">
                    
<!--username-->
                    
                    <label>Username <input type="text" name="name" placeholder="Your nickname..." value="<?php 
                    if(isset($_SESSION['form_username'])) {
                        echo $_SESSION['form_username'];
                        unset($_SESSION['form_username']);
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
                    <label>Your e-mail 
                        <input type="email" name="email" placeholder="Your e-mail..." value="<?php 
                    if(isset($_SESSION['form_email'])) {
                        echo $_SESSION['form_email'];
                        unset($_SESSION['form_email']);
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
                    <label>Password <input type="password" name="password1" value="<?php 
                    if(isset($_SESSION['form_password'])) {
                        echo $_SESSION['form_password'];
                        unset($_SESSION['form_password']);
                    }
                    ?>"><?php 
                    if(isset($_SESSION['form_password'])) {
                        echo $_SESSION['form_password'];
                        unset($_SESSION['form_password']);
                    }
                    ?></label>

                    <?php
                    if (isset($_SESSION['error4'])) {
                        echo $_SESSION['error4'];
                        unset($_SESSION['error4']);
                    }
                    ?>

<!--password confirmation-->
                    <label>Re-enter your password<input type="password" name="password2"></label>
                    <?php
                    if (isset($_SESSION['error0'])) {
                        echo $_SESSION['error0'];
                        unset($_SESSION['error0']);
                    }
                    if (isset($_SESSION['error1'])) {
                        echo $_SESSION['error1'];
                        unset($_SESSION['error1']);
                    }
                    if (isset($_SESSION['error5'])) {
                        echo $_SESSION['error5'];
                        unset($_SESSION['error5']);
                    }
                    ?>
<!--captcha-->
                    <div class="g-recaptcha" data-sitekey="6Ld-GxoUAAAAAILUnSuVJlpbWFe-3sQ9M5xByqjY">

                    </div>
                </div>

                <?php
                if (isset($_SESSION['error6'])) {
                    echo $_SESSION['error6'];
                    unset($_SESSION['error6']);
                }
                if (isset($_SESSION['error7'])) {
                    echo $_SESSION['error7'];
                    unset($_SESSION['error7']);
                }
                ?>
<!--submit-->
                <div class="button-section">
                    <button type="submit" name="submit">Create account!</button>

<!--checkbox-->
                    <span class="new-user">
                        <label><input type="checkbox" name="agree" <?php
                        if(isset($_SESSION['form_agree'])) {
                            echo "checked";
                            unset($_SESSION['form_agree']);
                        }
                        
                        ?>
                        >I agree to Terms and Policy.</label>
                    </span>
                </div>
            </form>
        </div>
    </body>
</html>