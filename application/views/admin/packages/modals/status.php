<div class="modal fade" id="statusPackage" tabindex="-1" role="dialog" aria-labelledby="editPackageLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Update Status</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="" role="form">
                <select id="status" class="form-control m-bot15" name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                <div class="modal-footer">
                    
                    <button class="btn btn-warning" type="submit">Update</button>
                </div>
                </form>
        </div>
    </div>
</div>
</div>


<script>

$('#statusPackage').on('show.bs.modal',function(e){
    var modal = $(this);
    var button = $(e.relatedTarget);
    var data = button.data('payload');

    var select = modal.find('#status').val(data.status);
    var url = button.data('url');
    modal.find('form').attr('action',url + data.id);    

})



</script>



