<?php
$username = $_GET["user"];
$stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
?>
