<?php
session_start();

//przywitanie
echo "Hello ".$_SESSION['username']."!<br>";
//wyloguj się
echo '<a href="../controller/logout.php">Log out</a>';
//
if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    exit();
}