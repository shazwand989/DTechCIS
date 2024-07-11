<?php $title = "Account" ?>
<?php include_once "layout/header.php"; ?>
<?php
$users = new Users(); // Create an instance of the Users class
$errors = []; // Initialize an empty array to store errors

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the action is 'profile'
    if (isset($_GET['action']) && $_GET['action'] == 'profile') {
        // Validate user input and store errors if any

        if (empty($_POST['user_name'])) {
            $errors['user_name'] = 'Full Name is required';
        }

        if (empty($_POST['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        } elseif ($users->getUserByEmail($_POST['email']) && $users->getUserByEmail($_POST['email'])['user_id'] != user()['user_id']) {
            $errors['email'] = 'Email already exists';
        }

        if (empty($_POST['phone'])) {
            $errors['phone'] = 'Phone is required';
        }

        if (empty($_POST['address'])) {
            $errors['address'] = 'Address is required';
        }

        if (empty($_POST['city'])) {
            $errors['city'] = 'City is required';
        }

        if (empty($_POST['state'])) {
            $errors['state'] = 'State is required';
        }

        if (empty($_POST['postcode'])) {
            $errors['postcode'] = 'Postcode is required';
        }

        // If there are no errors, update the user's profile
        if (empty($errors)) {
            $data = [
                'user_name' => $_POST['user_name'],
                'user_email' => $_POST['email'],
                'user_phone' => $_POST['phone'],
                'user_address' => $_POST['address'],
                'user_city' => $_POST['city'],
                'user_state' => $_POST['state'],
                'user_postcode' => $_POST['postcode'],
            ];

            // Handle profile picture upload
            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['name']) {
                $file = $_FILES['profile_picture'];
                $file_name = time() . '_' . $file['name'];
                $file_name = uploadImage($file, '../assets/dist/img/user/');
                deleteImage(user()['user_profile_picture'], '../assets/dist/img/user/');
                $data['user_profile_picture'] = $file_name;
            }

            // Update the user's data
            $users->updateUser(user()['user_id'], $data);
            set_flash_message('Profile updated successfully', 'success');
            redirect(base_url('pkt-management/account.php?action=profile'));
        }
    }
    // Check if the action is 'change-password'
    elseif (isset($_GET['action']) && $_GET['action'] == 'change-password') {
        // Validate password inputs and store errors if any

        if (empty($_POST['current_password'])) {
            $errors['current_password'] = 'Current Password is required';
        } elseif (!password_verify($_POST['current_password'], user()['user_password'])) {
            $errors['current_password'] = 'Current Password is incorrect';
        }

        if (empty($_POST['new_password'])) {
            $errors['new_password'] = 'New Password is required';
        } elseif (strlen($_POST['new_password']) < 6) {
            $errors['new_password'] = 'Password must be at least 6 characters';
        }

        if (empty($_POST['confirm_password'])) {
            $errors['confirm_password'] = 'Confirm Password is required';
        } elseif ($_POST['new_password'] != $_POST['confirm_password']) {
            $errors['confirm_password'] = 'Password does not match';
        }

        // If there are no errors, update the user's password
        if (empty($errors)) {
            $data = [
                'user_password' => $_POST['new_password'],
            ];
            $users->updateUser(user()['user_id'], $data);
            set_flash_message('Password updated successfully', 'success');
            redirect(base_url('pkt-management/account.php?action=change-password'));
        }
    }
}

