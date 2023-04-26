$(document).ready(() => {

    // Filtre
    $("#filter").keyup(function () {
        let filtre = $(this).val().toLowerCase();

        $("tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(filtre) > -1);
        });
    });

});