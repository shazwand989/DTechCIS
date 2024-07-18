<?php $title = 'ERROR 500'; ?>
<?php include_once 'layout/header.php'; ?>
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>500 Error Page</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">500 Error Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="error-page">
            <h2 class="headline text-warning"> 500</h2>
            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>
                <p>
                    We could not find the page you were looking for.
                    Meanwhile, you may <a href="<?= base_url('admin/index.php') ?>">return to dashboard</a>.
                </p>
                <!-- back button -->
                <button onclick="goBack()" class="btn btn-primary">Go Back</button>
            </div>

        </div>

    </section>

</div>
<?php include_once 'layout/footer.php'; ?>