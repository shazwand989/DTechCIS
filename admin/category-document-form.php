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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $document_title = $_POST['document_title'];
    $document_description = $_POST['document_description'];
    $document_date = $_POST['document_date'];
    $document_file = $_FILES['document_file'];

    $document_file_name = upload_file($document_file, 'documents');

    $dataDocument = [
        'document_title' => $document_title,
        'document_description' => $document_description,
        'document_date' => $document_date,
        'document_file' => $document_file_name,
        'document_user_id' => $_SESSION['user_id'],
        'document_category_sub_id' => $category_sub_id
    ];

    $categories->createDocument($dataDocument);

    set_flash_message('Document added successfully.', 'success');
    redirect('category-detail.php?id=' . $category_id);
}

function upload_file($file, $folder)
{
    $file_name = $file['name'];
    $file_size = $file['size'];
    $file_tmp = $file['tmp_name'];
    $file_type = $file['type'];
    $file_ext = strtolower(end(explode('.', $file_name)));

    $extensions = ['jpeg', 'jpg', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];
    if (in_array($file_ext, $extensions) === false) {
        return set_flash_message('Extension not allowed, please choose a JPEG, JPG, PNG, PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX file.', 'danger');
    }

    if ($file_size > 2097152) {
        set_flash_message('File size must be less than 2 MB.', 'danger');
        redirect('category-document-form.php?category_id=' . $category_id . '&category_sub_id=' . $category_sub_id);
    }

    $new_file_name = uniqid() . '.' . $file_ext;
    $upload_path = 'uploads/' . $folder . '/' . $new_file_name;
    move_uploaded_file($file_tmp, $upload_path);

    return $new_file_name;
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
                                <a href="category-list.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?= display_flash_message(); ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="document_title">Document Title</label>
                                    <input type="text" name="document_title" id="document_title" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="document_description">Document Description</label>
                                    <textarea name="document_description" id="document_description" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="document_date">Document Date</label>
                                    <input type="date" name="document_date" id="document_date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="document_file">Document File</label>
                                    <input type="file" name="document_file" id="document_file" class="form-control" required>
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