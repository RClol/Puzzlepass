<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: workers.php");
    exit;
}

require_once "includes/db.php";


// Onderhoudsblokkade verwijderen
if (isset($_GET["remove_block"])) {

    $blockId = (int) $_GET["remove_block"];

    $stmt = $pdo->prepare("
        DELETE FROM room_blocks
        WHERE id = :id
    ");

    $stmt->execute([
        "id" => $blockId
    ]);

    header("Location: workersedit.php");
    exit;
}


// Nieuwe onderhoudsblokkade toevoegen
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $roomName = trim($_POST["room_name"] ?? "");
    $blockDate = $_POST["block_date"] ?? "";
    $startTime = $_POST["start_time"] ?? "";
    $endTime = $_POST["end_time"] ?? "";
    $reason = trim($_POST["reason"] ?? "");

    if (
        $roomName !== "" &&
        $blockDate !== "" &&
        $startTime !== "" &&
        $endTime !== ""
    ) {

        $stmt = $pdo->prepare("
            INSERT INTO room_blocks
            (room_name, block_date, start_time, end_time, reason)
            VALUES
            (:room_name, :block_date, :start_time, :end_time, :reason)
        ");

        $stmt->execute([
            "room_name" => $roomName,
            "block_date" => $blockDate,
            "start_time" => $startTime,
            "end_time" => $endTime,
            "reason" => $reason
        ]);
    }

    header("Location: workersedit.php");
    exit;
}


// Kamers
$rooms = [
    "The Lost Library",
    "The Alchemist's Lab",
    "The Pirate's Treasure",
    "The Haunted Mansion"
];


// Onderhoudsblokkades ophalen
$blocksStmt = $pdo->query("
    SELECT *
    FROM room_blocks
    WHERE block_date >= CURDATE()
    ORDER BY block_date ASC, room_name ASC, start_time ASC
");

$blocks = $blocksStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Kamers beheren | Puzzlepass</title>

    <link rel="stylesheet" href="css/workers.css">
    <link rel="stylesheet" href="css/workersedit.css">

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


<main class="rooms-page">

    <a href="workers.php" class="back-link">
        ← Terug naar dashboard
    </a>


    <div class="page-header">

        <h2>
            Kamers beheren
        </h2>

        <p>
            Beheer kamers, openingstijden en onderhoudsblokkades.
        </p>

    </div>


    <!-- KAMERS -->

    <section class="rooms-section">

        <h3>
            Escape rooms
        </h3>


        <div class="rooms-list">

            <?php foreach ($rooms as $room): ?>

                <div class="room-card">

                    <div>

                        <h4>
                            <?= htmlspecialchars($room) ?>
                        </h4>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </section>


    <!-- ONDERHOUD -->

    <section class="maintenance-section">

        <h3>
            Onderhoudsblokkade toevoegen
        </h3>

        <form method="POST">

            <div class="form-group">

                <label for="room_name">
                    Kamer
                </label>

                <select
                    id="room_name"
                    name="room_name"
                    required
                >

                    <option value="">
                        Kies een kamer
                    </option>

                    <?php foreach ($rooms as $room): ?>

                        <option value="<?= htmlspecialchars($room) ?>">
                            <?= htmlspecialchars($room) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <div class="form-group">

                <label for="block_date">
                    Datum
                </label>

                <input
                    type="date"
                    id="block_date"
                    name="block_date"
                    min="<?= date("Y-m-d") ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label for="start_time">
                    Begintijd
                </label>

                <input
                    type="time"
                    id="start_time"
                    name="start_time"
                    required
                >

            </div>


            <div class="form-group">

                <label for="end_time">
                    Eindtijd
                </label>

                <input
                    type="time"
                    id="end_time"
                    name="end_time"
                    required
                >

            </div>


            <div class="form-group">

                <label for="reason">
                    Reden
                </label>

                <input
                    type="text"
                    id="reason"
                    name="reason"
                    placeholder="Bijvoorbeeld: onderhoud"
                >

            </div>


            <button type="submit">
                Blokkade toevoegen
            </button>

        </form>

    </section>


    <!-- BESTAANDE BLOKKADES -->

    <section class="blocks-section">

        <h3>
            Geplande onderhoudsblokkades
        </h3>


        <?php if (count($blocks) > 0): ?>

            <div class="blocks-list">

                <?php foreach ($blocks as $block): ?>

                    <div class="block-card">

                        <div>

                            <h4>
                                <?= htmlspecialchars($block["room_name"]) ?>
                            </h4>

                            <p>

                                <?= date(
                                    "d-m-Y",
                                    strtotime($block["block_date"])
                                ) ?>

                                |

                                <?= htmlspecialchars(substr($block["start_time"], 0, 5)) ?>

                                -

                                <?= htmlspecialchars(substr($block["end_time"], 0, 5)) ?>

                            </p>


                            <?php if ($block["reason"] !== ""): ?>

                                <span>
                                    <?= htmlspecialchars($block["reason"]) ?>
                                </span>

                            <?php endif; ?>

                        </div>


                        <a
                            href="workersedit.php?remove_block=<?= (int) $block["id"] ?>"
                            class="remove-link"
                        >
                            Verwijderen
                        </a>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="empty-blocks">

                <p>
                    Er zijn geen geplande onderhoudsblokkades.
                </p>

            </div>

        <?php endif; ?>

    </section>

</main>

</body>

</html>