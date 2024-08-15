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

// Initialize variables for pagination and search
$search = "";
$search_error = "";
$results_per_page = 10; // Number of results per page

// Process search form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate search input
    $search = trim($_POST["search"]);
    $search = mysqli_real_escape_string($conn, $search); // Escape special characters

    // Perform search query
    $sql = "SELECT COUNT(*) AS total FROM complaints
            WHERE id LIKE '%$search%'
            OR complainant_name LIKE '%$search%'
            OR department LIKE '%$search%'
            OR email LIKE '%$search%'";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_results = $row['total'];

    $total_pages = ceil($total_results / $results_per_page); // Calculate total pages

    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $current_page = intval($_GET['page']);
    } else {
        $current_page = 1;
    }

    $offset = ($current_page - 1) * $results_per_page; // Calculate offset for pagination

    // Query to retrieve complaints with pagination and search
    $sql = "SELECT id, complainant_name, complaint_subject, complaint_details, anonymous, date_submitted, department, email, complaint_file
            FROM complaints
            WHERE id LIKE '%$search%'
            OR complainant_name LIKE '%$search%'
            OR department LIKE '%$search%'
            OR email LIKE '%$search%'
            LIMIT $offset, $results_per_page";

    $result = $conn->query($sql);

    if ($result === false) {
        $search_error = "Error: " . $conn->error;
    }
} else {
    // Default query to retrieve all complaints with pagination
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $current_page = intval($_GET['page']);
    } else {
        $current_page = 1;
    }

    $offset = ($current_page - 1) * $results_per_page; // Calculate offset for pagination

    $sql = "SELECT COUNT(*) AS total FROM complaints";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_results = $row['total'];

    $total_pages = ceil($total_results / $results_per_page); // Calculate total pages

    // Query to retrieve complaints with pagination
    $sql = "SELECT id, complainant_name, complaint_subject, complaint_details, anonymous, date_submitted, department, email, complaint_file
            FROM complaints
            LIMIT $offset, $results_per_page";

    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints Summary</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1500px;
            margin: 0 auto;
            padding: 40px;
            margin-top: 3px;
        }
        .header {
            background: linear-gradient(45deg, rgba(255, 0, 102, 0.8), rgba(255, 204, 0, 0.8)) center top no-repeat;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .table-container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 20px;
        }
        .table-container h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .table-container table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table-container table th, .table-container table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        .table-container table th {
            background-color: rgba(255, 204, 0, 0.8);
            color: white;
        }
        .table-container table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .table-container table tbody tr:hover {
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
        .input-group .form-control {
            border-right: none;
        }
        .input-group .input-group-append .btn {
            border-left: none;
        }
        .profile-actions {
            margin-left: 10px;
        }
        .alert {
            margin-top: 20px;
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
    <div class="container">
        <div class="header">
            <h1>Complaints Summary</h1>
            <form class="form-inline justify-content-center mb-2" method="POST">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search by ID, Name, Department, or Email" name="search" value="<?php echo htmlspecialchars($search); ?>">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i> Search</button>
                    </div>
                    <div class="profile-actions">
                        <a href="admin_page.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                    </div>
                </div>
            </form>
            <?php if ($search_error): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $search_error; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="table-container">
            <?php
            if ($result && $result->num_rows > 0) {
                echo "<table class='table'>";
                echo "<thead><tr><th>ID</th><th>Complainant Name</th><th>Subject</th><th>Details</th><th>Date Submitted</th><th>Department</th><th>Email</th><th>Attachment</th><th>Actions</th></tr></thead>";
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["complainant_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["complaint_subject"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["complaint_details"]) . "</td>";
                    // echo "<td>" . ($row["anonymous"] ? "Yes" : "No") . "</td>";
                    echo "<td>" . htmlspecialchars($row["date_submitted"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["department"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>";
                    if (!empty($row["complaint_file"])) {
                        echo "<a href='./" . htmlspecialchars($row["complaint_file"]) . "' target='_blank'>View Attachment</a>";
                    } else {
                        echo "No Attachment";
                    }
                    echo "</td>";
                    echo "<td>";
                    echo "<form action='delete_complaint.php' method='POST' style='display:inline-block;'>";
                    echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                    echo "<button type='submit' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this complaint?\");'><i class='fas fa-trash'></i></button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";

                // Pagination
                echo "<nav aria-label='Page navigation'>";
                echo "<ul class='pagination justify-content-center'>";
                if ($current_page > 1) {
                    echo "<li class='page-item'><a class='page-link' href='complaints_summary.php?page=" . ($current_page - 1) . "'>&laquo; Previous</a></li>";
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<li class='page-item " . ($i == $current_page ? 'active' : '') . "'><a class='page-link' href='complaints_summary.php?page=$i'>$i</a></li>";
                }
                if ($current_page < $total_pages) {
                    echo "<li class='page-item'><a class='page-link' href='complaints_summary.php?page=" . ($current_page + 1) . "'>Next &raquo;</a></li>";
                }
                echo "</ul>";
                echo "</nav>";
            } else {
                echo "<p>No complaints found.</p>";
            }
            $conn->close();
            ?>
        </div>
        <div class="footer">
            <p>&copy; 2024 QuickComplaint. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
