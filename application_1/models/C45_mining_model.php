<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class C45_mining_model extends CI_Model {

    public function show() {
        return $this->db->get('c45_mining')->result();
    }

    public function show_by($table, $where, $order = null, $sort = null, $limit = null) {
        $this->db->where($where);
        if ($order != null):
            if ($sort != null):
                $this->db->order_by($order, $sort);
            else:
                $this->db->order_by($order);
            endif;
        endif;
        if ($limit != null):
            $this->db->limit($limit);
        endif;
        return $this->db->get($table)->result();
    }

    public function show_by_parameter($parameter, $id) {
        $this->db->where($parameter, $id);
        return $this->db->get('c45_mining')->row();
    }

    public function show_by_parameters($where, $order = null, $sort = null) {
        $this->db->where($where);
        if ($order != null):
            if ($sort != null):
                $this->db->order_by($order, $sort);
            else:
                $this->db->order_by($order);
            endif;
        endif;
        return $this->db->get('c45_mining')->row();
    }

    public function show_by_parameters2($where, $where2, $order = null, $sort = null) {
        if ($where != null) :
            $this->db->where($where);
        endif;
        if ($where2 != null) :
            $this->db->where($where2);
        endif;
        if ($order != null):
            if ($sort != null):
                $this->db->order_by($order, $sort);
            else:
                $this->db->order_by($order);
            endif;
        endif;
        return $this->db->get('c45_mining')->row();
    }

    public function count_by_parameter($table, $parameter, $id) {
        $this->db->where($parameter, $id);
        return $this->db->count_all_results($table);
    }

    public function count_by_parameters($table, $parameter = null) {
        if ($parameter != null) :
            $this->db->where($parameter);
        endif;
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
