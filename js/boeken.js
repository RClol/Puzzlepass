document.addEventListener("DOMContentLoaded", function () {

    // Get the booking form
    const bookingForm = document.getElementById("bookingForm");

    // Get player selector and summary
    const playersSelect = document.getElementById("players");
    const playersSummary = document.getElementById("summaryPlayers");

    // Update the number of players in the booking summary
    if (playersSelect && playersSummary) {
        playersSelect.addEventListener("change", function () {
            playersSummary.textContent = this.value;
        });
    }

    // Prevent submitting the form multiple times
    if (bookingForm) {
        bookingForm.addEventListener("submit", function () {

            const submitButton = bookingForm.querySelector(
                'button[type="submit"], input[type="submit"]'
            );

            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = "Boeking wordt verwerkt...";
            }
        });
    }

});