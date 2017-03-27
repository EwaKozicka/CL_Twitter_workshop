<?php

require_once '../src/Message.php';
require_once '../src/User.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    exit();
}
// wyświetla całą wiadomość i przestawia ifRead na 1

if ('GET' === $_SERVER['REQUEST_METHOD']) {
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $msg = Message::loadMessageById($conn, $id);
        $text = $msg->getText();
        $date = $msg->getDate();
        $ifRead = $msg->getIfRead();
        $receiverId = $msg->getReceiver();
        $senderId = $msg->getSender();
        
        $receiver = User::loadUserById($conn, $receiverId)->getUsername();
        $sender = User::loadUserById($conn, $senderId)->getUsername();
        
        $msgToPrint = '<div><span class="msg-header">'
                . 'Date: '. $date .'<br> '
                . 'From: '. $sender . '<br>'
                . 'To: '. $receiver . '<br>'
                . 'Text: </span><br>'
                . '<span class="msg-text">' . $text . '</span><br>'
                . '<hr></div>';

        if ($ifRead == 0 && $receiver == $_SESSION['username']) {
            $msg->setIfRead(1);
            $msg->saveToDB($conn);
        }
        
        $_SESSION['oneMessage'] = $msgToPrint;
        
        header ('Location: ../views/msg.php');
        
    }
}