<!DOCTYPE html>
<html lang="en">

<?php $path = APPPATH . 'views/header.php';
include("$path"); ?>

<?php $path = APPPATH . 'views/sidebar.php';
include("$path"); ?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="edge_device">
        <div class="row heading">
          <div class="col-lg-11">
            <?php
            foreach ($all_info['customer'] as $devices) { ?>
              <div>
                <h5><b>Customer ZTP - Devices - <?php echo $devices->username; ?></b></h5>
              </div>
            <?php } ?>

          </div>
          <?php if (($this->session->userdata('accesslevel') == 'root') || ($this->session->userdata('accesslevel') == 'admin')) {  ?>
            <div class="col-lg-1 txt-end">
              <div><a href="<?php echo base_url('Customers/index') ?>"><input type="button" class="btn btn-block btn-success" value="Back"></a></div>
            </div>
          <?php } ?>
        </div>

        <?php if ($this->session->flashdata('message')) {
          if ($this->session->flashdata('message') == 'assigned') {
            $message = 'The device has been assigned successfully';
            $style = 'bg-successbg-success-msg';
          } else {
            $message = 'The device has been unassigned successfully';
            $style = 'alert_msg alert_msg-danger error_msg';
          }
        ?>
          <div class='col-lg-6 <?php echo $style ?>' role="alert">
            <?php echo $message; ?> </div>
        <?php } ?>







        <div class="row card">
          <div class="card-body col-12">

            <div class="row">

              <div class="col-lg-12">
                <div class="heading">
                  <b>
                    <h5>Unassigned Devices:</h5>
                  </b>
                </div>

                <!-- /.card-header -->

                <table id="unassigned_devices_table" class="table table-bordered table-hover">
                  <thead>
                    <tr>

                      <th>ID</th>
                      <th>Details</th>
                      <th>License</th>
                      <th>Serial Number</th>
                      <th>Model</th>
                      <th>Area</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="contest_lst">
                    <?php foreach ($all_info['notset_devices'] as $notset_device) {
                      $model_variant = $notset_device->model_variant;
                      if ($model_variant == "l2") {
                        $_model_variant = "L2 SD-WAN";
                      } else if ($model_variant == "l2w1l2") {
                        $_model_variant = "L2 SD-WAN (L2W1L2)";
                      } else if ($model_variant == "l3") {
                        $_model_variant = "L3 SD-WAN";
                      } else if ($model_variant == "mptcp") {
                        $_model_variant = "MPTCP";
                      }
                    ?>
                      <tr>

                        <td> <?php echo $notset_device->id; ?> </td>
                        <td> <?php echo $notset_device->details; ?></td>
                        <td> <?php echo $notset_device->license; ?></td>
                        <td> <?php echo $notset_device->serialnumber; ?></td>
                        <td> <?php echo $_model_variant; ?></td>
                        <td> <?php echo $notset_device->area; ?></td>
                        <td>
                          <span class="fa_view">
                            <a style="color:#000 !important" href="<?php echo base_url('Customers/set_device/' . $notset_device->id . '/' . $all_info['customer'][0]->id . '/' . 'assign') ?>"> <button type="button" class="btn btn-block btn-success btn-xs" fdprocessedid="qjv3e">Assign</button></a>
                          </span>
                        </td>

                      </tr>
                    <?php } ?>
                  </tbody>

                  </tfoot>
                </table>


                <!-- /.card-body -->

              </div>

            </div>

            <div class="row">

              <div class="col-lg-12">

                <div class="heading" style="margin-top:1.5%;">
                  <b>
                    <h5>Assigned Devices:</h5>
                  </b>
                </div>
                <!-- /.card-header -->

                <table id="assigned_devices_table" class="table table-bordered table-hover">
                  <thead>
                    <tr>

                      <th>ID</th>
                      <th>Details</th>
                      <th>License</th>
                      <th>Serial Number</th>
                      <th>Model</th>
                      <th>Area</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="contest_lst">
                    <?php foreach ($all_info['assigned_devices'] as $notset_device) {
                      $model_variant = $notset_device->model_variant;
                      if ($model_variant == "l2") {
                        $_model_variant = "L2 SD-WAN";
                      } else if ($model_variant == "l2w1l2") {
                        $_model_variant = "L2 SD-WAN (L2W1L2)";
                      } else if ($model_variant == "l3") {
                        $_model_variant = "L3 SD-WAN";
                      } else if ($model_variant == "mptcp") {
                        $_model_variant = "MPTCP";
                      }
                      if ($notset_device->status == "up" || $notset_device->status == "UP") {
                        $status = '<div class="status"><i class="fa fa-arrow-up status_up" aria-hidden="true"></i></div>';
                      } else {
                        $status = '<div class="status"><i class="fa fa-arrow-down status_down" aria-hidden="true"></i></div>';
                      }  ?>
                      <tr>

                        <td> <?php echo $notset_device->id; ?> </td>
                        <td> <?php echo $notset_device->details; ?></td>
                        <td> <?php echo $notset_device->license; ?></td>
                        <td> <?php echo $notset_device->serialnumber; ?></td>
                        <td> <?php echo $_model_variant; ?></td>
                        <td> <?php echo $notset_device->area; ?></td>
                        <td> <?php echo $status; ?></td>
                        <td>
                          <span class="fa_view">
                            <a style="color:#000 !important" href="<?php echo base_url('Customers/set_device/' . $notset_device->id . '/' . $all_info['customer'][0]->id . '/' . 'unassign') ?>"> <button type="button" class="btn btn-block btn-danger btn-xs" fdprocessedid="qjv3e">Unassign</button></a>
                          </span>
                        </td>

                      </tr>
                    <?php } ?>
                  </tbody>

                  </tfoot>
                </table>


                <!-- /.card-body -->

              </div>

            </div>

            <div class="heading" style="margin-top:1.5%;">
                  <b>
                    <h5>Report:</h5>
                  </b>
                </div>
                <div>
                  <table id="connected_devices" class="table table-bordered table-hover">
                     <thead>
                                            <tr>
                                                <th><input type="checkbox" id="check-all"></th>
                                                <th>Serialnumber</th>
                                                <th>Details</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                        <?php foreach ($all_info['assigned_devices'] as $assigned_device) { ?>
                                            <tr>
                                              <td><input type="checkbox" class="row-checkbox"></td>
                                              <td><?php echo $assigned_device->serialnumber; ?></td>
                                              <td><?php echo $assigned_device->details; ?></td>
                                            </tr>
                                        <?php } ?>
               </tbody>
             </table>

            

             </div>

             <div class="row">
                <div class="col-lg-2">
                    <div class="btn btn-block btn-primary btn-sm download_pdf" fdprocessedid="qjv3e">Pdf Report Download</div>
                </div>
              <!-- <div class="col-lg-2">
              <a href="<?php// echo base_url('Customers/download_report') ?>" target="_blank"><input type="button" class="btn btn-block btn-success report_download" value="Pdf Report Download"></a>
              </div> -->
              <div class="col-lg-2">
              <div><a href="<?php echo base_url('Customers/excel_report_download') ?>" target="_blank"><input type="button" class="btn btn-block btn-success report_download" value="Excel Report Download"></a></div>
              </div>
             </div>
         
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>



