<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Complaint Status</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
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
            max-width: 600px;
            margin: 0 auto;
            padding: 100px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            background: linear-gradient(45deg, rgba(255, 0, 102, 0.8), rgba(255, 204, 0, 0.8)) center top no-repeat;
            color: white;
            text-align: center;
            padding: 20px;
            position: fixed;
            bottom: 0;
            width: calc(100% - 250px);
            margin-left: 250px;
            box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.1);
        }

        .alert {
            margin-top: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: rgba(255, 204, 0, 0.8);
            border: none;
        }

        .btn-primary:hover {
            background-color: rgba(255, 0, 102, 0.8);
        }
    </style>
</head>

<body>
    <?php
    session_start();
    ?>
    <div class="header">
        <div class="logo">
            <a href="admin_page.php">
            </a>
        </div>
        <div>Update Complaint Status</div>
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
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                unset($_SESSION['success']);
            }
            ?>
            <form action="update_status.php" method="post">
                <div class="form-group">
                    <label for="complaint_id">Complaint ID:</label>
                    <input type="number" class="form-control" name="complaint_id" id="complaint_id" required>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="form-control" name="status" id="status" required>
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>
    </div>
    <div class="footer">
        <p>QuickComplaints &copy; 2024</p>
    </div>
</body>

</html>
