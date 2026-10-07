<?php

require_once "includes/db.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Worker Login | Escape Room</title>

    <!-- Link to CSS -->
    <link rel="stylesheet" href="css/workerportal.css">
</head>

<body>

    <div class="login-box">

        <h1>Worker Login</h1>

        <p class="subtitle">Escape Room Staff Portal</p>

        <form action="login.php" method="POST">

            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                placeholder="Enter your username"
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
            >

            <button type="submit">Log In</button>

        </form>

        <a href="index.php" class="back">← Back to website</a>

    </div>

</body>
</html>
