<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json'); // Ensure the response is JSON

// Database connection details
$servername = "localhost";
$db_username = "root"; // Update if necessary
$db_password = "";     // Update if necessary
$dbname = "job_matching";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from request
$data = json_decode(file_get_contents("php://input"), true);

$name = trim($data['name']);
$username = trim($data['username']);
$email = trim($data['email']);
$password = trim($data['password']);

// Validate that required fields are not empty
if (empty($username) || empty($email) || empty($password) || empty($name)) {
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit;
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Attempt to insert the data
$sql = "INSERT INTO users (name, username, email, password) VALUES ('$name', '$username', '$email', '$hashed_password')";

try {
    $conn->query($sql);
    echo json_encode(["status" => "success", "message" => "User registered successfully"]);
} catch (mysqli_sql_exception $e) {
    echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
}

$conn->close();
?>

