<?php
session_start();
require '../config/config.php';

$page_url = $_SERVER['REQUEST_URI'];

$page_url = preg_replace('/&page=\d+/', '', $page_url);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Movie Search Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="../main.css">
	<style>	
		a:link {
			color:#29db4d;
		}
		a:visited{
			color:#258f5a;
		}


	</style>

</head>
<body>

	<?php include 'nav.php'; ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item active">Results</li>
	</ol>
	
	<div class="container-fluid">
		<div class="row">
			<h1 class="text col-12 mt-4">Movie Search Results</h1>
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->

	<div class="container-fluid">

		<div class="row mb-4 mt-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="button-details btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->

		<div class="row">
			<div class="col-12">

	<?php

	// 1. Establish DB Connection.
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if ( $mysqli->connect_errno ) :
		// Connection Error.
		echo $mysqli->connect_error;
	else :
		// Connection Success.

		$mysqli->set_charset('utf8');

		$sql_num_rows = "SELECT COUNT(*) AS count
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
						WHERE 1=1";

		if ( isset($_GET['dvd_title']) && !empty($_GET['dvd_title']) ) {					
			$sql_num_rows .= " AND dvd_titles.title LIKE '%" . $_GET['dvd_title'] . "%'";
		}

		if ( isset($_GET['genre']) && !empty($_GET['genre']) ) {
			$sql_num_rows .= " AND dvd_titles.genre_id = " . $_GET['genre'];
		}

		if ( isset($_GET['rating']) && !empty($_GET['rating']) ) {
			$sql_num_rows .= " AND dvd_titles.rating_id = " . $_GET['rating'];
		}

		if ( isset($_GET['label']) && !empty($_GET['label']) ) {
			$sql_num_rows .= " AND dvd_titles.label_id = " . $_GET['label'];
		}

		if ( isset($_GET['format']) && !empty($_GET['format']) ) {
			$sql_num_rows .= " AND dvd_titles.format_id = " . $_GET['format'];
		}

		if ( isset($_GET['sound']) && !empty($_GET['sound']) ) {
			$sql_num_rows .= " AND dvd_titles.sound_id = " . $_GET['sound'];
		}

		if ( $_GET['award'] == 'yes') {					
			$sql_num_rows .= " AND dvd_titles.award IS NOT NULL";
		} else if ( $_GET['award'] == 'no') {
			$sql_num_rows .= " AND dvd_titles.award IS NULL";
		}

		$sql_num_rows .= ";";

		//var_dump($sql_num_rows);

		$results_num_rows = $mysqli->query($sql_num_rows);

		/* Check for results error here. */

		$row_num_rows = $results_num_rows->fetch_assoc();

		$num_results = $row_num_rows['count'];

		$results_per_page = 5;

		$last_page = ceil($num_results / $results_per_page);

		if ( isset($_GET['page']) && !empty($_GET['page']) ) {
			$current_page = $_GET['page'];
		} else {
			$current_page = 1;
		}

		if ($current_page < 1) {
			$current_page = 1;
		} elseif ($current_page > $last_page) {
			$current_page = $last_page;
		}

		$start_index = ($current_page - 1) * $results_per_page;

		// 2. Generate & Submit SQL Query.
		$sql = "SELECT dvd_titles.dvd_title_id AS dvd_title_id, dvd_titles.title AS dvd_title, dvd_titles.release_date AS release_date, dvd_titles.award AS award, genres.genre AS genre_name, ratings.rating AS rating_name, labels.label AS label_name, formats.format AS format_name, sounds.sound AS sound_name
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
									WHERE 1=1";

							
		if ( isset($_GET['dvd_title']) && !empty($_GET['dvd_title']) ) {					
			$sql .= " AND dvd_titles.title LIKE '%" . $_GET['dvd_title'] . "%'";
		}

		if ( isset($_GET['genre']) && !empty($_GET['genre']) ) {
			$sql .= " AND dvd_titles.genre_id = " . $_GET['genre'];
		}

		if ( isset($_GET['rating']) && !empty($_GET['rating']) ) {
			$sql .= " AND dvd_titles.rating_id = " . $_GET['rating'];
		}

		if ( isset($_GET['label']) && !empty($_GET['label']) ) {
			$sql .= " AND dvd_titles.label_id = " . $_GET['label'];
		}

		if ( isset($_GET['format']) && !empty($_GET['format']) ) {
			$sql .= " AND dvd_titles.format_id = " . $_GET['format'];
		}

		if ( isset($_GET['sound']) && !empty($_GET['sound']) ) {
			$sql .= " AND dvd_titles.sound_id = " . $_GET['sound'];
		}

		if ( $_GET['award'] == 'yes') {					
			$sql .= " AND dvd_titles.award IS NOT NULL";
		} else if ( $_GET['award'] == 'no') {
			$sql .= " AND dvd_titles.award IS NULL";
		}

		$sql .= " LIMIT " . $start_index . ", " . $results_per_page;

		$sql .= ";";

		// echo $sql . "<hr>";

		$results = $mysqli->query($sql);

		if (!$results) :
			// SQL Error.
			echo $mysqli->error;
		else :
			// Results Received.

	?>


			<div class="col-12">
				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center">
						<li class="page-item <?php echo ($current_page==1) ? 'disabled' : ''; ?>">
							<a class="page-link" href="<?php echo $page_url . '&page=1'; ?>">First</a>
						</li>
						<li class="page-item <?php echo ($current_page==1) ? 'disabled' : ''; ?>">
							<a class="page-link" href="<?php echo $page_url . '&page=' . ($current_page-1); ?>">Previous</a>
						</li>
						<li class="page-item active">
							<a class="page-link" href=""><?php echo $current_page; ?></a>
						</li>
						<li class="page-item <?php echo ($current_page==$last_page) ? 'disabled' : ''; ?>">
							<a class="page-link" href="<?php echo $page_url . '&page=' . ($current_page+1); ?>">Next</a>
						</li>
						<li class="page-item <?php echo ($current_page==$last_page) ? 'disabled' : ''; ?>">
							<a class="page-link" href="<?php echo $page_url . '&page=' . $last_page; ?>">Last</a>
						</li>
					</ul>
				</nav>
			</div> <!-- .col -->


				<div class="text">
					Your search returned <?php echo $results->num_rows; ?> result(s).
				</div>

				<table class="text table table-hover table-responsive mt-4">
					<thead>
						<tr>
							<th>Movie Title</th>
							<th>Release Date</th>
							<th>Award</th>
							<th>Genre</th>
							<th>Rating</th>
							<th>Label</th>
							<th>Format</th>
							<th>Sound</th>
						</tr>
					</thead>
					<tbody>

		<?php
			while ( $row = $results->fetch_assoc() ) :
		?>
			<tr>
				<td>
					<a href="details.php?dvd_title_id=<?php echo $row['dvd_title_id']; ?>">
					<?php echo $row['dvd_title']; ?>		
					</a>

