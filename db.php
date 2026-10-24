<?php
mysqli_report(MYSQLI_REPORT_OFF);

$servername = getenv('DB_HOST') ?: 'db';
$username = getenv('DB_USER') ?: 'tastybook_user';
$password = getenv('DB_PASSWORD') ?: '';
$dbname = getenv('DB_NAME') ?: 'tastybook_db';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    http_response_code(500);
    exit("Database connection is temporarily unavailable.");
}

$conn->set_charset('utf8mb4');
?>
