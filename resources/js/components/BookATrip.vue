<template>
<form :action="url" method="POST" @submit.prevent="validateFields">
        <article class="book-trip">
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
                        <option v-for="(destination,index) in destinations" :key="index" v-show="destination_to != destination.id" :value="`${destination.id}`">{{ destination.name }}</option>
                    </select>
                    <h4 v-if="triptype == 'roundtrip'">Departing on</h4>
                    <input name="departure_from" type="date" :min="date_today" @input="from = $event.target.value">
                </li>
                <li >
                    <h5>To</h5>
                    <select name="destination_to" v-model="destination_to">
                    <option value="" >Select Destination</option>
                        <option v-for="(destination,index) in destinations" v-show="destination_from != destination.id" :key="index" :value="`${destination.id}`">{{ destination.name }}</option>
                    </select>
                    <h4 v-if="triptype == 'roundtrip'">Returning on</h4>
                    <input name="departure_to" type="date" ref="to" :min="from" @input="to = $event.target.value" v-if="this.triptype =='roundtrip'">
                </li>
                </ul>
            </div>
            </li>
            <li>
            <div>
                <button type="submit" style="background-color:transparent">
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

    export default {
        props: {
            destinations: {
                type: Array
            },
            url: String
        },
        data(){
            return {
                destination_from: '',
                destination_to: '',
                triptype: 'oneway',
                from: "",
                to: "",
                date_today: moment().format('YYYY-MM-DD')
            }
        },
        methods: {
            updateTripType(type){
                if(type == 'roundtrip'){
                    this.triptype = 'roundtrip'
                }else{
                    this.triptype = 'oneway'
                }
            },
            validateFields(e){

                let is_oneway = this.triptype == 'oneway'
                let is_roundtrip = this.triptype == 'roundtrip'

                if(is_roundtrip && (this.from == '' || this.to == '')){
                    alert('Please input a date');
                    return -1;
                }

                if(is_oneway && this.from == ''){
                    alert('Please input a date');
                    return -1;
                }

                if(this.destination_from == ''){
                    alert('Please select the origin')
                    return -1;
                }

                if(this.destination_to == ''){
                    alert('Please select the destination')
                    return -1;
                }

                e.target.submit();
            }
        },
        watch:{
            from(){
                let to_elem = this.$refs.to
                this.to = ""
                to_elem.value = ""
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