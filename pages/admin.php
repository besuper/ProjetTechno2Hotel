<?php

$erreur = "";

if (isset($_POST["submit"])) {
	$admin = new AdminBD($cnx);

	$login = $_POST["login"];
	$password = $_POST["password"];

	$resp = $admin->isAdmin($login, $password);

	if ($resp) {
		$_SESSION['admin'] = true;

		header("Location: admin/index.php?page=chambres.php");
	} else {
		$erreur = 'Mauvais mot de passe ou utilisateur';
	}
}

?>
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
