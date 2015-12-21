<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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
        $this->sess_user = $this->session->userdata($this->config->item("sess_loginsys"));
        if ($this->sess_user == "") :
            redirect("authentication/login");
        endif;
    }

    /* function to load view */

    protected function display($content_page = 'blank_page', $data = array()) {
        $data['RESOURCES_JS'] = $this->file_js;
        $data['RESOURCES_CSS'] = $this->file_css;
        $data['RESOURCES_MENU'] = '';
        if ($content_page == "blank_page") :
            $data['content_page'] = $content_page;
        else:
            $data['content_page'] = $content_page;
        endif;
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
