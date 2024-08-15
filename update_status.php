<?php
session_start();
include 'db.php';

// Correct paths to PHPMailer files
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Function to send email
function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Use Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'muhammadkalefo@gmail.com'; // Your Gmail email address
        $mail->Password = 'your_password'; // Your Gmail password or app-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('your_email@gmail.com', 'QuickComplaints');
        $mail->addAddress($to);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $complaint_id = $_POST['complaint_id'];
    $status = $_POST['status'];

    // Get the email of the complainant
    $stmt = $conn->prepare("SELECT email, complaint_details FROM complaints WHERE id = ?");
    $stmt->bind_param("i", $complaint_id);
    $stmt->execute();
    $stmt->bind_result($email, $complaint_details);
    $stmt->fetch();
    $stmt->close();

    if ($email) {
        // Update the status
        $stmt = $conn->prepare("UPDATE complaints SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $complaint_id);
        if ($stmt->execute()) {
            // Send notification email
            $subject = "Update on Your Complaint";
            $body = "Dear Student,<br><br>The status of your complaint has been updated to: $status.<br><br>Complaint Details: $complaint_details<br><br>Thank you,<br>QuickComplaints Team";
            sendEmail($email, $subject, $body);

            $_SESSION['success'] = 'Status updated and notification sent successfully!';
        } else {
            $_SESSION['error'] = 'Failed to update status: ' . htmlspecialchars($stmt->error);
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = 'Invalid complaint ID.';
    }

    $conn->close();

    header('Location: update_status_form.php');
    exit();
} else {
    $_SESSION['error'] = 'Invalid request method.';
    header('Location: update_status_form.php');
    exit();
}
?>
