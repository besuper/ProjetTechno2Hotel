<?php

if(file_exists("./lib/php/pgConnect.php")) {
	// partie admin
	require './lib/php/pgConnect.php';
	require './lib/php/classes/Autoloader.class.php';
}else if(file_exists("admin/lib/php/pgConnect.php")) {
	// partie publique
	require 'admin/lib/php/pgConnect.php';
	require 'admin/lib/php/classes/Autoloader.class.php';
}

Autoloader::register();
$cnx = Connexion::getInstance($dsn, $user, $pass);