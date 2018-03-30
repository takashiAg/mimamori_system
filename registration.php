<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>

<head>
<?php
session_start();
session_regenerate_id(TRUE);
if(!$_SESSION["name"]||!$_SESSION["pass"]){header( "Location: /");}
?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<title><?php include("parts/title_registration.html"); ?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="AdminLTE-2.3.6/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="AdminLTE-2.3.6/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="AdminLTE-2.3.6/dist/css/skins/skin-blue.min.css">
  
  <link rel="stylesheet" href="AdminLTE-2.3.6/dist/css/skins/_all-skins.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="AdminLTE-2.3.6/plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="AdminLTE-2.3.6/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="AdminLTE-2.3.6/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="AdminLTE-2.3.6/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="AdminLTE-2.3.6/plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="AdminLTE-2.3.6/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
<!-- jQuery 2.2.3 -->
<script src="AdminLTE-2.3.6/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="AdminLTE-2.3.6/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="AdminLTE-2.3.6/dist/js/app.min.js"></script>
<!-- FastClick -->
<script src="AdminLTE-2.3.6/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="AdminLTE-2.3.6/dist/js/demo.js"></script>
<!-- FLOT CHARTS -->
<script src="AdminLTE-2.3.6/plugins/flot/jquery.flot.min.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="AdminLTE-2.3.6/plugins/flot/jquery.flot.resize.min.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="AdminLTE-2.3.6/plugins/flot/jquery.flot.pie.min.js"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="AdminLTE-2.3.6/plugins/flot/jquery.flot.categories.min.js"></script>

<script src="AdminLTE-2.3.6/plugins/flot/jquery.flot.time.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css" >
<!--<script type="text/javascript" src="socket.io/socket.io.js"></script>-->

<script>
$(function() {
	$("#registrations").click(function(){
		/*var sensor_id		=	$("#sensor_id").val()
		var sensor_place	=	$("#sensor_place").val()
		var sensor_type		=	$("#sensor_type").val()
		$.post("registrationAPI.php",{sensor:sensor_id,place:sensor_place,type:sensor_type},function(data){
		console.log(data)
			if(data==""){
				alert("挿入するデータがおかしいよ");
			}else{
				$("#message").value="データベースの追加に成功しました"
				aleart("データベースの追加に成功しました");
			}
		})*/
		
		registration.main()
	});
	$("#addsensor").click(function(){
		
		table.append(0,["","",""]);
		
		//削除ボタンを有効化
		table.activation();
	});
	$.get("sensor.php",function(data){
		//テーブルの要素を取得
		table.sensor=JSON.parse(data);

		//テーブルに要素を全て追加
		table.create();
	});
});

var registration=new function(){

	this.main=function(){
		
		sensorinformation=this.sensor();
		console.log(sensorinformation)
		this.post(sensorinformation)
	};
	
	this.sensor=function(){
		var sensor=[];
		$('table#sensor tbody tr').each(function(){
			var text=[];
			$("input",this).each(function(){
				text.push($(this).val());
			});
			var flag=registration.checkerror(sensor,text[0])
			//console.log("flag",flag)


			if(!flag){
			sensor.push(text);
			}
		});
		return sensor;
	};
	
	
	this.checkerror=function(sensor,data){
		var flag=[];
		var flag2=false
		flag.push(this.checkduplication(sensor,data))
		flag.push(this.checkbrank(data))
		$.each(flag,function(key,value){
			if(value==true){
				flag2=true;
				console.log("checkerror","true")
			}
		});
		return flag2;
	}
	
	this.checkduplication=function(sensor,data){
		var flag=false;
		$.each(sensor,function(key,val){
			if(data==val[0]){
				flag=true;
			}
		});
		return flag;
	}
	
	this.checkbrank=function(data){
		var flag=false;
		if(data==""){
			flag=true;
		}
		return flag;
	}
	
	this.post=function(sensorinformation){
		var sensorinformationJSON = JSON.stringify(sensorinformation);
		$.post({
			type: "POST",
			url: "multiregistrationAPI.php",
			data: {
				sensor:sensorinformationJSON
			}
		}).done(function( data ) {
			alert("センサを登録しました。")
		});
	}
}

