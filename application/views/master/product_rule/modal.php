<div class="form-group">
    <label>Kategori <?php echo $title_page; ?></label>
    <select name="product_rule_ct_id" class="form-control">
        <?php if (count($dropdown) > 0) : ?>
            <?php foreach ($dropdown as $row): ?>
                <option value="<?php echo $row->product_rule_ct_id; ?>" <?php echo ($product_rule_ct_id == $row->product_rule_ct_id) ? 'selected' : ''; ?>><?php echo $row->product_rule_ct_name; ?></option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
</div>
<div class="form-group">
    <label>Nilai <?php echo $title_page; ?></label>
    <input type="hidden" name="mode" value="<?php echo $mode; ?>"/>
    <input type="hidden" name="product_rule_id" value="<?php echo $product_rule_id; ?>"/>
    <input type="text" name="product_rule_set" value="<?php echo $product_rule_set; ?>" class="form-control" required="" placeholder="Nilai <?php echo $title_page; ?>"/>
    <span id='error_set' class='help-block text-red' style='display: none;'>*Field ini wajib di isi</span>
</div>
<div class="form-group">
    <label>Kondisi <?php echo $title_page; ?></label>
    <input type="text" name="product_rule_value" value="<?php echo $product_rule_value; ?>" class="form-control" required="" placeholder="Kondisi <?php echo $title_page; ?>"/>
    <span id='error_value' class='help-block text-red' style='display: none;'>*Field ini wajib di isi</span>
</div>
<script type="text/javascript">
    $('[name=product_rule_set]').blur(function () {
        if (!$(this).val()) {
            $("#error_set").addClass('text-danger');
            $("#error_set").css("display", "block");
        } else {
            $("#error_set").removeClass('text-danger');
            $("#error_set").css("display", "none");
        }
    });

    $("input").keypress(function (event) {
        if (event.which === 13) {
            save_data();
        }
    });
</script>
