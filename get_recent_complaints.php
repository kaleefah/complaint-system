<?php
// get_recent_complaints.php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complaint_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch recent complaints
$sql = "SELECT id, complainant_name, DATE_FORMAT(date_submitted, '%Y-%m-%d') as date_submitted FROM complaints ORDER BY date_submitted DESC LIMIT 5";
$result = $conn->query($sql);

$complaints = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $complaints[] = $row;
    }
} else {
    echo json_encode([]);
    exit;
}

echo json_encode($complaints);

$conn->close();
?>
