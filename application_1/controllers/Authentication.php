<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends CI_Controller {

    private $global_set = array(
        'title' => 'Login Administrator',
        'title_page' => 'Login',
        'bread_one' => 'Login',
        'bread_two' => '',
        'bread_three' => '',
    );

    public function __construct() {
        parent::__construct();
        $this->load->model('authentication_model');
    }

    public function index() {
        //melakukan cek session dimana session disini digunakan untuk login
        $sess = $this->session->userdata($this->config->item('sess_loginsys'));
        switch ($sess):
            case '':
                redirect('authentication/login');
                break;
            default:
                redirect(site_url('dashboard'));
                break;
        endswitch;
    }

    public function login() {
        //proses login 
        //apabila session ada atau tidak kosong maka di arahkan pada halaman dashboard
        if ($this->session->userdata($this->config->item('sess_loginsys')) != '') :
            redirect(site_url('dashboard'));
        endif;

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="help-block text-red">', '</p>');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == false) :
            //tampilkan view login ketika belum melakukan submit / klik tombol login
            $data = $this->global_set;
            $data['form_action'] = base_url('authentication/login');
            $this->load->view('authentication/login', $data);
        else:
            //username dan password yang sudah di isi dimasukkan di sini
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            //proses pengecekan login dengan username dan password yang sudah di inputkan
            $result_login = $this->authentication_model->login($username, $password);
            if (count($result_login) == 0) :
                //ketika tidak ditemukan dengan username dan password tersebut login dinyatakan gagal
                $this->session->set_flashdata('flash_error', '*Login gagal !! username atau password anda salah');
                redirect('authentication/login');
            else:
                //inisiasi session login
                $sess_array = array();
                $sess_array = array(
                    'log_loginsys_access_id' => $result_login['users_id'],
                    'log_loginsys_access_username' => $result_login['users_username'],
                    'log_loginsys_access_name' => $result_login['users_name'],
                );

                /* set session login */
                $this->session->set_userdata($this->config->item('sess_loginsys'), $sess_array);
                redirect(base_url());
            endif;
        endif;
    }

    public function logout() {
        //proses logout
        $this->session->unset_userdata($this->config->item('sess_loginsys'));
        if (isset($_SESSION)) :
            session_destroy();
        endif;
        redirect(base_url(), 'refresh');
    }

}
