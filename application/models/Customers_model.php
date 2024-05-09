<?php

class Customers_model extends CI_Model
{

    public function get_customers()
    {
        $customers     = $this->db->where('access_level', 'customer')->order_by('id', 'asc')->get('smoad_users')->result();
        $all_customers = array();
        foreach ($customers as $customer) {
            $data['id']               = $customer->id;
            $data['name']             = $customer->name;
            $data['username']         = $customer->username;
            $data['area']             = $customer->area;
            $count_qry                = $this->db->query("select count(*) as assigned_devices from smoad_devices WHERE customer_id=$customer->id ");
            $count                    = $count_qry->result();
            $data['assigned_devices'] = $count[0]->assigned_devices;
            array_push($all_customers, $data);
        }
        return $all_customers;
    }

    public function getAlertsInfo()
    {
        return $this->db->get('smoad_alerts')->result();
    }

    public function getAlertsCount()
    {
        return $this->db->query('select count(*) as total_cnt from smoad_alerts')->result();
    }

    public function save_customer($data)
    {

        $existing_customers = $this->db->get('smoad_users')->result();
        foreach ($existing_customers as $customer) {
            if ($customer->username == $data['username']) {
                return "exists";
            }
        }

        if ($this->db->insert('smoad_users', $data)) {
            return "true";
        } else {
            return "false";
        }

    }

    public function delete_customer($id)
    {

        if ($this->db->delete('smoad_users', ['id' => $id])) {
            return true;
        } else {
            return false;
        }

    }

    public function get_customer_info($id)
    {
        return $this->db->where('id', $id)->get('smoad_users')->result();
    }

    public function update_customer($data, $id)
    {

        $this->db->where('id', $id);
        $this->db->update('smoad_users', $data);
        //  return $this->db->get('smoad_users')->result();
    }

    public function getCustomerDevices($id)
    {
        $all_info['customer']         = $this->db->where('id', $id)->get('smoad_users')->result();
        $all_info['notset_devices']   = $this->db->where('customer_id', 'notset')->get('smoad_devices')->result();
        $all_info['assigned_devices'] = $this->db->where('customer_id', $id)->get('smoad_devices')->result();
        return $all_info;
    }

    public function set_device($device_id, $customer_id, $status)
    {

        if ($status == 'assign') {
            $data['customer_id'] = $customer_id;
            $this->db->where('id', $device_id)->update('smoad_devices', $data);
            return 'assigned';
        }

        if ($status == 'unassign') {
            $data['customer_id'] = 'notset';
            $this->db->where('id', $device_id)->update('smoad_devices', $data);
            return 'unassigned';
        }

    }

    public function get_device_info($sno)
    {
        return $this->db->where('serialnumber',$sno)->get('smoad_devices')->result();
    }

