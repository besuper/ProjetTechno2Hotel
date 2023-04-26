<?php

require '../pgConnect.php';
require '../classes/Connexion.class.php';
require '../classes/Chambre.class.php';
require '../classes/ChambreBD.class.php';
$cnx = Connexion::getInstance($dsn,$user,$pass);

$fl = new ClientBD($cnx);
$fl->delete($_GET["id"]);
