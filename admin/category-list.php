<?php $title = "Categories"; ?>
<?php include_once "layout/header.php"; ?>
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
                                <a href="#category-form.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Category</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?= display_flash_message(); ?>
                            <div class="table-responsive">
                                <table id="table-default1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $categories = [
                                            ['id' => 1, 'name' => 'Collaboration'],
                                            ['id' => 2, 'name' => 'Research and Innovation'],
                                            ['id' => 3, 'name' => 'Expert service'],
                                            ['id' => 4, 'name' => 'Teaching and Learning'],
                                            ['id' => 5, 'name' => 'Publication'],
                                            ['id' => 6, 'name' => 'Recognition'],
                                            ['id' => 7, 'name' => 'Income generation'],
                                        ];
                                        ?>
                                        <?php foreach ($categories as $key => $category) : ?>
                                            <tr>
                                                <td><?= $key + 1 ?></td>
                                                <td><?= $category['name'] ?></td>
                                                <td style="width: 15%" class="text-center">
                                                    <a href="#category-form.php?id=<?= $category['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="#category-delete.php?id=<?= $category['id'] ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
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