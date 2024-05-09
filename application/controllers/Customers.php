<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Customers extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Customers_model');
        $this->load->helper('file');
        $this->load->library('FPDF');
    }

    public function index(){
        $logged_in = $this->session->userdata('logged_in');

        if (!($logged_in)) {
            redirect(base_url('/'));
        }
        $data['customers_info'] = $this->Customers_model->get_customers();
        $data['alerts_info'] = $this->Customers_model->getAlertsInfo();
        $data['alerts_cnt'] = $this->Customers_model->getAlertsCount();
        //echo "<pre>";print_r($data);exit;
        $this->load->view('customer/index',$data);
    }

    public function save_customer(){

        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('username','customer Name','required');
        $this->form_validation->set_rules('password','Password','required');
        $this->form_validation->set_rules('addr1','Address-1','required');
        $this->form_validation->set_rules('addr2','Address-2','required');
        $this->form_validation->set_rules('area','Area','required');
        
        if($this->form_validation->run() == false){
            $this->session->set_flashdata('error_msgs',validation_errors());
            redirect('Customers/add_customer');
        } 

        $data['name'] = $this->input->post('name');
        $data['username'] = $this->input->post('username');
        $data['password'] = $this->input->post('password');
        $data['addr1'] = $this->input->post('addr1');
        $data['addr2'] = $this->input->post('addr2');
        $data['area'] = $this->input->post('area');
        $data['access_level'] = 'customer';
        
        $status = $this->Customers_model->save_customer($data);

        if($status == "true"){
            $this->session->set_flashdata('success_msg','The customer has been added successfully');
        } else if($status == "exists"){
            $this->session->set_flashdata('error_msgs','Found already matching customer name. So cannot creating this new customer!');
        } else {
            $this->session->set_flashdata('error_msgs','There is a problem in adding a customer. Please try again later.');
        }
        
        redirect('Customers/index');
        
    }

    public function delete_customer() {
        $id = $this->input->post('customer_id');
        $status = $this->Customers_model->delete_customer($id);
        if($status == true) {
            $this->session->set_flashdata('delete_msg_success','The customer has been deleted successfully');
        } else {
            $this->session->set_flashdata('delete_msg_failure','There is a problem in deleting a customer. Please try again later.');
        }
    }
    public function delete_bulk_customers() {

        $delete_list_id = $this->input->post('alert_ids');
        for($i=0;$i<count($delete_list_id);$i++){
        $this->Customers_model->delete_customer($delete_list_id[$i]);
        }
        $this->session->set_flashdata('delete_msg_success','The selected Users has been deleted successfully');
       
    }

    public function view_customer(){

       $id = $this->uri->segment('3');
       $data['customer_info'] =  $this->Customers_model->get_customer_info($id);
       $data['alerts_info'] = $this->Customers_model->getAlertsInfo();
       $data['alerts_cnt'] = $this->Customers_model->getAlertsCount();
       $this->load->view('customer/view_customer',$data);
       
    }

    public function add_customer(){
        $data['alerts_info'] = $this->Customers_model->getAlertsInfo();
        $data['alerts_cnt'] = $this->Customers_model->getAlertsCount();
        $this->load->view('customer/add_customer',$data);
    }

    public function update_customer(){

        $id = $this->uri->segment('3');
        $data['customer_info'] =  $this->Customers_model->get_customer_info($id);
        $data['alerts_info'] = $this->Customers_model->getAlertsInfo();
        $data['alerts_cnt'] = $this->Customers_model->getAlertsCount();
        $this->load->view('customer/update_customer',$data);

    }

    public function save_edited_info(){

        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('username','customer Name','required');
        $this->form_validation->set_rules('password','Password','required');
        $this->form_validation->set_rules('addr1','Address-1','required');
        $this->form_validation->set_rules('addr2','Address-2','required');
        $this->form_validation->set_rules('area','Area','required');
        $id = $this->input->post('id');
        
        if($this->form_validation->run() == false){
            $this->session->set_flashdata('error_msgs',validation_errors());
            redirect('Customers/update_customer/'.$id);
        } 

        $data['name'] = $this->input->post('name');
        $data['username'] = $this->input->post('username');
        $data['password'] = $this->input->post('password');
        $data['addr1'] = $this->input->post('addr1');
        $data['addr2'] = $this->input->post('addr2');
        $data['area'] = $this->input->post('area');
        $data['users'] = $this->Customers_model->update_customer($data,$id);
        $this->session->set_flashdata('update_msgs','The Server details has been updated successfully');
        // $this->load->view('customer/index',$data);
        
        redirect('Customers/index');

    }


    public function customer_devices() {
        $id = $this->uri->segment('3');
        $data['all_info'] = $this->Customers_model->getCustomerDevices($id);
        $data['alerts_info'] = $this->Customers_model->getAlertsInfo();
        $data['alerts_cnt'] = $this->Customers_model->getAlertsCount();
        //echo "<pre>"; print_r($data);exit;
        $this->load->view('customer/customer_devices',$data);
    }

    public function set_device() {
        $device_id = $this->uri->segment('3');
        $customer_id = $this->uri->segment('4');
        $status = $this->uri->segment('5');
        
        // echo $device_id. '::' .$customer_id;exit;
        $device_status= $this->Customers_model->set_device($device_id,$customer_id,$status);
        if($device_status == 'assigned'){
            $message = 'assigned';
        } else if($device_status == 'unassigned'){
           $message = 'unassigned';
        }
        $this->session->set_flashdata('message',$message);
        $data['all_info'] = $this->Customers_model->getCustomerDevices($customer_id);
        $data['alerts_info'] = $this->Customers_model->getAlertsInfo();
        $data['alerts_cnt'] = $this->Customers_model->getAlertsCount();
        //echo "<pre>"; print_r($data);exit;
        $this->load->view('customer/customer_devices',$data);
       
    }

    // public function save_device_info_into_conf_file(){
    //     $sno = $this->input->post('serialnumber');
    //     $device_info = $this->Customers_model->get_device_details($sno);
        
    //     $file_name = APPPATH.'device_config.csv';
       
    //     $file = fopen($file_name, 'a');
    
    //     // Loop through each device info and write to the CSV file
    //     foreach ($device_info as $info) {
    //         $G_device_serialnumber  = $info->serialnumber;
    //         $G_device_id            = $info->id;
    //         $G_device_details       = $info->details;
    //         $model         = $info->model;
    //         $model_variant = $info->model_variant;

    //         if ($model == "spider") {
    //             $model_name = "SMOAD Spider";
    //         } elseif ($model == "spider2") {
    //             $model_name = "SMOAD Spider2";
    //         } elseif ($model == "beetle") {
    //             $model_name = "SMOAD Beetle";
    //         } elseif ($model == "bumblebee") {
    //             $model_name = "SMOAD BumbleBee";
    //         } elseif ($model == "vm") {
    //             $model_name = "SMOAD VM";
    //         }
    
    //         if ($model_variant == "l2") {
    //             $model_variant_name = "L2 SD-WAN";
    //         } elseif ($model_variant == "l2w1l2") {
    //             $model_variant_name = "L2 SD-WAN (L2W1L2)";
    //         } elseif ($model_variant == "l3") {
    //             $model_variant_name = "L3 SD-WAN";
    //         } elseif ($model_variant == "mptcp") {
    //             $model_variant_name = "MPTCP";
    //         }
    //         // Write the device details as a row in the CSV file
    //       fputcsv($file, [$G_device_serialnumber, $G_device_id, $G_device_details, $model_name, $model_variant_name]);
    //     }

    //     if ($this->sm_get_device_port_branching_by_serialnumber('LAN', $model, $model_variant)) {
    //         $ports_array[] = 'lan';
    //     }
    //     if ($this->sm_get_device_port_branching_by_serialnumber('WAN', $model, $model_variant)) {
    //         $ports_array[] = 'wan1';
    //     }
    //     if ($this->sm_get_device_port_branching_by_serialnumber('WAN2', $model, $model_variant)) {
    //         $ports_array[] = 'wan2';
    //     }
    //     if ($this->sm_get_device_port_branching_by_serialnumber('WAN3', $model, $model_variant)) {
    //         $ports_array[] = 'wan3';
    //     }
    //     if ($this->sm_get_device_port_branching_by_serialnumber('LTE1', $model, $model_variant)) {
    //         $ports_array[] = 'lte1';
    //     }
    //     if ($this->sm_get_device_port_branching_by_serialnumber('LTE2', $model, $model_variant)) {
    //         $ports_array[] = 'lte2';
    //     }
    //     if ($this->sm_get_device_port_branching_by_serialnumber('LTE3', $model, $model_variant)) {
    //         $ports_array[] = 'lte3';
    //     }
    //     if ($this->sm_get_device_port_branching_by_serialnumber('SD-WAN', $model, $model_variant)) {
    //         $ports_array[] = 'sdwan';
    //     }

    //     $pdf_info = $this->Customers_model->get_logs_by_sno($G_device_serialnumber);

    //     if(count($pdf_info) > 0) {
    //         foreach ($pdf_info as $info) {
        
    //             $rx_bytes_total  = 0;
    //             $tx_bytes_total  = 0;
    //             $upCount_total   = 0;
    //             $downCount_total = 0;
    //             $latencyAvg      = 0;
    //             $jitterAvg       = 0;
        
    //             for ($i = 0; $i < count($ports_array); ++$i) {
    //                 /*if (!$row['sum_'.$ports_array[$i].'_rx_bytes']) {
    //                 $row['sum_'.$ports_array[$i].'_rx_bytes'] = '-';
    //                 }*/
        
    //                 if ($i % 2 == 0) {
    //                     $flag = true;
    //                 } else {
    //                     $flag = false;
    //                 }
                    
    //                 $rx_bytes_clm   = 'sum_' . $ports_array[$i] . '_rx_bytes';
    //                 $tx_bytes_clm   = 'sum_' . $ports_array[$i] . '_tx_bytes';
    //                 $up_count_clm   = 'sum_link_status_' . $ports_array[$i] . '_up_count';
    //                 $down_count_clm = 'sum_link_status_' . $ports_array[$i] . '_down_count';
                   
    //                 if ($ports_array[$i] == 'lan') {
    //                     $rx_bytes      = '-';
    //                     $rx_bytes_unit = '';
    //                     $tx_bytes      = '-';
    //                     $tx_bytes_unit = '';
    //                     $downCount     = '-';
    //                     $latency_unit  = '-';
    //                     $jitter_unit   = '-';
    //                 } else {
    //                     $rx_bytes = $info->$rx_bytes_clm;
    //                     $tx_bytes = $info->$tx_bytes_clm;
    //                     $rx_bytes_total += $rx_bytes;
    //                     $tx_bytes_total += $tx_bytes;
        
    //                     $upCount   = $info->$up_count_clm;
    //                     $downCount = $info->$down_count_clm;
        
    //                     $upCount_total += $upCount;
    //                     $downCount_total += $downCount;
        
    //                     if ($downCount == null) {
    //                         $downCount = 0;
    //                     }

    //                     if ($upCount == null) {
    //                         $upCount = 0;
    //                     }
        
    //                     //GETTING NUMBER OF DAYS TO MINUTES IN MONTH USING COUNT OF ROW ENTRIES
    //                     $days_in_month    = $info->count_log_timestamp;
    //                     $minutes_in_month = $days_in_month * 1440; //MULTIPLYING BY 1440 GIVES US THE TOTAL MINUTES IN THE GIVEN DAYS
    //                                                                //OLD CODE $minutes_in_month_for_percentage = bcdiv($minutes_in_month,100,3);
    //                     $minutes_in_month_for_percentage = round($minutes_in_month / 100, 3);
        
    //                     //LOGIC TO GET PERCENTAGE OF UP TIME IN A MONTH, AND TOTAL UP TIME FOR INDIVIDUAL PORTS
    //                     $repeat_up_count_clm     = 'sum_link_status_' . $ports_array[$i] . '_repeat_up_count';
    //                     $port_repeat_count       = $info->$repeat_up_count_clm;
    //                     $latency_clm = 'avg_' . $ports_array[$i] . '_latency';
        
    //                     $latency = $info->$latency_clm;
    //                     $latencyAvg += $latency;
    //                     $jitter_clm = 'avg_' . $ports_array[$i] . '_jitter';
    //                     $jitter     = $info->$jitter_clm;
    //                     $jitterAvg += $jitter;
    //                     $rx_bytes_unit = $this->unit_conversion($rx_bytes);
    //                     $latency_unit  = round($latency, 2) . ' ms';
    //                     $jitter_unit   = round($jitter, 2) . ' ms';
    //                     $tx_bytes_unit = $this->unit_conversion($tx_bytes);
    //                 }
                  
    //                 $rx_bytes_value = $rx_bytes . " " . $rx_bytes_unit;
    //                 $tx_bytes_value =  $tx_bytes . " " . $tx_bytes_unit;
    //                 fputcsv($file,['port',$G_device_serialnumber,strtoupper($ports_array[$i]), $rx_bytes_value, $tx_bytes_value, $downCount,$latency_unit,$jitter_unit]);

    //             }
    //         }
    //     }
    //     // Close the file
    //     fclose($file);
    // }

    // public function download_report(){
    //     // Read the contents of the CSV file
    //         $file_name = APPPATH.'device_config.csv';
    //        // $csv_data = file_get_contents($file_name);

    //         $file = fopen($file_name, 'r');

    //         // Initialize arrays to store data
    //         $deviceData = [];
    //         $portData = [];

    //         // Read each line from the CSV file
    //         while (($line = fgetcsv($file)) !== false) {
    //             // Check if the line contains any non-whitespace characters
    //             if (preg_match('/[^\s]/', implode('', $line))) {
    //                 // Check if the line contains the word "port"
    //                 if (strpos($line[0], 'port') !== false) {
    //                     // Add the line to the port data array
    //                     $portData[] = $line;
    //                 } else {
    //                     // Add the line to the device data array
    //                     $deviceData[] = $line;
    //                 }
    //             }
    //         }

    //         // Close the file
    //         fclose($file);
       
    //         // for ($j = 0; $j < count($portData); $j++) {
    //         //   echo '<pre>'; print_r($portData[$j]);
    //         // } exit;
    //         $pdf = new FPDF();
    //         for($i=0;$i<count($deviceData);$i++){
    //            if(!empty($deviceData[$i])){
    //             $G_device_serialnumber = $deviceData[$i][0];
    //             $G_device_details = $deviceData[$i][2];
    //             $_model = $deviceData[$i][3];
    //             $_model_variant = $deviceData[$i][4];
    //             $pdf->AddPage();
    //             $pdf->SetTitle('Monthly Consolidated Report');
    //             $pdf->SetY(0);
    //             $pdf->SetFont("Arial", "B", "13");
    //             $pdf->SetXY(5, $pdf->GetY() + 15);
    //             $x          = 15;
    //             $y          = 10;
    //             $CI         =& get_instance();
    //             $image_name = $CI->config->base_url() . 'assets/dist/img/smoad_rect_logo_5g.png';
    //             $pdf->Cell($x, $y, $pdf->Image($image_name, 10, 7, 33.78), 0, 0, 'L', false);
        
    //             $pageWidth  = 210;
    //             $pageHeight = 297;
    //             $pdf->SetFont("Arial", "B", "11");
    //             $pdf->SetXY(160, $pdf->GetY());
    //             $pdf->Cell(10, 10, "Date: " . date("F j, Y"));
        
    //             $pdf->SetFont("Arial", "", "10");
    //             $pdf->SetXY(10, $pdf->GetY() + 7);
    //             $pdf->Cell($x, $y, "Serial Number: " . $G_device_serialnumber);
        
    //             $pdf->SetFont("Arial", "", "10");
    //             $pdf->SetXY(10, $pdf->GetY() + 7);
    //             $pdf->Cell($x, $y, "Details: " . $G_device_details);
        
    //             $pdf->SetFont("Arial", "", "10");
    //             $pdf->SetXY(10, $pdf->GetY() + 7);
    //             $pdf->Cell($x, $y, "Model: " . $_model);
        
    //             $pdf->SetFont("Arial", "", "10");
    //             $pdf->SetXY(10, $pdf->GetY() + 7);
    //             $pdf->Cell($x, $y, "Model Variant: " . $_model_variant);
        
    //             $pdf->SetFont("Arial", "B", "13");
    //             $pdf->SetXY(10, $pdf->GetY() + 18);
    //             //$pdf->SetFillColor(211,211,211);
    //             $pdf->Cell($x + 100, $y, "Consolidated Report");
        
    //             $pdf->SetFont("Arial", "B", "12");
    //             $pdf->SetXY(10, $pdf->GetY() + 10);
    //             $pdf->Cell($x, $y + 2, "Total Data Transferred:");
    //             $border = 0;
    //             $pdf->SetFont("Arial", "", "10");
    //             $pdf->SetXY(12, $pdf->GetY() + 12);
    //             $pdf->SetFillColor(68, 68, 68);
    //             $pdf->SetTextColor(255, 255, 255);
    //             // $pdf->Cell(30, 10, 'Port', $border, 0, 'C', true);
    //             // $pdf->Cell(30, 10, 'RX', $border, 0, 'C', true);
    //             // $pdf->Cell(15, 10, 'TX', $border, 0, 'C', true);
    //             // $pdf->Cell(30, 10, 'Down', $border, 0, 'C', true);
    //             // $pdf->Cell(20, 10, 'Latency', $border, 0, 'C', true);
    //             // $pdf->Cell(25, 10, 'Jitter', $border, 1, 'C', true); /*end of line*/
    //             $pdf->Cell(30, 10, 'Port', $border, 0, 'C', true);
    //             $pdf->Cell(30, 10, 'RX', $border, 0, 'C', true);
    //             $pdf->Cell(30, 10, 'TX', $border, 0, 'C', true);
    //             //$pdf->Cell(15 ,10,'Up',$border,0,'C', true);
    //             $pdf->Cell(30, 10, 'Down', $border, 0, 'C', true);
    //           //  $pdf->Cell(30, 10, 'Up Time', $border, 0, 'C', true);
    //             $pdf->Cell(30, 10, 'Latency', $border, 0, 'C', true);
    //             $pdf->Cell(30, 10, 'Jitter', $border, 1, 'C', true); /*end of line*/
    //             /*Heading Of the table end*/
    //             $pdf->SetFont('Arial', '', '10');
               
    //             if ($i % 2 == 0) {
    //                 $flag = true;
    //             } else {
    //                 $flag = false;
    //             }
    //             for ($j = 0; $j < count($portData); $j++) {
             
    //             if($G_device_serialnumber == $portData[$j][1]){
    //                 $pdf->SetXY(12, $pdf->GetY());
    //                 //$pdf->SetFillColor(216,68,48); // do not remove
    //                 $pdf->SetFillColor(233, 239, 245);
    //                 $pdf->SetTextColor(0, 0, 0);
    //                 $pdf->Cell(30, 10, strtoupper($portData[$j][2]), $border, 0, 'C', $flag);
    //                 $pdf->Cell(30, 10, $portData[$j][3], $border, 0, 'C', $flag);
    //                 $pdf->Cell(30, 10, $portData[$j][4], $border, 0, 'C', $flag);
    //                 $pdf->Cell(30, 10, $portData[$j][5], $border, 0, 'C', $flag);
                  
    //                 $pdf->Cell(30, 10, $portData[$j][6], $border, 0, 'C', $flag);
    //                 $pdf->Cell(30, 10, $portData[$j][7], $border, 1, 'C', $flag);
    //            }
    //             }
    //           }

              
    //         }

    //         $pdf->Output();

    // }
    
    public function clear_file(){
        $file_path = APPPATH . 'device_config.csv';
        // Empty the file
        file_put_contents($file_path, '');

        // Return a response
        echo 'File emptied successfully';
            }
    public function pdf_report(){
        //start of correct code
        $sno = $this->input->post('serialnumbers');
        $serialnumbers = explode(',',$sno);
        $file_path = APPPATH . 'device_config.csv';
    
        $file = fopen($file_path, 'a');
        foreach($serialnumbers as $serialNumber) {
            fputcsv($file, [$serialNumber]);
        }

        redirect('Customers/pdf_report_download');
        //end of correct code
    }



    public function pdf_report_download(){
        $file_name = APPPATH . 'device_config.csv';

         // Read all lines of the CSV file into an array
         $lines = file($file_name, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
         $pdf = new FPDF();
     foreach($lines as $line) {
        $ports_array = [];
        $device_details = $this->Customers_model->get_device_info($line);
          
            foreach ($device_details as $info) {
                $G_device_serialnumber  = $info->serialnumber;
                $G_device_id            = $info->id;
                $G_device_details       = $info->details;
                $device_model         = $info->model;
                $G_device_model_variant = $info->model_variant;
            }
            
            $model         = $device_model;
            $model_variant = $G_device_model_variant;
    
            $_model = $_model_variant = '';
            if ($model == "spider") {
                $_model = "SMOAD Spider";
            } elseif ($model == "spider2") {
                $_model = "SMOAD Spider2";
            } elseif ($model == "beetle") {
                $_model = "SMOAD Beetle";
            } elseif ($model == "bumblebee") {
                $_model = "SMOAD BumbleBee";
            } elseif ($model == "vm") {
                $_model = "SMOAD VM";
            }
    
            if ($model_variant == "l2") {
                $_model_variant = "L2 SD-WAN";
            } elseif ($model_variant == "l2w1l2") {
                $_model_variant = "L2 SD-WAN (L2W1L2)";
            } elseif ($model_variant == "l3") {
                $_model_variant = "L3 SD-WAN";
            } elseif ($model_variant == "mptcp") {
                $_model_variant = "MPTCP";
            }
    
            if ($this->sm_get_device_port_branching_by_serialnumber('LAN', $device_model, $G_device_model_variant)) {
                $ports_array[] = 'lan';
            }
            if ($this->sm_get_device_port_branching_by_serialnumber('WAN', $device_model, $G_device_model_variant)) {
                $ports_array[] = 'wan1';
            }
            if ($this->sm_get_device_port_branching_by_serialnumber('WAN2', $device_model, $G_device_model_variant)) {
                $ports_array[] = 'wan2';
            }
            if ($this->sm_get_device_port_branching_by_serialnumber('WAN3', $device_model, $G_device_model_variant)) {
                $ports_array[] = 'wan3';
            }
            if ($this->sm_get_device_port_branching_by_serialnumber('LTE1', $device_model, $G_device_model_variant)) {
                $ports_array[] = 'lte1';
            }
            if ($this->sm_get_device_port_branching_by_serialnumber('LTE2', $device_model, $G_device_model_variant)) {
                $ports_array[] = 'lte2';
            }
            if ($this->sm_get_device_port_branching_by_serialnumber('LTE3', $device_model, $G_device_model_variant)) {
                $ports_array[] = 'lte3';
            }
            if ($this->sm_get_device_port_branching_by_serialnumber('SD-WAN', $device_model, $G_device_model_variant)) {
                $ports_array[] = 'sdwan';
            }
           //   echo '<pre>';print_r($ports_array);
            $pdf->AddPage();
            $pdf->SetTitle('Monthly Consolidated Report');
            $pdf->SetY(0);
            $pdf->SetFont("Arial", "B", "13");
            $pdf->SetXY(5, $pdf->GetY() + 15);
            $x          = 15;
            $y          = 10;
            $CI         =& get_instance();
            $image_name = $CI->config->base_url() . 'assets/dist/img/smoad_rect_logo_5g.png';
            $pdf->Cell($x, $y, $pdf->Image($image_name, 10, 7, 33.78), 0, 0, 'L', false);
    
            $pageWidth  = 210;
            $pageHeight = 297;
            $pdf->SetFont("Arial", "B", "11");
            $pdf->SetXY(160, $pdf->GetY());
            $pdf->Cell(10, 10, "Date: " . date("F j, Y"));
    
            $pdf->SetFont("Arial", "", "10");
            $pdf->SetXY(10, $pdf->GetY() + 7);
            $pdf->Cell($x, $y, "Serial Number: " . $G_device_serialnumber);
    
            $pdf->SetFont("Arial", "", "10");
            $pdf->SetXY(10, $pdf->GetY() + 7);
            $pdf->Cell($x, $y, "Details: " . $G_device_details);
    
            $pdf->SetFont("Arial", "", "10");
            $pdf->SetXY(10, $pdf->GetY() + 7);
            $pdf->Cell($x, $y, "Model: " . $_model);
    
            $pdf->SetFont("Arial", "", "10");
            $pdf->SetXY(10, $pdf->GetY() + 7);
            $pdf->Cell($x, $y, "Model Variant: " . $_model_variant);
    
            $pdf->SetFont("Arial", "B", "13");
            $pdf->SetXY(10, $pdf->GetY() + 18);
            $pdf->Cell($x + 100, $y, "Consolidated Report");
    
            $pdf->SetFont("Arial", "B", "12");
            $pdf->SetXY(10, $pdf->GetY() + 10);
            $pdf->Cell($x, $y + 2, "Total Data Transferred:");
    
            $border = 0;
            $pdf->SetFont("Arial", "", "10");
            $pdf->SetXY(12, $pdf->GetY() + 12);
            $pdf->SetFillColor(68, 68, 68);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(30, 10, 'Port', $border, 0, 'C', true);
            $pdf->Cell(30, 10, 'RX', $border, 0, 'C', true);
            $pdf->Cell(30, 10, 'TX', $border, 0, 'C', true);
            $pdf->Cell(30, 10, 'Down', $border, 0, 'C', true);

    
            $pdf->Cell(30, 10, 'Latency', $border, 0, 'C', true);
            $pdf->Cell(30, 10, 'Jitter', $border, 1, 'C', true); /*end of line*/
            $pdf->SetFont('Arial', '', '10');
        
            $pdf_info = $this->Customers_model->get_logs_by_sno($G_device_serialnumber);
            if(count($pdf_info) > 0) {
                foreach ($pdf_info as $info) {
    
                    $rx_bytes_total  = 0;
                    $tx_bytes_total  = 0;
                    $upCount_total   = 0;
                    $downCount_total = 0;
                    $latencyAvg      = 0;
                    $jitterAvg       = 0;
    
                    for ($i = 0; $i < count($ports_array); ++$i) {
                      
                        if ($i % 2 == 0) {
                            $flag = true;
                        } else {
                            $flag = false;
                        }
                        $pdf->SetXY(12, $pdf->GetY());
                        $pdf->SetFillColor(233, 239, 245);
                        $pdf->SetTextColor(0, 0, 0);
                        $pdf->Cell(30, 10, strtoupper($ports_array[$i]), $border, 0, 'C', $flag);
                        $rx_bytes_clm   = 'sum_' . $ports_array[$i] . '_rx_bytes';
                        $tx_bytes_clm   = 'sum_' . $ports_array[$i] . '_tx_bytes';
                        $up_count_clm   = 'sum_link_status_' . $ports_array[$i] . '_up_count';
                        $down_count_clm = 'sum_link_status_' . $ports_array[$i] . '_down_count';
                  
                        if ($ports_array[$i] == 'lan') {
                            $rx_bytes      = '-';
                            $rx_bytes_unit = '';
                            $tx_bytes      = '-';
                            $tx_bytes_unit = '';
                            $downCount     = '-';
                            $latency_unit  = '-';
                            $jitter_unit   = '-';
                            $total_hrs     = '-';
                        } else {
                            $rx_bytes = $info->$rx_bytes_clm;
                            $tx_bytes = $info->$tx_bytes_clm;
                            $rx_bytes_total += $rx_bytes;
                            $tx_bytes_total += $tx_bytes;
    
                            $upCount   = $info->$up_count_clm;
                            $downCount = $info->$down_count_clm;
    
                            $upCount_total += $upCount;
                            $downCount_total += $downCount;
    
                            if ($downCount == null) {
                                $downCount = 0;
                            }
                            if ($upCount == null) {
                                $upCount = 0;
                            }
    
                            $days_in_month    = $info->count_log_timestamp;
                         
                            $latency_clm = 'avg_' . $ports_array[$i] . '_latency';
    
                            $latency = $info->$latency_clm;
                            $latencyAvg += $latency;
                            $jitter_clm = 'avg_' . $ports_array[$i] . '_jitter';
                            $jitter     = $info->$jitter_clm;
                            $jitterAvg += $jitter;
                            $rx_bytes_unit = $this->unit_conversion($rx_bytes);
                            $latency_unit  = round($latency, 2) . ' ms';
                            $jitter_unit   = round($jitter, 2) . ' ms';
                           // $total_hrs     = $total_up_time_port_hours . " (" . $percentage_up_port . "%)";
                            $tx_bytes_unit = $this->unit_conversion($tx_bytes);
                        }
                        $pdf->Cell(30, 10, $rx_bytes . " " . $rx_bytes_unit, $border, 0, 'C', $flag);
                        $pdf->Cell(30, 10, $tx_bytes . " " . $tx_bytes_unit, $border, 0, 'C', $flag);
                        $pdf->Cell(30, 10, $downCount, $border, 0, 'C', $flag);
                        $pdf->Cell(30, 10, $latency_unit, $border, 0, 'C', $flag);
                        $pdf->Cell(30, 10, $jitter_unit, $border, 1, 'C', $flag);
                    }
                }
            } 
          } 
        $pdf->Output();
    }
    public function filterData(&$str){ 
        $str = preg_replace("/\t/", "\\t", $str); 
        $str = preg_replace("/\r?\n/", "\\n", $str); 
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
    }

    public function excel_report_download() {
        // $this->load->library('PHPExcel');

        // // Create new PHPExcel object
        // $objPHPExcel = new PHPExcel();
    
        // // Set document properties
        // $objPHPExcel->getProperties()->setCreator("Your Name")
        //                              ->setLastModifiedBy("Your Name")
        //                              ->setTitle("Excel Title")
        //                              ->setSubject("Excel Subject")
        //                              ->setDescription("Excel Description")
        //                              ->setKeywords("excel phpexcel codeigniter")
        //                              ->setCategory("Excel Category");
    
        // // Add data to the Excel file
        // $objPHPExcel->setActiveSheetIndex(0)
        //             ->setCellValue('A1', 'Data 1')
        //             ->setCellValue('B1', 'Data 2')
        //             ->setCellValue('C1', 'Data 3');
    
        // // Set headers for download
        // $filename = 'example.xlsx';
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="'. $filename .'"');
        // header('Cache-Control: max-age=0');
    
        // // Save Excel 2007 file
        // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // $objWriter->save('php://output');
    }
    
    

    public function sm_get_device_port_branching_by_serialnumber($port, $model, $model_variant)
    {
        if ($port == "WAN") { //wan1 port is there for all variants
            return true;
        } elseif ($port == "WAN2") {
            if (
                ($model == 'vm' && $model_variant == "l2") || ($model == 'vm' && $model_variant == "l3") ||
                ($model == 'spider' && $model_variant == "l2") || ($model == 'spider' && $model_variant == "l3") ||
                ($model == 'spider2' && $model_variant == "l2") || ($model == 'spider2' && $model_variant == "l3") ||
                ($model == 'beetle' && $model_variant == "l2") || ($model == 'beetle' && $model_variant == "l3") ||
                ($model == 'bumblebee' && $model_variant == "l2") || ($model == 'bumblebee' && $model_variant == "l3")
            ) {
                return true;
            }

        } elseif ($port == "WAN3") {
            if (($model == 'spider2' && $model_variant == "l3")) {
                return true;
            }

        } elseif ($port == "LTE1") {
            if (
                ($model == 'spider' && $model_variant == "l2") || ($model == 'spider' && $model_variant == "l3") || ($model == 'spider' && $model_variant == "l2w1l2") ||
                ($model == 'spider2' && $model_variant == "l2") || ($model == 'spider2' && $model_variant == "l3") ||
                ($model == 'beetle' && $model_variant == "l2") || ($model == 'beetle' && $model_variant == "l3") ||
                ($model == 'bumblebee' && $model_variant == "l2") || ($model == 'bumblebee' && $model_variant == "l3")
            ) {
                return true;
            }

        } elseif ($port == "LTE2") {
            if (
                ($model == 'spider' && $model_variant == "l2") || ($model == 'spider' && $model_variant == "l3") || ($model == 'spider' && $model_variant == "l2w1l2") ||
                ($model == 'spider2' && $model_variant == "l2") || ($model == 'spider2' && $model_variant == "l3")
            ) {
                return true;
            }

        } elseif ($port == "LTE3") {
            if (($model == 'spider2' && $model_variant == "l2") || ($model == 'spider2' && $model_variant == "l3")) {
                return true;
            }

        } elseif ($port == "LAN") { //lan port is there for all variants
            return true;
        } elseif ($port == "WIRELESS") { //wifi port is there for all variants
            return true;
        } elseif ($port == "SD-WAN") { //sdwan port is there for all variants
            return true;
        }

        return false;
    }

    public function unit_conversion(&$unit_value)
    {   $unit = 1;
        $unit_name                       = "Kb";
        $unit_details                    = [];
        $unit_details['unit']            = $unit;
        $unit_name                       = "Kb";
        $unit_details['unit_name']       = $unit_name;
        if ($unit_value <= 0) {$unit_value = 1;}
        $unit_value = $unit_value * 8; //convert to bits
        if ($unit_value > 1100) {$unit = 1000;
            $unit_details['unit']            = $unit;
            $unit_name                       = "Mb";
            $unit_details['unit_name']       = $unit_name;
            $unit_value /= 1000;} //Mb
        if ($unit_value > 1100) {$unit = 1000;
            $unit_details['unit']            = $unit;
            $unit_name                       = "Gb";
            $unit_details['unit_name']       = $unit_name;
            $unit_value /= 1000;} //Gb

        $unit_value = number_format($unit_value, 1);
        return $unit_details['unit_name'];}
   

}

?>