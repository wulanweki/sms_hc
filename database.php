<?php
$servername = "localhost";
$username = "dev";
$password = "d3v3l0pm3nt";
// $username = "root";
// $password = "";
$dbname = "db_masteremployee";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
