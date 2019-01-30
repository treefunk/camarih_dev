export default {
    run: function(self){

        //selling start datepicker
        $('#datepicker_sellingstart').datepicker({
        }).on('changeDate', function(e) {
            self.trip_availability.selling_start = e.target.value // manually setting the value coz v-model not working
            return
        });

        //selling end datepicker
        $('#datepicker_sellingend').datepicker({
        }).on('changeDate', function(e) {
            self.trip_availability.selling_end = e.target.value // manually setting the value coz v-model not working
            return
        });

    }
}