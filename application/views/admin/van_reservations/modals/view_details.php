<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true"
    style="display: none; z-index: 99999999999999;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Details</h4>
            </div>
            <div class="modal-body">

            <div id="van_info">

            </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            
            </form>
            </div>
        </div>
    </div>
</div>

<script>
$('#detailsModal').on('show.bs.modal',function(e){
    var modal = $(this);
    var button = $(e.relatedTarget);
    var data = button.data('payload');
    
   $.post(data.url,data).success(function(response){
       var json = JSON.parse(response);
       var details = json.details

       $('#van_info').empty()

       createInfoList($('#van_info'),details)

   });

})
</script>