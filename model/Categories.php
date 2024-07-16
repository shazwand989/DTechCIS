<?php
class Categories extends Database
{
    // Constructor method that initializes the database connection.
    public function __construct()
    {
        $this->getConnection(); // Calls the method to establish a database connection.
    }

    // Method to get all categories from the database.
    public function getCategories()
    {
        return $this->read('categories'); // Fetches all records from the 'categories' table.
    }

    // Method to get a category by its ID.
    public function getCategoryById($categoryId)
    {

        $conditions = "category_id = :category_id"; // SQL conditions to find a category by ID.
        $sql = "SELECT * FROM categories WHERE $conditions"; // SQL query to select the category.
        $stmt = $this->conn->prepare($sql); // Prepares the SQL statement.
        $stmt->bindParam(':category_id', $categoryId); // Binds the category ID parameter.
        $stmt->execute(); // Executes the SQL statement.
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetches the category data as an associative array.
    }

    // Method to create a new category in the database.
    public function createCategory($data)
    {
        return $this->create('categories', $data); // Inserts the category data into the 'categories' table.
    }

    // Method to update a category in the database.
    public function updateCategory($id, $data)
    {
        $conditions = "category_id = :category_id"; // SQL conditions to find a category by ID.
        $data['category_id'] = $id; // Adds the category ID to the data array.
        return $this->update('categories', $data, $conditions); // Updates the category data in the 'categories' table.
    }

    // Method to delete a category from the database.
    public function deleteCategory($categoryId)
    {
        $conditions = "category_id = :category_id"; // SQL conditions to find a category by ID.
        return $this->delete('categories', $conditions, $categoryId); // Deletes the category data from the 'categories' table.
    }

    // Method to get all sub categories from the database.
    public function getSubCategories()
    {
        return $this->read('categories_sub'); // Fetches all records from the 'categories_sub' table.
    }

    // Method to get a sub category by its ID.
    public function getSubCategoryById($subCategoryId)
    {
        $conditions = "category_sub_id = :category_sub_id"; // SQL conditions to find a sub category by ID.
        $sql = "SELECT * FROM categories_sub WHERE $conditions"; // SQL query to select the sub category.
        $stmt = $this->conn->prepare($sql); // Prepares the SQL statement.
        $stmt->bindParam(':category_sub_id', $subCategoryId); // Binds the sub category ID parameter.
        $stmt->execute(); // Executes the SQL statement.
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetches the sub category data as an associative array.
    }

    // Method to create a new sub category in the database.
    public function createSubCategory($data)
    {
        return $this->create('categories_sub', $data); // Inserts the sub category data into the 'categories_sub' table.
    }

    // Method to update a sub category in the database.
    public function updateSubCategory($id, $data)
    {
        $conditions = "category_sub_id = :category_sub_id"; // SQL conditions to find a sub category by ID.
        $data['category_sub_id'] = $id; // Adds the sub category ID to the data array.
        return $this->update('categories_sub', $data, $conditions); // Updates the sub category data in the 'categories_sub' table.
    }

    // Method to delete a sub category from the database.
    public function deleteSubCategory($subCategoryId)
    {
        $conditions = "category_sub_id = :category_sub_id"; // SQL conditions to find a sub category by ID.
        return $this->delete('categories_sub', $conditions, $subCategoryId); // Deletes the sub category data from the 'categories_sub' table.
    }

    // Method to get all sub categories by category ID.
    public function getSubCategoriesByCategoryId($categoryId)
    {
        $conditions = "category_sub_category_id = :category_sub_category_id"; // SQL conditions to find sub categories by category ID.
        $sql = "SELECT * FROM categories_sub WHERE $conditions"; // SQL query to select sub categories by category ID.
        $stmt = $this->conn->prepare($sql); // Prepares the SQL statement.
        $stmt->bindParam(':category_sub_category_id', $categoryId); // Binds the category ID parameter.
        $stmt->execute(); // Executes the SQL statement.
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetches the sub categories data as an associative array.
    }

    // CREATE TABLE IF NOT EXISTS `documents` (
    //     `document_id` int(11) NOT NULL AUTO_INCREMENT,
    //     `document_title` varchar(255) NOT NULL,
    //     `document_description` text NOT NULL,
    //     `document_date` date NOT NULL,
    //     `document_file` varchar(255) NOT NULL,
    //     `document_user_id` int(11) NOT NULL,
    //     `document_category_sub_id` int(11) NOT NULL,
    //     `document_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    //     `document_updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    //     PRIMARY KEY (`document_id`),
    //     FOREIGN KEY (`document_user_id`) REFERENCES `users`(`user_id`),
    //     FOREIGN KEY (`document_category_sub_id`) REFERENCES `categories_sub`(`category_sub_id`)
    // );

    // Method to get all documents from the database.
    public function getDocuments()
    {
        return $this->read('documents'); // Fetches all records from the 'documents' table.
    }

    // Method to get a document by its ID.
    public function getDocumentById($documentId)
    {
        $conditions = "document_id = :document_id"; // SQL conditions to find a document by ID.
        $sql = "SELECT * FROM documents WHERE $conditions"; // SQL query to select the document.
        $stmt = $this->conn->prepare($sql); // Prepares the SQL statement.
        $stmt->bindParam(':document_id', $documentId); // Binds the document ID parameter.
        $stmt->execute(); // Executes the SQL statement.
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetches the document data as an associative array.
    }

    // Method to get a document by its Category Sub ID.
    public function getDocumentsByCategorySubId($categorySubId)
    {
        $conditions = "document_category_sub_id = :document_category_sub_id"; // SQL conditions to find documents by Category Sub ID.
        $sql = "SELECT * FROM documents WHERE $conditions"; // SQL query to select documents by Category Sub ID.
        $stmt = $this->conn->prepare($sql); // Prepares the SQL statement.
        $stmt->bindParam(':document_category_sub_id', $categorySubId); // Binds the Category Sub ID parameter.
        $stmt->execute(); // Executes the SQL statement.
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetches the documents data as an associative array.
    }

    // Method to create a new document in the database.
    public function createDocument($data)
    {
        return $this->create('documents', $data); // Inserts the document data into the 'documents' table.
    }

    // Method to update a document in the database.
    public function updateDocument($id, $data)
    {
        $conditions = "document_id = :document_id"; // SQL conditions to find a document by ID.
        $data['document_id'] = $id; // Adds the document ID to the data array.
        return $this->update('documents', $data, $conditions); // Updates the document data in the 'documents' table.
    }

    // Method to delete a document from the database.
    public function deleteDocument($documentId)
    {
        $conditions = "document_id = :document_id"; // SQL conditions to find a document by ID.
        return $this->delete('documents', $conditions, $documentId); // Deletes the document data from the 'documents' table.
    }
}
