<?php require_once 'config/db.php'; ?>
<!-- Include the database configuration file -->
<?php
// Create a new instance of the Users class
$users = new Users();

// Initialize an empty array to hold error messages
$errors = [];

// Check if the request method is POST (i.e., form submission)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the username and password from the POST request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username is empty and add an error message if it is
    if (empty($username)) {
        $errors['username'] = 'Username is required';
    }

    // Check if the password is empty and add an error message if it is
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }

    // If there are no errors, proceed with user authentication
    if (empty($errors)) {
        // Get the user details from the database using the provided username
        $user = $users->getUserByUsername($username);
        $email = $users->getUserByEmail($username);

        // Check if the user exists, the password is correct, the user role is admin, and the user status is active
        if (($user && password_verify($password, $user['user_password']) && $user['user_status'] == '1') || ($email && password_verify($password, $email['user_password']) && $email['user_status'] == '1')) {
            // Store user information in the session
            if ($user) {
                $_SESSION['user'] = $user;
            } else {
                $_SESSION['user'] = $email;
            }

            // Check if the "remember me" option was selected
            if (isset($_POST['remember'])) {
                // Set cookies to remember the user for 30 days
                setcookie('user_id', $user['user_id'] ?? $email['user_id'], time() + (86400 * 30), '/');
                setcookie('user_username', $user['user_username'] ?? $email['user_email'], time() + (86400 * 30), '/');
                setcookie('user_password', $password, time() + (86400 * 30), '/');
            } else {
                // Clear the cookies if "remember me" was not selected
                setcookie('user_id', '', time() - 3600, '/');
                setcookie('user_username', '', time() - 3600, '/');
                setcookie('user_password', '', time() - 3600, '/');
            }
            $target = '1116700813';
            // CREATE WHATSAPP MESSAGE TEMPLATE 
            if ($user) {
                $message = 'Hello ' . $user['user_name'] . ', you have successfully logged in to ' . SITE_NAME . ' at ' . date('d F Y, h:i A') . '.';
            } else {
                $message = 'Hello ' . $email['user_name'] . ', you have successfully logged in to ' . SITE_NAME . ' at ' . date('d F Y, h:i A') . '.';
            }
            // SEND WHATSAPP MESSAGE
            $response = send_whatsapp($target, $message);
            if ($_SESSION['user']['user_role'] == 'admin') {
                // Redirect to the admin index page
                redirect(base_url('admin/index.php'));
            } else if ($_SESSION['user']['user_role'] == 'cot_officer') {
                // Redirect to the cot officer index page
                redirect(base_url('cot-officer/index.php'));
            } else if ($_SESSION['user']['user_role'] == 'pkt_management') {
                // Redirect to the pkt management index page
                redirect(base_url('pkt-management/index.php'));
            }
        } else {
            // Set a flash message indicating invalid username or password
            set_flash_message('Invalid username or password', 'danger');
        }
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <title><?= SITE_NAME ?> | Login</title>
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
                                    <h3 class="mb-4">Sign In</h3>
                                </div>
                            </div>
                            <?= display_flash_message() ?>
                            <form action="" class="signin-form" method="post">
                                <div class="form-group mb-3">
                                    <label class="label" for="name">Username</label>
                                    <input type="text" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" id="username" name="username" placeholder="Username" value="<?= $_POST['username'] ?? $_COOKIE['user_username'] ?? '' ?>">
                                    <div class="invalid-feedback"><?= $errors['username'] ?? '' ?></div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label" for="password">Password</label>
                                    <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" name="password" placeholder="Password" value="<?= $_COOKIE['user_password'] ?? '' ?>">
                                    <div class="invalid-feedback"><?= $errors['password'] ?? '' ?></div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
                                </div>
                                <div class="form-group d-md-flex">
                                    <div class="w-50 text-left">
                                        <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                                            <input type="checkbox" name="remember" <?= isset($_COOKIE['user_id']) ? 'checked' : '' ?>>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="w-50 text-md-right">
                                        <a href="forgot-password.php">Forgot Password</a>
                                    </div>
                                </div>
                            </form>
                            <!-- <p class="text-center">Not a member? <a data-toggle="tab" href="#signup">Sign Up</a></p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script>
        $(document).ready(function() {
            $('#username').on('input', function() {
                this.value = this.value.replace(/\s/g, '').toLowerCase();
            });
        });
    </script>
</body>

</html>