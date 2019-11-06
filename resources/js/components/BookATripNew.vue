<template>
<form :action="url" method="POST" @submit.prevent="validateFields">
        <article class="book-trip" style="z-index:2">
        <div class='first_div'>
            <ul class="pad-0 listn">
            <li @click="updateTripType('roundtrip')" :class="{'active':this.triptype == 'roundtrip'}">
                <p>Round-trip</p>
            </li>
            <li @click="updateTripType('oneway')" :class="{'active':this.triptype == 'oneway'}">
                <p>One-way</p>
            </li>
            </ul>
        </div>
        <ul class="pad-0 listn">
            <li>
            <div>
                <h4>Book A trip</h4>
            </div>
            </li>
            <li>
            <div>
                <ul class="pad-0 listn">
                    <li>
                        <h5>From</h5>
                        <select name="destination_from" v-model="destination_from">
                        <option value="">Select Origin</option>
                            <option v-for="(origin,index) in origins" :key="index" :disabled="destination_to == origin.id"  :value="`${origin.id}`">{{ origin.name }}</option>
                        </select>
                    </li>
                    <li >
                        <h5>To</h5>
                        <select name="destination_to" v-model="destination_to">
                        <option value="" >Select Destination</option>
                            <option v-for="(destination,index) in destinations" :disabled="destination.id == destination_from" :key="index" :value="`${destination.id}`">{{ destination.name }}</option>
                        </select>
                    </li>

                    <!-- <div class="form-group" >
                            <label for="selling_date">Selling Date*</label>
                            <div class="input-group input-large" data-date-format="mm/dd/yyyy">
                                <input readonly="true" name="departure_from" id="sell_start" type="text" class="form-control" autocomplete="off">
                                <span class="input-group-addon">To</span>
                                <input readonly="true" name="selling_end" id="sell_end" type="text" class="form-control" autocomplete="off">
                            </div>                                        
                    </div> -->

                    <li>
                        <h5>Departing on</h5>
                        <div class="input-group input-large" data-date-format="mm/dd/yyyy">
                            <input readonly="true" name="departure_from" id="sell_start" type="text" class="form-control" autocomplete="off" @input="from = $event.target.value" @click="clickDate(destination_to, destination_from)" style="cursor: pointer;">
                        </div>
                        <!-- <input name="departure_from" type="date" :min="date_today" @input="from = $event.target.value" v-if="this.triptype =='roundtrip'"> -->
                    </li>
                    <li>
                        <h5 v-if="triptype == 'roundtrip'">Returning on</h5>
                        <div class="input-group input-large" data-date-format="mm/dd/yyyy">
                            <input readonly="true" name="departure_to" id="sell_end" type="text" class="form-control" autocomplete="off" @input="to = $event.target.value" @click="clickDate(destination_to, destination_from)" v-if="this.triptype == 'roundtrip'" style="cursor: pointer;">
                        </div>
                        <!-- <input name="departure_to" type="date" ref="to" :min="from" @input="to = $event.target.value" v-if="this.triptype =='roundtrip'"> -->
                    </li>
                </ul>
            </div>
            </li>
            <li>
            <div>
                <button type="submit" style="background-color:transparent" :disabled="destination_from == destination_to">
                <h5>Check <i class="fa fa-arrow-right"></i> Availability</h5>

                </button>
            </div>
            </li>
        </ul>
        <input type="hidden" name="is_roundtrip" :value="this.triptype == 'roundtrip'">
        </article>
        </form>
</template>

