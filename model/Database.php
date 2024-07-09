<?php
class Database
{
    private $host = DB_SERVER; // Database server host
    private $db_name = DB_DATABASE; // Database name
    private $username = DB_USERNAME; // Database username
    private $password = DB_PASSWORD; // Database password
    protected $conn; // Database connection object

    // Method to establish a connection to the database
    public function getConnection()
    {
        $this->conn = null; // Initialize the connection as null

        try {
            // Create a new PDO instance and set error mode to exception
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            // Display connection error message
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn; // Return the connection object
    }

    // Method to create a new record in the specified table
    public function create($table, $data)
    {
        try {
            // Convert data array keys to a comma-separated string
            $fields = implode(", ", array_keys($data));
            // Create placeholders for the values
            $placeholders = ":" . implode(", :", array_keys($data));
            // Prepare the SQL statement
            $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
            $stmt = $this->conn->prepare($sql);
            // Execute the statement with the data array
            $stmt->execute($data);
            return true; // Return true if successful
        } catch (PDOException $exception) {
            // Display create error message
            echo "Create error: " . $exception->getMessage();
            return false; // Return false if an error occurs
        }
    }

    // Method to read records from the specified table with optional conditions
    public function read($table, $conditions = "")
    {
        try {
            // Prepare the base SQL statement
            $sql = "SELECT * FROM $table";
            if ($conditions) {
                // Append conditions if provided
                $sql .= " WHERE $conditions";
            }
            $stmt = $this->conn->prepare($sql);
            // Execute the statement
            $stmt->execute();
            // Fetch all records as an associative array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            // Display read error message
            echo "Read error: " . $exception->getMessage();
            return false; // Return false if an error occurs
        }
    }

    // Method to update records in the specified table with provided data and conditions
    public function update($table, $data, $conditions)
    {
        try {
            // Create the set clause for the SQL statement
            $set = "";
            foreach ($data as $key => $value) {
                $set .= "$key = :$key, ";
            }
            // Remove the trailing comma and space
            $set = rtrim($set, ", ");
            // Prepare the SQL statement
            $sql = "UPDATE $table SET $set WHERE $conditions";
            $stmt = $this->conn->prepare($sql);
            // Execute the statement with the data array
            $stmt->execute($data);
            return true; // Return true if successful
        } catch (PDOException $exception) {
            // Display update error message
            echo "Update error: " . $exception->getMessage();
            return false; // Return false if an error occurs
        }
    }

    // Method to delete records from the specified table with provided conditions
    public function delete($table, $conditions)
    {
        try {
            // Prepare the SQL statement
            $sql = "DELETE FROM $table WHERE $conditions";
            $stmt = $this->conn->prepare($sql);
            // Execute the statement
            $stmt->execute();
            return true; // Return true if successful
        } catch (PDOException $exception) {
            // Display delete error message
            echo "Delete error: " . $exception->getMessage();
            return false; // Return false if an error occurs
        }
    }
}
