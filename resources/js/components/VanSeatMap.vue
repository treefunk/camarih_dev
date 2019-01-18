<template>
    <div>
        <div v-for="(seat,index) in seats" :key="index">

            <label>Row {{ index + 1 }}</label>
            <div class="form-group">
                <button type="button" class="btn btn-danger right_btn" @click="removeRow(index)"><i class="fa fa-times"></i></button>
                <input type="number" v-model="seats[index]" :name="`seats[]`" id="header"  :placeholder="`Enter Number of seats for row ${index + 1}`" class="form-control" min="1">             
            </div>

        </div>
        <button type="button" class="btn_green" @click="addRow">Add Row</button>
    </div>
</template>

<script>
    export default {
        props: {
            seats_data: {
                type: Array,
                default: () => ['1']
            }
        },
        data(){
            return {
                seats: this.seats_data
            }
        },
        methods: {
            addRow(){
                this.seats.push('')
            },
            removeRow(index){
                this.seats.splice(index,1)
            }
        }
    }
</script>

<style scoped>

</style>