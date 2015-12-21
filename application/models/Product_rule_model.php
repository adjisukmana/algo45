<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_rule_model extends CI_Model {

    public function show() {
        $this->db->join('product_rule_ct', 'product_rule.product_rule_ct_id = product_rule_ct.product_rule_ct_id', 'LEFT');
        $this->db->order_by('product_rule_ct_name, product_rule_set, product_rule_value', 'ASC');
        return $this->db->get('product_rule')->result();
    }

    public function show_condition($parameter = null) {
        if ($parameter != null) :
            $this->db->where_not_in('product_rule.product_rule_ct_id', $parameter);
        endif;
        $this->db->join('product_rule_ct', 'product_rule.product_rule_ct_id = product_rule_ct.product_rule_ct_id', 'LEFT');
        $this->db->order_by('product_rule_ct_name, product_rule_set, product_rule_value', 'ASC');
        return $this->db->get('product_rule')->result();
    }

    public function show_by_param($parameter) {
        $this->db->join('product_rule_ct', 'product_rule.product_rule_ct_id = product_rule_ct.product_rule_ct_id', 'LEFT');
        $this->db->where($parameter);
        return $this->db->get('product_rule')->row();
    }

    public function show_by($parameter, $id) {
        $this->db->where($parameter, $id);
        return $this->db->get('product_rule')->result();
    }

    public function show_by_parameter($parameter, $id) {
        $this->db->where($parameter, $id);
        return $this->db->get('product_rule')->row();
    }

    public function show_by_parameters($where) {
        $this->db->where($where);
        return $this->db->get('product_rule')->row();
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
