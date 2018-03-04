<?php
session_start();
require '../config/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Form</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="../main.css">


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
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Results</a></li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="text col-12 mt-4 mb-4">Edit a Movie</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<?php

		if ( !isset($_GET['dvd_title_id']) || empty($_GET['dvd_title_id']) ) :

			echo "Invalid DVD ID";

		else :

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

		$sql_dvd = "SELECT * 
		FROM dvd_titles 
		WHERE dvd_title_id = " . $_GET['dvd_title_id'] . ";";

		$results_genres = $mysqli->query($sql_genres);
		$results_rating = $mysqli->query($sql_rating);
		$results_labels = $mysqli->query($sql_labels);
		$results_formats = $mysqli->query($sql_formats);
		$results_sounds = $mysqli->query($sql_sounds);

		$results_dvd = $mysqli->query($sql_dvd);

		if ( !$results_genres || !$results_rating || !$results_labels 
			|| !$results_formats || !$results_sounds || !$results_dvd ) :

		?>

		<div>
			SQL Error:
			<?php echo $mysqli->error; ?>
		</div>

		<?php
		else :

			$row_dvd = $results_dvd->fetch_assoc();

				// var_dump($row_dvd);

		?>

		<form action="update.php" method="POST">

			<div class="form-group row">
				<label for="dvd-title-id" class="text col-sm-3 col-form-label text-sm-right">DVD Title: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="dvd-title-id" name="dvd_title" 
					value="<?php echo $row_dvd['title']; ?>">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="genre-id" class="text col-sm-3 col-form-label text-sm-right">Genre:</label>
				<div class="col-sm-9">
					<select name="genre" id="genre-id" class="form-control">
						<option value="" selected disabled>-- Select One --</option>

						<?php while( $row = $results_genres->fetch_assoc() ): 


						if ( !empty($row_dvd['genre_id']) &&  $row_dvd['genre_id'] == $row['genre_id']) :

			// Found genre for current dvd.

							?>

						<option value="<?php echo $row['genre_id']; ?>" selected>
							<?php echo $row['genre']; ?>
						</option>

						<?php

						else :

							?>
						<option value="<?php echo $row['genre_id']; ?>">
							<?php echo $row['genre']; ?>
						</option>
						<?php

						endif;

						?>





					<?php endwhile; ?>
				</select>
			</div>
		</div> <!-- .form-group -->

		<div class="form-group row">
			<label for="rating-id" class="text col-sm-3 col-form-label text-sm-right">Rating:</label>
			<div class="col-sm-9">
				<select name="rating" id="rating-id" class="form-control">
					<option value="" selected disabled>-- Select One --</option>

					<?php while( $row = $results_rating->fetch_assoc() ): 


					if ( $row_dvd['rating_id'] == $row['rating_id'] ) :

						?>

					<option value="<?php echo $row['rating_id']; ?>" selected>
						<?php echo $row['rating']; ?>
					</option>

					<?php

					else :

						?>

					<option value="<?php echo $row['rating_id']; ?>">
						<?php echo $row['rating']; ?>
					</option>

					<?php

					endif;
					?>

				<?php endwhile; ?>

			</select>
		</div>
	</div> <!-- .form-group -->

	<div class="form-group row">
		<label for="label-id" class="text col-sm-3 col-form-label text-sm-right">Label:</label>
		<div class="col-sm-9">
			<select name="label" id="label-id" class="form-control">
				<option value="" selected disabled>-- Select One --</option>

				<?php while( $row = $results_labels->fetch_assoc() ): 


				if ( $row_dvd['label_id'] == $row['label_id'] ) :

					?>

				<option value="<?php echo $row['label_id']; ?>" selected>
					<?php echo $row['label']; ?>
				</option>

				<?php

				else :

					?>

				<option value="<?php echo $row['label_id']; ?>">
					<?php echo $row['label']; ?>
				</option>

				<?php

				endif;
				?>

			<?php endwhile; ?>
		</select>
		</div>
	</div> <!-- .form-group -->

	<div class="form-group row">
		<label for="format-id" class="text col-sm-3 col-form-label text-sm-right">Format:</label>
		<div class="col-sm-9">
			<select name="format" id="format-id" class="form-control">
				<option value="" selected disabled>-- Select One --</option>

				<?php while( $row = $results_formats->fetch_assoc() ): 


				if ( $row_dvd['format_id'] == $row['format_id'] ) :

					?>

				<option value="<?php echo $row['format_id']; ?>" selected>
					<?php echo $row['format']; ?>
				</option>

				<?php

				else :

					?>

				<option value="<?php echo $row['format_id']; ?>">
					<?php echo $row['format']; ?>
				</option>

				<?php

				endif;
				?>

			<?php endwhile; ?>
		</select>
		</div>
	</div> <!-- .form-group -->

	<div class="form-group row">
		<label for="sound-id" class="text col-sm-3 col-form-label text-sm-right">Sound:</label>
		<div class="col-sm-9">
			<select name="sound" id="sound-id" class="form-control">
				<option value="" selected disabled>-- Select One --</option>

				<?php while( $row = $results_sounds->fetch_assoc() ): 


				if ( $row_dvd['sound_id'] == $row['sound_id'] ) :

					?>

				<option value="<?php echo $row['sound_id']; ?>" selected>
					<?php echo $row['sound']; ?>
				</option>

				<?php

				else :	

					?>

				<option value="<?php echo $row['sound_id']; ?>">
					<?php echo $row['sound']; ?>
				</option>

				<?php

				endif;
				?>

			<?php endwhile; ?>
		</select>
		</div>
	</div> <!-- .form-group -->

<div class="form-group row">
	<label for="award-id" class="text col-sm-3 col-form-label text-sm-right">Award:</label>
	<div class="col-sm-9">
		<input type="text" name="award" id="award-id" class="form-control"
		value="<?php echo $row_dvd['award']; ?>">
	</div>
</div> <!-- .form-group -->

<div class="form-group row">
	<label for="award-id" class="text col-sm-3 col-form-label text-sm-right">Release Date:</label>
	<div class="col-sm-9">
		<input type="text" name="release_date" id="date-id" class="form-control"
		value="<?php echo $row_dvd['release_date']; ?>">
	</div>
</div> <!-- .form-group -->

<div class="form-group row">
	<div class="ml-auto col-sm-9">
		<span class="text-danger font-italic">* Required</span>
	</div>
</div> <!-- .form-group -->

<input type="hidden" 
name="dvd_id" 
value="<?php echo $row_dvd['dvd_title_id']; ?>">

<div class="form-group row">
	<div class="col-sm-3"></div>
	<div class="col-sm-9 mt-2">
		<button type="submit" class="button-details btn btn-primary">Submit</button>
		<button type="reset" class="button-details btn btn-light">Reset</button>
	</div>
</div> <!-- .form-group -->

</form>


<?php 
endif; /* SQL Error ELSE Statement */

$mysqli->close();

endif; /* Connection Error ELSE Statement */

endif; /* Missing dvd ID ELSE Statement */

?>

</div> <!-- .container -->
</body>
</html>