<template>
    <div>
        <div v-for="(seat,index) in seats" :key="index">

            <label>Row {{ index + 1 }}</label>
            <div class="form-group">
                <button type="button" class="btn btn-danger right_btn" @click="removeRow(index)"><i class="fa fa-times"></i></button>
                <input type="number" v-model="seats[index]" :name="`seats[]`" id="header"  :placeholder="`Enter Number of seats for row ${index + 1}`" class="form-control" min="1" max="5">             
            </div>

        </div>
        <button v-if="this.seats.length < 5" type="button" class="btn_green" @click="addRow">Add Row</button>
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

                if(this.seats.length == 1){
                    alert('Seat plan must have at least 1 row.');
                    return -1;
                }

                this.seats.splice(index,1)
            }
        },
        watch:{
            seats(newSeats,oldSeats,wat)
            {
                if(newSeats[0] > 3){
                    alert('You can only have 2 seats maximum in the first row')
                    newSeats[0] = 2
                    return;
                }

                if(newSeats.length == oldSeats.length && newSeats[newSeats.length - 1] > 4){
                    alert('You can only have 4 seats maximum in a row')
                    newSeats[newSeats.length - 1] = 4
                    return;
                }
            }
        }
    }
</script>

<style scoped>

</style>