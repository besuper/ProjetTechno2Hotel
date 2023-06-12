<?php

require_once '../../vendor/autoload.php';

require '../lib/php/pgConnect.php';
require '../lib/php/classes/Connexion.class.php';

require '../lib/php/classes/Reservation.class.php';
require '../lib/php/classes/ReservationBD.class.php';

require '../lib/php/classes/Client.class.php';
require '../lib/php/classes/ClientBD.class.php';

require '../lib/php/classes/Chambre.class.php';
require '../lib/php/classes/ChambreBD.class.php';

$cnx = Connexion::getInstance($dsn, $user, $pass);

$reservationBD = new ReservationBD($cnx);
$reservation = $reservationBD->getReservationByID($_GET["id"]);

$clientBD = new ClientBD($cnx);
$client = $clientBD->getClientByID($reservation["id_client"]);

$chambreBD = new ChambreBD($cnx);
$chambre = $chambreBD->getChambreByID($reservation["id_chambre"]);

$mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML('<h1>Réservation</h1>');
$mpdf->WriteHTML('<p>Du ' . $reservation["res_date_debut"] . ' au ' . $reservation["res_date_fin"] . '</p>');
$mpdf->WriteHTML('<p>Prix: ' . $reservation["cout"] . '€</p>');

$mpdf->WriteHTML('<br>');
$mpdf->WriteHTML('<h1>Client</h1>');
$mpdf->WriteHTML('<p>Numéro de client: ' . $client["id_client"] . '</p>');
$mpdf->WriteHTML('<p>Nom: ' . $client["nom_client"] . '</p>');
$mpdf->WriteHTML('<p>Prénom: ' . $client["prenom_client"] . '</p>');

$mpdf->WriteHTML('<br>');
$mpdf->WriteHTML('<h1>Chambre</h1>');
$mpdf->WriteHTML('<p>Numéro de chambre: ' . $chambre["id_chambre"] . '</p>');
$mpdf->WriteHTML('<p>Nom: ' . $chambre["nom_chambre"] . '</p>');

$mpdf->Output();
?>