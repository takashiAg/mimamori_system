<?php  
session_start();
session_regenerate_id(TRUE); 
$mysqli = new mysqli('127.0.0.1', 'mitolab-IoT', 'mitolab','mitolab-IoT');
if ($mysqli->connect_error) {
	echo $mysqli->connect_error;
    exit();
} else {
    $mysqli->set_charset("utf8");
}
$sql = 'SELECT * FROM `sensor` WHERE name = "'.$_SESSION["name"].'"';
if ($result = $mysqli->query($sql)) {
	$sensor=[];
	while ($row = $result->fetch_assoc()) {
		Array_push($sensor,[$row["sensor_id"],$row["sensor_type"],$row["sensor_place"]]);
	}
	$result->close();
}
echo json_encode($sensor);
$mysqli->close();
?>