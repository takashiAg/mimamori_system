<?php  
session_start();
session_regenerate_id(TRUE); 
$mysqli = new mysqli('127.0.0.1', 'mitolab-IoT', 'mitolab','mitolab-IoT') or die(mysql_error());
if ($mysqli->connect_error) {
	//echo $mysqli->connect_error;
    exit();
} else {
    $mysqli->set_charset("utf8");
}

$sql = 'SELECT * FROM `mitolab-IoT` WHERE name = "'.$_SESSION["name"].'"';
if ($result = $mysqli->query($sql)) {
	$login="";
	while ($row = $result->fetch_assoc()) {
		//var_dump($row);
		if($row["pass"]==$_SESSION["pass"]){
			$login="OK";
		};
	}
	$result->close();
}
	

if($login!=""){
	$sql = 'DELETE FROM `sensor` WHERE `name` = "'.$_SESSION["name"].'";';
	$result = $mysqli->query($sql);
	//echo $result;
	$sensorinformation = json_decode($_POST['sensor']);
	foreach($sensorinformation as &$value){
		$sql = "INSERT INTO `sensor` (`number`, `sensor_id`, `sensor_place`, `sensor_type`, `name`) VALUES (NULL, '".$value[0]."', '".$value[1]."', '".$value[2]."', '".$_SESSION["name"]."');";
		$result = $mysqli->query($sql);
		var_dump($value);
	}
	//$sql = "INSERT INTO `sensor` (`number`, `sensor_id`, `sensor_place`, `sensor_type`, `name`) VALUES (NULL, '".$_POST["sensor"]."', '".$_POST["place"]."', '".$_POST["type"]."', '".$_SESSION["name"]."');";
	
	//$result = $mysqli->query($sql);
	//echo $result;
}
//echo "aaadfas";
$sql = 'SELECT * FROM `sensor` WHERE name = "'.$_SESSION["name"].'"';
if ($result = $mysqli->query($sql)) {
	$sensor=[];
	while ($row = $result->fetch_assoc()) {
		Array_push($sensor,[$row["sensor_id"],$row["sensor_type"],$row["sensor_place"]]);
	}
	$result->close();
}
$_SESSION["sensors"]=$sensor;
$mysqli->close();
?>
