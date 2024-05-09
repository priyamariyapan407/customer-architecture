<!DOCTYPE html>

<html lang="en">

<?php $path = APPPATH . 'views/header.php';
include "$path"; 
$login_type = $this->session->userdata('accesslevel'); ?>

<?php $path = APPPATH . 'views/sidebar.php';
include "$path"; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5><b>SMOAD Core - Home</b></h5>
        </div>
      </div>
    </div>
  </section>

  <section class="content">

    <div class="row">
   
      <div class="col-lg-6">
        <?php
            if ($login_type == 'root' || $login_type == 'admin' || $login_type == 'limited') {
            ?>
          <!-- area chart -->
          <div class="card card-primary">
            <div class="card-header card_title">
              <h3 class="card-title">SMOAD Edge Devices:
                <?php echo $edge_devices_count; ?>
              </h3>

            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="chart">

                    <?php

                            $device_up_count   = '';
                            $device_down_count = '';
                            $device_up_name    = '';
                            $device_down_name  = '';

                            foreach ($donutChart4 as $donutChart) {

                                if ($donutChart->status == 'up') {
                                    $device_up_count = $donutChart->quantity;
                                    $device_up_name  = $donutChart->status;
                                }

                                if ($donutChart->status == 'down') {
                                    $device_down_count = $donutChart->quantity;
                                    $device_down_name  = $donutChart->status;
                                }
                            }

                        ?>
                    <canvas id="donutChart4" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                </div>
         
           
              </div>

            </div>
            <!-- /.card-body -->
          </div>
        <?php } ?>
        <!-- /.end of area chart  -->
      </div>
    </div>

  

    <!-- <div class="container-fluid">

                <div>
                <canvas id="cool-canvas" width="600" height="300"></canvas>
                </div>
                <div style="height: 0; width: 0; overflow: hidden">
                <canvas id="supercool-canvas" width="1200" height="600"></canvas>
                </div>

                <button type="button" id="download-pdf2">
                Download PDF
                </button>


                </div> -->

  </section>


</div>
<!-- /.content-wrapper -->

