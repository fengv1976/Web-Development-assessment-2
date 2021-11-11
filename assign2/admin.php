<link rel="stylesheet" href="../style.css">

<?php
// get input
$input = $_POST['input'];

//details to connect to database
require_once('../../conf/settings.php');

//connect to database
$conn = mysqli_connect(
    $host,
    $user,
    $pswd,
    $dbnm
);

//check if database is connected
if (!$conn) {
    echo '<p><span class="error">Database connection failure</span></p>';
}
//check if input is number
else if (!preg_match('/^[0-9 ]*$/', $input)) {
    echo '<span class="error">Text can only be numbers</span>';
} else {
    //check if table exist
    $query = "SELECT * FROM booking";
    $result = mysqli_query($conn, $query);

    if (empty($result)) {
        echo "<p>Table is not found</p>";
        exit();
    } else {
        // show all bookings with a time that is within two hours from current time
        if (empty($input)) {

            //current time and date
            $current_date = date("y/m/d");
            $current_time = date("H:i:s");

            //current time plus two hours
            $plus_time = date("H:i:s", strtotime('+2 hour'));

            //query with filter to check date, time and status
            $query = "SELECT * FROM booking WHERE (date = '$current_date' AND time >= '$current_time' AND time <= '$plus_time' AND status = 'unassigned')";
        }
        //search bnumber with input
        else {
            $query = "SELECT * FROM booking WHERE bnumber = '$input'";
        }
        $result = mysqli_query($conn, $query);
        //check if query ran
        if (empty($query) || mysqli_num_rows($result) < 1) {
            echo '<span class="error">No data found</span>';
        } else {

            //table headers
            echo "<table border = \"3\" style=\"width: 100%;margin-left: auto;
                margin-right: auto;font-size: 13px;\">
                        <tr>
                        <th>Booking Reference Number</th>
                        <th>Customer Name</th>
                        <th>Contact Phone</th>
                        <th>Pick-up Suburb</th>
                        <th>Destination Suburb</th>
                        <th>Pick-up Date</th>
                        <th>Pick-up Time</th>
                        <th>Status</th>
                        </tr>";
            //loop to print all rows in table
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td>" . $row['bnumber'] .
                    "</td><td>" . $row['name'] .
                    "</td><td>" . $row['phone'] .
                    "</td><td>" . $row['sbname'] .
                    "</td><td>" . $row['dsbname'] .
                    "</td><td>" . $row['date'] .
                    "</td><td>" . $row['time'] .
                    "</td><td>" . $row['status'];

                echo "</td></tr>";
            }
            echo "</table><br>";
        }
        //close database connection
        mysqli_free_result($result);
        mysqli_close($conn);
    }
}


?>