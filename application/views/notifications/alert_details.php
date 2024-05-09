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

            <div class="row heading">
                <div class="col-lg-12">
                    <h4><b>Alert - Details</b></h4>
                </div>
            </div>

            <div class="row card">
                <div class="card-body col-12">

                    <div class="row">

                        <div class="col-lg-12">
                            <div>

                                <?php
                                if ($list_details[0]->status == 'new') {
                                    $bg_color = 'red';
                                } else {
                                    $bg_color = 'gray';
                                }
                                ?>

                                <!-- /.card-header -->
                                <div>
                                    <div class="row padding">
                                        <div class="col-lg-3">ID</div>
                                        <div class="col-lg-9">
                                            <?php echo $list_details[0]->id ?>
                                        </div>
                                    </div>
                                    <div class="row padding">
                                        <div class="col-lg-3">Alert</div>
                                        <div class="col-lg-9">
                                            <?php echo $list_details[0]->title ?>
                                        </div>
                                    </div>
                                    <div class="row padding">
                                        <div class="col-lg-3">Timestamp</div>
                                        <div class="col-lg-9">
                                            <?php echo $list_details[0]->log_timestamp ?>
                                        </div>
                                    </div>
                                    <div class="row padding">
                                        <div class="col-lg-3">Status</div>
                                        <div class="col-lg-9">
                                            <?php echo $list_details[0]->status ?>
                                        </div>
                                    </div>
                                    <div class="row padding">
                                        <div class="col-lg-3">Details</div>
                                        <div class="col-lg-9">
                                            <?php echo $list_details[0]->details ?>
                                        </div>
                                    </div>
                                    <div class="row padding">
                                        <i onclick="change_status('<?php echo $list_details[0]->id ?>','<?php echo $list_details[0]->status; ?>')" class="fa fa-close" style="font-size:24px;cursor:pointer;color:<?php echo $bg_color; ?>"></i>
                                    </div>
                                    <div class="row padding">
                                        <i onclick="deleteid(<?php echo $list_details[0]->id; ?>)" class="fa fa-trash" aria-hidden="true" style="font-size:24px;color:red;cursor:pointer;"></i>
                                    </div>

                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <!-- /.card -->
                        <div class="row lables mrgn_top">

                            <div class="col-lg-1"><a href="<?php echo base_url('Notifications/index') ?>"><input type="button" class="btn btn-block btn-success" value="Back"></a></div>
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
            url: '<?php echo base_url() . '/Notifications/delete_single_list' ?>',
            method: 'post',
            data: {
                'alert_id': id
            },
            success: function(data) {
                console.log(data);
                window.location = '<?php echo base_url() . '/Notifications/index/' ?>';
            }
        })
    }

    function change_status(id, status) {
        console.log(id, status);
        $.ajax({
            url: '<?php echo base_url() . '/Notifications/change_status' ?>',
            method: 'post',
            data: {
                'alert_id': id,
                'status': status
            },
            success: function(data) {
                console.log(data);
                window.location = '<?php echo base_url() . '/Notifications/index/' ?>';
            }
        })
    }
</script>

<!-- Script -->
</div>

</html>