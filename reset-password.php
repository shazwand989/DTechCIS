<?php require_once 'config/db.php'; ?>
<?php
// Create new instances of the Users and ForgotPassword classes
$Users = new Users();
$ForgotPassword = new ForgotPassword();

// Initialize an empty array to hold error messages
$errors = [];

// Check if a token is present in the GET request
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Retrieve the forgot password record using the token
    $forgotPassword = $ForgotPassword->getForgotPasswordByToken($token);

    // If the token is invalid, set an error message and redirect to the forgot-password page
    if (!$forgotPassword) {
        set_flash_message('Invalid token', 'danger');
        redirect(base_url('forgot-password.php'));
    }

    // Check if the request method is POST (i.e., form submission)

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Retrieve and trim the new and confirm password from the POST request
        $newPassword = trim($_POST['new_password']);
        $confirmPassword = trim($_POST['confirm_password']);

        // Validate the new password
        if (empty($newPassword)) {
            $errors['new_password'] = 'New password is required';
        } else {
            // Initialize an array to hold password validation errors
            $errPassword = [];
            // Check for at least one uppercase letter
            if (!preg_match('/[A-Z]/', $newPassword)) {
                $errPassword[] = 'At least one uppercase letter';
            }
            // Check for at least one lowercase letter
            if (!preg_match('/[a-z]/', $newPassword)) {
                $errPassword[] = 'At least one lowercase letter';
            }
            // Check for at least one number
            if (!preg_match('/[0-9]/', $newPassword)) {
                $errPassword[] = 'At least one number';
            }
            // Check for at least one special character
            if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $newPassword)) {
                $errPassword[] = 'At least one special character';
            }
            // Check if the password is at least 8 characters long
            if (strlen($newPassword) < 8) {
                $errPassword[] = 'Minimum 8 characters';
            }
            // If there are password validation errors, add them to the errors array
            if (!empty($errPassword)) {
                $textError = '<ul>';
                foreach ($errPassword as $err) {
                    $textError .= '<li>' . $err . '</li>';
                }
                $textError .= '</ul>';
                $errors['new_password'] = $textError;
            }
        }

        // Validate the confirm password
        if (empty($confirmPassword)) {
            $errors['confirm_password'] = 'Confirm password is required';
        } elseif ($newPassword != $confirmPassword) {
            $errors['confirm_password'] = 'Password does not match';
        }

        // If there are no errors, update the user's password and reset the forgot password status
        if (empty($errors)) {
            $data = [
                'user_password' => $newPassword
            ];
            // Update the user's password
            $Users->updateUser($forgotPassword['forgot_password_user_id'], $data);
            // Update the forgot password status to indicate it has been used
            $ForgotPassword->updateForgotPassword($forgotPassword['forgot_password_id'], ['forgot_password_status' => '0']);
            // Set a success message and redirect to the login page
            set_flash_message('Password has been reset', 'success');
            redirect(base_url('login.php'));
        }
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <title><?= SITE_NAME ?> | Reset Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/login.css') ?>">
    <style>
        .logo-custom {
            display: flex;
            justify-content: center;
            align-items: center;
            padding-left: 50px;
        }
    </style>
</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section"><?= SITE_NAME ?></h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="img logo-custom">
                            <img src="<?= base_url('assets/dist/img/logo/pkt-logo.png') ?>" alt="background image">
                        </div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Reset Password</h3>
                                </div>
                            </div>
                            <?= display_flash_message() ?>
                            <form action="" class="signin-form" method="post">
                                <div class="form-group mb-3">
                                    <label class="label" for="new_password">New Password</label>
                                    <input type="password" class="form-control <?= isset($errors['new_password']) ? 'is-invalid' : '' ?>" name="new_password" placeholder="New Password">
                                    <span class="text-danger"><?= $errors['new_password'] ?? '' ?></span>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label" for="confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>" name="confirm_password" placeholder="Confirm Password">
                                    <span class="text-danger"><?= $errors['confirm_password'] ?? '' ?></span>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script>
        $('input').focus(function() {
            $(this).removeClass('is-invalid');
            $(this).next().text('');
        });
    </script>
</body>

</html>