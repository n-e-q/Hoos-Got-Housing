<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
<link rel="stylesheet" href="signup2.css">
</head>

    <body>
    	<div><?php echo "Hello " . $_POST['firstname'] . " " . $_POST['lastname'] . ".";?></div>
    	<div>Please fill out the following information</div>
    	<br>
    	<div>
        	<?php 
        	if($_POST['type'] == 'renter'){
        	    echo "<form id='renterinfo' action='signupInsert.php' method='post'>";
        	    echo "<div><label>Age:</label> <input type='text' name='age'></div>";
        	    echo "<div><label>Gender:</label> <select name='gender' id='gender'>
                                                        <option value='male'>Male</option>
                                                        <option value='female'>Female</option>
                                                        <option value='other'>Other</option>
                                                  </select></div>";
        	    echo "<div><label>Are you currently searching for a roommate?:</label> <select name='roommate_searching' id='roommate_searching'>
                                                                                      		<option value='1'>Yes</option>
                                                                                      		<option value='0'>No</option>
                                                                                      	</select></div>";
        	    /* Hidden fields from previous page */
        	    echo "<input type='hidden' name='username' value='name' id='username' />";
        	    echo "<input type='hidden' name='password' value='name' id='password' />";
        	    echo "<input type='hidden' name='phone' value='name' id='phone' />";
        	    echo "<input type='hidden' name='type' value='name' id='type' />";
        	    echo "<input type='hidden' name='renter_name' value='name' id='renter_name' />";
        	    
        	    echo "</form>";
        	    echo "<input type='submit'>";
        	}
        	else if($_POST['type'] == 'landlord'){
        	    echo "<form id='propertyForm' action='signupInsert.php' method='post'>";
        	    for ($num = 1; $num <= 3; $num += 1) {
        	        echo "<div>Property #$num</div>";
        	        echo "<div class='propertyinfo'><div><label>Address:</label> <input type='text' name='address$num'></div>";
        	        echo "<div><label>Building Name:</label> <input type='text' name='building_name$num'></div>";
        	        echo "<div><label>Total Number of Possible Residents:</label> <input type='text' name='num_possible_residents'></div>";
        	        echo "<div><label>Number of Current Residents</label> <input type='text' name='num_current_residents'></div>";
        	        echo "<div><label>Number of Rooms</label> <input type='text' name='num_room'></div>";
        	        echo "<div><label>Number of Beds per Room</label> <input type='text' name='num_bed'></div>";
        	        echo "</div>";
        	    }  
        	    echo "</form>";
        	    echo "<input type='submit'>";
        	}
        	else{
        	    echo "Something went gravely wrong...";
        	}
        	?>
    	</div>
    </body>
</html>