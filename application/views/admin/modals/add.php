<div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Create Admin</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <form method="POST" action="<?=base_url('admin/createAdmin')?>" role="form">

                        <div class="form-group">
                            <label for="username_add">Username</label>
                            <input type="text" name="username" class="form-control" id="username_add" placeholder="Enter Username">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
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