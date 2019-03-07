<template>
    <div class="rate">
        <h3>
                    {{ getOrdinal(index + 1) }} Destination
        </h3>
        <div class="clearfix">
        <button type="button" class="btn btn-danger right_btn" @click="removeMe(index)"><i class="fa fa-times"></i></button>
        </div>
        <div class="row">
            <div class="col-md-6" v-if="false">
                <div class="form-group">
                    <!-- origin selection -->
                        <label for="select_van">Select Origin</label>
                        <select class="form-control input-lg m-bot15" name="destination_from" id="van" v-model="rate.origin_id">
                            <option value="">Select Origin</option>
                            <option v-for="(destination,index) in destinations" :key="index" :value="destination.id">{{ destination.name }}</option> 
                        </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="select_van">Select Destination</label>
                    <select v-model="rate.destination_id" class="form-control input-lg m-bot15" :name="`rates[${index}][destination_id]`"
                        id="destination">
                        <option value="">Select Destination</option>
                        <option v-for="(destination,index) in destinations" v-show="(rates_taken.find(r => r.destination_id == destination.id) == undefined)" :key="index" :value="destination.id">{{
                            destination.name }}</option>
                    </select>
                </div>
            </div>
        </div>
        

        <div class="form-group">
            <label for="price">Price</label>
            <input v-model="rate.price" type="text" class="form-control" :name="`rates[${index}][price]`" id=""
                placeholder="Enter Price">
        </div>

        <div class="form-group" v-if="false">
            <!-- timepicker -->
            <label for="departure_time">Departure Time</label>
            <div class="input-group bootstrap-timepicker">
                    <input  readonly v-model="rate.departure_time" name="departure_time" type="text" :class="`form-control timepicker-rate_${index}`" autocomplete="off">
                    <span class="input-group-btn" >
                        <button data-toggle="tooltip" data-placement="right" title="Click here to choose time" id="timepickr_rate" class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
                    </span>
            </div>
        </div>


    </div>
</template>

<script>
    export default {
        props: {
            rates_taken: {
                type:Array
            },
            index: {
                type: Number
            },
            rate: {
                type: Object,
                default: () => { 
                    return {
                        origin_id: "",
                        destination_id: "",
                        price: ""
                    }
                }
            },
            destinations: {
                type: Array
            },
            rate_length: Number
        },
        data(){
            return {

            }
        },
        methods: {
            removeMe(index){
                this.$emit('removeRate',index);
            },
            getOrdinal(n){
                let s=["th","st","nd","rd"],
                    v=n%100;
                return n+(s[(v-20)%10]||s[v]||s[0]);
            }
        },
        watch: {

            destinations: function (newV){
                if(newV.find(d => d.id == this.rate.destination_id) == undefined){
                    this.rate.destination_id = ""
                }
            }

        }
    }
</script>

<style scoped>
.rate{
    /* border: 1px solid rgb(199, 128, 81); */
    padding: 15px 25px;
    margin-bottom: 10px;
}

</style>