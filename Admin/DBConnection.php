<?php
$servername = "localhost";
$username = "root";
$password = "";
$db="new_solar_tech_solution";

$conn = new mysqli($servername, $username, $password,$db);

if ($conn->connect_error) {
  die("OPPS! No connection: " . $conn->connect_error);  
}
//echo "Connected successfully";
?>
