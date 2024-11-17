<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Database connection details
$servername = "localhost";
$db_username = "root"; // Update if necessary
$db_password = "";     // Update if necessary
$dbname = "job_matching";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

$result = $conn->query("SELECT * FROM events");
$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode(["status" => "success", "events" => $events]);

$conn->close();
?>
