<?php
//connection to my database i made in mysql
$servername = "localhost";
$username = "root";
$password = "";  
$database = "st_alphonsus_school";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>