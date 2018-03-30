<?php
/*
 * Auther   Ryosuke Ando
 * created  2017/11/12
 *
 */


$unixtime = time();
echo $unixtime;
$data = param_exist("data");
$id = param_exist("id");


if ($data != null && $id != null) {
    $servername = "127.0.0.1";
    $username = "mitolab-IoT";
    $password = "mitolab";
    $database = "sensor_data";
    $dbport = 3306;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database, $dbport);

    check_Error($conn);
    $conn->set_charset('utf8');

    if (table_exist($conn, $id)) {
        create_table($conn, $id);
        echo "table " . $id . " was created";
    }

    insert_table($conn, $id, $data, $unixtime);

    $conn->close();
}


/*
 * 以下自作関数
 */

function table_exist($conn, $id)
{
    $query = "SHOW TABLES FROM sensor_data LIKE '$id';";
    echo $query . "\n";

    $rst = $conn->query($query);
    if ($rst->num_rows == 0) {
        return true;
        echo "no table" . $id;
    }
    echo "table " . $id . " exist!";
    return false;
}

function check_error($conn)
{
    if ($conn->connect_errno) {
        printf("Connect failed: %s\n", $conn->connect_error);
        exit();
    }
}

function param_exist($param_name)
{
    if (isset($_POST[$param_name])) {
        return $_POST[$param_name];
    } else if (isset($_GET[$param_name])) {
        return $_GET[$param_name];
    }
    echo "no exist" . $param_name;
    return 0;
}

function create_table($conn, $table_name)
{
    $query = "CREATE TABLE `"
        . $table_name
        . "` ("
        . "date datetime,"
        . "millsec varchar(10),"
        . "dc1 varchar(10),"
        . "LQI varchar(10),"
        . "number varchar(10),"
        . "id varchar(20),"
        . "power varchar(10),"
        . "mode varchar(10),"
        . "dc2 varchar(10),"
        . "adc1 varchar(10),"
        . "adc2 varchar(10),"
        . "identifier varchar(10)"
        . ");";

    //echo $query . "\n";
    $conn->query($query);
}

function insert_table($conn, $id, $data, $unixtime)
{
    $datetime = date("Y-m-d G:i:s", $unixtime);
    echo $datetime;
    $query = "insert into `"
        . $id
        . "` values ('"
        . $datetime . "','"
        . "','"
        . "','"
        . "','"
        . "','"
        . $id . "','"
        . $data . "','"
        . "','"
        . "','"
        . "','"
        . "','"
        . "');";
    echo $query . "\n";
    $conn->query($query);
    print($conn);
    echo "insert!";
}

?>























