<?php

require_once '../src/Tweet.php';
require_once '../src/User.php';
require_once '../src/Comment.php';
require_once '../src/functions.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    exit();
}

//preparing tweet for showing on screen
if ('GET' === $_SERVER['REQUEST_METHOD']) {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $idTweeta = $_GET['id'];
        $tweet = Tweet::loadTweetById($conn, $idTweeta);
        if ($tweet) {
            $_SESSION['date'] = $tweet->getCreationDate();
            $_SESSION['text'] = $tweet->getText();
            $uId = $tweet->getuserId();
            $user = User::loadUserById($conn, $uId);
            $_SESSION['name'] = $user->getUsername();
            $_SESSION['postId'] = $idTweeta;
            
//loading comments belonging to a post
            $comments = Comment::loadAllCommentsByPostId($conn, $idTweeta);
            $_SESSION['comment'] = getComments($conn, $comments);
            $commentsAmount = count($comments);
            $_SESSION['howManyComments'] = $commentsAmount;
            
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
//
//
//if ('GET' === $_SERVER['REQUEST_METHOD']) {
//    if (isset($_GET['id']) && !empty($_GET['id'])) {
//        $postId = $_GET['id'];
//        $comments = Comment::loadAllCommentsByPostId($conn, $postId);
//        getComments($conn, $comments);
        
        
//        header('Location: ../views/post.php');
//    }
//}