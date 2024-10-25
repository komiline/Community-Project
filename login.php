<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Update if necessary
$password = ""; // Update if necessary
$dbname = "job_matching";

// Create connection
$conn = new mysqli("localhost", $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect data from form
$user_name = $_POST['username'];
$pwd = $_POST['password'];

// Validate login details
if (!empty($user_name) && !empty($pwd)) {
    $sql = "SELECT * FROM users WHERE username='$user_name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the user data
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($pwd, $user['password'])) {
            echo "Login successful! Welcome, " . $user['name'];
            // You can redirect the user to a dashboard or another page here
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }
} else {
    echo "All fields are required!";
}

// Close connection
$conn->close();
?>
