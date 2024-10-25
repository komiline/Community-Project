<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Update if needed
$password = ""; // Update if necessary
$dbname = "job_matching";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect data from form
$name = $_POST['name'];
$user_name = $_POST['username'];
$email = $_POST['email'];
$pwd = $_POST['password'];
$confirm_pwd = $_POST['confirm_password'];

// Validate data
if (!empty($name) && !empty($user_name) && !empty($email) && !empty($pwd) && !empty($confirm_pwd)) {
    if ($pwd === $confirm_pwd) {
        
        // Check if username or email already exists
        $check_user = "SELECT * FROM users WHERE username='$user_name' OR email='$email'";
        $result = $conn->query($check_user);

        if ($result->num_rows > 0) {
            echo "Username or email already exists!";
        } else {
            // Hash the password
            $hashed_password = password_hash($pwd, PASSWORD_DEFAULT);
            
            // Insert data into database
            $sql = "INSERT INTO users (name, username, email, password) VALUES ('$name', '$user_name', '$email', '$hashed_password')";

            if ($conn->query($sql) === TRUE) {
                echo "Registration successful!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Passwords do not match!";
    }
} else {
    echo "All fields are required!";
}

// Close connection
$conn->close();
?>
