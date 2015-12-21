<div class="form-group">
    <label>Username <?php echo $title_page; ?></label>
    <input type="hidden" name="mode" value="<?php echo $mode; ?>"/>
    <input type="hidden" name="users_id" value="<?php echo $users_id; ?>"/>
    <input <?php if($users_id != '') echo 'readonly'; ?> type="text" name="users_username" value="<?php echo $users_username; ?>" class="form-control" required="" placeholder="Username <?php echo $title_page; ?>"/>
    <span id='error_username' class='help-block text-red' style='display: none;'>*Field ini wajib di isi</span>
</div>
<div class="form-group">
    <label>Nama <?php echo $title_page; ?></label>
    <input type="text" name="users_name" value="<?php echo $users_name; ?>" class="form-control" required="" placeholder="Nama <?php echo $title_page; ?>"/>
    <span id='error_name' class='help-block text-red' style='display: none;'>*Field ini wajib di isi</span>
</div>
<div class="form-group">
    <label>Password <?php echo $title_page; ?></label>
    <input type="password" name="users_password" value="" class="form-control" required="" placeholder="Password <?php echo $title_page; ?>"/>
    <span id='error_password' class='help-block text-red' style='display: none;'>*Field ini wajib di isi</span>
</div>
<div class="form-group">
    <label>Konfirmasi Password <?php echo $title_page; ?></label>
    <input type="password" name="users_passwordconfirm" value="" class="form-control" required="" placeholder="Konfirmasi Password <?php echo $title_page; ?>"/>
    <span id='error_passwordconfirm' class='help-block text-red' style='display: none;'>*Field ini wajib di isi</span>
</div>
<div class="form-group">
    <label>Email <?php echo $title_page; ?></label>
    <input type="text" name="users_email" value="<?php echo $users_email; ?>" class="form-control" required="" placeholder="Email <?php echo $title_page; ?>"/>
    <span id='error_email' class='help-block text-red' style='display: none;'>*Field ini wajib di isi</span>
</div>
<script type="text/javascript">
    $('[name=users_username]').blur(function () {
        if (!$(this).val()) {
            $("#error_username").addClass('text-danger');
            $("#error_username").css("display", "block");
        } else {
            $("#error_username").removeClass('text-danger');
            $("#error_username").css("display", "none");
        }
    });
    $('[name=users_name]').blur(function () {
        if (!$(this).val()) {
            $("#error_name").addClass('text-danger');
            $("#error_name").css("display", "block");
        } else {
            $("#error_name").removeClass('text-danger');
            $("#error_name").css("display", "none");
        }
    });

    $("input").keypress(function (event) {
        if (event.which === 13) {
            save_data();
        }
    });
</script>
