<template>
    <div>
        <div v-for="(schedule,index) in schedules" :key="index">
            <div class="form-group">
                <button type="button" class="btn btn-danger right_btn" @click="removeRow(index)"><i class="fa fa-times"></i></button>
                <label for="select_type">Departure Time</label>
                <input type="text" v-model="schedules[index].departure_time" :name="`schedules[${index}]`" id="departure_time"  class="form-control">  

                <!-- input elements here -->
            <div class="form-group">
                <label for="select_type">Select Route</label>
                <div class="radio">
                        <label>
                            <input type="radio" v-model="schedules[index].type" :name="`type[${index}]`" id="type" value="1">
                            PPS - ELN
                        </label>
                        <label>
                            <input type="radio" v-model="schedules[index].type" :name="`type[${index}]`" id="type" value="2">
                            ELN - PPS
                        </label>
                </div>
            </div> 
            </div>
        <hr>
        </div>
        <button type="button" class="btn_green" @click="addRow">Add Row</button>
    </div>
</template>

<script>
    export default {
        props: {
            schedules_data: {
                type: Array,
                default: () => []
            }
        },
        data(){
            return {
                schedules:this.schedules_data
            }
        },
        methods: {
            addRow(){
                this.schedules.push({
                    'departure_time': '',
                    'type': ''
                })
            },
            removeRow(index){
                this.schedules.splice(index,1)
            }
        }
    }
</script>

<style scoped>

</style>