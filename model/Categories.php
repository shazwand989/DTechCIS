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
}
