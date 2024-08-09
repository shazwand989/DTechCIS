<?php
class Collaborations extends Database
{
    // Constructor method that initializes the database connection.
    public function __construct()
    {
        $this->getConnection(); // Calls the method to establish a database connection.
    }

    // Method to get all collaborations from the database.
    public function getCollaborations()
    {
        return $this->read('collaborations'); // Fetches all records from the 'collaborations' table.
    }

    // Method to get a collaboration by its ID.
    public function getCollaborationById($collaborationId)
    {

        $conditions = "collaboration_id = :collaboration_id"; // SQL conditions to find a collaboration by ID.
        $sql = "SELECT * FROM collaborations WHERE $conditions"; // SQL query to select the collaboration.
        $stmt = $this->conn->prepare($sql); // Prepares the SQL statement.
        $stmt->bindParam(':collaboration_id', $collaborationId); // Binds the collaboration ID parameter.
        $stmt->execute(); // Executes the SQL statement.
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetches the collaboration data as an associative array.
    }

    // Method to create a new collaboration in the database.
    public function createCollaboration($data)
    {
        return $this->create('collaborations', $data); // Inserts the collaboration data into the 'collaborations' table.
    }

    // Method to update a collaboration in the database.
    public function updateCollaboration($id, $data)
    {
        $conditions = "collaboration_id = :collaboration_id"; // SQL conditions to find a collaboration by ID.
        $data['collaboration_id'] = $id; // Adds the collaboration ID to the data array.
        return $this->update('collaborations', $data, $conditions); // Updates the collaboration data in the 'collaborations' table.
    }

    // Method to delete a collaboration from the database.
    public function deleteCollaboration($collaborationId)
    {
        $conditions = "collaboration_id = " . $collaborationId; // SQL conditions to find a collaboration by ID.
        return $this->delete('collaborations', $conditions); // Deletes the collaboration data from the 'collaborations' table.
    }
}
