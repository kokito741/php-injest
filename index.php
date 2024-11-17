<?php
// Database configuration
$servername = "your_server_name"; // Replace with your server address or IP
$username = "your_database_username";
$password = "your_database_password";
$dbname = "your_database_name";

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
    $sql = "SELECT * FROM `devices-list` WHERE device_id='$device_id' AND device_password='$device_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Insert data into the database
        $sql = "INSERT INTO `sensor_data` (device_id, temp, humidity, date_taken) VALUES ('$device_id', '$temp', '$humidity', '$date_taken')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Invalid device ID or password";
    }
} else {
    echo "Missing required POST data";
}

$conn->close();
?>
