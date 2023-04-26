<?php
$fl = new ClientBD($cnx);
$clients = $fl->getAll();
$nbr = count($clients);
?>

<script src="lib/js/filter.js"></script>
<script src="lib/js/gestion_clients.js"></script>

<div class="container mt-4">
    <div class="row">
        <div class="col-8">
            <p>
                <input type="text" class="form-control" id="filter" placeholder="Filtrer"/>
            </p>

            <a class="btn btn-primary mb-2" href="index.php?page=ajout_client.php">Ajouter client</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prenom</th>
                    <th scope="col">Mail</th>
                    <th scope="col">Adresse</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <form method="get">
					<?php
					for ($i = 0; $i < $nbr; $i++) {
						$cl = $clients[$i];

						echo '
                <tr id="row_client" name="' . $cl->nom_client . '">
                    <th name="id_client" id="id_client">' . $cl->id_client . '</th>
                    <td contenteditable="true" name="nom" id="' . $cl->nom_client . '">' . $cl->nom_client . '</td>
                    <td contenteditable="true" name="prenom" id="' . $cl->prenom_client . '">' . $cl->prenom_client . '</td>
                    <td contenteditable="true" name="mail" id="' . $cl->mail_client . '">' . $cl->mail_client . '</td>
                    <td contenteditable="false" name="adresse">' . $cl->rue . ', ' . $cl->numero_rue . ' ' . $cl->ville . ' ' . $cl->pays . '</td>
                    <td id="' . $cl->id_client . '">
                        <a href="index.php?page=client.php&id=1" class="btn btn-primary">Voir</a>
                        <i class="bi bi-trash-fill btn btn-danger delete"></i>
                    </td>
                </tr>
                ';
					}

					?>
                </form>
                </tbody>
            </table>
        </div>
    </div>
</div>