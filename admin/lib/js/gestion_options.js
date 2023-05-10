$(document).ready(() => {

    $("#ajouterOptionBtn").click(function() {
        const errorOption = $("#errorOption");

        const nomOption = $("#nameOption").val();
        const supplement = $("#supplementOption").val();

        if(nomOption.length == 0) {
            errorOption.text("Entrez le nom de l'option");
            return;
        }

        if(supplement.length == 0) {
            errorOption.text("Entrez un supplement");
            return;
        }

        $.ajax({
            type: "GET",
            datatype: 'json',
            data: 'nom_option=' + nomOption + '&supplement=' + supplement,
            url: "./lib/php/ajax/ajout_option.php",
            success: (data) => {
                if(data.success) {
                    $('#ajoutOption').modal('hide');

                    $("#options").append(`<option value="${data.id}">${nomOption} | Supplément : ${supplement}€</option>`);

                    $("#nameOption").val("");
                    $("#supplementOption").val(0);
                }
            }
        });
    });

});