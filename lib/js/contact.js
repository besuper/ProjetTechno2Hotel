$(document).ready(() => {

    function setError(message) {
        $("#error").text(message);
    }

    const email = $("#email").find("input");
    const sujet = $("#sujet");
    const message = $("#message");
    const submitBtn = $("#submit");

    sujet.hide();
    message.hide();
    submitBtn.hide();

    email.blur(function() {
        const content = email.val();

        if(content === undefined || content.length === 0) {
            setError("Veuillez entrer une adresse email!");
            return;
        }

        setError("");

        sujet.fadeIn(200);
    });

    sujet.find("input").blur(function() {
        const content = $(this).val();

        if(content === undefined || content.length === 0) {
            setError("Veuillez entrer un sujet!");
            return;
        }

        setError("");

        message.fadeIn(200);
    });

    message.find("textarea").blur(function() {
        const content = $(this).val();

        if(content === undefined || content.length === 0) {
            setError("Veuillez entrer un message!");
            return;
        }

        setError("");

        submitBtn.fadeIn(200);
    });

    let submited = false;

    $("#contact").submit(function(event) {
        event.preventDefault();

        if(!submited) {
            submited = true;

            $("#success").text("Message envoyé!");

            email.prop("disabled", true);
            sujet.find("input").prop("disabled", true);
            message.find("textarea").prop("disabled", true);

            // gerer envoi message ajax...
        }
    });

});