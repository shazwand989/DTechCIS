<?php $title = "Categories"; ?>
<?php include_once "layout/header.php"; ?>
<?php
$categories = new Categories();

if (isset($_GET['category_id']) && isset($_GET['category_sub_id'])) {
    $id = $_GET['category_id'];
    $category = $categories->getCategoryById($id);

    $subId = $_GET['category_sub_id'];
    $subCategory = $categories->getSubCategoryById($subId);
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
                                <!-- dropdown year -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-calendar-alt"></i> Year
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">2021</a>
                                        <a class="dropdown-item" href="#">2020</a>
                                        <a class="dropdown-item" href="#">2019</a>
                                    </div>
                                </div>
                                <a href="category-document-form.php?id=<?= $category['category_id'] ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add Document</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?= display_flash_message(); ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="table-default2">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th>File</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($categories->getDocumentsByCategorySubId($subId) as $key => $document) : ?>
                                            <tr>
                                                <td><?= $key + 1 ?></td>
                                                <td><?= $document['document_title'] ?></td>
                                                <td><?= $document['document_description'] ?></td>
                                                <td><?= $document['document_date'] ?></td>
                                                <td>
                                                    <a href="<?= base_url('uploads/' . $document['document_file']) ?>" target="_blank">
                                                        <?= $document['document_file'] ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="category-document-form.php?id=<?= $category['category_id'] ?>&sub_id=<?= $subCategory['category_sub_id'] ?>&document_id=<?= $document['document_id'] ?>" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <a href="category-document-delete.php?id=<?= $document['document_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this document?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
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
<?php include_once "layout/footer.php"; ?>