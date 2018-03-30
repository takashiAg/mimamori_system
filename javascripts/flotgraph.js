function inputValue(chart_type) {
    //console.log(chart_type)
    var x = [];
    var y = [];
    var f = [];
    var value = chart_type.value;
    var id = chart_type.id;
    var data_before = chart_type.data_before;
    var data_after = chart_type.data_after;
    var sensor_id = chart_type.sensor_id;
    var color = chart_type.color;
    var house = chart_type.house;
    var sensor_type = chart_type.sensor_type;
    var sensor_place = chart_type.sensor_place;
    var canvas = "#chart" + id;
    var canvas2 = "chart" + id;


    function InteractiveChart() {

    }

    function LineChart() {
        var trace3 = {
            x: [],
            y: [],
            mode: 'lines',
            //*
            mode: 'lines+markers',
            marker: {
                color: color,
                size: 2
            },
            //*/
            line: {
                color: color,
                width: 1
            }
        };
        Dataget.sensor_id = sensor_id
        if (data_before.length != 6) {
            data_before.push(0)
            data_before.push(0)
            data_before.push(0)
        }
        if (data_after.length != 6) {
            data_after.push(0)
            data_after.push(0)
            data_after.push(0)
        }
        console.log(data_before)
        console.log(data_after)
        Dataget.datebefore = data_before
        Dataget.dateafter = data_after
        var layout = {
            showlegend: false,
            height: 150,
            //width: 480,
            xaxis: {
                showline: false,
                showgrid: false,
                showticklabels: true,
                linecolor: 'rgb(204,204,204)',
                linewidth: 2,
                autotick: true,
                ticks: 'outside',
                tickcolor: 'rgb(204,204,204)',
                tickwidth: 2,
                ticklen: 5,
                tickfont: {
                    family: 'Arial',
                    size: 10,
                    color: 'rgb(82, 82, 82)'
                },
            },
            margin: {
                autoexpand: true,
                l: 100,
                r: 20,
                t: 20,
                b: 70
            },
            yaxis: {
                showgrid: false,
                zeroline: false,
                showline: false,
                showticklabels: true
            },
            autosize: true
        };
        if (sensor_type == "count") {
            layout.yaxis.title = "回数[回]"
            var getdata = Dataget.count();
        } else if (sensor_type == "power") {
            layout.yaxis.title = "電力[W]"
            var getdata = Dataget.power();
        } else if (sensor_type == "power2") {
            layout.yaxis.title = "電力[W]"
            var getdata = Dataget.power2();
        } else if (sensor_type == "power3") {
            layout.yaxis.title = "電力[W]"
            var getdata = Dataget.power3();
        } else if (sensor_type == "temp") {
            layout.yaxis.title = "温度[度]"
            var getdata = Dataget.humi();
        } else if (sensor_type == "humi") {
            layout.yaxis.title = "湿度[％]"
            var getdata = Dataget.humi();
        } else {
            layout.yaxis.title = "回数[回]"
            var getdata = Dataget.count();
        }
        trace3.x = getdata[0]
        trace3.y = getdata[1]
        var data = [trace3];
        Plotly.newPlot(canvas2, data, layout);
    }

    function AreaChart() {
        var trace3 = {
            x: [1, 2, 3, 4],
            y: [12, 9, 15, 12],
            fill: 'tozeroy',
            type: 'scatter',
            marker: {
                color: color,
                size: 8
            },
            line: {
                color: color,
                width: 1
            }
        };
        var data = [trace3];
        Plotly.newPlot(canvas2, data);
    }

    function BarChart() {

        var trace3 = {
            x: [1, 2, 3, 4],
            y: [12, 9, 15, 12],
            type: 'bar',
            marker: {
                color: color,
                size: 8
            },
            line: {
                color: color,
                width: 1
            }
        };

        var data = [trace3];

        Plotly.newPlot(canvas2, data);
    }


    function Tablecreate() {
        var table = document.createElement('table');
        table.setAttribute("class", "table");
        var table_column = ["反応日時", "電圧"];
        Dataget.datebefore = data_before
        Dataget.dateafter = data_after
        var data = Dataget.table();
        //console.log(data);
        var rows = [];
        var cells = [];

        for (i = 0; i <= data[0].length; i++) {
            // 行の追加
            rows.push(table.insertRow(-1));
            for (j = 0; j < table_column.length; j++) {
                // 追加した行にセルを追加してテキストを書き込む
                var cell = rows[i].insertCell(-1);
                if (i == 0) {
                    cell.appendChild(document.createTextNode(table_column[j]));
                } else {
                    var k = i - 1;
                    cell.appendChild(document.createTextNode(data[j][k]));
                }
            }
        }
        document.getElementById(canvas2).setAttribute("class", "table-responsive");
        document.getElementById(canvas2).appendChild(table);
    }

    function box_header() {
//$("#"+id).find(".box-header").append('<button class="get_csv"><label>CSVを取得する<label></button>');
        if (!($("#" + id).find(".box-header").find(".get_csv").length)) {
            $("#" + id).find(".box-header").append('<b>' + sensor_place + '(センサID:' + sensor_id + ')のデータ</b>' + '<button class="get_csv"><label>CSVを取得する<label></button>');
        }
        $(".get_csv").off("click");
        $(".get_csv").on("click", function () {
            //alert($(this).parent().parent().attr("id"));
            var csv_obj_id = $(this).parent().parent().attr("id");
            var csv_type;
            //console.log(settings)
            $.each(settings, function (index, value) {
                //console.log(index, value, csv_obj_id)
                $.each(value.chart_type, function (index2, value2) {
                    //console.log("value2", value2, csv_obj_id)
                    //console.log(value2.id + "", csv_obj_id + "")
                    if (value2.id == csv_obj_id) {
                        csv_type = value2;
                        //console.log("OK")
                    }
                });
                //console.log(index, value, csv_obj_id)
            });
            //console.log(settings)
            //console.log(csv_type)
            Csv_get.sensor_id = csv_type.sensor_id
            Csv_get.datebefore = csv_type.data_before
            Csv_get.dateafter = csv_type.data_after
            Csv_get.power()
        });
    }

    var Csv_get = new csv_get();
    var Dataget = new dataget();

    if (value == "Line Chart") {
        box_header();
        LineChart();
    }
    else if (value == "Full Width Area Chart") {
        AreaChart();
    }
    else if (value == "Bar Chart") {
        BarChart();
    }
    else if (value == "Donut Chart") {
        DonutChart();
    }
    //else if(value == "Radar Chart"){
//    box_header();
//    RadarChart();
// }
    else if (value == "Table") {
        box_header();
        Tablecreate();
    }
}
