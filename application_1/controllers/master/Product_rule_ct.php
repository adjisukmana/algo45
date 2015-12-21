<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/Backend.php';
//semua controller kecuali backend akan extends pada controller backend
//dimana backend memiliki function yang dipanggil setiap controller
//sebenernya product_rule_ct ini tidak bisa tambah atau ubah atau hapus
//dikarenakan pada proses mining kategori ini dikunci pada kondisi - kondisi yang diperlukan
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
        //melakukan load model product_rule_ct_model
        $this->load->model('product_rule_ct_model');
    }

    public function index() {
        //halaman utama dari controller product_rule_ct atau kategori rule
        $data = $this->global_set;

        //pada halaman ini akan meload css dan js yang dibutuhkan adalah datatable
        //plugin datatable digunakan untuk menampilkan data pada tabel dengan pagination dan searching secara otomatis 
        //dari data yang ada
        $this->load_css('plugins/datatables/dataTables.bootstrap.css');

        $this->load_js('plugins/datatables/jquery.dataTables.min.js');
        $this->load_js('plugins/datatables/dataTables.bootstrap.min.js');

        //tampilkan halaman show pada folder views/master/product_rule_ct
        parent::display('master/product_rule_ct/show', $data);
    }

    public function show() {
        //function show akan menampilkan tabel yang dipanggil pada halaman show yang di load di function index
        //dimana table tersebut dipanggil dengan ajax dan di load pada div id data
        //membawa data product_rule_ct_model dari function show()
        //yang akan ditampilkan ditabel
        $data = $this->global_set;
        $data['show'] = $this->product_rule_ct_model->show();
        $this->load->view('master/product_rule_ct/table', $data);
    }

    public function modal($mode, $id = null) {
        //fucntion modal ini digunakan untuk tambah dan ubah data
        //modal ini akan menampilkan pop up yang membawa form untuk ditambah atau diubah
        //untuk epngecekan apabila id tidak kosong maka akan ada variabel data yang di isi oleh value dari database
        //dimana data tersebut diperoleh berdasarkan id tersebut
        //misal saya mengubah data kategori id 1 maka ada 2 variabel yaitu product_rule_ct_id dan product_rule_ct_name
        //dengan value dari database yang ada
        $data = $this->global_set;
        $show = $this->product_rule_ct_model->show_by_parameter('product_rule_ct_id', $id);
        $data['mode'] = $mode;
        $data['product_rule_ct_id'] = (count($show) == 0) ? '' : $show->product_rule_ct_id;
        $data['product_rule_ct_name'] = (count($show) == 0) ? '' : $show->product_rule_ct_name;
        //melakukan load view modal yang berdas di folder view/master/product_rule_ct
        $this->load->view('master/product_rule_ct/modal', $data);
    }

    public function save() {
        //proses save tambah atau ubah data
        $mode = $this->input->post('mode');
        
        //menampung data dari post form dari modal kedalam variabel data
        $data = array(
            'product_rule_ct_id' => ($this->input->post('product_rule_ct_id') == '') ? null : $this->input->post('product_rule_ct_id'),
            'product_rule_ct_name' => ucwords($this->input->post('product_rule_ct_name')),
        );

        $check = $this->product_rule_ct_model->show_by_parameter('product_rule_ct_name', $this->input->post('product_rule_ct_name'));
        if ($mode == 'add') {
            //mode add akan menjadi mode untuk insert / tambah data
            //terdapat pengecekan pada $check dimana variabel tersebut melakukan check di database
            //ada kah data yang menggunakan nama yang sama dengan data yang barusan di inputkan
            //apabila tidak ada makan akan insert data masuk case 0
            //apabila ditemukan 1 atau lebih data akan langsung keluar flash error
            //Kode sudah digunakan
            switch (count($check)) {
                case 0:
                    $this->crud_model->insert_data('product_rule_ct', $data);
                    break;
                default:
                    $this->session->set_flashdata('error', 'Kode ' . $this->global_set['title_page'] . ' sudah digunakan, silahkan coba lagi');
                    break;
            }
        } else {
            //mode else ini adalah mode ubah
            //mode ubah digunakan untuk mengubah data yang berdasarkan id priamry key / utama dari tabel tersebut
            //apabila ketika melakukan update namun ditemukan nama yang sama dengan data yang diubah
            //dengan kondisi id nya berbeda / tidak sama dengan id yang sedang dirubah
            //maka akan keluar flash error
            //apabila tidak ditemukan maka akan ubah data
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

    //ini tidak digunakan
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

    //fungsi untuk menghapus
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
