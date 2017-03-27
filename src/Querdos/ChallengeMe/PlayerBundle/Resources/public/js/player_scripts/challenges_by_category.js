/**
 * Created by querdos on 3/23/17.
 */

$(document).ready(function() {
    var buttonsSolve         = $(".buttonSolveChallenge");
    var buttonRate           = $(".buttonRateChallenge");
    var buttonStartChallenge = $("#buttonStartChallenge");
    var buttonRateChallenge  = $("#rateChallenge")

    var challengeDescription = $("#challengeDescription");
    var modalRateTitle       = $("#modal-rate-title");

    // on the button solve click
    buttonsSolve.on('click', function() {
        // setting description for information
        challengeDescription.html(
            $(this).attr("data_challenge")
        );

        buttonStartChallenge.attr(
            "url_start",
            $(this).attr("url_start")
        );

        // setting onclick setting for the start button
        buttonStartChallenge.attr(
            'onclick',
            "window.location.href='" + $(this).attr("url_start") + "'"
        );
    });

    // on the button rate click
    buttonRate.on('click', function() {
        var chal_name   = $(this).attr("challenge_name");
        var chal_id     = $(this).attr("challenge_id");

        modalRateTitle.html("Rate <b>" + chal_name + "</b>");
        $("#hiddenChallengeId").attr("value", chal_id);
    });

    buttonRateChallenge.on('click', function() {
        // sending ajax request
        $.ajax({
            url: url_rate_challenge,
            type: "POST",
            data: $("#formRating").serialize(),
            success: function() {
                location.reload();
            }
        })
    });
});