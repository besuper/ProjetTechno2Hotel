$(document).ready(() => {

    // Filtre
    $("#filter").keyup(function () {
        let filtre = $(this).val().toLowerCase();

        $("tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(filtre) > -1);
        });
    });

    // Suppression d'une chambre
    $(".delete").click(function () {
        if(confirm("Supprimer ?")) {
            let idChambre = $(this).attr("id");
            let row = $(this).closest("tr");

            row.css("background-color", "red");
            row.fadeOut('slow');

            $.ajax({
                type: "GET",
                data: 'id=' + idChambre,
                url: "./lib/php/ajax/delete_chambre.php",
                success: () => {}
            });
        }
    });

    // Image hover
    const gl_image_chambre = $("#gl_image_chambre");
    gl_image_chambre.hide();

    $("tr[id='row_chambre']").each(function () {
        $(this).hover(function (a) {
            if (a.type === "mouseenter") {
                gl_image_chambre.attr("src", "images/" + $(this).attr("name") + ".jpg");
                gl_image_chambre.show();
            } else {
                gl_image_chambre.hide();
            }
        });
    });

    // Update
    $("td[contenteditable]").click(function () {
        let val1 = $(this).text();
        let id = $(this).attr("id");
        let name = $(this).attr("name");

        $(this).blur(function () {
            let val2 = $(this).text();

            if (val1 !== val2) {
                let param = "champ=" + name + "&id=" + id + "&val=" + val2;

                console.log(param);

                $.ajax({
                    type: "GET",
                    data: param,
                    url: "./lib/php/ajax/update_chambre.php",
                    success: () => {}
                });
            }
        });
    });
});