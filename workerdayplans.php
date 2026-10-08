<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: workers.php");
    exit;
}

require_once "includes/db.php";

$today = date("Y-m-d");

// Boekingen van vandaag ophalen
$stmt = $pdo->prepare("
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
        status
    FROM bookings
    WHERE booking_date = :today
    ORDER BY start_time ASC
");

$stmt->execute([
    "today" => $today
]);

$todayBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Eerstvolgende boeking ophalen
$nextBookingStmt = $pdo->prepare("
    SELECT
        room_name,
        booking_date,
        start_time,
        customer_first_name,
        customer_last_name,
        players,
        status
    FROM bookings
    WHERE
        booking_date > :today
        OR (
            booking_date = :today
            AND start_time >= :current_time
        )
    ORDER BY booking_date ASC, start_time ASC
    LIMIT 1
");

$nextBookingStmt->execute([
    "today" => $today,
    "current_time" => date("H:i:s")
]);

$nextBooking = $nextBookingStmt->fetch(PDO::FETCH_ASSOC);


// Datum weergeven
$todayFormatted = date("d-m-Y");

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dagplanning | Puzzlepass</title>

    <link rel="stylesheet" href="css/workers.css">
    <link rel="stylesheet" href="css/workerdayplans.css">

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


<main class="dayplanning-page">

    <a href="workers.php" class="back-link">
        ← Terug naar dashboard
    </a>


    <div class="page-header">

        <h2>
            Dagplanning
        </h2>

        <p>
            Vandaag: <?= $todayFormatted ?>
        </p>

    </div>


    <section class="planning-section">

        <h3>
            Boekingen van vandaag
        </h3>


        <?php if (count($todayBookings) > 0): ?>

            <div class="booking-list">

                <?php foreach ($todayBookings as $booking): ?>

                    <div class="booking-card">

                        <div class="booking-time">

                            <?= htmlspecialchars(
                                substr($booking["start_time"], 0, 5)
                            ) ?>

                        </div>


                        <div class="booking-info">

                            <h4>
                                <?= htmlspecialchars($booking["room_name"]) ?>
                            </h4>

                            <p>
                                <?= htmlspecialchars(
                                    $booking["customer_first_name"] . " " .
                                    $booking["customer_last_name"]
                                ) ?>
                            </p>

                            <span>
                                <?= htmlspecialchars($booking["players"]) ?> spelers
                            </span>

                        </div>


                        <div class="booking-status">

                            <span class="status <?= htmlspecialchars($booking["status"]) ?>">
                                <?= htmlspecialchars($booking["status"]) ?>
                            </span>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="empty-planning">

                <h4>
                    Geen boekingen vandaag
                </h4>

                <p>
                    Er zijn vandaag geen reserveringen gepland.
                    Bekijk hieronder de eerstvolgende boeking.
                </p>

            </div>

        <?php endif; ?>

    </section>


    <section class="next-booking">

        <h3>
            Eerstvolgende boeking
        </h3>


        <?php if ($nextBooking): ?>

            <div class="next-booking-card">

                <div>

                    <span class="next-label">
                        Datum
                    </span>

                    <strong>
                        <?= date(
                            "d-m-Y",
                            strtotime($nextBooking["booking_date"])
                        ) ?>
                    </strong>

                </div>


                <div>

                    <span class="next-label">
                        Tijd
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            substr($nextBooking["start_time"], 0, 5)
                        ) ?>
                    </strong>

                </div>


                <div>

                    <span class="next-label">
                        Kamer
                    </span>

                    <strong>
                        <?= htmlspecialchars($nextBooking["room_name"]) ?>
                    </strong>

                </div>


                <div>

                    <span class="next-label">
                        Klant
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $nextBooking["customer_first_name"] . " " .
                            $nextBooking["customer_last_name"]
                        ) ?>
                    </strong>

                </div>

            </div>

        <?php else: ?>

            <div class="empty-next-booking">

                <p>
                    Er zijn momenteel geen toekomstige boekingen.
                </p>

            </div>

        <?php endif; ?>

    </section>

</main>

</body>

</html>