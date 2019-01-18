<div class="modal fade" id="editAdmin" tabindex="-1" role="dialog" aria-labelledby="editAdminLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Edit Admin</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <form method="POST" id="editAdminForm" action="<?=base_url('admin/editAdmin/')?>" role="form">

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" value="" class="form-control" id="username" placeholder="Enter Username">
                        </div>

                        <div class="form-group">
                            <label for="password">Change Password:</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                        </div>

                        <div class="form-group">
                            <label for="password">Confirm Password:</label>
                            <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Password">
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


<script>

$('#editAdmin').on('show.bs.modal',function(e){
    var modal = $(this);
    var button = $(e.relatedTarget);
    var data = button.data('payload');

    modal.find('#username').val(data.username);
    var editurl = modal.find('form').attr('action');

    modal.find('form').attr('action',editurl + data.id);

})

</script>



