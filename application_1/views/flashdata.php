<!--Halaman ini digunakan untuk inisiasi tampilan error apabila terjadi error pada saat tambah, ubah, hapus data-->
<?php if ($this->session->flashdata('error') != '') : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <span><?php echo $this->session->flashdata('error'); ?></span>
            </div>
        </div>
    </div>
<?php endif; ?>
