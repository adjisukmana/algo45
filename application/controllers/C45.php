<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/Backend.php';

class C45 extends Backend {

    private $global_name = array(
        'title' => 'Algoritma C4.5',
        'title_head' => '<i class="ion ion-levels"></i> Master Algoritma C4.5',
        'title_page' => 'Algoritma C4.5',
        'bread_one' => 'Algoritma C4.5',
        'bread_two' => '',
        'bread_three' => '',
    );

    public function __construct() {
        parent::__construct();
        $this->load->model(
                array(
                    'c45_mining_model',
                    'c45_tree_model',
                    'product_model',
                    'product_rule_model',
                    'product_rule_ct_model'
                )
        );
    }

    public function index() {
        $data = $this->global_name;

        $this->load_css('plugins/datatables/dataTables.bootstrap.css');

        $this->load_js('plugins/datatables/jquery.dataTables.min.js');
        $this->load_js('plugins/datatables/dataTables.bootstrap.min.js');

        parent::display('c45/show', $data);
    }

    public function init() {
        $this->db->query('DELETE FROM c45_mining');
        $this->db->query('DELETE FROM c45_tree');
        $this->db->query('ALTER TABLE c45_mining AUTO_INCREMENT = 1');
        $this->db->query('ALTER TABLE c45_tree AUTO_INCREMENT = 1');
    }

    public function do_algorithm() {
        $this->init();
        $this->process(null, null, 1);
//        $this->process(array('product_time_delay' => 2,), array(1));
//        $this->process(array('product_time_delay' => 2, 'product_stock_buffer' => '>=0<=15'), array(1, 2));
//        $this->process(array('product_time_delay' => 2, 'product_stock_buffer' => '>=0<=15', 'product_result_sales' => '>=31<=60'), array(1, 2, 3));
//        $this->process(array('product_time_delay' => 2, 'product_stock_buffer' => '>=0<=15', 'product_result_sales' => '>=31<=60', 'product_stock_rest' => 4), array(1, 2, 3, 4));
    }

