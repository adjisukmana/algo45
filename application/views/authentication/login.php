<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login Authentication</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'fonts/font-awesome/css/font-awesome.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'fonts/ionicons/css/ionicons.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'css/AdminLTE.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'css/artmine.css'); ?>">
        <style>
            .login-box{margin-top: 12%;}
        </style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="<?php echo site_url(); ?>"><?php echo $this->config->item('title_head'); ?></a>
            </div>
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to app</p>
                <form action="<?php echo $form_action; ?>" method="post">
                    <div class="form-group has-feedback">
                        <input type="text" name='username' class="form-control" placeholder="Username">
                        <span class="ion ion-log-in form-control-feedback"></span>
                        <?php echo form_error('username'); ?>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name='password' class="form-control" placeholder="Password">
                        <span class="ion ion-lock-combination form-control-feedback"></span>
                        <?php echo form_error('password'); ?>
                    </div>
                    <?php if ($this->session->flashdata('flash_error') != "") : ?>
                        <p class='text-error'><?php echo $this->session->flashdata('flash_error'); ?></p>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat"><i class='ion ion-ionic'></i> Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script src="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'plugins/jQuery/jQuery-2.1.4.min.js'); ?>"></script>
        <script src="<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'js/bootstrap.min.js'); ?>"></script>
    </body>
</html>
