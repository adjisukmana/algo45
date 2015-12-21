<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_model extends CI_Model {

    public function show() {
//        $this->db->order_by('product_name', 'ASC');
        return $this->db->get('product')->result();
    }

    public function show_by_parameter($parameter, $id) {
        $this->db->where($parameter, $id);
        return $this->db->get('product')->row();
    }

    public function show_by_parameters($where) {
        $this->db->where($where);
        return $this->db->get('product')->row();
    }

    public function count_by_parameter($table, $parameter, $id) {
        $this->db->where($parameter, $id);
        return $this->db->count_all_results($table);
    }

    public function count_by_parameters($table, $parameter) {
        $this->db->where($parameter);
        return $this->db->count_all_results($table);
    }

    public function count_by_parameters2($table, $parameter = null, $parameter2 = null) {
        if ($parameter != null) :
            $this->db->where($parameter);
        endif;
        if ($parameter2 != null) :
            $this->db->where($parameter2);
        endif;
        return $this->db->count_all_results($table);
    }

}

/* End of file faq_model.php */
/* Location: ./application/models/faq_model.php */
