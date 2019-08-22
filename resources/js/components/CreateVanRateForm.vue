<template>
    <div class="panel-body">
        <form :action="form_url" method="POST" @submit.prevent="validateForms">
            <!-- <transition-group tag="div" name="fade"> -->
            <div class="row" v-for="(van_rate,index) in van_rates" :key="van_rate.id">
            <input :value="van_rates[index].id || 0" type="hidden" :name="`van_rates[${index}][id]`">
                <!-- <div class="col-md-1"> -->
                        <button type="button" style="margin-right: 15px" class="btn btn-danger right_btn" @click="removeRow(index)"><i class="fa fa-times" ></i></button>
                <!-- </div> -->
                <div :class="'col-md-12'">
                    <div class="form-group"><label for="origin_id">Origin</label>
                    <select class="form-control" :name="`van_rates[${index}][origin_id]`"  id="" v-model="van_rates[index].origin_id">
                        <option value="">Select Origin</option>
                        <option v-for="origin in origins" :key="origin.id" :value="`${origin.id}`" v-show="van_rates[index]['destination_id'] != origin.id">{{ origin.name }}</option>
                    </select>
                    </div>
                </div>
                <div class="col-md-12" v-show="van_rates[index]['origin_id'] != ''">
                    <div class="form-group"><label for="destination_id">Destination</label>
                    <select class="form-control" :name="`van_rates[${index}][destination_id]`"  id="" v-model="van_rates[index].destination_id" ref="thisSelect" >
                        <option value="">Select Destination</option>
                        <option v-for="destination in destinations" :key="destination.id" :value="`${destination.id}`" v-show="!selected2[van_rates[index].origin_id].includes(destination.id)
                        && van_rates[index]['origin_id'] != destination.id
                        " >{{ destination.name }}</option>
                    </select>
                    </div>
                </div>
                <div class="col-md-12" v-show="van_rates[index]['origin_id'] != ''">
                    <div class="form-group"><label for="oneway_rate">One-way Rate:</label>
                    
                    <input type="text" :name="`van_rates[${index}][oneway_rate]`" id="oneway_rate" class="form-control" v-model="van_rates[index].oneway_rate">
                    
                    </div>
                </div>
                <div class="col-md-12" v-show="van_rates[index]['origin_id'] != ''">
                    <div class="form-group"><label for="roundtrip_rate">Round-trip</label>
                    
                    <input type="text" :name="`van_rates[${index}][roundtrip_rate]`" id="roundtrip_rate" class="form-control" v-model="van_rates[index].roundtrip_rate">
                    
                    </div>
                </div>
            </div>
            
            <!-- </transition-group> -->
        <button  type="button" class="btn_green" @click="addRow">Add Row</button>

        <button  type="submit" class="btn_orange">Submit</button>
        </form>

    </div>
</template>

<script>
    export default {
        props: {
            van_rates_data: {
                type: Array,
                default: () => []
            },
            destinations_data: {
                type: Array,
                default: () => []
            },
            origins_data: {
                type: Array,
                default:() => []
            },
            form_url: String
        },
        data(){
            return {
                van_rates: this.van_rates_data,
                destinations: this.destinations_data,
                origins: this.origins_data
            }
        },
        methods: {
            addRow(){
                this.van_rates.push({
                    "origin_id": "",
                    "destination_id": "",
                    "oneway_rate": "",
                    "roundtrip_rate": ""
                })
            },
            removeRow(index){
                this.van_rates.splice(index,1)
            },
            validateForms(e){
                for(let x =0 ; x < this.van_rates.length; x++){
                    let van_rate = this.van_rates[x];
                    delete van_rate.roundtrip_rate
                    delete van_rate.oneway_rate
                    if(Object.values(this.van_rates[x]).includes("")){
                        this.$store.dispatch("showToastr", { message: "Please fill in all the required fields.", type: "error"})
                        return -1;
                    }
                }

                e.target.submit();
            }
        },
        computed: {
            selecteds(){
                return this.van_rates.map(v => v.destination_id)
            },
            selected2(){
                let r = {}
                this.van_rates.map(v => {
                    if(r[v.origin_id] == undefined){
                        r[v.origin_id] = [];
                    }
                    r[v.origin_id].push(v.destination_id)
                })
                return r;
            }
        }
    }
</script>

<style scoped>

.fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
}

.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}

</style>