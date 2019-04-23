<?php
        error_reporting(0);
        require "dbutil.php";
        $db = DbUtil::loginConnection();

        $stmt = $db->stmt_init();

        if($stmt->prepare("select residency_address, amenity_type, landlord_name, phone from residency_amenity_type 
        natural join own natural join landlord where amenity_type like ?") or die(mysqli_error($db))) {
                $searchString = '%' . $_GET['searchAme'] . '%';
                $stmt->bind_param(s, $searchString);
                $stmt->execute();
                $stmt->bind_result($residency_address, $amenity_type, $landlord_name, $phone);
                echo "<table class='table table-striped' border=1><th>Residency Address</th><th>Amenity Type</th><th>Landlord Name</th><th>Landlord Contact</th>\n";
                while($stmt->fetch()) {
                        echo "<tr><td>$residency_address</td><td>$amenity_type</td><td>$landlord_name</td><td>$phone</td></tr>";
                }
                echo "</table>";

                $stmt->close();
        }

        $db->close();


?>
