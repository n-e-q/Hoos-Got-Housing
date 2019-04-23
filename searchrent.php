<?php
        error_reporting(0);
        require "dbutil.php";
        $db = DbUtil::loginConnection();

        $stmt = $db->stmt_init();

        if($stmt->prepare("select * from residency where rent < ?") or die(mysqli_error($db))) {
                $searchString = $_GET['searchrent'];
                $stmt->bind_param(s, $searchString);
                $stmt->execute();
                $stmt->bind_result($residency_address, $rent, $num_possible_residents, $num_current_residents, $num_room, $num_bed);
                echo "<table class='table table-striped' border=1><th>Residency Address</th><th>Rent</th><th>Number of Possible Residents</th>
                <th>Number of Current Residents</th><th>Number of Rooms</th><th>Number of Beds</th>\n";
                while($stmt->fetch()) {
                        echo "<tr><td>$residency_address</td><td>$rent</td><td>$num_possible_residents</td>
                        <td>$num_current_residents</td><td>$num_room</td><td>$num_bed</td></tr>";
                }
                echo "</table>";

                $stmt->close();
        }

        $db->close();


?>
