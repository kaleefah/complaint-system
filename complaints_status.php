<?php
session_start();
// Check if the 'username' session variable is not set (not authenticated)
if (!isset($_SESSION['username'])) {
    // Redirect to the login page or any other page where login is handled
    header("Location: admin_login.php"); // Adjust the URL as per your setup
    exit(); // Ensure that no further code is executed
}

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

// Fetch pending complaints
$pendingComplaintsQuery = "SELECT * FROM complaints WHERE status = 'Pending'";
$pendingComplaintsResult = $conn->query($pendingComplaintsQuery);

// Fetch resolved complaints
$resolvedComplaintsQuery = "SELECT * FROM complaints WHERE status = 'Resolved'";
$resolvedComplaintsResult = $conn->query($resolvedComplaintsQuery);

// Fetch in-progress complaints
$inProgressComplaintsQuery = "SELECT * FROM complaints WHERE status = 'In Progress'";
$inProgressComplaintsResult = $conn->query($inProgressComplaintsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints Status</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .header {
            background: linear-gradient(45deg, rgba(255, 0, 102, 0.8), rgba(255, 204, 0, 0.8)) center top no-repeat;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 100px;
            background: linear-gradient(45deg, rgba(255, 0, 102, 0.8), rgba(255, 204, 0, 0.8));
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            color: white;
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
            display: block;
            transition: background-color 0.3s, padding-left 0.3s;
        }
        .sidebar a:hover {
            background-color: rgba(255, 204, 0, 0.8);
            padding-left: 30px;
        }
        .content {
            margin-left: 270px;
            padding: 40px;
            padding-bottom: 80px;
        }
        .container {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border-radius: 8px;
            margin-top: 50px;
        }
        h1 {
            margin: 0;
            font-size: 28px;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #f9f9f9;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: rgba(255, 204, 0, 0.8);
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e9ecef;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background: linear-gradient(45deg, rgba(255, 0, 102, 0.8), rgba(255, 204, 0, 0.8)) center top no-repeat;
            color: #fff;
            border-radius: 5px;
        }
        .nav a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
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
        <div class="header">
            <h1>Complaints Status</h1>
            <nav class="nav">
                <a href="admin_page.php"><i class="fas fa-arrow-left"></i> Back to Admin Dashboard</a>
            </nav>
        </div>

        <div class="container">
            <section id="pending-complaints">
                <h2>Pending Complaints</h2>
                <?php
                if ($pendingComplaintsResult->num_rows > 0) {
                    echo "<table><tr><th>ID</th><th>Complaint Text</th><th>Date Submitted</th></tr>";
                    while ($row = $pendingComplaintsResult->fetch_assoc()) {
                        echo "<tr><td>{$row['id']}</td><td>{$row['complaint_details']}</td><td>{$row['created_at']}</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No pending complaints.</p>";
                }
                ?>
            </section>

            <section id="in-progress-complaints">
                <h2>In Progress Complaints</h2>
                <?php
                if ($inProgressComplaintsResult->num_rows > 0) {
                    echo "<table><tr><th>ID</th><th>Complaint Text</th><th>Date Submitted</th></tr>";
                    while ($row = $inProgressComplaintsResult->fetch_assoc()) {
                        echo "<tr><td>{$row['id']}</td><td>{$row['complaint_details']}</td><td>{$row['created_at']}</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No in-progress complaints.</p>";
                }
                ?>
            </section>

            <section id="resolved-complaints">
                <h2>Resolved Complaints</h2>
                <?php
                if ($resolvedComplaintsResult->num_rows > 0) {
                    echo "<table><tr><th>ID</th><th>Complaint Text</th><th>Date Submitted</th></tr>";
                    while ($row = $resolvedComplaintsResult->fetch_assoc()) {
                        echo "<tr><td>{$row['id']}</td><td>{$row['complaint_details']}</td><td>{$row['created_at']}</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No resolved complaints.</p>";
                }
                ?>
            </section>
        </div>

        <div class="footer">
            <p>&copy; 2024 QuickComplaint. All rights reserved.</p>
        </div>
    </div>
    <?php $conn->close(); ?>
</body>
</html>
