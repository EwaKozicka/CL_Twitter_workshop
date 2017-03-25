<?php

//loading all Tweets and preparing div to put on the main site
/**
 * 
 * @param type $conn
 * @param type $array
 * @return type
 */
function getTweets($conn, $array) {
    foreach ($array as $tweet) {
        $text = $tweet->getText();
        $date = $tweet->getCreationDate();
        $userId = $tweet->getuserId();
        $tweetId = $tweet->getId();
        
        $nick = User::loadUserById($conn, $userId)->getUsername();
        $fullTweets[][$tweetId] = '<div><span class="tweet_header">'
                . $date . '<a class="plain" href="../controller/tweet.php?name=' . $nick . '"> ' . $nick . '</a> writes: </span><br>'
                . '<span class="text">' . $text . '</span><br>'
                . '<div class="right">Comments: $number</div>'
                . '<hr></div>';
    }
    
    $tweets = array_reverse($fullTweets);
    return $tweets;
    
}

//require_once 'Tweet.php';
//require_once 'User.php';


//$myTweets = Tweet::loadTweetByUserId($conn, 2);
//var_dump($myTweets);
//echo '<hr>';
//var_dump(getTweets($conn, $myTweets));
//echo '<hr>';

function getComments($conn, $array) {
    foreach ($array as $comment) {
        $text = $comment->getText();
        $date = $comment->getCreationDate();
        $userId = $comment->getUserId();
        $commentId = $comment->getId();
        $postId = $comment->getPostId();
        
        $nick = User::loadUserById($conn, $userId)->getUsername();
        $fullComments[][$commentId] = '<div><span class="tweet_header">'
                . $date . '<a class="plain" href="../controller/comment.php?name=' . $nick . '"> ' . $nick . '</a> comments: </span><br>'
                . '<span class="text">' . $text . '</span><br>'
                . '<div class="right">Comments: $number</div>'
                . '<hr></div>';
    }
    
    $comments = array_reverse($fullComments);
    return $comments;
    
}

//require_once 'Comment.php';

//
//$myComments = Comment::loadAllCommentsByPostId($conn, 5);
//var_dump($myComments);
//echo '<hr>';
//var_dump(getComments($conn, $myComments));