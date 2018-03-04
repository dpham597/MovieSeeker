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
		<li class="breadcrumb-item"><a href="add_form.php">Add</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="text col-12 mt-4">Add a Movie</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">

	<?php
		// var_dump($_POST);

		if ( !isset($_POST['dvd_title']) || empty($_POST['dvd_title'])) :

			// Required field is missing.

		?>

			<div class="text-danger">Please fill out all required fields.</div>

		<?php

		else :
			// All required fields present.

			// $host = "";
			// $user = "";
			// $pass = "";
			// $db = "";

			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

			if ($mysqli->connect_errno) :
				// DB Error
				echo $mysqli->connect_error;
			else :
				// Connection Succuess

				$genre_id = "null";
				$rating_id = "null";
				$label_id = "null";
				$format_id = "null";
				$sound_id = "null";
				$award = "null";
				$release_date = "null";

				if ( isset($_POST['genre']) && !empty($_POST['genre']) ) {
					$genre_id = $_POST['genre'];
				}

				if ( isset($_POST['rating']) && !empty($_POST['rating']) ) {
					$rating_id = $_POST['rating'];
				}

				if ( isset($_POST['label']) && !empty($_POST['label']) ) {
					$label_id = $_POST['label'];
				}

				if ( isset($_POST['format']) && !empty($_POST['format']) ) {
					$format_id = $_POST['format'];
				}

				if ( isset($_POST['sound']) && !empty($_POST['sound']) ) {
					$sound_id = $_POST['sound'];
				}

				if ( isset($_POST['award']) && !empty($_POST['award']) ) {
					$award = "'" . $_POST['award'] . "'";
				}

				if ( isset($_POST['release_date']) && !empty($_POST['release_date']) ) {
					$release_date = "'" . $_POST['release_date'] . "'";
				}


				$sql = "INSERT INTO dvd_titles (title, release_date, award, label_id, sound_id, genre_id, rating_id, format_id)
								VALUES ('"
					. $_POST['dvd_title']
					. "', " 
					. $release_date
					. ", "
					. $award
					. ", "
					. $label_id
					. ", "
					. $sound_id
					. ", "
					. $genre_id
					. ", "
					. $rating_id
					. ", " 
					. $format_id
					. ");";

				// echo $sql . "<hr>";

				$results = $mysqli->query($sql);

				if (!$results) :
					// SQL Error
					echo $mysqli->error;
				else :
					// SQL Success
	?>
				<div class="text-success"><span class="font-italic"><?php echo $_POST['dvd_title']; ?></span> was successfully added.</div>

	<?php
				endif; /* SQL Error */
				$mysqli->close();
			endif; /* DB Connection Connection Error */
		endif; /* Required input validtion */
	?>

			</div> <!-- .col -->
		</div> <!-- .row -->

		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="add_form.php" role="button" class="btn btn-primary">Back to Add Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->

	</div> <!-- .container -->

</body>
</html>