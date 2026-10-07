<?php

require_once "includes/db.php";

$message = "";
$message_type = "";

$security_pin = "0201";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $pin = $_POST["security_pin"] ?? "";
    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    // Check security PIN first
    if ($pin !== $security_pin) {

        $message = "Incorrect security PIN.";
        $message_type = "error";

    } elseif ($username === "" || $email === "" || $password === "" || $confirm_password === "") {

        $message = "Please fill in all fields.";
        $message_type = "error";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";
        $message_type = "error";

    } elseif (strlen($password) < 8) {

        $message = "Password must be at least 8 characters.";
        $message_type = "error";

    } elseif ($password !== $confirm_password) {

        $message = "Passwords do not match.";
        $message_type = "error";

    } else {

        // Check if username already exists
        $sql = "SELECT id FROM workers
                WHERE username = :username
                LIMIT 1";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            "username" => $username
        ]);

        if ($stmt->fetch()) {

            $message = "That username is already in use.";
            $message_type = "error";

        } else {

            // Check if email already exists
            $sql = "SELECT id FROM workers
                    WHERE email = :email
                    LIMIT 1";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                "email" => $email
            ]);

            if ($stmt->fetch()) {

                $message = "That email is already registered.";
                $message_type = "error";

            } else {

                // Hash the worker's password
                $hashed_password = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                // Create the worker account
                $sql = "INSERT INTO workers
                        (username, email, password)
                        VALUES
                        (:username, :email, :password)";

                $stmt = $pdo->prepare($sql);

                $stmt->execute([
                    "username" => $username,
                    "email" => $email,
                    "password" => $hashed_password
                ]);

                $message = "Worker account created successfully!";
                $message_type = "success";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register Worker | Escape Room</title>

    <link rel="stylesheet" href="css/register-worker.css">

</head>

<body>

    <div class="register-box">

        <h1>Register Worker</h1>

        <p class="subtitle">
            Create a new Escape Room staff account
        </p>

        <?php if ($message !== ""): ?>

            <div class="<?php echo $message_type; ?>">

                <?php echo htmlspecialchars($message); ?>

            </div>

        <?php endif; ?>


        <form action="register-worker.php" method="POST">

            <label for="security_pin">
                Security PIN
            </label>

            <input
                type="password"
                id="security_pin"
                name="security_pin"
                placeholder="Enter 4-digit security PIN"
                maxlength="4"
                minlength="4"
                inputmode="numeric"
                pattern="[0-9]{4}"
                required
            >


            <label for="username">
                Username
            </label>

            <input
                type="text"
                id="username"
                name="username"
                placeholder="Enter username"
                required
            >


            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter email"
                required
            >


            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter password"
                minlength="8"
                required
            >


            <label for="confirm_password">
                Confirm Password
            </label>

            <input
                type="password"
                id="confirm_password"
                name="confirm_password"
                placeholder="Confirm password"
                minlength="8"
                required
            >


            <button type="submit">
                Register Worker
            </button>

        </form>



    </div>

</body>

</html>
