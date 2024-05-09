<?php

class Admin_model extends CI_Model
{

    public function checkPassword($username, $password)
    {
        // $query = $this->db->query("select * from profile where username='$username' and password='$password'");
        $login = false;
        // if ($query->num_rows() == 1) {
        //   $login = true;
        //   $this->session->set_userdata('accesslevel', 'root');
        //   return $query->row();
        // }
        // if ($login == false) {
        $query = $this->db->query("select * from smoad_users where username='$username' and password='$password'");
        if ($query->num_rows() == 1) {
            $login     = true;
            $user_data = $query->result();
            foreach ($user_data as $data) {
                $this->session->set_userdata('accesslevel', $data->access_level);
                if ($data->access_level == 'customer') {
                    $this->session->set_userdata('customer_id', $data->id);
                }
            }

            return $query->row();
        }
        // }

        // if ($login == false) {
        //   $query = $this->db->query("select * from smoad_customers where custname='$username' and password='$password'");
        //   if ($query->num_rows() == 1) {
        //     $cust_data = $query->result();
        //     $login = true;
        //     $this->session->set_userdata('accesslevel', 'customer');
        //     $this->session->set_userdata('customerId', $cust_data[0]->id);
        //    return $query->row();
        //   }
        // }

        if ($login == false) {
            return false;
        }

    }

    public function getServerInfo()
    {
        return $this->db->where('id', '1')->get('profile')->result();
    }

    public function getAlertsInfo()
    {
        return $this->db->get('smoad_alerts')->result();
    }

    public function getAlertsCount()
    {
        return $this->db->query('select count(*) as total_cnt from smoad_alerts')->result();
    }

