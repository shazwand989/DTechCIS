<?php

include_once 'email.php';

function base_url($url = null)
{
    return SITE_URL . $url;
}

function redirect($url)
{
    echo "<script>window.location.href = '$url';</script>";
    die();
}

function auth($role = null)
{
    if (!isset($_SESSION['user'])) {
        set_flash_message('You must be logged in to view that page', 'danger');
        redirect(base_url('login.php'));
    }

    if ($role && $_SESSION['user']['role'] != $role) {
        set_flash_message('You are not authorized to view that page', 'danger');
        redirect(base_url('index.php'));
    }
}

function alert($text, $type)
{
    $msg = "<div class='alert alert-" . $type . " alert-dismissible fade show' role='alert'>
                <strong>" . $text . "</strong>
         
            </div>";

    $msg = "<div class='alert alert-" . $type . " alert-dismissible fade show' role='alert'>
                <strong>" . $text . "</strong>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
        </div>";
    return $msg;
}

// flash message
function set_flash_message($text, $type = 'info')
{
    $_SESSION['flash_message'] = [
        'text' => $text,
        'type' => $type,
    ];
}

// Display flash message
function display_flash_message()
{
    if (isset($_SESSION['flash_message'])) {
        $text = $_SESSION['flash_message']['text'];
        $type = $_SESSION['flash_message']['type'];

        echo alert($text, $type);

        // Clear the flash message to ensure it's only displayed once
        unset($_SESSION['flash_message']);
    }
}

// Function to send email
function sendEmail($email, $subject, $body)
{
    try {
        global $mail;
        // Server settings
        $mail->isSMTP();

        $mail->Host = MAIL_HOST; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME; // SMTP username
        $mail->Password = MAIL_PASSWORD; // SMTP password
        $mail->SMTPSecure = MAIL_SMTP_SECURE;
        $mail->Port = MAIL_PORT;

        // Recipients
        $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
        $mail->addAddress($email); // Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        // Send the email
        $mail->send();
        return true; // Email sent
    } catch (Exception $e) {
        return $e->getMessage(); // Email not sent
    }
}
