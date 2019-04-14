<?php
 include_once("./library.php"); // To connect to the database
 $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
 // Check connection
 if (mysqli_connect_errno())
 {
 echo "Failed to connect to MySQL: " .
mysqli_connect_error();
 }
 // Form the SQL query (an INSERT query)
 $sql="SELECT * FROM login WHERE username ='$_POST[username]' and password ='$_POST[password]'";

 $result = mysqli_query($con,$sql);
 $r = mysqli_fetch_array($result);
 if ($r){
	 echo $r['name'];
	 echo ", you have logined as a ";
	 echo $r['type'];
 }
 else{
	 echo "Wrong username or password, or the account does not exist.";
 }   
 mysqli_close($con);
?>