<?php

require_once '../connection.php';

class Message {

    private $id, $text, $date, $sender, $receiver, $ifRead;

    public function __construct() {
        $this->id = -1;
        $this->text = "";
        $this->date = null;
        $this->sender = "";
        $this->receiver = "";
        $this->ifRead = 0;
    }

    function getId() {
        return $this->id;
    }

    function getText() {
        return $this->text;
    }

    function getDate() {
        return $this->date;
    }

    function getSender() {
        return $this->sender;
    }

    function getReceiver() {
        return $this->receiver;
    }

    function getIfRead() {
        return $this->ifRead;
    }

    function setText($text) {
        $this->text = $text;
    }

    function setDate() {
        $date = date('Y-m-d H:i:s');
        $this->date = $date;
    }

    function setSender($sender) {
        $this->sender = $sender;
    }

    function setReceiver($receiver) {
        $this->receiver = $receiver;
    }

    function setIfRead($ifRead) {
        $this->ifRead = $ifRead;
    }

    /**
     * 
     * @param PDO $conn
     * @param type $id
     * @return boolean|\Message
     */
    static public function loadMessageById(PDO $conn, $id) {

        $sql = "SELECT * FROM `Message` WHERE `id` = :id;";
        try {
            $query = $conn->prepare($sql);
            $result = $query->execute([
                'id' => $id,
            ]);

            if ($result === true && $query->rowCount() > 0) {
                $row = $query->fetch();

                $loadedMessage = new Message();
                $loadedMessage->id = $row['id'];
                $loadedMessage->date = $row['date'];
                $loadedMessage->text = $row['text'];
                $loadedMessage->sender = $row['sender'];
                $loadedMessage->receiver = $row['receiver'];

                return $loadedMessage;
            } else {

                return null;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage() . '<hr>';
            return false;
        }
    }

    static public function loadMessagesBySenderId(PDO $conn, $sender) {

        $sql = "SELECT * FROM `Message` WHERE `sender` = :sender;";
        try {
            $query = $conn->prepare($sql);
            $result = $query->execute([
                'sender' => $sender,
            ]);

            if ($result === true && $query->rowCount() > 0) {
                $rows = $query->fetchAll();

                foreach ($rows as $row) {
                    $loadedMessage = new Message();
                    $loadedMessage->id = $row['id'];
                    $loadedMessage->date = $row['date'];
                    $loadedMessage->text = $row['text'];
                    $loadedMessage->sender = $row['sender'];
                    $loadedMessage->receiver = $row['receiver'];

                    $messages[] = $loadedMessage;
                }

                return $messages;
            } else {

                return null;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage() . '<hr>';
            return false;
        }
    }

    /**
     * 
     * @param PDO $conn
     * @param type $receiver
     * @return boolean|\Message
     */
    static public function loadMessagesByReceiverId(PDO $conn, $receiver) {

        $sql = "SELECT * FROM `Message` WHERE `receiver` = :receiver;";
        try {
            $query = $conn->prepare($sql);
            $result = $query->execute([
                'receiver' => $receiver,
            ]);

            if ($result === true && $query->rowCount() > 0) {
                $rows = $query->fetchAll();

                foreach ($rows as $row) {
                    $loadedMessage = new Message();
                    $loadedMessage->id = $row['id'];
                    $loadedMessage->date = $row['date'];
                    $loadedMessage->text = $row['text'];
                    $loadedMessage->sender = $row['sender'];
                    $loadedMessage->receiver = $row['receiver'];

                    $messages[] = $loadedMessage;
                }

                return $messages;
            } else {

                return null;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage() . '<hr>';
            return false;
        }
    }

    public function saveToDB(PDO $conn) {
        if ($this->id == -1) {
            $sql = 'INSERT INTO `Message`(`text`, `date`, `sender`, `receiver`, `ifRead`) VALUES (:text, :date, :sender, :receiver, :ifRead);';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'text' => $this->text,
                'date' => $this->date,
                'sender' => $this->sender,
                'receiver' => $this->receiver,
                'ifRead' => $this->ifRead,
            ]);
            if ($result !== false) {
                $this->id = $conn->lastInsertId();

                return true;
            }
        } else if ($this->id > -1) {
            $sql = 'UPDATE `Message` SET `ifRead` = :ifRead WHERE `id` = :id';
            try {
                $stmt = $conn->prepare($sql);
                $result = $stmt->execute([
                    'ifRead' => $this->ifRead,
                    'id' => $this->id,
                ]);
                if ($result !== false) {

                    return true;
                }
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }
        }
    }

    public function delete(PDO $conn) {
        if ($this->id != -1) {
            $sql = "DELETE FROM `Message` WHERE `id` = :id;";

            try {
                $query = $conn->prepare($sql);
                $result = $query->execute([
                    'id' => $this->id,
                ]);

                if ($result === true) {
                    $this->id = -1;

                    return true;
                }

                return false;
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }

            return true;
        }
    }

}
