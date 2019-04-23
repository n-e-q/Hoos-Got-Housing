<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="./js/jquery-1.6.2.min.js" type="text/javascript"></script>
  <script src="./js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
  <script src="./js/roommate_search.js" type="text/javascript"></script>
  <script src='js/TableToJson.min.js'></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <title>Search Roommate</title>
</head>


<body>
  <div class="container">
  <h1> Roomate Search </h1>

  <p id="instruction" style=<?php if(isset($_POST['gender']) || isset($_POST['occupation']) || isset($_POST['tidy']) || isset($_POST['sleep']) || isset($_POST['getup'])) echo 'visibility:hidden'; else echo 'visibility:visible'; ?>>Currently presents a list of all the renters in the database that are searching for roommates. Select the options you wish to filter your roommate by, then click search to narrow it down!</p>

  <form method="post">
    <h4>Search by: </h4>
    <input type="checkbox" id="check_gender" onclick="genderCheck()" <?php if(isset($_POST['gender'])) echo "checked='checked'"; ?>> <label for="check_gender">Gender</label>&ensp;&ensp;   
    <div id="is_gender" style=<?php if(isset($_POST['gender'])) echo 'display:inline'; else echo 'display:none'; ?>>
      <input type="radio" name="gender" value="male" <?php if(isset($_POST['gender']) && $_POST['gender']=="male") echo "checked='checked'"; ?>>
      Male &nbsp
      <input type="radio" name="gender" value="female" <?php if(isset($_POST['gender']) && $_POST['gender']=="female") echo "checked='checked'"; ?>> Female &nbsp
      <input type="radio" name="gender" value="other" <?php if(isset($_POST['gender']) && $_POST['gender']=="other") echo "checked='checked'"; ?>> Other
    </div> <br>

    <input type="checkbox" id="check_occupation" onclick="occupationCheck()" <?php if(isset($_POST['occupation'])) echo "checked='checked'"; ?>> <label
      for="check_occupation">Occupation</label>&ensp; &ensp;
    <div id="is_occupation" style=<?php if(isset($_POST['occupation'])) echo 'display:inline'; else echo 'display:none'; ?>>
      <input type="radio" name="occupation" value="student" <?php if(isset($_POST['occupation']) && $_POST['occupation']=="student") echo "checked='checked'"; ?>> Student &nbsp
      <input type="radio" name="occupation" value="non_student" <?php if(isset($_POST['occupation']) && $_POST['occupation']=="non_student") echo "checked='checked'"; ?>> Non-student
    </div> <br>

    <input type="checkbox" id="check_tidy" onclick="tidinessCheck()" <?php if(isset($_POST['tidy'])) echo "checked='checked'"; ?>> <label for="check_tidy"> Level
      of tidiness</label>&ensp;&ensp;
    <div id="is_tidy" style=<?php if(isset($_POST['tidy'])) echo 'display:inline'; else echo 'display:none'; ?>>
      <input type="radio" name="tidy" value="messy" <?php if(isset($_POST['tidy']) && $_POST['tidy']=="messy") echo "checked='checked'"; ?>> Messy &nbsp
      <input type="radio" name="tidy" value="clean" <?php if(isset($_POST['tidy']) && $_POST['tidy']=="clean") echo "checked='checked'"; ?>> Clean
    </div> <br>

    <input type="checkbox" id="check_sleep" onclick="sleepCheck()" <?php if(isset($_POST['sleep']) || isset($_POST['getup'])) echo "checked='checked'"; ?>> <label for="check_sleep"> Sleep
      Schedule</label>&ensp;&ensp;
    <div id="is_sleep" style=<?php if(isset($_POST['sleep']) || isset($_POST['getup'])) echo 'display:inline'; else echo 'display:none'; ?>>
      <input type="radio" name="sleep" value="sleep early" <?php if(isset($_POST['sleep']) && $_POST['sleep']=="sleep early") echo "checked='checked'"; ?>> Sleep Early &nbsp
      <input type="radio" name="sleep" value="sleep late" <?php if(isset($_POST['sleep']) && $_POST['sleep']=="sleep late") echo "checked='checked'"; ?>> Sleep Late &nbsp; | &nbsp;
      <input type="radio" name="getup" value="wake up early" <?php if(isset($_POST['getup']) && $_POST['getup']=="wake up early") echo "checked='checked'"; ?>> Get Up Early &nbsp
      <input type="radio" name="getup" value="wake up late" <?php if(isset($_POST['getup']) && $_POST['getup']=="wake up late") echo "checked='checked'"; ?>> Get Up Late
    </div> <br>
    <br>
    <input type="submit" id="submission" value="Search" class="btn btn-primary">

    <br>
    <br>

  </form>

  <!-- <div id="search_result"> Search Result HHHHHERE</div> -->

  <?php
    error_reporting(0);
    require "dbutil.php";
    $db = DbUtil::loginConnection();

    $stmt = $db->stmt_init();

    $gender = "";
    $occupation = "";
    $tidy = "";
    $sleep = "";
    $getup = "";

    if (isset($_POST['gender'])) $gender = $_POST['gender'];
    if (isset($_POST['occupation'])) $occupation = $_POST['occupation'];
    if (isset($_POST['tidy'])) $tidy = $_POST['tidy'];
    if (isset($_POST['sleep'])) $sleep = $_POST['sleep'];
    if (isset($_POST['getup'])) $getup = $_POST['getup'];

    if (empty($gender) && empty($occupation) && empty($tidy) && empty($sleep) && empty($getup)){
      // echo "hi in if statement";
      if($stmt->prepare("SELECT renter_name, phone
      FROM  `renter`
      WHERE roommate_searching = 1") or die(mysqli_error($db))) {
        $stmt->execute();
        $stmt->bind_result($renter_name, $phone);
        echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th></tr>
          </thead><tbody>';
        while($stmt->fetch()) {
          echo "<tr><td>$renter_name</td><td>$phone</td></tr>";
        }
        echo "</tbody></table>";
        $stmt->close();
      }
    }

    if (!empty($gender) && empty($occupation) && empty($tidy) && empty($sleep) && empty($getup)){
      if($stmt->prepare("SELECT renter_name, phone FROM  `renter` WHERE roommate_searching = 1 AND  gender=?") or die(mysqli_error($db))) {
        $stmt->bind_param('s', $gender);
        $stmt->execute();
        $stmt->bind_result($renter_name, $phone);
        echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th></tr>
        </thead><tbody>';
        while($stmt->fetch()) {
          echo "<tr><td>$renter_name</td><td>$phone</td></tr>";
        }
        echo "</tbody></table>";
        $stmt->close();
      }
    }

    if (empty($gender) && !empty($occupation) && empty($tidy) && empty($sleep) && empty($getup)){
      if ($occupation == "student"){
        if($stmt->prepare("SELECT renter_name, phone, major, year 
        FROM `student` NATURAL JOIN `renter`
        WHERE roommate_searching = 1") or die(mysqli_error($db))) {
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $major, $year);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Major</th><th>Class Of</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$major</td><td>$year</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
      if($occupation == "non_student"){
        if($stmt->prepare("SELECT renter_name, phone, job 
        FROM `non_student` NATURAL JOIN `renter`
        WHERE roommate_searching = 1") or die(mysqli_error($db))) {
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $job);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Job</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$job</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
    }

    if (empty($gender) && empty($occupation) && !empty($tidy) && empty($sleep) && empty($getup)){
      if($stmt->prepare("SELECT renter_name, phone 
      FROM  `lifestyle` NATURAL JOIN `renter`
      WHERE roommate_searching = 1 AND lifestyle = ?") or die(mysqli_error($db))) {
        $stmt->bind_param('s', $tidy);
        $stmt->execute();
        $stmt->bind_result($renter_name, $phone);
        echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th></tr>
          </thead><tbody>';
        while($stmt->fetch()) {
          echo "<tr><td>$renter_name</td><td>$phone</td></tr>";
        }
        echo "</tbody></table>";
        $stmt->close();
      }
    }
    if (empty($gender) && empty($occupation) && empty($tidy) && !empty($sleep) && empty($getup)){
      if($stmt->prepare("SELECT renter_name, phone 
      FROM  `lifestyle` NATURAL JOIN `renter`
      WHERE roommate_searching = 1 AND lifestyle = ?") or die(mysqli_error($db))) {
        $stmt->bind_param('s', $sleep);
        $stmt->execute();
        $stmt->bind_result($renter_name, $phone);
        echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th></tr>
          </thead><tbody>';
        while($stmt->fetch()) {
          echo "<tr><td>$renter_name</td><td>$phone</td></tr>";
        }
        echo "</tbody></table>";
        $stmt->close();
      }
    }

    if (empty($gender) && empty($occupation) && empty($tidy) && empty($sleep) && !empty($getup)){
      if($stmt->prepare("SELECT renter_name, phone 
      FROM  `lifestyle` NATURAL JOIN `renter`
      WHERE roommate_searching = 1 AND lifestyle = ?") or die(mysqli_error($db))) {
        $stmt->bind_param('s', $getup);
        $stmt->execute();
        $stmt->bind_result($renter_name, $phone);
        echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th></tr>
          </thead><tbody>';
        while($stmt->fetch()) {
          echo "<tr><td>$renter_name</td><td>$phone</td></tr>";
        }
        echo "</tbody></table>";
        $stmt->close();
      }
    }
    
    //GO
    if (!empty($gender) && !empty($occupation) && empty($tidy) && empty($sleep) && empty($getup)){
      if ($occupation == "student"){
        if($stmt->prepare("SELECT renter_name, phone, major, year
        FROM `student` NATURAL JOIN `renter`
        WHERE roommate_searching = 1 AND gender =?") or die(mysqli_error($db))) {
          $stmt->bind_param('s', $gender);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $major, $year);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Major</th><th>Class Of</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$major</td><td>$year</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
      if($occupation == "non_student"){
        if($stmt->prepare("SELECT renter_name, phone, job
        FROM `non_student` NATURAL JOIN `renter`
        WHERE roommate_searching = 1 AND gender =?") or die(mysqli_error($db))) {
          $stmt->bind_param('s', $gender);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $job);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Job</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$job</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
    }

    //GOT
    if (!empty($gender) && !empty($occupation) && !empty($tidy) && empty($sleep) && empty($getup)){
      if ($occupation == "student"){
        if($stmt->prepare("SELECT renter_name, phone, major, year
        FROM `student` NATURAL JOIN `renter` NATURAL JOIN `lifestyle`
        WHERE roommate_searching = 1 AND gender =? AND lifestyle =?") or die(mysqli_error($db))) {
          $stmt->bind_param('ss', $gender, $tidy);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $major, $year);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Major</th><th>Class Of</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$major</td><td>$year</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
      if($occupation == "non_student"){
        if($stmt->prepare("SELECT renter_name, phone, job
        FROM `non_student` NATURAL JOIN `renter` NATURAL JOIN `lifestyle`
        WHERE roommate_searching = 1 AND gender =? AND lifestyle =?") or die(mysqli_error($db))) {
          $stmt->bind_param('ss', $gender, $tidy);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $job);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Job</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$job</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
    }

    //GOTS
    if (!empty($gender) && !empty($occupation) && !empty($tidy) && !empty($sleep) && empty($getup)){
      if ($occupation == "student"){
        if($stmt->prepare("SELECT renter_name, phone, major, year
        FROM (SELECT * FROM `lifestyle` NATURAL JOIN `student` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND gender = ? AND lifestyle = ?) AS T1
        NATURAL JOIN (
        SELECT renter_name, phone, major, year FROM `lifestyle` NATURAL JOIN `student` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2") or die(mysqli_error($db))) {
          $stmt->bind_param('sss', $gender, $tidy, $sleep);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $major, $year);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Major</th><th>Class Of</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$major</td><td>$year</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
      if($occupation == "non_student"){
        if($stmt->prepare("SELECT renter_name, phone, job
        FROM (SELECT * FROM `lifestyle` NATURAL JOIN `non_student` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND gender = ? AND lifestyle = ?) AS T1
        NATURAL JOIN (
        SELECT renter_name, phone, job FROM `lifestyle` NATURAL JOIN `non_student` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2") or die(mysqli_error($db))) {
          $stmt->bind_param('sss', $gender, $tidy, $sleep);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $job);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Job</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$job</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
    }

    //GOTSGu
    if (!empty($gender) && !empty($occupation) && !empty($tidy) && !empty($sleep) && !empty($getup)){
      if ($occupation == "student"){
        if($stmt->prepare("SELECT renter_name, phone, major, year
        FROM (SELECT * FROM `lifestyle` NATURAL JOIN `student` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND gender = ? AND lifestyle = ?) AS T1
        NATURAL JOIN (
        SELECT renter_name, phone, major, year FROM `lifestyle` NATURAL JOIN `student` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2 NATURAL JOIN (
        SELECT renter_name, phone, major, year FROM `lifestyle` NATURAL JOIN `student` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T3") or die(mysqli_error($db))) {
          $stmt->bind_param('ssss', $gender, $tidy, $sleep, $getup);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $major, $year);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Major</th><th>Class Of</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$major</td><td>$year</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
      if($occupation == "non_student"){
        if($stmt->prepare("SELECT renter_name, phone, job
        FROM (SELECT * FROM `lifestyle` NATURAL JOIN `non_student` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND gender = ? AND lifestyle = ?) AS T1
        NATURAL JOIN (
        SELECT renter_name, phone, job FROM `lifestyle` NATURAL JOIN `non_student` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2 
        NATURAL JOIN (
        SELECT renter_name, phone, job FROM `lifestyle` NATURAL JOIN `non_student` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T3") or die(mysqli_error($db))) {
          $stmt->bind_param('ssss', $gender, $tidy, $sleep, $getup);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $job);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Job</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$job</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
    }

    //GOTGu
    if (!empty($gender) && !empty($occupation) && !empty($tidy) && empty($sleep) && !empty($getup)){
      if ($occupation == "student"){
        if($stmt->prepare("SELECT renter_name, phone, major, year
        FROM (SELECT * FROM `lifestyle` NATURAL JOIN `student` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND gender = ? AND lifestyle = ?) AS T1
        NATURAL JOIN (
        SELECT renter_name, phone, major, year FROM `lifestyle` NATURAL JOIN `student` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2") or die(mysqli_error($db))) {
          $stmt->bind_param('sss', $gender, $tidy, $getup);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $major, $year);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Major</th><th>Class Of</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$major</td><td>$year</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
      if($occupation == "non_student"){
        if($stmt->prepare("SELECT renter_name, phone, job
        FROM (SELECT * FROM `lifestyle` NATURAL JOIN `non_student` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND gender = ? AND lifestyle = ?) AS T1
        NATURAL JOIN (
        SELECT renter_name, phone, job FROM `lifestyle` NATURAL JOIN `non_student` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2") or die(mysqli_error($db))) {
          $stmt->bind_param('sss', $gender, $tidy, $getup);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $job);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Job</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$job</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
    }

    //GOS
    if (!empty($gender) && !empty($occupation) && empty($tidy) && !empty($sleep) && empty($getup)){
      if ($occupation == "student"){
        if($stmt->prepare("SELECT renter_name, phone, major, year
        FROM `student` NATURAL JOIN `renter` NATURAL JOIN `lifestyle`
        WHERE roommate_searching = 1 AND gender =? AND lifestyle =?") or die(mysqli_error($db))) {
          $stmt->bind_param('ss', $gender, $sleep);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $major, $year);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Major</th><th>Class Of</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$major</td><td>$year</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
      if($occupation == "non_student"){
        if($stmt->prepare("SELECT renter_name, phone, job
        FROM `non_student` NATURAL JOIN `renter` NATURAL JOIN `lifestyle`
        WHERE roommate_searching = 1 AND gender =? AND lifestyle =?") or die(mysqli_error($db))) {
          $stmt->bind_param('ss', $gender, $sleep);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $job);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Job</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$job</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
    }

    //GOGu
    if (!empty($gender) && !empty($occupation) && empty($tidy) && empty($sleep) && !empty($getup)){
      if ($occupation == "student"){
        if($stmt->prepare("SELECT renter_name, phone, major, year
        FROM `student` NATURAL JOIN `renter` NATURAL JOIN `lifestyle`
        WHERE roommate_searching = 1 AND gender =? AND lifestyle =?") or die(mysqli_error($db))) {
          $stmt->bind_param('ss', $gender, $getup);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $major, $year);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Major</th><th>Class Of</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$major</td><td>$year</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
      if($occupation == "non_student"){
        if($stmt->prepare("SELECT renter_name, phone, job
        FROM `non_student` NATURAL JOIN `renter` NATURAL JOIN `lifestyle`
        WHERE roommate_searching = 1 AND gender =? AND lifestyle =?") or die(mysqli_error($db))) {
          $stmt->bind_param('ss', $gender, $getup);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $job);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Job</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$job</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
    }

    //GT
    if (!empty($gender) && empty($occupation) && !empty($tidy) && empty($sleep) && empty($getup)){
      if($stmt->prepare("SELECT renter_name, phone
      FROM `renter` NATURAL JOIN `lifestyle`
      WHERE roommate_searching = 1 AND gender =? AND lifestyle =?") or die(mysqli_error($db))) {
        $stmt->bind_param('ss', $gender, $tidy);
        $stmt->execute();
        $stmt->bind_result($renter_name, $phone);
        echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th></tr>
        </thead><tbody>';
        while($stmt->fetch()) {
          echo "<tr><td>$renter_name</td><td>$phone</td></tr>";
        }
        echo "</tbody></table>";
        $stmt->close();
      }
    }

    //GS
    if (!empty($gender) && empty($occupation) && empty($tidy) && !empty($sleep) && empty($getup)){
      if($stmt->prepare("SELECT renter_name, phone
      FROM `renter` NATURAL JOIN `lifestyle`
      WHERE roommate_searching = 1 AND gender =? AND lifestyle =?") or die(mysqli_error($db))) {
        $stmt->bind_param('ss', $gender, $sleep);
        $stmt->execute();
        $stmt->bind_result($renter_name, $phone);
        echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th></tr>
        </thead><tbody>';
        while($stmt->fetch()) {
          echo "<tr><td>$renter_name</td><td>$phone</td></tr>";
        }
        echo "</tbody></table>";
        $stmt->close();
      }
    }

    //GGu
    if (!empty($gender) && empty($occupation) && empty($tidy) && empty($sleep) && !empty($getup)){
      if($stmt->prepare("SELECT renter_name, phone
      FROM `renter` NATURAL JOIN `lifestyle`
      WHERE roommate_searching = 1 AND gender =? AND lifestyle =?") or die(mysqli_error($db))) {
        $stmt->bind_param('ss', $gender, $getup);
        $stmt->execute();
        $stmt->bind_result($renter_name, $phone);
        echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th></tr>
        </thead><tbody>';
        while($stmt->fetch()) {
          echo "<tr><td>$renter_name</td><td>$phone</td></tr>";
        }
        echo "</tbody></table>";
        $stmt->close();
      }
    }

    //GTS
    if (!empty($gender) && empty($occupation) && !empty($tidy) && !empty($sleep) && empty($getup)){
      if($stmt->prepare("SELECT renter_name, phone
      FROM (SELECT * FROM `lifestyle` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND gender = ? AND lifestyle = ?) AS T1 NATURAL JOIN (
      SELECT renter_name, phone FROM `lifestyle` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2") or die(mysqli_error($db))) {
        $stmt->bind_param('sss', $gender, $tidy, $sleep);
        $stmt->execute();
        $stmt->bind_result($renter_name, $phone);
        echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th></tr>
        </thead><tbody>';
        while($stmt->fetch()) {
          echo "<tr><td>$renter_name</td><td>$phone</td></tr>";
        }
        echo "</tbody></table>";
        $stmt->close();
      }
    }

    //GTGu
    if (!empty($gender) && empty($occupation) && !empty($tidy) && empty($sleep) && !empty($getup)){
      if($stmt->prepare("SELECT renter_name, phone
      FROM (SELECT * FROM `lifestyle` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND gender = ? AND lifestyle = ?) AS T1 NATURAL JOIN (
      SELECT renter_name, phone FROM `lifestyle` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2") or die(mysqli_error($db))) {
        $stmt->bind_param('sss', $gender, $tidy, $getup);
        $stmt->execute();
        $stmt->bind_result($renter_name, $phone);
        echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th></tr>
        </thead><tbody>';
        while($stmt->fetch()) {
          echo "<tr><td>$renter_name</td><td>$phone</td></tr>";
        }
        echo "</tbody></table>";
        $stmt->close();
      }
    }

    //GSGu
    if (!empty($gender) && empty($occupation) && empty($tidy) && !empty($sleep) && !empty($getup)){
      if($stmt->prepare("SELECT renter_name, phone
      FROM (SELECT * FROM `lifestyle` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND gender = ? AND lifestyle = ?) AS T1 NATURAL JOIN (
      SELECT renter_name, phone FROM `lifestyle` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2") or die(mysqli_error($db))) {
        $stmt->bind_param('sss', $gender, $sleep, $getup);
        $stmt->execute();
        $stmt->bind_result($renter_name, $phone);
        echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th></tr>
        </thead><tbody>';
        while($stmt->fetch()) {
          echo "<tr><td>$renter_name</td><td>$phone</td></tr>";
        }
        echo "</tbody></table>";
        $stmt->close();
      }
    }

    //SGu
    if (empty($gender) && empty($occupation) && empty($tidy) && !empty($sleep) && !empty($getup)){
      if($stmt->prepare("SELECT renter_name, phone
      FROM (SELECT * FROM `lifestyle` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND lifestyle = ?) AS T1 NATURAL JOIN (
      SELECT renter_name, phone FROM `lifestyle` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2") or die(mysqli_error($db))) {
        $stmt->bind_param('ss', $sleep, $getup);
        $stmt->execute();
        $stmt->bind_result($renter_name, $phone);
        echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th></tr>
        </thead><tbody>';
        while($stmt->fetch()) {
          echo "<tr><td>$renter_name</td><td>$phone</td></tr>";
        }
        echo "</tbody></table>";
        $stmt->close();
      }
    }

    //TGu
    if (empty($gender) && empty($occupation) && !empty($tidy) && empty($sleep) && !empty($getup)){
      if($stmt->prepare("SELECT renter_name, phone
      FROM (SELECT * FROM `lifestyle` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND lifestyle = ?) AS T1 NATURAL JOIN (
      SELECT renter_name, phone FROM `lifestyle` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2") or die(mysqli_error($db))) {
        $stmt->bind_param('ss', $tidy, $getup);
        $stmt->execute();
        $stmt->bind_result($renter_name, $phone);
        echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th></tr>
        </thead><tbody>';
        while($stmt->fetch()) {
          echo "<tr><td>$renter_name</td><td>$phone</td></tr>";
        }
        echo "</tbody></table>";
        $stmt->close();
      }
    }

    //TS
    if (empty($gender) && empty($occupation) && !empty($tidy) && !empty($sleep) && empty($getup)){
      if($stmt->prepare("SELECT renter_name, phone
      FROM (SELECT * FROM `lifestyle` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND lifestyle = ?) AS T1 NATURAL JOIN (
      SELECT renter_name, phone FROM `lifestyle` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2") or die(mysqli_error($db))) {
        $stmt->bind_param('ss', $tidy, $sleep);
        $stmt->execute();
        $stmt->bind_result($renter_name, $phone);
        echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th></tr>
        </thead><tbody>';
        while($stmt->fetch()) {
          echo "<tr><td>$renter_name</td><td>$phone</td></tr>";
        }
        echo "</tbody></table>";
        $stmt->close();
      }
    }

    //TSGu
    if (empty($gender) && empty($occupation) && !empty($tidy) && !empty($sleep) && !empty($getup)){
      if($stmt->prepare("SELECT renter_name, phone
      FROM (SELECT * FROM `lifestyle` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND lifestyle = ?) AS T1 NATURAL JOIN (
      SELECT renter_name, phone FROM `lifestyle` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2 NATURAL JOIN (
      SELECT renter_name, phone FROM `lifestyle` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T3") or die(mysqli_error($db))) {
        $stmt->bind_param('sss', $tidy, $sleep, $getup);
        $stmt->execute();
        $stmt->bind_result($renter_name, $phone);
        echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th></tr>
        </thead><tbody>';
        while($stmt->fetch()) {
          echo "<tr><td>$renter_name</td><td>$phone</td></tr>";
        }
        echo "</tbody></table>";
        $stmt->close();
      }
    }

    //OT
    if (empty($gender) && !empty($occupation) && !empty($tidy) && empty($sleep) && empty($getup)){
      if ($occupation == "student"){
        if($stmt->prepare("SELECT renter_name, phone, major, year
        FROM `student` NATURAL JOIN `renter` NATURAL JOIN `lifestyle`
        WHERE roommate_searching = 1 AND lifestyle =?") or die(mysqli_error($db))) {
          $stmt->bind_param('s', $tidy);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $major, $year);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Major</th><th>Class Of</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$major</td><td>$year</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
      if($occupation == "non_student"){
        if($stmt->prepare("SELECT renter_name, phone, job
        FROM `non_student` NATURAL JOIN `renter` NATURAL JOIN `lifestyle`
        WHERE roommate_searching = 1 AND lifestyle =?") or die(mysqli_error($db))) {
          $stmt->bind_param('s', $tidy);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $job);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Job</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$job</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
    }

    //OTS
    if (empty($gender) && !empty($occupation) && !empty($tidy) && !empty($sleep) && empty($getup)){
      if ($occupation == "student"){
        if($stmt->prepare("SELECT renter_name, phone, major, year
        FROM (SELECT * FROM `lifestyle` NATURAL JOIN `student` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND lifestyle = ?) AS T1
        NATURAL JOIN (
        SELECT renter_name, phone, major, year FROM `lifestyle` NATURAL JOIN `student` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2") or die(mysqli_error($db))) {
          $stmt->bind_param('ss', $tidy, $sleep);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $major, $year);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Major</th><th>Class Of</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$major</td><td>$year</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
      if($occupation == "non_student"){
        if($stmt->prepare("SELECT renter_name, phone, job
        FROM (SELECT * FROM `lifestyle` NATURAL JOIN `non_student` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND lifestyle = ?) AS T1
        NATURAL JOIN (
        SELECT renter_name, phone, job FROM `lifestyle` NATURAL JOIN `non_student` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2") or die(mysqli_error($db))) {
          $stmt->bind_param('ss', $tidy, $sleep);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $job);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Job</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$job</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
    }

    //OTSGu
    if (empty($gender) && !empty($occupation) && !empty($tidy) && !empty($sleep) && !empty($getup)){
      if ($occupation == "student"){
        if($stmt->prepare("SELECT renter_name, phone, major, year
        FROM (SELECT * FROM `lifestyle` NATURAL JOIN `student` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND lifestyle = ?) AS T1
        NATURAL JOIN (
        SELECT renter_name, phone, major, year FROM `lifestyle` NATURAL JOIN `student` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2 NATURAL JOIN (
        SELECT renter_name, phone, major, year FROM `lifestyle` NATURAL JOIN `student` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T3") or die(mysqli_error($db))) {
          $stmt->bind_param('sss', $tidy, $sleep, $getup);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $major, $year);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Major</th><th>Class Of</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$major</td><td>$year</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
      if($occupation == "non_student"){
        if($stmt->prepare("SELECT renter_name, phone, job
        FROM (SELECT * FROM `lifestyle` NATURAL JOIN `non_student` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND lifestyle = ?) AS T1
        NATURAL JOIN (
        SELECT renter_name, phone, job FROM `lifestyle` NATURAL JOIN `non_student` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2 
        NATURAL JOIN (
        SELECT renter_name, phone, job FROM `lifestyle` NATURAL JOIN `non_student` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T3") or die(mysqli_error($db))) {
          $stmt->bind_param('sss', $tidy, $sleep, $getup);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $job);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Job</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$job</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
    }

    //OTGu
    if (empty($gender) && !empty($occupation) && !empty($tidy) && empty($sleep) && !empty($getup)){
      if ($occupation == "student"){
        if($stmt->prepare("SELECT renter_name, phone, major, year
        FROM (SELECT * FROM `lifestyle` NATURAL JOIN `student` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND lifestyle = ?) AS T1
        NATURAL JOIN (
        SELECT renter_name, phone, major, year FROM `lifestyle` NATURAL JOIN `student` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2") or die(mysqli_error($db))) {
          $stmt->bind_param('ss', $tidy, $getup);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $major, $year);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Major</th><th>Class Of</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$major</td><td>$year</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
      if($occupation == "non_student"){
        if($stmt->prepare("SELECT renter_name, phone, job
        FROM (SELECT * FROM `lifestyle` NATURAL JOIN `non_student` NATURAL JOIN `renter` WHERE roommate_searching = 1 AND lifestyle = ?) AS T1
        NATURAL JOIN (
        SELECT renter_name, phone, job FROM `lifestyle` NATURAL JOIN `non_student` NATURAL JOIN `renter` WHERE lifestyle = ?) AS T2") or die(mysqli_error($db))) {
          $stmt->bind_param('ss', $tidy, $getup);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $job);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Job</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$job</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
    }

    //OS
    if (empty($gender) && !empty($occupation) && empty($tidy) && !empty($sleep) && empty($getup)){
      if ($occupation == "student"){
        if($stmt->prepare("SELECT renter_name, phone, major, year
        FROM `student` NATURAL JOIN `renter` NATURAL JOIN `lifestyle`
        WHERE roommate_searching = 1 AND lifestyle =?") or die(mysqli_error($db))) {
          $stmt->bind_param('s', $sleep);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $major, $year);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Major</th><th>Class Of</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$major</td><td>$year</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
      if($occupation == "non_student"){
        if($stmt->prepare("SELECT renter_name, phone, job
        FROM `non_student` NATURAL JOIN `renter` NATURAL JOIN `lifestyle`
        WHERE roommate_searching = 1 AND lifestyle =?") or die(mysqli_error($db))) {
          $stmt->bind_param('s', $sleep);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $job);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Job</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$job</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
    }

    //OGu
    if (empty($gender) && !empty($occupation) && empty($tidy) && empty($sleep) && !empty($getup)){
      if ($occupation == "student"){
        if($stmt->prepare("SELECT renter_name, phone, major, year
        FROM `student` NATURAL JOIN `renter` NATURAL JOIN `lifestyle`
        WHERE roommate_searching = 1 AND lifestyle =?") or die(mysqli_error($db))) {
          $stmt->bind_param('s', $getup);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $major, $year);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Major</th><th>Class Of</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$major</td><td>$year</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
      if($occupation == "non_student"){
        if($stmt->prepare("SELECT renter_name, phone, job
        FROM `non_student` NATURAL JOIN `renter` NATURAL JOIN `lifestyle`
        WHERE roommate_searching = 1 AND lifestyle =?") or die(mysqli_error($db))) {
          $stmt->bind_param('s', $getup);
          $stmt->execute();
          $stmt->bind_result($renter_name, $phone, $job);
          echo '<table id="json" class="table table-striped"><thead><tr><th>Name</th><th>Phone Number</th><th>Job</th></tr>
          </thead><tbody>';
          while($stmt->fetch()) {
            echo "<tr><td>$renter_name</td><td>$phone</td><td>$job</td></tr>";
          }
          echo "</tbody></table>";
          $stmt->close();
        }
      }
    }
    
  ?>
  <input type="button" id="btnConvert" value="Convert to JSON" class="btn btn-success">
</div>


</body>

</html>