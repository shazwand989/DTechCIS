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

    if ($category['category_id'] == '1') {
        $collaborations = new Collaborations();

        if (isset($_GET['collaboration'])) {
            $collaboration_id = $_GET['id'];
            $collaboration = $collaborations->getCollaborationById($collaboration_id);
        }

        // CREATE TABLE IF NOT EXISTS `collaborations` (
        //     `collaboration_id` int(11) NOT NULL AUTO_INCREMENT,
        //     `collaboration_project_title` varchar(255) NOT NULL,
        //     `collaboration_collaborating_partners` varchar(255) NOT NULL,
        //     `collaboration_scope` varchar(255) NOT NULL,
        //     `collaboration_start_date` date NOT NULL,
        //     `collaboration_end_date` date NOT NULL,
        //     `collaboration_status` varchar(255) NOT NULL,
        //     `collaboration_benefit_outcome_impact` text NOT NULL,
        //     `collaboration_issues_challenges_lesson_learned` text NOT NULL,
        //     `collaboration_income_generated` decimal(10, 2) NOT NULL,
        //     `collaboration_user_id` int(11) NULL,
        //     `collaboration_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        //     `collaboration_updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        //     PRIMARY KEY (`collaboration_id`),
        //     FOREIGN KEY (`collaboration_user_id`) REFERENCES `users`(`user_id`)
        // );

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'collaboration_project_title' => trim($_POST['collaboration_project_title']),
                'collaboration_collaborating_partners' => trim($_POST['collaboration_collaborating_partners']),
                'collaboration_scope' => trim($_POST['collaboration_scope']),
                'collaboration_start_date' => trim($_POST['collaboration_start_date']),
                'collaboration_end_date' => trim($_POST['collaboration_end_date']),
                'collaboration_status' => trim($_POST['collaboration_status']),
                'collaboration_benefit_outcome_impact' => trim($_POST['collaboration_benefit_outcome_impact']),
                'collaboration_issues_challenges_lesson_learned' => trim($_POST['collaboration_issues_challenges_lesson_learned']),
                'collaboration_income_generated' => trim($_POST['collaboration_income_generated']),
            ];

            if (empty($data['collaboration_project_title'])) {
                $errors['collaboration_project_title'] = 'Project Title is required';
            }

            if (empty($data['collaboration_collaborating_partners'])) {
                $errors['collaboration_collaborating_partners'] = 'Collaborating Partners is required';
            }

            if (empty($data['collaboration_scope'])) {
                $errors['collaboration_scope'] = 'Scope is required';
            }

            if (empty($data['collaboration_start_date'])) {
                $errors['collaboration_start_date'] = 'Start Date is required';
            }

            if (empty($data['collaboration_end_date'])) {
                $errors['collaboration_end_date'] = 'End Date is required';
            }

            if (empty($data['collaboration_status'])) {
                $errors['collaboration_status'] = 'Status is required';
            }

            if (empty($data['collaboration_benefit_outcome_impact'])) {
                $errors['collaboration_benefit_outcome_impact'] = 'Benefit, Outcome, Impact is required';
            }

            if (empty($data['collaboration_issues_challenges_lesson_learned'])) {
                $errors['collaboration_issues_challenges_lesson_learned'] = 'Issues, Challenges, Lesson Learned is required';
            }

            if (empty($data['collaboration_income_generated'])) {
                $errors['collaboration_income_generated'] = 'Income Generated is required';
            }

            if (empty($errors)) {
                if (isset($collaboration)) {
                    $data['collaboration_id'] = $collaboration_id;
                    $collaborations->updateCollaboration($collaboration_id, $data);
                    set_flash_message("Collaboration updated successfully", "success");
                    redirect("category-information.php?category=$category_id");
                } else {
                    $collaborations->createCollaboration($data);
                    set_flash_message("Collaboration created successfully", "success");
                    redirect("category-information.php?category=$category_id");
                }
            }
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
                                    <?= $title ?> Information
                                </h4>
                                <div class="card-tools">
                                    <a href="category-information.php?category=<?= $category['category_id'] ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="collaboration_project_title">Project Title</label>
                                                <input type="text" name="collaboration_project_title" id="collaboration_project_title" class="form-control <?= $errors['collaboration_project_title'] ? 'is-invalid' : '' ?>" value="<?= $collaboration['collaboration_project_title'] ?? '' ?>">
                                                <div class="invalid-feedback"><?= $errors['collaboration_project_title'] ?></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="collaboration_collaborating_partners">Collaborating Partners</label>
                                                <textarea name="collaboration_collaborating_partners" id="collaboration_collaborating_partners" class="form-control <?= $errors['collaboration_collaborating_partners'] ? 'is-invalid' : '' ?>" rows="5"><?= $collaboration['collaboration_collaborating_partners'] ?? '' ?></textarea>
                                                <div class="invalid-feedback"><?= $errors['collaboration_collaborating_partners'] ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="collaboration_scope">Scope (R & I, T & L)</label>
                                                    <select name="collaboration_scope" id="collaboration_scope" class="form-control <?= $errors['collaboration_scope'] ? 'is-invalid' : '' ?>">
                                                        <option value="">Select Scope</option>
                                                        <option value="Research & Innovation" <?= isset($collaboration['collaboration_scope']) && $collaboration['collaboration_scope'] == 'Research & Innovation' ? 'selected' : '' ?>>Research & Innovation</option>
                                                        <option value="Teaching & Learning" <?= isset($collaboration['collaboration_scope']) && $collaboration['collaboration_scope'] == 'Teaching & Learning' ? 'selected' : '' ?>>Teaching & Learning</option>
                                                    </select>
                                                    <div class="invalid-feedback"><?= $errors['collaboration_scope'] ?></div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="collaboration_status">Status</label>
                                                    <select name="collaboration_status" id="collaboration_status" class="form-control <?= $errors['collaboration_status'] ? 'is-invalid' : '' ?>">
                                                        <option value="">Select Status</option>
                                                        <option value="Success" <?= isset($collaboration['collaboration_status']) && $collaboration['collaboration_status'] == 'Success' ? 'selected' : '' ?>>Success</option>
                                                        <option value="Pending" <?= isset($collaboration['collaboration_status']) && $collaboration['collaboration_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                        <option value="Failed" <?= isset($collaboration['collaboration_status']) && $collaboration['collaboration_status'] == 'Failed' ? 'selected' : '' ?>>Failed</option>
                                                    </select>
                                                    <div class="invalid-feedback"><?= $errors['collaboration_status'] ?></div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="collaboration_start_date">Start Date</label>
                                                    <input type="date" name="collaboration_start_date" id="collaboration_start_date" class="form-control <?= $errors['collaboration_start_date'] ? 'is-invalid' : '' ?>" value="<?= $collaboration['collaboration_start_date'] ?? '' ?>">
                                                    <div class="invalid-feedback"><?= $errors['collaboration_start_date'] ?></div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="collaboration_end_date">End Date</label>
                                                    <input type="date" name="collaboration_end_date" id="collaboration_end_date" class="form-control <?= $errors['collaboration_end_date'] ? 'is-invalid' : '' ?>" value="<?= $collaboration['collaboration_end_date'] ?? '' ?>">
                                                    <div class="invalid-feedback"><?= $errors['collaboration_end_date'] ?></div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="collaboration_benefit_outcome_impact">Benefit, Outcome, Impact</label>
                                                <textarea name="collaboration_benefit_outcome_impact" id="collaboration_benefit_outcome_impact" class="form-control <?= $errors['collaboration_benefit_outcome_impact'] ? 'is-invalid' : '' ?>" rows="5"><?= $collaboration['collaboration_benefit_outcome_impact'] ?? '' ?></textarea>
                                                <div class="invalid-feedback"><?= $errors['collaboration_benefit_outcome_impact'] ?></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="collaboration_issues_challenges_lesson_learned">Issues, Challenges, Lesson Learned</label>
                                                <textarea name="collaboration_issues_challenges_lesson_learned" id="collaboration_issues_challenges_lesson_learned" class="form-control <?= $errors['collaboration_issues_challenges_lesson_learned'] ? 'is-invalid' : '' ?>" rows="5"><?= $collaboration['collaboration_issues_challenges_lesson_learned'] ?? '' ?></textarea>
                                                <div class="invalid-feedback"><?= $errors['collaboration_issues_challenges_lesson_learned'] ?></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="collaboration_income_generated">Income Generated</label>
                                                <input type="number" name="collaboration_income_generated" id="collaboration_income_generated" class="form-control <?= $errors['collaboration_income_generated'] ? 'is-invalid' : '' ?>" value="<?= $collaboration['collaboration_income_generated'] ?? '' ?>" step="0.01">
                                                <div class="invalid-feedback"><?= $errors['collaboration_income_generated'] ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php include_once "layout/footer.php"; ?>