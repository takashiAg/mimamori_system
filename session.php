<?php  
session_start();
session_regenerate_id(TRUE); 
echo $_SESSION["name"];
echo $_SESSION["pass"];
?>

aaa