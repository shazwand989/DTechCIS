<?php
require_once "../config/db.php";
header('Content-Type: application/json');
$category = new Categories;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user']) && $_SESSION['user']['user_role'] == 'admin') {
    $category_sub_id = $_POST['id'];
    $category_sub = $category->getSubCategoryById($category_sub_id);
    if ($category_sub) {
        try {
            $category->deleteSubCategory($category_sub_id);
            echo json_encode(['status' => 'success', 'message' => 'Sub category deleted successfully', 'category_id' => $category_sub['category_sub_category_id']]);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete sub category.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Sub category not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
}
