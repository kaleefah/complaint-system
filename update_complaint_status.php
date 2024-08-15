<?php
include 'send_email.php';

// Database connection parameters
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "complaint_system"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaintID = $_POST['complaint_id'];
    $status = $_POST['status'];

    // Update complaint status in the database
    $sql = "UPDATE complaints SET status = '$status' WHERE id = $complaintID";
    if ($conn->query($sql) === TRUE) {
        // Fetch the student's email
        $sql = "SELECT email FROM complaints WHERE id = $complaintID";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $studentEmail = $row['email'];

            // Send status update email
            $subject = "Complaint Status Update";
            $body = "Dear Student,<br><br>Your complaint status has been updated to: $status.<br><br>Thank you,<br>QuickComplaints Team";
            sendEmail($studentEmail, $subject, $body);

            echo "Complaint status updated and email notification sent.";
        } else {
            echo "Error: Student email not found.";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
