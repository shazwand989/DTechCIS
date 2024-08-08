<?php $title = "Categories"; ?>
<?php include_once "layout/header.php"; ?>
<?php
$categories = new Categories();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $category = $categories->getCategoryById($id);
    if (!$category) {
        set_flash_message('Category not found.', 'danger');
        redirect('category-list.php');
    }
    $subCategories = $categories->getSubCategories($category['category_id']);
} else {
    set_flash_message('Category not found.', 'danger');
    redirect('category-list.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = $_POST['category_id'];
    $sub_category_name = $_POST['sub_category_name'];

    $dataSubCategory = [
        'category_sub_name' => $sub_category_name,
        'category_sub_category_id' => $category_id
    ];
    if (isset($_POST['category_sub_id']) && $_POST['category_sub_id'] > 0) {
        $category_sub_id = $_POST['category_sub_id'];
        $categories->updateSubCategory($category_sub_id, $dataSubCategory);
        set_flash_message('Sub category updated successfully.', 'success');
        redirect('category-detail.php?id=' . $category_id);
    }

    $categories->createSubCategory($dataSubCategory);

    set_flash_message('Sub category added successfully.', 'success');
    redirect('category-detail.php?id=' . $category_id);
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
                        <li class="breadcrumb-item active"><?= $category['category_name'] ?> Detail</li>
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
                                <!-- modal category sub -->
                                <button type="button" class="btn btn-primary" onclick="categorySubEdit(0, '')">
                                    <i class="fas fa-plus"></i> Add Sub Category
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?= display_flash_message(); ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="table-default2">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Sub Category Name</th>
                                            <th width="20%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($subCategories as $key => $subCategory) : ?>
                                            <tr>
                                                <td><?= $key + 1 ?></td>
                                                <td><?= $subCategory['category_sub_name'] ?></td>
                                                <td>
                                                    <a href="category-document.php?category_id=<?= $category['category_id'] ?>&category_sub_id=<?= $subCategory['category_sub_id'] ?>&year=<?= date('Y') ?>" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-primary" onclick="categorySubEdit(<?= $subCategory['category_sub_id'] ?>, '<?= $subCategory['category_sub_name'] ?>')">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteCategorySub(<?= $subCategory['category_sub_id'] ?>)">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modal-category-sub" tabindex="-1" role="dialog" aria-labelledby="modal-category-sub" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header">
                    <h5 class="modal-title"><span id="modal-title">Add</span> Sub Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="category_id" id="category_id" value="<?= $category['category_id'] ?>">
                    <input type="hidden" name="category_sub_id" id="category_sub_id" value="0">
                    <div class="form-group">
                        <label for="sub_category_name">Sub Category Name</label>
                        <input type="text" name="sub_category_name" id="sub_category_name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once "layout/footer.php"; ?>