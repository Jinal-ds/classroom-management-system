<?php
session_start();
include("connect.php");

// Fetch user's first name from the session
$firstName = isset($_SESSION['firstName']) ? $_SESSION['firstName'] : 'User'; // Default to 'User' if not set

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the meeting details from the form
    $meetingTitle = $_POST['meeting_title'];
    $meetingDate = $_POST['meeting_date'];
    $meetingTime = $_POST['meeting_time'];
    $meetingDescription = $_POST['meeting_description'];

    // Save the meeting details to the database
    $sql = "INSERT INTO meetings (title, date, time, description, created_by) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $meetingTitle, $meetingDate, $meetingTime, $meetingDescription, $firstName);

    if ($stmt->execute()) {
        $successMessage = "Meeting created successfully!";
    } else {
        $errorMessage = "Error creating meeting: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Meeting</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #e9ecef, #ffffff);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 80px; /* Space for fixed header */
        }
        .header {
            color: white;
            padding: 20px;
            width: 100%;
            text-align: center;
            position: fixed;
            top: 0;
            z-index: 1000;
            background-color: #4CAF50; /* Header color */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 400px;
            margin: 20px;
            transition: transform 0.3s;
        }
        .container:hover {
            transform: translateY(-5px);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s;
        }
        .form-group input:focus, .form-group textarea:focus {
            border-color: #4CAF50;
            outline: none;
        }
        .form-group button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }
        .form-group button:hover {
            background-color: #388E3C; /* Darker green on hover */
            transform: translateY(-2px);
        }
        .message {
            margin-top: 10px;
            color: green;
            font-weight: bold;
        }
        .error-message {
            margin-top: 10px;
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Create Meeting</h1>
    </div>
    <div class="container">
        <?php if (isset($successMessage)) { ?>
            <div class="message"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php } ?>
        <?php if (isset($errorMessage)) { ?>
            <div class="error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php } ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="meeting_title">Meeting Title</label>
                <input type="text" id="meeting_title" name="meeting_title" required placeholder="Enter meeting title">
            </div>
            <div class="form-group">
                <label for="meeting_date">Meeting Date</label>
                <input type="date" id="meeting_date" name="meeting_date" required>
            </div>
            <div class="form-group">
                <label for="meeting_time">Meeting Time</label>
                <input type="time" id="meeting_time" name="meeting_time" required>
            </div>
            <div class="form-group">
                <label for="meeting_description">Meeting Description</label>
                <textarea id="meeting_description" name="meeting_description" rows="4" placeholder="Enter a brief description"></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Create Meeting</button>
            </div>
        </form>
    </div>
</body>
</html>
