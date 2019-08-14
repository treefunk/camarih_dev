<div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Create New Package Name</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <form method="POST" action="<?=base_url('tourpackages/add_package_label')?>" role="form">

                        <div class="form-group">
                            <label for="username_add">Package Name</label>
                            <input type="text" name="name" class="form-control" id="" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="username_add">Sub Directory of:</label>
                            <select class="form-control" name="is_sub_directory">
                                <option></option>
                                <?php foreach ($package_root as $key => $value): ?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                <?php endforeach ?>
                            </select>
                            <p style="float: right; font-size: 10px; font-weight: 10px">NOTE: Leave blank if none</p>
                        </div>

                        <div class="form-group">
                            <label for="username_add">Duration</label>
                            <select class="form-control" name="duration_id">
                                <?php foreach ($durations as $key => $value): ?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                    
                                <?php endforeach ?>
                            </select>
                        </div>


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