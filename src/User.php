<?php

require_once '../connection.php';

class User {

    private $id, $username, $hashPass, $email;

    public function __construct() {
        $this->id = -1;
        $this->username = "";
        $this->hashPass = "";
        $this->email = "";
    }

    function getUsername() {
        return $this->username;
    }

    function getHashPass() {
        return $this->hashPass;
    }

    function getEmail() {
        return $this->email;
    }

    function getId() {
        return $this->id;
    }
    /**
     * 
     * @param type $username //string
     * @return boolean|\User
     */
    function setUsername($username) {
        if ((ctype_alnum($username)) && (!ctype_digit($username))) {
            if ((strlen($username) > 3) && (strlen($username) < 15)) {
                $this->username = $username;

                return $this;
            }
        }

        return false;
    }
/**
 * 
 * @param type $password //string
 * @return boolean|\User
 */
    function setHashPass($password) {
        if (strlen($password) < 8 || strlen($password) > 20) {

            return false;
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $this->hashPass = $hashedPassword;

            return $this;
        }
    }

    function passwordVerify($password) {
        if (password_verify($password, $this->hashPass)) {
            return true;
        }
    }
/**
 * 
 * @param type $email //string
 * @return boolean|\User
 */
    function setEmail($email) {
        $emailToSave = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (filter_var($emailToSave, FILTER_VALIDATE_EMAIL) == false || ($emailToSave != $email)) {

            return false;
        } else {
            $this->email = $emailToSave;

            return $this;
        }
    }
/**
 * 
 * @param PDO $conn
 * @return boolean
 */
    public function saveToDB(PDO $conn) {
        if ($this->id == -1) {
            $sql = 'INSERT INTO `User`(`username`, `email`, `hashPass`) VALUES (:username, :email, :pass);';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'username' => $this->username,
                'email' => $this->email,
                'pass' => $this->hashPass
            ]);
            if ($result !== false) {
                $this->id = $conn->lastInsertId();

                return true;
            }
        } else {
            $sql = "UPDATE `User` SET `username` = :username, `email` = :email, `hashPass` = :hashPass WHERE `id` = :id;";
            try {
                $query = $conn->prepare($sql);
                $result = $query->execute([
                    'username' => $this->username,
                    'email' => $this->email,
                    'hashPass' => $this->hashPass,
                    'id' => $this->id,
                ]);

                return $result;
            } catch (PDOException $ex) {
                echo $ex->getMessage() . '<hr>';
                return false;
            }
        }
    }
/**
 * 
 * @param PDO $conn
 * @param type $email
 * @return boolean|\User
 */
    static public function loadUserByEmail(PDO $conn, $email) {

        $sql = "SELECT * FROM `User` WHERE `email` = :email;";
        try {
            $query = $conn->prepare($sql);
            $result = $query->execute([
                'email' => $email,
            ]);

            if ($result === true && $query->rowCount() > 0) {
                $row = $query->fetch();

                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->username = $row['username'];
                $loadedUser->hashPass = $row['hashPass'];
                $loadedUser->email = $row['email'];

                return $loadedUser;
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
     * @param type $name
     * @return boolean|\User
     */
    static public function loadUserByName(PDO $conn, $name) {

        $sql = "SELECT * FROM `User` WHERE `username` = :username;";
        try {
            $query = $conn->prepare($sql);
            $result = $query->execute([
                'username' => $name,
            ]);

            if ($result === true && $query->rowCount() > 0) {
                $row = $query->fetch();

                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->username = $row['username'];
                $loadedUser->hashPass = $row['hashPass'];
                $loadedUser->email = $row['email'];

                return $loadedUser;
            } else {

                return null;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage() . '<hr>';
            return false;
        }
    }
    
    static public function loadUserById(PDO $conn, $id) {

        $sql = "SELECT * FROM `User` WHERE `id` = :id;";
        try {
            $query = $conn->prepare($sql);
            $result = $query->execute([
                'id' => $id,
            ]);

            if ($result === true && $query->rowCount() > 0) {
                $row = $query->fetch();

                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->username = $row['username'];
                $loadedUser->hashPass = $row['hashPass'];
                $loadedUser->email = $row['email'];

                return $loadedUser;
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
 * @return \User
 */
    static public function loadAllUsers(PDO $conn) {
        $sql = "SELECT * FROM `User`;";
        $users = [];
        try {
            $result = $conn->query($sql);
            if ($result !== false && $result->rowCount() != 0) {
                foreach ($result as $row) {
                    $loadedUser = new User();
                    $loadedUser->id = $row['id'];
                    $loadedUser->username = $row['username'];
                    $loadedUser->hashPass = $row['hashPass'];
                    $loadedUser->email = $row['email'];

                    $users[] = $loadedUser;
                }
            }

            return $users;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
/**
 * 
 * @param PDO $conn
 * @return boolean
 */
    public function delete(PDO $conn) {
        if ($this->id != -1) {
            $sql = "DELETE FROM `User` WHERE `id` = :id;";

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