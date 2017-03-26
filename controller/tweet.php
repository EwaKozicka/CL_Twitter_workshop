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

        $newTweet = new Tweet();
        if ($newTweet->setText($tweet) !== false) {
            $newTweet->setUserId($idTweeta);
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
            if(isset($_SESSION['whoseTweets-my'])) {
//                unset($_SESSION['whoseTweets-my']);
            }
            $userId = User::loadUserByName($conn, $name)->getId();
            $userTweets = Tweet::loadTweetByUserId($conn, $userId);
            if (!empty($userTweets)) {
                $_SESSION['tweets'] = getTweets($conn, $userTweets);
                header('Location: ../views/tweets.php');
            } else {
                $_SESSION['notweets'] = '<span class="error">This user has no tweets!</span>';
                header('Location: ../views/tweets.php');
            }
        } else {
            $_SESSION['whoseTweets-my'] = 'Your';
            if(isset($_SESSION['whoseTweets'])) {
//                unset($_SESSION['whoseTweets']);
            }
            $myTweets = Tweet::loadTweetByUserId($conn, $_SESSION['userId']);
            if (!empty($myTweets)) {
                $_SESSION['myTweets'] = getTweets($conn, $myTweets);
                header('Location: ../views/tweets.php');
            } else {
                header('Location: ../views/tweets.php');
            }
            
        }
        
        
    } else {
        
        header ('Location: ../views/tweets.php?name='.$_SESSION['username']);
//        if (!isset($_SESSION['whoseTweets'])) {
//            $_SESSION['whoseTweets'] = 'Your';
//            $myTweets = Tweet::loadTweetByUserId($conn, $_SESSION['userId']);
//            if ($myTweets != 0) {
//                $_SESSION['myTweets'] = getTweets($conn, $myTweets);
//            }
//
//            header('Location: ../views/tweets.php');
//        } else {
//            unset($_SESSION['whoseTweets']);
//            header('Location: ../views/tweets.php');
//        }
    }
}
//        if ($_SESSION['whoseTweets'] != 'Your') {
//            //get their tweets
//            $user = User::loadUserByName($conn, $_SESSION['whoseTweets']);
//            $userid = $user->getId();
//            $tweets = Tweet::loadTweetById($conn, $userid);
//            if (!empty($tweets)) {
//                $_SESSION['tweets'] = getTweets($conn, $tweets);
//                header('Location: ../views/tweets.php');
//            } else {
//                $_SESSION['notweets'] = '<span class="error">This user has no tweets!</span>';
//                header('Location: ../views/tweets.php');
//            }
//        } else if ($_SESSION['whoseTweets'] == 'Your') {
//            $_SESSION['whoseTweets'] == 'Your';
//        }
//    }
//}