    public function process($rule = null, $value = null, $loop = null) {
        $array = array();
        if (empty($rule) AND empty($value)) :
            $condition = '';
            $condition_ct = '';
        else:
            //select ke pohon keputusan
            $condition = $rule;
            $condition_ct = $value;
        endif;

        $total_total = 0;
        $total_yes = 0;
        $total_no = 0;
        $total_entropy = 0;
        if (empty($rule) AND empty($value)) :
            //membuat global total untuk looping pertama kali
            $array['total'] = array(
                'total' => $this->product_model->count_by_parameters2('product', $condition),
                'yes' => $this->product_model->count_by_parameters2('product', $condition, array('product_decision' => 'Y')),
                'no' => $this->product_model->count_by_parameters2('product', $condition, array('product_decision' => 'T')),
            );
            $entropy_1 = ($array['total']['yes'] / $array['total']['total']);
            $entropy_2 = ($array['total']['no'] / $array['total']['total']);
            $array['total']['entropy'] = ((-($entropy_1) * log($entropy_1, 2)) + (-($entropy_2) * log($entropy_2, 2)));
            if (is_nan($array['total']['entropy'])) :
                $array['total']['entropy'] = 0;
            endif;

            $total_total = $array['total']['total'];
            $total_yes = $array['total']['yes'];
            $total_no = $array['total']['no'];
            $total_entropy = $array['total']['entropy'];
        else:
            //memanggil kondisi dengan rule yang terpilih untuk menjadi total per node
            $array['total'] = array(
                'total' => $this->product_model->count_by_parameters2('product', $condition),
                'yes' => $this->product_model->count_by_parameters2('product', $condition, array('product_decision' => 'Y')),
                'no' => $this->product_model->count_by_parameters2('product', $condition, array('product_decision' => 'T')),
            );
            if ($array['total']['total'] == 0) :
                $array['total'] = array(
                    'total' => 0,
                    'yes' => 0,
                    'no' => 0
                );
            else:
                $entropy_1 = ($array['total']['yes'] / $array['total']['total']);
                $entropy_2 = ($array['total']['no'] / $array['total']['total']);
                $array['total']['entropy'] = ((-($entropy_1) * log($entropy_1, 2)) + (-($entropy_2) * log($entropy_2, 2)));
                if (is_nan($array['total']['entropy'])) :
                    $array['total']['entropy'] = 0;
                endif;
                $total_total = $array['total']['total'];
                $total_yes = $array['total']['yes'];
                $total_no = $array['total']['no'];
                $total_entropy = $array['total']['entropy'];
            endif;
        endif;

        $category = $this->product_rule_model->show_condition($condition_ct);
        $count_rule = count($category);
        if ($count_rule > 0) :

            foreach ($category as $index => $row) :
                $product_field = $this->product_field_by_ct($row->product_rule_ct_id);

                $get_rule = $this->product_rule_model->show_by('product_rule_ct_id', $row->product_rule_ct_id);
                $count_rule = count($get_rule);
                $gain_temp = 0;
                $gain = 0;
                foreach ($get_rule as $indexrule => $rowrule) :
                    $array[$row->product_rule_ct_name][$rowrule->product_rule_value] = array(
                        'total' => $this->product_model->count_by_parameters2('product', $condition, array($product_field => $rowrule->product_rule_set)),
                        'yes' => $this->product_model->count_by_parameters2('product', $condition, array($product_field => $rowrule->product_rule_set, 'product_decision' => 'Y')),
                        'no' => $this->product_model->count_by_parameters2('product', $condition, array($product_field => $rowrule->product_rule_set, 'product_decision' => 'T'))
                    );
                    $yes = $array[$row->product_rule_ct_name][$rowrule->product_rule_value]['yes'];
                    $no = $array[$row->product_rule_ct_name][$rowrule->product_rule_value]['no'];
                    $total = $array[$row->product_rule_ct_name][$rowrule->product_rule_value]['total'];

                    $entropy = 0;
                    if ($total == 0 OR $yes == 0 OR $no == 0) :
                        $entropy = 0;
                    else:
                        $entropy_1 = ($yes / $total);
                        $entropy_2 = ($no / $total);
                        $entropy = ((-($entropy_1) * log($entropy_1, 2)) + (-($entropy_2) * log($entropy_2, 2)));
                        if (is_nan($entropy)) :
                            $entropy = 0;
                        endif;
                    endif;
                    if ($no == $yes):
                        $entropy = 1;
                    endif;
                    $array[$row->product_rule_ct_name][$rowrule->product_rule_value]['entropy'] = $entropy;
                    if ($total_total == 0) :
                        $gain_temp = 0;
                    else:
                        $gain_temp = $gain_temp + ($total / $total_total) * $entropy;
                    endif;
                    if (($indexrule + 1) == $count_rule) :
                        $gain = $total_entropy - $gain_temp;
                        $array[$row->product_rule_ct_name]['gain'] = $gain;
                    endif;
                endforeach;
//                echo '<br/>'.$count_rule.'  '. ($indexrule+1);
            endforeach;

            $gain_max = null;
            $gain_max_category = null;
            $count_array = count($array);
            $search_index = 1;
            foreach ($array as $index => $row) :
                if ($index != 'total') :
                    if ($row['gain'] > $gain_max) :
                        $gain_max = $row['gain'];
                        $gain_max_category = $index;
                    else:
                        $gain_max = $gain_max;
                        $gain_max_category = $gain_max_category;
                    endif;

                    $insert_data = array(
                        'c45_mining_ct_id' => $this->product_field_by_ct_name($index),
                        'c45_mining_rule_id' => 0,
                        'c45_mining_parent' => $index,
                        'c45_mining_value' => null,
                        'c45_mining_set' => null,
                        'c45_mining_total' => 0,
                        'c45_mining_yes' => 0,
                        'c45_mining_no' => 0,
                        'c45_mining_entropy' => 0,
                        'c45_mining_gain' => $row['gain'],
                        'c45_mining_sequence' => $loop,
                    );
                    $this->crud_model->insert_data('c45_mining', $insert_data);

                    foreach ($array[$index] as $in => $roa) :
                        if ($roa['total'] != '') :
                            $insert_data = array(
                                'c45_mining_ct_id' => $this->product_field_by_ct_name($index),
                                'c45_mining_rule_id' => $this->product_rule_by_id($this->product_field_by_ct_name($index), $in, 1),
                                'c45_mining_parent' => $index,
                                'c45_mining_value' => $in,
                                'c45_mining_set' => $this->product_rule_by_id($this->product_field_by_ct_name($index), $in, 2),
                                'c45_mining_total' => $roa['total'],
                                'c45_mining_yes' => $roa['yes'],
                                'c45_mining_no' => $roa['no'],
                                'c45_mining_entropy' => $roa['entropy'],
                                'c45_mining_gain' => 0,
                                'c45_mining_sequence' => $loop,
                            );
                            $this->crud_model->insert_data('c45_mining', $insert_data);

                            $decision = 'T';
                            if ($roa['yes'] != 0 && $roa['no'] == 0) :
                                $decision = 'Y';
                            elseif ($roa['yes'] == 0 && $roa['no'] != 0) :
                                $decision = 'T';
                            elseif ($roa['yes'] != 0 && $roa['no'] != 0) :
                                $decision = '?';
                            else:
                                $decision = '?';
                            endif;

                            $check_where = array(
                                'c45_tree_ct_id' => $this->product_field_by_ct_name($index),
                                'c45_tree_rule_id' => $this->product_rule_by_id($this->product_field_by_ct_name($index), $in, 1),
                            );
                            $check_on_tree = $this->c45_tree_model->count_by_parameters('c45_tree', $check_where);
                            if ($check_on_tree == 0) :
                                $insert_tree = array(
                                    'c45_tree_ct_id' => $this->product_field_by_ct_name($index),
                                    'c45_tree_rule_id' => $this->product_rule_by_id($this->product_field_by_ct_name($index), $in, 1),
                                    'c45_tree_parent' => $index,
                                    'c45_tree_value' => $in,
                                    'c45_tree_set' => $this->product_rule_by_id($this->product_field_by_ct_name($index), $in, 2),
                                    'c45_tree_total' => $roa['total'],
                                    'c45_tree_yes' => $roa['yes'],
                                    'c45_tree_no' => $roa['no'],
                                    'c45_tree_decision' => $decision,
                                    'c45_tree_loop' => $loop,
                                );

                                $this->crud_model->insert_data('c45_tree', $insert_tree);
                            else:
                                $get_tree = $this->c45_tree_model->show_by_parameters($check_where);
                                $update_tree = array(
                                    'c45_tree_id' => $get_tree->c45_tree_id,
                                    'c45_tree_ct_id' => $this->product_field_by_ct_name($index),
                                    'c45_tree_rule_id' => $this->product_rule_by_id($this->product_field_by_ct_name($index), $in, 1),
                                    'c45_tree_parent' => $index,
                                    'c45_tree_value' => $in,
                                    'c45_tree_set' => $this->product_rule_by_id($this->product_field_by_ct_name($index), $in, 2),
                                    'c45_tree_total' => $roa['total'],
                                    'c45_tree_yes' => $roa['yes'],
                                    'c45_tree_no' => $roa['no'],
                                    'c45_tree_decision' => $decision,
                                    'c45_tree_loop' => $loop,
                                );

                                $this->crud_model->update_data('c45_tree', $update_tree, 'c45_tree_id');
                            endif;
                        endif;
                    endforeach;

                endif;
                $search_index++;
            endforeach;

            $entropy_gain_max = array();
            $condition_new = null;
            $category_new = null;
            if ($gain_max_category != '') :
                foreach ($array[$gain_max_category] as $index => $row) :
                    $entropy_gain_max += array($index => $row['entropy']);
                endforeach;

                $entropy_gain = max($entropy_gain_max);
                $entropy_index = array_search(max($entropy_gain_max), $entropy_gain_max);

                $get_rule_new = $this->product_rule_model->show_by_param(array('product_rule_ct_name' => $gain_max_category, 'product_rule_value' => $entropy_index));

                $condition_new = array(
                    $this->product_field_by_ct($get_rule_new->product_rule_ct_id) => $get_rule_new->product_rule_set
                );
                $category_new = array(
                    $get_rule_new->product_rule_ct_id
                );
                if ($condition != null) : $condition_new = array_merge($condition, $condition_new);
                endif;
                if ($condition_ct != null) : $category_new = array_merge($condition_ct, $category_new);
                endif;
            endif;

            if ($array['total']['total'] != 0) :
                $this->loop($condition_new, $category_new, $loop + 1);
            endif;
        endif;
    }

