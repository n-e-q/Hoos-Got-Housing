<?php
	require "dbutil.php";
	$db = DbUtil::loginConnection();
	
	$stmt = $db->stmt_init();
	
	if($stmt->prepare("select * from Renter where roommate_searching like ?") or die(mysqli_error($db))) {
		$searchString = '%' . $_GET['searchRoommateNumber'] . '%';
		$stmt->bind_param(s, $searchString);
		$stmt->execute();
		$stmt->bind_result($renter_name, $phone, $age, $gender, $roommate_searching);
		echo "<table border=1><th>renter_name</th><th>phone</th><th>age</th><th>gender<th>roommate_searching</th>\n";
		while($stmt->fetch()) {
			echo "<tr><td>$renter_name</td><td>$phone</td><td>$age</td><td>$gender</td><td>$roommate_searching</tr>";
		}
		echo "</table>";
	
		$stmt->close();
	}
	
	$db->close();


?>