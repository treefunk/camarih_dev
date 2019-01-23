<template>
    <div>
            <div class="outline">
                
                <div v-for="(row,index) in seats" :key="index" :class="['row',{
                    'seat': row.length == index + 1,
                    'seat-spacing-sm': row.length == index + 1
                }]">
                    
                    <!-- driver -->
                    <div class="col-fixed-md" v-if="index == 0">
                        <input class="occupied" disabled id="driverseat" name="seat" type="checkbox"> 
                        <label for="driverseat">
                        <div class="seat z-depth-soft"> <span class="idx"> Driver </span> </div>
                        <div class="seat-after z-depth-1"> </div>
                        </label>
                    </div>

                    <!-- seat input -->
                    <div v-for="(seat,i) in row" :key="i" :class="{
                        'col-fixed-md': row.length < 4,
                        'col-fixed': row.length == 4
                    }">
                        <input 
                        v-model="seats[index][i]['selected']" :value="seat" :disabled="seat.isOccupied || seat.isPending" name="seat[]" :class="{'occupied':seat.isOccupied,'pending':seat.isPending}"  :id="`seat-${seat.seatnum}`"  type="checkbox" > 
                        <label :for="`seat-${seat.seatnum}`">
                        <div class="seat z-depth-soft"> <span class="idx">{{ seat.seatnum }}</span> </div>
                        <div class="seat-after z-depth-1"> </div>
                        </label>
                    </div>                  
                </div>
                
            </div>
            
            <div v-for="(row,i) in seats" :key="i">

                <passenger-information v-for="(passenger,index) in row" :parentindex="i" :index="index" :key="index" :passenger="passenger" > </passenger-information>
            </div>

            <div class="btn-hldr">
                <button  class="btn btn-default" type="submit">Submit</button>
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
            }
        },
        data(){
            return {
                seats: this.seats_data,
                sels: this.sels_data
            }
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