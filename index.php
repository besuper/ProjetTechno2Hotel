<?php
session_start(); //pour utiliser les variables de session

include 'admin/lib/php/adminListeInclude.php';

?>

<!doctype html>
<html lang="fr">
<head>
	<title>Hotel</title>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="admin/lib/css/custom.css"/>
</head>
<body>
<div id="wrapper">
	<nav id="nav">
		<?php
		if (file_exists('./lib/php/menuPublic.php')) {
			include('./lib/php/menuPublic.php');
		}
		?>
	</nav>
	<section id="main">
		<?php
		if (!isset($_SESSION['page'])) {
			$_SESSION['page'] = "accueil.php";
		}
		if (isset($_GET['page'])) {
			$_SESSION['page'] = $_GET['page'];
		}
		$path = './pages/' . $_SESSION['page'];

		if (file_exists($path)) {
			include($path);
		} else {
			include('./pages/404.php');
		}

		?>
	</section>
</div>
</body>
<footer id="footer"></footer>
</html>