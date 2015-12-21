<div class="form-group">
    <label>Nama <?php echo $title_page; ?></label>
    <input type="hidden" name="mode" value="<?php echo $mode; ?>"/>
    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>"/>
    <input type="text" name="product_name" value="<?php echo $product_name; ?>" class="form-control" required="" placeholder="Nama <?php echo $title_page; ?>"/>
    <span id='error_name' class='help-block text-red' style='display: none;'>*Field ini wajib di isi</span>
</div>
<?php foreach ($rule as $index => $rowrule) : ?>
    <?php
    switch ($rowrule->product_rule_ct_id):
        case 1:
            $name = 'product_stock_buffer';
            $selected = $product_stock_buffer;
            break;
        case 2:
            $name = 'product_time_delay';
            $selected = $product_time_delay;
            break;
        case 3:
            $name = 'product_result_sales';
            $selected = $product_result_sales;
            break;
        case 4:
            $name = 'product_stock_rest';
            $selected = $product_stock_rest;
            break;
    endswitch;
    ?>
    <div class="form-group">
        <label><?php echo $rowrule->product_rule_ct_name; ?></label>
        <select name="<?php echo $name; ?>" class="form-control">
            <?php if (count($dropdown) > 0) : ?>
                <?php foreach ($dropdown as $row): ?>
                    <?php if ($row->product_rule_ct_id == $rowrule->product_rule_ct_id) : ?>
                        <option value="<?php echo $row->product_rule_set; ?>" <?php echo ($row->product_rule_set == $selected) ? 'selected' : ''; ?>><?php echo $row->product_rule_value . ' (' . $row->product_rule_set . ')'; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
<?php endforeach; ?>
<div class="form-group">
    <label>Kondisi <?php echo $title_page; ?></label>
    <select name="product_decision" class="form-control">
        <option value="Y" <?php echo ($product_decision == 'Y') ? 'selected' : ''; ?>>Ya</option>
        <option value="T" <?php echo ($product_decision == 'T') ? 'selected' : ''; ?>>Tidak</option>
    </select>
    <span id='error_value' class='help-block text-red' style='display: none;'>*Field ini wajib di isi</span>
</div>
<script type="text/javascript">
    $('[name=product_name]').blur(function () {
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
