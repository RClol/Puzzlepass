<!DOCTYPE html>
<html lang="nl">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Boeken - Puzzlepass</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/boeken.css">

</head>

<body>

    <!-- NAVBAR -->

    <header class="navbar">

        <a href="index.php" class="logo">
            Puzzle<span>pass</span>
        </a>

        <nav>
            <a href="index.php">Home</a>
            <a href="escaperooms.php" class="active">Escape rooms</a>
            <a href="register-worker.php">Medewerker Registreren</a>
            <a href="workerportal.php">Medewerker portaal</a>
        </nav>

        <a href="#" class="login-button">
            Inloggen
        </a>

    </header>


    <main>

        <!-- HEADER -->

        <section class="booking-page-header">

            <div>

                <p class="booking-label">
                    BIJNA KLAAR
                </p>

                <h1>
                    Bevestig je<br>
                    <span>boeking.</span>
                </h1>

                <p>
                    Controleer je gegevens en vul hieronder je
                    contactgegevens in.
                </p>

            </div>

        </section>


        <!-- BOOKING -->

        <section class="checkout">

            <!-- LEFT -->

            <div class="checkout-form">

                <div class="checkout-step">

                    <div class="checkout-step-number">
                        1
                    </div>

                    <div>

                        <p class="checkout-label">
                            JOUW GEGEVENS
                        </p>

                        <h2>
                            Contactgegevens
                        </h2>

                    </div>

                </div>


                <form id="bookingForm">

                    <div class="form-row">

                        <div class="form-group">

                            <label for="firstname">
                                Voornaam
                            </label>

                            <input
                                type="text"
                                id="firstname"
                                name="firstname"
                                placeholder="Voornaam"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label for="lastname">
                                Achternaam
                            </label>

                            <input
                                type="text"
                                id="lastname"
                                name="lastname"
                                placeholder="Achternaam"
                                required
                            >

                        </div>

                    </div>


                    <div class="form-group">

                        <label for="email">
                            E-mailadres
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="jouw@email.nl"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="phone">
                            Telefoonnummer
                        </label>

                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            placeholder="06 12345678"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="players">
                            Aantal spelers
                        </label>

                        <select id="players" name="players">

                            <option value="2">
                                2 spelers
                            </option>

                            <option value="3">
                                3 spelers
                            </option>

                            <option value="4">
                                4 spelers
                            </option>

                            <option value="5">
                                5 spelers
                            </option>

                            <option value="6">
                                6 spelers
                            </option>

                        </select>

                    </div>


                    <div class="checkout-step second-step">

                        <div class="checkout-step-number">
                            2
                        </div>

                        <div>

                            <p class="checkout-label">
                                BETALING
                            </p>

                            <h2>
                                Betaalmethode
                            </h2>

                        </div>

                    </div>


                    <div class="payment-options">

                        <label class="payment-option">

                            <input
                                type="radio"
                                name="payment"
                                value="ideal"
                                checked
                            >

                            <div class="payment-content">

                                <strong>
                                    iDEAL
                                </strong>

                                <span>
                                    Betaal veilig via je eigen bank
                                </span>

                            </div>

                            <span class="payment-check">
                                ✓
                            </span>

                        </label>


                        <label class="payment-option">

                            <input
                                type="radio"
                                name="payment"
                                value="card"
                            >

                            <div class="payment-content">

                                <strong>
                                    Creditcard
                                </strong>

                                <span>
                                    Visa, Mastercard
                                </span>

                            </div>

                            <span class="payment-check">
                                ✓
                            </span>

                        </label>

                    </div>


                    <label class="terms">

                        <input
                            type="checkbox"
                            required
                        >

                        <span>
                            Ik ga akkoord met de algemene voorwaarden
                            en het privacybeleid.
                        </span>

                    </label>


                    <button
                        type="submit"
                        class="confirm-button"
                    >
                        Boeking bevestigen →
                    </button>

                </form>

            </div>


            <!-- RIGHT -->

            <aside class="order-summary">

                <p class="summary-label">
                    JOUW BOEKING
                </p>

                <h2 id="roomName">
                    The Lost Library
                </h2>


                <div class="summary-line">

                    <span>
                        📅 Datum
                    </span>

                    <strong id="bookingDate">
                        -
                    </strong>

                </div>


                <div class="summary-line">

                    <span>
                        ◷ Tijd
                    </span>

                    <strong id="bookingTime">
                        -
                    </strong>

                </div>


                <div class="summary-line">

                    <span>
                        ⏱ Duur
                    </span>

                    <strong>
                        1,5 uur
                    </strong>

                </div>


                <div class="summary-line">

                    <span>
                        👥 Spelers
                    </span>

                    <strong id="bookingPlayers">
                        2 spelers
                    </strong>

                </div>


                <div class="summary-divider"></div>


                <div class="price-row">

                    <span>
                        Prijs
                    </span>

                    <strong id="bookingPrice">
                        €29,50
                    </strong>

                </div>


                <div class="secure-message">

                    <span>✓</span>

                    <p>
                        Je gegevens worden veilig verwerkt.
                    </p>

                </div>


                <a
                    href="escaperooms.php"
                    class="change-booking"
                >
                    ← Boeking wijzigen
                </a>

            </aside>

        </section>

    </main>


    <footer>

        <p>
            &copy; 2026 Puzzlepass. All rights reserved.
        </p>

    </footer>


    <script>

        /*
         * Haal de gekozen gegevens uit de URL.
         *
         * Bijvoorbeeld:
         *
         * boeken.php?
         * room=The%20Lost%20Library
         * &date=12%20oktober%202026
         * &time=14:30
         * &price=29.50
         */

        const params =
            new URLSearchParams(window.location.search);


        const room =
            params.get("room");

        const date =
            params.get("date");

        const time =
            params.get("time");

        const price =
            params.get("price");


        if (room) {

            document.getElementById(
                "roomName"
            ).textContent = room;

        }


        if (date) {

            document.getElementById(
                "bookingDate"
            ).textContent = date;

        }


        if (time) {

            document.getElementById(
                "bookingTime"
            ).textContent =
                time + " · 1,5 uur";

        }


        if (price) {

            document.getElementById(
                "bookingPrice"
            ).textContent =
                "€" + price.replace(".", ",");

        }


        /*
         * Aantal spelers aanpassen
         */

        document
            .getElementById("players")
            .addEventListener("change", function () {

                document.getElementById(
                    "bookingPlayers"
                ).textContent =
                    this.value + " spelers";

            });


        /*
         * Formulier
         */

        document
            .getElementById("bookingForm")
            .addEventListener("submit", function(event) {

                event.preventDefault();

                alert(
                    "Je boeking is bevestigd!"
                );

            

            });

    </script>

</body>
</html>