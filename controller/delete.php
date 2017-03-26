<?php



if (!isset($_SESSION)) {
    session_start();
}

require_once '../src/User.php';

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    exit();
}


if ('POST' === $_SERVER['REQUEST_METHOD']) {
    $userId = $_SESSION['userId'];
    $user = User::loadUserById($conn, $userId);
    $user->delete($conn);
    
    session_unset();
    header('Location: ../index.php');
 
}