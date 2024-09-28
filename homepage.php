<?php
session_start();
include("connect.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .dashboard {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .icon-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin: 20px;
            padding: 20px;
            text-align: center;
            width: 150px;
            transition: transform 0.3s;
            cursor: pointer;
        }
        .icon-container:hover {
            transform: scale(1.1);
        }
        .icon-container i {
            font-size: 48px;
            color: #4CAF50;
        }
        .icon-container h3 {
            margin-top: 10px;
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
</body>
</html>
