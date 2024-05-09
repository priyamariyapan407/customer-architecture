<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a class="brand-link smoad-logo">
        <img src="<?php echo $CI->config->base_url(); ?>assets/dist/img/smoad_rect_logo_5g_white.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="float: none;border-radius: unset;box-shadow: none !important;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <?php

        $dashboard = $user = $customers = $gateway = $edge = $edge_menu = $home_menu = $status = $ztp_dev_lan = $ztp_dev_wireless = $wan1 = $wan2 = $lte1 = $lte2 = $ztp_dev_sdwan =  $ztp_dev_qos = $ztp_dev_qos_app_prio = $ztp_dev_agg = $ztp_dev_firmware = $ztp_dev_config =  $ztp_dev_consolidated_log = $ztp_dev_consolidated_report_index = $ztp_dev_debug_jobs = $update_firmware_server = $dev_config_templates = $devices_menu = $packets =  $firewall =  $security_menu = $security = $iplist = $log_index =  $alert_menu = $alerts = $alert_config = $alert_index =  $ims =  $network_menu = $networks = $uplink = $console = $engineering_menu = $engineering = $jobs = $notifications =  $network_menu = $engineering_menu = $alert_menu = $security_menu = $home_menu = $edge_menu = $wan3 = $lte3 = '';



        if ($this->uri->segment('2') == 'dashboard') {
            $dashboard = 'active';
        }  else if ($this->uri->segment('1') == 'Customers') {
            $customers = 'active';
        } 

        ?>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?php echo base_url('Welcome/dashboard') ?>" class="nav-link <?= $dashboard ? $dashboard : '' ?>">
                        <i class="nav-icon fa fa-home"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>
               
                <li class="nav-item">
                    <a href="<?php echo base_url('Customers') ?>" class="nav-link <?= $customers ? $customers : '' ?>">
                        <i class="nav-icon fa fa-user"></i>
                        <p>
                            Customers
                        </p>
                    </a>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<?php
function sm_get_device_port_branching_by_serialnumber($port)
{
    $model = get_session_model_data();
    $model_variant = get_session_model_variant_data();
    // echo $model.' test '.$model_variant;
    if ($port == "WAN") {    //wan1 port is there for all variants
        return true;
    } elseif ($port == "WAN2") {
        if (($model == 'vm' && $model_variant == "l2") || ($model == 'vm' && $model_variant == "l3") ||
            ($model == 'spider' && $model_variant == "l2") || ($model == 'spider' && $model_variant == "l3") ||
            ($model == 'spider2' && $model_variant == "l2") || ($model == 'spider2' && $model_variant == "l3") ||
            ($model == 'beetle' && $model_variant == "l2") || ($model == 'beetle' && $model_variant == "l3") ||
            ($model == 'bumblebee' && $model_variant == "l2") || ($model == 'bumblebee' && $model_variant == "l3")
        )
            return true;
    } elseif ($port == "WAN3") {
        if (($model == 'spider2' && $model_variant == "l3"))
            return true;
    } elseif ($port == "LTE1") {
        if (($model == 'spider' && $model_variant == "l2") || ($model == 'spider' && $model_variant == "l3") || ($model == 'spider' && $model_variant == "l2w1l2") ||
            ($model == 'spider2' && $model_variant == "l2") || ($model == 'spider2' && $model_variant == "l3") ||
            ($model == 'beetle' && $model_variant == "l2") || ($model == 'beetle' && $model_variant == "l3") ||
            ($model == 'bumblebee' && $model_variant == "l2") || ($model == 'bumblebee' && $model_variant == "l3")
        )
            return true;
    } elseif ($port == "LTE2") {
        if (($model == 'spider' && $model_variant == "l2") || ($model == 'spider' && $model_variant == "l3") || ($model == 'spider' && $model_variant == "l2w1l2") ||
            ($model == 'spider2' && $model_variant == "l2") || ($model == 'spider2' && $model_variant == "l3")
        )
            return true;
    } elseif ($port == "LTE3") {
        if (($model == 'spider2' && $model_variant == "l2") || ($model == 'spider2' && $model_variant == "l3"))
            return true;
    } elseif ($port == "LAN") {    //lan port is there for all variants
        return true;
    } elseif ($port == "WIRELESS") {    //wifi port is there for all variants
        return true;
    } elseif ($port == "SD-WAN") {    //sdwan port is there for all variants
        return true;
    }

    return false;
} /* sm_get_device_port_branching_by_serialnumber */

?>