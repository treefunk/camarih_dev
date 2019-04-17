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
                        <!-- <a href=""><i class="fa fa-pencil"></i></a> -->
                        <a href="" @click.prevent="remove"><i class="fa fa-close"></i></a>
                      </div>
                    </div>
                  </div>
                  <div class="body">
                    <ul class="pad-0 listn">
                      <li>
                        <div class="parent">
                          <div class="children">
                            <p>Van Type</p>
                          </div>
                          <div class="children">
                              <p>{{ van_rent.van.name }}</p>
                          </div>
                        </div>
                      </li>
                      
                      <li>
                        <div class="parent">
                          <div class="children">
                            <p>Departure Date</p>
                          </div>
                          <div class="children">
                              <p>{{ van_rent.departure_date }}</p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="parent">
                          <div class="children">
                            <p>Destination:</p>
                          </div>
                          <div class="children">
                            <p>{{ van_rent.origin.name }} <i class="fa fa-long-arrow-right"></i> {{ van_rent.destination.name }}</p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="parent">
                          <div class="children">
                            <p>Trip type:</p>
                          </div>
                          <div class="children">
                            <p>{{ van_rent.trip_type | filterTripType }}</p>
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
            van_rent_data: {
                type: Object
            }
        },
        mounted(){
          this.checked = true;
        },
        data() {
            return {
                checked:false,
                booking_num: this.van_rent_data.booking_num,
                item_type: this.van_rent_data.item_type,
                van_rent: this.van_rent_data,
                total: parseFloat(this.van_rent_data.price)
            }
        },
        methods: {
        },
        filters: {
          filterTripType: (trip) => {
            switch(trip){
              case "round_trip":
                return "Round Trip"
              case "oneway_trip":
                return "One-way Trip"
              default:
                return "Unknown Trip"
            }
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