<?php
$host = "b8occq7i8qfvinaczwwh-mysql.services.clever-cloud.com";
$user = "uuovfe0ukxs2luyy";  // Updated username (lowercase "y" at the end)
$password = "sZXlCFtPlpIwOU0IzLK8";  // Updated password (zero instead of 'O')
$dbname = "b8occq7i8qfvinaczwwh";
$port = 3306;

// Create MySQL connection
$conn = new mysqli($host, $user, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
