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
                        <div>
                            <h5><b>Smoad Customers</b></h5>
                        </div>
                    </div>
                    <?php if (($this->session->userdata('accesslevel') == 'root') || ($this->session->userdata('accesslevel') == 'admin')) {  ?>
                        <div class="col-lg-1 txt-end">
                            <div><a href="<?php echo base_url('Customers/add_customer') ?>"><input type="button" class="btn btn-block btn-success" value="Add"></a></div>
                        </div>
                    <?php } ?>
                </div>

                <?php if ($this->session->flashdata('error_msgs')) { ?>
                    <div class='col-lg-6 alert_msg alert_msg-danger error_msg' role="alert">
                        <?= $this->session->flashdata('error_msgs'); ?> </div>
                <?php } ?>

                <?php if ($this->session->flashdata('delete_msg_failure')) { ?>
                    <div class='col-lg-6 alert_msg alert_msg-danger error_msg' role="alert">
                        <?= $this->session->flashdata('delete_msg_failure'); ?> </div>
                <?php } ?>

                <?php if ($this->session->flashdata('success_msg')) { ?>
                    <div class='col-lg-6 bg-success-msg' role="alert">
                        <?= $this->session->flashdata('success_msg'); ?> </div>
                <?php } ?>

                <?php if ($this->session->flashdata('delete_msg_success')) { ?>
                    <div class='col-lg-6 bg-success-msg' role="alert">
                        <?= $this->session->flashdata('delete_msg_success'); ?> </div>
                <?php } ?>
                <?php if ($this->session->flashdata('update_msgs')) { ?>
                    <div class='col-lg-6 bg-success-msg' role="alert">
                        <?= $this->session->flashdata('update_msgs'); ?> </div>
                <?php } ?>

                <div class="row card">
                    <div class="card-body col-12">

                        <div class="row">

                            <div class="col-lg-12">
                                <div>

                                    <!-- /.card-header -->
                                    <div>
                                        <table id="users_table" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="check-all"></th>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Customer Name</th>
                                                    <th>Area</th>
                                                    <th>Assigned Devices</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="contest_lst">
                                                <?php foreach ($customers_info as $customer) { ?>
                                                    <tr>
                                                        <td> <input type="checkbox" class="row-checkbox"> </td>
                                                        <td> <?php echo $customer['id']; ?> </td>
                                                        <td> <?php echo $customer['name']; ?></td>
                                                        <td> <?php echo $customer['username']; ?></td>
                                                        <td> <?php echo $customer['area']; ?></td>

                                                        <td> <?php echo $customer['assigned_devices']; ?></td>
                                                        <td>

                                                            <span class="fa_edit" style="margin: 2%;">
                                                                <a style="color:#000 !important" href="<?php echo base_url('Customers/update_customer/' . $customer['id']) ?>"><span class='fas fa-edit'></span></a>
                                                            </span>
                                                            <?php if (($this->session->userdata('accesslevel') == 'root') || ($this->session->userdata('accesslevel') == 'admin')) {  ?>
                                                                <span class="fa_delete" style="margin: 2%;">
                                                                    <span style="cursor:pointer;" data-bs-toggle="modal" onclick="deleteid('<?php echo  $customer['id'] ?>')">
                                                                        <span class="fa fa-trash"></span></span>
                                                                </span>
                                                            <?php } ?>
                                                            <span style="margin: 2%;">
                                                                <a style="color:#000 !important" href="<?php echo base_url('Customers/customer_devices/' . $customer['id']) ?>"><span class='fas fa-tasks'></span></a>
                                                            </span>
                                                        </td>

                                                    </tr>
                                                <?php } ?>
                                            </tbody>

                                            </tfoot>
                                        </table>
                                        <div class="col-lg-2">
                                            <div id="delete-selected">
                                                <button type="button" class="btn btn-block btn-primary btn-sm" fdprocessedid="qjv3e">Delete Selected</button>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- /.card-body -->
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

        var dataTable = $('#users_table').DataTable({
            "lengthMenu": [
                [20, 50],
                [20, 50]
            ]
        });

        // Check/uncheck all checkboxes when the "Check All" checkbox is clicked
        $('#check-all').on('change', function() {
            $('.row-checkbox').prop('checked', this.checked);
            $('#delete-selected').show();
        });

        // Handle individual row checkbox changes
        $('.row-checkbox').on('change', function() {
            if ($('.row-checkbox:checked').length === $('.row-checkbox').length) {
                $('#delete-selected').show();
                $('#check-all').prop('checked', true);
            } else {
                $('#delete-selected').show();
                $('#check-all').prop('checked', false);
            }
        });

        // Handle the delete selected button click
        $('#delete-selected').on('click', function() {

            var selectedIds = $('.row-checkbox:checked').map(function() {
                return $(this).closest('tr').find('td:eq(1)').text(); // Assuming ID is in the second column
            }).get();

            $.ajax({
                url: '<?php echo base_url() . '/Customers/delete_bulk_customers' ?>',
                method: 'post',
                data: {
                    'alert_ids': selectedIds
                },
                success: function(data) {
                    console.log(data);
                    window.location = '<?php echo base_url() . '/Customers' ?>';
                }
            })
            dataTable.rows('.selected').remove().draw(false);
        });



    });
</script>

</html>