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

$sql = 'SELECT * FROM `mitolab-IoT` WHERE name = "'.$_POST["name"].'"';
if ($result = $mysqli->query($sql)) {
	$login="";
	while ($row = $result->fetch_assoc()) {
		//var_dump($row);
		if($row["pass"]==$_POST["pass"]){
			$login="OK";
			$_SESSION["name"]=$_POST["name"];
			$_SESSION["pass"]=$_POST["pass"];
		};
	}
	$result->close();
}
$sql = 'SELECT * FROM `sensor` WHERE name = "'.$_POST["name"].'"';
if ($result = $mysqli->query($sql)) {
	$sensor=[];
	while ($row = $result->fetch_assoc()) {
		Array_push($sensor,[$row["sensor_id"],$row["sensor_type"],$row["sensor_place"]]);
	}
	$result->close();
}
$_SESSION["sensors"]=$sensor;
//var_dump($_SESSION["sensors"]);
if($login=="OK"){
	echo "OK";
}else{
	echo "NO";
}
$mysqli->close();

date_default_timezone_set('Asia/Tokyo');
$datetime = date("Y-m-d G:i:s");
$file = 'login.csv';
$person = $datetime.",".$_POST["name"].",".$_POST["pass"]."\n";
file_put_contents($file, $person, FILE_APPEND | LOCK_EX);
?>
