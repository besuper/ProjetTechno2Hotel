<?php

header('Content-Type: application/json');

require '../pgConnect.php';
require '../classes/Connexion.class.php';
require '../classes/Option.class.php';
require '../classes/OptionBD.class.php';
$cnx = Connexion::getInstance($dsn,$user,$pass);

$fl = new OptionBD($cnx);
$fl->hydrate(array(
	"nom_option" => $_GET["nom_option"],
	"supplement" => $_GET["supplement"]
));

$insert = $fl->insert();

if(array_key_exists("id_options", $insert)) {
	print json_encode(array("success" => true, "id" => $insert["id_options"]));
	return;
}

print json_encode(array("success" => false));