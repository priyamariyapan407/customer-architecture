<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Notifications_model');
    }

    public function index(){
        $logged_in = $this->session->userdata('logged_in');

        if (!($logged_in)) {
            redirect(base_url('/'));
        }
        $data['alerts_info'] = $this->Notifications_model->get_alerts_info();
        $data['alerts_info'] = $this->Notifications_model->getAlertsInfo();
		$data['alerts_cnt'] = $this->Notifications_model->getAlertsCount();
       // echo "<pre>";print_r($data);exit;
        $this->load->view('notifications/index',$data);
    }

    public function change_status(){
        $alert_id = $this->input->post('alert_id');
        $status = $this->input->post('status');
        $this->Notifications_model->change_status($alert_id,$status);
     }

     public function delete_single_list(){
        $delete_list_id = $this->input->post('alert_id');
        $this->Notifications_model->delete_list($delete_list_id);
     }

     public function alert_details(){
        $list_id = $this->uri->segment('3');
        $data['list_details'] = $this->Notifications_model->get_alert_details($list_id);
        $data['alerts_info'] = $this->Notifications_model->getAlertsInfo();
		$data['alerts_cnt'] = $this->Notifications_model->getAlertsCount();
        $this->load->view('notifications/alert_details',$data);
     }

     public function delete_list(){
        $delete_list_id = $this->input->post('alert_ids');
        for($i=0;$i<count($delete_list_id);$i++){
           $this->Notifications_model->delete_list($delete_list_id[$i]);
        }
       
     }
   

}

?>