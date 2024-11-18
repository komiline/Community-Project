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

if (isset($_GET['action']) && isset($_GET['id']) && isset($_GET['user_id'])) {
    $event_id = (int)$_GET['id'];
    $user_id = (int)$_GET['user_id'];
    $action = $_GET['action'];

    // Debug output
    error_log("action: $action, id: $event_id, user_id: $user_id");


    if ($action === "accept") {
        $points_to_add = 100; // Default points for level 1 events

        // Fetch event level to determine points
        $event_result = $conn->query("SELECT level FROM events WHERE id = $event_id");
        if ($event_result && $event_result->num_rows > 0) {
            $event_data = $event_result->fetch_assoc();
            $points_to_add = ($event_data['level'] == 2) ? 500 : 100;
        }

        // Update user points in the `user_points` table
        $update_points = $conn->query("INSERT INTO user_points (user_id, points) 
                                       VALUES ($user_id, $points_to_add) 
                                       ON DUPLICATE KEY UPDATE points = points + $points_to_add");

        // Update event status
        $update_event = $conn->query("UPDATE events SET status = 'accepted' WHERE id = $event_id");

        if ($update_points && $update_event) {
            echo json_encode(["status" => "success", "message" => "Points added and event accepted"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error updating database"]);
        }
    } elseif ($action === "decline") {
        $update_event = $conn->query("UPDATE events SET status = 'declined' WHERE id = $event_id");

        if ($update_event) {
            echo json_encode(["status" => "success", "message" => "Event declined"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error updating database"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
    }
} else {
    error_log("Invalid parameters: " . json_encode($_GET)); // Debug missing parameters
    echo json_encode(["status" => "error", "message" => "Invalid parameters"]);
}

$conn->close();
?>
