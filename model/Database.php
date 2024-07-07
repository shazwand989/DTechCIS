<?php
class Database
{
    private $host = DB_SERVER;
    private $db_name = DB_DATABASE;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    protected $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

    public function create($table, $data)
    {
        try {
            $fields = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));
            $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            return true;
        } catch (PDOException $exception) {
            echo "Create error: " . $exception->getMessage();
            return false;
        }
    }

    public function read($table, $conditions = "")
    {
        try {
            $sql = "SELECT * FROM $table";
            if ($conditions) {
                $sql .= " WHERE $conditions";
            }
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Read error: " . $exception->getMessage();
            return false;
        }
    }

    public function update($table, $data, $conditions)
    {
        try {
            $set = "";
            foreach ($data as $key => $value) {
                $set .= "$key = :$key, ";
            }
            $set = rtrim($set, ", ");
            $sql = "UPDATE $table SET $set WHERE $conditions";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            return true;
        } catch (PDOException $exception) {
            echo "Update error: " . $exception->getMessage();
            return false;
        }
    }

    public function delete($table, $conditions)
    {
        try {
            $sql = "DELETE FROM $table WHERE $conditions";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return true;
        } catch (PDOException $exception) {
            echo "Delete error: " . $exception->getMessage();
            return false;
        }
    }
}
