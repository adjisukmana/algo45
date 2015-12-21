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
    <form>
        <div class="box box-solid">
            <div class="box-header bg-gray">
                <h3 class="box-title"><i class="ion ion-levels"></i> Data <?php echo $title_page; ?></h3>
                <div class="box-tools pull-right">
                    <button id="btn-add" data-id="" type="button" data-toggle="modal" data-target="#myModal" class="btn btn-box-tool"><i class="ion ion-plus"></i> Add </button>
                    <button id="btn-refresh" data-id="" type="button" class="btn btn-box-tool"><i class="ion ion-refresh"></i> Refresh </button>
                    <!--<button id="btn-delete-check" data-id="" type="button" class="btn btn-box-tool"><i class="ion ion-trash-b"></i> Delete </button>-->
                </div>
            </div>
            <div class="box-body table-responsive" id="data"></div>
        </div>
    </form>
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
    function load_data() {
        $.ajax({
            url: "<?php echo site_url('master/product'); ?>",
            beforeSend: function () {
                $("#data").html("<img src='<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'img/ajax-loading.gif'); ?>' class='img-responsive' style='margin: 10px auto;'/>");
            },
            success: function () {
                $("#data").load('<?php echo site_url('master/product/show#data'); ?>');
            }
        });
    }

    function save_data() {
        if (!$('[name=product_name]').val()) {
            alert("Maaf ada field yang wajib di isi, mohon cek kembali");

            $("#error_name").addClass('text-red');
            $("#error_name").css("display", "block");
        } else {
            $.ajax({
                url: "<?php echo base_url('master/product/save'); ?>",
                data: $("form").serialize(),
                type: "POST",
                success: function () {
                    $('#myModal').modal('toggle');
                    $("#data").load('<?php echo base_url('master/product/show/#data'); ?>');
                }
            });
        }
    }

    function saved_data() {
        if ($(":checkbox:checked").length === 0) {
            alert('Pilih data dulu yang akan di hapus');
        } else {
            $.ajax({
                url: "<?php echo site_url('master/product/saved'); ?>",
                data: $("form").serialize(),
                type: "POST",
                beforeSend: function () {
                    $("#data").html("<img src='<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'img/ajax-loading.gif'); ?>' class='img-responsive' style='margin: 10px auto;'/>");
                },
                success: function () {
                    $("#data").load('<?php echo base_url('master/product/show/#data'); ?>');
                }
            });
        }
    }

    function modal_data(mode, id_param) {
        var id = id_param;
        var title = 'Tambah';
        $.ajax({
            url: "<?php echo base_url(); ?>master/product/modal/" + mode + '/' + id,
            beforeSend: function () {
                $(".modal-body").html("<img src='<?php echo base_url($this->config->item('resources_dir') . $this->config->item('resources_back') . 'img/ajax-loading.gif'); ?>' class='img-responsive' style='margin: 10px auto;'/>");
            },
            success: function (data) {
                if (mode === 'add') {
                    title = 'Tambah';
                    $(".modal-header").removeClass("bg-yellow");
                    $(".modal-header").addClass("bg-green");
                } else if (mode === 'edit') {
                    title = 'Ubah';
                    $(".modal-header").removeClass("bg-green");
                    $(".modal-header").addClass("bg-yellow");
                }
                $(".modal-title").html("<i class='ion ion-levels'></i> Form " + title);
                $(".modal-body").load("<?php echo base_url(); ?>master/product/modal/" + mode + '/' + id);
            }
        });
    }

    load_data();

    $(document).on("click", '[id^="btn-delete-check"]', function () {
        saved_data();
    });

    $(document).on("click", '[id^="btn-refresh"]', function () {
        load_data();
    });

    $(document).on("click", '[id^="btn-save"]', function () {
        save_data();
    });

    $(document).on("click", '[id^="btn-add"]', function () {
        modal_data('add', $(this).data('id'));
    });
</script>