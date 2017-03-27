<?php

require_once '../src/Message.php';
require_once '../src/User.php';
require_once '../src/functions.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    exit();
}

//adding new message sent via form

if ("POST" === $_SERVER['REQUEST_METHOD']) {

    if (isset($_POST['msg']) && !empty($_POST['msg'])) {
        $text = $_POST['msg'];
        $senderId = $_SESSION['userId'];
        $receiverId = $_SESSION['receiverId'];

        $newMsg = new Message();
        $newMsg->setText($text);
        $newMsg->setSender($senderId);
        $newMsg->setReceiver($receiverId);
        $newMsg->setDate();
        $newMsg->setIfRead(0);
        $newMsg->saveToDB($conn);
            
        header('Location: ../controller/sent.php');
        
    } else {
        header('Location: ../views/main.php');
    }
}




// kiedy jesteśmy przekierowani z guzika, to dostajemy message.php?name='.$_SESSION['whoseTweets'].'"

if ('GET' === $_SERVER['REQUEST_METHOD']) {
    if (isset($_GET['name']) && !empty($_GET['name'])) {
        $receiverName = $_GET['name'];
        $receiver = User::loadUserByName($conn, $receiverName);
        if (!empty($receiver)) {
            $receiverId = $receiver->getId();
            $_SESSION['receiverId'] = $receiverId;
            $senderId = $_SESSION['userId'];
            header('Location: ../views/msg-form.php');
        } else {
            header('Location: ../views/main.php');
        }
    } else {
        header('Location: ../views/main.php');
    }
    
}