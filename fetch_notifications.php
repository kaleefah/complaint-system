<?php
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

// Fetch latest complaints
$sql = "SELECT id, complaint_text, created_at FROM complaints ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="notification">';
        echo '<div class="notification-details">';
        echo '<span class="notification-id">Complaint ID: ' . $row["id"] . '</span>';
        echo '<span class="notification-text">' . $row["complaint_text"] . '</span>';
        echo '<span class="notification-date">Submitted on: ' . $row["created_at"] . '</span>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<div class="notification">No new complaints</div>';
}

$conn->close();
?>
