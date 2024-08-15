<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Complaint</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(45deg, rgba(255, 0, 102, 0.8), rgba(255, 204, 0, 0.8));
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 20px;
        }
        .form-container h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .form-container p {
            margin: 15px 0;
        }
        .form-container input, .form-container textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .form-container button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background: linear-gradient(45deg, rgba(255, 0, 102, 0.8), rgba(255, 204, 0, 0.8));
            color: #fff;
            font-size: 18px;
            cursor: pointer;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background: linear-gradient(45deg, rgba(255, 0, 102, 0.8), rgba(255, 204, 0, 0.8));
            color: #fff;
            border-radius: 5px;
        }
        .logout-btn {
            margin-top: 10px;
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #dc3545;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Complaint Submission Page</h1>
        </div>

        <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        ?>

        <div class="form-container">
            <h1>We are here to assist you!</h1>
            <p>Please complete the form below for your complaints.</p>
            <form action="submit_complaint.php" method="post" enctype="multipart/form-data">
                <p>Complainant's Name:</p>
                <input type="text" name="complainant_name" id="complainant_name">
                
                <p>Department:</p>
                <input type="text" name="department" required>
                
                <p>Email:</p>
                <input type="email" name="email" id="email" required>
                
                <p>Complaint Title:</p>
                <input type="text" name="complaint_subject" required>
                
                <p>The Specific Details of the Complaint:</p>
                <textarea name="complaint_details" required></textarea>
                
                <div class="form-group">
                    <label for="complaintFile">Attach Supporting Documents (Optional)</label>
                    <input type="file" class="form-control-file" id="complaintFile" name="complaintFile">
                </div>

                <!-- Checkbox for anonymous submission -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="anonymous" name="anonymous" onchange="toggleComplainantName()">
                    <label class="form-check-label" for="anonymous">Submit Anonymously</label>
                </div>

                <button type="submit">Submit</button>
                <!-- <a href="logout.php" class="logout-btn">Logout</a> -->
            </form>
        </div>

        <div class="footer">
            <p>QuickComplaints &copy; 2024</p>
        </div>
    </div>
    <script>
        function toggleComplainantName() {
            var complainantName = document.getElementById('complainant_name');
            var email = document.getElementById('email');
            if (document.getElementById('anonymous').checked) {
                complainantName.value = 'Anonymous';
                complainantName.disabled = true;
                email.value = 'Anonymous';
                email.disabled = true;
            } else {
                complainantName.value = '';
                complainantName.disabled = false;
                email.value = '';
                email.disabled = false;
            }
        }
    </script>
</body>
</html>
