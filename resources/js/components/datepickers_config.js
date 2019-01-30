module.exports = {
    runDateConfig: function(self){

        $('#datepicker_departure').datepicker({
            startDate: '1d',
        }).on('changeDate', function(e_parent) {
            self.trip_availability.selling_start = ""
            self.trip_availability.selling_end = ""
            self.trip_availability.arrival_date = ""
        
        
            $('#datepicker_arrival_date').datepicker({
                startDate: new Date(e_parent.target.value)
            }).on('changeDate', function(a_e){
                self.trip_availability.arrival_date = a_e.target.value
            })
        
            $('#datepicker_arrival_date_to').datepicker({
                startDate: new Date(e_parent.target.value)
            }).on('changeDate', function(a_to_e){
                self.trip_availability.arrival_date_to = a_to_e.target.value
            })
        
            $('#datepicker_sellingstart').datepicker('setEndDate',new Date(e_parent.target.value))
        
            $('#datepicker_sellingstart').datepicker({
                endDate: new Date(e_parent.target.value)
            }).on('changeDate', function(e) {
                $('#datepicker_sellingend').val('')
                self.trip_availability.selling_end = ''
                $('#datepicker_sellingend').datepicker('setStartDate',new Date(e.target.value))
                $('#datepicker_sellingend').datepicker('setEndDate',new Date(e_parent.target.value))
        
                $('#datepicker_sellingend').datepicker({
                    startDate: new Date(e.target.value),
                    endDate: new Date(e_parent.target.value)      
                }).on('changeDate', function(e) {
                    self.trip_availability.selling_end = e.target.value // manually setting the value coz v-model not working
                    return
                });
        
                self.trip_availability.selling_start = e.target.value // manually setting the value coz v-model not working
                return
            });
            //selling end
            
            self.trip_availability.departure_date = e_parent.target.value // manually setting the value coz v-model not working
            return
        });
        
        if($('#datepicker_departure').val() != ''){
            let departure_date = $('#datepicker_departure').val()
            let selling_start = $('#datepicker_sellingstart').val()
        
            $('#datepicker_sellingstart').datepicker('setEndDate',new Date(departure_date))
           
            $('#datepicker_sellingend').datepicker('setStartDate',new Date(selling_start))
            $('#datepicker_sellingend').datepicker('setEndDate',new Date(departure_date))
        }


        // RETURN DATE

        $('#datepicker_departure_to').datepicker({
            startDate: '1d',
        }).on('changeDate', function(e_parent) {
            self.trip_availability.selling_start_to = ""
            self.trip_availability.selling_end_to = ""

            for(let x = 0 ; x < self.trip_availability.rates.length ; x++)
            {
                self.trip_availability.rates[x].arrival_date_to = ""

                
            }
        
        
            
        
            $('#datepicker_sellingstart_to').datepicker('setEndDate',new Date(e_parent.target.value))
        
            $('#datepicker_sellingstart_to').datepicker({
                endDate: new Date(e_parent.target.value)
            }).on('changeDate', function(e) {
                $('#datepicker_sellingend_to').val('')
                self.trip_availability.selling_end_to = ''
                $('#datepicker_sellingend_to').datepicker('setStartDate',new Date(e.target.value))
                $('#datepicker_sellingend_to').datepicker('setEndDate',new Date(e_parent.target.value))
        
                $('#datepicker_sellingend_to').datepicker({
                    startDate: new Date(e.target.value),
                    endDate: new Date(e_parent.target.value)      
                }).on('changeDate', function(e) {
                    self.trip_availability.selling_end_to = e.target.value // manually setting the value coz v-model not working
                    return
                });
        
                self.trip_availability.selling_start_to = e.target.value // manually setting the value coz v-model not working
                return
            });
            //selling end
            
            self.trip_availability.departure_date_to = e_parent.target.value // manually setting the value coz v-model not working
            return
        });
        
        if($('#datepicker_departure_to').val() != ''){
            let departure_date_to = $('#datepicker_departure_to').val()
            let selling_start_to = $('#datepicker_sellingstart_to').val()
        
            $('#datepicker_sellingstart_to').datepicker('setEndDate',new Date(departure_date_to))
           
            $('#datepicker_sellingend_to').datepicker('setStartDate',new Date(selling_start_to))
            $('#datepicker_sellingend_to').datepicker('setEndDate',new Date(departure_date_to))
        }



    }
}


