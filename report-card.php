<?php
session_start();
include("connect.php");

// Get the student's ID from the session
$student_id = $_SESSION['student_id'];

// Create the students table if it does not exist
$query = "CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY,
    name VARCHAR(255),
    class VARCHAR(255),
    section VARCHAR(255)
)";
mysqli_query($conn, $query);

// Query to get the student's report card data
$query = "SELECT * FROM students WHERE id = '$student_id'";
$result = mysqli_query($conn, $query);
$student_data = mysqli_fetch_assoc($result);

// Query to get the student's exam marks data
$query = "SELECT * FROM exam_marks WHERE student_id = '$student_id'";
$result = mysqli_query($conn, $query);
$exam_marks_data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $exam_marks_data[] = $row;
}

// Query to get the student's attendance data
$query = "SELECT * FROM attendance WHERE student_id = '$student_id'";
$result = mysqli_query($conn, $query);
$attendance_data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $attendance_data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .report-card {
            width: 80%;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .report-card h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-card table {
            width: 100%;
            border-collapse: collapse;
        }
        .report-card th, .report-card td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .report-card th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="icon-container" onclick="location.href='study-materials.php'">
            <i class="fas fa-book"></i>
            <h3>Study Materials</h3>
        </div>
        <div class="icon-container" onclick="location.href='report-card.php'">
            <i class="fas fa-chart-line"></i>
            <h3>Report Card</h3>
        </div>
        <div class="icon-container" onclick="location.href='homework.php'">
            <i class="fas fa-tasks"></i>
            <h3>Homework</h3>
        </div>
        <div class="icon-container" onclick="location.href='announcements.php'">
            <i class="fas fa-bullhorn"></i>
            <h3>Announcements</h3>
        </div>
    </div>
    <div class="report-card">
        <h2>Report Card</h2>
        <table>
            <tr>
                <th>Name</th>
                <td><?= $student_data['name'] ?></td>
            </tr>
            <tr>
                <th>Class</th>
                <td><?= $student_data['class'] ?></td>
            </tr>
            <tr>
                <th >Section</th>
                <td><?= $student_data['section'] ?></td>
            </tr>
        </table>
        <h3>Exam Marks</h3>
        <table>
            <tr>
                <th>Exam Name</th>
                <th>Marks</th>
            </tr>
            <?php foreach ($exam_marks_data as $exam_marks) { ?>
            <tr>
                <td><?= $exam_marks['exam_name'] ?></td>
                <td><?= $exam_marks['marks'] ?></td>
            </tr>
            <?php } ?>
        </table>
        <h3>Monthly Attendance Report</h3>
        <table>
            <tr>
                <th>Month</th>
                <th>Attendance</th>
            </tr>
            <?php foreach ($attendance_data as $attendance) { ?>
            <tr>
                <td><?= $attendance['month'] ?></td>
                <td><?= $attendance['attendance'] ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>