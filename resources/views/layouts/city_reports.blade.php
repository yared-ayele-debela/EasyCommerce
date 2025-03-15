@extends('admindashboard.maindashboard')
@section('dashboard')
    <?php

        foreach($getUserCity as $key=>$value){
            $dataPoints[$key]['label']=$getUserCity[$key]['city'];
            $dataPoints[$key]['y']=$getUserCity[$key]['count'];
        }

    ?>
    <script>
        window.onload = function() {


            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "Registered Users City Count"
                },
                subtitles: [{
                    text: "Users"
                }],
                data: [{
                    type: "pie",
                    yValueFormatString: "#,##\"Users\"",
                    indexLabel: "{label} ({y})",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

        }
    </script>
    <div class="pagetitle  bg-light">
        <nav>
            <ol class="breadcrumb p-3 ">
                <li class="breadcrumb-item font-weight-bold"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Users Reports</li>
            </ol>
        </nav>
    </div>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
@endsection
