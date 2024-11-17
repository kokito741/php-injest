<?php
// Database configuration
$servername = "142.93.163.115";
$username = "api-injest-php";
$password = "OVwljsvfSKR5OMoL";
$dbname = "sensor-data";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from request
$device_id = $_POST['device_id'];
$temp = $_POST['temp'];
$humidity = $_POST['humidity'];
$date_taken = $_POST['date_taken'];
$device_password = $_POST['device_password'];

// Validate device
$sql = "SELECT * FROM devise-list WHERE device_id='$device_id' AND device_password='$device_password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Insert data into the database
    $sql = "INSERT INTO sensor_data.device-sensors (device_id, temp, humidity, date_taken) VALUES ('$device_id', '$temp', '$humidity', '$date_taken')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Invalid device ID or password";
}

$conn->close();
?>
