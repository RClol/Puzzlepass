<?php

session_start();

require_once "includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: workerportal.php");
    exit;
}

$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";

if ($username === "" || $password === "") {
    die("Please enter your username and password.");
}

// Find the worker in the workers table
$sql = "SELECT id, username, email, password
        FROM workers
        WHERE username = :username
        LIMIT 1";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "username" => $username
]);

$worker = $stmt->fetch();

// Check the password
if ($worker && password_verify($password, $worker["password"])) {

    // Login successful
    $_SESSION["user_id"] = $worker["id"];
    $_SESSION["username"] = $worker["username"];
    $_SESSION["email"] = $worker["email"];

    // Send worker to dashboard
    header("Location: workers.php");
    exit;

} else {

    // Login failed
    die("Incorrect username or password.");

}

?>