    public function loop($condition, $value, $loop) {
        if ($condition != null AND $value != null) :
            $this->process($condition, $value, $loop);
        endif;
    }

    private function product_field_by_ct($id) {
        switch ($id):
            case 1:
                $name = 'product_stock_buffer';
                break;
            case 2:
                $name = 'product_time_delay';
                break;
            case 3:
                $name = 'product_result_sales';
                break;
            case 4:
                $name = 'product_stock_rest';
                break;
        endswitch;
        return $name;
    }

    private function product_field_by_ct_name($name) {
        switch ($name):
            case 'Minimal Stock':
                $name = 1;
                break;
            case 'Waktu Tunggu (Hari)':
                $name = 2;
                break;
            case 'Hasil Penjualan':
                $name = 3;
                break;
            case 'Sisa Stock':
                $name = 4;
                break;
        endswitch;
        return $name;
    }

    private function product_rule_by_id($ctid, $name, $mode) {
        $where = array(
            'product_rule_ct_id' => $ctid,
            'product_rule_value' => $name
        );
        $get = $this->product_rule_model->show_by_parameters($where);
        if (count($get) > 0) :
            if ($mode == 1) :
                return $get->product_rule_id;
            else:
                return $get->product_rule_set;
            endif;
        else:
            return 0;
        endif;
    }

