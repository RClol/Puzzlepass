<?php

require_once "includes/db.php";

$username = "Roos";
$email = "Roos@example.com";
$password = "ww123";

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO workers (username, email, password)
        VALUES (:username, :email, :password)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "username" => $username,
    "email" => $email,
    "password" => $hashed_password
]);

echo "Worker account created successfully.";

?>