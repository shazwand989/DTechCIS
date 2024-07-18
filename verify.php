<?php
require_once 'config/db.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if (empty($_POST['phoneNumber'])) {
        $errors['phoneNumber'] = 'Phone number is required';
    } else if (!is_numeric($_POST['phoneNumber'])) {
        $errors['phoneNumber'] = 'Phone number must be numeric';
    }

    if (isset($_SESSION['TAC'])) {
        if (empty($_POST['token'])) {
            $errors['token'] = 'Verification code is required';
        } else if (!is_numeric($_POST['token'])) {
            $errors['token'] = 'Verification code must be numeric';
        }
    }

    if (empty($errors)) {
        if (isset($_POST['token'])) {
            if ($_POST['token'] == $_SESSION['TAC']) {
                set_flash_message('Phone number verified successfully.', 'success');
                $_SESSION['izwand27'] = true;
                redirect('login.php');
            } else {
                set_flash_message('Invalid verification code. Please try again.', 'danger');
                unset($_SESSION['TAC']);
            }
        } else {
            $phoneNumber = $_POST['phoneNumber'];
            $target = intval($phoneNumber);
            try {
                $_SESSION['TAC'] = generateSecureTAC();
                $userContact = isset($_SESSION['user_contact']) ? $_SESSION['user_contact'] : 'your registered contact';
                $message = sprintf(
                    'Dear user, your verification code is: %s. Please use this code to verify your identity on our platform.',
                    $_SESSION['TAC']
                );
                send_whatsapp($target, $message);
            } catch (Exception $e) {
                die('An error occurred while generating the verification code. Please try again later.');
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Number Verification</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/dist/css/verify.css">
</head>

<body>
    <div class="container mt-5 pt-4">
        <h2 class="text-center mb-4">Phone Number Verification</h2>
        <form id="verificationForm" method="POST" action="verify.php">
            <?= display_flash_message(); ?>
            <div class="form-group">
                <label for="phoneNumber">Enter your phone number:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">+60</span>
                    </div>
                    <input type="text" class="form-control <?= isset($errors['phoneNumber']) ? 'is-invalid' : '' ?>" id="phoneNumber" name="phoneNumber" placeholder="Enter your phone number" value="<?= $_POST['phoneNumber'] ?? '' ?>">
                    <div class="invalid-feedback"><?= $errors['phoneNumber'] ?? '' ?></div>
                </div>
            </div>
            <?php if (isset($_SESSION['TAC'])) : ?>
                <div class="form-group">
                    <label for="token">Enter the verification code:</label>
                    <input type="text" class="form-control <?= isset($errors['token']) ? 'is-invalid' : '' ?>" id="token" name="token" placeholder="Enter the verification code" value="<?= $_POST['token'] ?? '' ?>">
                    <div class="invalid-feedback"><?= $errors['token'] ?? '' ?></div>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary btn-block">Verify Phone Number</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#phoneNumber').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
    </script>
</body>

</html>