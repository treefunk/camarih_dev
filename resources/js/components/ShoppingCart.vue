<template>
    <section class="sec-2">
          <div class="container-cs">
            <div class="main-hldr">
              <div class="booking-part">
        <transition-group tag="ul" name="fade">
        <li class="booking-card" :key="item.booking_num" v-for="(item,index) in shopping_cart">
            <!-- <button type="button" @click="removeItem(index)" class="btn btn-danger">X</button> -->
                <booking-trip 
                :index="index" 
                v-if="item.item_type == 'booking_trip'" 
                :trip="item" 
                v-model="item[index]" 
                @addcheckout="addBookingTrip" 
                @removeMe="removeBookingItem(index)"
                />
                <booking-package 
                :index="index" 
                v-if="item.item_type == 'booking_package'"
                />
                <booking-van 
                :index="index" 
                v-if="item.item_type == 'booking_van'"
                :van_rent_data="item"
                v-model="item[index]"
                @removeMe="removeBookingItem(index)"
                @addcheckout="addBookingTrip" 
                />
        </li>
        </transition-group>

        
              </div>
              <div class="checkout">
                <div class="white-bg"></div>
                <div class="hldr">
                  <h4>Checkout</h4>
                  <form :action="checkout_url" method="POST" @submit.prevent="validateCheckout">
                  <ul class="pad-0 listn main-list">
                    
                    <li v-for="(c,i) in checkout" :key="i">
                      <input type="hidden" name="booking_num[]" :value="c.booking_num" />
                      <h5>Booking#: {{ c.booking_num }}</h5>
                      <div class="parent">
                        <div class="children">
                          <p>Type:</p>
                        </div>
                        <div class="children">
                          <p>{{ c.item_type | formatType }}</p>
                        </div>
                      </div>
                      <div v-if="c.item_type == 'booking_trip'" class="parent">
                        <div class="children">
                          <p>Trip:</p>
                        </div>
                        <div class="children">
                          <p>{{ c.type }}</p>
                        </div>
                      </div>
                      <div class="parent">
                        <div class="children">
                          <p>Total:</p>
                        </div>
                        <div class="children">
                          <p>{{ c.total | formatNum }}</p>
                        </div>
                      </div>
                    </li>
                    
                  </ul>
                  <div class="btm-hldr">
                    <div class="parent">
                        <div class="children">
                          <h6>Grand Total:</h6>
                        </div>
                        <div class="children">
                          <h6>Php {{ total_price  | formatNum }}</h6>
                        </div>
                    </div>
                  </div>
                  <div class="checkout-btm">
                    <button class="proceed-to-checkout" type="submit" >Proceed to Checkout</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            </div>
    </section>
</template>

<script>
    import axios from 'axios'

    import BookingTrip from './BookingTrip.vue'
    import BookingPackage from './BookingPackage.vue'
    import BookingVan from './BookingVan.vue'
    



    export default {
        components: {
            'booking-trip': BookingTrip,
            'booking-package': BookingPackage,
            'booking-van' : BookingVan
        },
        props: {
            shopping_cart_data : {
                type: Array,
                default: () => []
            },
            item_remove_url: {
                type: String,
            },
            checkout_url: {
              type: String,
              default: 'youdidnotspecifythecheckouturlhehe'
            }
        },
        data() {
            return {
                shopping_cart: this.shopping_cart_data,
                checkout: []
            }
        },
        methods: {
            removeItems() {
                // todo run ajax to delete item in session
                
            },
            addBookingTrip(payload){
                let checkout_all_booking = this.checkout.map(c => {
                    return c.booking_num
                })
                if(payload.checked && !checkout_all_booking.includes(payload.booking_num)){
                    this.checkout.push(payload)
                }else{
                    this.checkout = this.checkout.filter(c => {
                        return c.booking_num != payload.booking_num
                    })
                }
            },
            removeBookingItem(index){
                let that = this
                axios({
                    method: 'post',
                    url: this.item_remove_url,
                    data: {
                        index: index
                    }
                }).then(function (response) {
                    // if successfully removed in session splice data in vue
                    that.checkout = that.checkout.filter((c) => c.booking_num != that.shopping_cart[index].booking_num)
                    that.shopping_cart.splice(index, 1)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validateCheckout(e){
    
              if(this.checkout.length == 0){
                alert('cart is empty')
                return -1;
              }

              e.target.submit();


            }
            
        },
        computed: {
              total_price(){
                  return this.checkout.reduce((accu,c) => {
                    let total = 0;
                    if(c.item_type == 'booking_trip'){
                      total += (Object.keys(c.departure_data.seats).length * c.departure_data.selected.rate_price)
                      if(c.return_data.seats != false){
                        total += (Object.keys(c.return_data.seats).length * c.return_data.selected.rate_price)
                      }   
                      return total + accu
                    }else if(c.item_type == 'booking_van'){
                      total += parseFloat(c.total)
                      return total + accu
                    }
                },0)
              }
        },
        filters: {
          formatNum: (value) => {
              if(typeof value == "string"){ value = parseInt(value,10) }
              return value.toLocaleString(undefined,{
                 minimumFractionDigits: 2,
              })
          },
          formatType: (val) => {
            if(val == 'booking_trip'){ return "Trip Reservation" }
            if(val == 'booking_van'){ return "Van Rental" }
          }
        }
          
    }
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
  
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
  
}

li{
  list-style: none;
}

.proceed-to-checkout {
      padding: 20px 40px;
    background: #429e47;
    color: #fff;
    font-family: "Circular Std Medium", Arial, sans-serif;
    font-size: 18px;
    text-transform: uppercase;
    text-decoration: none;
    display: inline-block;
}
</style>