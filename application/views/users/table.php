<?php include APPPATH . 'views/flashdata.php'; ?>
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <!--<th width="1%"><input type="checkbox" id="checkAll"/></th>-->
            <th width="1%">No.</th>
            <th>Username</th>
            <th><?php echo $title_page; ?></th>
            <th>Email</th>
            <th width="10%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($show) > 0) : ?>
            <?php foreach ($show as $index => $row) : ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $row->users_username; ?></td>
                    <td><?php echo $row->users_name; ?></td>
                    <td><?php echo $row->users_email; ?></td>
                    <td class='text-center'>
                        <button id='btn-edit[]' data-id="<?php echo $row->users_id; ?>" type="button" class="btn btn-warning btn-xs tooltips" data-toggle="modal" data-target="#myModal" data-container="body" data-placement="left" data-original-title="Edit data"><i class="ion ion-edit"></i></button>
                        <?php if (!in_array($row->users_id, array(1))) : ?>
                            <button id='btn-delete[]' type="button" class="btn btn-danger btn-xs tooltips" data-container="body" data-placement="left" data-original-title="Hapus data" onClick="delete_data('<?php echo $row->users_id; ?>')"><i class="ion ion-trash-a"></i></button>
                        <?php endif; ?>
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
                url: "<?php echo base_url('users/delete'); ?>",
                data: {id: id},
                type: "POST",
                success: function () {
                    $("#data").load('<?php echo site_url('users/show#data'); ?>');
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
