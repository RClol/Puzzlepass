<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Escape rooms - Puzzlepass</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/escaperooms.css">
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

        <!-- PAGE HEADER -->
        <section class="rooms-header">

            <div class="rooms-header-content">

                <p class="rooms-label">
                    PUZZLEPASS ESCAPE ROOMS
                </p>

                <h1>
                    Kies jouw<br>
                    <span>escape room.</span>
                </h1>

                <p>
                    Kies een uitdaging, selecteer een datum en
                    reserveer jouw tijdslot.
                </p>

            </div>

        </section>


        <!-- BOOKING SECTION -->
        <section class="booking-section">

            <!-- LEFT SIDE -->
            <div class="booking-rooms">

                <div class="booking-title">

                    <div>

                        <p class="step-label">
                            Stap 1
                        </p>

                        <h2>
                            Kies een escape room
                        </h2>

                    </div>

                    <p class="room-count">
                        4 kamers beschikbaar
                    </p>

                </div>


                <div class="room-grid">


                    <!-- ROOM 1 -->
                    <article
                        class="puzzle-room selected"
                        data-room="The Lost Library"
                        data-price="29.50"
                    >

                        <div class="room-image-wrapper">

                            <img
                                src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=900&q=80"
                                alt="The Lost Library"
                            >

                            <span class="room-tag">
                                POPULAIR
                            </span>

                        </div>

                        <div class="room-info">

                            <div class="room-top">

                                <h3>
                                    The Lost Library
                                </h3>

                                <span class="difficulty">
                                    Gemiddeld
                                </span>

                            </div>

                            <p>
                                Ontdek de geheimen van een oude
                                bibliotheek en vind de uitgang voordat
                                de tijd om is.
                            </p>

                            <div class="room-bottom">

                                <span>
                                    2 - 6 spelers
                                </span>

                                <span>
                                    60 min.
                                </span>

                            </div>

                            <button
                                type="button"
                                class="room-select selected"
                            >
                                Geselecteerd ✓
                            </button>

                        </div>

                    </article>


                    <!-- ROOM 2 -->
                    <article
                        class="puzzle-room"
                        data-room="The Alchemist's Lab"
                        data-price="32.50"
                    >

                        <div class="room-image-wrapper">

                            <img
                                src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=900&q=80"
                                alt="The Alchemist's Lab"
                            >

                        </div>

                        <div class="room-info">

                            <div class="room-top">

                                <h3>
                                    The Alchemist's Lab
                                </h3>

                                <span class="difficulty hard">
                                    Moeilijk
                                </span>

                            </div>

                            <p>
                                Experimenteer met mysterieuze
                                ingrediënten en los de geheimen van
                                de alchemist op.
                            </p>

                            <div class="room-bottom">

                                <span>
                                    2 - 6 spelers
                                </span>

                                <span>
                                    60 min.
                                </span>

                            </div>

                            <button
                                type="button"
                                class="room-select"
                            >
                                Selecteren
                            </button>

                        </div>

                    </article>


                    <!-- ROOM 3 -->
                    <article
                        class="puzzle-room"
                        data-room="The Pirate's Treasure"
                        data-price="27.50"
                    >

                        <div class="room-image-wrapper">

                            <img
                                src="https://images.unsplash.com/photo-1518709594023-6eab9bab7b23?auto=format&fit=crop&w=900&q=80"
                                alt="The Pirate's Treasure"
                            >

                        </div>

                        <div class="room-info">

                            <div class="room-top">

                                <h3>
                                    The Pirate's Treasure
                                </h3>

                                <span class="difficulty">
                                    Gemiddeld
                                </span>

                            </div>

                            <p>
                                Zoek de verloren schat voordat de
                                piraten terugkeren.
                            </p>

                            <div class="room-bottom">

                                <span>
                                    2 - 6 spelers
                                </span>

                                <span>
                                    60 min.
                                </span>

                            </div>

                            <button
                                type="button"
                                class="room-select"
                            >
                                Selecteren
                            </button>

                        </div>

                    </article>


                    <!-- ROOM 4 -->
                    <article
                        class="puzzle-room"
                        data-room="The Haunted Mansion"
                        data-price="34.50"
                    >

                        <div class="room-image-wrapper">

                            <img
                                src="https://images.unsplash.com/photo-1509248961158-e54f6934749c?auto=format&fit=crop&w=900&q=80"
                                alt="The Haunted Mansion"
                            >

                        </div>

                        <div class="room-info">

                            <div class="room-top">

                                <h3>
                                    The Haunted Mansion
                                </h3>

                                <span class="difficulty hard">
                                    Moeilijk
                                </span>

                            </div>

                            <p>
                                Durf jij het verleden van het
                                verlaten landhuis te ontdekken?
                            </p>

                            <div class="room-bottom">

                                <span>
                                    2 - 6 spelers
                                </span>

                                <span>
                                    60 min.
                                </span>

                            </div>

                            <button
                                type="button"
                                class="room-select"
                            >
                                Selecteren
                            </button>

                        </div>

                    </article>

                </div>

            </div>


            <!-- RIGHT SIDE -->
            <aside class="booking-card">

                <div class="booking-card-header">

                    <p class="step-label">
                        Stap 2
                    </p>

                    <h2>
                        Reserveer je plek
                    </h2>

                    <p>
                        Kies hieronder een datum en tijd.
                        Elk tijdslot duurt 1,5 uur.
                    </p>

                </div>


                <!-- DATE -->
                <div class="booking-part">

                    <div class="part-heading">

                        <span>
                            2
                        </span>

                        <div>

                            <small>
                                DATUM
                            </small>

                            <h3>
                                Kies een datum
                            </h3>

                        </div>

                    </div>


                    <div class="calendar">

                        <div class="calendar-top">

                            <button
                                type="button"
                                id="previousMonth"
                            >
                                ←
                            </button>

                            <strong id="monthTitle">
                                Oktober 2026
                            </strong>

                            <button
                                type="button"
                                id="nextMonth"
                            >
                                →
                            </button>

                        </div>


                        <div class="calendar-weekdays">

                            <span>MA</span>
                            <span>DI</span>
                            <span>WO</span>
                            <span>DO</span>
                            <span>VR</span>
                            <span>ZA</span>
                            <span>ZO</span>

                        </div>


                        <div
                            class="calendar-days"
                            id="calendarDays"
                        ></div>

                    </div>

                </div>


                <!-- TIME -->
                <div class="booking-part">

                    <div class="part-heading">

                        <span>
                            3
                        </span>

                        <div>

                            <small>
                                TIJD
                            </small>

                            <h3>
                                Kies een tijdslot
                            </h3>

                        </div>

                    </div>


                    <div class="time-grid">

                        <button
                            type="button"
                            class="time-slot"
                            data-time="10:00"
                        >
                            10:00
                            <small>
                                tot 11:30
                            </small>
                        </button>

                        <button
                            type="button"
                            class="time-slot"
                            data-time="11:30"
                        >
                            11:30
                            <small>
                                tot 13:00
                            </small>
                        </button>

                        <button
                            type="button"
                            class="time-slot"
                            data-time="13:00"
                        >
                            13:00
                            <small>
                                tot 14:30
                            </small>
                        </button>

                        <button
                            type="button"
                            class="time-slot"
                            data-time="14:30"
                        >
                            14:30
                            <small>
                                tot 16:00
                            </small>
                        </button>

                        <button
                            type="button"
                            class="time-slot"
                            data-time="16:00"
                        >
                            16:00
                            <small>
                                tot 17:30
                            </small>
                        </button>

                        <button
                            type="button"
                            class="time-slot"
                            data-time="17:30"
                        >
                            17:30
                            <small>
                                tot 19:00
                            </small>
                        </button>

                        <button
                            type="button"
                            class="time-slot"
                            data-time="19:00"
                        >
                            19:00
                            <small>
                                tot 20:30
                            </small>
                        </button>

                        <button
                            type="button"
                            class="time-slot"
                            data-time="20:30"
                        >
                            20:30
                            <small>
                                tot 22:00
                            </small>
                        </button>

                    </div>

                </div>


                <!-- SUMMARY -->
                <div class="booking-summary">

                    <p>
                        Jouw keuze
                    </p>

                    <div class="summary-main">

                        <div>

                            <strong id="summaryRoom">
                                The Lost Library
                            </strong>

                            <span id="summaryDate">
                                Kies een datum
                            </span>

                            <span id="summaryTime">
                                Kies een tijd
                            </span>

                        </div>

                        <strong id="summaryPrice">
                            €29,50
                        </strong>

                    </div>


                    <button
                        type="button"
                        class="booking-button"
                        id="bookingButton"
                        disabled
                    >
                        Doorgaan naar boeken →
                    </button>

                </div>

            </aside>

        </section>

    </main>


    <!-- FOOTER -->
    <footer>

        <p>
            &copy; 2026 Puzzlepass. All rights reserved.
        </p>

    </footer>


    <!-- JAVASCRIPT -->
    <script src="js/escaperooms.js"></script>

</body>
</html>