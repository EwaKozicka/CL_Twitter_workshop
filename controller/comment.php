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


//adding to DB new comment sent via form

if ("POST" === $_SERVER['REQUEST_METHOD']) {

    if (isset($_POST['comment']) && !empty($_POST['comment'])) {
        $comment = $_POST['comment'];
        $userId = $_SESSION['userId'];
        $postId = $_SESSION['postId'];

        $newComment = new Comment();
        if ($newComment->setText($comment) !== false) {
            $newComment->setUserId($userId);
            $newComment->setPostId($postId);
            $newComment->setCreationDate();
            $newComment->saveToDB($conn);

            $comments = Comment::loadAllCommentsByPostId($conn, $postId);
            $_SESSION['comment'] = getComments($conn, $comments);

            header('Location: ../views/post.php');
        } else {
            $_SESSION['toolong'] = '<span class="error">Comments can\'t be longer than 60 chars!</span>';
            $comments = Comment::loadAllCommentsByPostId($conn, $postId);
            $_SESSION['comment'] = getComments($conn, $comments);
            header('Location: ../views/post.php');
        }
    } else {
        $comments = Comment::loadAllCommentsByPostId($conn, $postId);
        $_SESSION['comment'] = getComments($conn, $comments);
        header('Location: ../views/post.php');
    }
}



//loading comments belonging to a post

if ('GET' === $_SERVER['REQUEST_METHOD']) {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $postId = $_GET['id'];
        $comments = Comment::loadAllCommentsByPostId($conn, $postId);
        $commentsAmount = count($comments);
        $_SESSION['howManyComments'] = $commentsAmount;
        getComments($conn, $comments);

        header('Location: ../views/post.php');
    } else if (isset($_GET['name']) && !empty($_GET['name'])) {
        $name = $_GET['name'];
        header('Location: ./tweet.php?name='.$name);
    } else {
        header('Location: ../views/main.php');
    }
}

