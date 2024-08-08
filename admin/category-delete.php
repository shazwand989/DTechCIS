<?php
require_once "../config/db.php";
header('Content-Type: application/json');
$Categories = new Categories;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user']) && $_SESSION['user']['user_role'] == 'admin') {
    $category_id = $_POST['category_id'];

    // check if the category exists
    $category = $Categories->getCategoryById($category_id);

    if ($category) {
        // delete the category
        $delete = $Categories->deleteCategory($category_id);
        if ($delete) {
            echo json_encode(['status' => 'success', 'message' => 'Category deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete category']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Category not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
}
