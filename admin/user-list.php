<?php $title = "Users"; ?>
<?php include_once "layout/header.php"; ?>
<?php
$users = new Users(); // Create an instance of the Users class
if (isset($_GET['role'])) { // Check if the role parameter is set in the URL
    $role = $_GET['role']; // Get the role value from the URL
    $result_user = $users->getUserByRole($role); // Retrieve users based on the specified role
}
?>
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <?php if ($role == 'admin') : ?>
                            Admin
                        <?php elseif ($role == 'cot_officer') : ?>
                            COT Officers
                        <?php elseif ($role == 'pkt_management') : ?>
                            PKT Management
                        <?php endif; ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                        <li class="breadcrumb-item active"><?= ucfirst($role) ?></li>
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
                                <?php if ($role == 'admin') : ?>
                                    Admin
                                <?php elseif ($role == 'cot_officer') : ?>
                                    COT Officers
                                <?php elseif ($role == 'pkt_management') : ?>
                                    PKT Management
                                <?php endif; ?>
                            </h4>
                            <div class="card-tools">
                                <a href="user-form.php?role=<?= $role ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add User</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?= display_flash_message(); ?>
                            <div class="table-responsive">
                                <table id="table-default1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Profile</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Join Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($result_user as $user) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td>
                                                    <?php if (file_exists("../assets/dist/img/user/" . $user['user_profile_picture']) && $user['user_profile_picture'] != NULL) : ?>
                                                        <img src="../assets/dist/img/user/<?= $user['user_profile_picture'] ?>" alt="<?= $user['user_name'] ?>" class="img-circle img-size-32 mr-2" onclick="viewImage(this)">
                                                    <?php else : ?>
                                                        <img src="../assets/dist/img/user/default.png" alt="<?= $user['user_name'] ?>" class="img-circle img-size-32 mr-2" onclick="viewImage(this)">
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $user['user_name'] ?></td>
                                                <td><?= $user['user_email'] ?></td>
                                                <td><?= $user['user_phone'] ?></td>
                                                <td><?= date('d F Y H:i', strtotime($user['user_created_at'])) ?></td>
                                                <td>
                                                    <a href="user-form.php?role=<?= $role ?>&id=<?= $user['user_id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteUser(<?= $user['user_id'] ?>)"><i class="fas fa-trash-alt"></i> Delete</button>
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