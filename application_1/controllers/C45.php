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
        // melakukan inisiasi load model yang akan digunakan.
        // banyak model yang digunakan pada perhitungan c45 nya.
        // model adalah function yang disusun untuk memperoleh data dari 
        // database sesuai kondisi yang diperlukan
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
        // function ini dipanggil ketika melakukan proses mining. 
        // pada function init ini tujuannya adalah melakukan clear data 
        // di tabel tabel yang akan digunakan
        $this->db->query('DELETE FROM c45_mining');
        $this->db->query('DELETE FROM c45_tree');
        $this->db->query('ALTER TABLE c45_mining AUTO_INCREMENT = 1');
        $this->db->query('ALTER TABLE c45_tree AUTO_INCREMENT = 1');
    }

    public function do_algorithm() {
        //do algorithm dipanggil ketika proses mining
        //yang dipanggil pertama kali adalah function init
        //kemudian melakukan proses tahap pertama.
        $this->init();
        $this->process(null, null, 1);
        //dibawah ini adalah testing iterasi secara bertahap
        //$this->process(array('product_time_delay' => 2,), array(1));
        //$this->process(array('product_time_delay' => 2, 'product_stock_buffer' => '>=0<=15'), array(1, 2));
        //$this->process(array('product_time_delay' => 2, 'product_stock_buffer' => '>=0<=15', 'product_result_sales' => '>=31<=60'), array(1, 2, 3));
        //$this->process(array('product_time_delay' => 2, 'product_stock_buffer' => '>=0<=15', 'product_result_sales' => '>=31<=60', 'product_stock_rest' => 4), array(1, 2, 3, 4));
    }

    public function process($rule = null, $value = null, $loop = null) {
        $array = array();
        //disini akan ada inisiasi kondisi dari perulangan nya.
        //kondisi yang wajib adalah condition kategori dan rule nya
        if (empty($rule) AND empty($value)) :
            $condition = '';
            $condition_ct = '';
        else:
            //select ke pohon keputusan
            $condition = $rule;
            $condition_ct = $value;
        endif;

        //inisiasi variabel yang akan digunakan untuk total
        $total_total = 0;
        $total_yes = 0;
        $total_no = 0;
        $total_entropy = 0;
        if (empty($rule) AND empty($value)) :
            //membuat global total untuk looping pertama kali
            //membuat inisiasi variabel total dengan index total yes dan no. 
            //untuk kondisi total melakukan select / ambil data dari product dengan condition yang ada pada process perulangan perhitungan
            //untuk kondisi total melakukan select / ambil data dari product dengan condition yang ada pada process perulangan perhitungan dengan terdapat kondisi yes
            //untuk kondisi total melakukan select / ambil data dari product dengan condition yang ada pada process perulangan perhitungan dengan terdapat kondisi no
            $array['total'] = array(
                'total' => $this->product_model->count_by_parameters2('product', $condition),
                'yes' => $this->product_model->count_by_parameters2('product', $condition, array('product_decision' => 'Y')),
                'no' => $this->product_model->count_by_parameters2('product', $condition, array('product_decision' => 'T')),
            );
            //melakukan perhitungan entropy dengan memecah berdasarkan kondisi yes dan no terlebih dahulu 
            //sesudah itu akan dimasukkan pada variabel entropy dengan rumus entropy
            //apabila kondisinya adalah is_nan alias tidak ada value nya akan di default jadi 0
            $entropy_1 = ($array['total']['yes'] / $array['total']['total']);
            $entropy_2 = ($array['total']['no'] / $array['total']['total']);
            $array['total']['entropy'] = ((-($entropy_1) * log($entropy_1, 2)) + (-($entropy_2) * log($entropy_2, 2)));
            if (is_nan($array['total']['entropy'])) :
                $array['total']['entropy'] = 0;
            endif;
            //input nilai total pada variabel yang sudah dibentuk sebelumnya untuk digunakan pada proses pencarian gain
            $total_total = $array['total']['total'];
            $total_yes = $array['total']['yes'];
            $total_no = $array['total']['no'];
            $total_entropy = $array['total']['entropy'];
        else:
            //memanggil kondisi dengan rule yang terpilih untuk menjadi total per node
            //membuat inisiasi variabel total dengan index total yes dan no. 
            //untuk kondisi total melakukan select / ambil data dari product dengan condition yang ada pada process perulangan perhitungan
            //untuk kondisi total melakukan select / ambil data dari product dengan condition yang ada pada process perulangan perhitungan dengan terdapat kondisi yes
            //untuk kondisi total melakukan select / ambil data dari product dengan condition yang ada pada process perulangan perhitungan dengan terdapat kondisi no
            $array['total'] = array(
                'total' => $this->product_model->count_by_parameters2('product', $condition),
                'yes' => $this->product_model->count_by_parameters2('product', $condition, array('product_decision' => 'Y')),
                'no' => $this->product_model->count_by_parameters2('product', $condition, array('product_decision' => 'T')),
            );
            //apabila variabel total index total == 0 maka yes and no nya di set 0 juga
            if ($array['total']['total'] == 0) :
                $array['total'] = array(
                    'total' => 0,
                    'yes' => 0,
                    'no' => 0
                );
            else:
                //melakukan perhitungan entropy dengan memecah berdasarkan kondisi yes dan no terlebih dahulu 
                //sesudah itu akan dimasukkan pada variabel entropy dengan rumus entropy
                //apabila kondisinya adalah is_nan alias tidak ada value nya akan di default jadi 0
                $entropy_1 = ($array['total']['yes'] / $array['total']['total']);
                $entropy_2 = ($array['total']['no'] / $array['total']['total']);
                $array['total']['entropy'] = ((-($entropy_1) * log($entropy_1, 2)) + (-($entropy_2) * log($entropy_2, 2)));
                if (is_nan($array['total']['entropy'])) :
                    $array['total']['entropy'] = 0;
                endif;
                //input nilai total pada variabel yang sudah dibentuk sebelumnya untuk digunakan pada proses pencarian gain
                $total_total = $array['total']['total'];
                $total_yes = $array['total']['yes'];
                $total_no = $array['total']['no'];
                $total_entropy = $array['total']['entropy'];
            endif;
        endif;
        //melakukan select data rule product dengan kondisi kategori yang terdapat pada parameter process / iterasi
        //count rule digunakan untuk mengetahui berapa jumlah rule yang diperoleh.apabila lebih dari 0 maka lanjut
        $category = $this->product_rule_model->show_condition($condition_ct);
        $count_rule = count($category);
        if ($count_rule > 0) :
            //melakukan perulangan dari hasil select pada variable category
            foreach ($category as $index => $row) :
                //inisiasi field ditabel product berdasarkan kategori
                //jadi tabel rule ct tidak bisa diubah dikarenakan ditetapkan pada field product nya
                // 1 : Minimal Stock dan seterusnya sesuai urutan nya. dapat dicek di function product_field_by_ct dibawah
                $product_field = $this->product_field_by_ct($row->product_rule_ct_id);
                //memperoleh rule product berdasarkan rule ct yang didapatkan sebelumnya
                $get_rule = $this->product_rule_model->show_by('product_rule_ct_id', $row->product_rule_ct_id);
                //menghitung berapa jumlah rule yang ada
                $count_rule = count($get_rule);

                //inisiasi gain dan gain temp untuk proses perhitungan gain
                $gain_temp = 0;
                $gain = 0;
                //melakukan perulangan rule yang diperoleh sebelumnya dan menciptakan variabel berdasarkan nama kategori dan nilai rule
                //terdapat tiga index yaitu total yes dan no.
                //sama seperti variabel total di atas dimana akan mendapatkan condition dari setiap loop, dan ditambahkan kondisi berdasarkan product rule set yang ada
                //untuk kondisi yes atau no disertakan pada index masing masing
                foreach ($get_rule as $indexrule => $rowrule) :
                    $array[$row->product_rule_ct_name][$rowrule->product_rule_value] = array(
                        'total' => $this->product_model->count_by_parameters2('product', $condition, array($product_field => $rowrule->product_rule_set)),
                        'yes' => $this->product_model->count_by_parameters2('product', $condition, array($product_field => $rowrule->product_rule_set, 'product_decision' => 'Y')),
                        'no' => $this->product_model->count_by_parameters2('product', $condition, array($product_field => $rowrule->product_rule_set, 'product_decision' => 'T'))
                    );
                    //menyimpan value total yes no pada variabel dibawah ini agar mudah pada proses perhitungan entropy dan gain
                    $yes = $array[$row->product_rule_ct_name][$rowrule->product_rule_value]['yes'];
                    $no = $array[$row->product_rule_ct_name][$rowrule->product_rule_value]['no'];
                    $total = $array[$row->product_rule_ct_name][$rowrule->product_rule_value]['total'];

                    $entropy = 0;
                    //adapun kondisi - kondisi yang membatasi perhitungan agar tidak terdapat error dibagi 0 atau disebut DIVIDE BY ZERO
                    //dengan beberapa kondisi
                    //kondisi pertama ketika total 0 atau yes 0 atau no 0 maka entropy = 0
                    //ketika tidak seperti kondisi pertama maka akan dilakukan proses perhitungan entropy
                    if ($total == 0 OR $yes == 0 OR $no == 0) :
                        $entropy = 0;
                    else:
                        //memecah proses entropy dengan dibagi 2 menjadi kondisi yes/total dan no/total
                        //setelah itu dimasukkan pada variabel entropy
                        $entropy_1 = ($yes / $total);
                        $entropy_2 = ($no / $total);
                        $entropy = ((-($entropy_1) * log($entropy_1, 2)) + (-($entropy_2) * log($entropy_2, 2)));
                        //jika entropy is nan atau tidak terdefinisi berapa nilai nya akan di isi 0
                        if (is_nan($entropy)) :
                            $entropy = 0;
                        endif;
                    endif;
                    //ketika ada kondisi nilai no = yes maka entropy = 1
                    if ($no == $yes):
                        $entropy = 1;
                    endif;
                    //kemudian masukkan nilai entropy pada variabel kategori dengan value rule index entropy
                    $array[$row->product_rule_ct_name][$rowrule->product_rule_value]['entropy'] = $entropy;

                    //kondisi berikutnya adalah proses perhitungan gain
                    //ada kondisi ketika total_total (total paling atas pada setiap perulangan) == 0 maka gain temp = 0
                    if ($total_total == 0) :
                        $gain_temp = 0;
                    else:
                        //apabila tidak, gain temp adalah gain_temp itu sendiri + total per rule dibagi total dikali entropy
                        //gain temp adalah total dari semua rule perkategori untuk digunakan pada perhitungan gain
                        $gain_temp = $gain_temp + ($total / $total_total) * $entropy;
                    endif;
                    if (($indexrule + 1) == $count_rule) :
                        //ketika index setiap rule sudah maksimal maka akan dilakukan perhitungan gain
                        //gain = total entropy (total paling atas) - gain temp yang dihitung sebelumnya
                        $gain = $total_entropy - $gain_temp;
                        //di isi berapa nilai gain pada setiap kategori nya
                        $array[$row->product_rule_ct_name]['gain'] = $gain;
                    endif;
                endforeach;
            endforeach;

            //setelah gain di hitung pada iterasi. maka adalah proses pencarian gain maksimal pada setiap iterasi
            //inisiasi variabel variabel yang akan digunakan
            //gain max akan digunakan untuk nilai gain paling maksimal
            //gain max category digunakan untuk mengetahui nama kategori yang memiliki gain max tersebut
            $gain_max = null;
            $gain_max_category = null;
            $count_array = count($array);
            $search_index = 1;
            foreach ($array as $index => $row) :
                //perulangan dari variable array yang sudah ada 
                //terdapat index total dan index kategori rule
                //yang akan dicari adalah gain maksimal dari index kategori rule saja 
                //jadi ada kondisi apabila index bukan total
                if ($index != 'total') :
                    //kondisi ketika nilai gain pada array lebih besar dari nilai pada gain max
                    //maka gain max akan di isi oleh nilai gain pada array tersebut
                    //sedangkan gain max category di isi nama kategori rule tersebut
                    if ($row['gain'] > $gain_max) :
                        $gain_max = $row['gain'];
                        $gain_max_category = $index;
                    else:
                        //apabila tidak variabel gain max tetap dengan nilai gain max tersebut
                        //dan gain max category juga demikian
                        $gain_max = $gain_max;
                        $gain_max_category = $gain_max_category;
                    endif;

                    //membuat nilai array insert data untuk ke table c45_mining
                    //tabel c45 mining akan digunakan untuk membentuk data pada tabel c45_tree
                    //dan pohon keputusan 
                    $insert_data = array(
                        'c45_mining_ct_id' => $this->product_field_by_ct_name($index), //mendapatkan id kategori rule berdasarkan nama kategori
                        'c45_mining_rule_id' => 0,
                        'c45_mining_parent' => $index,
                        'c45_mining_value' => null,
                        'c45_mining_set' => null,
                        'c45_mining_total' => 0,
                        'c45_mining_yes' => 0,
                        'c45_mining_no' => 0,
                        'c45_mining_entropy' => 0,
                        'c45_mining_gain' => $row['gain'], // nilai gain setiap perulangan array nya.
                        'c45_mining_sequence' => $loop,
                    );
                    //insert data ketable c45_mining dengan variable insert_data
                    $this->crud_model->insert_data('c45_mining', $insert_data);

                    foreach ($array[$index] as $in => $roa) :
                        if ($roa['total'] != '') :
                            //apabila perulangan array ini bukan total maka akan melakukan proses input data ketabel mining
                            //dengan kondisi sebagai root per kategori.
                            //ditabel mining ini akan terdapaat data semua rule per kategori dimana setiap kategori ada 
                            //root kategori yang membawa nilai gain. root kategori terdapat pada input mining sebelumnya / diatas ini
                            //pada bawah ini adalah input rule product setiap kategori
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
                            //proses insert data ke tabel c45 mining untuk rule per kategori bukan root kategori dari data diatas ini
                            $this->crud_model->insert_data('c45_mining', $insert_data);

                            //inisiasi keputusan dengan default T (Tidak)
                            $decision = 'T';
                            //ketika kondisi yes diatas 0 dan no sama dengan 0  maka kondisi keputusan adalah yes / ya
                            if ($roa['yes'] != 0 && $roa['no'] == 0) :
                                $decision = 'Y';
                            //ketika kondisi yes 0 dan no tidak sama dengan 0 maka kondisi keputusan adalah no / tidak
                            elseif ($roa['yes'] == 0 && $roa['no'] != 0) :
                                $decision = 'T';
                            //apabila kondisi yes dan no tidak sama dengan 0 atau terdapat nilai masing -masing maka kondisinya ? 
                            elseif ($roa['yes'] != 0 && $roa['no'] != 0) :
                                $decision = '?';
                            else:
                                $decision = '?';
                            endif;

                            //kondisi check untuk tabel c45_tree yang akan di isi dengan melakukan select pada tabel c45_tree
                            //dengan id kategori rule dan id rule product
                            $check_where = array(
                                'c45_tree_ct_id' => $this->product_field_by_ct_name($index),
                                'c45_tree_rule_id' => $this->product_rule_by_id($this->product_field_by_ct_name($index), $in, 1),
                            );
                            //mengambil dan menghitung jumlah data pada c45_tree dengan kondisi yang dideklarasikan
                            $check_on_tree = $this->c45_tree_model->count_by_parameters('c45_tree', $check_where);
                            if ($check_on_tree == 0) :
                                //apabila == 0 atau tidak ada maka insert data c45_tree dengan demikian
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
                                //tambah data ke c45 tree dengan data diatas
                                $this->crud_model->insert_data('c45_tree', $insert_tree);
                            else:
                                //abila check diatas 0 maka data akan diupdate / diubah data nya yang sudah ada dengan 
                                //melakukan select berdasarkan kondisi dan dapatkan id c45_tree_id dan diupdate data nya
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
                                //proses update tree berdasarkan data yang ada
                                $this->crud_model->update_data('c45_tree', $update_tree, 'c45_tree_id');
                            endif;
                        endif;
                    endforeach;

                endif;
                $search_index++;
            endforeach;

            //disini adalah proses dimana akan adanya perulangan lanjutan dengan mendapatkan data gain max sebelumnya
            //data yang diperoleh akan dilempar sebagai parameter untuk loop / perulangan selanjutnya
            //dimana sudah diketahui gain max diatas berapa dan kemudian kita akan mencari rule mana yang memiliki entropy tertinggi
            //untuk dilakukannya proses perulangan selanjutnya berdasarkan data rule tersebut
            //dan menjadi kondisi untuk mengambil data selanjutnya
            $entropy_gain_max = array();
            $condition_new = null;
            $category_new = null;
            if ($gain_max_category != '') :
                foreach ($array[$gain_max_category] as $index => $row) :
                    //melakukan perulangan dengan mendapatkan semua entropy dari setiap gain.dan dicari mana entropy yang paling tinggi
                    //entropy paling tinggi tersebut akan sebagai total paling atas pada perulangan selanjutnya
                    $entropy_gain_max += array($index => $row['entropy']);
                endforeach;

                //mencari nilai max dari entropy yang ada
                $entropy_gain = max($entropy_gain_max);
                //mendapatkan index pada array entropy gain max 
                //dimana array nya adalah rule value product
                $entropy_index = array_search(max($entropy_gain_max), $entropy_gain_max);
                //select data rule untuk perulangan terbaru
                $get_rule_new = $this->product_rule_model->show_by_param(array('product_rule_ct_name' => $gain_max_category, 'product_rule_value' => $entropy_index));

                //kondisi terbaru dengan kategori yang diperoleh dari select sebelumnya
                $condition_new = array(
                    $this->product_field_by_ct($get_rule_new->product_rule_ct_id) => $get_rule_new->product_rule_set
                );
                //id kategori yang baru untuk perulangan selanjutnya
                $category_new = array(
                    $get_rule_new->product_rule_ct_id
                );
                //apabila condition pada parameter function process tidak kosong atau ada kondisi sebelumnya
                //maka akan digabungkan antara condition dengan condition new untuk loop selanjutnya
                //misal kondisi pertama dengan id kategori 1
                //dan loop kedua dengan id kategori 1 dan maksimal entropy pada id 2
                //untuk loop ketiga akan dengan id kategori 1 dan 2 dan selanjutnya
                if ($condition != null) : $condition_new = array_merge($condition, $condition_new);
                endif;
                //pada bawah ini untuk category value nya
                if ($condition_ct != null) : $category_new = array_merge($condition_ct, $category_new);
                endif;
            endif;

            //jika total total variabel diatas tidak sama dengan 0 atau masih ada data yang bisa di iterasikan 
            //maka panggil function loop dibawah dengan kondisi terbaru yang sudah digabungkan dengan kondisi lama
            //diberikan loop + 1 untuk mengetahui ini iterasi ditambahkan 1 karena next loop
            if ($array['total']['total'] != 0) :
                $this->loop($condition_new, $category_new, $loop + 1);
            endif;
        endif;
    }

    public function loop($condition, $value, $loop) {
        //cek apabila kondisi tidak kosong dan value tidak kosong
        //lakukan process dengan kondisi dan value yang ada
        if ($condition != null AND $value != null) :
            $this->process($condition, $value, $loop);
        endif;
    }

    private function product_field_by_ct($id) {
        //mendapatkan nama field pada tabel product berdasarkan kategori rule yang ada
        //makstnya 
        //id kategori 1 adalah field product_stock_buffer
        //id kategori 2 adalah product_time_delay
        //id kategori 3 adalah product_result_sales
        //id kategori 4 adalah product_stock_rest
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
        //mendapatkan nama id kategori berdasarkan nama kategori yang di inputkan
        //apabila 1 maka kategori Minimal Stock
        //apabila 2 maka kategori Waktu Tunggu (Hari)
        //apabila 3 maka kategori Hasil Penjualan
        //apabila 4 maka kategori Sisa Stock
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
        //mendapatkan id rule atau rule set product berdasarkan id kategori, rule value 
        $where = array(
            'product_rule_ct_id' => $ctid,
            'product_rule_value' => $name
        );
        //select data dengan kondisi tersebut
        $get = $this->product_rule_model->show_by_parameters($where);
        if (count($get) > 0) :
            //mode == 1 maka yang didapatkan adalah product_rule_id
            if ($mode == 1) :
                return $get->product_rule_id;
            else:
            //mode == 2 maka yang didapatkan adalah product_rule_set
                return $get->product_rule_set;
            endif;
        else:
            return 0;
        endif;
    }

    public function tree() {
        //process tree ini dipanggil ketika tampil pohon 
        //pada function ini akan memanggil process_tree dan dimasukkan dalam sebuah variabel result
        //yang akan ditampilkan nanti nya di pohon keputusan
        $result = $this->process_tree(1);
        echo $result;
    }

    public function process_tree($loop) {
        //process tree ini akan sebagai process tampil pohon keputusan
        //dengan kondisi berdasarkan loop yang ada.
        //dimana akan tampil dari data loop = 1 yang di panggil di function tree
        $result = null;
        //kondisi loop
        $where = array('c45_tree_loop' => $loop);
        //tampilkan data tree berdasarkan kondisi yang sudah disampaikan
        $get = $this->c45_tree_model->show_by($where);
        //dapatkan parent / kategori rule dengan kondisi diurutkan asc atau yang paling atas
        //dikarenakan data yang diambil adalah root kategori yang memiliki gain bukan kategori yang terdapat rule 
        $get_parent = $this->c45_tree_model->show_by_parameters($where, 'c45_tree_loop', 'ASC', 1)->c45_tree_parent;
        //mendapatkan jumlah maximal loop yang ada pada tabel c45_tree
        $maximal_loop = $this->c45_tree_model->show_by_parameters(null, 'c45_tree_loop', 'DESC', 1)->c45_tree_loop;
        if ($maximal_loop != 0) :
            //jika maximal loop tidak 0 maka ada kondisi disini
            //pada kondisi ini akan membentuk sebuah ul li html dengan secara pohon
            //misal ul
            //       li -> kategori a
            //       li -> kategori b
            //             ul 
            //              li -> kategori d
            //              li -> kategori e  
            //       li -> kategori c
            //secara dinamis
            $i = 0;
            if (count($get) > 0) :
                //jika data lebih dari 0 maka tampilkan nama kategori dengan li dan menciptkan ul setelahnya
                $result .= '<li>' . $get_parent . '</li>';
                $result .= '<ul>';
                //perulangan ini untuk memanggil kembalii process_tree dengan loop selanjutnya
                foreach ($get as $index => $row) :
                    if ($row['c45_tree_decision'] == '?') :
                        //apabila kondisi nya masih ? maka ada 2 kemungkinan
                        //1. data memiliki sub kategori lagi dari loop selanjutnya
                        //2. data tidak valid atau nilai yes dan no tidak 0
                        //dengan kondisi ? maka akan memanggil fucntion ini sendiri dengan loop + 1
                        $result .= '<li>' . $row['c45_tree_value'] . '</li>';
                        $result .= '<ul>';
                        $result .= $this->process_tree($loop + 1);
                        $result .= '</ul>';
                    else:
                        //tampilkan li dengan c45_tree_value dan kondisi nya
                        //apabila yes maka tampil tulisan Ya
                        //apabila no maka tampil tulisan Tidak
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
            //data belum ada pada tabel c45_tree
            $result = 'Maaf belum ada data pada pohon keputusan, lakukan mining terlebih dahulu';
        endif;
        return $result;
    }

}
