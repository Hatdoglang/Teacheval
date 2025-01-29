<?php 

$host = "b8occq7i8qfvinaczwwh-mysql.services.clever-cloud.com"; // Cloud Clever MySQL host
$username = "uuovfe0ukxs2luyy"; // Replace with your Cloud Clever MySQL username
$password = "sZXlCFtPlpIwOU0IzLK8"; // Replace with your Cloud Clever MySQL password
$database = "b8occq7i8qfvinaczwwh"; // Cloud Clever database name

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully!";
?>
