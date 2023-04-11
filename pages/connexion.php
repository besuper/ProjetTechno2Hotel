<?php

if (isset($_POST["submit"])) {
	$admin = new AdminBD($cnx);

	$login = $_POST["login"];
	$password = $_POST["password"];

	$resp = $admin->isAdmin($login, $password);

	if ($resp) {
		$_SESSION['admin'] = true;

		header("Location: admin/index.php?page=accueil.php");
	} else {
		echo 'Mauvais mot de passe ou utilisateur !!';
	}
}

?>
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
        <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
