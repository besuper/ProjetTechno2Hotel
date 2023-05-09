<?php

if (!isset($_GET["id"])) {
	header('Location: ./index.php?page=clients.php');
	return;
}

$idClient = $_GET["id"];

$clientBD = new ClientBD($cnx);
$client = $clientBD->getClientByID($idClient);

$villeBD = new VilleBD($cnx);
$villes = $villeBD->getAll();

$paysBD = new PaysBD($cnx);
$pays = $paysBD->getAll();

$reservationBD = new ReservationBD($cnx);
$reservations = $reservationBD->getClientReservations($client['id_client']);

// Formulaire de modification
$errors = [];

if(isset($_POST["submit"])) {
	extract($_POST);

	if (empty($rue)) {
		$errors["rue"] = "Indiquez la rue";
	}

	if (empty($num_rue)) {
		$errors["num_rue"] = "Indiquez le numéro de rue";
	}

	if (empty($errors)) {
		$clientBD->hydrate(array(
			"id_client" => $client["id_client"],
			"nom" => $client["nom_client"],
			"prenom" => $client["prenom_client"],
			"mail" => $client["mail_client"],
			"rue" => $rue,
			"numero_rue" => $num_rue,
			"id_ville" => $choix_ville,
			"id_pays" => $choix_pays
		));

		$executed = $clientBD->update();

		if($executed) {
			$client['rue'] = $rue;
			$client['numero_rue'] = $num_rue;
			$client['id_ville'] = $choix_ville;
			$client['id_pays'] = $choix_pays;
		}else {
			$errors["global"] = "Impossible de mettre a jour le client";
		}
	}
}

?>


<script src="lib/js/gestion_reservation.js"></script>

<div class="container-fluid mt-4">
	<h1>Informations du client</h1>

	<div class="row">
		<div class="col-3">
			<label for="nom" class="form-label">Nom du client</label>
			<input type="text" class="form-control" id="nom" name="nom" value="<?php echo $client['nom_client']; ?>"
				   disabled>
		</div>

		<div class="col-3">
			<label for="nom" class="form-label">Prenom du client</label>
			<input type="text" class="form-control" id="nom" name="nom" value="<?php echo $client['prenom_client']; ?>"
				   disabled>
		</div>
	</div>

	<div class="row mt-4">
		<div class="col-6">
			<label for="email" class="form-label">Adresse email</label>
			<input type="email" class="form-control" id="email" name="email"
				   value="<?php echo $client['mail_client']; ?>" disabled>
		</div>
	</div>

	<form method="POST">
		<div class="row mt-4">
			<div class="col-4">
				<label for="rue" class="form-label">Rue</label>
				<input type="text" class="form-control" id="rue" name="rue" value="<?php echo $client['rue']; ?>">

				<div id="error" class="form-text text-danger"><?php echo isset($errors["rue"]) ? $errors["rue"] : ''; ?></div>
			</div>

			<div class="col-2">
				<label for="num_rue" class="form-label">N°</label>
				<input type="number" min="0" class="form-control" id="num_rue" name="num_rue"
					   value="<?php echo $client['numero_rue']; ?>">

				<div id="error" class="form-text text-danger"><?php echo isset($errors["num_rue"]) ? $errors["num_rue"] : ''; ?></div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-3">
				<label for="choix_ville" class="form-label">Ville</label>
				<select class="form-select" id="choix_ville" name="choix_ville">
					<?php
					for ($i = 0; $i < count($villes); $i++) {
						$ville = $villes[$i];
						$id = $ville->id_ville;
						$nom = $ville->nom;

						echo '<option value="' . $id . '">' . $nom . '</option>';
					}

					?>
				</select>

				<div id="error" class="form-text text-danger"><?php echo isset($errors["ville"]) ? $errors["ville"] : ''; ?></div>
			</div>

			<div class="col-3">
				<label for="choix_pays" class="form-label">Pays</label>
				<select class="form-select" id="choix_pays" name="choix_pays">
					<?php
					for ($i = 0; $i < count($pays); $i++) {
						$ville = $pays[$i];
						$id = $ville->id_pays;
						$nom = $ville->nom;

						echo '<option value="' . $id . '">' . $nom . '</option>';
					}

					?>
				</select>

				<div id="error" class="form-text text-danger"><?php echo isset($errors["pays"]) ? $errors["pays"] : ''; ?></div>
			</div>
		</div>

		<div id="error" class="form-text text-danger mt-4"><?php echo isset($errors["global"]) ? $errors["global"] : ''; ?></div>

		<button type="submit" class="btn btn-primary mt-4" name="submit">Modifier</button>
	</form>

	<div class="row mt-4">
		<div class="col-4 d-flex align-items-center">
			<h1>Réservations</h1>

			<a class="btn btn-primary ms-4" href="index.php?page=ajout_reservation.php&client=<?php echo $client["id_client"]; ?>">
				Ajouter
			</a>
		</div>
	</div>

	<div class="row col-8">
		<?php
		if(count($reservations) > 0) {
			?>
			<table class="table table-striped mb-4 ms-2">
				<thead>
				<tr>
					<th scope="col">Date debut</th>
					<th scope="col">Date fin</th>
					<th scope="col">Nbr personne</th>
					<th scope="col">Cout</th>
					<th scope="col">Chambre</th>
					<th scope="col">Actions</th>
				</tr>
				</thead>
				<tbody>
				<?php
				for ($i = 0; $i < count($reservations); $i++) {
					$res = $reservations[$i];

					echo '
                <tr id="row_reservation">
                    <td name="date_debut" id="date_debut">' . $res->rest_date_debut . '</td>
                    <td name="date_fin" id="date_fin">' . $res->res_date_fin . '</td>
                    <td name="personne" id="personne">' . $res->personne . '</td>
                    <td name="cout" id="cout">' . $res->cout . '</td>
                    <td name="chambre" id="chambre">' . $res->id_chambre . '</td>
                    <td name="actions" id="actions">
                   		<button class="btn btn-danger cancel">Annuler</button>
                   	</td>
                </tr>
                ';
				}

				?>
				</tbody>
			</table>
			<?php
		}else {
			echo '<p>Aucune réservation</p>';
		}

		?>
	</div>
</div>
