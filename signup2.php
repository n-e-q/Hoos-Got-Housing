<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
<link rel="stylesheet" href="signup2.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

    <body>
    	<div><?php echo "Hello " . $_POST['firstname'] . " " . $_POST['lastname'] . ".";?></div>
    	<div>Please fill out the following information</div>
    	<br>
    	<div>
        	<?php 
        	
        	$fullName = $_POST['firstname'] . " " . $_POST['lastname'];
        	
        	if($_POST['type'] == 'renter'){
        	    echo "<form id='renterinfo' action='signupInsert.php' method='post'>";
        	    echo "<div><label>Age:</label> <input type='text' name='age'></div>";
        	    echo "<div><label>Gender:</label> <select name='gender' id='gender'>
                                                        <option value='male'>Male</option>
                                                        <option value='female'>Female</option>
                                                        <option value='other'>Other</option>
                                                  </select></div>";
        	    echo "<div><label>Are you a student?</label> <select name='is_student' id='is_student'>
                                                        <option value='1'>Yes</option>
                                                        <option value='0'>No</option>
                                                  </select></div>";
        	    echo "<div><label>Are you currently searching for a roommate?</label> <select name='roommate_searching' id='roommate_searching'>
                                                                                      		<option value='1'>Yes</option>
                                                                                      		<option value='0'>No</option>
                                                                                      	</select></div>";
        	    /* Hidden fields from previous page */
        	    echo "<input type='hidden' name='username' value='$_POST[username]' id='username' />";
        	    echo "<input type='hidden' name='password' value='$_POST[password]' id='password' />";
        	    echo "<input type='hidden' name='phone' value='$_POST[phone]' id='phone' />";
        	    echo "<input type='hidden' name='type' value='renter' id='type' />";
        	    echo "<input type='hidden' name='fullname' value='$fullName' id='fullname' />";
        	    echo "<input type='submit' class='btn btn-primary'>";
        	    echo "</form>";
        	    
        	}
        	else if($_POST['type'] == 'landlord'){
        	    echo "Please add the information of one of your properties (others can be added later in your profile).<br>";
        	    echo "<form id='propertyForm' action='signupInsert.php' method='post'>";
        	    

        	        echo "<div class='propertyinfo'><div><label>Address:</label> <input type='text' name='address'></div>";
        	        echo "<div><label>Building Name:</label> <input type='text' name='building_name'></div>";
        	        
        	        echo "<div><label>Residency Type:</label> <select name='residency_type' id='residency_type'>
                                                        <option value='off_grounds_house'>Offgrounds - House</option>
                                                        <option value='off_grounds_apt'>Offgrounds - Apartment</option>
                                                        <option value='on_grounds'>Ongrounds</option>
                                                  </select></div>";
        	        echo "<div><label>Rent</label> <input type='text' name='rent'></div>";
        	        echo "<div><label>Total Number of Possible Residents:</label> <input type='text' name='num_possible_residents'></div>";
        	        echo "<div><label>Number of Current Residents</label> <input type='text' name='num_current_residents'></div>";
        	        echo "<div><label>Number of Rooms</label> <input type='text' name='num_room'></div>";
        	        echo "<div><label>Number of Beds per Room</label> <input type='text' name='num_bed'></div>";
        	        echo "</div>";
        	    
        	    
        	    echo "<input type='hidden' name='username' value='$_POST[username]' id='username' />";
        	    echo "<input type='hidden' name='password' value='$_POST[password]' id='password' />";
        	    echo "<input type='hidden' name='phone' value='$_POST[phone]' id='phone' />";
        	    echo "<input type='hidden' name='type' value='landlord' id='type' />";
        	    echo "<input type='hidden' name='fullname' value='$fullName' id='fullname' />";
        	    
        	    echo "<input type='submit' class='btn btn-primary'>";
        	    echo "</form>";
        	}
        	else{
        	    echo "Something went gravely wrong...";
        	}
        	?>
    	</div>
    </body>
</html>