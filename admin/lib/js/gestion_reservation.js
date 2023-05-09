$(document).ready(() => {

    // Annulation d'une réservation d'un client
    $(".cancel").click(function () {
        if (confirm("Annuler ?")) {
            const row = $(this).parent().parent();

            let idChambre = row.find("#chambre").text();
            let dateDebut = row.find("#date_debut").text();
            let dateFin = row.find("#date_fin").text();

            $.ajax({
                type: "GET",
                data: 'debut=' + dateDebut + "&fin=" + dateFin + "&id_chambre=" + idChambre,
                url: "./lib/php/ajax/cancel_reservation.php",
                success: () => {
                    let row = $(this).closest("tr");

                    row.css("background-color", "red");
                    row.fadeOut('slow');
                }
            });
        }
    });

});