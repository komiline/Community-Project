<?php

header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job_matching";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

$sql = "SELECT u.username, p.points 
        FROM users u
        JOIN user_points p ON u.user_id = p.user_id
        ORDER BY p.points DESC
        LIMIT 4";
$result = $conn->query($sql);

$leaderboard = [];
$rank = 1;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $leaderboard[] = [
            "rank" => $rank,
            "username" => htmlspecialchars($row['username']),
            "points" => $row['points']
        ];
        $rank++;
    }
}

echo json_encode($leaderboard);

$conn->close();
?>

        