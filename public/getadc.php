<?php
//Creates new record as per request
 
    // Create connection
   $conn = mysqli_connect("localhost", "root", "mis12345" ,"alcohol");
    mysqli_query($conn, "SET NAMES 'utf8'");

    // Check connection
    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }
    
    date_default_timezone_set('Asia/Jakarta');
    //$idwaktu = date("Y-m-d h:i")

    //if(!empty($_GET['ADCMQ3']) && !empty($_GET['ADCMQ135']) && !empty($_GET['hum']) && !empty($_GET['temp']))
    //{
    	//$mq3 = $_GET['ADCMQ3'];
        //$mq135 = $_GET['ADCMQ135'];
        //$humadity = $_GET['hum'];
        //$temperature = $_GET['temp'];
        $mq3=1;
	$mq135=2;
	$humadity=1;
	$temperature=100;
        
	    $sql = "INSERT INTO log (mq3, mq135, humadity, temperature)
		
		VALUES ('".$mq3."', '".$mq135."', '".$humadity."', '".$temperature."')";
 
		if ($conn->query($sql) === TRUE) {
		    echo "OK";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
//	}
 
 
	$conn->close();
?>
