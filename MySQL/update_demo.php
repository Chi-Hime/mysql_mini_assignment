<?php
// get credentials
require("../dbconnect.php");
// make connection
$conn = new mysqli($host, $db_user, $db_pw, $db_name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
	echo "connection complete";
}
$sql = "UPDATE Vehicles SET model = 'bobby', color = 'mauve' WHERE id = 15";
if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>