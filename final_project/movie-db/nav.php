<head>
	<link rel="stylesheet" href="../main.css">
</head>
<nav style="background-color: #fff6e0" class="container-fluid p-2">
	<div class="row">
		<div class="text col-12 d-flex">

		<?php if ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false ) : ?>

			<a class="nav-text text-center p-2 ml-auto" href="../login/login.php">Login</a>

		<?php else : ?>

			<div class="nav-text text-center p-2 ml-auto">Hello <?php echo $_SESSION['username']; ?>!</div>

		<?php endif; ?>

			<a class="nav-text text-center p-2" href="../login/logout.php">Logout</a>

		</div>
	</div> <!-- .row -->
</nav>