var table=new function() {
	this.sensor=[];
	
	this.create=function(){
		$.each(this.sensor,function(key,val){
			//テーブルに行を追加
			table.append(key,val);
			
			//削除ボタンを有効化
			table.activation();
		});
	}
	
	this.activation=function(){
		this.deletesensor();
		this.changeup();
		this.changedown();
	}
	this.deletesensor=function(){
		$(".delete-sensor").off("click");
		$(".delete-sensor").on("click",function(){
			$(this).parent().parent().remove();
		});
	}
	this.changeup=function(){
		$(".change-up").off("click");
		$(".change-up").on("click",function(){
			prev_element=$(this).parent().parent().prev('tr')
			$(this).parent().parent().after(prev_element)
		});
	}
	this.changedown=function(){
		$(".change-down").off("click");
		$(".change-down").on("click",function(){
			next_element=$(this).parent().parent().next('tr')
			$(this).parent().parent().before(next_element)
		});
	}
	
	this.add=function(){
		$('table#sensor tbody').append(
			'<tr>'
			+'<th scope="row">'+0+'</th>'
			+'<td><input type="text" style="background-color:rgba(100,100,100,0);outline: 0;border: 0px;"></input></td>'
			+'<td><input type="text" style="background-color:rgba(100,100,100,0);outline: 0;border: 0px;"></input></td>'
			+'<td><input type="text" style="background-color:rgba(100,100,100,0);outline: 0;border: 0px;"></input></td>'
			+'<td><i style="cursor:pointer" class="fa fa-ban delete-sensor" aria-hidden="true">削除</i><i style="cursor:pointer" class="fa fa-arrow-up" aria-hidden="true">上へ</i><i style="cursor:pointer" class="fa fa-arrow-down" aria-hidden="true">下へ</i></td>'
			+'</tr>'
		);
	}
	
	this.append=function(key,val){
		$('table#sensor tbody').append(
			'<tr>'
			+'<td><input type="text" style="background-color:rgba(100,100,100,0);outline: 0;border: 0px;" value='+val[0]+'></input></td>'
			+'<td><input type="text" style="background-color:rgba(100,100,100,0);outline: 0;border: 0px;" value='+val[2]+'></input></td>'
			+'<td><input type="text" style="background-color:rgba(100,100,100,0);outline: 0;border: 0px;" value='+val[1]+'></input></td>'
			+'<td>'
			+'<i style="cursor:pointer" class="fa fa-ban delete-sensor" aria-hidden="true">削除</i>'
			+'<i style="cursor:pointer" class="fa fa-arrow-up change-up" aria-hidden="true">上へ</i>'
			+'<i style="cursor:pointer" class="fa fa-arrow-down change-down" aria-hidden="true">下へ</i></td>'
			+'</tr>'
		);
	}
}
</script>


<!--<script type="text/javascript" src="javascripts/dropdown.js"></script>-->
<!-- -->

<script type="text/javascript" src="javascripts/uuid.js"></script>


<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

 
	<!-- Main Header -->
	<header class="main-header">

	<!-- Logo -->
	<?php include("parts/logo.html"); ?>

	<!-- Header Navbar -->
	<?php include("parts/navbar.html"); ?>

	</header>

	<!-- Left side column. contains the logo and sidebar -->
	<?php include("parts/column.html"); ?>
	<script>window.onload=function(){$("#registration").addClass("active");}</script>






  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
	<section class="content-header">
  	<h1><?php include("parts/title_registration.html"); ?></h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Your Page Content Here -->
		<style></style>
		<div id = "main" class = "row">
        	<?php include("parts/content.html"); ?>
        	<div class="col-md-8 col-xs-12 col-md-offset-2">
        		<div class="table-responsive">
        			<table class="table table-striped table-hover" style="table-layout:fixed;" id="sensor">
        				<thead>
							<tr>
								<th style="width:100px">センサID</th>
								<th style="width:100px">設置場所</th>
								<th style="width:100px">タイプ</th>
								<th style="width:150px">削除</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<button id="registrations" class="btn btn-primary btn-md btn-block"><label><i class="fa fa-check-square fa-2x" aria-hidden="true">センサを登録</i></label></button>
				<button id="addsensor" class="btn btn-primary btn-md btn-block"><label><i class="fa fa-plus fa-2x" aria-hidden="true">センサを追加</i></label></button>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Main Footer -->
    <?php include("parts/footer.html"); ?>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
<!-- Create the tabs -->
	<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
		<li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
		<li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
	</ul>
	<!-- Tab panes -->
	<div class="tab-content">
		<!-- Home tab content -->
		<div class="tab-pane active" id="control-sidebar-home-tab">
			<h3 class="control-sidebar-heading">Recent Activity</h3>
			<ul class="control-sidebar-menu">
				<li>
					<a href="javascript::;">
						<i class="menu-icon fa fa-birthday-cake bg-red"></i>
						<div class="menu-info">
							<h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
							<p>Will be 23 on April 24th</p>
						</div>
					</a>
				</li>
			</ul>
			<!-- /.control-sidebar-menu -->
			<h3 class="control-sidebar-heading">Tasks Progress</h3>
			<ul class="control-sidebar-menu">
				<li>
					<a href="javascript::;">
						<h4 class="control-sidebar-subheading">
							Custom Template Design
							<span class="pull-right-container">
								<span class="label label-danger pull-right">70%</span>
							</span>
						</h4>
						<div class="progress progress-xxs">
							<div class="progress-bar progress-bar-danger" style="width: 70%"></div>
						</div>
					</a>
				</li>
			</ul>
			<!-- /.control-sidebar-menu -->
		</div>
		<!-- /.tab-pane -->
		<!-- Stats tab content -->
		<div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
		<!-- /.tab-pane -->
		<!-- Settings tab content -->
		<div class="tab-pane" id="control-sidebar-settings-tab">
		<form method="post">
			<h3 class="control-sidebar-heading">General Settings</h3>
			<div class="form-group">
				<label class="control-sidebar-subheading">
					Report panel usage
					<input type="checkbox" class="pull-right" checked>
				</label>
				<p>
					Some information about this general settings option
				</p>
			</div>
			<!-- /.form-group -->
			</form>
		</div>
		<!-- /.tab-pane -->
	</div>
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>


<!-- REQUIRED JS SCRIPTS -->


<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
     

     
<!--     <div id="datebefore" class="datepicker"></div>
     <div id="dateafter" class="datepicker"></div>-->

</body>
</html>
