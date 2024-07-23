<?php
require_once "../config/db.php";
header('Content-Type: application/json');
$Users = new Users;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user']) && $_SESSION['user']['user_role'] == 'admin') {
    $user_id = $_POST['id'];

    if ($user_id == $_SESSION['user']['user_id']) {
        echo json_encode(['status' => 'error', 'message' => 'You cannot delete yourself']);
        exit;
    }
    // check if the user exists
    $user = $Users->getUserById($user_id);
    if ($user) {
        // update 
        $Users->updateUser($user_id, ['user_deleted_at' => date('Y-m-d H:i:s')]);
        echo json_encode(['status' => 'success', 'message' => 'User deleted successfully', 'role' => $user['user_role']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
}
