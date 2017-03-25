<?php
session_start();


if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    exit();
}
//wykasowanie danych sesyjnych pozostałych po ewentualnych błędach rejestracji i pamiętających dane wpisane do formularza

if (isset($_SESSION['form_username'])) {
    unset($_SESSION['form_username']);
}
if (isset($_SESSION['form_email'])) {
    unset($_SESSION['form_email']);
}
if (isset($_SESSION['form_password'])) {
    unset($_SESSION['form_password']);
}
if (isset($_SESSION['form_agree'])) {
    unset($_SESSION['form_agree']);
}
if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}
if (isset($_SESSION['empty'])) {
    unset($_SESSION['empty']);
}
if (isset($_SESSION['error0'])) {
    unset($_SESSION['error0']);
}
if (isset($_SESSION['error1'])) {
    unset($_SESSION['error1']);
}
if (isset($_SESSION['error2'])) {
    unset($_SESSION['error2']);
}
if (isset($_SESSION['error3'])) {
    unset($_SESSION['error3']);
}
if (isset($_SESSION['error4'])) {
    unset($_SESSION['error4']);
}
if (isset($_SESSION['error5'])) {
    unset($_SESSION['error5']);
}
if (isset($_SESSION['error6'])) {
    unset($_SESSION['error6']);
}
if (isset($_SESSION['error7'])) {
    unset($_SESSION['error7']);
}
if (isset($_SESSION['error8a'])) {
    unset($_SESSION['error8a']);
}
if (isset($_SESSION['error8b'])) {
    unset($_SESSION['error8b']);
}
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>MyTwitter - main page</title>

        <link rel="stylesheet" href="main.css">
        <link rel="stylesheet" href="views/fontello-773d6be7/css/fontello.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header hello">
                    <?= "Hello " . $_SESSION['username'] . "!" ?>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="#">Home</a>
                    </li>
                    <li>
                        <a href="../controller/tweet.php"><span class="glyphicon glyphicon-pencil"></span> Tweets</a>
                    </li>
                    <li>
                        <a href="msg.php"><span class="glyphicon glyphicon-envelope"></span> Messages</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="../controller/user.php"><span class="glyphicon glyphicon-user"></span> Profile</a>
                    </li>
                    <li>
                        <a href="../controller/logout.php"><span class="glyphicon glyphicon-off"></span> Log out</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="form-style-10">
            <h3>Tweet something!<span>Share your thoughts!</span></h3>
            <form action="../controller/tweet.php" method="post">
                <div class="inner-wrap">
                    <?php
                    if (isset($_SESSION['toolong'])) {
                        echo $_SESSION['toolong'];
                        unset($_SESSION['toolong']);
                    }
                    ?>

                    <label>Write your message here:<br> <textarea cols="50" rows="3" name="tweet"></textarea></label>

                    <div class="button-section">
                        <button type="submit" name="submit">Publish!</button>
                    </div>
                </div>
            </form>
            <div>
                <?php
                if (isset($_SESSION['show'])) {
                    foreach ($_SESSION['show'] as $tweet) {
                        foreach ($tweet as $tweetId => $text) {
                            echo '<a class="plain" href="../controller/post.php?id='.$tweetId.'">' . $text . '</a>';
                        }
                    }
                }
                ?>
            </div>
        </div>





    </body>
</html>