<?php

if(!isset($_GET["id"])){
	header('Location: ./index.php?page=clients.php');
	return;
}

$idClient = $_GET["id"];

$clientBD = new ClientBD($cnx);
$client = $clientBD->getClientByID($idClient);


?>
<div class="container-fluid mt-4">
	<h1>Informations du client</h1>

	<div class="row">
		<div class="col-3">
			<label for="nom" class="form-label">Nom du client</label>
			<input type="text" class="form-control" id="nom" name="nom" value="<?php echo $client['nom_client']; ?>" disabled>
		</div>

		<div class="col-3">
			<label for="nom" class="form-label">Prenom du client</label>
			<input type="text" class="form-control" id="nom" name="nom" value="<?php echo $client['prenom_client']; ?>" disabled>
		</div>
	</div>

	<div class="row mt-4">
		<div class="col-6">
			<label for="email" class="form-label">Adresse email</label>
			<input type="email" class="form-control" id="email" name="email" value="<?php echo $client['mail_client'];?>" disabled>
		</div>
	</div>
</div>
