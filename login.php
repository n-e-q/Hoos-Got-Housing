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
 $sql="SELECT * FROM Persons WHERE username ==(username) and password ==(password) 
 VALUES
 ('$_POST[username]','$_POST[password]')";

 $r = mysqli_query($con,$sql);
 if($r){  // if there is a valid result
    if ($r['type']=="renter"){  //if it is a renter 
        echo $r['name'] " , you have logined as a renter";
    }
    else{ // if it is a owner
        echo $r['name'] " , you have logined as a owner";
    }
 }
 else{ // if any input is incorrect or if it is not in the system
    echo "Wrong username or password, or the account does not exist."  
 }
    
 mysqli_close($con);
?>
