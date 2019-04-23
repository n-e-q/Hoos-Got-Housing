<?php
        require "dbutil.php";
        $db = DbUtil::loginConnection();

        $stmt = $db->stmt_init();

        if($stmt->prepare("select * from renter where renter_name like ?") or die(mysqli_error($db))) {
                $searchString = '%' . $_GET['searchRenterName'] . '%';
                $stmt->bind_param(s, $searchString);
                $stmt->execute();
                $stmt->bind_result($renter_name, $phone_number, $age, $gender, $roommate_searching);
                echo "<table border=1><th>renter_name</th><th>phone_number</th><th>age</th><th>gender</th><th>roommate_searching</th>\n";
                while($stmt->fetch()) {
                        echo "<tr><td>$renter_name</td><td>$phone_number</td><td>$age</td><td>$gender</td><td>$roommate_searching</td></tr>";
                }
                echo "</table>";

                $stmt->close();
        }

        $db->close();


?>
