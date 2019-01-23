<template>
    <div>
            <div class="outline">
                <div v-for="(row,index) in seatMapConverted" :key="index" :class="{'row' : true, 'seat': (index == 0),'seat-spacing-sm': (index != 0)}">
                    <div class="col-fixed-md" v-if="index == 0">
                        <input class="occupied" disabled id="driverseat" name="seat" type="checkbox"> 
                        <label for="driverseat">
                        <div class="seat z-depth-soft"> <span class="idx"> Driver </span> </div>
                        <div class="seat-after z-depth-1"> </div>
                        </label>
                    </div>

                    <div v-for="(seat,i) in row"  :key="i" :class="{'col-fixed-md': (row.length < 4), 'col-fixed': (row.length == 4)}">
                        <input v-model="selected" :disabled="seat.occupied || seat.pending" name="seat[]" :value="{seatnum: seat.seatnum + 1,name:'',bday:''}" :class="{'occupied':seat.occupied,'pending':seat.pending}"  :id="`seat-${seat.seatnum}`"  type="checkbox" > 
                        <label :for="`seat-${seat.seatnum}`">
                        <div class="seat z-depth-soft"> <span class="idx">{{ seat.seatnum + 1 }}</span> </div>
                        <div class="seat-after z-depth-1"> </div>
                        </label>
                    </div>                  
                </div>
                
            </div>
            
            <div v-for="(passenger,index) in selected" :key="index" v-if="selected.length > 0">

                <passenger-information 
                @update-passenger-name="updatePassengerParent"
                :passenger="passenger"
                :index="index"> </passenger-information>

            </div>

            <div class="btn-hldr">
                <button v-if="selected.length > 0" class="btn btn-default" type="submit">Submit</button>
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
            trip_availability: {
                type: Object
            },
            seats_data: {
                type: Array,
                default: () => ['2','4','2','1','2']
            },
            occupied_seats_data: {
                type: Array,
                default: () => [1,5,8]
            },
            pending_seats_data: {
                type: Array,
                default: () => []
            }
            ,
            post_url: {
                type: String
            }
        },
        data(){
            return {
                seats: this.seats_data,
                occupied_seats: this.occupied_seats_data,
                selected: [],
                pending_seats: this.pending_seats_data
            }
        },
        methods: {
            updatePassengerParent(passenger){

        }
        },
        computed: {
            seatMapConverted(){
                let index = 0,seatMap = []
                for(let x = 0; x < this.seats.length ; x++){
                    let seat_num = parseInt(this.seats[x],10)
                    for(let y = 0; y < seat_num; y++){

                        if(seatMap[x] == undefined) seatMap[x] = []
                        let isOccupied = (this.occupied_seats.includes(index + 1))
                        let isPending = this.pending_seats.includes(index + 1)

                        seatMap[x].push({
                            seatnum: index,
                            occupied: isOccupied,
                            pending: isPending
                        })

                        index++
                    }
                }
                return seatMap;
            }
        },
        watch: {
            selected(newSeats,oldSeats){
                this.$store.commit('updateCurrentSeats',{ seatsLength: newSeats.length} )
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