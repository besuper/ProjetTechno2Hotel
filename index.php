<?php
session_start(); //pour utiliser les variables de session

include 'admin/lib/php/adminListeInclude.php';

$erreur = "";

if (isset($_POST["submit"])) {
	$admin = new AdminBD($cnx);

	$login = $_POST["login"];
	$password = $_POST["password"];

	$resp = $admin->isAdmin($login, $password);

	if ($resp) {
		$_SESSION['admin'] = true;

		header("Location: admin/index.php?page=accueil.php");
	} else {
		$erreur = 'Mauvais mot de passe ou utilisateur';
	}
}

?>

<!doctype html>
<html lang="fr">
<head>
	<title>Hotel</title>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
			integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
			crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
			integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
			crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.4.min.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css"
		  href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="./admin/lib/css/custom.css"/>
</head>
<body>
<div class="container h-100">
	<div class="d-flex flex-column justify-content-center align-items-center h-100">
		<h2>Se connecter</h2>
		<div class="col-3 ps-3">
			<form method="POST">

				<div class="mb-3">
					<label for="login" class="form-label">Login</label>
					<input type="text" class="form-control" id="login" name="login">
				</div>

				<div class="mb-3">
					<label for="password" class="form-label">Password</label>
					<input type="password" class="form-control" id="password" name="password">
				</div>

				<p class="text-danger"><?php echo empty($erreur) ? '' : $erreur; ?></p>

				<button type="submit" name="submit" id="submit" class="btn btn-primary">Connection</button>
			</form>
		</div>
	</div>
</div>
</body>
</html>