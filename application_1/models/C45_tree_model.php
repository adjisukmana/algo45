<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class C45_tree_model extends CI_Model {

    public function show() {
        return $this->db->get('c45_tree')->result();
    }

    public function show_by($where) {
        $this->db->where($where);
        return $this->db->get('c45_tree')->result_array();
    }

    public function show_by_parameter($parameter, $id) {
        $this->db->where($parameter, $id);
        return $this->db->get('c45_tree')->row();
    }

    public function show_by_parameters($where = null, $order = null, $sort = null, $limit = null) {
        if ($where != null) :
            $this->db->where($where);
        endif;
        if ($order != null):
            if ($sort != null):
                $this->db->order_by($order, $sort);
            else:
                $this->db->order_by($order);
            endif;
        endif;
        if($limit != null) :
            $this->db->limit($limit);
        endif;
        return $this->db->get('c45_tree')->row();
    }

    public function count_by_parameter($table, $parameter, $id) {
        $this->db->where($parameter, $id);
        return $this->db->count_all_results($table);
    }

    public function count_by_parameters($table, $parameter) {
        $this->db->where($parameter);
        return $this->db->count_all_results($table);
    }

}

/* End of file faq_model.php */
/* Location: ./application/models/faq_model.php */
