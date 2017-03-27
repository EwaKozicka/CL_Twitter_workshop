<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['logged'])) {
    header('Location: ../index.php');
    exit();
}

require_once '../src/Message.php';
require_once '../src/functions.php';
require_once '../src/User.php';

$myMessages = Message::loadMessagesByReceiverId($conn, $_SESSION['userId']);


if (!empty($myMessages)) {
    $_SESSION['msgs-received'] = getMessagesReceived($conn, $myMessages);
}

header('Location: ../views/received.php');
