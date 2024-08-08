<?php $title = "Categories"; ?>
<?php include_once "layout/header.php"; ?>
<?php $categories = new Categories(); ?>
<?php
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
    $category = $categories->getCategoryById($category_id);
    if (!$category) {
        set_flash_message("Category not found", "danger");
        redirect("category-list.php");
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];

    if (empty($category_name)) {
        $errors['category_name'] = "Category name is required";
    }

    if (empty($errors['category_name'])) {

        $data = [
            'category_name' => $category_name
        ];
        if (isset($category_id)) {
            if ($categories->updateCategory($category_id, $data)) {
                set_flash_message("Category updated successfully", "success");
                redirect("category-list.php");
            } else {
                set_flash_message("Failed to update category", "danger");
            }
        } elseif ($categories->createCategory($data)) {
            set_flash_message("Category added successfully", "success");
            redirect("category-list.php");
        } else {
            set_flash_message("Failed to add category", "danger");
        }
    }
}

?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <?= $title ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
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
                                <?= $title ?> Form
                            </h4>
                            <div class="card-tools">
                                <a href="category-list.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?= display_flash_message(); ?>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="category_name">Category Name</label>
                                    <input type="text" name="category_name" id="category_name" class="form-control <?= $errors['category_name'] ? 'is-invalid' : '' ?>" value="<?= $category['category_name'] ?? '' ?>">
                                    <div class="invalid-feedback"><?= $errors['category_name']  ?? '' ?></div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
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