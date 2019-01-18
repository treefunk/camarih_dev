<template>
    <div>
        <form role="form" :action="post_url" method="POST" enctype="multipart/form-data">
                                          
            <!-- input elements here -->
            
            <div class="form-group">
                <!-- datepicker -->
                <label for="departure_date">Departure Date</label>
                <input autocomplete="off" id="datepicker_departure" v-model="trip_availability.departure_date" class="form-control form-control-inline input-medium default-date-picker" size="16" type="text" name="departure_date">
                <br>
                <!-- timepicker -->
                <div class="input-group bootstrap-timepicker">
                        <input @focus="triggerTime" v-model="trip_availability.departure_time" name="departure_time" type="text" class="form-control timepicker-default">
                        <span class="input-group-btn">
                            <button id="timepickr" class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
                        </span>
                </div>
            </div>


            <div class="form-group">
                <select class="form-control input-lg m-bot15" name="van_id" id="van" v-model="trip_availability.van_id">
                    <option value="">Select Van</option>
                    <option v-for="(van,index) in vans" :key="index" :value="van.id">{{ van.name }}</option> 
                </select>
            </div>

            

            <!-- <select-origin :destinations=""></select-origin> -->

            <div class="radio">
                    <label>
                        <input type="radio" v-model="trip_availability.is_roundtrip" name="is_roundtrip" id="is_roundtrip" value="0">
                        One-way Trip
                    </label>
                    <label>
                        <input type="radio" v-model="trip_availability.is_roundtrip" name="is_roundtrip" id="is_roundtrip" value="1">
                        Roundtrip
                    </label>
            </div>

            <div class="form-group">
                <label for="selling_date">Selling Date</label>
                <div class="input-group input-large" data-date-format="mm/dd/yyyy">
                    <input v-model="trip_availability.selling_start" id="datepicker_sellingstart" type="text" class="form-control dpd1 default-date-picker" name="from" autocomplete="off">
                    <span class="input-group-addon">To</span>
                    <input v-model="trip_availability.selling_end" id="datepicker_sellingend" type="text" class="form-control dpd2 default-date-picker" name="to" autocomplete="off">
                </div>                                        
            </div>

           

            <div>
                <rate 
                @update-selected="updateSelected" 
                @clear-rates="clearRates"
                @remove-selected="removeRate"
                :destinations="destinations" 
                :rate_list="this.trip_availability.rates"
                :selectedOrigin="this.trip_availability.destination_from"

                ></rate>
            </div>
            <div class="" v-if="!((this.trip_availability.rates.length + 1) == this.destinations.length)">
                <button type="button" class="btn_green" @click="addRate">Add Rate</button>
            </div>
            <button v-if="this.trip_availability.rates.length > 0" type="submit" class="btn_orange right_btn">Submit</button></form>

    </div>
</template>

<script>

    import axios from 'axios'
    import Rate from './Rate.vue'

    export default {
        mounted(){
            //Departure Datepicker
            let self = this
            $('#datepicker_departure').datepicker({
                startDate: '1d',
            }).on('changeDate', function(e_parent) {
                self.trip_availability.selling_start = ""
                self.trip_availability.selling_end = ""

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

            //Departure Timepicker
            $('.timepicker-default').timepicker({
                minuteStep:30,
                defaultTime:'current'
            }).on('change', function(e) {
                self.trip_availability.departure_time = e.target.value
                return
            });

            

            //selling start
            
            
        },
        components: {
            'rate' : Rate
        },
        props: {
            destinations: Array,
            post_url:String,
            vans:Array,
            rates: {
                type: Array,
                default: () => []
            },
            tripavailability: {
                type: Object,
                default: () => {
                    return {
                        departure_date: '',
                        departure_time: '',
                        van_id: '',
                        selling_start: '',
                        selling_end: '',
                        is_roundtrip: '',
                        destination_from: '',
                        rates: []
                    }
                }
            }
        },
        data(){
            return {
                selected_from_child:'',
                departure: '',
                trip_availability: this.tripavailability
            }
        },
        methods: {
            addRate(){
                if(this.trip_availability.destination_from == ''){
                    alert('Please select an origin destination first.');
                    return;
                }
                // todo if all destinations are covered add rate button must be hidden!
                this.trip_availability.rates.push({
                    destination_id: '',
                    price: ''
                })
            },
            clearRates(){
                this.trip_availability.rates = []
            },
            updateSelected(from_child_selected){
                this.selected_from_child = from_child_selected
                this.trip_availability.destination_from = from_child_selected
            },
            removeRate(index){
                
                this.trip_availability.rates.splice(index,1)
            },
            triggerTime(){
                $('#timepickr').click();
            }
        },
        watch: {
            rates(newValue,oldValue){
                // if(newValue == this.rates){
                //     alert('yeo')
                // }
            }
        }
    }
</script>

<style scoped>


</style>