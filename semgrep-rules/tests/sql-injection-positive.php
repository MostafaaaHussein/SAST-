<?php
$username = $_GET["user"];
$query = "SELECT * FROM accounts WHERE username='" . $username . "'";
$result = mysqli_query($conn, $query);
?>
