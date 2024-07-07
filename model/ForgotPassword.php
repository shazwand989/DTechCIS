<?php
class ForgotPassword extends Database
{
    public function __construct()
    {
        $this->getConnection();
    }

    public function createForgotPassword($data)
    {
        return $this->create('forgot_password', $data);
    }

    public function getForgotPasswords()
    {
        return $this->read('forgot_password');
    }

    public function getForgotPasswordById($forgotPasswordId)
    {
        $conditions = "forgot_password_id = :forgot_password_id";
        $sql = "SELECT * FROM forgot_password WHERE $conditions";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':forgot_password_id', $forgotPasswordId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateForgotPassword($forgotPasswordId, $data)
    {
        $conditions = "forgot_password_id = :forgot_password_id";
        $data['forgot_password_id'] = $forgotPasswordId;
        return $this->update('forgot_password', $data, $conditions);
    }

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
