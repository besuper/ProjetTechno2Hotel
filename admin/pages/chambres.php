<?php
$fl = new ChambreBD($cnx);
$chambres = $fl->getAllChambres();
$nbr = count($chambres);
?>

<script src="lib/js/gestion_chambres.js"></script>

<div class="fluid-container ps-4">
    <div class="row">
        <div class="col-8">
            <p>
                <input type="text" class="form-control" id="filter" placeholder="Filtrer"/>
            </p>

            <a class="btn btn-primary" href="index.php?page=ajout_chambre.php">Ajouter chambre</a>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prix</th>
                    <th scope="col">Lit</th>
                    <th scope="col">Description</th>
                    <th scope="col">Image</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <form method="get">
					<?php
					for ($i = 0; $i < $nbr; $i++) {
						$chambre = $chambres[$i];

						echo '
                <tr id="row_chambre" name="' . $chambre->nom_chambre . '">
                    <th name="id_chambre" id="id_chambre">' . $chambre->id_chambre . '</th>
                    <td contenteditable="true" name="nom" id="' . $chambre->id_chambre . '">' . $chambre->nom_chambre . '</td>
                    <td contenteditable="true" name="prix" id="' . $chambre->id_chambre . '">' . $chambre->prix . '</td>
                    <td contenteditable="true" name="lit" id="' . $chambre->id_chambre . '">' . $chambre->lit . '</td>
                    <td contenteditable="true" name="description" id="' . $chambre->id_chambre . '">' . $chambre->description . '</td>
                    <td contenteditable="true" name="image" id="' . $chambre->id_chambre . '">' . $chambre->image_chambre . '</td>
                    <td id="' . $chambre->id_chambre . '" class="delete"><i class="bi bi-trash-fill text-danger pointer"></i></td>
                </tr>
                ';
					}

					?>
                </form>
                </tbody>
            </table>
        </div>
        <div class="col-4">
            <div class="d-flex justify-content-center">
                <img src="" id="gl_image_chambre" alt="Aucune image"/>
            </div>
        </div>
    </div>
</div>