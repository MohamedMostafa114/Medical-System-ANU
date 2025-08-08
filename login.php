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
    // Get the input values from the form
    $input_username = $conn->real_escape_string($_POST['username']);
    $input_password = $_POST['password'];

    // Query to check if the username exists
    $sql = "SELECT * FROM user WHERE username = '$input_username'"; // Ensure the table name is 'user'
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, fetch the data
        $row = $result->fetch_assoc();

        // Check if the password is plain text or hashed
        if (password_needs_rehash($row['password'], PASSWORD_DEFAULT)) {
            // If password is plain-text (or not hashed correctly), rehash and store the new hash
            // Only do this when you want to update the password in the database
            $hashed_password = password_hash($input_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE user SET password = '$hashed_password' WHERE id = {$row['id']}";
            $conn->query($update_sql);
            // Verify the hashed password
            if (password_verify($input_password, $hashed_password)) {
                // Password is correct, start the session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_type'] = $row['user_type']; // Admin or User

                // Redirect to index.html after successful login
                header("Location: index.html"); // Redirect to index.html after successful login
                exit();
            } else {
                // Invalid password
                echo "Invalid password. Please try again.";
            }
        } else {
            // If password is already hashed, use password_verify
            if (password_verify($input_password, $row['password'])) {
                // Password is correct, start the session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_type'] = $row['user_type']; // Admin or User

                // Redirect to index.html after successful login
                header("Location: index.html"); // Redirect to index.html after successful login
                exit();
            } else {
                // Invalid password
                echo "Invalid password. Please try again.";
            }
        }
    } else {
        // User not found
        echo "No user found with that username.";
    }
}

// Close the database connection
$conn->close();
?>
