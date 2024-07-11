<?php $title = 'Dashboard'; ?>
<?php include_once 'layout/header.php'; ?>
<?php
$Users = new Users();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <h1 class="mb-4">How DTechCIS Works</h1>

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="mb-0">1. Logging In</h3>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Admin, COT officers, and PKT management will each have their own login to access the system.</li>
                    </ul>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="mb-0">2. Admin Role</h3>
                </div>
                <div class="card-body">
                    <ul>
                        <li><strong>Manage Users:</strong> The admin can add, edit, or remove users from the system.</li>
                        <li><strong>Manage COT Elements:</strong> The admin sets up the categories for activities, involving 7 elements such as Collaboration, Research and Innovation, Expert service, Teaching and Learning, Publication, Recognition, and Income generation.</li>
                    </ul>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="mb-0">3. COT Officers Role</h3>
                </div>
                <div class="card-body">
                    <ul>
                        <li><strong>Manage Activities:</strong> COT officers can enter details about activities they are working on, update information, and remove old or incorrect entries.</li>
                        <li><strong>Plan Activities:</strong> They can create and manage plans for future activities.</li>
                        <li><strong>View Plans and Reports:</strong> They can see all planned activities and generate reports on what has been achieved.</li>
                    </ul>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="mb-0">4. PKT Management Role</h3>
                </div>
                <div class="card-body">
                    <ul>
                        <li><strong>View Plans:</strong> PKT management can see the overall plans for activities.</li>
                        <li><strong>View Reports:</strong> They can access detailed reports on the achievements of these activities, which are updated quarterly.</li>
                    </ul>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include_once 'layout/footer.php'; ?>