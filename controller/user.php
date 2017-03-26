<?php

require_once '../src/User.php';
require_once '../src/Tweet.php';
require_once '../src/functions.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    exit();
}

$error0 = '<span class="error">Use post method to send this form!</span>';

$error2 = '<span class = "error">Invalid username</span>';
$error3 = '<span class = "error">Invalid email</span>';
$error4 = '<span class = "error">Password should contain 8 - 20 signs</span>';
$error5 = '<span class = "error">Both passwords should be the same!</span>';
$error8a = '<span class = "error">Email already taken</span>';
$error8b = '<span class = "error">Username already taken</span>';


$thisUser = User::loadUserById($conn, $_SESSION['userId']);
$currentName = $thisUser->getUsername();
$currentEmail = $thisUser->getEmail();
$_SESSION['email'] = $currentEmail;

if ("GET" === $_SERVER['REQUEST_METHOD']) {
    
    header ('Location: ../views/edit.php');
}


if ("POST" === $_SERVER["REQUEST_METHOD"]) {

    if (isset($_POST['email'], $_POST['name'], $_POST['password1'], $_POST['password2'])) {
        
        if (!empty($_POST['email']) || !empty($_POST['name']) || !empty($_POST['password1'])) {
            //nowe zmienne (z formularza)
            $username = $_POST['name'];
            $email = $_POST['email'];
            $password1 = $_POST['password1'];
            $password2 = $_POST['password2'];
            
//flaga
            $ok = true;
            
// walidacja username
            if (!empty($username)) {
                $newName = $thisUser->setUsername($username);
                if ($newName == false) {
                    $ok = false;
                    $_SESSION['error2'] = $error2;
                }
            } 
            // else to username = stary username
            

// walidacja maila
            if (!empty($email)) {
                if ($thisUser->setEmail($email) == false) {
                    $ok = false;
                    $_SESSION['error3'] = $error3;
                }
            }

// walidacja haseł
            if (!empty($password1) || !empty($password2)){
                if ($password1 != $password2) {
                    $ok = false;
                    $_SESSION['error5'] = $error5;
                } else {
                    if ($thisUser->setHashPass($password1) == false) {
                        $ok = false;
                        $_SESSION['error4'] = $error4;
                    }
                }
            }
            
//sprawdzenie, czy email jest już w bazie
            if (!empty($email)) {
                $mailIfExists = User::loadUserByEmail($conn, $email);
                
                if (!empty($mailIfExists)) {
                    $mailFromDB = $mailIfExists->getEmail();

                    if ($mailFromDB !== $currentEmail) {
                        $ok = false;
                        $_SESSION['error8a'] = $error8a;
                    }
                }   
            }
            
//sprawdzenie, czy nazwa usera jest już w bazie
            if (!empty($username)) {
                $userIfExists = User::loadUserByName($conn, $username);
                
                if (!empty($userIfExists)) {
                    $nameFromDB = $userIfExists->getUsername();

                    if ($nameFromDB !== $currentName) {
                        $ok = false;
                        $_SESSION['error8b'] = $error8b;
                    }
                }   
            }            
            
//update usera w DB
            if ($ok == true) {
                $thisUser->saveToDB($conn);
//                $_SESSION['logged'] = true;
                $_SESSION['username'] = $username;
//                $_SESSION['userId'] = $user->getId();
                
                $tweets = Tweet::loadAllTweets($conn);
                $_SESSION['show'] = getTweets($conn, $tweets);
                      
                header("Location: ../views/edit.php");
                
            } else {
                header("Location: ../views/edit.php");
            }
        } else {
            $_SESSION['error1'] = $error1;
            header("Location: ../views/sign-up.php");
        }
    } else {
        $_SESSION['error0'] = $error0;
        header("Location: ../views/sign-up.php");
    }
}