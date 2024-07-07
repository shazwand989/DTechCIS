<?php
// START SESSION
session_start();

// DATABASE CREDINTIALS
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'db_DTechCIS');

// SITE URL
define('SITE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/');

// SITE NAME
define('SITE_NAME', 'Digital Technology Center Of Information System (DTechCIS)');

// CONNECT TO DATABASE
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// CHECK CONNECTION
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


include_once 'functions.php';
include_once 'model.php';
