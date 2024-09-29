<?php
session_start();
include("connect.php");

// Initialize a variable to hold the message
$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teacher_name = $_SESSION['firstName'];
    $announcement_text = $_POST['announcement_text'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO announcements (teacher_name, announcement_text) VALUES (?, ?)");
    $stmt->bind_param("ss", $teacher_name, $announcement_text);

    // Execute and check if successful
    if ($stmt->execute()) {
        // Success message will be set to display in an alert
        $message = "Announcement uploaded successfully."; 
    } else {
        $message = "Error: " . $stmt->error; 
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Announcement</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        textarea {
            width: 100%;
            height: 150px;
            margin-bottom: 10px;
            padding: 15px;
            border: 2px solid #4CAF50;
            border-radius: 5px;
            resize: none; /* Prevents resizing */
            font-size: 16px;
            transition: border-color 0.3s;
        }
        textarea:focus {
            border-color: #388E3C; /* Darker green when focused */
            outline: none; /* Removes the outline */
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049; /* Darker green on hover */
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4CAF50;
            text-decoration: none;
            font-size: 16px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        // Function to show alert message
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <h1>Create Announcement</h1>
    <div class="container">
        <form method="POST" action="create_announcement.php" onsubmit="showAlert('Uploading announcement...');">
            <textarea name="announcement_text" placeholder="Write your announcement here..." required></textarea>
            <button type="submit">Upload Announcement</button>
        </form>
        <a class="back-link" href="homepage.php">Back to Dashboard</a> <!-- Link back to the dashboard -->
    </div>

    <script>
        // Show alert if there's a message after form submission
        <?php if ($message) echo "showAlert('$message');"; ?>
    </script>
</body>
</html>

<?php $conn->close(); ?>
