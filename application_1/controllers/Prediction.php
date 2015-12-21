<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/Backend.php';

class Prediction extends Backend {

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
        $this->load->model(array('prediction_model', 'product_rule_model', 'product_rule_ct_model'));
    }

    public function index() {
        $data = $this->global_name;

        $this->load_css('plugins/datatables/dataTables.bootstrap.css');

        $this->load_js('plugins/datatables/jquery.dataTables.min.js');
        $this->load_js('plugins/datatables/dataTables.bootstrap.min.js');

        parent::display('prediction/show', $data);
    }

    public function show() {
        $data = $this->global_name;
        $data['show'] = $this->prediction_model->show();
        $this->load->view('prediction/table', $data);
    }

    public function modal($mode, $id = null) {
        $data = $this->global_name;
        $show = $this->prediction_model->show_by_parameter('prediction_id', $id);
        $data['rule'] = $this->product_rule_ct_model->show();
        $data['dropdown'] = $this->product_rule_model->show();
        $data['mode'] = $mode;
        $data['prediction_id']              = (count($show) == 0) ? '' : $show->prediction_id;
        $data['prediction_name']            = (count($show) == 0) ? '' : $show->prediction_name;
        $data['prediction_stock_buffer']    = (count($show) == 0) ? '' : $show->prediction_stock_buffer;
        $data['prediction_time_delay']      = (count($show) == 0) ? '' : $show->prediction_time_delay;
        $data['prediction_result_sales']    = (count($show) == 0) ? '' : $show->prediction_result_sales;
        $data['prediction_stock_rest']      = (count($show) == 0) ? '' : $show->prediction_stock_rest;
        $data['prediction_decision']        = (count($show) == 0) ? '' : $show->prediction_decision;
        $this->load->view('prediction/modal', $data);
    }

    public function save() {
        $mode = $this->input->post('mode');
        $data = array(
            'prediction_id'             => ($this->input->post('prediction_id') == '') ? null : $this->input->post('prediction_id'),
            'prediction_name'           => $this->input->post('prediction_name'),
            'prediction_stock_buffer'   => $this->input->post('prediction_stock_buffer'),
            'prediction_time_delay'     => $this->input->post('prediction_time_delay'),
            'prediction_result_sales'   => $this->input->post('prediction_result_sales'),
            'prediction_stock_rest'     => $this->input->post('prediction_stock_rest'),
        );

        $check_where = array(
            'prediction_name'           => $this->input->post('prediction_name'),
            'prediction_stock_buffer'   => $this->input->post('prediction_stock_buffer'),
            'prediction_time_delay'     => $this->input->post('prediction_time_delay'),
            'prediction_result_sales'   => $this->input->post('prediction_result_sales'),
            'prediction_stock_rest'     => $this->input->post('prediction_stock_rest'),
            'prediction_decision'       => $this->input->post('prediction_decision'),
        );
        $check = $this->prediction_model->show_by_parameters($check_where);

        switch (count($check)) {
            case 0:
                $data['prediction_decision'] = $this->get_prediction($data['prediction_stock_buffer'], $data['prediction_time_delay'], $data['prediction_result_sales'], $data['prediction_stock_rest']);
                $this->crud_model->insert_data('prediction', $data);
                break;
            default:
                $this->session->set_flashdata('error', 'Kode ' . $this->global_name['title_page'] . ' sudah digunakan, silahkan coba lagi');
                break;
        }
    }

    public function get_prediction($stockbuffer = null, $timedelay = null, $resultsales = null, $stockrest = null) {
        $data = array(
            'product_stock_buffer' => $this->get_product_rule_ct_id(1, $stockbuffer, 1),
            'product_time_delay' => $this->get_product_rule_ct_id(1, $timedelay, 1),
            'product_result_sales' => $this->get_product_rule_ct_id(1, $resultsales, 1),
            'product_stock_rest' => $this->get_product_rule_ct_id(1, $stockrest, 1),
        );
        $check_stockbuffer = $this->prediction_model->show_tree('c45_tree', array('c45_tree_ct_id' => 1, 'c45_tree_rule_id' => $this->get_product_rule_by_parameter(1, $stockbuffer, 1)))->row();
        $check_timedelay = $this->prediction_model->show_tree('c45_tree', array('c45_tree_ct_id' => 2, 'c45_tree_rule_id' => $this->get_product_rule_by_parameter(2, $timedelay, 1)))->row();
        $check_resultsales = $this->prediction_model->show_tree('c45_tree', array('c45_tree_ct_id' => 3, 'c45_tree_rule_id' => $this->get_product_rule_by_parameter(3, $resultsales, 1)))->row();
        $check_stockrest = $this->prediction_model->show_tree('c45_tree', array('c45_tree_ct_id' => 4, 'c45_tree_rule_id' => $this->get_product_rule_by_parameter(4, $stockrest, 1)))->row();

        $condition = '?';
        if (count($check_stockbuffer) > 0) :
            if ($check_stockbuffer->c45_tree_decision == 'Y') :
                $condition = 'Y';
            elseif ($check_stockbuffer->c45_tree_decision == 'T') :
                $condition = 'T';
            else:
                if (count($check_timedelay) > 0) :
                    if ($check_timedelay->c45_tree_decision == 'Y') :
                        $condition = 'Y';
                    elseif ($check_timedelay->c45_tree_decision == 'T') :
                        $condition = 'T';
                    else:
                        if (count($check_resultsales) > 0) :
                            if ($check_resultsales->c45_tree_decision == 'Y') :
                                $condition = 'Y';
                            elseif ($check_resultsales->c45_tree_decision == 'T') :
                                $condition = 'T';
                            else:
                                if (count($check_stockrest) > 0) :
                                    if ($check_stockrest->c45_tree_decision == 'Y') :
                                        $condition = 'Y';
                                    elseif ($check_stockrest->c45_tree_decision == 'T') :
                                        $condition = 'T';
                                    else:
                                        $condition = '?';
                                    endif;
                                endif;
                            endif;
                        endif;
                    endif;
                endif;
            endif;
        endif;
        echo $condition;
        return $condition;
    }

    public function delete() {
        $id = $this->input->post('id');
        $this->crud_model->delete_data('prediction', 'prediction_id', $id);
        $this->db->query('ALTER TABLE prediction AUTO_INCREMENT = 1');
    }

    private function get_product_rule_ct_id($id) {
        switch ($id):
            case 1:
                $name = 'product_stock_buffer';
                break;
            case 2:
                $name = 'product_time_delay';
                break;
            case 3:
                $name = 'product_result_sales';
                break;
            case 4:
                $name = 'product_stock_rest';
                break;
        endswitch;
        return $name;
    }

    private function get_product_rule_by_parameter($ctid, $name, $mode) {
        $where = array(
            'product_rule_ct_id' => $ctid,
            'product_rule_set' => $name
        );
        $get = $this->product_rule_model->show_by_parameters($where);
        if (count($get) > 0) :
            if ($mode == 1) :
                return $get->product_rule_id;
            else:
                return $get->product_rule_set;
            endif;
        else:
            return 0;
        endif;
    }

}
