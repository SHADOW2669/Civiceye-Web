<?php

$host = "localhost:3306";
$user = "root";
$password = "";
$database = "civic_eye_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn-> connection_error) {
    die("Connection failed: ". $conn->connect_error);
}

?>