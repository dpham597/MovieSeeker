<?php
session_start();
require '../config/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Confirmation | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
</head>
<body>

	<?php include 'nav.php'; ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Edit</a></li>
		<li class="breadcrumb-item active">Update</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="text col-12 mt-4">Edit a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">

	<?php
		// var_dump($_POST);

		if ( !isset($_POST['dvd_title'])) :
			// Required field is missing.

		?>

			<div class="text-danger">Please fill out all required fields.</div>

		<?php

		else :
			// All required fields present.

	
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

				$sql = "UPDATE dvd_titles
								SET title = '" . $_POST['dvd_title'] ."',
								genre_id = ". $genre_id .",
								rating_id = ". $rating_id . ",
								label_id = ". $label_id .",
								format_id = ". $format_id .",
								sound_id = ". $sound_id .",
								award = ". $award .",
								release_date = ". $release_date ."
								WHERE dvd_title_id = ".$_POST['dvd_id'].";";

				// echo $sql . "<hr>";

				$results = $mysqli->query($sql);

				if (!$results) :
					// SQL Error
					echo $mysqli->error;
				else :
					// SQL Success
	?>
				<div class="text-success"><span class="font-italic"><?php echo $_POST['dvd_title']; ?></span> was successfully updated.</div>

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
				<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="button-details btn btn-primary">Back to Edit Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->

	</div> <!-- .container -->

</body>
</html>