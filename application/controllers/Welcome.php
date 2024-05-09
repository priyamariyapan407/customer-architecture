<?php
use Dompdf\Dompdf;

defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        //$this->load->library('pdf');
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *     - or -
     *         http://example.com/index.php/welcome/index
     *     - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/userguide3/general/urls.html
     */
    public function index()
    {
        $this->load->view('home');
    }
    public function dashboard()
    {
        $logged_in = $this->session->userdata('logged_in');

        if (!($logged_in)) {
            redirect(base_url('/'));
        }

        $data['server_details']     = $this->Admin_model->getServerInfo();
        $data['network_details']    = $this->Admin_model->getNetworkInfo();
        $data['sm_gw_count']        = $this->Admin_model->getGatewayCount();
        $data['donutChart1']        = $this->Admin_model->donutChart1();
        $data['donutChart2']        = $this->Admin_model->donutChart2();
        $data['donutChart3']        = $this->Admin_model->donutChart3();
        $data['edge_devices_count'] = $this->Admin_model->getEdgeDeviceCount();
        $data['donutChart4']        = $this->Admin_model->donutChart4();
        $data['donutChart5']        = $this->Admin_model->donutChart5();
        $data['donutChart6']        = $this->Admin_model->donutChart6();
        $data['donutChart7']        = $this->Admin_model->donutChart7();
        $data['donutChart8']        = $this->Admin_model->donutChart8();
        $data['circuit_summary']    = $this->Admin_model->circuitSummary();
        $data['firmware_summary']   = $this->Admin_model->firmwareSummary();
        $data['link_counts']        = $this->Admin_model->linkReliabilityCounts();
        $data['sd_wan']             = $this->Admin_model->sdwanLatency();
        $data['sd_wan_link_usage']  = $this->Admin_model->sdWanLinkUsage();
        $data['alerts_info']        = $this->Admin_model->getAlertsInfo();
        $data['alerts_cnt']         = $this->Admin_model->getAlertsCount();
        //echo '<pre>'; print_r($data);exit;
        $this->load->view('dashboard', $data);
    }

    public function linked_Devices()
    {
        $port                = $this->uri->segment('3');
        $data['devices']     = $this->Admin_model->get_linked_Devices($port);
        $data['alerts_info'] = $this->Admin_model->getAlertsInfo();
        $data['alerts_cnt']  = $this->Admin_model->getAlertsCount();
        $this->load->view('linked_devices', $data);
    }

    public function getWgPeers()
    {
        $data['get_peer_counts'] = $this->Admin_model->getPeers();
        $data['alerts_info']     = $this->Admin_model->getAlertsInfo();
        $data['alerts_cnt']      = $this->Admin_model->getAlertsCount();
        $this->load->view('dashboard', $data);
    }

    public function admin_login()
    {
        //echo '1';exit;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('username', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == true) {
                $username = $this->input->post('username');
                $password = $this->input->post('password');

                $this->load->model('Admin_model');
                $status = $this->Admin_model->checkPassword($username, $password);

                if ($status != false) {
                    $access_level = $status->access_level;
                    $this->session->set_userdata('logged_in', true);
                    redirect(base_url('Welcome/dashboard'));
                } else {
                    $this->session->set_flashdata('error', 'username or password is wrong');
                    redirect(base_url('/'));
                }
            } else {
                $this->session->set_flashdata('error', 'Fill all the required fields');
                redirect(base_url('/'));
            }

        }
    }

    public function save_server_name()
    {

        $this->form_validation->set_rules('server_name', 'server name', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error_msgs', validation_errors());
            redirect('Welcome/dashboard');
        }

        $data['server_name'] = $this->input->post('server_name');

        $status = $this->Admin_model->update_server_name($data);

        if ($status == true) {
            $this->session->set_flashdata('success_msg', 'The server name has been updated successfully');
            redirect('Welcome/dashboard');
        } else {
            $this->session->set_flashdata('error_msgs', 'There is a error in updating a server name. Please try again later.');
            redirect('Welcome/dashboard');
        }

    }

    public function pdfDownload()
    {
        $html   = $this->load->view('spin/pdf', array('user' => 'user1'), true);
        $dompdf = new Dompdf();
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->set_option('enable-javascript', true);
        $dompdf->set_option('javascript-delay', 13000); // page load is quick but even a high number doesn't help
        $dompdf->set_option('++-smart-shrinking', true);
        $dompdf->set_option('no-stop-slow-scripts', true);
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream();
    }
}
