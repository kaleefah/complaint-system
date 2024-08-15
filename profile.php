<?php
// Start session to access session variables
session_start();

// Check if the 'username' session variable is not set (not authenticated)
if (!isset($_SESSION['username'])) {
    // Redirect to the login page or any other page where login is handled
    header("Location: admin_login.php"); // Adjust the URL as per your setup
    exit(); // Ensure that no further code is executed
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

// Fetch user profile details
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $conn->error . "<br>";
    echo "SQL: " . $sql . "<br>";
    exit(); // Stop the script execution
}

$user = $result->fetch_assoc();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
   <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.header,
.sidebar {
    background: linear-gradient(45deg, rgba(255, 0, 102, 0.8), rgba(255, 204, 0, 0.8)) center top no-repeat;
    color: white;
}

.header {
    padding: 20px;
    font-size: 24px;
    font-weight: bold;
    letter-spacing: 2px;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header .logo img {
    height: 40px;
}

.header .nav-icons {
    display: flex;
    align-items: center;
}

.header .nav-icons a {
    font-size: 20px;
    margin-left: 20px;
    color: white;
    transition: color 0.3s;
}

.header .nav-icons a:hover {
    color: rgba(255, 204, 0, 0.8);
}

.sidebar {
    height: 100vh;
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    padding-top: 100px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
}

.sidebar .logo {
    font-size: 24px;
    text-align: center;
    margin-bottom: 30px;
    font-weight: bold;
}

.sidebar a {
    padding: 15px 20px;
    text-decoration: none;
    font-size: 18px;
    color: white;
    width: 100%;
    text-align: left;
    transition: background-color 0.3s, padding-left 0.3s;
}

.sidebar a:hover {
    background-color:  rgba(255, 204, 0, 0.8);
}

.content {
    margin-left: 270px;
    padding: 40px;
    padding-bottom: 80px;
    background: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    max-width: 1200px;
    margin: 40px auto;
}

.profile-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #eaeaea;
    padding-bottom: 20px;
    margin-bottom: 20px;
}

.profile-header img {
    border-radius: 50%;
    width: 120px;
    height: 120px;
    object-fit: cover;
    border: 3px solid  rgba(255, 204, 0, 0.8);
}

.profile-header .profile-info {
    flex: 1;
    margin-left: 20px;
}

.profile-header .profile-info h2 {
    margin: 0;
    font-size: 24px;
}

.profile-header .profile-info p {
    margin: 5px 0;
    color: #666;
}

.profile-header .profile-actions {
    text-align: right;
}

.profile-header .profile-actions .btn {
    margin-bottom: 5px;
    background: linear-gradient(45deg, rgba(255, 0, 102, 0.8), rgba(255, 204, 0, 0.8)) center top no-repeat;
    border: none;
    color: white;
    transition: background 0.3s;
}

.profile-header .profile-actions .btn:hover {
    background: #ff007a;
}

.profile-details {
    display: flex;
    justify-content: space-between;
}

.profile-details .detail-item {
    flex: 1;
    margin: 0 10px;
}

.profile-details .detail-item h3 {
    margin-bottom: 10px;
    font-size: 18px;
    border-bottom: 2px solid #ff007a;
    display: inline-block;
    padding-bottom: 5px;
    color:#ffcc00;
}

.profile-details .detail-item p {
    margin: 5px 0;
    color: #333;
}

.profile-details .detail-item p i {
    margin-right: 10px;
    color: #ff007a;
}

.edit-profile {
    margin-top: 30px;
}

.edit-profile h2 {
    margin-bottom: 20px;
    font-size: 22px;
    border-bottom: 2px solid #ff007a;
    display: inline-block;
    padding-bottom: 5px;
    color: #ffcc00;
}

.edit-profile .form-group {
    margin-bottom: 20px;
}

.edit-profile .form-control {
    border-radius: 5px;
    border: 1px solid #ddd;
    padding: 10px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.edit-profile .form-control:focus {
    border-color: #ffcc00;
    box-shadow: none;
}

.edit-profile .btn-primary {
    background: linear-gradient(45deg, rgba(255, 0, 102, 0.8), rgba(255, 204, 0, 0.8)) center top no-repeat;
    border: none;
    color: white;
    transition: background 0.3s;
}

.edit-profile .btn-primary:hover {
    background: #ffcc00;
}

    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <a href="admin_page.php">
            </a>
        </div>
        <div>User Profile</div>
        <div class="nav-icons">
            <a href="notifications.php"><i class="fas fa-bell"></i></a>
            <a href="profile.php"><i class="fas fa-user"></i></a>
        </div>
    </div>
    <div class="sidebar">
    <div class="logo">QuickComplaint</div>

        <a href="admin_page.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="update_status_form.php"><i class="fas fa-sync-alt"></i> Update Complaint Status</a>
        <a href="complaints_summary.php"><i class="fas fa-users"></i> Complaint Summary</a>
        <a href="complaints_status.php"><i class="fas fa-hourglass-half"></i>Complaints Status</a>
        <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <div class="content">
        <div class="container">
            <div class="profile-header">
                <img src="public/<?php echo htmlspecialchars($user['profile_image'] ?: 'default.jpg'); ?>" alt="Profile Image">
                <div class="profile-info">
                    <h2><?php echo htmlspecialchars($user['username']); ?></h2>
                    <p><?php echo htmlspecialchars($user['role']); ?></p>
                </div>
                <div class="profile-actions">
                    <a href="admin_page.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                </div>
            </div>
            <div class="profile-details">
                <div class="detail-item">
                    <h3>Profile Details</h3>
                    <p><i class="fas fa-user"></i><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                    <p><i class="fas fa-envelope"></i><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                </div>
            </div>
            <div class="edit-profile">
                <h2>Edit Profile</h2>
                <form action="update_profile.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="profile_image">Profile Image:</label>
                        <input type="file" name="profile_image" id="profile_image" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
