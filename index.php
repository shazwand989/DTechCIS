<?php require_once 'config/db.php'; ?>
<?php auth(); ?>

<?php
if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] == 'admin') {
    redirect(base_url('admin/index.php'));
}
