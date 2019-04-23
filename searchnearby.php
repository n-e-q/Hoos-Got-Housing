<?php

error_reporting(0);
require "dbutil.php";
$db = DbUtil::loginConnection();


$stmt = $db->stmt_init();
if($stmt->prepare("select residency_address, location_name, location_address, landlord_name, phone
        from nearby natural join own natural join landlord where location_name like ?") or die(mysqli_error($db))) {
        $searchString = '%' . $_GET['searchnearby'] . '%';
        $stmt->bind_param(s, $searchString);
        $stmt->execute();
        $stmt->bind_result($residency_address, $location_name, $location_address, $landlord_name, $phone);
        echo "<table class='table table-striped' border=1><th>Residency Address</th><th>Location Name</th><th>Location Address</th><th>Landlord Name</th><th>Location Contact</th>\n";
        while($stmt->fetch()) {
                echo "<tr><td>$residency_address</td><td>$location_name</td><td>$location_address</td><td>$landlord_name</td><td>$phone</td></tr>";
        }
        echo "</table>";

        $stmt->close();
}

$db->close();


?>