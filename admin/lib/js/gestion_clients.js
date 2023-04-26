$(document).ready(() => {

    // Suppression d'un client
    $(".delete").click(function () {
        if(confirm("Supprimer ?")) {
            let idClient = $(this).parent().attr("id");

            $.ajax({
                type: "GET",
                data: 'id=' + idClient,
                url: "./lib/php/ajax/delete_client.php",
                success: () => {
                    let row = $(this).closest("tr");

                    row.css("background-color", "red");
                    row.fadeOut('slow');
                }
            });
        }
    });

    // Update
    $("td[contenteditable]").click(function () {
        let val1 = $(this).text();
        let id = $(this).attr("id");
        let name = $(this).attr("name");

        $(this).blur(function () {
            let val2 = $(this).text();

            if (val1 !== val2) {
                $.ajax({
                    type: "GET",
                    data: "champ=" + name + "&id=" + id + "&val=" + val2,
                    url: "./lib/php/ajax/update_chambre.php",
                    success: () => {}
                });
            }
        });
    });
});