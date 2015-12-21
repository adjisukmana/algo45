<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/Backend.php';

class Product_rule_ct extends Backend {

    private $global_set = array(
        'title' => 'Kategori Rule Barang',
        'title_head' => '<i class="ion ion-levels"></i> Master Kategori Rule Barang',
        'title_page' => 'Kategori Rule Barang',
        'bread_one' => 'Kategori Rule Barang',
        'bread_two' => '',
        'bread_three' => '',
    );

    public function __construct() {
        parent::__construct();
        $this->load->model('product_rule_ct_model');
    }

    public function index() {
        $data = $this->global_set;

        $this->load_css('plugins/datatables/dataTables.bootstrap.css');

        $this->load_js('plugins/datatables/jquery.dataTables.min.js');
        $this->load_js('plugins/datatables/dataTables.bootstrap.min.js');

        parent::display('master/product_rule_ct/show', $data);
    }

    public function show() {
        $data = $this->global_set;
        $data['show'] = $this->product_rule_ct_model->show();
        $this->load->view('master/product_rule_ct/table', $data);
    }

    public function modal($mode, $id = null) {
        $data = $this->global_set;
        $show = $this->product_rule_ct_model->show_by_parameter('product_rule_ct_id', $id);
        $data['mode'] = $mode;
        $data['product_rule_ct_id'] = (count($show) == 0) ? '' : $show->product_rule_ct_id;
        $data['product_rule_ct_name'] = (count($show) == 0) ? '' : $show->product_rule_ct_name;
        $this->load->view('master/product_rule_ct/modal', $data);
    }

    public function save() {
        $mode = $this->input->post('mode');
        $data = array(
            'product_rule_ct_id' => ($this->input->post('product_rule_ct_id') == '') ? null : $this->input->post('product_rule_ct_id'),
            'product_rule_ct_name' => ucwords($this->input->post('product_rule_ct_name')),
        );

        $check = $this->product_rule_ct_model->show_by_parameter('product_rule_ct_name', $this->input->post('product_rule_ct_name'));
        if ($mode == 'add') {
            switch (count($check)) {
                case 0:
                    $this->crud_model->insert_data('product_rule_ct', $data);
                    break;
                default:
                    $this->session->set_flashdata('error', 'Kode ' . $this->global_set['title_page'] . ' sudah digunakan, silahkan coba lagi');
                    break;
            }
        } else {
            switch (count($check)) {
                case 0:
                    $this->crud_model->update_data('product_rule_ct', $data, 'product_rule_ct_id');
                    break;
                default:
                    if ($check->product_rule_ct_id == $this->input->post('product_rule_ct_id')) {
                        $this->crud_model->update_data('product_rule_ct', $data, 'product_rule_ct_id');
                    } else {
                        $this->session->set_flashdata('error', 'Nama ' . $this->global_set['title_page'] . ' sudah digunakan, silahkan coba lagi');
                    }
                    break;
            }
        }
    }

    public function saved() {
        $id = $this->input->post('checkboxes');
        if (!empty($id)) {
            for ($i = 0; $i < count($id); ++$i) {
                $check = $this->product_rule_ct_model->count_by_parameter('product_rule', 'product_rule_ct_id', $id[$i]);
                if ($check == 0) {
                    $this->crud_model->delete_data('product_rule_ct', 'product_rule_ct_id', $id[$i]);
                }
            }
            $this->db->query('ALTER TABLE product_rule_ct AUTO_INCREMENT = 1');
        } else {
            $this->session->set_flashdata('error', 'Pilih data dulu yang akan di hapus');
        }
    }

    public function delete() {
        $id = $this->input->post('id');
        $check = $this->product_rule_ct_model->count_by_parameter('product_rule', 'product_rule_ct_id', $id);
        if ($check == 0) {
            $this->crud_model->delete_data('product_rule_ct', 'product_rule_ct_id', $id);
            $this->db->query('ALTER TABLE product_rule_ct AUTO_INCREMENT = 1');
        } else {
            $this->session->set_flashdata('error', '' . $this->global_set['title_page'] . ' masih digunakan pada master kelas, silahkan coba lagi');
        }
    }

}
