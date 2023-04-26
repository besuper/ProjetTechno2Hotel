<?php

$villeBD = new VilleBD($cnx);
$villes = $villeBD->getAll();

$paysBD = new PaysBD($cnx);
$pays = $paysBD->getAll();

$errors = [];

if (isset($_POST["submit"])) {
	extract($_POST);

	if (empty($nom)) {
		$errors["nom"] = "Le champ nom ne peut pas être vide!";
	}

	if (empty($prenom)) {
		$errors["prenom"] = "Le prenom ne peut pas être vide!";
	}

	if (empty($email)) {
		$errors["email"] = "Iniquez l'adresse email du client";
	}

	if (empty($rue)) {
		$errors["rue"] = "Indiquez la rue";
	}

	if (empty($num_rue)) {
		$errors["num_rue"] = "Indiquez le numéro de rue";
	}

	if (empty($errors)) {
		$newClient = new ClientBD($cnx);
		$newClient->hydrate(array(
			"nom" => $nom,
			"prenom" => $prenom,
			"mail" => $email,
			"rue" => $rue,
			"numero_rue" => $numero_rue,
			"id_ville" => $choix_ville,
			"id_pays" => $choix_pays
		));

		$executed = $newClient->insert();

		if($executed) {
			header("Location: ./index.php?page=clients.php");
		}else {
			$errors["global"] = "Impossible d'ajouter le client";
		}
	}
}

?>
<div class="container-fluid mt-4">
	<h1>Ajout d'un client</h1>

	<form method="POST" enctype="multipart/form-data">
		<div class="row">
			<div class="col-3">
				<label for="nom" class="form-label">Nom du client</label>
				<input type="text" class="form-control" id="nom" name="nom">

				<div id="error" class="form-text text-danger"><?php echo isset($errors["nom"]) ? $errors["nom"] : ''; ?></div>
			</div>

			<div class="col-3">
				<label for="prenom" class="form-label">Prénom du client</label>
				<input type="text" class="form-control" id="prenom" name="prenom">

				<div id="error" class="form-text text-danger"><?php echo isset($errors["prenom"]) ? $errors["prenom"] : ''; ?></div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-6">
				<label for="email" class="form-label">Adresse email</label>
				<input type="email" class="form-control" id="email" name="email">

				<div id="error" class="form-text text-danger"><?php echo isset($errors["email"]) ? $errors["email"] : ''; ?></div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-4">
				<label for="rue" class="form-label">Rue</label>
				<input type="text" class="form-control" id="rue" name="rue">

				<div id="error" class="form-text text-danger"><?php echo isset($errors["rue"]) ? $errors["rue"] : ''; ?></div>
			</div>

			<div class="col-2">
				<label for="num_rue" class="form-label">N°</label>
				<input type="number" min="0" class="form-control" id="num_rue" name="num_rue">

				<div id="error" class="form-text text-danger"><?php echo isset($errors["num_rue"]) ? $errors["num_rue"] : ''; ?></div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-3">
				<label for="choix_ville" class="form-label">Ville</label>
				<select class="form-select" id="choix_ville" name="choix_ville">
					<?php
						for($i = 0; $i < count($villes); $i++){
							$ville = $villes[$i];
							$id = $ville->id_ville;
							$nom = $ville->nom;

							echo '<option value="'.$id.'">'.$nom.'</option>';
						}

					?>
				</select>

				<div id="error" class="form-text text-danger"><?php echo isset($errors["ville"]) ? $errors["ville"] : ''; ?></div>
			</div>

			<div class="col-3">
				<label for="choix_pays" class="form-label">Pays</label>
				<select class="form-select" id="choix_pays" name="choix_pays">
					<?php
					for($i = 0; $i < count($pays); $i++){
						$ville = $pays[$i];
						$id = $ville->id_pays;
						$nom = $ville->nom;

						echo '<option value="'.$id.'">'.$nom.'</option>';
					}

					?>
				</select>

				<div id="error" class="form-text text-danger"><?php echo isset($errors["pays"]) ? $errors["pays"] : ''; ?></div>
			</div>
		</div>

		<div id="error" class="form-text text-danger mt-4"><?php echo isset($errors["global"]) ? $errors["global"] : ''; ?></div>

		<button type="submit" class="btn btn-primary mt-4" name="submit">Ajouter</button>
	</form>
</div>
