<head>

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
			echo "OK";
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
	header( "Location: "."main.php");
}
$mysqli->close();
?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>見守りシステムログインページ</title>
	<!-- BootstrapのCSS読み込み -->
	<link href="AdminLTE-2.3.6/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- jQuery読み込み -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- BootstrapのJS読み込み -->
	<script src="AdminLTE-2.3.6/bootstrap/js/bootstrap.min.js"></script>
	<!-- ログインフォームのjs -->
	<script type="text/javascript" src="javascripts/loginform.js"></script>
	<!-- ログインフォーム用のスタールシート -->
	<link rel="stylesheet" type="text/css" href="css/loginform.css">
</head>

<body>
<!--
you can substitue the span of reauth email for a input with the email and
include the remember me checkbox
-->
<div class="container">
	<div class="card card-container">
		<!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
		<img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
		<p id="profile-name" class="profile-name-card"></p>
		<?php	if($login==""&&(isset($_SESSION["name"])||isset($_SESSION["pass"]))){
					echo "ログインに失敗しました。ユーザー名を確認してください";
				}
				if($_SESSION["failure"]=="timeout"){
					echo "接続がタイムアウトになったか、不正なログインです。";
					$_SESSION["failure"]="";
				}
		?>
		<form class="form-signin" action="index.php" method="post">
			<span id="reauth-email" class="reauth-email"></span>
			<input type="text" name="name"id="name" class="form-control" placeholder="User Name" required autofocus>
			<input type="password" name="pass" id="pass" class="form-control" placeholder="Password" required>
			<div id="remember" class="checkbox">
				<label>
				<input type="checkbox" value="remember-me"> Remember me
				</label>
			</div>
			<button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
		</form><!-- /form -->
		<a href="#" class="forgot-password">Forgot the password?</a>
		</div><!-- /card-container -->
	</div><!-- /container -->
</body> 
