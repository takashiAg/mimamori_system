var settings=[];

function setup(chart_type,id){
	var response = {};
	response.value=chart_type
	var dt = new Date();
    //dt.setHours(dt.getHours()-14)
    //dt.setMinutes(dt.getMinutes()-30)
	response.data_after=[dt.getFullYear(),dt.getMonth()+1,dt.getDate(),dt.getHours(),dt.getMinutes(),dt.getSeconds()]
	//console.log(dt.getDate(),dt)
	dt.setDate(dt.getDate()-1);
	//console.log(dt.getDate(),dt)
	response.data_before=[dt.getFullYear(),dt.getMonth()+1,dt.getDate(),dt.getHours(),dt.getMinutes(),dt.getSeconds()]
	//console.log(id)
	response.sensor_id=id[0]
	response.sensor_type=id[1]
	response.sensor_place=id[2]
	//console.log(response)
	return response;
}
var json =[{
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


var options = [];

$("#modal-template").on( 'click',"a", function( event ) {
    //console.log("ok");
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       $inp = $target.find( 'input' ),
       idx;

   if ( ( idx = options.indexOf( val ) ) > -1 ) {
      options.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
   } else {
      options.push( val );
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();

   //console.log( options );
   return false;
});

var Setting = function()
{
    var id;

    this.setting = function(){

        for (var i=0;i<json.length;i++){
			var str = uuid();
            var box_id = str+i;
            var ob = json[i];
            //console.log(json)
            ob.id=box_id;
			//console.log("ob",ob);
            settings.push(ob);

            var temp = $("#template").clone();
            // id設定
            $(temp).attr("id",box_id);
            $(temp).find(".box-name").attr("id","box_title"+box_id);
            // box追加
            $("#main").append(temp);
            $("#"+box_id).wrapAll('<section class="col-lg-'+ob.box_size+' connectedSortable" />');
            $("#main").sortable("refresh");
            for (var j=0;j<ob.chart_type.length;j++){
                var chart_id = str+"J"+j;
                var graph_temp = $("#graph-template").clone();
                //id設定
                $(graph_temp).attr("id",chart_id);
                $(graph_temp).find(".chart-type").attr("id","chart"+chart_id);
                //box追加
                $("#"+box_id).find(".original").append(graph_temp);
                settings[i].chart_type[j].id = str+"J"+j;
                //console.log("setting",settings[i]);
                this.draw(box_id,chart_id);
            }

        }

    }

    this.save = function(selector) {
        if(document.getElementById("box_name") == null){
            return;
        }
        //box_nameの取得
        var box_name = document.forms.form_template.box_name.value;
        //box_nameによってタイトル変更
        var elem = document.getElementById("box_title"+selector);
        elem.innerHTML = box_name;

        for(key in settings){
            if(settings[key].id == selector){
                settings[key].box_name = box_name;
            }
        }
    }

    this.canvas = function(selector){
        id = uuid();
        var graph_temp = $("#graph-template").clone();
        //id設定
        $(graph_temp).attr("id",id);
        $(graph_temp).find(".chart-type").attr("id","chart"+id);
        //box追加
        $("#"+selector).find(".original").append(graph_temp);
        for(key in settings){
            if(settings[key].id == selector ){
                settings[key].chart_type.push({id:id,value:null,box_size:null,color:null,house:null,data_before:null,data_after:null,sensor:[1,2,3,4,5,6,0]});
            }
        }
    }

    this.graph = function(selector,selector2){
        if(selector2==null){
            selector2 = id;
        }
        //valueの取得
        var index = document.myForm.mySelect.selectedIndex;
        var value = document.myForm.mySelect.options[index].value;

        var hiduke=new Date();
        var year_after = hiduke.getFullYear();
        var month_after = hiduke.getMonth()+1;
        var day_after = hiduke.getDate();
        var hour_after = hiduke.getHours();
        var hiduke2 = new Date();
        hiduke2.setDate( hiduke2.getDate() -7 );
        var year_before = hiduke2.getFullYear();
        var month_before = hiduke2.getMonth()+1;
        var day_before = hiduke2.getDate();
        var hour_before = hiduke2.getHours();
        var data_before = [year_before,month_before,day_before];
        var data_after = [year_after,month_after,day_after];
        //console.log(settings);
        for(key in settings){
            if(settings[key].id == selector ){
                for(key2 in settings[key].chart_type){
                    if(settings[key].chart_type[key2].id == selector2){
                        settings[key].chart_type[key2].value = value;
                        settings[key].chart_type[key2].data_before = data_before;
                        settings[key].chart_type[key2].data_after = data_after;
                    }
                }
            }
        }
    }


    this.data_set = function(selector,selector2){
        var date = $("#datebefore").datepicker("getDate");
        var year_before = date.getFullYear()
        var month_before = date.getMonth()+1;
        var day_before = date.getDate();
		var date = $("#dateafter").datepicker("getDate");
        var year_after = date.getFullYear();
        var month_after = date.getMonth()+1;
        var day_after = date.getDate();
        var data_before = [year_before,month_before,day_before];
        var data_after = [year_after,month_after,day_after];

            for(key in settings){
                if(settings[key].id == selector ){
                    for(key2 in settings[key].chart_type){
                        if(settings[key].chart_type[key2].id == selector2){
                            settings[key].chart_type[key2].data_before = data_before;
                            settings[key].chart_type[key2].data_after =  data_after;
                        }
                    }
                }
            }
            //console.log(settings);
    }

    this.house_change = function(selector,selector2){
        if(selector2==null){
            selector2 = id;
        }
        var index= document.myForm.houseChange.selectedIndex;
        var house = document.myForm.houseChange.options[index].value;
        for(key in settings){
            if(settings[key].id == selector ){
                for(key2 in settings[key].chart_type){
                    if(settings[key].chart_type[key2].id == selector2){
                        settings[key].chart_type[key2].house = house;
                    }
                }
            }
        }
    }

    this.sensor_select = function(selector,selector2){
        if(selector2==null){
            selector2 = id;
        }
        var sensor = [];
        for(var i=1;i<7;i++){
            var value = $("[name=Sensor"+i+"]:checked").val();
            if(value != null){
                sensor.push(value);
            }
        }
        sensor.push(0);
        for(key in settings){
            if(settings[key].id == selector ){
                for(key2 in settings[key].chart_type){
                    if(settings[key].chart_type[key2].id == selector2){
                        settings[key].chart_type[key2].sensor = sensor;
                    }
                }
            }
        }
        //console.log(sensor);

    }

    this.a = function(selector,selector2){
        if(selector2==null){
            selector2 = id;
        }
        var index_color = document.myForm.colorChange.selectedIndex;
        var color = document.myForm.colorChange.options[index_color].value;
        if (color == "Color"){
            color == "#0000FF"
        }
        for(key in settings){
            if(settings[key].id == selector ){
                for(key2 in settings[key].chart_type){
                    if(settings[key].chart_type[key2].id == selector2){
                        settings[key].chart_type[key2].color = color;
                    }
                }
            }
        }
    }

    this.add= function(){
        var str = uuid();
        //templateのクローン作製
        var temp = $("#template").clone();
        //id設定
        $(temp).attr("id",str);
        $(temp).find(".box-name").attr("id","box_title"+str);
        //box追加
        $("#main").append(temp);
        $("#"+str).wrapAll('<section class="col-lg-12 connectedSortable" />');
        $("#main").sortable("refresh");
        //id保存
        settings.push({id:str,box_name:null,chart_type:[]});
    }

    this.remove = function(selector,selector2){
        $("#"+selector2).remove();
        //配列のデータも削除
        for(key in settings){
            if(settings[key].id == selector){
                for(key2 in settings[key].chart_type){
                    if(settings[key].chart_type[key2].id == selector2){
                        settings[key].chart_type.splice(key2,1);
                    }
                }
            }
        }
    }


    this.window = function(selector){
        if($("#"+selector).parent().attr("class")=="col-lg-12 connectedSortable"){
            $("#"+selector).parent().attr("class","col-lg-6 connectedSortable");
        }
        else if($("#"+selector).parent().attr("class")=="col-lg-6 connectedSortable"){
            $("#"+selector).parent().attr("class","col-lg-12 connectedSortable");
        }
    }

    this.draw = function(selec,selec2){
        if(selec2==null){
            selec2 = id;
        }
        var chart_type;
		//console.log("selec",selec);
		//console.log("selec2",selec2);
        for(key in settings){
                if(settings[key].id == selec ){
                    for(key2 in settings[key].chart_type){
                        if(settings[key].chart_type[key2].id == selec2){
                            chart_type = settings[key].chart_type[key2];
                            //console.log("charttype",chart_type);
                        }
                    }
                }
        }
        if(chart_type.value == "Chart type"){
            this.remove(selec,selec2);
        }
        var kikan = ["年","月","日"];
        var house = chart_type.house;
        var before="";
        var after="";
        for(var i=0;i<3;i++){
               before += chart_type.data_before[i]+kikan[i];
               after += chart_type.data_after[i]+kikan[i];
        }
        var start = new Date(chart_type.data_before[0],chart_type.data_before[1]-1,chart_type.data_before[2],chart_type.data_before[3],0,0); // 開始日の指定 ※月は-1してください。例）1月なら0
        var myS　= start.getTime();
        var end = new Date(chart_type.data_after[0],chart_type.data_after[1]-1,chart_type.data_after[2],chart_type.data_after[3],0,0);  // 終了日の指定
        var myE = end.getTime();              // 1970/1/1午前0時からの終了日までのミリ秒
		//console.log(myS);
		//console.log(myE);
        /*if(myS>myE){
            $("#"+selec2).find(".box-header .kikan").empty();
            if(document.getElementById("exist") != null){
				console.log(myS);
				console.log(myE);
                document.getElementById("exist").style.display="block";
            }
        }
        else{
            if(document.getElementById("exist") != null){
                document.getElementById("exist").style.display="none";
            }
            $("#"+selec2).find(".box-header .kikan").empty();
            $("#"+selec2).find(".box-header .kikan").append('<div>'+before+'~'+after+'のデータ</div>');
        }*/
        $("#chart"+selec2).empty();
        console.log(chart_type)
        setTimeout(function(){
            inputValue(chart_type)
        },1);
        //console.log(settings);
    }

    this.selected = function(selec,selec2){
        if(selec2==null){
            selec2 = id;
        }
        var data_before;
        var data_after;
        for(key in settings){
                if(settings[key].id == selec ){
                    for(key2 in settings[key].chart_type){
                        if(settings[key].chart_type[key2].id == selec2){
                            data_before = settings[key].chart_type[key2].data_before;
                            data_after = settings[key].chart_type[key2].data_after;
                        }
                    }
                }
        }
        $("select option").attr("selected",false);
        $("#year_select_before").val(data_before[0]+"");
        $("#month_select_before").val(data_before[1]+"");
        $("#day_select_before").val(data_before[2]);
        $("#year_select_after").val(data_after[0]+"");
        $("#month_select_after").val(data_after[1]);
        $("#day_select_after").val(data_after[2]);
    }
}

var Modal = function()
{
var name = '<label for="box_name">Box Name</label>'
         + '<div class="form-item">'
         + '<input type="text" id="box_name" name="box_name" required="required" placeholder="box name" value=""></input>'
         + '</div>';

var chart = '<label>Chart type</label>'
          + '<select id="chart_select" name="mySelect" style="width: 100%;" class="form-control" >'
          + '<option selected="selected">Chart type</option>'
          + '<option value="Interactive Area Chart">Interactive Area Chart</option>'
          + '<option value="Line Chart">Line Chart</option>'
          + '<option value="Full Width Area Chart">Full Width Area Chart</option>'
          + '<option value="Bar Chart">Bar Chart</option>'
          + '<option value="Table">Table</option>'
          + '</select>';

var color = '<label>Color</label>'
          + '<select id="color_select" name="colorChange" class="form-control" style="width: 100%;" >'
          + '<option selected="selected">Color</option>'
          + '<option value="#000000">Black</option>'
          + '<option value="#FF0000">Red</option>'
          + '<option value="#0000FF">Blue</option>'
          + '<option value="#32CD32">Green</option>'
          + '<option value="#FFFF00">Yellow</option>'
          + '</select>';


//var house = '<label>House</label>'
//          + '<select id="house_select" name="houseChange" class="select" title="Choose one of the following..." style="width: 100%;" >'
//          + '<option selected="selected">House</option>'
//          + '<option value="A">A</option>'
//          + '<option value="B">B</option>'
//          + '<option value="C">C</option>'
//          + '</select>'
//          + '<script type="text/javascript">'
//          + '$(function(){'
//          + '$(".select").select2();'
//          + '});'
//          + '</script>';


//var house =	'<label>House</label>'+
//			'<div class="btn-group">'+
//			'<button type="button" class="btn"><span id="visibleValue">Action</span></button>'+
//			'<button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>'+
//			'<ul class="dropdown-menu" role="menu" hiddenTag="#hiddenValue" visibleTag="#visibleValue">'+
//			'<li><a href="javascript:void(0)" value="Action">Action</a></li>'+
//			'<li><a href="javascript:void(0)" value="Another action">Another action</a></li>'+
//			'<li><a href="javascript:void(0)" value="Something else here">Something else here</a></li>'+
//			'<li class="divider"></li>'+
//			'<li><a href="javascript:void(0)" value="Separated link">Separated link</a></li>'+
//			'</ul>'+
//			'<input type="hidden" id="hiddenValue" value="">'+
//			'</div>'+
//			'<script type="text/javascript">'+
//			'$(function(){'+
//			'$(".dropdown-menu a").click(function(){'+
//			'var visibleTag = $(this).parents("ul").attr("visibleTag");'+
//			'var hiddenTag = $(this).parents("ul").attr("hiddenTag");'+
//			'$(visibleTag).html($(this).attr("value"));'+
//			'$(hiddenTag).val($(this).attr("value"));'+
//			'})'+
//			'})'+
//			'</script>';

//var house =	'<div class="btn-group">'+
//			'<a class="btn btn-primary" data-label-placement>Checked option</a>'+
//			'<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" data-placeholder="Please select"><span class="caret"></span></button>'+
//			'<ul class="dropdown-menu" name="houseChange" id="house_select">'+
//			'<li><input type="option" name="houseChange" id="H" value="house"><label for="H">ando</label></li>'+
//			'<li><input type="option" name="houseChange" id="A" value="A"><label for="A">A</label></li>'+
//			'<li><input type="option" name="houseChange" id="B" value="B"><label for="B">B</label></li>'+
//			'<li><input type="option" name="houseChange" id="C" value="C"><label for="C">C</label></li>'+
//			'</ul>'+
//			'</div><br/>';

//var house =	'<div class="dropdown">'+
//			'<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">'+
//			'ご利用中のスマートフォン'+
//			'<span class="caret"></span>'+
//			'</button>'+
//			'<ul class="dropdown-menu">'+
//			'<li><a href="#" data-value="iphone">iPhone</a></li>'+
//			'<li><a href="#" data-value="android">Android</a></li>'+
//			'<li class="divider"></li>'+
//			'<li><a href="#" data-value="other">それ以外</a></li>'+
//			'</ul>'+
//			'<input type="hidden" name="dropdown-value" value="">'+
//			'</div>';

var sensor = '<label>Sensor</label>'+
             '<div class="input-group-btn">'+
             '<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" style="width:100%;">Sensor'+
             '<span></span>'+
             '<span class="caret"></span></button>'+
             '<ul id="sensor_select" class="dropdown-menu noclose" style="width:100%;">'+
             '<li><a href="#" class="small" data-value="option1" tabIndex="-1"><input type="checkbox" name="Sensor1" value="1"/>&nbsp;Sensor1</a></li>'+
             '<li><a href="#" class="small" data-value="option2" tabIndex="-1"><input type="checkbox" name="Sensor2" value="2"/>&nbsp;Sensor2</a></li>'+
             '<li><a href="#" class="small" data-value="option3" tabIndex="-1"><input type="checkbox" name="Sensor3" value="3"/>&nbsp;Sensor3</a></li>'+
             '<li><a href="#" class="small" data-value="option4" tabIndex="-1"><input type="checkbox" name="Sensor4" value="4"/>&nbsp;Sensor4</a></li>'+
             '<li><a href="#" class="small" data-value="option5" tabIndex="-1"><input type="checkbox" name="Sensor5" value="5"/>&nbsp;Sensor5</a></li>'+
             '<li><a href="#" class="small" data-value="option6" tabIndex="-1"><input type="checkbox" name="Sensor6" value="6"/>&nbsp;Sensor6</a></li>'+
             '</ul>'+
             '</div>';

//var sensor=	'<div class="btn-group">'+
//			'<a class="btn btn-primary" data-label-placement style="width: 100%;">Checked option</a>'+
//			'<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" data-placeholder="Please select" ><span class="caret"></span></button>'+
//			'<ul class="dropdown-menu">'+
//			'<li><input type="checkbox" name="Sensor1" id="sensor1" value="1"><label for="sensor1">sensor1</label></li>'+
//			'<li><input type="checkbox" name="Sensor2" id="sensor2" value="2"><label for="sensor2">sensor2</label></li>'+
//			'<li><input type="checkbox" name="Sensor3" id="sensor3" value="3"><label for="sensor3">sensor3</label></li>'+
//			'<li><input type="checkbox" name="Sensor4" id="sensor4" value="4"><label for="sensor4">sensor4</label></li>'+
//			'<li><input type="checkbox" name="Sensor5" id="sensor5" value="5"><label for="sensor5">sensor5</label></li>'+
//			'<li><input type="checkbox" name="Sensor6" id="sensor6" value="6"><label for="sensor6">sensor6</label></li>'+
//			'</ul>'+
//			'</div><br/>';


var data = '<div id="datebefore" class="datepicker"></div><div id="dateafter" class="datepicker"></div>';

var modal_element = "";

var save_button = '<button type="button" class="btn btn-primary save ">保存</button>';
var close_button = '<button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>';


     this.set = function(box_name,form_type,button_type){
                    //sensorフォーム用
                    var options = [];
                    $( '.dropdown-menu a' ).on( 'click', function( event ) {

                       var $target = $( event.currentTarget ),
                           val = $target.attr( 'data-value' ),
                           $inp = $target.find( 'input' ),
                           idx;

                       if ( ( idx = options.indexOf( val ) ) > -1 ) {
                          options.splice( idx, 1 );
                          setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
                       } else {
                          options.push( val );
                          setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
                       }

                       $( event.target ).blur();

                       //console.log( options );
                       return false;
                    });

                var modal_name = document.getElementById("modal-label");
                var modal_form = document.getElementById("modal-form");
                var modal_button = document.getElementById("modal-function");
                var flag=0;
                modal_name.innerHTML = box_name;
                var form ="";
                var button="";
                for(key in form_type){
                        if(form_type[key]=="box-name"){
                            modal_element += form_type[key]+" ";
                            form_type[key] = name;
                        }
                        else if(form_type[key]=="chart_type"){
                            modal_element += form_type[key]+" ";
                            form_type[key] = chart;
                        }
                        //else if(form_type[key]=="color_type"){
                        //    modal_element += form_type[key]+" ";
                        //    form_type[key] = color;
                        //}
                        else if(form_type[key]=="data_set"){
                            modal_element += form_type[key]+" ";
                            form_type[key] = data+'<p id="exist" class="error" style="display:none; color:#FF0000;">before_dateとafter_dateの日付がおかしいです</p>';
                        }
                        //else if(form_type[key]=="house_type"){
                        //    modal_element += form_type[key]+" ";
                        //    form_type[key] = house;
                        //}
                        else if(form_type[key]=="sensor_type"){
                            modal_element += form_type[key]+" ";
                            form_type[key] = sensor;
                            flag = 1;
                        }
                        else{
                            form_type[key]="";
                        }
                        form = form + form_type[key];
                }
                save_button = '<button type="button" class="btn btn-primary save '+modal_element+'">保存</button>';
                for(key in button_type){
                        if(button_type[key]=="save"){
                            button_type[key] = save_button;
                        }
                        else if(button_type[key]=="close"){
                            button_type[key] = close_button;
                        }
                        else{
                            button_type[key] = "";
                        }
                        button = button + button_type[key];
                }
                modal_form.innerHTML = form;
                $(function() {$(".datepicker").datepicker();});
                modal_button.innerHTML = button;
                modal_element = "";
　　            //modalを表示
　　            $('#modal-template').modal();
　　
          }

}


var day = function(timing){
                if(timing == '_before'){
                        var index = document.myForm.monthChange_before.selectedIndex;
                        var month = document.myForm.monthChange_before.options[index].value;
                }
                else if(timing == '_after'){
                        var index = document.myForm.monthChange_after.selectedIndex;
                        var month = document.myForm.monthChange_after.options[index].value;
                }
                        var day_select = document.getElementById("day_select"+timing);
                        var n;
                        if(month == "2"){
                            n =30;
                        }
                        else if(month == "4"||month == "6"||month == "9"||month == "11"){
                            n = 31;
                        }
                        else{
                            n = 32;
                        }

                       var data  = '<select id="day_select'+timing+'" name="dayChange'+timing+'">';
                                    for(var j = 1; j < n; ++j){
                                        data = data + '<option value=' + j + '>' + j + '</option>';
                                    }
                        day_select.innerHTML = data;

                    }


var date_form = function(timing,form_title){
                    var time = "'"+timing+"'"
                    var year_select  = '<label for="data_number">'+form_title+'</label>'
                                     + '<select id="year_select'+timing+'" name="yearChange'+timing+'">'
                                     + '<option value="2016">2016</option>'
                                     + '<option value="2017">2017</option>'
                                     + '</select>年';

                    var month_select = '<select id="month_select'+timing+'" name="monthChange'+timing+'" onchange="day('+time+');">';
                                     for (var i = 1; i < 13; ++i) {
                                        month_select = month_select + '<option value=' + i + '>' + i + '</option>';
                                     }
                                     month_select = month_select + '</select>月';

                    var day_select  = '<select id="day_select'+timing+'" name="dayChange'+timing+'">';
                                    for(var j = 1; j < 32; ++j){
                                        day_select = day_select + '<option value=' + j + '>' + j + '</option>';
                                    }
                                    day_select = day_select + '</select>日';

                    var hour_select  = '<select id="hour_select'+timing+'" name="hourChange'+timing+'">';
                                     for(var k = 0; k < 24; ++k){
                                        hour_select = hour_select + '<option value=' + k + '>' + k + '</option>';
                                     }
                                     hour_select = hour_select + '</select>時';


                    var data = '<ul>'+year_select+month_select+day_select+'</ul>';


                    return data;

                }
