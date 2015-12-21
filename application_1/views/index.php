<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $this->config->item('title_head'); ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <link rel="stylesheet" href="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'fonts/font-awesome/css/font-awesome.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'fonts/ionicons/css/ionicons.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'css/bootstrap.min.css'); ?>">

        <!--
        Resources css adalah variabel yang dibentuk dan dipanggil ketika dibutuhkan. Misalnya ada tampilan yang membutuhkan tampilan tabel dengan 
        plugin datatables akan di load pada controller function modul tersebut dan akan di load link untuk memanggil css nya.
        -->
        <?php echo $RESOURCES_CSS; ?>

        <link rel="stylesheet" href="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'css/AdminLTE.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'css/artmine.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'css/skins/_all-skins.min.css'); ?>">

        <script src="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'plugins/jQuery/jQuery-2.1.4.min.js'); ?>"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-purple sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <a href="<?php echo site_url(); ?>" class="logo">
                    <span class="logo-mini"><i class='ion ion-card'></i></span>
                    <span class="logo-lg"><?php echo $this->config->item('title_head'); ?></span>
                </a>
                <nav class="navbar navbar-static-top" role="navigation">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-custom-menu" style="padding-right: 30px;">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="ion ion-person"></i>
                                    <span><?php echo $this->session->userdata($this->config->item("sess_loginsys"))['log_loginsys_access_name']; ?> <i class="caret"></i></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo site_url('users'); ?>"><i class="ion ion-ios-people"></i> Manajemen User</a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo site_url('authentication/logout'); ?>"><i class="ion ion-log-out"></i> Log Out</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <aside class="main-sidebar">
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        <li class="header">MAIN MENU</li>
                        <li><a href="<?php echo site_url('dashboard'); ?>"><i class="ion ion-ios-home"></i> <span>Dashboard</span></a></li>
                        <li><a href="<?php echo site_url('users'); ?>"><i class="ion ion-ios-people"></i> <span>Pegawai</span></a></li>
                        <li class="treeview">
                            <a href="#">
                                <i class="ion ion-grid"></i> <span>Barang</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo site_url('master/product'); ?>"><i class="ion ion-levels"></i> <span>Data Barang</span></a></li>
                                <li><a href="<?php echo site_url('master/product_rule'); ?>"><i class="ion ion-code-working"></i> <span>Rule Barang</span></a></li>
                                <li><a href="<?php echo site_url('master/product_rule_ct'); ?>"><i class="ion ion-code"></i> <span>Kategori Rule</span></a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo site_url('c45'); ?>"><i class="ion ion-cube"></i> <span>Pohon Keputusan</span></a></li>
                        <li><a href="<?php echo site_url('prediction'); ?>"><i class="ion ion-toggle-filled"></i> <span>Prediksi</span></a></li>
                    </ul>
                </section>
            </aside>

            <!--
            Pada bagian ini adalah content page apa yang akan diload.
            Semisal ada url dashboard.html akan memanggil controllers Dashboard.php pada bagian index.
            Pada function indext tersebut apakah ada variable content page yang diload maka akan ditampilkan
            sebagai tampilan yang di load pada halaman tersebut.
            -->
            <div class="content-wrapper"><?php $this->load->view($content_page); ?></div>

            <footer class="main-footer">
                <strong>Copyright &copy; 2014-2015 <?php echo $this->config->item('title_head'); ?>. </strong> All rights reserved.
            </footer>
        </div>

        <!--Load boostrap js--> 
        <script src="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'js/bootstrap.min.js'); ?>"></script>

        <!--
        Resources js adalah variabel yang dibentuk dan dipanggil ketika dibutuhkan. Misalnya ada tampilan yang membutuhkan tampilan tabel dengan 
        plugin datatables akan di load pada controller function modul tersebut dan akan di load link untuk memanggil js nya.
        -->
        <?php echo $RESOURCES_JS; ?>

        <!--Dibawah ini akan meload js yang digunakan pada sistem-->
        <script src="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
        <script src="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'plugins/fastclick/fastclick.min.js'); ?>"></script>
        <script src="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'js/app.min.js'); ?>"></script>
        <script src="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'js/demo.js'); ?>"></script>

    </body>
</html>
