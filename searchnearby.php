<?php

error_reporting(0);
require "dbutil.php";
$db = DbUtil::loginConnection();


$stmt = $db->stmt_init();
if($stmt->prepare("select * from nearby where location_name like ?") or die(mysqli_error($db))) {
        $searchString = '%' . $_GET['searchnearby'] . '%';
        $stmt->bind_param(s, $searchString);
        $stmt->execute();
        $stmt->bind_result($residency_address, $location_name, $location_address);
        echo "<table class='table table-striped' border=1><th>Residency Address</th><th>Location Name</th><th>Location Address</th>\n";
        while($stmt->fetch()) {
                echo "<tr><td>$residency_address</td><td>$location_name</td><td>$location_address</td></tr>";
        }
        echo "</table>";

        $stmt->close();
}

$db->close();


?>