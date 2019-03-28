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
                :edit_base_url="edit_base_url"
                :trip="item" 
                v-model="item[index]" 
                @addcheckout="addBookingTrip" 
                @removeMe="removeBookingItem(index)"
                />
                <booking-package 
                :index="index"
                v-if="item.item_type == 'booking_package'"
                :package_data="item"
                v-model="item[index]"
                @addcheckout="addBookingTrip" 
                @removeMe="removeBookingItem(index)"
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


                  <div  class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true"
                        style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="z-index:99">×</button>
                                    <h4 class="modal-title">Checkout Details</h4>
                                    <div class="form-group"> <label for="fullname"> Fullname </label> <input name="booking_information[fullname]" class="form-control"
                                        id="fullname" required="" type="text"> </div>


                                    <div class="form-group"> <label for="email"> Email </label> <input name="booking_information[email]" class="form-control"
                                        id="email" required="" type="email">
                                    </div>

                                    <div class="form-group"> <label for="phone"> Phone </label> <input name="booking_information[phone]" class="form-control"
                                        id="phone" required="" type="text">
                                    </div>

                                </div>
                                <div class="modal-body">
                                        
                   
                                </div>
                                <div class="modal-footer">
                                    <!-- <button data-dismiss="modal" class="btn btn-default" type="button">Close</button> -->
                                    <button type="submit" class="proceed-to-checkout">Checkout</button>
                                </div>
                                </div>
                            </div>
                    </div>



                  <div class="checkout-btm">
                    <button type="button" @click="showCheckoutForm" class="proceed-to-checkout">Proceed to Checkout</button>
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
            },
            edit_base_url: {
              type: String,
              default: "noediturl"
            }
        },
        data() {
            return {
                shopping_cart: this.shopping_cart_data,
                checkout: []
            }
        },
        methods: {
            showCheckoutForm(){
              if(this.checkout.length == 0){
                this.$store.dispatch("showToastr", { message: "Cart is empty.", type: "error"})
                return -1;
              }
                $('#checkoutModal').modal('show')   
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
                this.$store.dispatch("showToastr", { message: "Cart is empty.", type: "error"})
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
                    }else if(c.item_type == 'booking_package'){
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
            if(val == 'booking_package'){ return "Tour Package" }
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