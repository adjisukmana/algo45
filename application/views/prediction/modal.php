<div class="form-group">
    <label>Nama <?php echo $title_page; ?></label>
    <input type="hidden" name="mode" value="<?php echo $mode; ?>"/>
    <input type="hidden" name="prediction_id" value="<?php echo $prediction_id; ?>"/>
    <input type="text" name="prediction_name" value="<?php echo $prediction_name; ?>" class="form-control" required="" placeholder="Nama <?php echo $title_page; ?>"/>
    <span id='error_name' class='help-block text-red' style='display: none;'>*Field ini wajib di isi</span>
</div>
<?php foreach ($rule as $index => $rowrule) : ?>
    <?php
    switch ($rowrule->product_rule_ct_id):
        case 1:
            $name = 'prediction_stock_buffer';
            $selected = $prediction_stock_buffer;
            break;
        case 2:
            $name = 'prediction_time_delay';
            $selected = $prediction_time_delay;
            break;
        case 3:
            $name = 'prediction_result_sales';
            $selected = $prediction_result_sales;
            break;
        case 4:
            $name = 'prediction_stock_rest';
            $selected = $prediction_stock_rest;
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
<script type="text/javascript">
    $('[name=prediction_name]').blur(function () {
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
