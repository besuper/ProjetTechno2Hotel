<?php
$fl = new ReservationBD($cnx);
$reservations = $fl->getAllReservations();
$nbr = count($reservations);
?>

<script src="lib/js/filter.js"></script>

<div class="container mt-4">
    <div class="row">
        <div class="col-8">
            <p>
                <input type="text" class="form-control" id="filter" placeholder="Filtrer"/>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Date debut</th>
                    <th scope="col">Date fin</th>
                    <th scope="col">Cout</th>
                    <th scope="col">Chambre</th>
                    <th scope="col">Client</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <form method="get">
					<?php
					for ($i = 0; $i < $nbr; $i++) {
						$res = $reservations[$i];

						echo '
                <tr>
                    <th>' . $res->id_reservation . '</th>
                    <td>' . $res->res_date_debut . '</td>
                    <td>' . $res->res_date_fin . '</td>
                    <td>' . $res->cout . '</td>
                    <td>' . $res->id_chambre . '</td>
                    <td><a href="index.php?page=client.php&id='.$res->id_client.'">' . $res->id_client . '</a></td>
                    <td><a href="pages/pdf.php?id='.$res->id_reservation.'" target="_blank"><i class="bi bi-download"></i></a></td>
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