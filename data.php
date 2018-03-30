<?php
if(isset($_GET["user"])){
	$user = $_GET["user"];
	$dayafter	=	$_GET["after"];
	$daybefore	=	$_GET["before"];
//	echo $dayafter;
//	echo $daybefore;
	if($_GET["type"]=="power"){
		$dataplace="date,ADC1";
		$threshold=700;
	}else if($_GET["type"]=="count"){
		$dataplace="date";
	}else if($_GET["type"]=="humi"){
		$dataplace="date,power";
	}else{
		$dataplace="date,power";
	}
	$servername = "127.0.0.1";
    $username = "mitolab-IoT";
    $password = "mitolab";
    $database = "sensor_data";
    $dbport = 3306;
    $conn = new mysqli($servername, $username, $password, $database, $dbport);
    if($conn->connect_errno){
    	printf("Connect failed: %s\n", $conn->connect_error);
    	exit();
    }
    $conn->set_charset('utf8');
	$query = "SHOW TABLES FROM sensor_data LIKE '".$_GET["user"]."';";
	$rst = $conn->query($query);
	if($rst->num_rows==1){
		$query = "SELECT $dataplace FROM `".$_GET["user"]."` where date between '$daybefore' and '$dayafter';";
		//echo $query;
		$rst = $conn->query($query);
		$result=Array();
		while($row = $rst->fetch_row()){
			if(isset($threshold)){
				if($row[1]>$threshould){
					Array_Push($result,$row);
				}
			}else{
				Array_Push($result,$row);
			}
		}
		$result = json_encode($result);
		header('Content-type:application/json; charset=utf8');
		echo $result;
	}
}
?>