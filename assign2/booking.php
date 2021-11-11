<link rel="stylesheet" href="../style.css">
<?php
//function to validate input with preg_match	
function validation($string, $pattern)
{
    if (preg_match($pattern, $string)) {
        return false;
    } else {
        return true;
    }
}

// get details from input fields
$name = $_POST['name'];
$phone = $_POST['phone'];
$unumber = $_POST['unumber'];
$snumber = $_POST['snumber'];
$stname = $_POST['stname'];
$sbname = $_POST['sbname'];
$dsbname = $_POST['dsbname'];
$date = $_POST['date'];
$time = $_POST['time'];
$status = "unassigned";

//assigning uniqe booking number
$bnumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

//details to connect to database
require_once('../../conf/settings.php');

//patterns for validation
$num_pattern = '/^[0-9 ]*$/';
$letter_pattern = '/^[A-Za-z ]*$/';
$both_pattern = '/^[0-9A-Za-z ]*$/';

//check if require text fields are empty 
if (empty($name) || empty($phone) || empty($snumber) || empty($stname) || empty($date) || empty($time)) {
    echo '<p><span class = "error">Require input left empty, please make sure all to fill in inputs with the require tag</span></p>';
}
//check if input is correct
else if (
    validation($name, $letter_pattern) || validation($phone, $num_pattern) || validation($unumber, $num_pattern) || validation($snumber, $both_pattern)
    || validation($stname, $letter_pattern) || validation($sbname, $letter_pattern) || validation($dsbname, $letter_pattern)
    || new DateTime() > new DateTime($date . " " . $time . ":00")
) {

    //error messaging

    echo '<span class = "error"><h1>Incorrect input in:</h1>';
    if (validation($name, $letter_pattern)) {
        echo '<li>Name - Please enter with letters only</li>';
    }
    if (validation($phone, $num_pattern)) {
        echo '<li>Phone - Please enter with numbers only</li>';
    }
    if (validation($unumber, $num_pattern)) {
        echo '<li>Unit Number - Please enter with numbers only</li>';
    }
    if (validation($snumber, $both_pattern)) {
        echo '<li>Street Number - Please enter with letters and numbers only</li>';
    }
    if (validation($stname, $letter_pattern)) {
        echo '<li>Street Name - Please enter with letters only</li>';
    }
    if (validation($sbname, $letter_pattern)) {
        echo '<li>Suburb Name - Please enter with letters only</li>';
    }
    if (validation($dsbname, $letter_pattern)) {
        echo '<li>Destination Suburb Name - Please enter with letters only</li>';
    }
    //current date greater than the input
    if (new DateTime() > new DateTime($date . " " . $time . ":00")) {
        echo '<li>Pick Up Date/Time - Please enter valid date/time</li>';
    }
    echo '</span>';
} else {

    // Connection to Database
    $conn = mysqli_connect(
        $host,
        $user,
        $pswd,
        $dbnm
    );

    if (!$conn) {
        echo '<span class = "error"><p>Database connection failure</span></p>';
    } else {
        // Database connection successful

        // check if table exist
        $query = "SELECT * FROM booking";
        $result = mysqli_query($conn, $query);

        if (empty($result)) {
            echo "<p>Table is not found</p>";

            //make booking table
            "CREATE TABLE IF NOT EXISTS booking (
                    'bnumber' int(4) NOT NULL PRIMARY KEY,
                    'name' varchar(255) NOT NULL,
                    'phone' int(20) NOT NULL,
                    'unumber' varchar(15),
                    'snumber' int(11) NOT NULL,
                    'stname' varchar(255) NOT NULL,
                    'sbname' varchar(255),
                    'dsbname' varchar(255),
                    'date' date NOT NULL,
                    'time' time NOT NULL,
                    'status' varchar(20))";

            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "<p>Table made</p>";
            } else {
                echo "<p>Table failed to make</p>";
                exit();
            }
        }

        //check if bnumber taken
        $query = "SELECT * FROM booking WHERE bnumber = '$bnumber'";
        $result = mysqli_query($conn, $query);

        //loop until bnumber is unique
        if (mysqli_num_rows($result) > 0) {
            while (mysqli_num_rows($result) > 0) {
                $bnumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                $query = "SELECT * FROM booking WHERE bnumber = '$bnumber'";
                $result = mysqli_query($conn, $query);
            }
        }

        //insert to table
        $query = "INSERT INTO booking VALUES('$bnumber','$name','$phone','$unumber','$snumber','$stname','$sbname','$dsbname','$date','$time','$status')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo '<p><b><span class = "correct">Thank you! Your booking reference number is ' . $bnumber . '. You will be picked up in front of your provided address
                    at ' . $time . ' on ' . $date . '.</p></b></span>';
        } else {
            echo "<p>Failed to insert to database</p>";
        }
    }
    //close database connection
    mysqli_free_result($result);
    mysqli_close($conn);
}
?>