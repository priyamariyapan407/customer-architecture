<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Smoad| Dashboard</title>
  <!-- Google Font: Source Sans Pro -->
  <?php $CI =& get_instance(); ?>

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="                                  <?php echo $CI->config->base_url(); ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet"  href="                                   <?php echo $CI->config->base_url(); ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="                                  <?php echo $CI->config->base_url(); ?>assets/plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet"  href="                                   <?php echo $CI->config->base_url(); ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="                                  <?php echo $CI->config->base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="                                  <?php echo $CI->config->base_url(); ?>assets/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $CI->config->base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $CI->config->base_url(); ?>assets/dist/css/adminlte.min.css">
  <link rel="stylesheet"
    href="<?php echo $CI->config->base_url(); ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet"
    href="<?php echo $CI->config->base_url(); ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet"
    href="<?php echo $CI->config->base_url(); ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<link rel="stylesheet"href="<?php echo $CI->config->base_url(); ?>assets/plugins/styles.css">

  <!-- jQuery -->
  <script src="                <?php echo $CI->config->base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="                <?php echo $CI->config->base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="                <?php echo $CI->config->base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>
  <!-- AdminLTE App -->
  <script src="                <?php echo $CI->config->base_url(); ?>assets/dist/js/adminlte.min.js"></script>
  <!-- DataTables  & Plugins -->

  <script
    src="          <?php echo $CI->config->base_url(); ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="                <?php echo $CI->config->base_url(); ?>assets/plugins/jszip/jszip.min.js"></script>
  <script src="                <?php echo $CI->config->base_url(); ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="                <?php echo $CI->config->base_url(); ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
  <script
    src="          <?php echo $CI->config->base_url(); ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script
    src="          <?php echo $CI->config->base_url(); ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script
    src="          <?php echo $CI->config->base_url(); ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="<?php echo $CI->config->base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo $CI->config->base_url(); ?>assets/plugins/sparklines/sparkline.js"></script>
    <!-- Sparkline -->
<script src="<?php echo $CI->config->base_url(); ?>assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo $CI->config->base_url(); ?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo $CI->config->base_url(); ?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo $CI->config->base_url(); ?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo $CI->config->base_url(); ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo $CI->config->base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo $CI->config->base_url(); ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js">
</script>
<!-- Summernote -->
<script src="<?php echo $CI->config->base_url(); ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo $CI->config->base_url(); ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js">
</script>
<!-- AdminLTE App -->
<script src="<?php echo $CI->config->base_url(); ?>assets/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo $CI->config->base_url(); ?>assets/dist/js/pages/dashboard.js"></script>

<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>

<!-- DataTables  & Plugins -->
<script src="<?php echo $CI->config->base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $CI->config->base_url(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js">
</script>
<script src="<?php echo $CI->config->base_url(); ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js">
</script>
<script src="<?php echo $CI->config->base_url(); ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js">
</script>
<script src="<?php echo $CI->config->base_url(); ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js">
</script>
<script src="<?php echo $CI->config->base_url(); ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js">
</script>
  <!-- AdminLTE for demo purposes -->
  <!-- Page specific script -->

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="                                          <?php echo $CI->config->base_url(); ?>assets/dist/img/smoad_logo.jpg"
        alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <!-- Left navbar links -->

      <!-- <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="                                                            <?php echo $CI->config->base_url(); ?>assets/#"
            role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul> -->
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- user login -->
        <li class="nav-item">
          <a class="nav-link loggedin_user" href="#" role="button">
            <i class="fas fa-user"></i><i class="logged_in_user"> <span>
                <?php echo $this->session->userdata('accesslevel'); ?>
              </span>
            </i>
          </a>


        </li>

        <?php $cnt = 0;foreach ($alerts_cnt as $info) {$cnt = $info->total_cnt;} ?>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge"><?=$cnt; ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right notification_bar " style="max-width: unset !important;">
            <span class="dropdown-item dropdown-header">  <?=$cnt . 'Notifications'; ?></span>
            <div class="dropdown-divider"></div>
          <?php $count = 0;foreach ($alerts_info as $info) {++$count;if ($count == 6) {break;} ?>
            <a  class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> <?=$info->title; ?>
              <span class="float-right text-muted text-sm"> <?=$info->log_timestamp; ?> </span>
            </a>
            <div class="dropdown-divider" style="margin-top: 5%;"></div>
            <?php } ?>
            <!-- <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a> -->
            <div class="dropdown-divider"></div>
            <a href="<?php echo base_url('Notifications/index'); ?>" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $CI->config->base_url(); ?>" role="button">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>
      </ul>

    </nav>


    </head>