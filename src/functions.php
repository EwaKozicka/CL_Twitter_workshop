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
        
//nick autora tweeta
        $nick = User::loadUserById($conn, $userId)->getUsername();
        
        $fullTweets[][$tweetId] = '<div><span class="tweet_header"><a class="plain" href="../controller/post.php?id='.$tweetId.'">'.$date . '<a class="plain" href="../controller/tweet.php?name=' . $nick . '"> ' . $nick . '</a> writes: </span><br>'
                . '<span class="text">' . $text . '</span><br>'
                . '<div class="right">Comments: $number</div>'
                . '<hr></div>';
    }
    
    
    $tweets = array_reverse($fullTweets);
    return $tweets;
    
}
/**
 * 
 * @param type $conn
 * @param type $array
 * @return type
 */
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
function getMessagesSent($conn, $array) {
    foreach ($array as $msg) {
        $msgId = $msg->getId();
        $text = $msg->getText();
        if (strlen($text) > 40) {
            $text = substr($text, 0, 40).'...';
        }
        $date = $msg->getDate();
        $receiver = $msg->getReceiver();
        $ifRead = $msg->getIfRead();
        
        $receiverAll = User::loadUserById($conn, $receiver);
        $receiverName = $receiverAll->getUsername();
   
        if ($ifRead === 1) {
            $msg = '<div><a class="msg-link-read" href="../controller/msg.php?id='.$msgId.'"><span class="msg-header">Date: '. $date .'<br> To: '. $receiverName . ' </span><br>'
                . '<span class="msg-text-read">' . $text . '</span><br>'
                . '<hr></div>';
            $fullMessages[][$msgId] = $msg;
        } 
        else if ($ifRead === 0) {
            $msg = '<div><a class="msg-link" href="../controller/msg.php?id='.$msgId.'"><span class="msg-header">Date: '. $date .'<br> To: '. $receiverName . ' </span><br>'
                . '<span class="msg-text">' . $text . '</span><br>'
                . '<hr></div>';
            $fullMessages[][$msgId] = $msg;
        }
        
//        $fullMessages[][$msgId] = $msg;
    }
    
    $messages = array_reverse($fullMessages);
    return $messages;
    
}

function getMessagesReceived($conn, $array) {
    foreach ($array as $msg) {
        $msgId = $msg->getId();
        $text = $msg->getText();
        if (strlen($text) > 30) {
            $text = substr($text, 0, 30).'...';
        }
        $date = $msg->getDate();
        $ifRead = $msg->getIfRead();
        $sender = $msg->getSender();
        $senderAll = User::loadUserById($conn, $sender);
        $senderName = $senderAll->getUsername();
   
        
        if ($ifRead == 1) {
            $msg = '<div><a class="msg-link-read" href="../controller/msg.php?id='.$msgId.'"><span class="msg-header">Date: '. $date .'<br> From: '. $senderName . ' </span><br>'
                . '<span class="msg-text-read">' . $text . '</span><br>'
                . '<hr></div>';
        } 
        else if ($ifRead == 0) {
            $msg = '<div><a class="msg-link" href="../controller/msg.php?id='.$msgId.'"><span class="msg-header">Date: '. $date .'<br> From: '. $senderName . ' </span><br>'
                . '<span class="msg-text">' . $text . '</span><br>'
                . '<hr></div>';
        }
        
        $fullMessages[][$msgId] = $msg;
    }
    
    $messages = array_reverse($fullMessages);
    var_dump($messages);
    return $messages;
    
}


