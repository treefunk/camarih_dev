<template>
<div class="clearfix">
    <div class="right_item">
        <form :action="form_url" method="POST" ref="detailsForm">
        <article class="details">
            <h4>{{ van_data.name }}</h4>
            <p>{{ seatsNum }} - Seater</p>

            <ul class="pad-0 listn">
                
                <li>
                    <h6>Date</h6>
                    <input type="date" name="" id="" v-model="selectedDate">
                </li>

                <li>
                    <h6>Select Origin</h6>
                    <select name="origin_id" id="origin_id" v-model="selectedOrigin">
                        <option value="">Select Origin</option>
                        <option  v-for="origin in availableOrigins" :key="origin.id" name="origin_id" :value="`${origin.id}`">{{ origin.name }}</option>
                    </select>
                </li>
                <li v-if="selectedOrigin">
                    <h6>Select a Destination</h6>
                    <select name="destination_id" id="desination_id" v-model="selectedDestination">
                        <option value="">Select Destination</option>
                        <option v-for="destination in availableDestinations" name="destination_id" :key="destination.id" :value="`${destination.destination_id}`">{{ getDestinationById(destination.destination_id).name }}</option>
                    </select>
                </li>
                <li>
                    <ul class="pad-0 listn">
                        <li>
                            <input type="radio" id="test1" name="trip_type" value="oneway_trip" v-model="tripType">
                            <label for="test1">One-way</label>
                        </li>
                        <li>
                            <input type="radio" id="test2" name="trip_type" value="round_trip" v-model="tripType">
                            <label for="test2">Round Trip</label>
                        </li>
                    </ul>
                </li>

                <li>
                    <h5>Adults</h5>
                    <input type="number" v-model="adultCount" name="adultCount">
                    <span>{{ ratePrice }}</span>
                </li>
            </ul>
                <div class="text-center" style="margin-top:30px">
                    <p :style="{ color: message_class }" v-if="message">{{ message }}</p>
                    <div class="loading-dual" v-if="loading"></div>
                </div>
        </article>
        <div class="btm_link">
            <ul class="pad-0 listn">
                <li>
                    <a href="#prcing_table" class="popup-with-form">Pricing Table</a>
                </li>
                    
                <li v-if="valid">
                    <a @click.prevent="addToCart" v-if="!loading" >Add to Cart</a>
                </li>
            </ul>
        </div>
        </form>
    </div>
</div>

</template>

<script>
    import axios from 'axios'

    export default {
        props: {
            form_url: String,
            check_url: String,
            destinations_data:Array,
            origins_data:Array,
            van_data: {
                type: Object,
                default: () => {}
            }
        },
        data(){
            return {
                destinations: this.destinations_data,
                rates: this.van_data.van_rates,
                origins: this.origins_data,
                selectedOrigin: "",
                tripType: "oneway_trip",
                selectedDate: "",
                selectedDestination:"",
                adultCount: 1,
                loading: false,
                message: "",
                valid: false
            }
        },
        computed: {
            availableRates(){
                let r = {}
                this.rates.map(v => {
                    if(r[v.origin_id] == undefined){
                        r[v.origin_id] = [];
                    }
                    
                    r[v.origin_id].push(v)
                })
                return r;
            },
            availableOrigins(){
                let rateKeys = Object.keys(this.availableRates)
                return this.origins.filter(o => rateKeys.includes(o.id))
            },
            availableDestinations(){
                return this.availableRates[this.selectedOrigin]
            },
            ratePrice(){
                if(this.tripType == '' || this.selectedOrigin == '' || this.selectedDestination == ''){
                    return ""
                }

                let rates = this.availableRates[this.selectedOrigin]
                let rate = {}

                for(let x = 0; x < rates.length; x++){
                    if(rates[x].destination_id == this.selectedDestination){
                        rate = rates[x]
                    }
                }

                let price = this.tripType == 'oneway_trip' ? rate.oneway_rate : rate.roundtrip_rate
                return 'PHP ' + (price).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2})
                
            },
            seatsNum(){
                return (this.van_data.seat_map.split(',')).reduce((accu,num) => accu + parseInt(num,10),0)
            },
            formData(){
                return {
                    date: this.selectedDate,
                    origin_id: this.selectedOrigin,
                    destination_id: this.selectedDestination,
                    trip_type: this.tripType,
                    adult_count: this.adultCount
                }
            },
            impt(){
                return {
                    date: this.selectedDate,
                    origin_id: this.selectedOrigin,
                    destination_id: this.selectedDestination,
                }                
            }
        },
        methods: {
            getDestinationById(id){
                for(let x = 0; x < this.destinations.length ; x++){
                    if(this.destinations[x].id == id){
                        return this.destinations[x]
                    }
                }
            },
            addToCart(){
                this.loading = true
                axios.post(this.form_url,this.formData).then((res) => {
                    this.selectedOrigin = ""
                    this.selectedDestination = ""
                    this.selectedDate = ""
                    this.$nextTick(() => {
                        this.message = res.data.message
                    })
                    this.loading = false
                })

                
            }
           
        },
        watch: {
            selectedOrigin(){
                this.selectedDestination = ""
            },
            impt: {
                handler: function(newV,oldV){
                    if(Object.values(newV).every((x) => x != "")){
                        this.loading = true;
                        axios.post(this.check_url,newV).then((res) => {
                            if(res.data.available){
                                this.valid = true;
                                this.loading = false;
                                this.message = res.data.message
                                this.message_class = "green"
                            }else{
                                this.valid = false;
                                this.loading = false;
                                this.message = res.data.message
                                this.message_class = "red"
                            }
                        })
                    }else{
                        this.valid = false;
                        this.message = ""
                    }
                },
                deep: true
            }
        }
    }
</script>

<style scoped>
input[type="date"] {
    max-width: 290px;
    width: 100%;
    border: 2px solid #e1e1e1;
    height: 40px;
    padding-left: 15px;
    margin-bottom: 25px;
    background-image: url('~/../images/select-gray.png');
    background-repeat: no-repeat;
    background-position: 95% center;
    background-size: 15px;
    font-size: 18px;
}
</style>