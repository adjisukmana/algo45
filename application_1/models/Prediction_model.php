<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Prediction_model extends CI_Model {

    public function show() {
//        $this->db->order_by('prediction_name', 'ASC');
        return $this->db->get('prediction')->result();
    }

    public function show_tree($table, $where = null, $group_by = null, $order_by = null, $sort = null, $limit = null) {
        if ($where != '') :
            $this->db->where($where);
        endif;
        if ($group_by != '') :
            $this->db->group_by($group_by);
        endif;
        if ($order_by != '') :
            $this->db->order_by($order_by, $sort);
        endif;
        if ($limit != '') :
            $this->db->limit($limit);
        endif;
        return $this->db->get($table);
    }

    public function show_by_parameter($parameter, $id) {
        $this->db->where($parameter, $id);
        return $this->db->get('prediction')->row();
    }

    public function show_by_parameters($where) {
        $this->db->where($where);
        return $this->db->get('prediction')->row();
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
