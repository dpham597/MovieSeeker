<?php
session_start();
require '../config/config.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Movie Details</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="../main.css">

</head>
<body>

	<?php include 'nav.php'; ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item active">Details</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="text col-12 mt-4">Movie Details</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">
	<?php
	if (!isset($_GET['dvd_title_id']) || empty($_GET['dvd_title_id'])) :
		echo "Invalid DVD ID";
	else :


	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if ($mysqli->connect_errno) :
		echo $mysqli->connect_error;
	else :
		// Connection success
		$mysqli->set_charset('utf8');

		$sql = "SELECT dvd_titles.title AS dvd_title, dvd_titles.release_date AS release_date, dvd_titles.award AS award, genres.genre AS genre_name, ratings.rating AS rating_name, labels.label AS label_name, formats.format AS format_name, sounds.sound AS sound_name
									FROM dvd_titles
									LEFT JOIN genres
										ON dvd_titles.genre_id = genres.genre_id
									LEFT JOIN ratings
										ON ratings.rating_id = dvd_titles.rating_id
									LEFT JOIN labels
										ON labels.label_id = dvd_titles.label_id
									LEFT JOIN formats 
										ON formats.format_id = dvd_titles.format_id
									LEFT JOIN sounds
										ON sounds.sound_id = dvd_titles.sound_id
									
									WHERE dvd_title_id = "
									. $_GET['dvd_title_id']
						.";";
		// echo $sql . "<hr>";
				$results = $mysqli->query($sql);

				if (!$results) :
					echo $mysqli->$error;
				else :

					$row = $results->fetch_assoc();

					// var_dump($row);
	?>

				<table class="table table-responsive">

					<tr>
						<th class="text text-right">DVD Name:</th>
						<td class="text"><?php echo $row['dvd_title']; ?></td>
					</tr>

					<tr>
						<th class="text text-right">Release Date</th>
						<td class="text"><?php echo $row['release_date']; ?></td>
					</tr>

					<tr>
						<th class="text text-right">Award:</th>
						<td class="text"><?php echo $row['award']; ?></td>
					</tr>

					<tr>
						<th class="text text-right">Label:</th>
						<td class="text"><?php echo $row['label_name']; ?></td>
					</tr>

					<tr>
						<th class="text text-right">Sound:</th>
						<td class="text"><?php echo $row['sound_name']; ?></td>
					</tr>

					<tr>
						<th class="text text-right">Genre:</th>
						<td class="text"><?php echo $row['genre_name']; ?></td>
					</tr>

					<tr>
						<th class="text text-right">Rating:</th>
						<td class="text"><?php echo $row['rating_name']; ?></td>
					</tr>

					<tr>
						<th class="text text-right">Format:</th>
						<td class="text"><?php echo $row['format_name']; ?></td>
					</tr>

				</table>

<?php
			endif; /* SQL Error */
		$mysqli->close();
	endif; /* DB Connection Error */
endif; /* Missing Track ID */
?>

			</div> <!-- .col -->
		</div> <!-- .row -->

		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-primary">Back to Search Results</a>
			</div> <!-- .col -->
		</div> <!-- .row -->

	</div> <!-- .container -->

</body>
</html>