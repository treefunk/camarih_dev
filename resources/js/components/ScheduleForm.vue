<template>
    <div>
        <div v-for="(schedule,index) in schedules" :key="index">
            {{ getOrdinal(index + 1) }} Trip
                    <button type="button" class="btn btn-danger right_btn" @click="removeRow(index)"><i class="fa fa-times"></i></button>
            <div class="row">
                    <input type="hidden" :name="`schedules[${index}][trip_num]`" :value="index+1">
                    <div class="form-group col-md-5">
                        <label for="select_type">PPS TO ELN</label>
                        <input type="text" v-model="schedules[index].departure_time_pps" :name="`schedules[${index}][departure_time_pps]`" id="departure_time"  class="form-control">  
                    </div>

                    <div class="form-group col-md-5">
                        <label for="select_type">ELN TO PPS</label>
                        <input type="text" v-model="schedules[index].departure_time_eln" :name="`schedules[${index}][departure_time_eln]`" id="departure_time"  class="form-control">  
                    </div>
            </div>
        <hr>
        </div>
        <button type="button" class="btn_green" @click="addRow">Add Schedule</button>
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
                    'trip_num': this.schedules.length + 1,
                    'departure_time_pps': '',
                    'departure_time_eln': ''
                })
            },
            removeRow(index){
                this.schedules.splice(index,1)
            }, getOrdinal(n){
                let s=["th","st","nd","rd"],
                    v=n%100;
                return n+(s[(v-20)%10]||s[v]||s[0]);
            },
        }
    }
</script>

<style scoped>

</style>