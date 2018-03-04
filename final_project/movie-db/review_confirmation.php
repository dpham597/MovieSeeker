<?php
	session_start();
	require '../config/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Confirmation</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="../main.css">

</head>
<body>

	<?php include 'nav.php'; ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Review</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="text col-12 mt-4">Add a Review</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">

	<?php

		if ( !isset($_POST['dvd_title_id']) || empty($_POST['dvd_title_id'])
			|| !isset($_POST['review_text']) || empty($_POST['review_text'])) :

			echo "Required field is missing.";

		?>

			<div class="text-danger">Please fill out all required fields.</div>

		<?php

		else :
			// All required fields present.

			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, USER_DB_NAME);

			if ($mysqli->connect_errno) :
				// DB Error
				echo $mysqli->connect_error;
			else :
				// Connection Succuess

				$sql = "INSERT INTO reviews (username, movie_id, review_desc)
								VALUES ('"
					. $_POST['username']
					. "', "
					. $_POST['dvd_title_id']
					.", '" 
					. $_POST['review_text'] 
					. "');";
			
				// echo $sql . "<hr>";

				$results = $mysqli->query($sql);

				if (!$results) :
					// SQL Error
					echo $mysqli->error;
				
				$sql = "INSERT INTO movies (dvd_title_id)
							VALUES ("
						. $_POST['dvd_title_id']
						. ");";

				$results = $mysqli->query($sql);

				else :

				if (!$results) :
					// SQL Error
					echo $mysqli->error;

				else :
					// SQL Success
	?>
				<div class="text-success"><span class="font-italic"> Your review was successfully added.</span></div>

	<?php
				endif; /* SQL Error */
				$mysqli->close();
			endif; /* DB Connection Connection Error */
		endif; /* Required input validtion */
		endif;
	?>

			</div> <!-- .col -->
		</div> <!-- .row -->

		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="button-details text btn btn-primary">Back to Review Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->

	</div> <!-- .container -->

</body>
</html>