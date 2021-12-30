<?php
require_once 'utilities/blogposts.php';
require_once 'utilities/user.php';

if (!is_user_loggedin()) {
	header("Location: index.php");
	return;
}

$blogposts = get_all_posts();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<!-- <link rel="stylesheet" href="style.css"> -->
	<title>Home</title>
</head>

<body>

	<?php include "header.php"; ?>

	<div style="text-align: center">
		<h1 class="display-1">This is home page</h1>
		<?php
		if ($blogposts != null) :
			foreach ($blogposts as $blogpost) :
				$author = $blogpost["user_full_name"];
				$post_id = $blogpost["post_id"];
				$post_title = $blogpost["post_title"];
				$post_body = $blogpost["post_body"];
				$likes = $blogpost["likes"];
				$reads = $blogpost["_reads"];
				$comments = $blogpost["_comments"];
				$post_date = $blogpost["post_date"]; // String object
				$post_date = date_create($post_date); // DateTime object
				$post_date = date_format($post_date, "jS, F, Y.");
		?>
				<div class="card mt-2 bg-light" style="width: 80%; margin:auto;">
					<div class="card-body">
						<h5 class="card-title display-5"><?= $post_title ?></h5>
						<div class="container">
							<div class="row border-bottom">
								<span class="col card-subtitle text-muted mb-2">By <?= $author ?></span>
								<span class="col card-subtitle text-muted mb-2"> Posted on: <?= $post_date ?></span>
							</div>
							<div class="row">
								<div class="col">
									<?= $post_body ?> <a href="post.php?id=<?= $post_id ?>">Read more...</a>
								</div>
							</div>
							<div class="row border-top mt-2">
								<div class="col">
									<?php if ($likes > 0) : ?>
										<a href="postlikes.php?id=<?= $post_id ?>">
										<?php endif; ?>
										<span><?= $likes ?> Likes</span>
										<?php if ($likes > 0) : ?>
										</a>
									<?php endif; ?>
								</div>
								<div class="col">
									<?php if ($reads > 0) : ?>
										<a href="postreads.php?id=<?= $post_id ?>">
										<?php endif; ?>
										<span><?= $reads ?> Reads</span>
										<?php if ($reads > 0) : ?>
										</a>
									<?php endif; ?>
								</div>
								<div class="col ">
									<?php if ($comments > 0) : ?>
										<a href="postcomments.php?id=<?= $post_id ?>">
										<?php endif; ?>
										<span><?= $comments ?> Comments</span>
										<?php if ($comments > 0) : ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
		<?php
			endforeach;
		endif;
		?>
	</div>
</body>

</html>