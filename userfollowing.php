<?php
require_once 'utilities/blogposts.php';
require_once 'utilities/user.php';

	if (!is_user_loggedin()) {
		header("Location: index.php");
		return;
	}

	if(isset($_GET['user_id'])) {
		$user_id = $_GET['user_id'];
	}

	$users = get_users_who_are_followed($user_id);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="style.css">
		<title>Home</title>
	</head>
	<body>
		
		<?php include "header.php";?>

		<div style="text-align: center">
			<h1>User details who commented on this post.</h1>
			<?php
			if ($users != null):
				foreach($users as $user):
					$user_name = $user["user_full_name"];
			?>
			<div class="username"><?=$user_name?></div>
			<?php
			endforeach;
			endif;
			?>
		</div>
	</body>
</html>
