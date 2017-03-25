<?php

require_once '../src/Tweet.php';
require_once '../src/User.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    exit();
}


if ('GET' === $_SERVER['REQUEST_METHOD']) {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $tweet = Tweet::loadTweetById($conn, $id);
        if ($tweet != 0) {
            $_SESSION['date'] = $tweet->getCreationDate();
            $_SESSION['text'] = $tweet->getText();
            $uId = $tweet->getuserId();
            $user = User::loadUserById($conn, $uId);
            $_SESSION['name'] = $user->getUsername();

            header('Location: ../views/post.php');
        } else {
            header('Location: ../views/main.php');
        }
    } else {
        header('Location: ../views/main.php');
    }
} else {
    header('Location: ../views/main.php');
}