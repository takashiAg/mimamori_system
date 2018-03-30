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
if(!$_SESSION["name"]||!$_SESSION["pass"]){$_SESSION["failure"]="timeout";header( "Location: /");}
?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<title><?php include("parts/title_main.html"); ?></title>
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
	<!-- AdminLTE Skins. We have chosen the skin-blue for this starter page. However, you can choose any other skin. Make sure you apply the skin class to the body tag so the changes take effect. -->
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
	<script src="javascripts/plotly.js"></script>
<script>
$(function() {
	/*$(".get_csv").on("click",function(){
		alert($(this).parent().parent().attr("id"));
	});*/
	$("#testbtn").click(function(){
		$("#main").empty();
		settings=[]
		json =[{
			boxname:null,
			box_size:"6",
			chart_type:[]
		},{
			boxname:null,
			box_size:"6",
			chart_type:[]
		}];
		var sensor_count = 0;
		sensors.forEach(function(id){
			//console.log(id);
			var setuped=setup("Line Chart",id);
			//console.log(setuped)
			json[sensor_count].chart_type.push(setuped);
			if(sensor_count==1){sensor_count=0}else{sensor_count=1}
		});
		Setting.setting();
	});
    $("#autoreloadbtn").click(function(){
        setInterval(reload,60000)
    });
    function reload(){
    $("#main").empty();
    settings=[]
    json =[{
        boxname:null,
        box_size:"6",
        chart_type:[]
    },{
        boxname:null,
        box_size:"6",
        chart_type:[]
    }];
    var sensor_count = 0;
    sensors.forEach(function(id){
        //console.log(id);
        var setuped=setup("Line Chart",id);
        //console.log(setuped)
        json[sensor_count].chart_type.push(setuped);
        if(sensor_count==1){sensor_count=0}else{sensor_count=1}
    });
    setTimeout(function(){
            Setting.setting();
        },1);
}
});
var sensors=JSON.parse('<?php echo json_encode($_SESSION["sensors"]); ?>');
$(window).load(function(){
	//timeout();
	setInterval("timeout()",1)
});
/*var widthes={}
function timeout(){
	$(".js-plotly-plot").each(function(){
		//console.log($(this).attr("id"));
		if(!widthes[$(this).attr("id")]){
			widthes[$(this).attr("id")]=$(this).width();
		}else{
			if(widthes[$(this).attr("id")]!=$(this).width()){
				var width=$(this).width()
				var layout={};
				layout.width=$(this).width();
				Plotly.relayout($(this).attr("id"),layout);
				//console.log(widthes[$(this).attr("id")],$(this).width())
				//console.log(widthes)
				widthes[$(this).attr("id")]=$(this).width();
			}
		}
	});

};*/
var widthes={}
var before={}
function timeout(){
	time=[]
	$(".js-plotly-plot").each(function(){
		var this_id=$(this).attr("id")
		var this_width=$(this).width()
		//console.log($(this).attr("id"));
		if(!widthes[this_id]){
			widthes[this_id]=[];
			widthes[this_id]=[this_width,this_width,this_width];
		}else{
			widthes[this_id].unshift(this_width);
			widthes[this_id].pop();
			if(widthes[this_id][0]==widthes[this_id][1]&&widthes[this_id][0]!=widthes[this_id][2]){
				Plotly.relayout(this_id,{width:this_width});
			}
		}
	});
	if(time.length!=0){
		console.log(time);
	}
	setTimeout(timeout,1)
};
</script>

<script type="text/javascript" src="javascripts/flotgraph.js"></script>


<!--<script type="text/javascript" src="javascripts/dropdown.js"></script>-->
<!-- -->

<script type="text/javascript" src="javascripts/uuid.js"></script>

<script type="text/javascript" src="javascripts/setting.js"></script>
<script type="text/javascript" src="javascripts/getdata.js"></script>

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
	<script>window.onload=function(){$("#mainpage").addClass("active");}</script>



<!-- ejsの中身が入る-->

<style>
    #template { display: none; }
    #graph-template { display: none; }
</style>
<script>
  var Setting = new Setting();
  var Modal = new Modal();
$(window).load(function(){
  Setting.setting();
});
  var selector;
