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
        <title>MyTwitter - tweets</title>

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
                    Tweets
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="main.php">Main page</a></li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="edit.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
                    <li><a href="../controller/logout.php"><span class="glyphicon glyphicon-off"></span> Log out</a></li>
                </ul>
            </div>
        </nav>

        <div class="form-style-10">
            <h3><?php
                if (isset($_SESSION['whoseTweets'])) {
                    if ($_SESSION['whoseTweets'] != 'Your') {
                        echo $_SESSION['whoseTweets'] . ' -';
                    } else {
                        echo $_SESSION['whoseTweets'];
                    }
                }
                echo ' tweets!';
                
                if (isset($_SESSION['whoseTweets'])) {
                    if ($_SESSION['whoseTweets'] != 'Your') {
                        echo ''
                        . '<div class="button-section">
                    <button class="msg" type="submit" name="submit"><span class="glyphicon glyphicon-envelope"></span>  Message ' . $_SESSION['whoseTweets'] . '!</button>
                </div>';
                    }
                }
                ?></h3>



            <div>
                <?php
                if (isset($_SESSION['tweets'])) {
                    foreach ($_SESSION['tweets'] as $tweet) {
                        foreach ($tweet as $tweetId => $text) {
                            echo $text;
                        }
                    } 
                    unset ($_SESSION['tweets']);
                } else if (isset($_SESSION['myTweets'])) {
                    foreach ($_SESSION['myTweets'] as $tweet) {
                        foreach ($tweet as $tweetId => $text) {
                            echo $text;
                        }
                    }
                } else {
                    echo "You have no tweets yet.";
                }
                ?>
            </div>
          
            
        </div>


    </body>
</html>