?>
<div class="content-wrapper" style="min-height: 2646.44px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">User Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link <?= !isset($_GET['action']) || $_GET['action'] == 'profile' ? 'active' : '' ?>" href="#profile" data-toggle="tab">Profile</a></li>
                                <li class="nav-item"><a class="nav-link <?= isset($_GET['action']) && $_GET['action'] == 'change-password' ? 'active' : '' ?>" href="#change-password" data-toggle="tab">Change Password</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <?= display_flash_message() ?>
                            <div class="tab-content">
                                <div class="tab-pane <?= isset($_GET['action']) && $_GET['action'] == 'profile' ? 'active' : '' ?>" id="profile">
                                    <form class="form-horizontal" action="?action=profile" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-lg-4 text-center">
                                                <?php if (file_exists('../assets/dist/img/user/' . user()['user_profile_picture']) && user()['user_profile_picture'] != null) : ?>
                                                    <img src="../assets/dist/img/user/<?= user()['user_profile_picture'] ?>" class="img-fluid" alt="User Image" id="profile_picture">
                                                <?php else : ?>
                                                    <img src="../assets/dist/img/user/default.png" class="img-fluid" alt="User Image" id="profile_picture">
                                                <?php endif; ?>
                                                <div class="form-group">
                                                    <label for="inputFile">Profile Picture</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="inputFile" name="profile_picture" onchange="changePicture(this)">
                                                            <label class="custom-file-label" for="inputFile">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-lg-8">
                                                <div class="form-group row">
                                                    <label for="inputName" class="col-sm-2 col-form-label">Full Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control <?= isset($errors['user_name']) ? 'is-invalid' : '' ?>" placeholder="Full Name" name="user_name" value="<?= user()['user_name'] ?? $_POST['user_name'] ?? '' ?>">
                                                        <div class="invalid-feedback"><?= $errors['user_name'] ?? '' ?></div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" placeholder="Email" name="email" value="<?= user()['user_email'] ?? $_POST['email'] ?? '' ?>">
                                                        <div class="invalid-feedback"><?= $errors['email'] ?? '' ?></div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputPhone" class="col-sm-2 col-form-label">Phone</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" placeholder="Phone" name="phone" value="<?= user()['user_phone'] ?? $_POST['phone'] ?? '' ?>">
                                                        <div class="invalid-feedback"><?= $errors['phone'] ?? '' ?></div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputAddress" class="col-sm-2 col-form-label">Address</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>" placeholder="Address" name="address"><?= user()['user_address'] ?? $_POST['address'] ?? '' ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputCity" class="col-sm-2 col-form-label">City</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control <?= isset($errors['city']) ? 'is-invalid' : '' ?>" placeholder="City" name="city" value="<?= user()['user_city'] ?? $_POST['city'] ?? '' ?>">
                                                        <div class="invalid-feedback"><?= $errors['city'] ?? '' ?></div>
                                                    </div>
                                                    <label for="inputState" class="col-sm-1 col-form-label">State</label>
                                                    <div class="col-sm-3">
                                                        <select class="form-control <?= isset($errors['state']) ? 'is-invalid' : '' ?>" name="state">
                                                            <option value="">-- Select State --</option>
                                                            <option value="Johor" <?= (user()['user_state'] ?? $_POST['state'] ?? '') == 'Johor' ? 'selected' : '' ?>>Johor</option>
                                                            <option value="Kedah" <?= (user()['user_state'] ?? $_POST['state'] ?? '') == 'Kedah' ? 'selected' : '' ?>>Kedah</option>
                                                            <option value="Kelantan" <?= (user()['user_state'] ?? $_POST['state'] ?? '') == 'Kelantan' ? 'selected' : '' ?>>Kelantan</option>
                                                            <option value="Kuala Lumpur" <?= (user()['user_state'] ?? $_POST['state'] ?? '') == 'Kuala Lumpur' ? 'selected' : '' ?>>Kuala Lumpur</option>
                                                            <option value="Labuan" <?= (user()['user_state'] ?? $_POST['state'] ?? '') == 'Labuan' ? 'selected' : '' ?>>Labuan</option>
                                                            <option value="Melaka" <?= (user()['user_state'] ?? $_POST['state'] ?? '') == 'Melaka' ? 'selected' : '' ?>>Melaka</option>
                                                            <option value="Negeri Sembilan" <?= (user()['user_state'] ?? $_POST['state'] ?? '') == 'Negeri Sembilan' ? 'selected' : '' ?>>Negeri Sembilan</option>
                                                            <option value="Pahang" <?= (user()['user_state'] ?? $_POST['state'] ?? '') == 'Pahang' ? 'selected' : '' ?>>Pahang</option>
                                                            <option value="Perak" <?= (user()['user_state'] ?? $_POST['state'] ?? '') == 'Perak' ? 'selected' : '' ?>>Perak</option>
                                                            <option value="Perlis" <?= (user()['user_state'] ?? $_POST['state'] ?? '') == 'Perlis' ? 'selected' : '' ?>>Perlis</option>
                                                            <option value="Pulau Pinang" <?= (user()['user_state'] ?? $_POST['state'] ?? '') == 'Pulau Pinang' ? 'selected' : '' ?>>Pulau Pinang</option>
                                                            <option value="Putrajaya" <?= (user()['user_state'] ?? $_POST['state'] ?? '') == 'Putrajaya' ? 'selected' : '' ?>>Putrajaya</option>
                                                            <option value="Sabah" <?= (user()['user_state'] ?? $_POST['state'] ?? '') == 'Sabah' ? 'selected' : '' ?>>Sabah</option>
                                                            <option value="Sarawak" <?= (user()['user_state'] ?? $_POST['state'] ?? '') == 'Sarawak' ? 'selected' : '' ?>>Sarawak</option>
                                                            <option value="Selangor" <?= (user()['user_state'] ?? $_POST['state'] ?? '') == 'Selangor' ? 'selected' : '' ?>>Selangor</option>
                                                            <option value="Terengganu" <?= (user()['user_state'] ?? $_POST['state'] ?? '') == 'Terengganu' ? 'selected' : '' ?>>Terengganu</option>
                                                        </select>
                                                        <div class="invalid-feedback"><?= $errors['state'] ?? '' ?></div>
                                                    </div>
                                                    <label for="inputPostcode" class="col-sm-1 col-form-label">Postcode</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control <?= isset($errors['postcode']) ? 'is-invalid' : '' ?>" placeholder="Postcode" name="postcode" value="<?= user()['user_postcode'] ?? $_POST['postcode'] ?? '' ?>">
                                                        <div class="invalid-feedback"><?= $errors['postcode'] ?? '' ?></div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" class="btn btn-primary">Update Profile</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane <?= isset($_GET['action']) && $_GET['action'] == 'change-password' ? 'active' : '' ?>" id="change-password">
                                    <form class="form-horizontal" action="?action=change-password" method="post">
                                        <div class="form-group row">
                                            <label for="inputCurrentPassword" class="col-sm-3 col-form-label">Current Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control <?= isset($errors['current_password']) ? 'is-invalid' : '' ?>" placeholder="Current Password" name="current_password">
                                                <div class="invalid-feedback"><?= $errors['current_password'] ?? '' ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputNewPassword" class="col-sm-3 col-form-label">New Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control <?= isset($errors['new_password']) ? 'is-invalid' : '' ?>" placeholder="New Password" name="new_password">
                                                <div class="invalid-feedback"><?= $errors['new_password'] ?? '' ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputConfirmPassword" class="col-sm-3 col-form-label">Confirm Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>" placeholder="Confirm Password" name="confirm_password">
                                                <div class="invalid-feedback"><?= $errors['confirm_password'] ?? '' ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-3 col-sm-9">
                                                <button type="submit" class="btn btn-primary">Change Password</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>
</div>
<?php include_once "layout/footer.php"; ?>
<script>
    $(document).ready(function() {
        $('input, textarea, select').focus(function() {
            $(this).removeClass('is-invalid');
            $(this).next().text('');
        });
    });

    function changePicture(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#profile_picture').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>