<?php

class Notifications_model extends CI_Model {

     function get_alerts_info() {
        return $this->db->get('smoad_alerts')->result();
     }

     
    function change_status($alert_id, $status)
    {

        if ($status == 'new') {
          $change_status = 'dismiss';
        } else {
          $change_status = 'new';
        }
        $data['status'] = $change_status;

        $this->db->where('id', $alert_id);
        $this->db->update('smoad_alerts', $data);

    }
    function getAlertsInfo()
    {
      return $this->db->get('smoad_alerts')->result();
    }
  
    function getAlertsCount()
    {
      return $this->db->query('select count(*) as total_cnt from smoad_alerts')->result();
    }

    function delete_list($id)
    {
 
       $this->db->delete('smoad_alerts', ['id' => $id]);
 
    }

    function get_alert_details($id)
    {
 
       $alert_list = $this->db->where('id', $id)->get('smoad_alerts')->result();
       return $alert_list;
 
    }

  //   function get_customers(){
  //     $customers = $this->db->where('access_level','customer')->order_by('id','asc')->get('smoad_users')->result();
  //     $all_customers = array();
  //     foreach($customers as $customer){

  //       $data['id'] = $customer->id;
  //       $data['name'] = $customer->name;
  //       $data['username'] = $customer->username;
  //       $data['area'] = $customer->area;
  //      // $data['id_user_access'] = $customer->id_user_access;

  //       $count_qry = $this->db->query("select count(*) as assigned_devices from smoad_devices WHERE customer_id=$customer->id ");

  //       $count = $count_qry->result();
  //       $data['assigned_devices'] = $count[0]->assigned_devices;
  //        array_push($all_customers,$data);
  //     }
  //      return $all_customers;
  //   }
    
  //  function save_customer($data) {

  //      $existing_customers = $this->db->get('smoad_users')->result();
  //      foreach($existing_customers as $customer){
  //       if($customer->username == $data['username']){
  //           return "exists";
  //       }
  //      }

  //       if($this->db->insert('smoad_users',$data)){
  //           return "true";
  //       } else {
  //           return "false";
  //       }

  //  }

  //  function delete_customer($id){

  //   if($this->db->delete('smoad_users',['id'=>$id])){
  //     return true;
  //   } else {
  //       return false;
  //   }
    
  //  }

  //  function get_customer_info($id){
  //      return $this->db->where('id',$id)->get('smoad_users')->result();
  //  }

  //  function update_customer($data,$id) {

  //   $this->db->where('id',$id);
  //   $this->db->update('smoad_users',$data);
  // //  return $this->db->get('smoad_users')->result();
  //  }


  //  function getCustomerDevices($id){
  //    $all_info['customer'] = $this->db->where('id',$id)->get('smoad_users')->result();
  //    $all_info['notset_devices'] = $this->db->where('customer_id','notset')->get('smoad_devices')->result();
  //    $all_info['assigned_devices'] = $this->db->where('customer_id',$id)->get('smoad_devices')->result();
  //    return $all_info;
  //  }

  //  function set_device($device_id,$customer_id,$status){

  //   if( $status == 'assign'){
  //      $data['customer_id']=$customer_id;
  //      $this->db->where('id',$device_id)->update('smoad_devices',$data);
  //      return 'assigned';
  //   }

  //   if( $status == 'unassign'){
  //       $data['customer_id']= 'notset';
  //       $this->db->where('id',$device_id)->update('smoad_devices',$data);
  //       return 'unassigned';
  //    }
    
  //  }

}

?>