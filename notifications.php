<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 500px;
            max-width: 90%;
        }

        h1 {
            text-align: center;
            color: #ff007a;
            margin-bottom: 20px;
        }

        .notification {
            border-bottom: 1px solid #dee2e6;
            padding: 15px 0;
            display: flex;
            flex-direction: column;
        }

        .notification:last-child {
            border-bottom: none;
        }

        .notification-details {
            display: flex;
            flex-direction: column;
        }

        .notification-id,
        .notification-text,
        .notification-date {
            margin: 3px 0;
        }

        .notification-id {
            font-weight: 600;
            color: #343a40;
        }

        .notification-text {
            font-size: 1rem;
            color: #495057;
        }

        .notification-date {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .header {
            background-color:#ff007a;
            color: white;
            padding: 10px;
            font-size: 1.25rem;
            text-align: center;
            width: 100%;
            border-radius: 10px 10px 0 0;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            Notifications
        </div>
        <div class="notifications" id="notifications">
            <!-- Notifications will be dynamically loaded here -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        function fetchNotifications() {
            $.ajax({
                url: 'fetch_notifications.php',
                method: 'GET',
                success: function (data) {
                    $('#notifications').html(data);
                }
            });
        }

        // Fetch notifications every 5 seconds
        setInterval(fetchNotifications, 5000);

        // Initial fetch
        fetchNotifications();
    </script>
</body>

</html>
