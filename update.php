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

if (isset($_GET['action']) && isset($_GET['event_id']) && isset($_GET['user_id'])) {
    $event_id = (int)$_GET['event_id'];
    $user_id = (int)$_GET['user_id'];
    $action = $_GET['action'];

    if ($action === "accept") {
        $points_to_add = 100; // Default for level 1; modify if levels are defined in your database

        // Optional: Fetch event level to set points accordingly if levels vary
        $event_result = $conn->query("SELECT level FROM events WHERE id = $event_id");
        if ($event_result->num_rows > 0) {
            $event_data = $event_result->fetch_assoc();
            $points_to_add = ($event_data['level'] == 2) ? 500 : 100;
        }

        $conn->query("UPDATE users SET points = points + $points_to_add WHERE id = $user_id");
        $conn->query("UPDATE events SET status = 'accepted' WHERE id = $event_id");

        echo json_encode(["status" => "success", "message" => "Points added"]);
    } elseif ($action === "decline") {
        $conn->query("UPDATE events SET status = 'declined' WHERE id = $event_id");
        echo json_encode(["status" => "success", "message" => "Event declined"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid parameters"]);
}

$conn->close();
?>