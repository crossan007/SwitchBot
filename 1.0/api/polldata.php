<?php
include "configfile.php"
$conn = new mysqli($MySQLServername, $MySQLUsername, $MySQLPassword, $MySQLDBname);
$id = intval($_GET['id']);
$highestID=0;
$JSON="{";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT * FROM NotifyQueue where id >= ".$id." ORDER BY ID ASC";
$result="";
while(true)
{
	$result = $conn->query($sql); // get the rows
	if ($result->num_rows > 0) //if there are any
	{
		while($row = $result->fetch_assoc()) { //iterate through them
		$highestID=$row['id'];
		$Text=$row['Notification Text'];
		  /*$sql = "DELETE FROM NotifyQueue where `Time` = '".$row['Time']."'";
			//echo $sql;
			if ($conn->query($sql) === TRUE) {
				//echo "message dropped";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}*/
		}

		break;
	}
	usleep(100000);
}
$conn->close();

$JSON.="\"TEXT\":\"".$Text."\",";
$JSON.="\"ID\":\"".$highestID."\"";
$JSON =$JSON."}";

echo $JSON;

?>