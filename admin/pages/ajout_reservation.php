<?php

if(!isset($_GET["client"])) {
	header("Location: index.php?page=clients.php");
	return;
}

$errors = [];
$id_client = $_GET["client"];

$clientBD = new ClientBD($cnx);
$client = $clientBD->getClientByID($id_client);

$chambreBD = new ChambreBD($cnx);
$chambres = $chambreBD->getAllChambres();

if (isset($_POST["submit"])) {
	extract($_POST);

	if (empty($dateDebut)) {
		$errors["dateDebut"] = "La date de réservation ne peut pas être vide!";
	}

	if (empty($duree)) {
		$errors["duree"] = "La durée ne peut pas être vide!";
	}

	if (empty($errors)) {
		$chambre = $chambreBD->getChambreByID($choix_chambre);

		$fl = new ReservationBD($cnx);
		$fl->hydrate(array(
			"date_debut" => $dateDebut,
			"date_debut_2" => $dateDebut,
			"duree" => $duree,
			"personne" => 1,
			"cout" => $chambre["prix"],
			"id_client" => $id_client,
			"id_chambre" => $choix_chambre
		));

		$executed = $fl->insert();

		var_dump($executed);

		if (array_key_exists('ajout_reservation', $executed)) {
			header("Location: ./index.php?page=client.php&id=" . $id_client );
		} else {
			$errors["global"] = "Impossible d'ajouter la réservation";
		}
	}
}

?>

<script src="lib/js/gestion_options.js"></script>

<div class="container-fluid mt-4">
	<h1>Ajout d'une réservation</h1>

	<form method="POST" enctype="multipart/form-data">
		<div class="row">
			<div class="col-3">
				<label for="nom" class="form-label">Nom</label>
				<input type="text" class="form-control" id="nom" name="nom" value="<?php echo $client['nom_client']; ?>" disabled>
			</div>

			<div class="col-3">
				<label for="prenom" class="form-label">Prenom</label>
				<input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $client['prenom_client']; ?>" disabled>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-3">
				<label for="dateDebut" class="form-label">Date debut</label>
				<input type="text" class="form-control" id="dateDebut" name="dateDebut">

				<div id="error" class="form-text text-danger"><?php echo isset($errors["dateDebut"]) ? $errors["dateDebut"] : ''; ?></div>
			</div>

			<div class="col-3">
				<label for="duree" class="form-label">Duree (jours)</label>
				<input type="number" min="1" class="form-control" id="duree" name="duree">

				<div id="error" class="form-text text-danger"><?php echo isset($errors["duree"]) ? $errors["duree"] : ''; ?></div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-6">
				<label for="chambre" class="form-label">Choix de la chambre</label>
				<select class="form-select" id="chambre" name="choix_chambre" aria-label="Default select example">
					<?php
					for($i = 0; $i < count($chambres); $i++) {
						$chambre = $chambres[$i];

						echo '<option value="'.$chambre->id_chambre.'">'.$chambre->nom_chambre.' | Prix: '.$chambre->prix.'€</option>';
					}

					?>
				</select>
			</div>
		</div>

		<div id="error" class="form-text text-danger mt-4"><?php echo isset($errors["global"]) ? $errors["global"] : ''; ?></div>

		<button type="submit" class="btn btn-primary mt-4" name="submit">Ajouter</button>
	</form>

</div>