<?php
// Database connection credentials
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your MySQL password
$dbname = "medical_center";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database 'medical_center' created successfully.<br>";
} else {
    die("Error creating database: " . $conn->error);
}

// Use the created database
$conn->select_db($dbname);

// Create table
$tableName = "appointment_requests";
$sql = "CREATE TABLE IF NOT EXISTS $tableName (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(50),
    lname VARCHAR(50),
    email VARCHAR(100),
    phone VARCHAR(20),
    reason TEXT,
    additional_info TEXT,
    pharmacy_details TEXT,
    request_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'appointment_requests' created successfully.<br>";
} else {
    die("Error creating table: " . $conn->error);
}

// Insert data into the table
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $reason = $_POST['reason'];
    $additional_info = $_POST['app-add'];
    $pharmacy_details = '';

    if ($_POST['radioOptions3'] === 'Delivery within 24 hours') {
        $pharmacy_details = "Your full address: " . $_POST['address'];
    } else {
        $pharmacy_details = "Preferred pharmacy: " . $_POST['pharmacy'] . "\n" .
                            "Phone number: " . $_POST['pharm-number'] . "\n" .
                            "Fax number: " . $_POST['pharm-fax-number'] . "\n" .
                            "Full address: " . $_POST['pharm-address'];
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO $tableName (fname, lname, email, phone, reason, additional_info, pharmacy_details) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $fname, $lname, $email, $phone, $reason, $additional_info, $pharmacy_details);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Data inserted successfully into 'appointment_requests' table.<br>";
    } else {
        echo "Error inserting data: " . $stmt->error;
    }

    $stmt->close();
}

// Include booking success HTML
include("booking_success.html");

// Require config file for email credentials
require_once('config.php');

// Send email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php";

global $email_address, $password, $from, $fromName, $subject;

$mail = new PHPMailer(true);

// Enable SMTP debugging
$mail->SMTPDebug = false;
// Set PHPMailer to use SMTP
$mail->isSMTP();
// Set SMTP host name
$mail->Host = "smtp.gmail.com";
// Set this to true if SMTP host requires authentication to send email
$mail->SMTPAuth = true;

// Provide username and password
$mail->Username = $email_address;
$mail->Password = $password;

// If SMTP requires TLS encryption then set it
$mail->SMTPSecure = "tls";
// Set TCP port to connect to
$mail->Port = 587;

$mail->From = $from;
$mail->FromName = $fromName;

// To address and name
$mail->addAddress($_POST['email'], $_POST['fname'] . " " . $_POST['lname']);

// Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = $subject;

$mail->Body = '<div style="background-color:#e0eaef; padding:50px 0px 50px 0px;">
      <div style="background-color:#282b5e; margin:0px 50px 0px 50px; font-family: Arial, Helvetica, sans-serif;">
        <div style="color:white; padding:25px 50px 25px 50px;">
          <h2>' . $_POST['fname'] . ' ' . $_POST['lname'] . ',</h2>
          <h2>Thank you for requesting an appointment with Dundurn Medical Centre. We will get back to you soon.</h2>
          <h2>Below is a summary of your submission.</h2>
          <br>
      		<h1>Appointment Request</h1>
          <br>
        	<div>
      			<div style="color:white;">
    					<h2>About you</h2>
        			<h3>I am a new patient:' . ' ' . $_POST['radioOptions1'] . '</h3>
        			<h3>Is the patient a child? (under 18):' . ' ' . $_POST['radioOptions2'] . '</h3>
      			  <h3>Phone number:' . ' ' . $_POST['phone'] . '</h3>
              <h3>Additional Information:</h3>
        			<h3>' . $_POST['you-add'] . '</h3>
              <br>
        			<h2>About your appointment</h2>
              <h3>Reason for visit:' . ' ' . $_POST['reason'] . '</h3>
              <h3>Additional Information:</h3>
      				<h3>' . $_POST['app-add'] . '</h3>
              <br>
        			<h2>Pharmacy details</h2>
              <h3>Where do you want your prescription:' . ' ' . $_POST['radioOptions3'] . '</h3>
              <h3>' . $pharmacy_details . '</h3>
      		</div>
        </div>
    	</div>
    </div>';

$mail->send();

// Close database connection
$conn->close();
?>
