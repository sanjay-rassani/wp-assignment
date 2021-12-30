<?php
session_start();

require_once 'utilities/user.php';

if (isset($_POST['user-name'])) {
    $user_name = $_POST['user-name'];
    $user_pass = $_POST['user-pass'];
    $user_full_name = $_POST['user-full-name'];

    $res = do_register($user_name, $user_pass, $user_full_name);
    if ($res == 'REGISTERED') {
        $user = do_login($user_name, $user_pass);
        if ($user != null) {
            $_SESSION["_user"] = $user;
            header("Location: home.php");
        }
    } else {
        $login_fail_message = "user name already taken";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="style.css">
    <title>Main</title>
</head>

<body>
    <?php include "header.php"; ?>
    <div style="text-align: center">
        <h1 class="display-1">Register Form</h1>
        <?php if (isset($login_fail_message)) : ?>
            <div class="error-message"><?= $login_fail_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <div>
                <label class='form-label'>User Full Name
                    <input class='form-control' type="text" name="user-full-name" required />
                </label>
            </div>
            <div>
                <label class='form-label'>User Name
                    <input class='form-control' type="text" name="user-name" required />
                </label>
            </div>
            <div>
                <label class='form-label'>User Password
                    <input class='form-control' type="password" name="user-pass" required />
                </label>
            </div>
            <div>
                <input type="submit" class="from-control btn btn-primary" value="SignUp" />
                <a href="index.php">Login?</a>
            </div>
        </form>
    </div>
</body>

</html>