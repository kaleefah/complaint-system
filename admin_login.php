<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the username and password (e.g., check against the database)
    if (validate_user($username, $password)) {
        // Set session variable
        $_SESSION['username'] = $username;
        // Redirect to the admin page
        header("Location: admin_page.php");
        exit();
    } else {
        // Invalid login
        $error = "Invalid username or password";
    }
}

function validate_user($username, $password) {
    // Implement your user validation logic here (e.g., database query)
    // Return true if valid, false otherwise
    return true; // This is just a placeholder
}
?>

 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, width=device-width">
    <title>Admin-Login</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f0f0;
            background: linear-gradient(45deg, rgba(255, 0, 102, 0.8), rgba(255, 204, 0, 0.8));
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
            max-width: 400px;
            width: 100%;
        }
        h2 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input[type="text"], input[type="password"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: calc(100% - 24px);
        }
        button {
            background: linear-gradient(45deg, rgba(255, 0, 102, 0.8), rgba(255, 204, 0, 0.8));           
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hey, 
        Welcome Back!</h2>
        <form action="admin_login_process.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