　var selector2;
　

  $(function() {
    $("#main").on("drag",".box-header",function(){
      selector = $(this).parents(".graphbox").attr("id");
      console.log(selector);
    });
    $("#main").sortable({
    placeholder: "sort-highlight",
    connectWith: ".connectedSortable",
    handle: ".box-header, .nav-tabs",
    forcePlaceholderSize: true,
    zIndex: 999999,
    stop: function(event, ui) {
  			var index = $("#main section").index($(".connectedSortable"));
  			console.log($(".connectedSortable"));
        console.log(index);
  		}
  });



  $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

  $("body").on("click","button",function(){
      var button_type = $(this).attr("class");
      if(button_type == "btn btn-success btn-flat add"){
        Setting.add();
      }
  });


  $("#main").on("click","a,button",function(){
      selector = $(this).parents(".graphbox").attr("id");
      selector2 = $(this).parents(".branch").attr("id");
      console.log(selector2);
　　  var button_type = $(this).attr("class");
　　
//buttonの機能  
　　   //boxのboxremoveボタンが押されたら
　　   if(button_type == "btn btn-box-tool cls"){
　　      $("#"+selector).parent().remove();
　　      for(key in settings){
              if(settings[key].id == selector){
                 settings.splice(key,1);
              }
          }
　　   }
　　
　　   //graphのremoveボタンだったら
　　   if(button_type == "modebar-btn plotlyjsicon modebar-btn--logo cls"||button_type == "btn btn-box-tool remove"){
　　     Setting.remove(selector,selector2);
　　     console.log(settings);
　　   }
　　   //box name設定だったら
　　   else if(button_type == "btn btn-box-tool box_name"){
　　     Modal.set("Setting",["box-name"],["save","close"]);
　　     console.log($("#modal-template").find(".save").attr("class"));
　　   }
　　   //graphの追加だったら
       else if(button_type == "btn btn-box-tool graph"){
　　     Modal.set("Setting",["sensor_type","house_type","chart_type","color_type"],["save","close"]);
　　     console.log($("#modal-template").find(".save").attr("class"));
　　   }
　　   else if(button_type == "btn btn-box-tool window"){
　　     Setting.window(selector);
　　     console.log($("#modal-template").find(".save").attr("class"));
　　   }
　　   //設定ボタンだったら
　　   else if(button_type == "modebar-btn plotlyjsicon modebar-btn--logo set"||button_type =="btn btn-box-tool set"){
　　     Modal.set("Setting",["data_set"],["save","close"]);
　　     Setting.selected(selector,selector2);
　　     console.log($("#modal-template").find(".save").attr("class"));
　　
　　   }
　　   //色変更ボタンだったら
　　   else if(button_type == "modebar-btn plotlyjsicon modebar-btn--logo color"){
　　     Modal.set("Setting",["color_type"],["save","close"]);
　　     console.log($("#modal-template").find(".save").attr("class"));
　　   }
　　    //家ボタンだったら
　　   else if(button_type == "btn btn-box-tool house"){
　　     Modal.set("Setting",["house_type"],["save","close"]);
　　     console.log($("#modal-template").find(".save").attr("class"));
　　   }
　　   else if(button_type == "btn btn-box-tool sensor"){
　　     Modal.set("Setting",["sensor_type"],["save","close"]);
　　     console.log($("#modal-template").find(".save").attr("class"));
　　   }
　　   else{
　　     return;
　　   }
  });
});

$(function() {
  $("#modal-template").on("click","button",function(){
          var button_type = $(this).attr("class");
          var function_type = button_type.split(" ");
          var draw_flag=0;
          var dataset_flag=0;
          if(document.getElementById("chart_select") != null && function_type[2] == "save"){
            Setting.canvas(selector);
          }
          for(key in function_type){
            if(function_type[key] == "box-name"){
              Setting.save(selector);
            }
            else if(function_type[key] == "data_set"){
              Setting.data_set(selector,selector2);
              draw_flag=1;
              dataset_flag=1;
            }
            else if(function_type[key] == "house_type"){
              Setting.house_change(selector,selector2);
              draw_flag=1;
            }
            else if(function_type[key] == "chart_type"){
              Setting.graph(selector,selector2);
               draw_flag=1;
            }
            else if(function_type[key] == "color_type"){
              Setting.a(selector,selector2);
               draw_flag=1;
            }
            else if(function_type[key] == "sensor_type"){
              Setting.sensor_select(selector,selector2);
               draw_flag=1;
            }
          }
          if(draw_flag == 1){
            Setting.draw(selector,selector2);
            draw_flag=0;
          }
          if(function_type[2] == "save"){
            if(dataset_flag==1){
              if(document.getElementById("exist").style.display == "block"){
              }
              else{
                dataset_flag=0;
                $('#modal-template').modal('hide');
              }
            }
            else{
              $('#modal-template').modal('hide');
            }
          }
  });
});
</script>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
  	<!-- Content Header (Page header) -->
  	<section class="content-header">
		<h1><?php include("parts/title_main.html"); ?></h1>
  	</section>

  	<!-- Main content -->
  	<section class="content">
    	<!-- Your Page Content Here -->
    	<div id = "main" class = "row">
    	</div>
  	</section>
  	<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<!--box template-->
	<?php include("parts/template.html"); ?>
<!-- /.content -->


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
	<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
	<div class="control-sidebar-bg"></div>
</div>


<!-- REQUIRED JS SCRIPTS -->


<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->



<!--   	<div id="datebefore" class="datepicker"></div>
   	<div id="dateafter" class="datepicker"></div>-->

</body>
</html>
