<template>
    <div>
            <div class="outline">
                
                <div v-for="(row,index) in seats" :key="index" :class="['row',{
                    'seat': row.length == index + 1,
                    'seat-spacing-sm': row.length == index + 1
                }]">
                    
                    <!-- driver -->
                    <div :class="['parent',{'ch3': (row.length  + (index == 0 ? 1 : 0)) == 3, 'ch4': row.length == 4}]">
                        <div class="children" v-if="index == 0">
                            <div class="col-fixed-md" >
                                <input class="occupied" disabled id="driverseat" name="seat" type="checkbox"> 
                                <label for="driverseat">
                                <div class="seat z-depth-soft"> <span class="idx"> Driver </span> </div>
                                <div class="seat-after z-depth-1"> </div>
                                </label>
                            </div>
                        </div>
                        

                        <!-- seat input -->
                        <div class="children" v-for="(seat,i) in row" :key="i">
                            <!-- <div v-for="(seat,i) in row" :key="i" :style="`display:inline-block; width:calc(100% / ${index == 0 ? row.length + 1 : row.length});`"> -->



                                <input 
                            v-model="seats[index][i]['selected']" :value="seat" :disabled="seat.isOccupied || seat.isPending"  :class="{'occupied':seat.isOccupied,'pending':seat.isPending}"  :id="`seat-${seat.seatnum}`"  type="checkbox" > 
                                <label :for="`seat-${seat.seatnum}`">
                                    <div class="seat z-depth-soft"> <span class="idx">{{ seat.seatnum }}</span> </div>
                                    <div class="seat-after z-depth-1"> </div>
                                </label>
                        </div>
                    </div>                  
                </div>
                
            </div>

        
            
            
            <div v-for="(row,i) in seats" :key="i">

                <passenger-information v-for="(passenger,index) in row" @unselectSeat="unselectSeat" :parentindex="i" :index="index" :key="index" :passenger="passenger" > </passenger-information>
            </div>

            <div class="container">
                <div class="row">

                    <div class="modal fade" id="bookingInformation" tabindex="-1" role="dialog" aria-labelledby="bookingInformationLabel" aria-hidden="true"
                        style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="z-index:99">×</button>
                                    <h4 class="modal-title">Booking Information</h4>
                                </div>
                                <div class="modal-body">
                                        
                                    <!-- <div class="form-group"> <label for="fullname"> Fullname </label> <input name="booking_information[fullname]" class="form-control" id="fullname" required=""
                                            type="text"> </div>


                                    <div class="form-group"> <label for="email"> Email </label> <input name="booking_information[email]" class="form-control" id="email" required="" type="email">
                                    </div>


                                    <div class="form-group"> <label for="phone"> Phone </label> <input name="booking_information[phone]" class="form-control" id="phone" required="" type="text">
                                    </div> -->


                                    <div class="form-group"> <label for="pickup"> Pickup Location </label> <textarea v-model="booking_information['pickup_location']" name="booking_information[pickup_location]" class="form-control" id="pickup"
                                            required="" rows="3"> </textarea> </div>


                                    <div class="form-group"> <label for="drop"> Drop Location </label> <textarea v-model="booking_information['drop_location']" name="booking_information[drop_location]" class="form-control" id="drop" required=""
                                            rows="3"> </textarea> </div>


                                    <!-- <div class="form-group"> <label for="flight"> Flight Info </label> <textarea name="booking_information[flight_info]" class="form-control" id="flight" required=""
                                            rows="3"> </textarea> </div>
                                     -->
                   
                                </div>
                                <div class="modal-footer">
                                    <!-- <button data-dismiss="modal" class="btn btn-default" type="button">Close</button> -->
                                    <div class="btn-hldr" v-if="currentSeats.length">
                                    <button  class="btn btn-default" type="submit">Submit</button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            

            <div class="btn-hldr" v-if="currentSeats.length">
                <button @click="showInfoForm" class="btn btn-default" type="button">Next</button>
            </div>

            

            
    </div>
</template>

<script>

        import PassengerInformation from './PassengerInformation'

    export default {
        components: {
            'passenger-information' : PassengerInformation
        },
        props: {
            seats_data: {
                type: Array
            },
            seat_map: {
                type: Array
            },
            sels_data: {
                type: Array,
                default: () => []
            },
            booking_information_data: {
                type: Object,
                default: () => { return {
                        pickup_location: "",
                        drop_location: ""
                    }
                }
            },
            current_seats_data:{
                type: Array,
                default: () => []
            }
        },
        data(){
            return {
                seats: this.seats_data,
                sels: this.sels_data,
                booking_information: this.booking_information_data
            }
        },
        mounted(){
                this.$store.commit('updateCurrentSeats', { seatsLength: this.currentSeats.length })
        },
        computed:{
            
            selected(){

                let filtered = []
                for(let x = 0 ; x < this.seats.length ; x++)
                {
                    for(let y = 0; y < this.seats[x].length; y++)
                    {
                        if(!this.seats[x][y].isOccupied && !this.seats[x][y].isPending)
                        {
                            for(let z = 0; z < this.sels; z++){
                                if(this.sels[z]['seatnum'] == this.seats[x][y]['seatnum']){
                                    filtered.push(this.sels[z])
                                }
                            }
                            filtered.push(this.seats[x][y])
                        }
                    }
                }
                return filtered
            },
            currentSeats(){
                return this.selected.filter( (seat) => seat.selected == true)
            }
        },
        watch: {
            currentSeats(newV) {
                let currentLength = newV.length
                this.$store.commit('updateCurrentSeats', { seatsLength: currentLength })
            }
        },
        methods: {
            showInfoForm(){
                $('#bookingInformation').modal('show')   
            },
            unselectSeat(payload){
                this.seats[payload.parentindex][payload.index].selected = false
            }
        }
    }
</script>

<style scoped>
.outline{
    background-size: 100% 100%;
    width: 280px;
    height: 540px;
    padding-top: 100px;
    padding-left: 50px;
    padding-right: 50px;
    position: relative;
    display: block;
    margin: 0 auto;
}
.pending{
    background: yellow;
}

</style>