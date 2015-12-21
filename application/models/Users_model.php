<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Users_model extends CI_Model {

    public function show() {
        $this->db->order_by('users_username');
        return $this->db->get('users')->result();
    }

    public function show_by_parameter($parameter, $id) {
        $this->db->where($parameter, $id);
        return $this->db->get('users')->row();
    }

}

/* End of file faq_ct_model.php */
/* Location: ./application/models/faq_ct_model.php */
