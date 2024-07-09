<?php
class ForgotPassword extends Database
{
    // Constructor to establish the database connection
    public function __construct()
    {
        $this->getConnection();
    }

    // Method to create a new forgot password record
    public function createForgotPassword($data)
    {
        return $this->create('forgot_password', $data);
    }

    // Method to get all forgot password records
    public function getForgotPasswords()
    {
        return $this->read('forgot_password');
    }

    // Method to get a forgot password record by its ID
    public function getForgotPasswordById($forgotPasswordId)
    {
        $conditions = "forgot_password_id = :forgot_password_id";
        $sql = "SELECT * FROM forgot_password WHERE $conditions";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':forgot_password_id', $forgotPasswordId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to get a forgot password record by its token
    public function getForgotPasswordByToken($token)
    {
        $conditions = "forgot_password_token = :forgot_password_token";
        $conditions .= " AND forgot_password_status = '1'";
        $sql = "SELECT * FROM forgot_password WHERE $conditions";
        $sql .= " AND forgot_password_created_at >= DATE_SUB(NOW(), INTERVAL 15 MINUTE)";
        $sql .= " ORDER BY forgot_password_created_at DESC LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':forgot_password_token', $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to update a forgot password record by its ID
    public function updateForgotPassword($forgotPasswordId, $data)
    {
        $conditions = "forgot_password_id = :forgot_password_id";
        $data['forgot_password_id'] = $forgotPasswordId;
        return $this->update('forgot_password', $data, $conditions);
    }

    // Method to delete a forgot password record by its ID
    public function deleteForgotPassword($forgotPasswordId)
    {
        $conditions = "forgot_password_id = :forgot_password_id";
        $sql = "DELETE FROM forgot_password WHERE $conditions";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':forgot_password_id', $forgotPasswordId);
        $stmt->execute();
        return true;
    }
}
