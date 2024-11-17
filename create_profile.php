<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json'); // Ensure response is JSON

// Database connection details
$servername = "localhost";
$db_username = "root"; // Update if necessary
$db_password = "";     // Update if necessary
$dbname = "job_matching"; // Adjust to match your database name

$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

// Get data from the request
$data = json_decode(file_get_contents("php://input"), true);

$name = trim($data['name']);
$email = trim($data['email']);
$gender = trim($data['gender']);
$age = intval($data['age']);
$handicap = trim($data['handicap']);
$specialization = trim($data['specialization']);
$skill_level = trim($data['skill_level']);
$years_of_experience = intval($data['years_of_experience']);
$personality_traits = trim($data['personality_traits']);
$language_proficiency = trim($data['language_proficiency']);
$certifications = trim($data['certifications']);
$interests = trim($data['interests']);
$availability = intval($data['availability']);
$job_type = trim($data['job_type']);
$preferred_industry = trim($data['preferred_industry']);

// Validate required fields
if (empty($name) || empty($email) || empty($gender) || empty($age) || empty($handicap) || empty($specialization) || empty($skill_level)) {
    echo json_encode(["status" => "error", "message" => "All required fields must be filled"]);
    exit;
}

// Insert data into the database
$sql = "INSERT INTO profiles (
    name, email, gender, age, handicap, specialization, skill_level, years_of_experience, personality_traits, 
    language_proficiency, certifications, interests, availability, job_type, preferred_industry
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sssssssisssssss",
    $name, $email, $gender, $age, $handicap, $specialization, $skill_level, $years_of_experience,
    $personality_traits, $language_proficiency, $certifications, $interests, $availability, $job_type, $preferred_industry
);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Profile created successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
