<?php
	session_start();


	if ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false ) {
		header('Location: index.php');
	}

	require '../config/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add a Review</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">

	<style>
	.form-check-label {
		padding-top: calc(.5rem - 1px * 2);
		padding-bottom: calc(.5rem - 1px * 2);
		margin-bottom: 0;
	}
</style>
</head>
<body>

	<?php include 'nav.php'; ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item active">Review</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="text col-12 mt-4 mb-4">Add a Review</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<?php

				// 1. Establish DB Connection
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if ( $mysqli->connect_errno ) :

			?>
			<div>
				MySQL Connection Error:
				<?php echo $mysqli->connect_error; ?>
			</div>

		<?php else: ?>

			<?php

			$mysqli->set_charset('utf8');

		$sql_genres = "SELECT * FROM genres;";
		$sql_rating = "SELECT * FROM ratings;";
		$sql_labels = "SELECT * FROM labels;";
		$sql_formats = "SELECT * FROM formats;";
		$sql_sounds = "SELECT * FROM sounds;";

		$results_genres = $mysqli->query($sql_genres);
		$results_rating = $mysqli->query($sql_rating);
		$results_labels = $mysqli->query($sql_labels);
		$results_formats = $mysqli->query($sql_formats);
		$results_sounds = $mysqli->query($sql_sounds);

		if (!$results_genres || !$results_rating || !$results_labels
			|| !$results_formats || !$results_sounds) :
		?>

				<div>
					SQL Error:
					<?php echo $mysqli->error; ?>
				</div>

				<?php
			else :
				?>

				<form action="review_confirmation.php" method="POST">

					<div class="form-group row">
						<label for="text-id" class="text col-sm-3 col-form-label text-sm-right">Review: <span class="text-danger">*</span></label>
						<div class="col-sm-9">
							<textarea class="form-control" rows="15" id="text-id" name="review_text"></textarea>
						</div>
					</div> <!-- .form-group -->

					
					<div class="form-group row">
						<label for="review-num-id" class="text col-sm-3 col-form-label text-sm-right">Rating: <span class="text-danger">*</span></label>
						<div class="col-sm-9">
							<select name="review-num" id="review-num-id" class="form-control">
								<option value="" selected>Choose</option>
								<option value="1" >1</option>
								<option value="2" >2</option>
								<option value="3" >3</option>
								<option value="4" >4</option>
								<option value="5" >5</option>
							</select>

						</div>
					</div> <!-- .form-group -->

					<input type="hidden" name="username" value="<?php echo $_SESSION['username'] ?>">
					<input type="hidden" name="dvd_title_id" value="<?php echo $_GET['dvd_title_id'] ?>">


					<div class="form-group row">
						<div class="ml-auto col-sm-9">
							<span class="text-danger font-italic">* Required</span>
						</div>
					</div> <!-- .form-group -->
					
					<div class="form-group row">
						<div class="col-sm-3"></div>
						<div class="col-sm-9 mt-2">
							<button type="submit" class="button-details text btn btn-primary">Submit</button>
							<button type="reset" class="button-details text btn btn-light">Reset</button>
						</div>
					</div> <!-- .form-group -->

				</form>


				<?php 
			endif; /* SQL Error ELSE Statement */

			$mysqli->close();

		endif; /* Connection Error ELSE Statement */

		?>

	</div> <!-- .container -->
</body>
</html>