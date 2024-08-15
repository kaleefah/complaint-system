<?php
// Start session to access session variables
session_start();

// Check if the 'username' session variable is not set (not authenticated)
if (!isset($_SESSION['username'])) {
    // Redirect to the login page or any other page where login is handled
    header("Location: admin_login.php"); // Adjust the URL as per your setup
    exit(); // Ensure that no further code is executed
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
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

        .card {
            margin-bottom: 20px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            color: #333;
            font-weight: bold;
        }

        .card-text {
            color: #555;
        }

        .card-icon {
            font-size: 50px;
            color: rgba(255, 204, 0, 0.8);
            margin-right: 20px;
        }

        .footer {
            background: linear-gradient(45deg, #ff007a, #ffcc00);
            color: white;
            text-align: center;
            padding: 20px;
            position: fixed;
            bottom: 0;
            width: calc(100% - 250px);
            margin-left: 250px;
            box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.1);
        }

        .task-list {
            list-style: none;
            padding: 0;
        }

        .task-list li {
            background: #fff;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .task-list li span {
            flex-grow: 1;
            margin-left: 10px;
        }

        .task-list li button {
            background: none;
            border: none;
            color: #ff0000;
            cursor: pointer;
        }

        .recent-complaints {
            margin-top: 20px;
        }

        .recent-complaints h5 {
            margin-bottom: 20px;
            color: #333;
            font-weight: bold;
        }

        .recent-complaints .complaint {
            background: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .recent-complaints .complaint:hover {
            transform: scale(1.02);
        }

        .complaint-icon {
            font-size: 30px;
            color: rgba(255, 204, 0, 0.8);
            margin-right: 15px;
        }

        .complaint-details {
            flex-grow: 1;
        }

        .complaint-details span {
            display: block;
            color: #555;
        }

        .complaint-id {
            font-weight: bold;
            color: #333;
        }

        .complaint-date {
            color: #999;
            font-size: 14px;
        }
        
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <a href="admin_page.php">
            </a>
        </div>
        <div>DASHBOARD</div>
        <div class="nav-icons">
            <!-- <a href="notifications.php"><i class="fas fa-bell"></i></a> -->
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
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex">
                        <div class="card-icon"><i class="fas fa-exclamation-circle"></i></div>
                        <div>
                            <h5 class="card-title">Total Complaints</h5>
                            <p class="card-text" id="total-complaints">Loading...</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex">
                        <div class="card-icon"><i class="fas fa-hourglass-half"></i></div>
                        <div>
                            <h5 class="card-title">Pending Complaints</h5>
                            <p class="card-text" id="pending-complaints">Loading...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex">
                        <div class="card-icon"><i class="fas fa-check-circle"></i></div>
                        <div>
                            <h5 class="card-title">Resolved Complaints</h5>
                            <p class="card-text" id="resolved-complaints">Loading...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tasks</h5>
                        <form id="task-form">
                            <input type="text" id="task-input" class="form-control" placeholder="Enter your task here" required>
                            <button type="submit" class="btn btn-primary mt-2">Add Task</button>
                        </form>
                        <ul id="task-list" class="task-list"></ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card recent-complaints">
                    <div class="card-body">
                        <h5 class="card-title">Recent Complaints</h5>
                        <div id="recent-complaints"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        &copy; 2024 QuickComplaints. All Rights Reserved.
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetchData('get_total_complaints.php', 'total-complaints');
            fetchData('get_pending_compliant.php', 'pending-complaints');
            fetchData('get_resolved_complaints.php', 'resolved-complaints');
            fetchRecentComplaints();
            renderTasks();
        });

        function fetchData(url, elementId) {
            fetch(url)
                .then(response => response.text())
                .then(data => {
                    document.getElementById(elementId).innerText = data;
                })
                .catch(error => {
                    document.getElementById(elementId).innerText = 'Error: ' + error.message;
                });
        }

        function fetchRecentComplaints() {
            fetch('get_recent_complaints.php')
                .then(response => response.json())
                .then(data => {
                    const complaintsContainer = document.getElementById('recent-complaints');
                    complaintsContainer.innerHTML = '';
                    data.forEach(complaint => {
                        const complaintElement = document.createElement('div');
                        complaintElement.classList.add('complaint');
                        complaintElement.innerHTML = `
                            <div class="complaint-icon"><i class="fas fa-exclamation-circle"></i></div>
                            <div class="complaint-details">
                                <span class="complaint-id">Complaint ID: ${complaint.id}</span>
                                <span>Submitted by: ${complaint.complainant_name}</span>
                            </div>
                        `;
                        complaintsContainer.appendChild(complaintElement);
                    });
                })
                .catch(error => {
                    console.error('Error fetching recent complaints:', error);
                });
        }

        function saveTasks(tasks) {
            localStorage.setItem('tasks', JSON.stringify(tasks));
        }

        function getSavedTasks() {
            const tasks = localStorage.getItem('tasks');
            return tasks ? JSON.parse(tasks) : [];
        }

        function renderTasks() {
            const taskList = document.getElementById('task-list');
            const tasks = getSavedTasks();
            taskList.innerHTML = '';
            tasks.forEach((task, index) => {
                const taskElement = document.createElement('li');
                taskElement.innerHTML = `
                    <span>${task}</span>
                    <button onclick="deleteTask(${index})"><i class="fas fa-trash"></i></button>
                `;
                taskList.appendChild(taskElement);
            });
        }

        function addTask(task) {
            const tasks = getSavedTasks();
            tasks.push(task);
            saveTasks(tasks);
            renderTasks();
        }

        function deleteTask(index) {
            const tasks = getSavedTasks();
            tasks.splice(index, 1);
            saveTasks(tasks);
            renderTasks();
        }

        document.getElementById('task-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const taskInput = document.getElementById('task-input');
            const task = taskInput.value;
            taskInput.value = '';
            addTask(task);
        });
    </script>
</body>

</html>
