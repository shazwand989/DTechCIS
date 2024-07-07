<?php require_once 'config/db.php'; ?>
<?php session_destroy(); ?>
<?php redirect(base_url('login.php')); ?>