<script>
    import moment from "moment";
    import axios from 'axios';

    export default {
        props: {
            origins_data: {
                type: Array
            },
            destinations_data: {
                type: Array
            },
            url: String,
            check_avail_url: String
        },
        mounted(){
            //dates
            
        },
        data(){
            return {
                destinations: this.destinations_data,
                origins: this.origins_data,
                destination_from: '',
                destination_to: '',
                triptype: 'oneway',
                from: "",
                to: "",
                date_today: moment().format('YYYY-MM-DD'),
                nosellingdate: 0,
                invaliddate: 0
            }
        },
        computed:{
            formData(){
                return {
                    destination_to: this.destination_to,
                    destination_from: this.destination_from,
                    triptype: this.triptype
                }
            }
        },
        methods: {
            updateTripType(type){
                this.nosellingdate = 0;
                if(type == 'roundtrip'){
                    this.triptype = 'roundtrip'
                }else{
                    this.triptype = 'oneway'
                }
            },
            clickDate(from, to){
                if (from == '' || to == '') {
                    this.$store.dispatch("showToastr", { message: "Please select location.", type: "error"})
                }
            },
            validateFields(e){

                let is_oneway = this.triptype == 'oneway'
                let is_roundtrip = this.triptype == 'roundtrip'

                if (is_roundtrip && this.invaliddate) {
                    this.$store.dispatch("showToastr", { message: "Invalid set of dates", type: "error"})
                    return -1;
                }

                if (this.nosellingdate) {
                    this.$store.dispatch("showToastr", { message: "No selling dates. Please select another location.", type: "error"})
                    return -1; 
                }
                if(is_roundtrip && (this.from == '' || $('#sell_end').val() == '')){
                    this.$store.dispatch("showToastr", { message: "You did not specify the date.", type: "error"})
                    return -1;
                }

                if(is_oneway && this.from == ''){
                    this.$store.dispatch("showToastr", { message: "You did not specify the date.", type: "error"})
                    return -1;
                }

                if(this.destination_from == ''){
                    this.$store.dispatch("showToastr", { message: "Please select the origin", type: "error"})
                    return -1;
                }

                if(this.destination_to == ''){
                    this.$store.dispatch("showToastr", { message: "Please select the destination", type: "error"})
                    return -1;
                }

                e.target.submit();
            }
        },
        watch:{
            from(){
                let to_elem = this.$refs.to
            },
            triptype(newVal){
                if(newVal == 'roundtrip'){
                    this.destinations = this.origins_data
                    this.destination_to = ""
                }else{
                    this.destinations = this.destinations_data
                }
            },
            destination_to(){
                var self = this;
                
                $('input[name=departure_from]').removeAttr('disabled');
                $('input[name=departure_to]').removeAttr('disabled');
                if (this.destination_from && this.destination_to) {
                    axios.post(this.check_avail_url,this.formData).then((res) => {
                        $('#sell_start').val('');
                        if (res.data.min) {
                            this.nosellingdate = 0;
                            if ($('#sell_start').data('datepicker')) {
                                $('#sell_start').data('datepicker').destroy();
                            }
                            $('#sell_start').val(res.data.min_format);
                            self.from = res.data.min_format;
                            let dp = $('#sell_start').datepicker({
                                startDate: res.data.min,
                                endDate: res.data.max,
                                datesDisabled: res.data.disabled_dates,
                                setDate: res.data.min,
                                todayHighlight: true,
                            }).on('changeDate', function(e) {
                                self.from = e.target.value // manually setting the value coz v-model not working
                                self.invaliddate = 0;
                                if (self.triptype == 'roundtrip') {
                                    if ($('#sell_start').datepicker('getDate') > $('#sell_end').datepicker('getDate')) {
                                        self.invaliddate = 1;
                                    }
                                }

                                return
                            });
                            if (this.triptype == 'roundtrip') {
                                if (res.data.min_date_2way) {
                                    if ($('#sell_end').data('datepicker')) {
                                        $('#sell_end').data('datepicker').destroy();
                                    }
                                    $('#sell_end').val(res.data.min_format_2way);
                                    self.to = res.data.min_format_2way;
                                    $('#sell_end').datepicker({
                                            startDate: res.data.min_date_2way,
                                            endDate: res.data.max_date_2way,
                                            datesDisabled: res.data.disabled_dates_2way,
                                            todayHighlight: true,
                                        }).on('changeDate', function(e) {
                                            self.to = e.target.value // manually setting the value coz v-model not working
                                            self.invaliddate = 0;
                                            if ($('#sell_start').datepicker('getDate') > $('#sell_end').datepicker('getDate')) {
                                                self.invaliddate = 1;
                                            }
                                            return
                                    });
                                }else{
                                    this.nosellingdate = 1;
                                    $('input[name=departure_from]').attr('disabled', 'disabled');
                                    self.from = '';
                                    if (this.triptype == 'roundtrip') {
                                        $('#sell_end').val("");
                                        $('input[name=departure_to]').attr('disabled', 'disabled');
                                    }
                                    this.$store.dispatch("showToastr", { message: "No selling dates. Please select another location.", type: "error"})
                                }
                            }


                        }else{
                            this.nosellingdate = 1;
                            $('input[name=departure_from]').attr('disabled', 'disabled');
                            self.from = '';
                            if (this.triptype == 'roundtrip') {
                                $('#sell_end').val("");
                                $('input[name=departure_to]').attr('disabled', 'disabled');
                            }
                            this.$store.dispatch("showToastr", { message: "No selling dates. Please select another location.", type: "error"})
                        }
                    })
                }
            },
            destination_from(){
                var self = this;
                
                $('input[name=departure_from]').removeAttr('disabled');
                $('input[name=departure_to]').removeAttr('disabled');
                if (this.destination_from && this.destination_to) {
                    axios.post(this.check_avail_url,this.formData).then((res) => {
                        $('#sell_start').val('');
                        if (res.data.min) {
                            this.nosellingdate = 0;
                            if ($('#sell_start').data('datepicker')) {
                                $('#sell_start').data('datepicker').destroy();
                            }
                            $('#sell_start').val(res.data.min_format);
                            self.from = res.data.min_format;
                            let dp = $('#sell_start').datepicker({
                                startDate: res.data.min,
                                endDate: res.data.max,
                                datesDisabled: res.data.disabled_dates,
                                setDate: res.data.min,
                                todayHighlight: true,
                            }).on('changeDate', function(e) {
                                self.from = e.target.value // manually setting the value coz v-model not working
                                self.invaliddate = 0;
                                if (self.triptype == 'roundtrip') {
                                    if ($('#sell_start').datepicker('getDate') > $('#sell_end').datepicker('getDate')) {
                                        self.invaliddate = 1;
                                    }
                                }

                                return
                            });
                            if (this.triptype == 'roundtrip') {
                                if (res.data.min_date_2way) {
                                    if ($('#sell_end').data('datepicker')) {
                                        $('#sell_end').data('datepicker').destroy();
                                    }
                                    $('#sell_end').val(res.data.min_format_2way);
                                    self.to = res.data.min_format_2way;
                                    $('#sell_end').datepicker({
                                            startDate: res.data.min_date_2way,
                                            endDate: res.data.max_date_2way,
                                            datesDisabled: res.data.disabled_dates_2way,
                                            todayHighlight: true,
                                        }).on('changeDate', function(e) {
                                            self.to = e.target.value // manually setting the value coz v-model not working
                                            self.invaliddate = 0;
                                            if ($('#sell_start').datepicker('getDate') > $('#sell_end').datepicker('getDate')) {
                                                self.invaliddate = 1;
                                            }
                                            return
                                    });
                                }else{
                                    this.nosellingdate = 1;
                                    $('input[name=departure_from]').attr('disabled', 'disabled');
                                    self.from = '';
                                    if (this.triptype == 'roundtrip') {
                                        $('#sell_end').val("");
                                        $('input[name=departure_to]').attr('disabled', 'disabled');
                                    }
                                    this.$store.dispatch("showToastr", { message: "No selling dates. Please select another location.", type: "error"})
                                }
                            }


                        }else{
                            this.nosellingdate = 1;
                            $('input[name=departure_from]').attr('disabled', 'disabled');
                            self.from = '';
                            if (this.triptype == 'roundtrip') {
                                $('#sell_end').val("");
                                $('input[name=departure_to]').attr('disabled', 'disabled');
                            }
                            this.$store.dispatch("showToastr", { message: "No selling dates. Please select another location.", type: "error"})
                        }
                    })
                }
            }

        }
    }
</script>

<style scoped>
article div.first_div li {
    background : #ebebeb;
}

article div.first_div li p {
    color: #222f46;
}
article div.first_div li.active { 
    background: #429e47;
}
article div.first_div li.active p { 
    color: #fff;
}
</style>