<script>
  // var chart_data = {
  //   labels: ["tx packet", "rx packet", "tx byte", "rx byte"],
  //   datasets: [
  //     {
  //       fillColor: "rgb(229,124,35,0.5)",
  //       strokeColor: "rgba(220,220,220,1)",
  //       pointColor: "rgba(220,220,220,1)",
  //       pointStrokeColor: "#fff",
  //       pointHighlightFill: "#fff",
  //       pointHighlightStroke: "rgba(220,220,220,1)",
  //       data: [210, 104, 25, 800],
  //     },
  //     {
  //       fillColor: "rgba(233,102,160,0.5)",
  //       strokeColor: "rgba(220,220,220,1)",
  //       pointColor: "rgba(220,220,220,1)",
  //       pointStrokeColor: "#fff",
  //       pointHighlightFill: "#fff",
  //       pointHighlightStroke: "rgba(220,220,220,1)",
  //       data: [120, 344, 165, 674],
  //     },
  //     {
  //       fillColor: "rgba(137,129,33,0.5)",
  //       strokeColor: "rgba(220,220,220,1)",
  //       pointColor: "rgba(220,220,220,1)",
  //       pointStrokeColor: "#fff",
  //       pointHighlightFill: "#fff",
  //       pointHighlightStroke: "rgba(220,220,220,1)",
  //       data: [260, 374, 153, 694],
  //     },
  //   ],
  // };
  //original canvas
  // var canvas = document.querySelector("#cool-canvas");
  // var context = canvas.getContext("2d");
  // new Chart(context).Line(chart_data);
  //hidden canvas
  // var newCanvas = document.querySelector("#supercool-canvas");
  // newContext = newCanvas.getContext("2d");
  // var supercoolcanvas = new Chart(newContext).Line(chart_data);
  // supercoolcanvas.defaults.global = {
  //   scaleFontSize: 600,
  // };
  //add event listener to button
  // document
  //   .getElementById("download-pdf")
  //   .addEventListener("click", downloadPDF);
  // //donwload pdf from original canvas
  // function downloadPDF() {
  //   var canvas = document.querySelector("#cool-canvas");
  //   var canvasImg = canvas.toDataURL("image/jpeg", 1.0);
  //   var doc = new jsPDF("landscape");
  //   doc.setFontSize(20);
  //   doc.text(15, 15, "Cool Chart");
  //   doc.addImage(canvasImg, "JPEG", 10, 10, 280, 150);
  //   doc.save("canvas.pdf");
  // }

  // document
  //   .getElementById("download-pdf2")
  //   .addEventListener("click", downloadPDF2);

  // function downloadPDF2() {
  //   var newCanvas = document.querySelector("#supercool-canvas");
  //   var newCanvasImg = newCanvas.toDataURL("image/jpeg", 1.0);
  //   var doc = new jsPDF("landscape");
  //   doc.setFontSize(10);
  //   doc.text(10, 10, "Serial Number: a902f38a44f2ab0d");
  //   doc.text(10, 15, "Details: 714A-VAD230755-JAYPORE_(ABFRL)");
  //   doc.text(10, 20, "ConsolModel: SMOAD BumbleBeeidated");
  //   doc.text(10, 25, "Model Variant: L2 SD-WAN");
  //   doc.setFontSize(20);
  //   doc.text(10, 40, "Consolidated Report For the Month: July, 2023");
  //   doc.text(10, 50, "Total Data Transferred");
  //   doc.addImage(newCanvasImg, "JPEG", 10, 100, 280, 100);
  //   var headers = [["tx packet", "rx packet", "tx byte", "rx byte"]];
  //   var data = [
  //     [210, 104, 25, 800],
  //     [120, 344, 165, 674],
  //     [260, 374, 153, 694]
  //   ];

  //   // Auto-generate the table with the autoTable plugin
  //   doc.autoTable({
  //     head: headers,
  //     body: data,
  //     startX: 10,
  //     startY: 60 // Vertical position to start the table
  //   });
  //   doc.save("new-canvas.pdf");
  // }
</script>

<!-- <script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Digital Goods',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label               : 'Electronics',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,
      options: areaChartOptions
    })

    //-------------

  })
</script> -->

<script>
  $(document).ready(function() {


    var donutOptions = {
      maintainAspectRatio: true,
      legend: {
        position: 'right' // Position legend (labels) to the right
      }

    }
    



    var device_up_name = '<?php echo $device_up_name; ?>';
    var device_up_count = '<?php echo $device_up_count; ?>';
    var device_down_name = '<?php echo $device_down_name; ?>';
    var device_down_count = '<?php echo $device_down_count; ?>';


    var donutChartCanvas = $('#donutChart4').get(0).getContext('2d')
    var donutData = {
      labels: ['Up', 'Down'],
      datasets: [{
        data: [device_up_count, device_down_count],
        backgroundColor: ['rgba(33, 145, 80,0.9)', 'rgba(200, 200, 200, 0.9)'],
      }]
    }

    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'pie',
      data: donutData,
      options: donutOptions
    });




  




  });
</script>

<script>
  $(function() {
    $("#example1").DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "lengthMenu": [
        [20, 50]
      ]
    });
    // $("#example1").DataTable({
    //   "responsive": true, "lengthChange": false, "autoWidth": false,
    //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "lengthMenu": [
        [20, 50],
        [20, 50]
      ]
    });
    $('#example3').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "lengthMenu": [
        [20, 50],
        [20, 50]
      ]
    });
    $('#sd_wan_latency').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "lengthMenu": [
        [20, 50],
        [20, 50]
      ]
    });
    $('#sd_wan_jitter').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "lengthMenu": [
        [20, 50],
        [20, 50]
      ]
    });
    $('#sd_wan_link_usage').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "lengthMenu": [
        [20, 50],
        [20, 50]
      ]
    });

  });
</script>

<script>
  function submitform() {
    alert('words');
    $('#myform').submit();
  }
</script>


</body>

</html>