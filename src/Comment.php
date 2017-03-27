<?php

require_once '../connection.php';

class Comment {

    private $id, $userId, $postId, $creationDate, $text;

    public function __construct() {
        $this->id = -1;
        $this->userId = "";
        $this->postId = "";
        $this->creationDate = "";
        $this->text = "";
    }

    function getId() {
        return $this->id;
    }

    function getUserId() {
        return $this->userId;
    }

    function getPostId() {
        return $this->postId;
    }

    function getCreationDate() {
        return $this->creationDate;
    }

    function getText() {
        return $this->text;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setPostId($postId) {
        $this->postId = $postId;
    }

    function setCreationDate() {
        $date = date('Y-m-d H:i:s');
        $this->creationDate = $date;
    }

    function setText($text) {
        if (strlen($text) < 61) {
            $this->text = $text;
        } else {
            return false;
        }
    }
/**
 * 
 * @param PDO $conn
 * @param type $id
 * @return boolean|\Comment
 */
    static public function loadCommentById(PDO $conn, $id) {

        $sql = "SELECT * FROM `Comment` WHERE `id` = :id;";
        try {
            $query = $conn->prepare($sql);
            $result = $query->execute([
                'id' => $id,
            ]);

            if ($result === true && $query->rowCount() > 0) {
                $row = $query->fetch();

                $loadedComment = new Comment();
                $loadedComment->id = $row['id'];
                $loadedComment->userId = $row['userId'];
                $loadedComment->postId = $row['postId'];
                $loadedComment->creationDate = $row['creationDate'];
                $loadedComment->text = $row['text'];

                return $loadedComment;
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
 * @param type $postId
 * @return \Comment
 */
    static public function loadAllCommentsByPostId(PDO $conn, $postId) {
        $sql = "SELECT * FROM `Comment` WHERE `postId` = :postId;";
        $comments = [];
        try {
            $query = $conn->prepare($sql);
            $result = $query->execute([
                'postId' => $postId,
            ]);
            
            $rows = $query->fetchAll();

                foreach ($rows as $row) {
                    $loadedComment = new Comment();
                    $loadedComment->id = $row['id'];
                    $loadedComment->userId = $row['userId'];
                    $loadedComment->postId = $row['postId'];
                    $loadedComment->text = $row['text'];
                    $loadedComment->creationDate = $row['creationDate'];

                    $comments[] = $loadedComment;
                }

            return $comments;
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
            $sql = 'INSERT INTO `Comment`(`userId`, `postId`, `text`, `creationDate`) VALUES (:userId, :postId, :text, :creationDate);';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'userId' => $this->userId,
                'postId' => $this->postId,
                'text' => $this->text,
                'creationDate' => $this->creationDate
            ]);
            if ($result !== false) {
                $this->id = $conn->lastInsertId();

                return true;
            }
        } else {
            $sql = "UPDATE `Comment` SET `text` = :text WHERE `id` = :id;";
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
    
    public function delete(PDO $conn) {
        if ($this->id != -1) {
            $sql = "DELETE FROM `Comment` WHERE `id` = :id;";

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
