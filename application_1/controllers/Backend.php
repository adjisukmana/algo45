<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//Backend adalah controller utama/pusat dari semua controller.
//dimana backend akan menjadi extends setiap controller lainnya dikarenakan semua function dan setting backend digunakan
//pada setiap controller
//semisal adalah fungsi pengecekan user tersebut sudah login atau tidak
//maka akan dicek dengan function is_logged_in
//untuk menampilkan view load index dan mengganti setiap content_page / modul 
//gunakan pemanggila display yang dimana akan meload index disertai halaman content page yang akan diload
//content page diatur pada setiap function conroller lainnya ketika dipanggil / diakses
class Backend extends CI_Controller {

    public $portal_id = 0; //use for divide application mode ex : 1 => administrator site, 2 => public site

    /* Set Global Variable */
    private $file_css = null;
    private $file_js = null;
    protected $menu_active = null; /* current menu to set class is actived menu */
    protected $sess_user = array(); /* use for session user */

    public function __construct() {
        parent::__construct();
        $this->is_logged_in();
    }

    /* function check user is login */

    protected function is_logged_in() {
        //fungsi pengecekan login
        //apabila login tidak ada maka di arahkan kehalaman login
        $this->sess_user = $this->session->userdata($this->config->item("sess_loginsys"));
        if ($this->sess_user == "") :
            redirect("authentication/login");
        endif;
    }

    /* function to load view */

    protected function display($content_page = 'blank_page', $data = array()) {
        //resource js dan css digunakan untuk proses meload asset yang digunakan hanya pada tampilan tersebut
        //semisal tidak semua tampilan membutuhkan plugin datatable
        $data['RESOURCES_JS'] = $this->file_js;
        $data['RESOURCES_CSS'] = $this->file_css;
        $data['RESOURCES_MENU'] = '';
        //meload halaman content page.apabila kosong maka akan meload halaman blank_page
        if ($content_page == "blank_page") :
            $data['content_page'] = $content_page;
        else:
            //apabila variabel content page terisi maka variabel data content page di isi variabel content page
            $data['content_page'] = $content_page;
        endif;
        //meload halaman index
        $this->load->view("index.php", $data);
    }

    /* function load javascript */

    protected function load_js($address) {
        if (is_file($this->config->item('resources_dir') . $this->config->item("resources_back") . $address)) :
            $this->file_js .= '<script src="' . base_url($this->config->item('resources_dir') . $this->config->item("resources_back") . $address) . '" type="text/javascript"></script>';
            $this->file_js .= "\n";
        else :
            $this->file_js .= 'Javascript file ' . $address . ' is not found ! <br>';
        endif;
    }

    /* function load css */

    protected function load_css($address) {
        if (is_file($this->config->item('resources_dir') . $this->config->item("resources_back") . $address)) :
            $this->file_css .= '<link href="' . base_url($this->config->item('resources_dir') . $this->config->item("resources_back") . $address) . '" rel="stylesheet" type="text/css"/>';
        else:
            $this->file_css .= 'CSS File' . $address . ' is not found ! <br>';
        endif;
    }

}
