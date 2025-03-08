@extends('admindashboard.maindashboard')
@section('dashboard')
    <?php


  $months=array();
  $count=0;
  while($count <=3){
      $months[]=date('M Y', strtotime("-".$count." month"));
      $count++;
  }
//  echo "<pre>"; print_r($months); die;
    $dataPoints = array(
        array("y" => $ordersCount[3], "label" => $months[3]),
        array("y" => $ordersCount[2], "label" =>  $months[2]),
        array("y" => $ordersCount[1], "label" =>  $months[1]),
        array("y" => $ordersCount[0], "label" =>  $months[0]),

    );

    ?>


<script>
    window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title: {
                text: "Oders Reports"
            },
            axisY: {
                title: "Number of Orders"
            },
            data: [{
                type: "column",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    }
</script>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
@endsection
