<?php
$servername = "localhost";
$username = "root";
$password = "mis12345";
$db = "e-kunci";

$conn = new mysqli($servername, $username, $password,$db);
if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	} 
$sql = "update kunci set status=0 where kunci=1";
$result = mysqli_query($conn, $sql);
if (mysqli_query($conn, $sql)) {
      echo "Record updated successfully";
   } else {
      echo "Error updating record: " . mysqli_error($conn);
   }
?>
