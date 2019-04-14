<?php
   include_once("./library.php"); 
   $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);

   if (mysqli_connect_errno())
     {
     echo "Failed to connect to MySQL: " .
mysqli_connect_error();
     }
     $sql="INSERT INTO own (landlord_name, residency_address) 
     VALUES 
     ('$_POST[landlord_name]','$_POST[residency_address]')";
      $sql="INSERT INTO landlord (landlord_name, phone)
     ('$_POST[landlord_name]','$_POST[phone]')";
     if (!mysqli_query($con,$sql))
        {
	die('Error: ' . mysqli_error($con));
	} echo "1 record added";
	mysqli_close($con);
?>