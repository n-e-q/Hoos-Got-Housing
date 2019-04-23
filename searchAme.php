<?php
        error_reporting(0);
        require "dbutil.php";
        $db = DbUtil::loginConnection();

        $stmt = $db->stmt_init();

        if($stmt->prepare("select * from residency_amenity_type where amenity_type like ?") or die(mysqli_error($db))) {
                $searchString = '%' . $_GET['searchAme'] . '%';
                $stmt->bind_param(s, $searchString);
                $stmt->execute();
                $stmt->bind_result($residency_address, $amenity_type);
                echo "<table border=1><th>residency_address</th><th>amenity_type</th>\n";
                while($stmt->fetch()) {
                        echo "<tr><td>$residency_address</td><td>$amenity_type</td></tr>";
                }
                echo "</table>";

                $stmt->close();
        }

        $db->close();


?>
