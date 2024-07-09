<?php
class Users extends Database
{
    // Constructor method that initializes the database connection.
    public function __construct()
    {
        $this->getConnection(); // Calls the method to establish a database connection.
    }

    // Method to create a new user in the database.
    public function createUser($data)
    {
        if (isset($data['user_password'])) {
            $data['user_password'] = password_hash($data['user_password'], PASSWORD_DEFAULT); // Hashes the user's password for security.
        }
        return $this->create('users', $data); // Inserts the user data into the 'users' table.
    }

    // Method to get all users from the database.
    public function getUsers()
    {
        return $this->read('users'); // Fetches all records from the 'users' table.
    }

    // Method to get a user by their ID.
    public function getUserById($userId)
    {
        $conditions = "user_id = :user_id AND user_deleted_at IS NULL"; // SQL conditions to find a user by ID and ensure they are not deleted.
        $sql = "SELECT * FROM users WHERE $conditions"; // SQL query to select the user.
        $stmt = $this->conn->prepare($sql); // Prepares the SQL statement.
        $stmt->bindParam(':user_id', $userId); // Binds the user ID parameter.
        $stmt->execute(); // Executes the SQL statement.
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetches the user data as an associative array.
    }

    // Method to get a user by their email.
    public function getUserByEmail($email)
    {
        $conditions = "user_email = :user_email AND user_deleted_at IS NULL"; // SQL conditions to find a user by email and ensure they are not deleted.
        $sql = "SELECT * FROM users WHERE $conditions"; // SQL query to select the user.
        $stmt = $this->conn->prepare($sql); // Prepares the SQL statement.
        $stmt->bindParam(':user_email', $email); // Binds the email parameter.
        $stmt->execute(); // Executes the SQL statement.
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetches the user data as an associative array.
    }

    // Method to get a user by their username.
    public function getUserByUsername($username)
    {
        $conditions = "user_username = :user_name AND user_deleted_at IS NULL"; // SQL conditions to find a user by username and ensure they are not deleted.
        $sql = "SELECT * FROM users WHERE $conditions"; // SQL query to select the user.
        $stmt = $this->conn->prepare($sql); // Prepares the SQL statement.
        $stmt->bindParam(':user_name', $username); // Binds the username parameter.
        $stmt->execute(); // Executes the SQL statement.
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetches the user data as an associative array.
    }

    // Method to get a user by their phone number.
    public function getUserByPhone($phone)
    {
        $conditions = "user_phone = :user_phone AND user_deleted_at IS NULL"; // SQL conditions to find a user by phone number and ensure they are not deleted.
        $sql = "SELECT * FROM users WHERE $conditions"; // SQL query to select the user.
        $stmt = $this->conn->prepare($sql); // Prepares the SQL statement.
        $stmt->bindParam(':user_phone', $phone); // Binds the phone number parameter.
        $stmt->execute(); // Executes the SQL statement.
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetches the user data as an associative array.
    }

    // Method to get users by their role.
    public function getUserByRole($role)
    {
        $conditions = "user_role = :user_role AND user_deleted_at IS NULL"; // SQL conditions to find users by role and ensure they are not deleted.
        $sql = "SELECT * FROM users WHERE $conditions"; // SQL query to select the users.
        $stmt = $this->conn->prepare($sql); // Prepares the SQL statement.
        $stmt->bindParam(':user_role', $role); // Binds the role parameter.
        $stmt->execute(); // Executes the SQL statement.
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetches all user data as an associative array.
    }

    // Method to update user information.
    public function updateUser($userId, $data)
    {
        if (isset($data['user_password'])) {
            $data['user_password'] = password_hash($data['user_password'], PASSWORD_DEFAULT); // Hashes the new password if provided.
        }
        $conditions = "user_id = :user_id"; // SQL condition to find the user by ID.
        $data['user_id'] = $userId; // Adds the user ID to the data array.
        return $this->update('users', $data, $conditions); // Updates the user data in the 'users' table.
    }

    // Method to delete a user by their ID.
    public function deleteUser($userId)
    {
        $conditions = "user_id = :user_id"; // SQL condition to find the user by ID.
        $sql = "DELETE FROM users WHERE $conditions"; // SQL query to delete the user.
        $stmt = $this->conn->prepare($sql); // Prepares the SQL statement.
        $stmt->bindParam(':user_id', $userId); // Binds the user ID parameter.
        $stmt->execute(); // Executes the SQL statement.
        return true; // Returns true if the user was deleted.
    }

    // Method to count the number of users with a specific role.
    public function countUsers($role)
    {
        $conditions = "user_role = :user_role AND user_deleted_at IS NULL"; // SQL conditions to count users by role and ensure they are not deleted.
        $sql = "SELECT COUNT(*) FROM users WHERE $conditions"; // SQL query to count the users.
        $stmt = $this->conn->prepare($sql); // Prepares the SQL statement.
        $stmt->bindParam(':user_role', $role); // Binds the role parameter.
        $stmt->execute(); // Executes the SQL statement.
        return $stmt->fetchColumn(); // Returns the count of users.
    }
}
