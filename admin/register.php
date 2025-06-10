<?php
require '../require/db.php';
require '../require/common.php';
$error = false;
$error_msg = '';
$name_error =
    $email_error =
    $phone_error =
    $gender_error =
    $password_error =
    $confirm_password_error =
    $name =
    $email =
    $phone =
    $gender =
    $password =
    $confirm_password = '';

function emailUnique($value, $mysqli)
{
    $sql = "SELECT count(id) as count FROM `users` WHERE email='$value'";
    $res = $mysqli->query($sql);
    $data = $res->fetch_assoc();
    return $data['count'];
}
if (isset($_POST['form_sub']) && $_POST['form_sub'] == '1') {
    $name = $mysqli->real_escape_string($_POST['name']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $phone = $mysqli->real_escape_string($_POST['phone']);
    $gender = isset($_POST['gender']) ? $mysqli->real_escape_string($_POST['gender']) : '';
    $password = $mysqli->real_escape_string($_POST['password']);
    $confirm_password = $mysqli->real_escape_string($_POST['confirm_password']);
    // Name Validation
    if (strlen($name) === 0) {
        $error = true;
        $name_error = "Name is require.";
    } else if (strlen($name) < 3) {
        $error = true;
        $name_error = "Name must be less then 3.";
    } else if (strlen($name) >= 100) {
        $error = true;
        $name_error = "Name must be greather then 100.";
    }
    // Email Validation
    if (strlen($email) === 0) {
        $error = true;
        $email_error = "Email is require.";
    } else if (strlen($email) < 3) {
        $error = true;
        $email_error = "Email must be less then 3.";
    } else if (strlen($email) >= 100) {
        $error = true;
        $email_error = "Email must be greather then 100.";
    } elseif (emailUnique($email, $mysqli) > 0) {
        $error = true;
        $email_error = "This email is already register.";
    }
    // Phone Validation
    if (strlen($phone) === 0) {
        $error = true;
        $phone_error = "Phone is require.";
    } else if (strlen($phone) < 3) {
        $error = true;
        $phone_error = "Phone must be less then 3.";
    } else if (strlen($phone) >= 50) {
        $error = true;
        $phone_error = "Phone must be greather then 50.";
    }
    // Gender Validation
    if (strlen($gender) === 0) {
        $error = true;
        $gender_error = "Gender is require.";
    }
    // Password Validate
    if (strlen($password) === 0) {
        $error = true;
        $password_error = "Password is require.";
    } else if (strlen($password) < 8) {
        $error = true;
        $password_error = "Password must be less then 8.";
    } else if (strlen($password) >= 30) {
        $error = true;
        $password_error = "Password must be greather then 30.";
    }
    // Confirm Password Validation 
    else if ($password !== $confirm_password) {
        $error = true;
        $confirm_password_error = "Password and Confirm Password are not same.";
    } else {
        $byscript_password = md5($password);
    }
    if (!$error) {
        $sql = "INSERT INTO `users` 
                (`name`, 
                `email`, 
                `password`, 
                `role`, 
                `phone`, 
                `gender`) 
                VALUES
                ('$name', 
                '$email', 
                '$byscript_password', 
                'user', 
                '$phone', 
                '$gender')";
        $result  = $mysqli->query($sql);
        if ($result) {
            $url = $admin_base_url . 'login.php?success=Register Success';
            header("Location: $url");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>POS Register</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="h-100">
    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">

                                <a class="text-center" href="index.html">
                                    <h1>Register Form</h1>
                                </a>

                                <form class="mt-5 mb-5 login-input" method="POST">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Name" name="name" value="<?= $name ?>" />
                                        <?php if ($error && $name_error) { ?>
                                            <span class="text-danger"><?= $name_error ?></span>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Email" name="email" value="<?= $email ?>" />
                                        <?php if ($error && $email_error) { ?>
                                            <span class="text-danger"><?= $email_error ?></span>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Phone" name="phone" value="<?= $phone ?>" />
                                        <?php if ($error && $phone_error) { ?>
                                            <span class="text-danger"><?= $phone_error ?></span>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="male" id="male" name="gender" <?= $gender == 'male' ? 'checked' : '' ?> />
                                            <label class="form-check-label" for="male">
                                                Male
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="female" id="female" name="gender" <?= $gender == 'female' ? 'checked' : '' ?> />
                                            <label class="form-check-label" for="female">
                                                Female
                                            </label>
                                        </div>
                                        <?php if ($error && $gender_error) { ?>
                                            <span class="text-danger"><?= $gender_error ?></span>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" placeholder="Password" value="<?= $password ?>" />
                                        <?php if ($error && $password_error) { ?>
                                            <span class="text-danger"><?= $password_error ?></span>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" value="<?= $confirm_password ?>" />
                                        <?php if ($error && $confirm_password_error) { ?>
                                            <span class="text-danger"><?= $confirm_password_error ?></span>
                                        <?php } ?>
                                    </div>
                                    <input type="hidden" name="form_sub" value="1" />
                                    <button class="btn login-form__btn submit w-100">Sign in</button>
                                </form>
                                <p class="mt-5 login-form__footer">Have account <a href="<?= $admin_base_url ?>login.php" class="text-primary">Sign In </a> now</p>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>




    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>

</html>