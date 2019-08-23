<template>

    <div>
        <div class="btm_sec" v-if="package_.is_day_tour == 1">
            <section class="addtocart">
                <div class="pagewrapper3">
                  <article class="qty-price">
                    <ul>
                      <!-- <li><div class="quantity"><input type="number" name="" min="1" max="20" value="1"></div></li> -->
                      <input type="text" v-model="adult_count" :min="package_data.minimum_count" style='width: 122px;height: 68px;font: 36px/36px "Circular Std Medium",Arial,sans-serif;color: #353535;padding: 0 15px;border: 0;'>
                            <div class="btns-hldr">
                            <button @click="adult_count++"><i class="fa fa-chevron-up"></i></button>
                            <button @click="adult_count--"><i class="fa fa-chevron-down"></i></button>
                            </div>
                            {{package_.is_day_tour}}
                      <li>x P{{ package_.rate }} = <span>Php {{tprice_lbl}}</span></li>
                    </ul>
                  </article>
                  <aside>
                    <a @click.prevent="addToCart" style='height: 101px;background: #f68000;border: 0;color: #fff;font: 24px/36px "Circular Std Medium",Arial,sans-serif;text-transform: uppercase;letter-spacing: 2px;padding-bottom: 20px;padding-top: 20px;padding-left: 26px; padding-right: 26px;'>Add to Cart</a>
                    
                    <!-- <input type="submit" name="" value="ADD TO CART"> -->
                  </aside>
                </div>
            </section>

            <!-- <span class="text-center" style="margin-top:30px">
                <p :style="{ color: message_class }" :class="['msg-style']" v-if="message">{{ message }}</p>
                <div class="loading-dual" v-if="loading"></div>
            </span>
            <ul class="pad-0 listn">

                <li>
                    <h4>php {{ package_.rate | formatNum }}
                        <span>per person</span>
                    </h4>
                </li>
                <li>
                    <h5>Adults</h5>
                    {{package_data.minimum_count}}
                    <div class="inc-item">
                        <input type="text" v-model="adult_count" :min="package_data.minimum_count">
                        <div class="btns-hldr">
                        <button @click="adult_count++"><i class="fa fa-chevron-up"></i></button>
                        <button @click="adult_count--"><i class="fa fa-chevron-down"></i></button>
                        </div>
                    </div>
                    <span>Php {{ ( package_.rate * adult_count || 0 ) | formatNum }}</span>
                </li>
                <li>

                    <ul class="pad-0 listn">
                        <li v-if="package_.package_download != null">
                            <a data-target="#viewDownloadModal" data-toggle="modal">View Attached File</a>
                        </li>
                        <li>
                            <a @click.prevent="addToCart">Add to Cart</a>
                        </li>
                    </ul>
                </li>
            </ul> -->
        </div>

        <section class="addtocart" v-if="package_.is_day_tour == 0">
            <div class="pagewrapper3">
              <article class="book">
                <ul>
                  
                  <li>BOOK THIS PACKAGE NOW</li>
                </ul>
              </article>
              <aside>
                <a :href="`#bookPackageTour`" class="popup-with-form" style='height: 68px;background: #f68000;border: 0;color: #fff;font: 24px/36px "Circular Std Medium",Arial,sans-serif;text-transform: uppercase;letter-spacing: 2px;'>INQUIRE NOW</a>
                <!-- <input type="submit" name="" value="INQUIRE NOW"> -->
              </aside>
            </div>
            <div :id="`bookPackageTour`" class="mfp-hide white-popup-block prcing_table-popup">
                <div class="clearfix">
                  <article class="item">
                    <form method="post" :action="form_url">
                        <h4>{{ package_.name }}</h4>
                        <label>Name</label>
                        <input type="text" name="name"><br>
                        <label>Mobile #</label>
                        <input type="text" name="mobile"><br>
                        <label>Email Address</label>
                        <input type="email" name="email_address"><br>
                        <input type="submit" name="" value="Send Inquiry">
                    </form>
                  </article>
                </div>
            </div>
        </section>
    </div>
</template>


<script>
    import axios from 'axios'
    import { package_common } from './../mixins/package_common'

    export default {
        mixins: [ package_common ],
        mounted(){
            $('.popup-with-form').magnificPopup({
                type: 'inline'
            });
        },
        props: {
            package_data: Object,
            form_url: String,
            add_to_cart_url: String
        },
        data(){
            return {
                package_ : this.package_data,
                adult_count: parseInt(this.package_data.minimum_count,10),
                tprice_lbl: (parseInt(this.package_data.minimum_count,10)*this.package_data.rate).toLocaleString(),
                message: "",
                message_class: "",
                loading: false
            }
        }
    }
</script>

<style scoped>
.msg-style{
    font-family: "Circular Std Book", Arial, sans-serif;
    font-size: 30px;
    line-height: 30px;
    margin-left: 30px;
    margin-bottom: 22px;
}
</style>