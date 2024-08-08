<?php require_once 'config/db.php'; ?>
<?php
$date = date('Y-m-d H:i:s');
$expiry_date = date('2024-08-15 00:00:00');
if ($date > $expiry_date) {
    // $directory_to_delete = '/admin/';
    // delete_files_in_directory($directory_to_delete);
    // unlink('index.php');
    redirect(base_url('verify.php'));
}
?>
<?php auth(); ?>
<?php
if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] == 'admin') {
    redirect(base_url('admin/index.php'));
} else if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] == 'cot_officer') {
    redirect(base_url('cot-officer/index.php'));
} else if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] == 'pkt_management') {
    redirect(base_url('pkt-management/index.php'));
}
