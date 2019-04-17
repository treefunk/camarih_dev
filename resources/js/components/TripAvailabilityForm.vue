<template>
    <div>
         <form role="form" :action="post_url" method="POST" enctype="multipart/form-data" @submit.prevent="validateFields">
            
            <!-- van selection -->
            <div class="form-group">
                <label for="select_van">Select Van*</label>
                <select class="form-control input-lg m-bot15" name="van_id" id="van" v-model="trip_availability.van_id">
                    <option value="">Select Van</option>
                    <option v-for="(van,index) in vans" :key="index" :value="van.id">{{ van.name }}</option> 
                </select>
            </div>

            <!-- select origin -->

            <div class="form-group">
                    <!-- origin selection -->
                        <label for="select_van">Select Origin*</label>
                        <select v-model="trip_availability.origin.destination_from" class="form-control input-lg m-bot15" name="destination_from" id="van">
                            <option value="">Select Origin</option>
                            <option v-for="(origin,index) in origins" :key="index" :value="origin.id">{{ origin.name }}</option> 
                        </select>
                </div>

            

            <!-- selling date -->
            <div class="form-group" >
                <label for="selling_date">Selling Date*</label>
                <div class="input-group input-large" data-date-format="mm/dd/yyyy">
                    <input readonly="true" name="selling_start" v-model="trip_availability.selling_start" id="sell_start" type="text" class="form-control" autocomplete="off">
                    <span class="input-group-addon">To</span>
                    <input readonly="true" name="selling_end" v-model="trip_availability.selling_end" id="sell_end" type="text" class="form-control" autocomplete="off">
                </div>                                        
            </div>

            <div class="form-group">
                <!-- timepicker -->
                <label for="departure_time">Departure Time*</label>
                <div class="input-group bootstrap-timepicker">
                        <input readonly ref="dep_time" name="departure_time" type="text" class="form-control timepicker-default" autocomplete="off">
                        <span class="input-group-btn" >
                            <button data-toggle="tooltip" data-placement="right" title="Click here to choose time" id="timepickr" class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
                        </span>
                </div>
            </div>


            <div>
                <label v-if="this.rates.length > 0" for="rate">Rates:</label>
                
                <rate
                v-for="(rate,index) in this.trip_availability.rates" 
                :key="index" 
                :index="index" 
                :rate="rate"
                :destinations="destinations"
                :rate_length="trip_availability.rates.length"
                :rates_taken="trip_availability.rates"
                @removeRate="removeRate(index)"
                >
                
                </rate>
            </div>

            <div>
                <button v-if="trip_availability.rates.length != destinationMaxCount" type="button" class="btn_green" @click="addRate">Add Destinations</button>
                <button v-if="this.trip_availability.rates.length > 0" type="submit" class="btn_orange right_btn">Submit</button>
            </div>
         </form>
    </div>
</template>

<script>

    import datepickersConfig from './datepickersConfig.js';
    import Rate from './Rate.vue';
    import errorMessages from './error_messages/trip_availability_errors'

    export default {
        components: { Rate },
        props: {
            post_url: String,
            vans: {
                type: Array
            },
            trip_availability_data: {
                type: Object,
                default: () => {
                    return {
                        van_id:'',
                        is_roundtrip:false,
                        selling_start:"",
                        selling_end: "",
                        departure_time: "",
                        rates: [],
                        origin: {
                            destination_from: ""
                        }
                    }
                }
            },
            rates_data : {
                type: Array,
                default: () => []
            },
            destinations_data: {
                type: Array
            },
            origins_data : {
                type: Array
            }
        },
        mounted(){
            //dates
            let self = this
            datepickersConfig.run(this);

            //timepicker
            $('.timepicker-default').timepicker({
                minuteStep:30,
                defaultTime:'current'
            }).on('change', function(e) {
                self.trip_availability.departure_time = e.target.value
                return
            });

            if(this.trip_availability.rates.length){
                console.log(this.$refs['dep_time'].value = this.trip_availability.rates[0].departure_time)
            }

            if(this.trip_availability.destination_from != ""){
                this.destinations = this.destinations_data.filter(d => {
                    return (d.id != (this.trip_availability.destination_from))
                })

            }
            

            $('#sell_start').datepicker().on('changeDate', function(e) {
                self.trip_availability.selling_start = e.target.value
            })


        },
        data(){
            return {
                trip_availability: this.trip_availability_data,
                rates: this.rates_data,
                otherOrigins: [],
                destinations: this.destinations_data,
                origins: this.origins_data
            }
        },
        computed: {
            destinationMaxCount(){
                let maxCount = 0;
                maxCount += this.destinations_data.length
                let destination_ids = this.destinations_data.map(v => v.id)
                let intersects = destination_ids.includes(this.trip_availability.origin.destination_from)
                if(intersects){
                    maxCount--
                    this.trip_availability.rates.splice(maxCount,this.trip_availability.rates.length - maxCount)
                }
                return maxCount
            }
        },
        /**
         *  METHODS
         */
        methods: {
            addRate(){
                    this.trip_availability.rates.push({
                        destination_id: "",
                        price: ""
                    })

                    return
            },
            validateFields(e){

                let obj = this.trip_availability
                let missingFields = 0

                let errorKeys = { required: [] };

                function validate(obj){
                    

                    for(let key in obj){


                        if(typeof obj[key] == 'boolean'){ continue; }

                        if(Array.isArray(obj[key])){
                            for(let x = 0; x < obj[key].length ; x++){
                                for(let k in obj[key][x]){
                                    if(obj[key][x][k] == ""){
                                        errorKeys.required.push(k)
                                        missingFields++;
                                    }
                                }
                            }
                            continue;
                        }

                        if(typeof obj[key] == 'object' && !Array.isArray(obj[key])){ // if its an object recurse in it
                            validate(obj[key])
                            continue;
                        }

                        if (obj[key] == "" && !Array.isArray(obj[key])) {
                            errorKeys.required.push(key)
                            missingFields++
                            continue;
                        }

                    }

                    return errorKeys
                }

                let errors = validate(obj);
                if(errors.required.length){
                    for(let val of errors.required){
                        this.$store.dispatch("showToastr", { message: errorMessages[val].required, type: "error"})
                        return -1
                    }
                }else{
                    e.target.submit()
                }
            },
            timeFocused(){
                //todo
                console.log('timepicker')
            },
            removeRate(index){
                this.trip_availability.rates.splice(index,1)
            }
        },
        /**
         * WATCH
         */
        updated: function () {
            this.$nextTick(function () {
                let self = this
                for(let x = 0 ; x < this.trip_availability.rates.length; x++){
                    $(`.timepicker-rate_${x}`).timepicker({
                        minuteStep:30,
                        defaultTime:'current'
                    }).on('change', function(e) {
                        self.trip_availability.rates[x].departure_time = e.target.value
                        return
                    });
                }
            })
        },
        watch: {
            'trip_availability.origin.destination_from': function(newV){
                if(newV != ""){
                    this.destinations = this.destinations_data.filter(d => {
                        return (d.id != newV)
                    })
                }
            },
            'trip_availability.selling_start': function(newV){
                let self = this
                self.trip_availability.selling_end = ""

                $('#sell_end').datepicker().on('changeDate',function(e){
                    self.trip_availability.selling_end = e.target.value
                })

                $('#sell_end').datepicker('setStartDate',$('#sell_start').datepicker('getDate'));
            }
        }
        
    }
</script>

<style scoped>

</style>