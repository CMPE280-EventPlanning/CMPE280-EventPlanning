<?php
	header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Max-Age: 1000');
        header("content-type: application/json");
        
	$jsonobj = new stdClass();
        $jsonobj->operation = null;

  	$conn = new mysqli('eclectic.ciwss8n8nsgm.us-west-1.rds.amazonaws.com', 'cmpe280', 'cmpe280project', 'eclectic');
	// Check connection
  	if ($conn->connect_error >0) {
    	$jsonobj->operation = "Error" ;
    	die("Connection failed: " . $conn->connect_error);
  	} 
//	through the global variable $_POST, like this:
        $email = isset($_POST['email1']) ? $_POST['email1'] : 'null';
        $password = isset($_POST['password1']) ? $_POST['password1'] : 'null';
  	$sql = "SELECT email FROM registration WHERE email = '$email' and password = '$password'";
  	$result = $conn->query($sql);    
      	$count = mysqli_num_rows($result);
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count > 0) {
		 $sql = "select firstname from registration where email = '$email'";
		 $result = $conn->query($sql);
		 $row = $result->fetch_assoc();
		 $fname = $row["firstname"];
         $jsonobj->userid= $fname;
         $jsonobj->operation = 'Ok';
      }else {
         $jsonobj->userid= null;
         $jsonobj->operation = 'Error';
      }
      echo json_encode($jsonobj);
?>
