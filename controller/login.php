<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once '../src/User.php';
require_once '../src/Tweet.php';
require_once '../src/functions.php';

if ("POST" === $_SERVER['REQUEST_METHOD']) {
    if (isset($_POST['email'], $_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = User::loadUserByEmail($conn, $email);

        if ($user !== null) {
            $verify = $user->passwordVerify($password);
            if ($verify) {
                $_SESSION['logged'] = true;
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['userId'] = $user->getId();
                unset($_SESSION['error']);
                
                $tweets = Tweet::loadAllTweets($conn);
                $_SESSION['show'] = getTweets($conn, $tweets);
                
                header('Location: ../views/main.php');
                
            } else {
                $_SESSION['error'] = '<span class="error">Incorrect login or password!</span>';
                header('Location: ../index.php');
            }
            
        } else {
            $_SESSION['error'] = '<span class="error">Incorrect login or password!</span>';
            header('Location: ../index.php');
        }
        
    } else {
        $_SESSION['empty'] = '<span class="error"">Fill out all the fields!</span>';
        header('Location: ../index.php');
    }
    
} else {
    header('Location: ../index.php');
}