<?php require_once 'config/db.php'; ?>
<?php auth(); ?>

<?php
if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] == 'admin') {
    redirect(base_url('admin/index.php'));
} else if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] == 'cot_officer') {
    redirect(base_url('cot-officer/index.php'));
} else if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] == 'pkt_management') {
    redirect(base_url('pkt-management/index.php'));
}
