<?php $title = "Users"; ?>
<?php include_once "layout/header.php"; ?>
<?php
$users = new Users(); // Create a new instance of the Users class

// Check if a user role is set in the GET request
if (isset($_GET['role'])) {
    $role = $_GET['role'];
    $user['user_role'] = $role; // Assign the role to the user array
}

// Check if a user ID is set in the GET request
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = $users->getUserById($id); // Get the user by ID
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = []; // Initialize an array to store error messages

    // Sanitize and validate user inputs
    $user_name = filter_var($_POST['user_name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
    $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
    $state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
    $postcode = filter_var($_POST['postcode'], FILTER_SANITIZE_STRING);
    $role = filter_var($_GET['role'], FILTER_SANITIZE_STRING);

    $password = $_POST['password'];

    // Validate user_name
    if (!$user_name) {
        $errors['user_name'] = 'Full name is required';
    } elseif (!preg_match('/^[a-zA-Z\s]*$/', $user_name)) {
        $errors['user_name'] = 'Invalid full name';
    } elseif (strlen($user_name) < 3) {
        $errors['user_name'] = 'Full name must be at least 3 characters';
    } elseif (strlen($user_name) > 80) {
        $errors['user_name'] = 'Full name must be less than 80 characters';
    }

    // Validate email
    $user_email = $users->getUserByEmail($email);
    if (!$email) {
        $errors['email'] = 'Email is required';
    } elseif ($user_email && (!isset($_GET['id']) || $user_email['user_id'] != $_GET['id'])) {
        $errors['email'] = 'Email already exists';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email address';
    } elseif (strlen($email) > 100) {
        $errors['email'] = 'Email must be less than 100 characters';
    }

    // Validate phone
    $user_phone = $users->getUserByPhone($phone);
    if (!$phone) {
        $errors['phone'] = 'Phone is required';
    } elseif ($user_phone && (!isset($_GET['id']) || $user_phone['user_id'] != $_GET['id'])) {
        $errors['phone'] = 'Phone already exists';
    } elseif (!preg_match('/^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/', $phone)) {
        $errors['phone'] = 'Invalid phone number';
    }

    // Validate password
    if ($password) {
        $passwordErrors = [];
        if (strlen($password) < 6) {
            $passwordErrors[] = 'Password must be at least 6 characters';
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $passwordErrors[] = 'Password must contain at least one uppercase letter';
        }
        if (!preg_match('/[a-z]/', $password)) {
            $passwordErrors[] = 'Password must contain at least one lowercase letter';
        }
        if (!preg_match('/[0-9]/', $password)) {
            $passwordErrors[] = 'Password must contain at least one number';
        }
        if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
            $passwordErrors[] = 'Password must contain at least one special character';
        }
        if (count($passwordErrors) > 0) {
            $errors['password'] = '<ul><li>' . implode('</li><li>', $passwordErrors) . '</li></ul>';
        }
    } else {
        $password = 'password'; // Placeholder password for validation purposes
    }

    // If there are no errors, proceed with user creation/updation
    if (empty($errors)) {
        $data = [
            'user_name' => $user_name,
            'user_email' => $email,
            'user_phone' => $phone,
            'user_address' => $address,
            'user_city' => $city,
            'user_state' => $state,
            'user_postcode' => $postcode,
            'user_role' => $role
        ];

        // Include the password if it was provided
        if ($password) {
            $data['user_password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Handle profile picture upload
        if (isset($_FILES['cover']) && $_FILES['cover']['name']) {
            $file = $_FILES['cover'];
            $file_name = time() . '_' . $file['name'];
            $file_name = uploadImage($file, '../assets/dist/img/user/');
            $data['user_profile_picture'] = $file_name;
            if (isset($_GET['id'])) {
                $user = $users->getUserById($_GET['id']);
                deleteImage($user['user_profile_picture'], '../assets/dist/img/user/');
            }
        }

        // Update or create the user
        if (isset($_GET['id'])) {
            $result = $users->updateUser($_GET['id'], $data);
        } else {
            $result = $users->createUser($data);
        }

        // Set flash message and redirect based on result
        if ($result === true) {
            set_flash_message("User has been " . (isset($_GET['id']) ? 'updated' : 'created'), 'success');
            redirect("user-list.php?role=$role");
        } else {
            set_flash_message("Failed to save user", 'danger');
        }
    }
}
?>
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User
                        <?php if ($role == 'admin') : ?>
                            Admin
                        <?php elseif ($role == 'cot_officer') : ?>
                            COT Officers
                        <?php elseif ($role == 'pkt_management') : ?>
                            PKT Management
                        <?php endif; ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                        <li class="breadcrumb-item active"><?= ucfirst($role) ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                Infomation
                                <?php if ($role == 'admin') : ?>
                                    Admin
                                <?php elseif ($role == 'cot_officer') : ?>
                                    COT Officers
                                <?php elseif ($role == 'pkt_management') : ?>
                                    PKT Management
                                <?php endif; ?>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-4 col-12 text-center">
                                        <?php if (isset($user['user_profile_picture']) && file_exists('../assets/dist/img/user/' . $user['user_profile_picture'])) : ?>
                                            <img src="<?= base_url('assets/dist/img/user/' . $user['user_profile_picture']) ?>" class="img-fluid" alt="Responsive image" id="cover-preview" style="max-width: 250px; max-height: 250px;">
                                        <?php else : ?>
                                            <img src="https://via.placeholder.com/150" class="img-fluid" alt="Responsive image" id="cover-preview" style="max-width: 250px; max-height: 250px;">
                                        <?php endif; ?>
                                        <div class="form-group mt-3">
                                            <input type="file" name="cover" id="cover" class="form-control-file <?= isset($errors['cover']) ? 'is-invalid' : '' ?>" onchange="previewImage(this, 'cover-preview')">
                                            <div class="invalid-feedback"><?= $errors['cover'] ?? '' ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <div class="row">
                                            <div class="form-group col-md-4 col-12">
                                                <label for="user_name">Full Name <span class="text-danger">*</span></label>
                                                <input type="text" name="user_name" id="user_name" class="form-control <?= isset($errors['user_name']) ? 'is-invalid' : '' ?>" value="<?= $_POST['user_name'] ?? $user['user_name'] ?? '' ?>" minlength="3" maxlength="80" placeholder="Full Name">
                                                <div class="invalid-feedback"><?= $errors['user_name'] ?? '' ?></div>
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <label for="email">Email <span class="text-danger">*</span></label>
                                                <input type="email" name="email" id="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" value="<?= $_POST['email'] ??  $user['user_email'] ?? '' ?>" placeholder="Email">
                                                <div class="invalid-feedback">
                                                    <?= $errors['email'] ?? '' ?>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <label for="phone">Phone <span class="text-danger">*</span></label>
                                                <input type="text" name="phone" id="phone" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" value="<?= $_POST['phone'] ?? $user['user_phone'] ?? '' ?>" minlength="10" maxlength="15" placeholder="Phone">
                                                <div class="invalid-feedback">
                                                    <?= $errors['phone'] ?? '' ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea name="address" id="address" class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>" placeholder="Address"><?= $_POST['address'] ?? $user['user_address'] ?? '' ?></textarea>
                                            <div class="invalid-feedback">
                                                <?= $errors['address'] ?? '' ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4 col-12">
                                                <label for="city">City</label>
                                                <input type="text" name="city" id="city" class="form-control <?= isset($errors['city']) ? 'is-invalid' : '' ?>" value="<?= $_POST['city'] ??  $user['user_city'] ?? '' ?>" minlength="3" maxlength="50" placeholder="City">
                                                <div class="invalid-feedback">
                                                    <?= $errors['city'] ?? '' ?>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <label for="state">State</label>
                                                <select name="state" id="state" class="form-control <?= isset($errors['state']) ? 'is-invalid' : '' ?>">
                                                    <option value="">Select State</option>
                                                    <?php foreach (states() as $state) : ?>
                                                        <option value="<?= $state ?>" <?= (isset($_POST['state']) && $_POST['state'] == $state) || (isset($user['user_state']) && $user['user_state'] == $state) ? 'selected' : '' ?>><?= $state ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    <?= $errors['state'] ?? '' ?>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <label for="postcode">Postcode</label>
                                                <input type="text" name="postcode" id="postcode" class="form-control <?= isset($errors['postcode']) ? 'is-invalid' : '' ?>" value="<?= $_POST['postcode'] ?? $user['user_postcode'] ?? '' ?>" minlength="5" maxlength="5" placeholder="Postcode">
                                                <div class="invalid-feedback">
                                                    <?= $errors['postcode'] ?? '' ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" id="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" placeholder="Password">
                                            <div class="invalid-feedback">
                                                <?= $errors['password'] ?? '' ?>
                                            </div>
                                            <small class="text-muted">Leave blank if you don't want to change the password</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 offset-md-4">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include_once "layout/footer.php"; ?>