<?php
header('Content-Type: application/json');

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

// SQL query to fetch complaints
$sql = "SELECT DATE(created_at) as date, COUNT(*) as count FROM complaints GROUP BY DATE(created_at) ORDER BY DATE(created_at)";
$result = $conn->query($sql);

// Check if the query was successful
if ($result === false) {
    echo json_encode(["error" => $conn->error]);
    exit();
}

// Prepare data for JSON response
$data = [];
$cumulativeCount = 0;
while ($row = $result->fetch_assoc()) {
    $cumulativeCount += $row['count'];
    $data[] = ['date' => $row['date'], 'count' => $cumulativeCount];
}

// Close the database connection
$conn->close();

echo json_encode($data);
?>
