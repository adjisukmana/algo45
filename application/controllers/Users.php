<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/Backend.php';

class Users extends Backend {

    private $global_set = array(
        'title' => 'Manajemen Pegawai',
        'title_head' => '<i class="ion ion-levels"></i> Manajemen Pegawai',
        'title_page' => 'Pegawai',
        'bread_one' => 'Manajemen Pegawai',
        'bread_two' => '',
        'bread_three' => '',
    );

    public function __construct() {
        parent::__construct();
        $this->load->model('users_model');
    }

    public function index() {
        $data = $this->global_set;

        $this->load_css('plugins/datatables/dataTables.bootstrap.css');

        $this->load_js('plugins/datatables/jquery.dataTables.min.js');
        $this->load_js('plugins/datatables/dataTables.bootstrap.min.js');

        parent::display('users/show', $data);
    }

    public function show() {
        $data = $this->global_set;
        $data['show'] = $this->users_model->show();
        $this->load->view('users/table', $data);
    }

    public function modal($mode, $id = null) {
        $data = $this->global_set;
        $show = $this->users_model->show_by_parameter('users_id', $id);
        $data['mode'] = $mode;
        $data['users_id'] = (count($show) == 0) ? '' : $show->users_id;
        $data['users_username'] = (count($show) == 0) ? '' : $show->users_username;
        $data['users_password'] = (count($show) == 0) ? '' : $show->users_password;
        $data['users_email'] = (count($show) == 0) ? '' : $show->users_email;
        $data['users_name'] = (count($show) == 0) ? '' : $show->users_name;
        $this->load->view('users/modal', $data);
    }

    public function save() {
        $mode = $this->input->post('mode');
        $data = array(
            'users_id' => ($this->input->post('users_id') == '') ? null : $this->input->post('users_id'),
            'users_username' => $this->input->post('users_username'),
            'users_name'            => ucwords($this->input->post('users_name')),
            'users_email'           => $this->input->post('users_email'),
        );

        $check = $this->users_model->show_by_parameter('users_username', $this->input->post('users_username'));
        if ($mode == 'add') {
            $data['users_password'] = md5($this->input->post('users_password'));
            switch (count($check)) {
                case 0:
                    $this->crud_model->insert_data('users', $data);
                    break;
                default:
                    $this->session->set_flashdata('error', 'Username ' . $this->global_set['title_page'] . ' sudah digunakan, silahkan coba lagi');
                    break;
            }
        } else {
            if ($this->input->post('users_password') != '' && $this->input->post('users_passwordconfirm') != '') :
                if ($this->input->post('users_password') == $this->input->post('users_passwordconfirm')):
                    $data['users_password'] = md5($this->input->post('users_password'));
                else:
                    $this->session->set_flashdata('error', 'Password ' . $this->global_set['title_page'] . ' tidak sama, silahkan coba lagi');
                endif;
            endif;
            switch (count($check)) {
                case 0:
                    $this->crud_model->update_data('users', $data, 'users_id');
                    break;
                default:
                    if ($check->users_id == $this->input->post('users_id')) {
                        $this->crud_model->update_data('users', $data, 'users_id');
                    } else {
                        $this->session->set_flashdata('error', 'Username ' . $this->global_set['title_page'] . ' sudah digunakan, silahkan coba lagi');
                    }
                    break;
            }
        }
    }

    public function delete() {
        $id = $this->input->post('id');
        $this->crud_model->delete_data('users', 'users_id', $id);
        $this->db->query('ALTER TABLE users AUTO_INCREMENT = 1');
    }

}
