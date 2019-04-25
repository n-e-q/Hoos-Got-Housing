<?php
//include_once("library.php"); // To connect to the database
$SERVER = "mysql.cs.virginia.edu";
$USERNAME = "ak6eh";
$PASSWORD = "5ag";
$DATABASE = "ak6eh_project";

$con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " .
        mysqli_connect_error();
}

// Login info steps
$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$loginInfoSQL = "INSERT INTO login (username, password, name, phone) VALUES ('$_POST[username]', '$hashed_password', '$_POST[fullname]', '$_POST[phone]')";
if (!mysqli_query($con,$loginInfoSQL))
{
    die('Error: ' . mysqli_error($con));
}
echo "1 record added to login table<br>"; // Output to user


if($_POST['type'] == 'renter'){
    
    $renterInfoSQL = "INSERT INTO renter VALUES('$_POST[fullname]', '$_POST[phone]', '$_POST[age]', '$_POST[gender]', '$_POST[roommate_searching]', '$_POST[is_student]')";
    
    if (!mysqli_query($con,$renterInfoSQL))
    {
        die('Error: ' . mysqli_error($con));
    }
    echo "1 record added to renter table<br>";
}
else if($_POST['type'] == 'landlord'){
    $landlordSQL = "INSERT INTO landlord VALUES('$_POST[fullname]','$_POST[phone]')";
    if (!mysqli_query($con,$landlordSQL))
    {
        die('Error: ' . mysqli_error($con));
    }
    echo "1 record added to landlord table<br>";
    
    // Insert residency owned SQL
    if($_POST['address'] != null){
        
        $resSQL = "INSERT INTO residency VALUES('$_POST[address]','$_POST[rent]','$_POST[num_possible_residents]','$_POST[num_current_residents]','$_POST[num_room]','$_POST[num_bed]')";
        if (!mysqli_query($con,$resSQL))
        {
            die('Error: ' . mysqli_error($con));
        }
        echo "1 record added to residency<br>";
        
        $ownSQL = "INSERT INTO own VALUES('$_POST[fullname]','$_POST[address]')";
        if (!mysqli_query($con,$ownSQL))
        {
            die('Error: ' . mysqli_error($con));
        }
        echo "1 record added to owned<br>";
        
        $resTypeSQL = "INSERT INTO " . $_POST['residency_type'] . " VALUES('$_POST[address]','$_POST[building_name]')";
        if (!mysqli_query($con,$resTypeSQL))
        {
            die('Error: ' . mysqli_error($con));
        }
        echo "1 record added to " . $_POST['residency_type'] . "<br>";
    }
    
}
// Form the SQL query (an INSERT query)
//$sql="INSERT INTO login (username, password, name, phone, type) VALUES ('$_POST[username]', '$_POST[password]', '$fullName', '$_POST[phone]', '$_POST[type]')";

mysqli_close($con);
?>