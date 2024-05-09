<!DOCTYPE html>
<html lang="en">
<?php $path = APPPATH . 'views/header.php';
include "$path"; ?>

<?php $path = APPPATH . 'views/sidebar.php';
include "$path"; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="edge_device">
                <div class="row heading">
                    <div class="col-lg-11">
                        <div>
                            <h5><b>Linked Edge Devices</b></h5>
                        </div>
                    </div>

                </div>

                <div class="row card">
                    <div class="card-body col-12">

                        <div class="row">

                            <div class="col-lg-12">

                                <table id="users_table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>

                                            <th>ID</th>
                                            <th>Details</th>
                                            <th>License</th>
                                            <th>Serial Number</th>
                                            <th>Model - Variant</th>
                                            <th>Area</th>
                                            <th>Gateway</th>
                                            <th>Status</th>

                                        </tr>
                                    </thead>
                                    <tbody class="contest_lst">
                                        <?php foreach ($devices as $device) { ?>
                                            <tr>
                                                <td>                                                                                                                                                             <?php echo $device['id']; ?> </td>
                                                <td>                                                                                                                                                             <?php echo $device['details']; ?></td>
                                                <td>                                                                                                                                                             <?php echo $device['license']; ?></td>
                                                <td>                                                                                                                                                             <?php echo $device['serialnumber']; ?></td>
                                                <td>                                                                                                                                                             <?php echo $device['model'] . " - " . $device['model_variant']; ?></td>
                                                <td>                                                                                                                                                             <?php echo $device['area']; ?></td>
                                                <td><?php echo $device['server_details']; ?></td>
                                                <?php
                                                    if ($device['status'] == "up" || $device['status'] == "UP") {
                                                        $status = '<div class="status"><i class="fa fa-arrow-up status_up" aria-hidden="true"></i></div>';
                                                    } else {
                                                        $status = '<div class="status"><i class="fa fa-arrow-down status_down" aria-hidden="true"></i></div>';
                                                    }

                                                    ?>
                                                <td><?php echo $status; ?></td>

                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                    </tfoot>
                                </table>

                                <div class="row lables mrgn_top">

                            <div class="col-lg-1"><a href="<?php echo base_url('Welcome/dashboard') ?>"><input type="button" class="btn btn-block btn-success" value="Back"></a></div>
                        </div>
                            </div>
                            <!-- /.card -->

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
            'url': '<?php echo base_url('Edge/delete_edge') ?>',
            'method': 'post',
            'data': {
                'edge_id': id
            },
            'success': function(data) {
                window.location = '<?php echo base_url() . '/Edge' ?>';
            }
        })

    }
</script>



<script>
    $(function() {
        $('#users_table').DataTable({
            "lengthMenu": [
                [20, 50],
                [20, 50]
            ],
        });
    });
</script>

</html>