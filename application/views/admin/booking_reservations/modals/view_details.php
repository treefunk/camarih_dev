<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true"
    style="display: none; z-index: 99999999999999;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Details</h4>
            </div>
            <div class="modal-body">
                

            <div id="checkout_info">

            </div>



            <h3>Seat plan</h3>
                <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Birthday</th>
                        <th>Seat Number</th>
                    </tr>
                </thead>
                <tbody id="tbody">

                </tbody>

                </table>
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
       var seat_plan = json.seat_plan
       var details = json.details
       console.log(details)
       $('#checkout_info').empty()

       createInfoList($('#checkout_info'),details)

       $('#tbody').empty()
       
       for(var x = 0 ; x < seat_plan.length ; x++)
       {
           $('<tr><td>'+ seat_plan[x].name +'</td><td>'+  seat_plan[x].birth_date +'</td><td>' +  seat_plan[x].seat_num + '</td></tr>').appendTo("#tbody")
       }
   });

})
</script>