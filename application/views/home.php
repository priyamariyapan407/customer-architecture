<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Smoad Server</title>
 
  <?php $CI =& get_instance(); ?>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"href="<?php echo $CI->config->base_url(); ?>assets/plugins/styles.css">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $CI->config->base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet"
    href="<?php echo $CI->config->base_url(); ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $CI->config->base_url(); ?>assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">

      <img class="login_page_logo" src=" <?php echo $CI->config->base_url(); ?>assets/dist/img/smoad_rect_logo_5g.png"
        alt="AdminLTELogo" height="60" width="60">
    </div>
    <!-- /.login-logo -->
    <div class="card"> 
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="<?= base_url('Welcome/admin_login') ?>" method="post">
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="User name">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">

            <!-- /.col -->
            <div class="col">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <?php
        if ($this->session->flashdata('success')) { ?>
          <p class='alert alert-danger error_msg' role="alert">
            <?= $this->session->flashdata('success'); ?>
          </p>
        <?php } ?>
        <?php
        if ($this->session->flashdata('error')) { ?>
          <p class='alert alert-danger error_msg' role="alert">
            <?= $this->session->flashdata('error'); ?>
          </p>
        <?php } ?>


      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?php echo $CI->config->base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo $CI->config->base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo $CI->config->base_url(); ?>assets/dist/js/adminlte.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/assets//bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>