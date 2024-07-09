<?php require_once 'config/db.php'; ?>
<?php
$users = new Users();
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim(strtolower($_POST['email']));

    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    } else {
        $user = $users->getUserByEmail($email);
        if (!$user) {
            $errors['email'] = 'Email not found';
        }
    }

    if (empty($errors)) {
        $token = bin2hex(random_bytes(50));
        $forgotPassword = new ForgotPassword();
        $dataForgotPassword = [
            'forgot_password_user_id' => $user['user_id'],
            'forgot_password_token' => $token,
            'forgot_password_created_at' => date('Y-m-d H:i:s')
        ];
        $subject = 'Reset Password';
        $body = 'Click the link below to reset your password<br>';
        $body .= '<a href="' . base_url('reset-password.php?token=' . $token) . '">Reset Password</a>';
        $email_send = send_email($email, $subject, $body);
        if ($email_send === true) {
            set_flash_message('Reset password link has been sent to your email', 'success');
            $forgotPassword->createForgotPassword($dataForgotPassword);
        } else {
            set_flash_message($email_send, 'danger');
        }
        redirect(base_url('forgot-password.php'));
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <title><?= SITE_NAME ?> | Forgot Password</title>
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
                                    <h3 class="mb-4">Forgot Password</h3>
                                </div>
                            </div>
                            <?= display_flash_message() ?>
                            <form action="" class="signin-form" method="post">
                                <div class="form-group mb-3">
                                    <label class="label" for="email">Email</label>
                                    <input type="text" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" name="email" placeholder="Email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>">
                                    <span class="text-danger"><?= $errors['email'] ?? '' ?></span>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Submit</button>
                                </div>
                                <div class="form-group d-md-flex">
                                    <a href="login.php">Back to Login</a>
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