<?php
// db.php
$servername = "localhost";
$dbusername = "root"; // default MySQL username
$dbpassword = ""; // default MySQL password
$dbname = "complaint_system";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
