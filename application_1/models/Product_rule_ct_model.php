<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_rule_ct_model extends CI_Model {

    public function show($where = null) {
        if ($where != null) :
            $this->db->where($where);
        endif;
        $this->db->select('product_rule_ct.product_rule_ct_id, product_rule_ct_name, COUNT(product_rule_id) as product_rule_ct_count');
        $this->db->join('product_rule', 'product_rule_ct.product_rule_ct_id = product_rule.product_rule_ct_id', 'LEFT');
        $this->db->group_by('product_rule_ct.product_rule_ct_id');
        return $this->db->get('product_rule_ct')->result();
    }

    public function show_by($where = null, $where2 = null) {
        if ($where != null) :
            $this->db->where($where);
        endif;
        if ($where2 != null) :
            $this->db->where("product_rule_ct_id NOT IN ($where2)");
        endif;
        return $this->db->get('product_rule_ct')->result();
    }

    public function show_by_parameter($parameter, $id) {
        $this->db->where($parameter, $id);
        return $this->db->get('product_rule_ct')->row();
    }

    public function count_by_parameter($table, $parameter, $id) {
        $this->db->where($parameter, $id);
        return $this->db->count_all_results($table);
    }

}

/* End of file faq_ct_model.php */
/* Location: ./application/models/faq_ct_model.php */
