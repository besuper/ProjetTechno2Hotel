<?php

require '../pgConnect.php';
require '../classes/Connexion.class.php';
require '../classes/Reservation.class.php';
require '../classes/ReservationBD.class.php';
$cnx = Connexion::getInstance($dsn,$user,$pass);

$fl = new ReservationBD($cnx);
$fl->cancel($_GET["debut"], $_GET["fin"], $_GET["id_chambre"]);
