<?php

if(!isset($_GET["client"])) {
	header("Location: index.php?page=chambres.php");
	return;
}

$errors = [];

if (isset($_POST["submit"])) {
	extract($_POST);

	if (empty($nom)) {
		$errors["nom"] = "Le champ nom ne peut pas être vide!";
	}

	if (empty($prix)) {
		$errors["prix"] = "Le prix ne peut pas être vide!";
	}

	if (empty($lits)) {
		$errors["lits"] = "Iniquez le nombre de lits";
	}

	if (empty($description)) {
		$errors["description"] = "La description ne peut pas être vide!";
	}

	$check = getimagesize($_FILES["image"]["tmp_name"]);

	if (!$check) {
		$errors["image"] = "Erreur lors de l'upload de l'image";
	}

	$target_dir = "./images/";
	$target_file = $target_dir . basename($_FILES["image"]["name"]);

	if (file_exists($target_file)) {
		$errors["image"] = "Cette image éxiste déjà";
	}

	if (empty($errors)) {
		$fl = new ChambreBD($cnx);
		$fl->hydrate(array(
			"nom" => $nom,
			"prix" => $prix,
			"lit" => $lits,
			"description" => $description,
			"image" => $_FILES["image"]["name"]
		));

		$executed = $fl->insert();

		if (array_key_exists('id_chambre', $executed)) {
			$fl->id_chambre = $executed["id_chambre"];

			if (isset($options)) {
				// $options

				for ($j = 0; $j < count($options); $j++) {
					$option = $options[$j];

					$fl->ajoutOption($option);
				}
			}

			if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
				// tout est ok
				//header("Location: ./index.php?page=chambres.php");
			} else {
				$errors["global"] = "Impossible d'upload l'image";
			}
		} else {
			$errors["global"] = "Impossible d'ajouter la nouvelle chambre";
		}
	}
}

$id_client = $_GET["client"];

$clientBD = new ClientBD($cnx);
$client = $clientBD->getClientByID($id_client);

$chambreBD = new ChambreBD($cnx);
$chambres = $chambreBD->getAllChambres();

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
			</div>

			<div class="col-3">
				<label for="duree" class="form-label">Duree (jours)</label>
				<input type="number" min="1" class="form-control" id="duree" name="duree">
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-6">
				<label for="chambre" class="form-label">Choix de la chambre</label>
				<select class="form-select" id="chambre" aria-label="Default select example">
					<?php
					for($i = 0; $i < count($chambres); $i++) {
						$chambre = $chambres[$i];

						echo '<option value="'.$chambre->id_chambre.'">'.$chambre->nom_chambre.' | Prix: '.$chambre->prix.'€</option>';
					}

					?>
				</select>

				<div id="error" class="form-text text-danger"><?php echo isset($errors["prix"]) ? $errors["prix"] : ''; ?></div>
			</div>
		</div>

		<div id="error"
			 class="form-text text-danger mt-4"><?php echo isset($errors["global"]) ? $errors["global"] : ''; ?></div>

		<button type="submit" class="btn btn-primary mt-4" name="submit">Ajouter</button>
	</form>

	<div class="modal fade" id="ajoutOption" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter une option</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<label for="nameOption" class="form-label">Nom de l'option</label>
					<input type="text" class="form-control" id="nameOption" name="nameOption">

					<label for="supplementOption" class="form-label">Supplement</label>
					<input type="number" min="0" class="form-control" id="supplementOption" name="supplementOption">

					<div id="errorOption" class="form-text text-danger mt-4"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
					<button type="button" class="btn btn-primary" id="ajouterOptionBtn">Ajouter</button>
				</div>
			</div>
		</div>
	</div>

</div>