<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true"
    style="display: none; z-index: 99999999999999;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Update Status</h4>
            </div>
            <div class="modal-body">

            <form method="post">

                <select class="form-control" name="status" id="status">
                    <?php foreach($status_types as $status): ?>
                    <option value="<?=$status?>" ><?=ucFirst($status)?></option>
                    <?php endforeach; ?>
                </select>

                <div class="form-group">
                            <label for="" >Please enter "CONFIRM" to confirm update <br /> <span style="color:red; font-size:70%">NOTE:text must be in capital letters</span></label>
                            <input autocomplete="off" class="form-control" type="text" name="" id="confirm" placeholder="">
                </div>
                
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                <button class="btn btn-success" id="submitBtn" disabled type="submit">Save changes</button>
            </form>
            </div>
        </div>
    </div>
</div>

<script>
$('#statusModal').on('show.bs.modal',function(e){
    var modal = $(this);
    var button = $(e.relatedTarget);
    var data = button.data('payload');

    var confirmElem = $('#confirm')
    var statusElem = $('#status')
    var submitButton = $('#submitBtn')


    statusElem.on("change",function(e){
        confirmElem.val('')
        submitButton.attr('disabled','true')
    })
    
    
    confirmElem.val('')
    confirmElem.on('keyup',function(e){
      var val = e.target.value
      
      if(val === "CONFIRM"){
          console.log(submitButton)
          submitButton.removeAttr('disabled')
      }else{
          submitButton.attr('disabled','true')
      }
    })
    
    modal.find("form").attr('action',data.form_url)
    modal.find('#status').val(data.status)

})
</script>