<?php
$servername = "localhost";
$username = "root";
$password = "mis12345";
$db = "e-kunci";

$conn = new mysqli($servername, $username, $password,$db);
if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	} 
$sql = "SELECT * FROM kunci limit 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$hasil->status= $row['status'];
$myJSON = json_encode($hasil);
echo $myJSON;
?>
