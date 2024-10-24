<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Update if necessary
$password = "your_password"; // Your MySQL password
$dbname = "job_matching";

// Create connection
$conn = new mysqli("localhost", "root", "bundemall12", "job_matching");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect data from form
$name = $_POST['name'];
$user_name = $_POST['username'];
$email = $_POST['email'];
$pwd = $_POST['password'];

// Validate the data (basic validation)
if (!empty($name) && !empty($user_name) && !empty($email) && !empty($pwd)) {
    
    // Check if the username or email already exists
    $check_user = "SELECT * FROM users WHERE username='$user_name' OR email='$email'";
    $result = $conn->query($check_user);

    if ($result->num_rows > 0) {
        echo "Username or email already exists!";
    } else {
        // Hash the password
        $hashed_password = password_hash($pwd, PASSWORD_DEFAULT);
        
        // Insert data into the database
        $sql = "INSERT INTO users (name, username, email, password) 
                VALUES ('$name', '$user_name', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "Please fill in all fields.";
}

// Close connection
$conn->close();
?>
