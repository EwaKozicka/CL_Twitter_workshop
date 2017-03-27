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
        $idTweeta = $_SESSION['userId'];

        $newMsg = new Tweet();
        if ($newMsg->setText($tweet) !== false) {
            $newMsg->setUserId($idTweeta);
            $newMsg->setCreationDate();
            $newMsg->saveToDB($conn);

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
        $_SESSION['whoseTweets'] = $name;
        
        //logged user tweets to show
        if ($name == $_SESSION['username']) {
            
            $myTweets = Tweet::loadTweetByUserId($conn, $_SESSION['userId']);
            if (!empty($myTweets)) {
                $_SESSION['myTweets'] = getTweets($conn, $myTweets);
                header('Location: ../views/tweets.php');
            } else {
                header('Location: ../views/tweets.php');
            }
        }

        //other users tweets to show

        if ($name !== $_SESSION['username']) {
            
            $userId = User::loadUserByName($conn, $name)->getId();
            $userTweets = Tweet::loadTweetByUserId($conn, $userId);
            if (!empty($userTweets)) {
                $_SESSION['tweets'] = getTweets($conn, $userTweets);
                header('Location: ../views/tweets.php');
            } else {
                $_SESSION['notweets'] = '<span class="error">This user has no tweets!</span>';
                header('Location: ../views/tweets.php');
            }
        } 
    } else {
        header('Location: ../views/main.php');
    }
} else {
    echo "What da fak? jak ty tu się dostałeś?";
}