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

$messages = Message::loadMessagesBySenderId($conn, $_SESSION['userId']);
$_SESSION['msgs-sent'] = getMessagesSent($conn, $messages);

header('Location: ../views/sent.php');
