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

// Fetch all profiles
$result = $conn->query("SELECT * FROM profiles");

if ($result === false) {
    echo json_encode(["status" => "error", "message" => "Error fetching profiles: " . $conn->error]);
    $conn->close();
    exit;
}

$profiles = [];
while ($row = $result->fetch_assoc()) {
    $profiles[] = $row;
}

// Return profiles as JSON
echo json_encode(["status" => "success", "profiles" => $profiles]);

$conn->close();
?>
