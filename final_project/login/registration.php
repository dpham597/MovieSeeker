<?php
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register | Recipe Database</title>
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

	<div class="container">
		<div class="row">
			<h1 class="text col-12 mt-4 mb-4">User Registration</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<form action="register.php" method="POST">		

			<div class="row mb-3">
				<div id="form-error" class="col-sm-9 ml-sm-auto font-italic text-danger">
				</div>
			</div> <!-- .row -->

			<div class="form-group row">
				<label for="email-id" class="text col-sm-3 col-form-label text-sm-right">Email: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<input type="email" class="form-control" id="email-id" name="email">
				</div>
			</div> <!-- .form-group -->	

			<div class="form-group row">
				<label for="username-id" class="text col-sm-3 col-form-label text-sm-right">Username: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="username-id" name="username">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="password-id" class="text col-sm-3 col-form-label text-sm-right">Password: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<input type="password" class="form-control" id="password-id" name="password">
				</div>
			</div> <!-- .form-group -->

			<div class="row">
				<div class="ml-auto col-sm-9">
					<span class="text text-danger font-italic">* Required</span>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-3">
					<button type="submit" class="button-details text btn btn-primary">Register</button>
					<a href="../song-db" role="button" class="button-details text btn btn-light">Cancel</a>
				</div>
			</div> <!-- .form-group -->

			<div class="row">
				<div class="col-sm-9 ml-sm-auto">
					<a href="login.php" class="text">Already have an account</a>
				</div>
			</div> <!-- .row -->

		</form>

	</div> <!-- .container -->

	<script>

		document.querySelector('form').onsubmit = function(){

			if ( document.querySelector('#email-id').value.trim().length == 0
				|| document.querySelector('#username-id').value.trim().length == 0
				|| document.querySelector('#password-id').value.trim().length == 0 ) {

				document.querySelector('#form-error').innerHTML = 'Please fill out all required fields.';

				return false;
				
			}
		}

	</script>

</body>
</html>