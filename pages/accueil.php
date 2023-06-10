<?php

$chambre = new ChambreBD($cnx);
$chambres = $chambre->getAllChambres();

?>

<div class="container">

	<h2>Nos chambres</h2>

	<div class="row">
		<?php
			for($i = 0; $i < count($chambres); $i++) {
				$chambre = $chambres[$i];

				echo '
					<div class="col-4 mb-4">
						<div class="card" >
							<a href="index.php?page=chambre.php&id='. $chambre->id_chambre .'">
								<img src="admin/images/'.$chambre->image_chambre.'" class="card-img-top" style="height: 300px;">
							</a>
							<div class="card-body">
								<h5 class="card-title">' . $chambre->nom_chambre . '</h5>
								<p class="card-text">' . $chambre->description . '</p>
								<p class="card-text">Prix/nuit: <strong>' . $chambre->prix . '€</strong></p>
							</div>
						</div>
					</div>
				';
			}

		?>
	</div>
</div>
