<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home Page</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<link rel="stylesheet" href="../main.css">

	<style>
	</style>
</head>
<body style="background-image: url('guardians.jpg')">

	<?php include 'nav.php'; ?>

	<div style="text-align:center; display: block" class="container">
		<div class="row">
			<h1 class="main-header col-12 mt-4 mb-4">What would you like to do?</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">
		<div class="row">
			<div class="col-12 col-md-6">
				<a href="search_form.php" class="button-details text btn btn-primary btn-lg btn-block mt-4 mt-md-2" role="button">Search for Movies</a>
			</div>
		

		<?php if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ) : ?>

			<div class="text col-12 col-md-6">
				<a href="add_form.php" class="button-details text btn btn-primary btn-lg btn-block mt-4 mt-md-2" role="button">Add a Movie</a>
			</div>


		<?php endif; ?>


		</div> <!-- .row -->
	</div> <!-- .container -->


	
</body>
</html>


