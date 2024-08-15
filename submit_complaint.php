<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'anonymous' checkbox is set and its value
    $isAnonymous = isset($_POST['anonymous']) && $_POST['anonymous'] == '1';

    // Ensure 'complainant_name' and 'email' are not null
    $complainant_name = $isAnonymous ? 'Anonymous' : (isset($_POST['complainant_name']) && !empty($_POST['complainant_name']) ? $_POST['complainant_name'] : 'Anonymous');
    $email = $isAnonymous ? 'Anonymous' : (isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : 'Anonymous');
    $complaint_subject = $_POST['complaint_subject'];
    $complaint_details = $_POST['complaint_details'];
    $department = $_POST['department'];
    $anonymous = $isAnonymous ? 1 : 0;

    // Validate non-anonymous fields
    if (!$isAnonymous && (empty($complainant_name) || empty($email))) {
        $_SESSION['error'] = "Complainant name and email are required.";
        header("Location: complaint.php");
        exit();
    }

    $servername = "localhost";
    $dbname = "complaint_system";
    $dbusername = "root";
    $dbpassword = "";

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $complaintFile = '';
    if (isset($_FILES['complaintFile']) && $_FILES['complaintFile']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $complaintFile = $target_dir . basename($_FILES["complaintFile"]["name"]);
        if (!move_uploaded_file($_FILES["complaintFile"]["tmp_name"], $complaintFile)) {
            $_SESSION['error'] = "Sorry, there was an error uploading your file.";
            header("Location: complaint.php");
            exit();
        }

        // Debugging: Confirm file upload success
        if (file_exists($complaintFile)) {
            echo "File uploaded successfully: " . $complaintFile . "<br>";
        } else {
            echo "File upload failed.";
        }
    } else {
        echo "No file uploaded or there was an error during file upload.";
    }

    $date_submitted = date('Y-m-d');
    $sql = "INSERT INTO complaints (complainant_name, complaint_subject, complaint_details, anonymous, complaint_file, department, email, date_submitted) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("sssissss", $complainant_name, $complaint_subject, $complaint_details, $anonymous, $complaintFile, $department, $email, $date_submitted);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Complaint submitted successfully!";
        header("Location: complaint.php");
        exit();
    } else {
        $_SESSION['error'] = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        header("Location: complaint.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: complaint.php");
    exit();
}
?>
