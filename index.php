<?php
// Database configuration
$servername = "142.93.163.115"; // Replace with actual IP or hostname
$username = "api-injest-php";
$password = "OVwljsvfSKR5OMoL";
$dbname = "sensor-data";
// Set the default timezone to Sofia, Bulgaria 
date_default_timezone_set('Europe/Sofia');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if all necessary POST data is set
if (isset($_POST['device_id'], $_POST['temp'], $_POST['humidity'], $_POST['date_taken'], $_POST['device_password'], $_POST['device_battery'])) {
    $device_id = $_POST['device_id'];
    $temp = $_POST['temp'];
    $humidity = $_POST['humidity'];
    $date_taken = $_POST['date_taken'];
    $device_password = $_POST['device_password'];
    $device_battery = $_POST['device_battery'];

    // Validate device
    $sql = "SELECT * FROM `devise-list` WHERE `device_id`='$device_id' AND `device_password`='$device_password'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            // Insert data into the database
            $sql = "INSERT INTO `device-sensors` (`device_id`, `temp`, `humanity`, `data_taken`) VALUES ('$device_id', '$temp', '$humidity', '$date_taken')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error inserting data: " . $conn->error;
            }

            // Update the device battery value and last seen timestamp
            $sql = "UPDATE `devise-list` SET `device_battery`='$device_battery', `device-last-seen`=NOW(), `device_status`='online' WHERE `device_id`='$device_id'";
            if ($conn->query($sql) === TRUE) {
                echo "Device battery and last seen updated successfully";
            } else {
                echo "Error updating device battery and last seen: " . $conn->error;
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