    public function get_logs_by_sno($G_device_serialnumber)
    {
        return $this->db->query("SELECT
        AVG(avg_lan_rx_bytes_rate) avg_lan_rx_bytes_rate, AVG(avg_lan_tx_bytes_rate) avg_lan_tx_bytes_rate,
        AVG(avg_wan1_rx_bytes_rate) avg_wan1_rx_bytes_rate, AVG(avg_wan1_tx_bytes_rate) avg_wan1_tx_bytes_rate,
        AVG(avg_wan2_rx_bytes_rate) avg_wan2_rx_bytes_rate, AVG(avg_wan2_tx_bytes_rate) avg_wan2_tx_bytes_rate,
        AVG(avg_lte1_rx_bytes_rate) avg_lte1_rx_bytes_rate, AVG(avg_lte1_tx_bytes_rate) avg_lte1_tx_bytes_rate,
        AVG(avg_lte2_rx_bytes_rate) avg_lte2_rx_bytes_rate, AVG(avg_lte2_tx_bytes_rate) avg_lte2_tx_bytes_rate,
        AVG(avg_lte3_rx_bytes_rate) avg_lte3_rx_bytes_rate, AVG(avg_lte3_tx_bytes_rate) avg_lte3_tx_bytes_rate,
        AVG(avg_sdwan_rx_bytes_rate) avg_sdwan_rx_bytes_rate, AVG(avg_sdwan_tx_bytes_rate) avg_sdwan_tx_bytes_rate,
        AVG(avg_wan1_latency) avg_wan1_latency, AVG(avg_wan1_jitter) avg_wan1_jitter,
        AVG(avg_wan2_latency) avg_wan2_latency, AVG(avg_wan2_jitter) avg_wan2_jitter,
        AVG(avg_lte1_latency) avg_lte1_latency, AVG(avg_lte1_jitter) avg_lte1_jitter,
        AVG(avg_lte2_latency) avg_lte2_latency, AVG(avg_lte2_jitter) avg_lte2_jitter,
        AVG(avg_lte3_latency) avg_lte3_latency, AVG(avg_lte3_jitter) avg_lte3_jitter,
        AVG(avg_sdwan_latency) avg_sdwan_latency, AVG(avg_sdwan_jitter) avg_sdwan_jitter,
        SUM(sum_lan_rx_bytes) sum_lan_rx_bytes, SUM(sum_lan_tx_bytes) sum_lan_tx_bytes,
        SUM(sum_wan1_rx_bytes) sum_wan1_rx_bytes, SUM(sum_wan1_tx_bytes) sum_wan1_tx_bytes,
        SUM(sum_wan2_rx_bytes) sum_wan2_rx_bytes, SUM(sum_wan2_tx_bytes) sum_wan2_tx_bytes,
        SUM(sum_lte1_rx_bytes) sum_lte1_rx_bytes, SUM(sum_lte1_tx_bytes) sum_lte1_tx_bytes,
        SUM(sum_lte2_rx_bytes) sum_lte2_rx_bytes, SUM(sum_lte2_tx_bytes) sum_lte2_tx_bytes,
        SUM(sum_lte3_rx_bytes) sum_lte3_rx_bytes, SUM(sum_lte3_tx_bytes) sum_lte3_tx_bytes,
        SUM(sum_sdwan_rx_bytes) sum_sdwan_rx_bytes, SUM(sum_sdwan_tx_bytes) sum_sdwan_tx_bytes,
        SUM(sum_link_status_wan_up_count) sum_link_status_wan1_up_count,
        SUM(sum_link_status_wan2_up_count) sum_link_status_wan2_up_count,
        SUM(sum_link_status_lte1_up_count) sum_link_status_lte1_up_count,
        SUM(sum_link_status_lte2_up_count) sum_link_status_lte2_up_count,
        SUM(sum_link_status_lte3_up_count) sum_link_status_lte3_up_count,
        SUM(sum_link_status_sdwan_up_count) sum_link_status_sdwan_up_count,
        SUM(sum_link_status_wan_down_count) sum_link_status_wan1_down_count,
        SUM(sum_link_status_wan2_down_count) sum_link_status_wan2_down_count,
        SUM(sum_link_status_lte1_down_count) sum_link_status_lte1_down_count,
        SUM(sum_link_status_lte2_down_count) sum_link_status_lte2_down_count,
        SUM(sum_link_status_lte3_down_count) sum_link_status_lte3_down_count,
        SUM(sum_link_status_sdwan_down_count) sum_link_status_sdwan_down_count,
        SUM(sum_link_status_wan_repeat_up_count) as sum_link_status_wan1_repeat_up_count,
        SUM(sum_link_status_wan2_repeat_up_count) as sum_link_status_wan2_repeat_up_count,
        SUM(sum_link_status_wan3_repeat_up_count) as sum_link_status_wan3_repeat_up_count,
        SUM(sum_link_status_lte1_repeat_up_count) as sum_link_status_lte1_repeat_up_count,
        SUM(sum_link_status_lte2_repeat_up_count) as sum_link_status_lte2_repeat_up_count,
        SUM(sum_link_status_lte3_repeat_up_count) as sum_link_status_lte3_repeat_up_count,
        SUM(sum_link_status_sdwan_repeat_up_count) as sum_link_status_sdwan_repeat_up_count,
        SUM(sum_link_status_any_repeat_up_count) as sum_link_status_any_repeat_up_count,
        COUNT(log_timestamp) as count_log_timestamp
        FROM smoad_device_consolidated_stats_log
        WHERE device_serialnumber=\"$G_device_serialnumber\"")->result();
    }

}
