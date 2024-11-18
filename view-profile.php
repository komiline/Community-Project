<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "job_matching";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}
// Fetch profiles from the database
$sql = "SELECT name, email, specialization, skill_level, interests, handicap FROM user_profiles";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $profiles = [];
    while ($row = $result->fetch_assoc()) {
        $profiles[] = [
            "name" => $row['name'],
            "email" => $row['email'],
            "specialization" => $row['specialization'],
            "skill_level" => $row['skill_level'],
            "interests" => $row['interests'],
            "handicap" => $row['handicap'], // Include handicap field
        ];
    }
    echo json_encode(["status" => "success", "profiles" => $profiles]);
} else {
    echo json_encode(["status" => "error", "message" => "No profiles found"]);
}

$conn->close();
?>