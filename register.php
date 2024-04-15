<?php
// Database configuration
$servername = "localhost"; // Change this to your MySQL server hostname
$username = "root"; // Change this to your MySQL username
$password = "Admin128@#"; // Change this to your MySQL password
$database = "site_data"; // Change this to your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$bloodGroup = $_POST['bloodGroup'];

// SQL query to insert data into database
$sql = "INSERT INTO users (username, email, password, bloodGroup) VALUES ('$username', '$email', '$password', '$bloodGroup')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>