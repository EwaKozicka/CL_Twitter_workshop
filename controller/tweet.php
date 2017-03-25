<?php

require_once '../src/Tweet.php';
require_once '../src/User.php';
require_once '../src/functions.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    exit();
}


//adding new tweet sent via form

if ("POST" === $_SERVER['REQUEST_METHOD']) {

    if (isset($_POST['tweet']) && !empty($_POST['tweet'])) {
        $tweet = $_POST['tweet'];
        $id = $_SESSION['userId'];

        $newTweet = new Tweet();
        if ($newTweet->setText($tweet) !== false) {
            $newTweet->setUserId($id);
            $newTweet->setCreationDate();
            $newTweet->saveToDB($conn);
            
            $tweets = Tweet::loadAllTweets($conn);
            $_SESSION['show'] = getTweets($conn, $tweets);
            
            header('Location: ../views/main.php');
        } else {
            $_SESSION['toolong'] = '<span class="error">Tweets can\'t be longer than 140 chars!</span>';
            header('Location: ../views/main.php');
        }
    } else {
        header('Location: ../views/main.php');
    }
}

//loading tweets of one user

if ('GET' === $_SERVER['REQUEST_METHOD']) {
    if (isset($_GET['name']) && !empty($_GET['name'])) {
        $name = $_GET['name'];
        if ($name != $_SESSION['username']) {
            $_SESSION['whoseTweets'] = $name;
            $userId = User::loadUserByName($conn, $name)->getId();
            $userTweets = Tweet::loadTweetByUserId($conn, $userId);
            $_SESSION['tweets'] = getTweets($conn, $userTweets);
            header('Location: ../views/tweets.php');
        } else {
            $_SESSION['whoseTweets'] = 'Your';
            $myTweets = Tweet::loadTweetByUserId($conn, $_SESSION['userId']);
            $_SESSION['myTweets'] = getTweets($conn, $myTweets);
            header('Location: ../views/tweets.php');
        }
    } else {
        $_SESSION['whoseTweets'] = 'Your';
        $myTweets = Tweet::loadTweetByUserId($conn, $_SESSION['userId']);
        if ($myTweets != 0) {
            $_SESSION['myTweets'] = getTweets($conn, $myTweets);
        }
        
        header('Location: ../views/tweets.php');
    }
}