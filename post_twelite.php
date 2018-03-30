<?php
	date_default_timezone_set('Asia/Tokyo');
	$datetime = date("Y-m-d G:i:s");
$data=null;
if(isset($_POST["uart"])){
	$data=$_POST["uart"];
}else{
	if(isset($_GET["uart"])){
		$data=$_GET["uart"];
	}else{
		$data=null;
	}
}
if($data!=null){
	$servername = "127.0.0.1";
    $username = "mitolab-IoT";
    $password = "mitolab";
    $database = "sensor_data";
    $dbport = 3306;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database, $dbport);
    if($conn->connect_errno){
    	printf("Connect failed: %s\n", $conn->connect_error);
    	exit();
    }

    $conn->set_charset('utf8');
	$file=explode(";",$data);
	if(uart_check($file)){
		$query = "SHOW TABLES FROM sensor_data LIKE '".$file[5]."';";
		echo $query;
		$rst = $conn->query($query);
		if($rst->num_rows==0){
			$query=create_table($file[5]);
			echo $query;
			$conn->query($query);
		}
		$query=insert_table($file,$datetime);
		echo $query;
		$conn->query($query);
		
	}
$conn->close();
$fp = fopen("log.csv", "a");
fwrite($fp,$datetime.",".$data."\n");
fclose($fp);
}
function uart_check($file){
//	return strlen($file[0])==0&&strlen($file[2])==8&&strlen($file[3])==3&&strlen($file[4])==3&&strlen($file[5])==7&&strlen($file[6])==4&&strlen($file[7])==4&&strlen($file[8])==4&&strlen($file[9])==4&&strlen($file[10])==4&&strlen($file[11])==1;
if($file[5]=="temp"||$file[5]=="humi"){
	return true;
}elseif(strlen($file[5])==7&&(($file[2]!=1&&$file[11]="S")||$file[11]="P")){
	return strlen($file[0])==0&&strlen($file[2])==8&&strlen($file[6])==4&&strlen($file[7])==4&&strlen($file[8])==4&&strlen($file[9])==4&&strlen($file[10])==4&&strlen($file[11])==1;
}else{
	return false;
}
}
function create_table($table_name){
	return "CREATE TABLE `"
	.$table_name
	."` ("
	."date datetime,"
	."millsec varchar(10),"
	."dc1 varchar(10),"
	."LQI varchar(10),"
	."number varchar(10),"
	."id varchar(10),"
	."power varchar(10),"
	."mode varchar(10),"
	."dc2 varchar(10),"
	."adc1 varchar(10),"
	."adc2 varchar(10),"
	."identifier varchar(10)"
	.");";
}
function insert_table($file,$datetime){
	return "insert into `"
	.$file[5]
	."` values ('"
	.$datetime."','"
	.$file[1]."','"
	.$file[2]."','"
	.$file[3]."','"
	.$file[4]."','"
	.$file[5]."','"
	.$file[6]."','"
	.$file[7]."','"
	.$file[8]."','"
	.$file[9]."','"
	.$file[10]."','"
	.$file[11]
	."');";
}
?>