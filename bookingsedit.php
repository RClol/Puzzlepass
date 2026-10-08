<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: workers.php");
    exit;
}

require_once "includes/db.php";


// Reservering verwijderen
if (isset($_GET["remove_booking"])) {

    $bookingId = (int) $_GET["remove_booking"];

    if ($bookingId > 0) {

        $stmt = $pdo->prepare("
            DELETE FROM bookings
            WHERE id = :id
        ");

        $stmt->execute([
            "id" => $bookingId
        ]);
    }

    header("Location: bookingsedit.php");
    exit;
}


// Betalingsstatus wijzigen
if (isset($_GET["toggle_paid"])) {

    $bookingId = (int) $_GET["toggle_paid"];

    if ($bookingId > 0) {

        $stmt = $pdo->prepare("
            UPDATE bookings
            SET paid = CASE
                WHEN paid = 1 THEN 0
                ELSE 1
            END
            WHERE id = :id
        ");

        $stmt->execute([
            "id" => $bookingId
        ]);
    }

    header("Location: bookingsedit.php");
    exit;
}


// Reserveringen ophalen
$bookingsStmt = $pdo->query("
    SELECT
        id,
        room_name,
        booking_date,
        start_time,
        customer_first_name,
        customer_last_name,
        customer_email,
        customer_phone,
        players,
        price,
        status,
        paid,
        created_at
    FROM bookings
    ORDER BY booking_date ASC, start_time ASC
");

$bookings = $bookingsStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Reserveringen beheren | Puzzlepass</title>

    <link rel="stylesheet" href="css/workers.css">
    <link rel="stylesheet" href="css/bookingsedit.css">

</head>


<body>

<header>

    <div>

        <h1>
            Puzzlepass
        </h1>

        <p>
            Medewerker portaal
        </p>

    </div>


    <div>

        <span>
            Welkom,
            <?= htmlspecialchars($_SESSION["username"]) ?>
        </span>

        <a href="logout.php">
            Uitloggen
        </a>

    </div>

</header>


<main class="bookings-page">

    <a href="workers.php" class="back-link">
        ← Terug naar dashboard
    </a>


    <div class="page-header">

        <h2>
            Reserveringen beheren
        </h2>

        <p>
            Bekijk, betaalstatus wijzigen en verwijder bestaande reserveringen.
        </p>

    </div>


    <section class="bookings-section">

        <h3>
            Alle reserveringen
        </h3>


        <?php if (count($bookings) > 0): ?>

            <div class="bookings-list">

                <?php foreach ($bookings as $booking): ?>

                    <div class="booking-card">

                        <div class="booking-info">

                            <h4>
                                <?= htmlspecialchars($booking["room_name"]) ?>
                            </h4>


                            <p>
                                <strong>Datum:</strong>
                                <?= date(
                                    "d-m-Y",
                                    strtotime($booking["booking_date"])
                                ) ?>
                            </p>


                            <p>
                                <strong>Tijd:</strong>
                                <?= htmlspecialchars(
                                    substr($booking["start_time"], 0, 5)
                                ) ?>
                            </p>


                            <p>
                                <strong>Klant:</strong>
                                <?= htmlspecialchars(
                                    $booking["customer_first_name"] . " " .
                                    $booking["customer_last_name"]
                                ) ?>
                            </p>


                            <p>
                                <strong>E-mail:</strong>
                                <?= htmlspecialchars($booking["customer_email"]) ?>
                            </p>


                            <p>
                                <strong>Telefoon:</strong>
                                <?= htmlspecialchars($booking["customer_phone"]) ?>
                            </p>


                            <p>
                                <strong>Spelers:</strong>
                                <?= htmlspecialchars($booking["players"]) ?>
                            </p>


                            <p>
                                <strong>Prijs:</strong>
                                €<?= htmlspecialchars($booking["price"]) ?>
                            </p>


                            <p>
                                <strong>Status:</strong>
                                <?= htmlspecialchars($booking["status"]) ?>
                            </p>


                            <p>
                                <strong>Betaling:</strong>

                                <?php if ($booking["paid"] == 1): ?>

                                    <span class="paid-status">
                                        ✓ Betaald
                                    </span>

                                <?php else: ?>

                                    <span class="unpaid-status">
                                        ✗ Niet betaald
                                    </span>

                                <?php endif; ?>

                            </p>

                        </div>


                        <div class="booking-actions">

                            <a
                                href="bookingsedit.php?toggle_paid=<?= (int) $booking["id"] ?>"
                                class="payment-link"
                                onclick="return confirm('Wil je de betaalstatus van deze reservering wijzigen?');"
                            >
                                <?php if ($booking["paid"] == 1): ?>

                                    Markeer als onbetaald

                                <?php else: ?>

                                    Markeer als betaald

                                <?php endif; ?>
                            </a>


                            <a
                                href="bookingsedit.php?remove_booking=<?= (int) $booking["id"] ?>"
                                class="remove-link"
                                onclick="return confirm('Weet je zeker dat je deze reservering wilt verwijderen?');"
                            >
                                Verwijderen
                            </a>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="empty-bookings">

                <p>
                    Er zijn geen reserveringen gevonden.
                </p>

            </div>

        <?php endif; ?>

    </section>

</main>

</body>

</html>