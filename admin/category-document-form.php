<?php $title = "Categories"; ?>
<?php include_once "layout/header.php"; ?>
<?php
$categories = new Categories();

if (isset($_GET['category_id']) && isset($_GET['category_sub_id'])) {
    $category_id = $_GET['category_id'];
    $category = $categories->getCategoryById($category_id);

    $category_sub_id = $_GET['category_sub_id'];
    $category_sub = $categories->getSubCategoryById($category_sub_id);
}

if (isset($_GET['document_id'])) {
    $document_id = $_GET['document_id'];
    $document = $categories->getDocumentById($document_id);
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
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $document_title = $_POST['document_title'];
    $document_description = $_POST['document_description'];
    $document_date = $_POST['document_date'];
    $document_file = $_FILES['document_file'];

    if (empty($document_title)) {
        $errors['document_title'] = 'Document title is required';
    }

    if (empty($document_description)) {
        $errors['document_description'] = 'Document description is required';
    }

    if (empty($document_date)) {
        $errors['document_date'] = 'Document date is required';
    }

    if (empty($document_file['name']) && !isset($document_id)) {
        $errors['document_file'] = 'Document file is required';
    }

    $dataDocument = [];
    if (isset($document_file)) {
        $document_file_name = upload_file($document_file, '../assets/dist/documents');

        if ($document_file_name['status'] == 'error') {
            set_flash_message($document_file_name['message'], 'danger');
            redirect('category-document-form.php?category_id=' . $category_id . '&category_sub_id=' . $category_sub_id);
        } else {
            $document_file_name = $document_file_name['file_name'];
        }
    } else {
        $document_file_name = $document['document_file'];
    }

    if (empty($errors)) {
        $dataDocument = [
            'document_title' => $document_title,
            'document_description' => $document_description,
            'document_date' => $document_date,
            'document_file' => $document_file_name,
            'document_user_id' => $_SESSION['user']['user_id'],
            'document_category_sub_id' => $category_sub_id
        ];

        if (isset($document_id)) {
            $dataDocument['document_updated_at'] = date('Y-m-d H:i:s');
            $categories->updateDocument($document_id, $dataDocument);

            if ($document['document_file'] != $document_file_name) {
                unlink('../assets/dist/documents/' . $document['document_file']);
            }
        } else {
            $categories->createDocument($dataDocument);
        }

        set_flash_message('Document ' . (isset($document_id) ? 'updated' : 'created') . ' successfully.', 'success');
        $target = '1116700813';
        send_whatsapp($target, 'Hello ' . $_SESSION['user']['user_name'] . ', you have successfully uploaded a document to ' . SITE_NAME . ' at ' . date('d F Y, h:i A') . '.');
        redirect('category-document.php?category_id=' . $category_id . '&category_sub_id=' . $category_sub_id . '&year=' . date('Y'));
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <?= $title ?> Detail - <?= $category['category_name'] ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="category-list.php"><?= $title ?></a></li>
                        <li class="breadcrumb-item"><a href="category-detail.php?id=<?= $category['category_id'] ?>"><?= $category['category_name'] ?> Detail</a></li>
                        <li class="breadcrumb-item active">Add <?= $category['category_name'] ?> Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                <?= $title ?> Detail - <?= $category['category_name'] ?>
                            </h4>
                            <div class="card-tools">
                                <a href="category-document.php?category_id=<?= $category['category_id'] ?>&category_sub_id=<?= $category_sub['category_sub_id'] ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?= display_flash_message(); ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="document_title">Document Title</label>
                                    <input type="text" name="document_title" id="document_title" class="form-control <?= isset($errors['document_title']) ? 'is-invalid' : '' ?>" value="<?= isset($document) ? $document['document_title'] : '' ?>">
                                    <div class="invalid-feedback"><?= $errors['document_title'] ?? '' ?></div>
                                </div>
                                <div class="form-group">
                                    <label for="document_description">Document Description</label>
                                    <textarea name="document_description" id="document_description" class="form-control <?= isset($errors['document_description']) ? 'is-invalid' : '' ?>"><?= isset($document) ? $document['document_description'] : '' ?></textarea>
                                    <div class="invalid-feedback"><?= $errors['document_description'] ?? '' ?></div>
                                </div>
                                <div class="form-group">
                                    <label for="document_date">Document Date</label>
                                    <input type="date" name="document_date" id="document_date" class="form-control <?= isset($errors['document_date']) ? 'is-invalid' : '' ?>" value="<?= isset($document) ? $document['document_date'] : '' ?>">
                                    <div class="invalid-feedback"><?= $errors['document_date'] ?? '' ?></div>
                                </div>
                                <div class="form-group">
                                    <label for="document_file">Document File</label>
                                    <input type="file" name="document_file" id="document_file" class="form-control <?= isset($errors['document_file']) ? 'is-invalid' : '' ?>">
                                    <div class="invalid-feedback"><?= $errors['document_file'] ?? '' ?></div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include_once "layout/footer.php"; ?>