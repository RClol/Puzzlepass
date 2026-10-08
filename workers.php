<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: workers.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Medewerker Portaal | Puzzlepass</title>

    <link rel="stylesheet" href="css/workers.css">

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


    <main>

        <h2>
            Medewerker dashboard
        </h2>

        <p>
            Beheer reserveringen, kamers en de dagelijkse planning.
        </p>


        <section>


            <div class="card">

                <h3>
                    Dagplanning
                </h3>

                <p>
                    Bekijk de reserveringen van vandaag,
                    inclusief aankomsttijd en status.
                </p>

                <a href="workerdayplans.php">
                    Dagplanning bekijken
                </a>

            </div>


            <div class="card">

                <h3>
                    Kamers beheren
                </h3>

                <p>
                    Beheer kamers, openingstijden en
                    onderhoudsblokkades.
                </p>

                <a href="workersedit.php">
                    Kamers beheren
                </a>

            </div>


            <div class="card">

                <h3>
                    Reserveringen
                </h3>

                <p>
                    Bevestig reserveringen en markeer
                    betalingen als ontvangen.
                </p>

                <a href="bookingsedit.php">
                    Reserveringen beheren
                </a>

            </div>


        </section>

    </main>

</body>

</html>