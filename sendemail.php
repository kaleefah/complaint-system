<?php
// Function to send email
function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Use Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'muhammadkalefo@gmail.com'; // Your Gmail email address
        $mail->Password = 'kalifahs'; // Your Gmail password or app-specific password
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

// Example function to update complaint status and notify user
function updateComplaintStatus($complaint_id, $new_status, $user_email) {
    global $conn;

    // Update the status in the database
    $stmt = $conn->prepare("UPDATE complaints SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $complaint_id);
    if ($stmt->execute()) {
        // Send notification email
        $subject = "Complaint Status Updated";
        $body = "Dear Student,<br><br>Your complaint status has been updated to: $new_status.<br><br>Thank you,<br>QuickComplaints Team";
        sendEmail($user_email, $subject, $body);
    } else {
        echo "Failed to update status: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
}
?>
