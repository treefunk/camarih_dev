<template>
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
                    <option value="">Select a Location</option>
                        <option v-for="(destination,index) in destinations" :key="index" :value="`${destination.id}`">{{ destination.name }}</option>
                    </select>
                    <input name="departure_from" type="date">
                </li>
                <li >
                    <h5>To</h5>
                    <select name="destination_to" v-model="destination_to">
                    <option value="" >Select a Location</option>
                        <option v-for="(destination,index) in destinations" :key="index" :value="`${destination.id}`">{{ destination.name }}</option>
                    </select>
                    <input name="departure_to" type="date" v-if="this.triptype =='roundtrip'">
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
</template>

<script>
    export default {
        props: {
            destinations: {
                type: Array
            }
        },
        data(){
            return {
                destination_from: '',
                destination_to: '',
                triptype: 'oneway'
            }
        },
        methods: {
            updateTripType(type){
                if(type == 'roundtrip'){
                    this.triptype = 'roundtrip'
                }else{
                    this.triptype = 'oneway'
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