<?php
require_once(__DIR__ . '/../config/db.php');
class User extends Db
{

    public function __construct()
    {
        parent::__construct();
    }

    // methode to get number of users
    public function getNumberOfUsers()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }
    // // metohode to get user by id
    // public function getUserById($idUser)
    // {
    //     $stmt = $this->conn->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = ?");
    //     $stmt->execute([$idUser]);
    //     $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //     return $user;
    // }

    // register method
    public function register($user)
    {

        try {
            $result = $this->conn->prepare("INSERT INTO users (full_name, email,password, role) VALUES (?, ?, ?, ?)");
            $result->execute($user);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    // login method
    public function login($userData)
    {

        try {
            $result = $this->conn->prepare("SELECT * FROM users WHERE email=?");
            $result->execute([$userData[0]]);
            $user = $result->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($userData[1], $user["password"])) {
                return  $user;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // methode to get all users
    public function getAllUsers()
    {
        $resul = $this->conn->prepare("SELECT * FROM users WHERE role !='admin' AND status!='inactive' ");
        $resul->execute();

        $users = $resul->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    // methode to get inactive teachers
    public function getInactiveTeachers()
    {
        $resul = $this->conn->prepare("SELECT * FROM users WHERE role ='teacher' AND status ='inactive' ");
        $resul->execute();

        $users = $resul->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }
    // method to delete a user
    public function deleteUser($userId)
    {
        try {
            $deleteUser = $this->conn->prepare("DELETE FROM users WHERE user_id=?");
            $deleteUser->execute([$userId]);
        } catch (PDOException $e) {
            error_log("error deltting user: " . $e->getMessage());
        }
    }

    // methode to change user status
    public function setUserStatus($idUser,$newStatus)
    {
        $changeStatus = $this->conn->prepare("UPDATE users SET status=? WHERE user_id=?");
        $changeStatus->execute([$newStatus, $idUser]);
    }
}
