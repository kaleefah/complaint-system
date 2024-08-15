<?php
header('Content-Type: text/plain');

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complaint_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to count resolved complaints
$sql = "SELECT COUNT(*) as pending_complaints FROM complaints WHERE status = 'pending'";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $conn->error;
} else {
    $row = $result->fetch_assoc();
    echo $row['pending_complaints'];
}

$conn->close();
?>