<script>
  function deleteid(id) {

    $.ajax({
      'url': '<?php echo base_url('Customers/delete_customer') ?>',
      'method': 'post',
      'data': {
        'customer_id': id
      },
      'success': function(data) {
        window.location = '<?php echo base_url() . '/Customers' ?>';
      }
    })

  }
</script>



<script>
  $(function() {

    var dataTable = $('#unassigned_devices_table').DataTable({
      "lengthMenu": [
        [20, 50],
        [20, 50]
      ]
    });
    $('#assigned_devices_table').DataTable({
      "lengthMenu": [
        [20, 50],
        [20, 50]
      ]
    });

    
    var dataTable = $('#connected_devices').DataTable({
            "lengthMenu": [
                [10],
                [50]
            ]
        });

    

  });
</script>

<script>
$(document).ready(function() {
  $('.download_pdf').on('click', function() {
    var selectedsnos = $('.row-checkbox:checked').map(function() {
        return $(this).closest('tr').find('td:eq(1)').text();
    }).get();
    console.log(selectedsnos, 'selectedsnos');

    if(selectedsnos.length > 10){
      alert('Error: Cannot proceed with more than 10 selected IDs.');
        return;
    }

    $.ajax({
    url: '<?php echo base_url() . '/Customers/clear_file' ?>', // Path to your server-side script
    method: 'POST',
    success: function(response) {
        console.log(response); // Log the response
        // Handle success, if needed
    },
    error: function(xhr, status, error) {
        console.error(error); // Log any errors
        // Handle errors, if needed
    }
});

    // Ensure selectedsnos is sent as an array
    $.ajax({
        url: '<?php echo base_url() . '/Customers/pdf_report' ?>',
        method: 'POST',
        data: {'serialnumbers': selectedsnos.join(',')}, // Ensure it's treated as an array
        success: function(data) {
            // Open the PDF URL in a new tab
            window.open('<?php echo base_url() . '/Customers/pdf_report' ?>', '_blank');
        }
    });
});


});



</script>

</html>