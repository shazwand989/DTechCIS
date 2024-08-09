<?php $title = "Categories"; ?>
<?php include_once "layout/header.php"; ?>
<?php $categories = new Categories(); ?>
<?php
if (isset($_GET['category'])) {
    $category_id = $_GET['category'];
    $category = $categories->getCategoryById($category_id);

    if (!$category) {
        set_flash_message("Category not found", "danger");
        redirect("category-list.php");
    }
}
?>
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <?= $category['category_name'] ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="category-list.php">Categories</a></li>
                        <li class="breadcrumb-item active"><?= $category['category_name'] ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <?php if ($category['category_id'] == '1') : ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <?= $title ?> List
                                </h4>
                                <div class="card-tools">
                                    <a href="category-information-form.php?category=<?= $category['category_id'] ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add <?= $category['category_name'] ?></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <?= display_flash_message(); ?>
                                <div class="table-responsive">
                                    <table id="table-default2" class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">#</th>
                                                <th>Project Title</th>
                                                <th>Collaborating Partners</th>
                                                <th>Scope (R & I, T & L)</th>
                                                <th>Time Frame (Start Date - End Date)</th>
                                                <th>Status</th>
                                                <th>Benefit / Outcome / Impact</th>
                                                <th>Issues / Challenges / Lesson Learned</th>
                                                <th>Income Generated (Monetary Value) (RM)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $collaborations = new Collaborations(); ?>
                                            <?php foreach ($collaborations->getCollaborations() as $key => $collaboration) : ?>
                                                <tr>
                                                    <td><?= $key + 1 ?></td>
                                                    <td><?= $collaboration['collaboration_project_title'] ?></td>
                                                    <td><?= nl2br($collaboration['collaboration_collaborating_partners']) ?></td>
                                                    <td><?= $collaboration['collaboration_scope'] ?></td>
                                                    <td><?= $collaboration['collaboration_start_date'] . " - " . $collaboration['collaboration_end_date'] ?></td>
                                                    <td><?= $collaboration['collaboration_status'] ?></td>
                                                    <td><?= nl2br($collaboration['collaboration_benefit_outcome_impact']) ?></td>
                                                    <td><?= nl2br($collaboration['collaboration_issues_challenges_lesson_learned']) ?></td>
                                                    <td><?= $collaboration['collaboration_income_generated'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php include_once "layout/footer.php"; ?>