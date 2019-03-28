<template>
    <div>
                  <div class="top clearfix">
                    <div class="left">  
                      
                          <div class="input-hldr">
                            <input type="checkbox" v-model="checked">
                            <span class="uncheck"></span>
                          </div>
                       
                          <h4>Booking #: {{ booking_num }}</h4>
                        
                    </div>
                    <div class="right">
                      <div class="icon-hldr">
                        <!-- TODO: EDIT BOOKING TRIP -->
                        <!-- <a :href="`${this.edit_base_url}/${booking_num}`"><i class="fa fa-pencil"></i></a> -->
                        <a href="" @click.prevent="remove"><i class="fa fa-close"></i></a>
                      </div>
                    </div>
                  </div>
                  <div class="body">
                    <ul class="pad-0 listn">
                      <li>
                        <div class="parent">
                          <div class="children">
                            <p>Trip Type:</p>
                          </div>
                          <div class="children">
                            <p>{{  type }}</p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="parent">
                          <div class="children">
                            <p>Seats:</p>
                          </div>
                          <div class="children">
                            Departure:
                            <p>{{ concatenated_seats_departure }}</p>
                          
                          <div  v-if="concatenated_seats_return != ''">
                            Return:
                            <p class="return">{{ concatenated_seats_return }}</p>
                          </div>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="parent">
                          <div class="children">
                            <p>Destination/Return Location:</p>
                          </div>
                          <div class="children">
                            Departure:
                            <p>{{ departure_data.selected.origin.name }} - {{ departure_data.selected.destination.name }}</p>
                            <div  v-if="return_data.selected">
                            Return:
                            <p>{{ return_data.selected.origin.name }} - {{ return_data.selected.destination.name }}</p>
                          </div>
                          </div>
                        </div>
                      </li>
                      <li v-if="departure_data.selected">
                        <div class="parent">
                          <div class="children">
                            <p>Departure Date & Time:</p>
                          </div>
                          <div class="children">
                            <p>{{ departure_data.selected.from | formatDate }} | {{ departure_data.selected.departure_time }}</p>
                            <!-- <p>February 24, 2019 | 06:30AM</p> -->
                          </div>
                        </div>
                      </li>
                      <li v-if="return_data.selected">
                        <div class="parent">
                          <div class="children">
                            <p>Return Date & Time:</p>
                          </div>
                          <div class="children">
                            <p>{{ return_data.selected.from | formatDate }} | {{ return_data.selected.departure_time }}</p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="parent">
                          <div class="children">
                            <p>Price: </p>
                          </div>
                          <div class="children">
                            Departure:
                            <p>&#8369; {{ departure_data.selected.rate_price | formatNum }}</p>
                            <div v-if="return_data.selected">
                              Return:
                              <p>&#8369; {{ return_data.selected.rate_price | formatNum }}</p>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="parent">
                          <div class="children">
                            <p># of Seats:</p>
                          </div>
                          <div class="children">
                            Departure:
                            <p>{{ departure_data.seats.length }}</p>
                            <div v-if="return_data.seats.length">
                              Return:
                              <p>{{ return_data.seats.length }}</p>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="parent">
                          <div class="children">
                            <p>Total</p>
                          </div>
                          <div class="children">
                            <p>&#8369; {{ total | formatNum }}</p>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
</template>

<script>

    import moment from 'moment';
    import { cart_item } from './../mixins/cart_item'
    export default {
        mixins: [ cart_item ],
        props: {
            trip: {},
            index: Number,
            edit_base_url: String
        },
        mounted(){
          this.checked = true
        },
        data(){
            return {
                checked: false,
                type: this.trip.check_availability.is_roundtrip == "true" ? 'Round-trip' : 'One-way',
                booking_num: this.trip.booking_num,
                departure_data: {
                    departure_date: this.trip.selected[0].from,
                    selected: this.trip.selected[0],
                    seats: this.trip.selected_seats[0],
                    booking_information: this.trip.booking_information[0]
                },
                return_data: {
                    departure_date: this.trip.check_availability.is_roundtrip == "true" ? this.trip.selected[1].from : false,
                    selected: this.trip.check_availability.is_roundtrip == "true" ? this.trip.selected[1] : false,
                    seats: this.trip.check_availability.is_roundtrip == "true" ? this.trip.selected_seats[1] : false,
                    booking_information: this.trip.check_availability.is_roundtrip == "true" ? this.trip.booking_information[1] : false
                },
                item_type: this.trip.item_type
            }
        },
        methods: {
            
        },
        computed: {
          total(){
            let total = 0
            total += (Object.keys(this.departure_data.seats).length * this.departure_data.selected.rate_price)
            if(this.return_data.seats != false){
              total += (Object.keys(this.return_data.seats).length * this.return_data.selected.rate_price)
            }
            return total
          },
          concatenated_seats_departure(){
            return this.departure_data.seats.map(s => `[#${s.seatnum} - ${s.name}]`).join(',')
          },
          concatenated_seats_return(){
            return  !this.return_data.seats ? "" :this.return_data.seats.map(s => `[#${s.seatnum} - ${s.name}]`).join(',')
          }
        }
        
    }
</script>

<style scoped>
.return{
      font-size: 18px;
    color: #000;
    word-break: break-word;
}
</style>