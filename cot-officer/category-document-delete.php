<?php
require_once "../config/db.php";
header('Content-Type: application/json');
$Categories = new Categories;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user']) && $_SESSION['user']['user_role'] == 'admin') {
    $document_id = $_POST['document_id'];
    // check if the document exists
    $document = $Categories->getDocumentById($document_id);

    if ($document) {
        // delete the document
        $delete = $Categories->deleteDocument($document_id);
        if ($delete) {
            if (file_exists('../assets/dist/documents/' . $document['document_file'])) {
                // delete the file
                unlink('../assets/dist/documents/' . $document['document_file']);
            }
            echo json_encode(['status' => 'success', 'message' => 'Document deleted successfully']);
            $target = '1116700813';
            send_whatsapp($target, 'Hello ' . $_SESSION['user']['user_name'] . ', you have successfully deleted a document from ' . SITE_NAME . ' at ' . date('d F Y, h:i A') . '.');
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete document']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Document not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
}
