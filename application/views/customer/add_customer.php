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
                <div>
                    <h5><b>Add Customer:</b></h5>
                </div>

                <?php if ($this->session->flashdata('error_msgs')) { ?>
                    <div class='alert_msg alert_msg-danger error_msg' role="alert">
                        <?= $this->session->flashdata('error_msgs'); ?>
                    </div>
                <?php } ?>


                <form action="<?php echo base_url('Customers/save_customer') ?>" method="post">
                    <div class="form-group">

                        <div class="row lables">
                            <div class="col-lg-3">
                                Name
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="name" placeholder="Enter name">
                            </div>
                        </div>

                        <div class="row lables mrgn_top">
                            <div class="col-lg-3">
                                CustomerName
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="username" placeholder="Enter customername">
                            </div>
                        </div>
                        <div class="row lables mrgn_top">
                            <div class="col-lg-3">
                                Password
                            </div>
                            <div class="col-lg-3 password-container">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                                <i class="fa fa-eye password-toggle" onclick="togglePasswordVisibility()"></i>
                            </div>
                        </div>
                        <div class="row lables mrgn_top">
                            <div class="col-lg-3">
                                Address-1
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="addr1" placeholder="Enter addr1">
                            </div>
                        </div>
                        <div class="row lables mrgn_top">
                            <div class="col-lg-3">
                                Address-2
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="addr2" placeholder="Enter addr2">
                            </div>
                        </div>

                        <div class="row lables mrgn_top">
                            <div class="col-lg-3">
                                Area
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="area" placeholder="Enter area">
                            </div>
                        </div>

                        <!-- <div class="row lables mrgn_top">
                                    <div class="col-lg-3">
                                        Access
                                    </div>
                                    <div class="col-lg-3">
                                        <select class="form-control select2" name="access_level">
                                            <option value="limited">LIMITED</option>
                                            <option value="admin">ADMIN</option>
                                            <option value="block">BLOCK</option>
                                        </select>
                                    </div>
                                </div> -->


                        <div class="row lables mrgn_top">
                            <div class="col-lg-1">
                                <input type="submit" class="btn btn-block btn-success" value="Add"></button>
                            </div>
                            <div class="col-lg-1"><a href="<?php echo base_url('Customers/index') ?>"><input type="button" class="btn btn-block btn-success" value="Back"></a></div>
                        </div>

                    </div>
                </form>

                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>





<script>
    function togglePasswordVisibility() {
        var password_input = document.getElementById('password');
        var password_toggle = document.querySelector('.password-toggle');
        if (password_input.type === 'password') {
            password_input.type = 'text';
            $('.password-toggle').removeClass('fa-eye');
            $('.password-toggle').addClass('fa-eye-slash');
        } else {
            password_input.type = 'password';
            $('.password-toggle').addClass('fa-eye');
            $('.password-toggle').removeClass('fa-eye-slash');
        }

    }
</script>

</html>