    public function getNetworkInfo()
    {
        $netwokInfo = $this->db->query("SELECT AVG(wan1_rx_bytes_rate) wan1_rx, AVG(wan2_rx_bytes_rate) wan2_rx,
      AVG(lte1_rx_bytes_rate) lte1_rx, AVG(lte2_rx_bytes_rate) lte2_rx,
      AVG(wan1_tx_bytes_rate) wan1_tx, AVG(wan2_tx_bytes_rate) wan2_tx,
      AVG(lte1_tx_bytes_rate) wan1_tx, AVG(lte2_tx_bytes_rate) lte2_tx,
      AVG(sdwan_rx_bytes_rate) sdwan_rx, AVG(sdwan_tx_bytes_rate) sdwan_tx ,
      count(wan1_rx_drop) wan1_rx_drop, count(wan2_rx_drop) wan2_rx_drop,
      count(lte1_rx_drop) lte1_rx_drop, count(lte2_rx_drop) lte2_rx_drop,
      count(wan1_tx_drop) wan1_tx_drop, count(wan2_tx_drop) wan2_tx_drop,
      count(lte1_tx_drop) lte1_tx_drop, count(lte2_tx_drop) lte2_tx_drop,
      count(sdwan_rx_drop) sdwan_rx_drop, count(sdwan_tx_drop) sdwan_tx_drop,
      AVG(wan1_latency) wan1, AVG(wan2_latency) wan2, AVG(lte1_latency) lte1, AVG(lte2_latency) lte2,AVG(sdwan_latency) sdwan_lt,
      AVG(wan1_jitter) wan1_jitter, AVG(wan2_jitter) wan2_jitter, AVG(lte1_jitter) lte1_jitter, AVG(lte2_jitter) lte2_jitter
      FROM smoad_device_network_stats_log ");
        return $netwokInfo->result();
    }

    public function getGatewayCount()
    {
        $query    = $this->db->query('select count(*) as gw_cnt from smoad_sdwan_servers');
        $gw_count = $query->result();
        return $gw_count[0]->gw_cnt;
    }

    public function donutChart1()
    {
        $query = $this->db->query('select count(*) as quantity,status from smoad_sdwan_servers group by status');
        return $query->result();
    }

    public function donutChart2()
    {
        $query = $this->db->query('select count(*) as quantity,type from smoad_sdwan_servers group by type');
        return $query->result();
    }

    public function donutChart3()
    {
        $query = $this->db->query('select count(*) as quantity,sdwan_proto from smoad_sdwan_servers group by sdwan_proto');
        return $query->result();
    }

    public function getEdgeDeviceCount()
    {
        $query    = $this->db->query("select count(*) as edge_count FROM smoad_devices");
        $edge_cnt = $query->result();
        return $edge_cnt[0]->edge_count;
    }

    public function donutChart4()
    {
        $query = $this->db->query('select count(*) as quantity,status from smoad_devices group by status');
        return $query->result();
    }

    public function donutChart5()
    {
        $query = $this->db->query('select count(*) as quantity,model from smoad_devices group by model');
        return $query->result();
    }

    public function donutChart6()
    {
        $query = $this->db->query("select sum( CASE when (wan_link_status='up' or wan2_link_status='up' or wan3_link_status='up')
                                                and (lte1_link_status='down' or lte1_link_status='notset')
                                                and (lte2_link_status='down' or lte2_link_status='notset')
                                                and (lte3_link_status='down' or lte3_link_status='notset')  THEN 1 ELSE 0 END) as wan_up,
                                       sum( CASE when (lte1_link_status='up' or lte2_link_status='up' or lte3_link_status='up')
                                                and (wan_link_status='down' or wan_link_status='notset')
                                                and (wan2_link_status='down' or wan2_link_status='notset')
                                                and (wan3_link_status='down' or wan3_link_status='notset')  THEN 1 ELSE 0 END) as lte_up,
                                       sum(CASE when (wan_link_status='up' or wan2_link_status='up' or wan3_link_status='up')
                                                and (lte1_link_status='up' or lte2_link_status='up' or lte3_link_status='up') THEN 1 ELSE 0 END) as wan_lte_up,
                                       sum(CASE when (wan_link_status='down' or wan_link_status='notset')
                                                and (wan2_link_status='down' or wan2_link_status='notset')
                                                and (wan3_link_status='down' or wan3_link_status='notset')
                                                and (lte1_link_status='down' or lte1_link_status='notset')
                                                and (lte2_link_status='down' or lte2_link_status='notset')
                                                and (lte3_link_status='down' or lte3_link_status='notset') THEN 1 ELSE 0 END) as wan_lte_down
                               FROM smoad_device_network_cfg");
        return $query->result();
    }

    public function get_linked_Devices($port)
    {
        if ($port == 'wan_up') {
            $smoad_device_network_cfg_qry = $this->db->query("select device_serialnumber from  smoad_device_network_cfg where (wan_link_status='up' or wan2_link_status='up' or wan3_link_status='up')
      and (lte1_link_status='down' or lte1_link_status='notset')
      and (lte2_link_status='down' or lte2_link_status='notset')
      and (lte3_link_status='down' or lte3_link_status='notset') ")->result();
        } elseif ($port == 'lte_up') {
            $smoad_device_network_cfg_qry = $this->db->query("select device_serialnumber from  smoad_device_network_cfg where (lte1_link_status='up' or lte2_link_status='up' or lte3_link_status='up')
      and (wan_link_status='down' or wan_link_status='notset')
      and (wan2_link_status='down' or wan2_link_status='notset')
      and (wan3_link_status='down' or wan3_link_status='notset') ")->result();
        } elseif ($port == 'wan_lte_up') {
            $smoad_device_network_cfg_qry = $this->db->query("select device_serialnumber from  smoad_device_network_cfg where (wan_link_status='up' or wan2_link_status='up' or wan3_link_status='up')
      and (lte1_link_status='up' or lte2_link_status='up' or lte3_link_status='up') ")->result();
        } elseif ($port == 'wan_lte_down') {
            $smoad_device_network_cfg_qry = $this->db->query("select device_serialnumber from  smoad_device_network_cfg where (wan_link_status='down' or wan_link_status='notset')
      and (wan2_link_status='down' or wan2_link_status='notset')
      and (wan3_link_status='down' or wan3_link_status='notset')
      and (lte1_link_status='down' or lte1_link_status='notset')
      and (lte2_link_status='down' or lte2_link_status='notset')
      and (lte3_link_status='down' or lte3_link_status='notset') ")->result();
        }
        $serialNumbers = [];
        if (!empty($smoad_device_network_cfg_qry)) {
            foreach ($smoad_device_network_cfg_qry as $object) {
                $serialNumbers[] = $object->device_serialnumber;
            }

            // print_r($serialNumbers);
            // exit;

            $devices = $this->db->where_in('serialnumber', $serialNumbers)->order_by('id', 'desc')->get('smoad_devices')->result();

            $devices_info = array();

            foreach ($devices as $device) {
                $data['id']              = $device->id;
                $data['details']         = $device->details;
                $data['license']         = $device->license;
                $data['serialnumber']    = $device->serialnumber;
                $data['status']          = $device->status;
                $data['sdwan_server_id'] = $device->sdwan_server_id;
                $model                   = $device->model;
                if ($model == "spider") {
                    $_model = "Spider";
                } elseif ($model == "spider2") {
                    $_model = "Spider2";
                } elseif ($model == "beetle") {
                    $_model = "Beetle";
                } elseif ($model == "bumblebee") {
                    $_model = "BumbleBee";
                } elseif ($model == "wasp1") {
                    $_model = "Wasp1";
                } elseif ($model == "wasp2") {
                    $_model = "Wasp2";
                } elseif ($model == "vm") {
                    $_model = "VM";
                } elseif ($model == "soft_client") {
                    $_model = "Soft-client";
                } else {
                    $_model = '';
                }

                $data['model'] = $_model ? $_model : '';
                $model_variant = $device->model_variant;
                if ($model_variant == "l2") {
                    $_model_variant = "L2 SD-WAN";
                } elseif ($model_variant == "l2w1l2") {
                    $_model_variant = "L2 SD-WAN (L2W1L2)";
                } elseif ($model_variant == "l3") {
                    $_model_variant = "L3 SD-WAN";
                } elseif ($model_variant == "mptcp") {
                    $_model_variant = "MPTCP";
                } else {
                    $_model_variant = '';
                }

                $data['model_variant'] = $_model_variant ? $_model_variant : '';
                $data['area']          = $device->area;
                // $data['sdwan_server_ipaddr'] = $device->sdwan_server_ipaddr;
                // $data['vlan_id'] = $device->vlan_id;
                // $data['enable'] = $device->enable;
                // $data['updated'] = $device->updated;
                $data['server_details'] = '';
                $data['server_id']      = '';
                $data['server_sno']     = '';
                $server_details         = $this->db->where('id', $device->sdwan_server_id)->get('smoad_sdwan_servers')->result();

                foreach ($server_details as $details) {
                    $data['server_details'] = $details->details ? $details->details : '';
                    $data['server_id']      = $details->id ? $details->id : '';
                    $data['server_sno']     = $details->serialnumber ? $details->serialnumber : '';
                }
                array_push($devices_info, $data);

            }} else {
            $devices_info = [];
        }

        return $devices_info;

    }

    public function donutChart7()
    {
        $query = $this->db->query('select count(*) as quantity,sdwan_proto from smoad_devices group by sdwan_proto');
        return $query->result();
    }

    public function donutChart8()
    {
        $query               = $this->db->query("select count(*) qty FROM smoad_devices where sdwan_server_ipaddr<>'notset'");
        $not_equal_to_notset = $query->result()[0]->qty;
        $query2              = $this->db->query("select count(*) qty FROM smoad_devices where sdwan_server_ipaddr='notset'");
        $equal_to_notset     = $query2->result()[0]->qty;
        $values              = array();
        array_push($values, ['not_equal_to_notset' => $not_equal_to_notset, 'equal_to_notset' => $equal_to_notset]);
        return $values;
    }

    public function circuitSummary()
    {
        $query = $this->db->query(" select * from smoad_sdwan_servers");
        //return $query->result();

        $sdwan_results = $query->result();

        $sdwan_data = array();

        foreach ($sdwan_results as $sdwan_result) {
            $peer_qry = $this->db->query("select count(*) as total_cnt,sum( CASE when sdwan_link_status='UP' THEN 1 ELSE 0 END) as up_count, sum(CASE WHEN sdwan_link_status='DOWN' THEN 1 ELSE 0 END) as down_count from smoad_sds_wg_peers where serialnumber='$sdwan_result->serialnumber'");

            $peer_qry_result = $peer_qry->result();

            array_push($sdwan_data, ['serialnumber' => $sdwan_result->serialnumber, 'ipaddr' => $sdwan_result->ipaddr, 'details' => $sdwan_result->details, 'total_cnt' => $peer_qry_result[0]->total_cnt, 'up_count' => $peer_qry_result[0]->up_count, 'down_count' => $peer_qry_result[0]->down_count]);

        }

        return $sdwan_data;

    }

    public function firmwareSummary()
    {
        $smoad_update_firmware_server = $this->db->query('select update_firmware_release_version from smoad_update_firmware_server');
        $firmware_data                = $smoad_update_firmware_server->result();
        $count_array                  = array();
        $total_device_count           = '';
        $updated_cnt                  = '';
        foreach ($firmware_data as $server) {
            $device_qry         = $this->db->query("select count(*) as total_cnt,sum(CASE when firmware='$server->update_firmware_release_version' THEN 1 ELSE 0 END) as updated from smoad_devices");
            $device_result      = $device_qry->result();
            $total_device_count = $device_result[0]->total_cnt;
            $updated_cnt        = $device_result[0]->updated;
        }
        $pending_cnt = ($total_device_count - $updated_cnt);
        array_push($count_array, ['updated_cnt' => $updated_cnt, 'pending_cnt' => $pending_cnt]);
        return $count_array;
    }

    public function linkReliabilityCounts()
    {
        $query = $this->db->query("select device_serialnumber, sum(link_status_wan_up_count+link_status_wan2_up_count+link_status_lte1_up_count+link_status_lte2_up_count+link_status_lte3_up_count) as up_count,sum(link_status_wan_down_count+link_status_wan2_down_count+link_status_lte1_down_count+link_status_lte2_down_count+link_status_lte3_down_count) as down_count  from smoad_device_status_log where log_timestamp > (NOW() - INTERVAL 24 HOUR) GROUP by device_serialnumber");
        // $query = $this->db->query("select device_serialnumber, sum(link_status_wan_up_count+link_status_wan2_up_count+link_status_lte1_up_count+link_status_lte2_up_count+link_status_lte3_up_count) as up_count,sum(link_status_wan_down_count+link_status_wan2_down_count+link_status_lte1_down_count+link_status_lte2_down_count+link_status_lte3_down_count) as down_count from smoad_device_status_log  GROUP by device_serialnumber");
        $status_log_result = $query->result();
        $login_type        = $this->session->userdata('accesslevel');
        $id_customer       = $this->session->userdata('customerId');

        $smoad_devices_array = array();

        foreach ($status_log_result as $log) {
            $device_serialnumber = $log->device_serialnumber;
            $up_count            = $log->up_count;
            $down_count          = $log->down_count;
            if ($login_type == 'root' || $login_type == 'admin' || $login_type == 'limited') {
                $where_clause = "";
            } else {
                $where_clause = "and customer_id = $id_customer ";
            }
            $devices_qry = $this->db->query("select id, details, serialnumber, model, area from smoad_devices where serialnumber='$device_serialnumber' $where_clause");
            $device_data = $devices_qry->result();

            foreach ($device_data as $data) {

                $info['id']           = $data->id;
                $info['details']      = $data->details;
                $info['serialnumber'] = $data->serialnumber;
                $info['model']        = $data->model;
                $info['area']         = $data->area;
                $info['up_count']     = $up_count;
                $info['down_count']   = $down_count;

                if ($info['model'] == "spider") {
                    $info['model'] = "Spider";
                } elseif ($info['model'] == "beetle") {
                    $info['model'] = "Beetle";
                } elseif ($info['model'] == "vm") {
                    $info['model'] = "VM";
                }

                array_push($smoad_devices_array, $info);

            }

        }
        return $smoad_devices_array;
    }

    public function sdwanLatency()
    {

        $query = $this->db->query("SELECT device_serialnumber,AVG(sdwan_latency) AS latency FROM smoad_device_network_stats_log where  log_timestamp > (NOW() - INTERVAL 60 MINUTE) GROUP BY device_serialnumber  ORDER BY latency DESC LIMIT 5");

        // $query = $this->db->query("SELECT device_serialnumber,AVG(sdwan_latency) AS latency, AVG(sdwan_jitter) jitter FROM smoad_device_network_stats_log  GROUP BY device_serialnumber  ORDER BY latency DESC LIMIT 5");
        $status_log_result = $query->result();
        $login_type        = $this->session->userdata('accesslevel');
        $id_customer       = $this->session->userdata('customerId');

        $smoad_devices_array = array();

        foreach ($status_log_result as $log) {
            $device_serialnumber = $log->device_serialnumber;
            $latency             = $log->latency;
            $latency             = round($latency, 1);
            $latency             = number_format($latency, 1);
            $jitter              = $log->jitter;
            $jitter              = round($jitter, 1);
            $jitter              = number_format($jitter, 1);
            if ($login_type == 'root' || $login_type == 'admin' || $login_type == 'limited') {
                $where_clause = "";
            } else {
                $where_clause = "and customer_id = $id_customer ";
            }
            $devices_qry = $this->db->query("select id, details, serialnumber, model, area from smoad_devices where serialnumber=\"$device_serialnumber\" $where_clause");
            $device_data = $devices_qry->result();

            foreach ($device_data as $data) {

                $info['id']           = $data->id;
                $info['details']      = $data->details;
                $info['serialnumber'] = $data->serialnumber;
                $info['model']        = $data->model;
                $info['area']         = $data->area;
                $info['latency']      = $latency;
                $info['jitter']       = $jitter;

                if ($info['model'] == "spider") {
                    $info['model'] = "Spider";
                } elseif ($info['model'] == "beetle") {
                    $info['model'] = "Beetle";
                } elseif ($info['model'] == "vm") {
                    $info['model'] = "VM";
                }

                array_push($smoad_devices_array, $info);

            }

        }
        return $smoad_devices_array;

    }

    public function sdWanLinkUsage()
    {

        // $query = $this->db->query("SELECT device_serialnumber,AVG(sdwan_latency) AS latency FROM smoad_device_network_stats_log where  log_timestamp > (NOW() - INTERVAL 5 MINUTE) GROUP BY device_serialnumber  ORDER BY latency DESC LIMIT 5");

        $query = $this->db->query("select device_serialnumber,sdwan_link_high_usage_threshold sdwan_link_status FROM smoad_device_network_cfg
    where sdwan_link_high_usage='high' and sdwan_link_status='up'");
        $status_log_result   = $query->result();
        $smoad_devices_array = array();
        foreach ($status_log_result as $result) {
            $serialnumber                    = $result->device_serialnumber;
            $sdwan_link_high_usage_threshold = $result->sdwan_link_high_usage_threshold;
            $stats_log_qry                   = $this->db->query("SELECT AVG(sdwan_rx_bytes_rate) avg_sdwan_rx_bytes_rate, AVG(sdwan_tx_bytes_rate) avg_sdwan_tx_bytes_rate,
			SUM(sdwan_rx_bytes) sum_sdwan_rx_bytes, SUM(sdwan_tx_bytes) sum_sdwan_tx_bytes FROM smoad_device_network_stats_log
			 and device_serialnumber=\"$serialnumber\"");

            // $stats_log_qry = $this->db->query("SELECT AVG(sdwan_rx_bytes_rate) avg_sdwan_rx_bytes_rate, AVG(sdwan_tx_bytes_rate) avg_sdwan_tx_bytes_rate,
            // SUM(sdwan_rx_bytes) sum_sdwan_rx_bytes, SUM(sdwan_tx_bytes) sum_sdwan_tx_bytes FROM smoad_device_network_stats_log
            // WHERE time(log_timestamp) > TIME(NOW() - INTERVAL 5 MINUTE) and device_serialnumber=\"$serialnumber\"");

            $stats_log = $stats_log_qry->result();

            foreach ($stats_log as $log) {
                $avg_sdwan_rx_bytes_rate = $log->avg_sdwan_rx_bytes_rate;
                $avg_sdwan_tx_bytes_rate = $log->avg_sdwan_tx_bytes_rate;
                $sum_sdwan_rx_bytes      = $log->sum_sdwan_rx_bytes;
                $sum_sdwan_tx_bytes      = $log->sum_sdwan_tx_bytes;
            }

            $avg_sdwan_rx_bytes_rate = $avg_sdwan_rx_bytes_rate / 1000;
            $avg_sdwan_tx_bytes_rate = $avg_sdwan_tx_bytes_rate / 1000;
            $avg_sdwan_rx_bytes_rate = number_format($avg_sdwan_rx_bytes_rate, 2);
            $avg_sdwan_tx_bytes_rate = number_format($avg_sdwan_tx_bytes_rate, 2);

            $login_type  = $this->session->userdata('accesslevel');
            $id_customer = $this->session->userdata('customerId');
            if ($login_type == 'root' || $login_type == 'admin' || $login_type == 'limited') {
                $where_clause = "";
            } else {
                $where_clause = "and customer_id = $id_customer ";
            }
            $devices_qry                     = $this->db->query("select id, details, serialnumber, model, area from smoad_devices where serialnumber=\"$serialnumber\" $where_clause");
            $device_data                     = $devices_qry->result();
            $sdwan_link_high_usage_threshold = number_format($sdwan_link_high_usage_threshold, 2);
            foreach ($device_data as $data) {
                $info['id']                              = $data->id;
                $info['details']                         = $data->details;
                $info['serialnumber']                    = $data->serialnumber;
                $info['model']                           = $data->model;
                $info['area']                            = $data->area;
                $info['avg_sdwan_rx_bytes_rate']         = $avg_sdwan_rx_bytes_rate;
                $info['avg_sdwan_tx_bytes_rate']         = $avg_sdwan_tx_bytes_rate;
                $info['sdwan_link_high_usage_threshold'] = $sdwan_link_high_usage_threshold;

                if ($info['model'] == "spider") {
                    $info['model'] = "Spider";
                } elseif ($info['model'] == "beetle") {
                    $info['model'] = "Beetle";
                } elseif ($info['model'] == "vm") {
                    $info['model'] = "VM";
                }
                array_push($smoad_devices_array, $info);
            }

        }

        return $smoad_devices_array;

        // $smoad_devices_array = array();

        // foreach($status_log_result as $log){
        //  $device_serialnumber = $log->device_serialnumber;
        //  $latency = $log->latency;
        //  $latency = round($latency,1); $latency = number_format($latency, 1);
        //  $jitter = $log->jitter;
        //     $jitter = round($jitter,1); $jitter = number_format($jitter, 1);
        //  if($login_type == 'root' || $login_type=='admin' || $login_type=='limited'){
        //   $where_clause="";
        //   } else {
        //     $where_clause="and customer_id = $id_customer ";
        //   }
        //   $devices_qry = $this->db->query("select id, details, serialnumber, model, area from smoad_devices where serialnumber=\"$device_serialnumber\" $where_clause");
        //   $device_data = $devices_qry->result();

        //   foreach($device_data as $data){

        //     $info['id'] = $data->id;
        //         $info['details'] = $data->details;
        //         $info['serialnumber'] = $data->serialnumber;
        //         $info['model'] = $data->model;
        //         $info['area'] = $data->area;
        //     $info['latency'] = $latency;
        //     $info['jitter'] = $jitter;

        //         if($info['model'] =="spider") { $info['model'] ="Spider"; }
        //         else if($info['model'] =="beetle") { $info['model'] ="Beetle"; }
        //         else if($info['model'] =="vm") { $info['model'] ="VM"; }

        //     array_push($smoad_devices_array,$info);

        //   }

        // }

    }

    public function update_server_name($data)
    {
        return $this->db->where("id", 1)->update('profile', $data);
    }

}
