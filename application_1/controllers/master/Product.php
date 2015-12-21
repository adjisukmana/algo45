<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/Backend.php';

class Product extends Backend {

    private $global_name = array(
        'title' => 'Barang',
        'title_head' => '<i class="ion ion-levels"></i> Master Barang',
        'title_page' => 'Barang',
        'bread_one' => 'Barang',
        'bread_two' => '',
        'bread_three' => '',
    );

    public function __construct() {
        parent::__construct();
        $this->load->model(array('product_model', 'product_rule_model', 'product_rule_ct_model'));
    }

    public function index() {
        $data = $this->global_name;

        $this->load_css('plugins/datatables/dataTables.bootstrap.css');

        $this->load_js('plugins/datatables/jquery.dataTables.min.js');
        $this->load_js('plugins/datatables/dataTables.bootstrap.min.js');

        parent::display('master/product/show', $data);
    }

    public function show() {
        $data = $this->global_name;
        $data['show'] = $this->product_model->show();
        $this->load->view('master/product/table', $data);
    }

    public function modal($mode, $id = null) {
        $data = $this->global_name;
        $show = $this->product_model->show_by_parameter('product_id', $id);
        $data['rule'] = $this->product_rule_ct_model->show();
        $data['dropdown'] = $this->product_rule_model->show();
        $data['mode'] = $mode;
        $data['product_id'] = (count($show) == 0) ? '' : $show->product_id;
        $data['product_name'] = (count($show) == 0) ? '' : $show->product_name;
        $data['product_stock_buffer'] = (count($show) == 0) ? '' : $show->product_stock_buffer;
        $data['product_time_delay'] = (count($show) == 0) ? '' : $show->product_time_delay;
        $data['product_result_sales'] = (count($show) == 0) ? '' : $show->product_result_sales;
        $data['product_stock_rest'] = (count($show) == 0) ? '' : $show->product_stock_rest;
        $data['product_decision'] = (count($show) == 0) ? '' : $show->product_decision;
        $this->load->view('master/product/modal', $data);
    }

    public function save() {
        $mode = $this->input->post('mode');
        $data = array(
            'product_id' => ($this->input->post('product_id') == '') ? null : $this->input->post('product_id'),
            'product_name' => $this->input->post('product_name'),
            'product_stock_buffer' => $this->input->post('product_stock_buffer'),
            'product_time_delay' => $this->input->post('product_time_delay'),
            'product_result_sales' => $this->input->post('product_result_sales'),
            'product_stock_rest' => $this->input->post('product_stock_rest'),
            'product_decision' => $this->input->post('product_decision'),
        );

        $check = $this->product_model->show_by_parameters(
                array(
                    'product_name' => $this->input->post('product_name'),
                    'product_stock_buffer' => $this->input->post('product_stock_buffer'),
                    'product_time_delay' => $this->input->post('product_time_delay'),
                    'product_result_sales' => $this->input->post('product_result_sales'),
                    'product_stock_rest' => $this->input->post('product_stock_rest'),
                    'product_decision' => $this->input->post('product_decision'),
                )
        );
        if ($mode == 'add') {
            switch (count($check)) {
                case 0:
                    $this->crud_model->insert_data('product', $data);
                    break;
                default:
                    $this->session->set_flashdata('error', 'Kode ' . $this->global_name['title_page'] . ' sudah digunakan, silahkan coba lagi');
                    break;
            }
        } else {
            switch (count($check)) {
                case 0:
                    $this->crud_model->update_data('product', $data, 'product_id');
                    break;
                default:
                    if ($check->product_id == $this->input->post('product_id')) {
                        $this->crud_model->update_data('product', $data, 'product_id');
                    } else {
                        $this->session->set_flashdata('error', 'Nama ' . $this->global_name['title_page'] . ' sudah digunakan, silahkan coba lagi');
                    }
                    break;
            }
        }
    }

    public function saved() {
        $id = $this->input->post('checkboxes');
        if (!empty($id)) {
            for ($i = 0; $i < count($id); ++$i) {
                $this->crud_model->delete_data('product', 'product_id', $id[$i]);
            }
            $this->db->query('ALTER TABLE product AUTO_INCREMENT = 1');
        } else {
            $this->session->set_flashdata('error', 'Pilih data dulu yang akan di hapus');
        }
    }

    public function delete() {
        $id = $this->input->post('id');
        $this->crud_model->delete_data('product', 'product_id', $id);
        $this->db->query('ALTER TABLE product AUTO_INCREMENT = 1');
    }

}
