<?php $title = "Categories"; ?>
<?php include_once "layout/header.php"; ?>
<?php $categories = new Categories(); ?>
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
                                <?= $title ?>
                            </h4>
                            <div class="card-tools">
                                <!-- <a href="category-form.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Category</a> -->
                            </div>
                        </div>
                        <div class="card-body">
                            <?= display_flash_message(); ?>
                            <div class="table-responsive">
                                <table id="table-default1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th>Category Name</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($categories->getCategories() as $key => $category) : ?>
                                            <tr>
                                                <td><?= $key + 1 ?></td>
                                                <td><?= $category['category_name'] ?></td>
                                                <td style="width: 15%" class="text-center">
                                                    <a href="category-information.php?category=<?= $category['category_id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Detail</a>
                                                    <!-- <a href="category-detail.php?id=<?= $category['category_id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Detail</a> -->
                                                    <!-- <a href="category-form.php?id=<?= $category['category_id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a> -->
                                                    <!-- <button type="button" class="btn btn-danger btn-sm" onclick="deleteCategory(<?= $category['category_id'] ?>)"><i class="fas fa-trash"></i> Delete</button> -->
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