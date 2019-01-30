<template>
    <div>
        <form role="form" :action="post_url" method="POST" enctype="multipart/form-data">
                                          
            <div class="form-group">
                <label for="select_van">Select Van</label>
                <select class="form-control input-lg m-bot15" name="van_id" id="van" v-model="trip_availability.van_id">
                    <option value="">Select Van</option>
                    <option v-for="(van,index) in vans" :key="index" :value="van.id">{{ van.name }}</option> 
                </select>
            </div>
            

            <!-- input elements here -->
            <div class="form-group">
                <label for="select_type">Select Type</label>
                <div class="radio">
                        <label>
                            <input type="radio" v-model="trip_availability.is_roundtrip" name="is_roundtrip" id="is_roundtrip" :value="false">
                            One-way Trip
                        </label>
                        <label>
                            <input type="radio" v-model="trip_availability.is_roundtrip" name="is_roundtrip" id="is_roundtrip" :value="true">
                            Roundtrip
                        </label>
                </div>
            </div>


            <div class="form-group" >
                <label for="selling_date">Selling Date</label>
                <div class="input-group input-large" data-date-format="mm/dd/yyyy">
                    <input name="selling_start" v-model="trip_availability.selling_start" id="datepicker_sellingstart" type="text" class="form-control dpd1 default-date-picker" autocomplete="off">
                    <span class="input-group-addon">To</span>
                    <input name="selling_end" v-model="trip_availability.selling_end" id="datepicker_sellingend" type="text" class="form-control dpd2 default-date-picker" autocomplete="off">
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
                :is_roundtrip="this.trip_availability.is_roundtrip == true"
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
    import datepickerConf from './datepickers_config.js'

    export default {
        mounted(){
            //Departure Datepicker
            let self = this

            datepickerConf.runDateConfig(self)
            
            //Departure Timepicker
            $('.timepicker-default').timepicker({
                minuteStep:30,
                defaultTime:'current'
            }).on('change', function(e) {
                self.trip_availability.departure_time = e.target.value
                return
            });

            $('.timepicker-default2').timepicker({
                minuteStep:30,
                defaultTime:'current'
            }).on('change', function(e) {
                self.trip_availability.departure_time_to = e.target.value
                return
            });

            
            
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
                        departure_date_to: '',
                        departure_time_to: '',
                        van_id: '',
                        selling_start: '',
                        selling_end: '',
                        is_roundtrip: false,
                        destination_from: '',
                        rates: [],
                        arrival_date: ''
                    }
                }
            }
        },
        data(){
            return {
                selected_from_child:'',
                departure: '',
                trip_availability: this.tripavailability,
                timepickerStyle: {

                }
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
                    price: '',
                    arrival_date_to: ''
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
            triggerTime(e){
                if(this.trip_availability.departure_time == ''){
                    this.timepickerStyle = {
                        background: 'red'
                    }
                    $('#timepickr').tooltip('show')
                }
            }
        },
        watch: {
            'trip_availability.departure_time': function(newV,oldV){
                if(newV == ''){
                    this.timepickerStyle = {background: 'red'} 
                }else{
                    this.timepickerStyle = {} 
                }
            },
            'trip_availability.departure_date': function(newV,oldV){
                    this.trip_availability.selling_start = ''
                    this.trip_availability.selling_end = ''
            },
            'trip_availability.is_roundtrip': function(newV,oldV){
                if(oldV == false && newV == true){
                    // $('#datepicker_departure_to').datepicker('setStartDate',new Date(this.trip_availability.departure_date))
                    let self = this
                    $('#datepicker_departure_to').datepicker({
                        startDate: '1d',
                    }).on('changeDate', function(e_parent) {
                        self.trip_availability.selling_start_to = ""
                        self.trip_availability.selling_end_to = ""

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
                }
            },
            'trip_availability.departure_date_to': function(newV,oldV){
                    for(let x = 0 ; x < this.trip_availability.rates.length ; x++)
                    {
                        this.trip_availability.rates[x].arrival_date_to = ""
                        console.log(this.trip_availability.rates[x].arrival_date_to)
                        
                    } 
            }
        },
        updated: function() {
            this.$nextTick(function(){
                self = this
                for(let x = 0; x < this.trip_availability.rates.length; x++){
                    $(`#datepicker_arrival_date_to_${x}`).datepicker({
                        startDate: new Date($('#datepicker_departure_to').val())
                    }).on('changeDate', function(a_to_e){
                        self.trip_availability.rates[x].arrival_date_to = a_to_e.target.value
                    })
                }
            })
        }
    }
</script>

<style scoped>


</style>