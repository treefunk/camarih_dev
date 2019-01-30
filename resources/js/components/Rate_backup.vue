<template>
    <div>
            <div class="form-group">
                <select @change="checkSelected" v-model="selectedFrom" class="form-control input-lg m-bot15" name="destination_id" id="destination">
                    <option value="">Select Origin</option>
                    <option v-for="(destination,index) in destinations" :value="destination.id" :key="index" >{{ destination.name }}</option>
                </select>
            </div>
            <label v-if="this.rate_list.length > 0" for="rate">Rates:</label>


            <div v-for="(rate,index) in rates" :key="index">
                <button type="button" class="btn btn-danger right_btn" @click="removeMe(index)"><i class="fa fa-times"></i></button>
                <div class="form-group" v-if="selectedFrom != ''">
                    <select v-model="rate.destination_id" class="form-control input-lg m-bot15" :name="`rates[${index}][destination_id]`" id="destination">
                        <option value="">Select Destination</option>
                        <option v-for="(destination,index) in destinationsWithoutSelected" :key="index" :value="destination.id">{{ destination.name }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <input v-model="rate.price" type="text" class="form-control" :name="`rates[${index}][price]`" id="" placeholder="Enter Price">
                </div>

            </div>


    </div>
</template>

<script>
    export default {
        mounted(){
            
        },
        props: {
            destinations: {
                type: Array,
                default: () => []
            },
            rate_list: {
                type: Array,
                default: () => []
            },
            is_roundtrip: {
                type: Boolean,
                default: false
            },
            selectedOrigin: String

        },
        data(){
            return {
                selectedTo: '',
                filtered: [],
                rates: this.rate_list,
                selectedFrom: this.selectedOrigin
            }
        },
        computed: {
            destinationsWithoutSelected(){
                
                let newDestination = [];
                let destinations = this.destinations;

                for(let x = 0 ; x < destinations.length; x++){
                    if(destinations[x].id != this.selectedFrom){
                        newDestination.push(destinations[x])
                    }
                }

                let selection = newDestination.map((d) => d.id)
                let selected = this.rates.map((d) => d.destination_id)


                let filtered = newDestination.map((d) => {
                    if(selected.includes(d.id)){
                        d.selected = true 
                    }else{
                        d.selected = false
                    }
                    return d
                })
                
                return filtered
            }
        },
        methods: {
            checkSelected(e){
                if(e.target.value == ''){
                    this.$emit('clear-rates')
                }   
            },
            removeMe(index){
                this.$emit('remove-selected',index)
            }
        },
        watch: {
            selectedFrom(newValue){
                this.$emit('update-selected',newValue)
            }
        }
        
    }
</script>

<style scoped>

</style>