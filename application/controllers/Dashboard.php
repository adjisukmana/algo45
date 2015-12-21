<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/Backend.php';

class Dashboard extends Backend {

    private $global_set = array(
        'title' => 'Dashboard',
        'title_head' => '<i class="ion ion-levels"></i> Master Kategori Rule Barang',
        'title_page' => 'Dashboard',
    );

    public function __construct() {
        parent::__construct();
        $this->load->model(array('product_rule_ct_model', 'product_rule_model', 'product_model'));
    }

    public function index() {
        $data = $this->global_set;
        $this->load_css('plugins/datatables/dataTables.bootstrap.css');

        $this->load_js('plugins/datatables/jquery.dataTables.min.js');
        $this->load_js('plugins/datatables/dataTables.bootstrap.min.js');
        parent::display('dashboard', $data);
    }

}
