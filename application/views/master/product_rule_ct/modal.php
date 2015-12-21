<div class="form-group">
    <label>Nama <?php echo $title_page; ?></label>
    <input type="hidden" name="mode" value="<?php echo $mode; ?>"/>
    <input type="hidden" name="product_rule_ct_id" value="<?php echo $product_rule_ct_id; ?>"/>
    <input type="text" name="product_rule_ct_name" value="<?php echo $product_rule_ct_name; ?>" class="form-control" required="" placeholder="Nama <?php echo $title_page; ?>"/>
    <span id='error_name' class='help-block text-red' style='display: none;'>*Field ini wajib di isi</span>
</div>
<script type="text/javascript">
    $('[name=product_rule_ct_name]').blur(function () {
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
