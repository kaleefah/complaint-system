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

// SQL query to count total complaints
$sql = "SELECT COUNT(*) as total FROM complaints";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $conn->error;
} else {
    $row = $result->fetch_assoc();
    echo $row['total'];
}

$conn->close();
?>
