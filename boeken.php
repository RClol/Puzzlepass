<?php

session_start();

require_once "includes/db.php";

$bookingSuccess = false;
$bookingError = "";

$room = $_GET["room"] ?? "";
$date = $_GET["date"] ?? "";
$time = $_GET["time"] ?? "";
$price = $_GET["price"] ?? "";

//convert dates

$months = [
    "januari" => "01",
    "februari" => "02",
    "maart" => "03",
    "april" => "04",
    "mei" => "05",
    "juni" => "06",
    "juli" => "07",
    "augustus" => "08",
    "september" => "09",
    "oktober" => "10",
    "november" => "11",
    "december" => "12"
];

$bookingDate = null;

if ($date) {

    $dateParts = explode(" ", strtolower(trim($date)));

    if (count($dateParts) >= 4) {

        $day = str_pad($dateParts[1], 2, "0", STR_PAD_LEFT);
        $monthName = $dateParts[2];
        $year = $dateParts[3];

        if (isset($months[$monthName])) {

            $bookingDate =
                $year . "-" .
                $months[$monthName] . "-" .
                $day;
        }
    }
}

//submit form

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $room = $_POST["room"] ?? "";
    $bookingDate = $_POST["booking_date"] ?? "";
    $time = $_POST["time"] ?? "";
    $price = $_POST["price"] ?? "";

    $firstName = trim($_POST["firstname"] ?? "");
    $lastName = trim($_POST["lastname"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $players = (int) ($_POST["players"] ?? 0);

    //valid check

    if (
        empty($room) ||
        empty($bookingDate) ||
        empty($time) ||
        empty($price) ||
        empty($firstName) ||
        empty($lastName) ||
        empty($email) ||
        empty($phone)
    ) {

        $bookingError = "Vul alle verplichte gegevens in.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $bookingError = "Vul een geldig e-mailadres in.";

    } elseif ($players < 2 || $players > 6) {

        $bookingError =
            "Het aantal spelers moet tussen 2 en 6 liggen.";

    } else {

        try {

            //check room if the room is blocked

            $bookingStart = $time;

            $bookingEnd = date(
                "H:i:s",
                strtotime($bookingStart) + (90 * 60)
            );

            $blockSql = "
                SELECT id
                FROM room_blocks
                WHERE room_name = :room
                AND block_date = :booking_date
                AND start_time < :booking_end
                AND end_time > :booking_start
                LIMIT 1
            ";

            $blockStmt = $pdo->prepare($blockSql);

            $blockStmt->execute([
                ":room" => $room,
                ":booking_date" => $bookingDate,
                ":booking_start" => $bookingStart,
                ":booking_end" => $bookingEnd
            ]);

            if ($blockStmt->fetch()) {

                $bookingError =
                    "Deze kamer is op dit tijdstip geblokkeerd wegens onderhoud. Kies een ander tijdstip.";

            } else {

                //check if slot is 

                $checkSql = "
                    SELECT id
                    FROM bookings
                    WHERE room_name = :room
                    AND booking_date = :booking_date
                    AND start_time = :start_time
                    LIMIT 1
                ";

                $checkStmt = $pdo->prepare($checkSql);

                $checkStmt->execute([
                    ":room" => $room,
                    ":booking_date" => $bookingDate,
                    ":start_time" => $time
                ]);

                if ($checkStmt->fetch()) {

                    $bookingError =
                        "Dit tijdslot is helaas al geboekt. Kies een ander tijdstip.";

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | SAVE BOOKING
                    |--------------------------------------------------------------------------
                    */

                    $insertSql = "
                        INSERT INTO bookings (
                            room_name,
                            booking_date,
                            start_time,
                            customer_first_name,
                            customer_last_name,
                            customer_email,
                            customer_phone,
                            players,
                            price,
                            status
                        )
                        VALUES (
                            :room,
                            :booking_date,
                            :start_time,
                            :first_name,
                            :last_name,
                            :email,
                            :phone,
                            :players,
                            :price,
                            'confirmed'
                        )
                    ";

                    $insertStmt = $pdo->prepare($insertSql);

                    $insertStmt->execute([
                        ":room" => $room,
                        ":booking_date" => $bookingDate,
                        ":start_time" => $time,
                        ":first_name" => $firstName,
                        ":last_name" => $lastName,
                        ":email" => $email,
                        ":phone" => $phone,
                        ":players" => $players,
                        ":price" => $price
                    ]);

                    $bookingSuccess = true;
                }
            }

        } catch (PDOException $e) {

            if ($e->getCode() === "23000") {

                $bookingError =
                    "Dit tijdslot is ondertussen door iemand anders geboekt. Kies een ander tijdstip.";

            } else {

                $bookingError =
                    "Er ging iets mis bij het opslaan van je boeking. Probeer het opnieuw.";
            }
        }
    }
}

?>

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

            <a href="index.php">
                Home
            </a>

            <a href="escaperooms.php" class="active">
                Escape rooms
            </a>

            <a href="register-worker.php">
                Medewerker Registreren
            </a>

            <a href="workerportal.php">
                Medewerker portaal
            </a>

        </nav>

        <a href="login.php" class="login-button">
            Inloggen
        </a>

    </header>

    <main>

        <?php if ($bookingSuccess): ?>

            <!-- SUCCESS -->

            <section class="booking-page-header">

                <div>

                    <p class="booking-label">
                        BOEKING BEVESTIGD
                    </p>

                    <h1>
                        Bedankt voor<br>
                        <span>je boeking.</span>
                    </h1>

                    <p>
                        Je boeking is succesvol opgeslagen.
                        We kijken ernaar uit je te ontvangen!
                    </p>

                </div>

            </section>

            <section class="checkout">

                <aside class="order-summary">

                    <p class="summary-label">
                        JOUW BOEKING
                    </p>

                    <h2>
                        <?= htmlspecialchars($room) ?>
                    </h2>

                    <div class="summary-line">

                        <span>
                            📅 Datum
                        </span>

                        <strong>
                            <?= htmlspecialchars($date) ?>
                        </strong>

                    </div>

                    <div class="summary-line">

                        <span>
                            ◷ Tijd
                        </span>

                        <strong>
                            <?= htmlspecialchars($time) ?> · 1,5 uur
                        </strong>

                    </div>

                    <div class="summary-line">

                        <span>
                            👥 Spelers
                        </span>

                        <strong>
                            <?= htmlspecialchars($players) ?> spelers
                        </strong>

                    </div>

                    <div class="summary-divider"></div>

                    <div class="price-row">

                        <span>
                            Prijs
                        </span>

                        <strong>
                            €<?= number_format(
                                (float) $price,
                                2,
                                ",",
                                "."
                            ) ?>
                        </strong>

                    </div>

                    <div class="secure-message">

                        <span>✓</span>

                        <p>
                            Je boeking is opgeslagen in ons systeem.
                        </p>

                    </div>

                    <a href="index.php" class="change-booking">
                        ← Terug naar home
                    </a>

                </aside>

            </section>

        <?php else: ?>

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

            <?php if ($bookingError): ?>

                <div class="booking-error">
                    ⚠ <?= htmlspecialchars($bookingError) ?>
                </div>

            <?php endif; ?>

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

                    <form
                        id="bookingForm"
                        method="POST"
                        action="boeken.php"
                    >

                        <!-- BOOKING DATA -->

                        <input
                            type="hidden"
                            name="room"
                            value="<?= htmlspecialchars($room) ?>"
                        >

                        <input
                            type="hidden"
                            name="booking_date"
                            value="<?= htmlspecialchars($bookingDate ?? "") ?>"
                        >

                        <input
                            type="hidden"
                            name="time"
                            value="<?= htmlspecialchars($time) ?>"
                        >

                        <input
                            type="hidden"
                            name="price"
                            value="<?= htmlspecialchars($price) ?>"
                        >

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

                            <select
                                id="players"
                                name="players"
                                required
                            >

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

                        <!-- TERMS -->

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

                        <?= htmlspecialchars(
                            $room ?: "The Lost Library"
                        ) ?>

                    </h2>

                    <div class="summary-line">

                        <span>
                            📅 Datum
                        </span>

                        <strong id="bookingDate">

                            <?= htmlspecialchars(
                                $date ?: "-"
                            ) ?>

                        </strong>

                    </div>

                    <div class="summary-line">

                        <span>
                            ◷ Tijd
                        </span>

                        <strong id="bookingTime">

                            <?= htmlspecialchars(
                                $time ?: "-"
                            ) ?>

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

                            €<?= number_format(
                                (float) ($price ?: 29.50),
                                2,
                                ",",
                                "."
                            ) ?>

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

        <?php endif; ?>

    </main>

    <footer>

        <p>
            &copy; 2026 Puzzlepass. All rights reserved.
        </p>

    </footer>

    <!-- JAVASCRIPT -->

    <script src="js/boeken.js"></script>

</body>

</html>