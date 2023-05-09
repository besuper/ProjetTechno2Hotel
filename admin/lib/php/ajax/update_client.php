<?php

require '../pgConnect.php';
require '../classes/Connexion.class.php';
require '../classes/Client.class.php';
require '../classes/ClientBD.class.php';
$cnx = Connexion::getInstance($dsn,$user,$pass);

$fl = new ClientBD($cnx);
$fl->updateClient($_GET["id"], $_GET["champ"], $_GET["val"]);
