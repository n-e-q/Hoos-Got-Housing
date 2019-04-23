<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="./js/jquery-1.6.2.min.js" type="text/javascript"></script>
    <script src="./js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
    <title>Search</title>
</head>

<script>
    $(document).ready(function () {
        $("#LastNinput").change(function () {
            $.ajax({
                url: 'searchnearby.php',
                type:"POST",
                data: { searchnearby: $("#LastNinput").val() },
                success: function (data) {
                    $('#LastNresult').html(data);
                }
            });
        });
    });
</script>

<body>

    <h1> Search housing options based on nearby locations </h1>

    <select id="LastNinput">
            <option value = "">---Select---</option>
            <?php
            include ("dbutil.php");
            $db = DbUtil::loginConnection();

            $stmt = $db->stmt_init();
            $stmt = $db->prepare("SELECT location_name FROM nearby");
            $stmt->execute();
            $stmt->bind_result($location_name);
            while ($stmt->fetch()){
                echo "<option value='$location_name'>$location_name</option>";
            }
            $stmt->close();
            ?>
    </select>

    <div id="LastNresult"> Search Result </div>

</body>


<?php

error_reporting(0);

$stmt = $db->stmt_init();
if($stmt->prepare("select * from nearby where location_name like ?") or die(mysqli_error($db))) {
        $searchString = $_POST['searchnearby'];
        $stmt->bind_param(s, $searchString);
        $stmt->execute();
        $stmt->bind_result($residency_address, $location_name, $location_address);
        echo "<table border=1><th>residency_address</th><th>location_name</th><th>location_address</th>\n";
        while($stmt->fetch()) {
                echo "<tr><td>$residency_address</td><td>$location_name</td><td>$location_address</td></tr>";
        }
        echo "</table>";

        $stmt->close();
}

$db->close();


?>

</html>