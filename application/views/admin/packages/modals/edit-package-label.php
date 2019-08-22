<div class="modal fade" id="editPackageName" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Edit Package Name</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <form method="POST" action="<?=base_url('tourpackages/update_package_label')?>" role="form">

                        <div class="form-group">
                            <label for="username_add">Package Name</label>
                            <input type="text" name="name" class="form-control" id="package_name" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="username_add">Sub Directory of:</label>
                            <select class="form-control" name="is_sub_directory" id="is_sub_directory">
                                <option value="0">None</option>
                                <?php foreach ($package_root as $key => $value): ?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->name.' ('.$value->duration_format.')'; ?></option>
                                <?php endforeach ?>
                            </select>
                            <p style="float: right; font-size: 10px; font-weight: 10px">NOTE: Leave blank if none</p>
                        </div>

                        <div class="form-group">
                            <label for="username_add">Duration</label>
                            <select class="form-control" name="duration_id" id="duration">
                                <?php foreach ($durations as $key => $value): ?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                    
                                <?php endforeach ?>
                            </select>
                        </div>

                        <input type="hidden" name="id" class="form-control" id="id" placeholder="">

                </div>

            </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    <button class="btn btn-success" type="submit">Save changes</button>
                </div>
                </form>
        </div>
    </div>
</div>
<script>

$('#editPackageName').on('show.bs.modal',function(e){
    var modal = $(this);
    var button = $(e.relatedTarget);
    var data = button.data('payload');
    console.log(data);
    modal.find('#package_name').val(data.name);
    modal.find('#duration').val(data.duration_id);
    modal.find('#is_sub_directory').val(data.is_sub_directory);
    modal.find('#id').val(data.id);
})

</script>