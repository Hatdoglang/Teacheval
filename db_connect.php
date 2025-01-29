<?php
$host = getenv("DB_HOST") ?: "b8occq7i8qfvinaczwwh-mysql.services.clever-cloud.com";
$user = getenv("DB_USER") ?: "uuovfe0ukxs2luYY";
$password = getenv("DB_PASSWORD") ?: "sZXlCFtPlpIwOUOIzLK8";
$dbname = getenv("DB_NAME") ?: "b8occq7i8qfvinaczwwh";
$port = getenv("DB_PORT") ?: "3306";

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET SESSION sql_mode = ''"
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
