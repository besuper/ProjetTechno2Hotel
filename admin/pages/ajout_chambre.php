<?php

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

			if(isset($options)) {
				// $options

				for($j = 0; $j < count($options); $j++) {
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

$optionsBD = new OptionBD($cnx);
$options = $optionsBD->getAll();

?>

<script src="lib/js/gestion_options.js"></script>

<div class="container-fluid mt-4">
	<h1>Ajout d'une chambre</h1>

	<form method="POST" enctype="multipart/form-data">
		<div class="row">
			<div class="col-6">
				<label for="nom" class="form-label">Nom de chambre</label>
				<input type="text" class="form-control" id="nom" name="nom">

				<div id="error"
					 class="form-text text-danger"><?php echo isset($errors["nom"]) ? $errors["nom"] : ''; ?></div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-3">
				<label for="prix" class="form-label">Prix</label>
				<input type="number" min="0" class="form-control" id="prix" name="prix">

				<div id="error"
					 class="form-text text-danger"><?php echo isset($errors["prix"]) ? $errors["prix"] : ''; ?></div>
			</div>

			<div class="col-3">
				<label for="lits" class="form-label">Nombre de lits</label>
				<input type="number" min="0" class="form-control" id="lits" name="lits">

				<div id="error"
					 class="form-text text-danger"><?php echo isset($errors["lits"]) ? $errors["lits"] : ''; ?></div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-6">
				<label for="description" class="form-label">Description</label>
				<textarea class="form-control" placeholder="Description de la chambre" name="description"
						  id="description" style="height: 100px"></textarea>

				<div id="error"
					 class="form-text text-danger"><?php echo isset($errors["description"]) ? $errors["description"] : ''; ?></div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-4">
				<label for="image" class="form-label">Image</label>
				<input class="form-control" type="file" name="image" id="image">

				<div id="error"
					 class="form-text text-danger"><?php echo isset($errors["image"]) ? $errors["image"] : ''; ?></div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-6">
				<div class="d-flex">
					<label for="options" class="form-label">Options</label>
					<span class="btn btn-primary ms-4 mb-2" data-bs-toggle="modal" data-bs-target="#ajoutOption">
						Ajouter
					</span>
				</div>

				<select class="form-select" multiple id="options" name="options[]" aria-label="multiple select example">
					<?php
					for ($i = 0; $i < count($options); $i++) {
						$option = $options[$i];

						echo '<option value="' . $option->id_options . '">' . $option->nom_options . ' | Supplément : ' . $option->supplement . '€</option>';
					}

					?>
				</select>
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