<?php
// Start the session
session_start();

// Database connection credentials
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your MySQL password
$dbname = "medical_center";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input values
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $gender = isset($_POST['gender']) ? $conn->real_escape_string($_POST['gender']) : 'other'; // Default to 'other'
    $age = isset($_POST['age']) ? (int)$_POST['age'] : 0; // Default to 0
    $user_type = isset($_POST['user_type']) ? $conn->real_escape_string($_POST['user_type']) : 'user'; // Default to 'user'

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the data into the database
        $sql = "INSERT INTO user (username, email, password, gender, age, user_type) 
                VALUES ('$username', '$email', '$hashed_password', '$gender', $age, '$user_type')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to index.html upon successful signup
            header("Location: index.html");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>
