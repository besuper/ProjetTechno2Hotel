<?php

$id_chambre = $_GET["id"];

$chambreBD = new ChambreBD($cnx);
$chambre = $chambreBD->getChambreByID($id_chambre);

$optionBD = new OptionBD($cnx);
$options = $optionBD->getChambreOptions($id_chambre);

echo '
<div class="container">
	<div class="row">
		<div class="col-6">
			<img src="admin/images/' . $chambre["image_chambre"] . '" style="width: 600px;">
		</div>
		
		<div class="col-4">
			<h1>Chambre ' . $chambre["id_chambre"] . ': ' . $chambre["nom_chambre"] . '</h1>
			
			<p>' . $chambre["description"] . '</p>
	
			<p>Prix par nuit : <strong>' . $chambre["prix"] . '€</strong></p>
			<p>Nombre de lit(s) : <strong>' . $chambre["lit"] . '€</strong></p>

';

if($options != NULL) {
	echo '<h3>Options</h3>';

	echo '<p>';

	for($i = 0; $i < count($options); $i++) {
		$option = $options[$i];

		echo $option->nom_options.'</br>';
	}

	echo '</p>';
}

echo '
		<button class="btn btn-success" id="reserver" data-bs-toggle="modal" data-bs-target="#reserverModal">Reserver</button>
		
		</div>
	</div>
</div>';

?>

<div class="modal fade" id="reserverModal" tabindex="-1" aria-labelledby="reserverModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="reserverModalLabel">Reserver une chambre</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				Pour reserver une chambre appelez nous : 069 78 45 12
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
			</div>
		</div>
	</div>
</div>
