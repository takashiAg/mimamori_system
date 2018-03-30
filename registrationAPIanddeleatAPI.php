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

$sql = 'SELECT * FROM `sensor` WHERE name = "'.$_POST["sensor"].'"';
if ($result = $mysqli->query($sql)) {
	$registration="OK";
	while ($row = $result->fetch_assoc()) {
		if($row["sensor"]==$_POST["sensor"]){
			$registration="";
		};
	}
	$result->close();
}
//echo "login ".$login;
//echo "registration ".$registration;
//if($registration=="OK"&&$login=="OK"){echo "a";}else{echo "b";}
if($registration!=""&&$login!=""){
	$sql = "DELETE FROM `sensor` WHERE ".`sensor_id = `.$_POST["sensor"].".name = ".$_SESSION["name"].";";
	$result = $mysqli->query($sql);
	echo $result;
	//$sql = "INSERT INTO `sensor` (`number`, `sensor_id`, `name`) VALUES (NULL, 'e', 'e');";
	//$sql = "INSERT INTO `sensor` (`number`, `sensor_id`, `sensor_place`, `name`) VALUES (NULL, '".$_POST["sensor"]."', '".$_POST["place"]."', '".$_SESSION["name"]."');";
	$sql = "INSERT INTO `sensor` (`number`, `sensor_id`, `sensor_place`, `sensor_type`, `name`) VALUES (NULL, '".$_POST["sensor"]."', '".$_POST["place"]."', '".$_POST["type"]."', '".$_SESSION["name"]."');";
	//$sql = "INSERT INTO `sensor` (number,name,sensor_id) VALUES (null,'".$_POST["name"]."','".$_POST["sensor"]."')";
	//echo $sql;
	$result = $mysqli->query($sql);
	echo $result;
}
//echo "aaadfas";
$mysqli->close();
?>
