<?php
include "configfile.php"
$conn = new mysqli($MySQLServername, $MySQLUsername, $MySQLPassword, $MySQLDBname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO NotifyQueue (`Notification Text`) VALUES ('".$_POST['value']."')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}



$conn->close();


?>
