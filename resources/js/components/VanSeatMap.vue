<template>
    <div>  
        <h3>Seat plan</h3>
        <div v-for="(seat,index) in seats" :key="index">

            <label>Row {{ index + 1 }}</label>
            <div class="form-group">
                <button type="button" class="btn btn-danger right_btn" @click="removeRow(index)"><i class="fa fa-times"></i></button>
                
                <div class="inc-item">
                    <input type="text" v-model="seats[index]" :name="`seats[]`" id="header"  :placeholder="`Enter Number of seats for row ${index + 1}`" class="form-control" min="1" max="5">             
                    <div class="btns-hldr">
                        <button type="button" @click="incUp(index)"><i class="fa fa-chevron-up"></i></button>
                        <button type="button" @click="incDown(index)"><i class="fa fa-chevron-down"></i></button>
                    </div>
                </div>
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
                default: () => ['2']
            }
        },
        data(){
            return {
                seats: this.seats_data
            }
        },
        methods: {
            incUp(index){
                this.$nextTick(() => {
                    this.$set(this.seats,index,(++this.seats[index]).toString())
                })
            },
            incDown(index){
                this.$nextTick(() => {
                    this.$set(this.seats,index,(--this.seats[index]).toString())
                })
            },
            addRow(){
                let seatCount = "3";
                if(this.seats.length == 0){ seatCount = "2"}
                this.seats.push("" + seatCount)
            },
            removeRow(index){

                if(this.seats.length == 1){
                    this.$store.dispatch("showToastr", {message: "Seat plan must have at least 1 row.",type: "error"})
                    return -1;
                }

                this.seats.splice(index,1)
                if(parseInt(this.seats[0],10) > 3){
                    this.seats[0] = "2"
                    return;
                }
            }
        },
        watch:{
            seats(newSeats,oldSeats,wat)
            {
                if(parseInt(newSeats[0],10) >= 3){
                    this.$store.dispatch("showToastr", { message: 'You can only have 2 seats maximum in the first row',type: "error"})
                    newSeats[0] = '2'
                    return;
                }
                if(parseInt(newSeats[0],10) <= 1){
                    this.$store.dispatch("showToastr", { message: 'Minimum count of seat in the first row is 2',type: "error"})
                    newSeats[0] = '2'
                }

                for(let x = 1 ; x <= newSeats.length; x++)
                {
                    if(parseInt(newSeats[x],10) < 3){
                            this.$store.dispatch("showToastr", { message: 'Minimum count of seat per row is 3',type: "error"})
                            newSeats[x] = '3'
                    }
                    if(parseInt(newSeats[x],10) > 4){
                        this.$store.dispatch("showToastr", { message: 'You can only have 4 seats maximum in a row',type: "error"})
                        newSeats[x] = '4'
                    }
                }
                
                // if(newSeats.length == oldSeats.length && newSeats[newSeats.length - 1] > 4){
                //     alert('You can only have 4 seats maximum in a row')
                //     newSeats[newSeats.length - 1] = 4
                //     return;
                // }
            }
        }
    }
</script>

<style scoped>
    .inc-item .btns-hldr { top: 49px;}
</style>