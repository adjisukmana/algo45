<?php include APPPATH . 'views/flashdata.php'; ?>
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <!--<th width="1%"><input type="checkbox" id="checkAll"/></th>-->
            <th width="1%">No.</th>
            <th><?php echo $title_page; ?></th>
            <th>Minimal Stock</th>
            <th>Waktu Tunggu</th>
            <th>Hasil Penjualan</th>
            <th>Sisa Stock</th>
            <th>Keputusan</th>
            <th width="10%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($show) > 0) : ?>
            <?php foreach ($show as $index => $row) : ?>
                <tr>
                    <!--<td><input type='checkbox' name='checkboxes[]' class='checkboxes' value="<?php echo $row->product_id; ?>"/></td>-->
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $row->product_name; ?></td>
                    <td class="text-center"><?php echo $row->product_stock_buffer; ?></td>
                    <td class="text-center"><?php echo $row->product_time_delay; ?> Hari</td>
                    <td class="text-center"><?php echo $row->product_result_sales; ?></td>
                    <td class="text-center"><?php echo $row->product_stock_rest; ?></td>
                    <td class="text-center"><?php echo ($row->product_decision == 'Y') ? 'Ya' : 'Tidak'; ?></td>
                    <td class='text-center'>
                        <button id='btn-edit[]' data-id="<?php echo $row->product_id; ?>" type="button" class="btn btn-warning btn-xs tooltips" data-toggle="modal" data-target="#myModal" data-container="body" data-placement="left" data-original-title="Edit data"><i class="ion ion-edit"></i></button>
                        <button id='btn-delete[]' type="button" class="btn btn-danger btn-xs tooltips" data-container="body" data-placement="left" data-original-title="Hapus data" onClick="delete_data('<?php echo $row->product_id; ?>')"><i class="ion ion-trash-a"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<script type='text/javascript'>
    function delete_data(param) {
        var clicked = confirm("Delete Data ?");
        if (clicked === true) {
            //var id = $(this).data('id');
            var id = param;
            $.ajax({
                url: "<?php echo base_url('master/product/delete'); ?>",
                data: {id: id},
                type: "POST",
                success: function () {
                    $("#data").load('<?php echo site_url('master/product/show#data'); ?>');
                }
            });
        } else {

        }
    }

    $(function () {
        $("#example1").DataTable();
    });

    $("#checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $(document).on("click", '[id^="btn-edit"]', function () {
        modal_data('edit', $(this).data('id'));
    });
</script>
