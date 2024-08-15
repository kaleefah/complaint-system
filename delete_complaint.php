<?php
session_start();

// Database connection details
$servername = "localhost";
$dbname = "complaint_system";
$dbusername = "root";
$dbpassword = "";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get complaint ID from POST data
    $id = intval($_POST["id"]);

    // SQL query to delete the complaint
    $sql = "DELETE FROM complaints WHERE id = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Execute the query
    if ($stmt->execute()) {
        $_SESSION['message'] = "Complaint deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting complaint: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Debugging output
    echo "Redirecting to complaints_summary.php";
    // Redirect back to the complaints summary page
    header("Location: complaints_summary.php");
    exit();
} else {
    // Debugging output
    echo "Not a POST request. Redirecting to complaints_summary.php";
    // Redirect to complaints summary page if not a POST request
    header("Location: complaints_summary.php");
    exit();
}
?>
