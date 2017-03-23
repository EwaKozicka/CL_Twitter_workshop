
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>MyTwitter - login page</title>

        <link href="../views/login.css" rel="stylesheet" type="text/css"/>
        <link href="../views/fontello-773d6be7/css/fontello.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>

    </head>
    <body>
        
         <div class="form-style-10">
            <h1>Sign up!<span>Join MyTwitter!</span></h1>
            <form action="signController.php" method="post">
                <div class="section">
                    <span><i class="demo-icon icon-twitter"></i></span>E-mail &amp; password
                </div>
                <div class="inner-wrap">
                    <label>Your e-mail <input type="email" name="email" /></label>
                    <label>Password <input type="password" name="password"></label>
                </div>
                <div class="button-section">
                    <button type="submit" name="submit">Create account!</button>
<!--                    <span class="new-user">
                        <input type="checkbox" name="field7">I agree to Terms and Policy.
                    </span>-->
                </div>
            </form>
        </div>
    </body>
</html>