<?php

$host="localhost";
$user="root";
$pass="";
$db="login";
// connect.php
$conn = mysqli_connect("localhost", "root", "", "login");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>