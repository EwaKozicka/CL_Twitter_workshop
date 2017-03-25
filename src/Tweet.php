<?php
require_once '../connection.php';

class Tweet {
    private $id, $userId, $text, $creationDate;

    public function __construct() {
        $this->id = -1;
        $this->userId = "";
        $this->text = "";
        $this->creationDate = "";
    }

    function getId() {
        return $this->id;
    }

    function getuserId() {
        return $this->userId;
    }

    function getText() {
        return $this->text;
    }
    
    function getCreationDate() {
        return $this->creationDate;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setText($text) {
        if (strlen($text) < 141) {
            $this->text = $text;
        } else {
            return false;
        }
    }

    function setCreationDate() {
        $date = date('Y-m-d H:i:s');
        $this->creationDate = $date;
    }
 /**
  * 
  * @param PDO $conn
  * @param type $id
  * @return \Tweet|boolean
  */
    static public function loadTweetById(PDO $conn, $id) {

        $sql = "SELECT * FROM `Tweet` WHERE `id` = :id;";
        try {
            $query = $conn->prepare($sql);
            $result = $query->execute([
                'id' => $id,
            ]);

            if ($result === true && $query->rowCount() > 0) {
                $row = $query->fetch();

                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId = $row['userId'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->creationDate = $row['creationDate'];

                return $loadedTweet;
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
     * @param type $userId
     * @return \Tweet|boolean
     */
    static public function loadTweetByUserId(PDO $conn, $userId) {

        $sql = "SELECT * FROM `Tweet` WHERE `userId` = :userId;";
        try {
            $query = $conn->prepare($sql);
            $result = $query->execute([
                'userId' => $userId,
            ]);

            if ($result === true && $query->rowCount() > 0) {
                $rows = $query->fetchAll();

                foreach ($rows as $row) {
                    $loadedTweet = new Tweet();
                    $loadedTweet->id = $row['id'];
                    $loadedTweet->userId = $row['userId'];
                    $loadedTweet->text = $row['text'];
                    $loadedTweet->creationDate = $row['creationDate'];
                    
                    $tweets[] = $loadedTweet;

                }

                return $tweets;
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
     * @return array of objects if succeed
     */
    static public function loadAllTweets(PDO $conn) {
        $sql = "SELECT * FROM `Tweet`;";
        $tweets = [];
        try {
            $result = $conn->query($sql);
            if ($result !== false && $result->rowCount() != 0) {
                $rows = $result->fetchAll();
                
                foreach ($rows as $row) {
                    $loadedTweet = new Tweet();
                    $loadedTweet->id = $row['id'];
                    $loadedTweet->userId = $row['userId'];
                    $loadedTweet->text = $row['text'];
                    $loadedTweet->creationDate = $row['creationDate'];

                    $tweets[] = $loadedTweet;
                }
            }

            return $tweets;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    /**
     * 
     * @param PDO $conn
     * @return boolean
     */
    public function saveToDB(PDO $conn) {
        if ($this->id == -1) {
            $sql = 'INSERT INTO `Tweet`(`userId`, `text`, `creationDate`) VALUES (:userId, :text, :creationDate);';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'userId' => $this->userId,
                'text' => $this->text,
                'creationDate' => $this->creationDate
            ]);
            if ($result !== false) {
                $this->id = $conn->lastInsertId();

                return true;
            }
        } else {
            $sql = "UPDATE `Tweet` SET `text` = :text WHERE `id` = :id;";
            try {
                $query = $conn->prepare($sql);
                $result = $query->execute([
                    'text' => $this->text,
                    'id' => $this->id,
                ]);

                return $result;
            } catch (PDOException $ex) {
                echo $ex->getMessage() . '<hr>';
                return false;
            }
        }
    }
    
    
    
    
    
    
    
    
}