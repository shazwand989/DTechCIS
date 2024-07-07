<?php

// Mail settings
define('MAIL_HOST', 'smtp.example.com');
define('MAIL_USERNAME', '');
define('MAIL_PASSWORD', '');
define('MAIL_PORT', 587);
define('MAIL_FROM', MAIL_USERNAME);
define('MAIL_FROM_NAME', 'Admin - ' . SITE_NAME);
define('MAIL_SMTP_SECURE', 'tls');

require __DIR__ . '/../vendor/autoload.php';



// Include PHPMailer autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
