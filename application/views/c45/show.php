<section class="content-header">
    <h1><i class="ion ion-levels"></i> Data <?php echo $title_page; ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>"><i class="ion ion-home"></i> Home</a></li>
        <?php echo ($bread_one != '') ? '<li class="active">' . $bread_one . '</li>' : ''; ?>
        <?php echo ($bread_two != '') ? '<li class="active">' . $bread_two . '</li>' : ''; ?>
        <?php echo ($bread_three != '') ? '<li class="active">' . $bread_three . '</li>' : ''; ?>
    </ol>
</section>
<section class="content">
    <div class="box box-solid">
        <div class="box-header bg-gray">
            <h3 class="box-title"><i class="ion ion-code-working"></i> Data <?php echo $title_page; ?></h3>
        </div>
        <div class="box-body table-responsive">
            <p class="lead"><a id="btn-process" style="color: #000; cursor: pointer;">Lakukan Mining C4.5</a></p>
            <div id="data"></div>
        </div>
    </div>
    <div class="box box-solid">
        <div class="box-header bg-gray">
            <h3 class="box-title"><i class="ion ion-fork-repo"></i> Pohon Keputusan C4.5</h3>
        </div>
        <div class="box-body table-responsive">
            <p class="lead"><a id="btn-tree" style="color: #000; cursor: pointer;">Tampilkan Pohon Keputusan C4.5</a></p>
            <div id="data-tree"></div>
        </div>
    </div>
</section>
<div class="modal fade bs-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form>
                <div class="modal-header uppercase text-center"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="myModalLabel">Modal title</h4></div>
                <div class="modal-body"></div>
                <div class="modal-footer bg-gray"><button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="ion ion-arrow-left-a"></i> Close</button><button id="btn-save" type="button" class="btn btn-sm btn-primary"><i class="ion ion-arrow-down-a"></i> Save</button></div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function process_data() {
        $.ajax({
            url: "<?php echo site_url('c45/do_algorithm'); ?>",
            beforeSend: function () {
                $("#data").html("<img src='<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'img/ajax-loading.gif'); ?>' class='img-responsive' style='margin: 10px auto;'/>");
            },
            success: function () {
                $("#data").html('<p class="lead">Proses perhitungan selsai. sukses <br/> Page rendered in <strong>{elapsed_time}</strong> seconds.</p>');
            }
        });
    }
    function process_tree() {
        $.ajax({
            url: "<?php echo site_url('c45/tree'); ?>",
            beforeSend: function () {
                $("#data-tree").html("<img src='<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'img/ajax-loading.gif'); ?>' class='img-responsive' style='margin: 10px auto;'/>");
            },
            success: function () {
                $("#data-tree").load("<?php echo site_url('c45/tree'); ?>");
            }
        });
    }

    $(document).on("click", '[id^="btn-process"]', function () {
        process_data();
    });

    $(document).on("click", '[id^="btn-tree"]', function () {
        process_tree();
    });
</script>