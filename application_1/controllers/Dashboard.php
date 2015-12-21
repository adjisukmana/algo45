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
        //halaman pertama / dashboard
        //pada halaman ini hanya menampilkan tampilan dashboard pada index 
        //cara menampilkan adalah memanggil function display dari extends Backend dan sebutkan nama content page
        //pada bagian ini content page adalah dashboard
        //data global set adalah nama title halaman 
        //title had untuk nama head pada halaman
        //title page untuk kondisi - kondisi nama yang ditampilkan
        $data = $this->global_set;
        parent::display('dashboard', $data);
    }

}
