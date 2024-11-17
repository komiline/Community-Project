<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json'); // Ensure response is JSON

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

// Get data from request
$data = json_decode(file_get_contents("php://input"), true);
$event_name = trim($data['event_name']);
$event_date = trim($data['event_date']);
$duration = intval($data['duration']);
$max_persons = intval($data['max_persons']);
$skills_required = trim($data['skills_required']);
$specialization = trim($data['specialization']);
$additional_info = trim($data['additional_info']);

// Validate that required fields are not empty
if (empty($event_name) || empty($event_date) || empty($duration) || empty($max_persons) || empty($skills_required) || empty($specialization)) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit;
}

// Attempt to insert the event data
$sql = "INSERT INTO events (event_name, event_date, duration, max_persons, skills_required, specialization, additional_info) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssissss", $event_name, $event_date, $duration, $max_persons, $skills_required, $specialization, $additional_info);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Event created successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
