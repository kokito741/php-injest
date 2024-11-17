<?php
// Database configuration
$servername = "142.93.163.115"; // Replace with actual IP or hostname
$username = "api-injest-php";
$password = "OVwljsvfSKR5OMoL";
$dbname = "sensor-data";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if all necessary POST data is set
if (isset($_POST['device_id'], $_POST['temp'], $_POST['humidity'], $_POST['date_taken'], $_POST['device_password'])) {
    $device_id = $_POST['device_id'];
    $temp = $_POST['temp'];
    $humidity = $_POST['humidity'];
    $date_taken = $_POST['date_taken'];
    $device_password = $_POST['device_password'];

    // Validate device
    $sql = "SELECT * FROM `devices-list` WHERE device-id='$device_id' AND device-password='$device_password'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            // Insert data into the database
            $sql = "INSERT INTO `sensor-data` (device-id, temp, humidity, date-taken) VALUES ('$device_id', '$temp', '$humidity', '$date_taken')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error inserting data: " . $conn->error;
            }
        } else {
            echo "Invalid device ID or password";
        }
    } else {
        echo "Error validating device: " . $conn->error;
    }
} else {
    echo "Missing required POST data";
}

$conn->close();
?>
