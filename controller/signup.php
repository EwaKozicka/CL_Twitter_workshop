<?php

if (!isset($_SESSION)) {
    session_start();
}
require_once '../src/User.php';
require_once '../src/Tweet.php';
require_once '../src/functions.php';

$error0 = '<span class="error">Use post method to send this form!</span>';
$error1 = '<span class="error">Fill out all fields!</span>';
$error2 = '<span class = "error">Invalid username</span>';
$error3 = '<span class = "error">Invalid email</span>';
$error4 = '<span class = "error">Password should contain 8 - 20 signs</span>';
$error5 = '<span class = "error">Both passwords should be the same!</span>';
$error6 = '<span class = "error">You have to agree to Terms and Policy<br></span>';
$error7 = '<span class = "error">Are you a bot or what?</span>';
$error8a = '<span class = "error">Email already taken</span>';
$error8b = '<span class = "error">Username already taken</span>';

//captcha key
$key = '6Ld-GxoUAAAAAJMQnH9qOVRJKqQhcgXzRk37uGPH';

//początek walidacji
if ("POST" === $_SERVER["REQUEST_METHOD"]) {

    if (isset($_POST['email'], $_POST['name'], $_POST['password1'], $_POST['password2'])) {

        if (!empty($_POST['email']) && !empty($_POST['name']) && !empty($_POST['password1']) && !empty($_POST['password2'])) {

            $username = $_POST['name'];
            $email = $_POST['email'];
            $password1 = $_POST['password1'];
            $password2 = $_POST['password2'];

//flaga
            $ok = true;

            $user = new User();

// walidacja nicku
            if (is_string($user->setUsername($username))) {
                $ok = false;
                $_SESSION['error2'] = $error2;
            }

// walidacja maila
            if ($user->setEmail($email) == false) {
                $ok = false;
                $_SESSION['error3'] = $error3;
            }

// walidacja haseł
            if ($password1 != $password2) {
                $ok = false;
                $_SESSION['error5'] = $error5;
            } else {
                if ($user->setHashPass($password1) == false) {
                    $ok = false;
                    $_SESSION['error4'] = $error4;
                }
            }
            
// walidacja terms and policy
            if (!isset($_POST['agree'])) {
                $ok = false;
                $_SESSION['error6'] = $error6;
            }
            
// walidacja captcha
            $captcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$key.'&response='.$_POST['g-recaptcha-response']);
            $response = json_decode($captcha);
            if (!($response->success)) {
                $ok = false;
                $_SESSION['error7'] = $error7;
            }

//sprawdzenie, czy email jest już w bazie
            $ifMailExists = User::loadUserByEmail($conn, $email);
            if ($ifMailExists) {
                $ok = false;
                $_SESSION['error8a'] = $error8a;
            }
            
//sprawdzenie, czy nazwa usera jest już w bazie
            $ifUserExists = User::loadUserByName($conn, $username);
            if ($ifUserExists) {
                $ok = false;
                $_SESSION['error8b'] = $error8b;
            }
            
//zapamiętanie wprowadzonych danych
            $_SESSION['form_username'] = $username;
            $_SESSION['form_email'] = $email;
            $_SESSION['form_password'] = $password1;
            
            if (isset($_POST['agree'])) {
                $_SESSION['form_agree'] = true;
            }
            
//dodanie usera do DB
            if ($ok == true) {
                $user->saveToDB($conn);
                $_SESSION['logged'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['userId'] = $user->getId();
                
                $tweets = Tweet::loadAllTweets($conn);
                $_SESSION['show'] = getTweets($conn, $tweets);
                
                
                header("Location: ../views/main.php");
                
            } else {
                header("Location: ../views/sign-up.php");
            }
        } else {
            $_SESSION['error1'] = $error1;
            header("Location: ../views/sign-up.php");
        }
    } else {
        $_SESSION['error0'] = $error0;
        header("Location: ../views/sign-up.php");
    }
} else {
    header("Location: ../index.php");
}