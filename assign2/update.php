<link rel="stylesheet" href="../style.css">

<?php
// get input
$input = $_POST['input'];

//details to connect to database
require_once('../../conf/settings.php');

if (empty($input)) {
    echo '<span class="error">Text was empty</span>';
} else if (preg_match('/^[a-zA-Z\s-]+$/', $input)) {
    echo '<span class="error">Text can only be numbers</span>';
} else {

    //connect to database
    $conn = mysqli_connect(
        $host,
        $user,
        $pswd,
        $dbnm
    );
    //check if database is connected
    if (!$conn) {
        echo '<p><span class="error">Database connection failure</p></span>';
    } else {
        //check if table exist
        $query = "SELECT * FROM booking";
        $result = mysqli_query($conn, $query);
        //exit if not found
        if (empty($result)) {
            echo "<p>Table is not found</p>";
            exit();
        } else {
            // search booking number by with input
            $query = "SELECT * FROM booking WHERE bnumber = '$input'";
            $result = mysqli_query($conn, $query);
            //if booking not found
            if (mysqli_num_rows($result) == 0) {
                echo '<span class="error">Booking number not found</span>';
            } else {

                $row = mysqli_fetch_array($result);

                //check if status in booking number is assigned
                if ($row['status'] == 'Assigned') {
                    echo '<span class="error">Booking number already assigned</span>';
                } else {
                    //update status to assigned
                    $query = "UPDATE booking SET status='Assigned' WHERE bnumber='$input'";
                    $result = mysqli_query($conn, $query);

                    //check if update is successful
                    if (mysqli_affected_rows($conn) == 0) {
                        echo '<span class="error">Booking number failed to be update to Assigned</span>';
                    } else {
                        echo '<span class="correct">Booking number is updated to Assigned</span>';
                    }
                }
            }
            //close database connection
            mysqli_free_result($result);
            mysqli_close($conn);
        }
    }
}
?>