    public function tree() {
        $result = $this->process_tree(1);
        echo $result;
    }

    public function process_tree($loop) {
        $result = null;
        $where = array('c45_tree_loop' => $loop);
        $get = $this->c45_tree_model->show_by($where);
        $get_parent = $this->c45_tree_model->show_by_parameters($where, 'c45_tree_loop', 'ASC', 1)->c45_tree_parent;
        $maximal_loop = $this->c45_tree_model->show_by_parameters(null, 'c45_tree_loop', 'DESC', 1)->c45_tree_loop;
        if ($maximal_loop != 0) :
            $i = 0;
            if (count($get) > 0) :
                $result .= '<li>' . $get_parent . '</li>';
                $result .= '<ul>';
                foreach ($get as $index => $row) :
                    if ($row['c45_tree_decision'] == '?') :
                        $result .= '<li>' . $row['c45_tree_value'] . '</li>';
                        $result .= '<ul>';
                        $result .= $this->process_tree($loop + 1);
                        $result .= '</ul>';
                    else:
                        $result .= '<li>';
                        $result .= $row['c45_tree_value'];
                        $result .= ' ======>  ';
                        $result .= ($row['c45_tree_decision'] == 'Y') ? '<strong>Ya</strong>' : '<strong>Tidak</strong>';
                        $result .= '</li>';
                    endif;
                    $i++;
                endforeach;
                $result .= '</ul>';
            endif;
        else:
            $result = 'Maaf belum ada data pada pohon keputusan, lakukan mining terlebih dahulu';
        endif;
        return $result;
    }

}
