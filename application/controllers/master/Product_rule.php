<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/Backend.php';

class Product_rule extends Backend {

    private $global_set = array(
        'title' => 'Rule Barang',
        'title_head' => '<i class="ion ion-levels"></i> Master Rule Barang',
        'title_page' => 'Rule Barang',
        'bread_one' => 'Rule Barang',
        'bread_two' => '',
        'bread_three' => '',
    );

    public function __construct() {
        parent::__construct();
        $this->load->model(array('product_rule_model', 'product_rule_ct_model'));
    }

    public function index() {
        $data = $this->global_set;

        $this->load_css('plugins/datatables/dataTables.bootstrap.css');

        $this->load_js('plugins/datatables/jquery.dataTables.min.js');
        $this->load_js('plugins/datatables/dataTables.bootstrap.min.js');

        parent::display('master/product_rule/show', $data);
    }

    public function show() {
        $data = $this->global_set;
        $data['show'] = $this->product_rule_model->show();
        $this->load->view('master/product_rule/table', $data);
    }

    public function modal($mode, $id = null) {
        $data = $this->global_set;
        $show = $this->product_rule_model->show_by_parameter('product_rule_id', $id);
        $data['dropdown'] = $this->product_rule_ct_model->show();
        $data['mode'] = $mode;
        $data['product_rule_id'] = (count($show) == 0) ? '' : $show->product_rule_id;
        $data['product_rule_set'] = (count($show) == 0) ? '' : $show->product_rule_set;
        $data['product_rule_value'] = (count($show) == 0) ? '' : $show->product_rule_value;
        $data['product_rule_ct_id'] = (count($show) == 0) ? '' : $show->product_rule_ct_id;
        $this->load->view('master/product_rule/modal', $data);
    }

    public function save() {
        $mode = $this->input->post('mode');
        $data = array(
            'product_rule_id' => ($this->input->post('product_rule_id') == '') ? null : $this->input->post('product_rule_id'),
            'product_rule_ct_id' => $this->input->post('product_rule_ct_id'),
            'product_rule_set' => $this->input->post('product_rule_set'),
            'product_rule_value' => $this->input->post('product_rule_value'),
        );

        $check = $this->product_rule_model->show_by_parameters(array('product_rule_set' => $this->input->post('product_rule_set'), 'product_rule_ct_id' => $this->input->post('product_rule_ct_id')));
        if ($mode == 'add') {
            switch (count($check)) {
                case 0:
                    $this->crud_model->insert_data('product_rule', $data);
                    break;
                default:
                    $this->session->set_flashdata('error', 'Kode ' . $this->global_set['title_page'] . ' sudah digunakan, silahkan coba lagi');
                    break;
            }
        } else {
            switch (count($check)) {
                case 0:
                    $this->crud_model->update_data('product_rule', $data, 'product_rule_id');
                    break;
                default:
                    if ($check->product_rule_id == $this->input->post('product_rule_id')) {
                        $this->crud_model->update_data('product_rule', $data, 'product_rule_id');
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
                $this->crud_model->delete_data('product_rule', 'product_rule_id', $id[$i]);
            }
            $this->db->query('ALTER TABLE product_rule AUTO_INCREMENT = 1');
        } else {
            $this->session->set_flashdata('error', 'Pilih data dulu yang akan di hapus');
        }
    }

    public function delete() {
        $id = $this->input->post('id');
        $this->crud_model->delete_data('product_rule', 'product_rule_id', $id);
        $this->db->query('ALTER TABLE product_rule AUTO_INCREMENT = 1');
    }

}