<?php if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ) : ?>
	<div>
		<a href="review.php?dvd_title_id=<?php echo $row['dvd_title_id']; ?>" class="btn btn-outline-secondary mt-2">REVIEW</a>

		<a href="edit.php?dvd_title_id=<?php echo $row['dvd_title_id']; ?>" class="btn btn-outline-secondary mt-2">EDIT</a>

		<a href="delete.php?dvd_title_id=<?php echo $row['dvd_title_id']; ?>&dvd_title=<?php echo $row['dvd_title'] ?>" class="btn btn-outline-secondary mt-2" 
			onclick="return confirm('Are you sure you want to delete <?php echo $row['dvd_title']; ?>?');">DELETE</a>
	</div>
<?php endif; ?>

				</td>
				<td><?php echo $row['release_date']; ?></td>
				<td><?php echo $row['award']; ?></td>
				<td><?php echo $row['genre_name']; ?></td>
				<td><?php echo $row['rating_name']; ?></td>
				<td><?php echo $row['label_name']; ?></td>
				<td><?php echo $row['format_name']; ?></td>
				<td><?php echo $row['sound_name']; ?></td>
			</tr>
		<?php
			endwhile;
		?>


					</tbody>

				</table>

				<div class="col-12">
					<nav aria-label="Page navigation example">
						<ul class="pagination justify-content-center">
							<li class="page-item <?php echo ($current_page==1) ? 'disabled' : ''; ?>">
								<a class="page-link" href="<?php echo $page_url . '&page=1'; ?>">First</a>
							</li>
							<li class="page-item <?php echo ($current_page==1) ? 'disabled' : ''; ?>">
								<a class="page-link" href="<?php echo $page_url . '&page=' . ($current_page-1); ?>">Previous</a>
							</li>
							<li class="page-item active">
								<a class="page-link" href=""><?php echo $current_page; ?></a>
							</li>
							<li class="page-item <?php echo ($current_page==$last_page) ? 'disabled' : ''; ?>">
								<a class="page-link" href="<?php echo $page_url . '&page=' . ($current_page+1); ?>">Next</a>
							</li>
							<li class="page-item <?php echo ($current_page==$last_page) ? 'disabled' : ''; ?>">
								<a class="page-link" href="<?php echo $page_url . '&page=' . $last_page; ?>">Last</a>
							</li>
						</ul>
					</nav>
				</div> <!-- .col -->

	<?php
			endif; /* ELSE Results Received */
		$mysqli->close();
	endif; /* ELSE Connection Success */
	?>

			</div> <!-- .col -->
		</div> <!-- .row -->

		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->

	</div> <!-- .container-fluid -->

</body>
</html>