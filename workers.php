<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: workerportal.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Worker Dashboard | Escape Room</title>

    <link rel="stylesheet" href="css/workers.css">

</head>

<body>

    <header>

        <h1>Escape Room Worker Portal</h1>

        <div>

            <span>
                Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>
            </span>

            <a href="logout.php">Log Out</a>

        </div>

    </header>


    <main>

        <h2>Worker Dashboard</h2>

        <p>
            Welcome to the Escape Room staff portal.
        </p>


        <section>

            <div class="card">

                <h3>Bookings</h3>

                <p>
                    View and manage escape room bookings.
                </p>

                <a href="#">View Bookings</a>

            </div>


            <div class="card">

                <h3>Customers</h3>

                <p>
                    View customer information.
                </p>

                <a href="#">View Customers</a>

            </div>


            <div class="card">

                <h3>Rooms</h3>

                <p>
                    View escape room information.
                </p>

                <a href="#">View Rooms</a>

            </div>


            <div class="card">

                <h3>My Account</h3>

                <p>
                    Username:
                    <?php echo htmlspecialchars($_SESSION["username"]); ?>
                </p>

                <p>
                    Email:
                    <?php echo htmlspecialchars($_SESSION["email"]); ?>
                </p>

            </div>

        </section>

    </main>

</body>

</html>