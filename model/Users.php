<?php
class Users extends Database
{
    public function __construct()
    {
        $this->getConnection();
    }

    public function createUser($data)
    {
        if (isset($data['user_password'])) {
            $data['user_password'] = password_hash($data['user_password'], PASSWORD_DEFAULT);
        }
        return $this->create('users', $data);
    }

    public function getUsers()
    {
        return $this->read('users');
    }

    public function getUserById($userId)
    {
        $conditions = "user_id = :user_id";
        $sql = "SELECT * FROM users WHERE $conditions";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email)
    {
        $conditions = "user_email = :user_email";
        $sql = "SELECT * FROM users WHERE $conditions";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByUsername($username)
    {
        $conditions = "user_username = :user_name";
        $sql = "SELECT * FROM `users` WHERE $conditions";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_name', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($userId, $data)
    {
        if (isset($data['user_password'])) {
            $data['user_password'] = password_hash($data['user_password'], PASSWORD_DEFAULT);
        }
        $conditions = "user_id = :user_id";
        $data['user_id'] = $userId;
        return $this->update('users', $data, $conditions);
    }

    public function deleteUser($userId)
    {
        $conditions = "user_id = :user_id";
        $sql = "DELETE FROM users WHERE $conditions";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return true;
    }

    public function countUsers($role)
    {
        $conditions = "user_role = :user_role";
        $sql = "SELECT COUNT(*) FROM users WHERE $conditions";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_role', $role);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
