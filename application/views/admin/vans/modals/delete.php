<div class="modal fade" id="deleteVan" tabindex="-1" role="dialog" aria-labelledby="editVanLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Delete Van</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    Are you sure you want to do this?
                </div>
                <form method="POST" action="<?=base_url('vans/delete/')?>" role="form">
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    <button class="btn btn-danger" type="submit">DELETE</button>
                </div>
                </form>
        </div>
    </div>
</div>
</div>


<script>

$('#deleteVan').on('show.bs.modal',function(e){
    var modal = $(this);
    var button = $(e.relatedTarget);
    var data = button.data('payload');

    var url = modal.find('form').attr('action');
    modal.find('form').attr('action',url + data.id);

})



</script>



