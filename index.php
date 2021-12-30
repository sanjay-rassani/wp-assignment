<?php
session_start();

require_once 'utilities/user.php';
require_once 'utilities/post.php';

if (isset($_POST['user-name'])) {
	$user_name = $_POST['user-name'];
	$user_pass = $_POST['user-pass'];

	$user = do_login($user_name, $user_pass);

	if ($user != null) {
		// get likes, comments, reads, and followers of both, user itself and others
		$user_id = $user['user_id'];
		$user['user_likes'] = get_user_likes($user_id);
		$user['user_reads'] = get_user_reads($user_id);
		$user['user_comments'] = get_user_comments($user_id);
		$user['user_follows'] = get_user_follows($user_id);
		$user['user_posts'] = sizeof(get_user_posts($user_id));

		// $user['other_likes'] = get_other_likes($user_id);
		// $user['other_reads'] = get_other_reads($user_id);
		// $user['other_comments'] = get_other_comments($user_id);
		// $user['other_follows'] = get_other_follows($user_id);

		$_SESSION["_user"] = $user;
		header("Location: home.php");
	}
	$login_fail_message = "Username or password mismatched";
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
	<div style="text-align: center" class="container">
		<h1 class="display-1">Login Form</h1>
		<?php if (isset($login_fail_message)) : ?>
			<div class="error-message"><?= $login_fail_message; ?></div>
		<?php endif; ?>
		<div class="row justify-content-center">
			<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" class="col-3">
				<div class="mb-3">
					<label class="form-label">User Name
						<input class="form-control" type="text" name="user-name" required />
					</label>
				</div>
				<div class="mb-3">
					<label class="form-label">User Password
						<input class="form-control" type="password" name="user-pass" required />
					</label>
				</div>
				<div>
					<input class="form-control btn-info" type="submit" value="Submit" />
					<a href="signup.php">Not registered yet?</a>
				</div>
			</form>
		</div>
	</div>
</body>

</html>