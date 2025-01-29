<?php
$host = getenv("DB_HOST") ?: "b8occq7i8qfvinaczwwh-mysql.services.clever-cloud.com";
$user = getenv("DB_USER") ?: "uuovfe0ukxs2luYY";
$password = getenv("DB_PASSWORD") ?: "sZXlCFtPlpIwOUOIzLK8";
$dbname = getenv("DB_NAME") ?: "b8occq7i8qfvinaczwwh";
$port = getenv("DB_PORT") ?: "3306";

$conn = new mysqli($host, $user, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
