<?php
session_start();
include 'db.php'; // Ensure this line correctly includes the db.php file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ? AND role = 'admin'");
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $hashed_password, $role);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $role;
                    header('Location: admin_page.php');
                    exit();
                } else {
                    $_SESSION['error'] = 'Invalid password.';
                    header('Location: admin_login.php');
                    exit();
                }
            } else {
                $_SESSION['error'] = 'No admin found with that username.';
                header('Location: admin_login.php');
                exit();
            }

            $stmt->close();
        } else {
            die('Prepare failed: ' . $conn->error);
        }
    } else {
        $_SESSION['error'] = 'Please enter both username and password.';
        header('Location: admin_login.php');
        exit();
    }
}

$conn->close();
?>
