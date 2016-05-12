<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dataviz";

/*
$servername = "mysql.1freehosting.com";
$username = "u102397316_dviz";
$password = "terdviz";
$dbname = "u102397316_dviz";
*/

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>