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
        <title>MyTwitter - messages</title>

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
                    Messages
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="main.php">Main page</a></li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="edit.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
                    <li><a href="../controller/logout.php"><span class="glyphicon glyphicon-off"></span> Log out</a></li>
                </ul>
            </div>
        </nav>

        <div class="form-style-10">
            <h3> 

Your message
    
            </h3>
        
        <div>
<?php


if (isset($_SESSION['oneMessage'])) {    
    echo $_SESSION['oneMessage'];
} else {
    echo "Brak wiadomości";
}

?>
            </div>


        </div>


    </body>
</html>