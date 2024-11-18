<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "job_matching";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

// Extract form fields from $_POST
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : null;
$name = isset($_POST['name']) ? trim($_POST['name']) : null;
$email = isset($_POST['email']) ? trim($_POST['email']) : null;
$gender = isset($_POST['gender']) ? trim($_POST['gender']) : null;
$age = isset($_POST['age']) ? intval($_POST['age']) : null;
$handicap = isset($_POST['handicap']) ? trim($_POST['handicap']) : null;
$specialization = isset($_POST['specialization']) ? trim($_POST['specialization']) : null;
$skill_level = isset($_POST['skill_level']) ? trim($_POST['skill_level']) : null;
$years_of_experience = isset($_POST['years_of_experience']) ? intval($_POST['years_of_experience']) : null;
$personality_traits = isset($_POST['personality_traits']) ? trim($_POST['personality_traits']) : null;
$language_proficiency = isset($_POST['language_proficiency']) ? trim($_POST['language_proficiency']) : null;
$certifications = isset($_POST['certifications']) ? trim($_POST['certifications']) : null;
$interests = isset($_POST['interests']) ? trim($_POST['interests']) : null;
$availability = isset($_POST['availability']) ? intval($_POST['availability']) : null;
$job_type = isset($_POST['job_type']) ? trim($_POST['job_type']) : null;
$preferred_industry = isset($_POST['preferred_industry']) ? trim($_POST['preferred_industry']) : null;
$comments = isset($_POST['comments']) ? trim($_POST['comments']) : null;

// Handle file uploads
$profile_picture = null;
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $profile_picture = 'uploads/' . basename($_FILES['photo']['name']);
    move_uploaded_file($_FILES['photo']['tmp_name'], $profile_picture);
}

$resume = null;
if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
    $resume = 'uploads/' . basename($_FILES['resume']['name']);
    move_uploaded_file($_FILES['resume']['tmp_name'], $resume);
}

// Validate required fields
if (!$user_id || empty($name) || empty($email) || empty($specialization) || empty($skill_level)) {
    echo json_encode(["status" => "error", "message" => "Required fields are missing"]);
    exit;
}

// Insert the profile into the database
$sql = "INSERT INTO user_profiles (user_id, name, email, gender, age, handicap, specialization, skill_level, years_of_experience, personality_traits, language_proficiency, certifications, interests, availability, job_type, preferred_industry, comments, profile_picture, resume)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isssisissssssisssss", $user_id, $name, $email, $gender, $age, $handicap, $specialization, $skill_level, $years_of_experience, $personality_traits, $language_proficiency, $certifications, $interests, $availability, $job_type, $preferred_industry, $comments, $profile_picture, $resume);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Profile created successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error creating profile: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
