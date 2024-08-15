<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Database connection
$servername = "localhost";
$username = "root"; // default MySQL username
$password = ""; // default MySQL password
$dbname = "complaint_system";

// Enable detailed error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch form data
$username = $_POST['username'];
$email = $_POST['email'];
$current_username = $_SESSION['username'];
$profile_image = $_FILES['profile_image'];

// Handle profile image upload
$image_name = $user['profile_image']; // Default to current image if no new image uploaded
if ($profile_image['size'] > 0) {
    $target_dir = "public/";
    $target_file = $target_dir . basename($profile_image["name"]);
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate image file
    $check = getimagesize($profile_image["tmp_name"]);
    if ($check === false) {
        $_SESSION['error'] = "File is not an image.";
        header('Location: profile.php');
        exit();
    }

    // Allow certain file formats
    if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg") {
        $_SESSION['error'] = "Only JPG, JPEG, and PNG files are allowed.";
        header('Location: profile.php');
        exit();
    }

    // Upload file
    if (!move_uploaded_file($profile_image["tmp_name"], $target_file)) {
        $_SESSION['error'] = "Sorry, there was an error uploading your file.";
        header('Location: profile.php');
        exit();
    }

    // Set new image name
    $image_name = basename($profile_image["name"]);
}

// Update user profile in the database
$sql = "UPDATE users SET username=?, email=?, profile_image=? WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $username, $email, $image_name, $current_username);

if ($stmt->execute()) {
    $_SESSION['username'] = $username; // Update session username if changed
    $_SESSION['success'] = "Profile updated successfully!";
} else {
    $_SESSION['error'] = "Failed to update profile: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();

header('Location: profile.php');
exit();
?>
