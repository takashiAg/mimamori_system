
<?php

if(isset($_GET["user"])){
	$user = $_GET["user"];
	$dayafter	=	$_GET["after"];
	$daybefore	=	$_GET["before"];
//	echo $dayafter;
//	echo $daybefore;
	if($_GET["type"]=="power"){
		$dataplace="date,ADC1";
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
		$result="";
		while($row = $rst->fetch_row()){
			forEach($row as $value){
				$result.=$value.",";
			}
			$result.="\n";
		}
	}
}
if(isset($_GET["before"])&&isset($_GET["before"])){
	if($_GET["before"]==$_GET["after"]){
		$filename="センサーID(".$_GET["user"].")の".$_GET["before"]."のデータ";
	}else{
		$filename="センサーID(".$_GET["user"].")の".$_GET["before"]."から".$_GET["after"]."のデータ";
	}
}
header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=".$filename.".csv");

$csv=mb_convert_encoding($result, 'SJIS-win', 'UTF-8');
echo $csv;
exit();
 

?>
