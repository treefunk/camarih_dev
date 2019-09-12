<template>
  <li>
               <aside><a :href="item.slug"><img :src="main_image"></a></aside>
               <article>
                 <h3><a :href="item.slug">{{ item.name }}</a></h3>
                 <h5>{{ item.location_name }}</h5>
                 <!-- <h4>Php {{ item.rate | formatNum }}</h4> -->
                 <h4 v-if="item.is_day_tour == 0">{{item.price_description_f}} <span><br>{{item.price_description_span}}</span></h4>
                 <h4 v-if="item.is_day_tour == 1">{{item.price_description_f}}</h4>

                 <h6><a :href="item.slug">View Details</a></h6>
               </article>
             </li>

    <!-- <div>
        <section :class="{ 'sec-3': !isLeft ,
         'clearfix':isLeft, 'sec-2': isLeft}">
            <article class="pckage_wrap clearfix">
              <div class="clearfix">
                <aside :class="isLeft ? 'right' : 'left'">
                  <img :src="main_image">
                </aside>
                <article :class="!isLeft ? 'right' : 'left'">
                  <div>
                    <ul class="pad-0 listn" >
                        <li>
                          <h3>{{ item.name }}</h3>
                        </li>
                        <li>
                          <h4>Php {{ item.rate | formatNum }} <span>per person</span></h4>

                        </li>
                        <li v-if='package_.is_day_tour != 0'>
                          
                          <h6>Adults</h6>
                           <div class="inc-item">
                             <input type="text" v-model="adult_count" :min="item.minimum_count">
                             <div class="btns-hldr">
                               <button type="button" @click="adult_count++"><i
                                   class="fa fa-chevron-up"></i></button>
                               <button type="button" @click="adult_count--"><i
                                   class="fa fa-chevron-down"></i></button>
                             </div>
                           </div>
                        </li>
                    </ul>
                    <aside>
                      <ul class="pad-0 listn">
                        <li>
                          <a :href="`${this.single_url}/${item.id}`">View Details</a>
                        </li>
                        <li v-if='package_.is_day_tour == 1'>
                          <button @click="addToCart" ><span class="add-to-cart">Add to cart</span></button>
                        </li>
                        <li v-if='package_.is_day_tour == 0'>
                          <button ><a href="#modal" class="popup-with-form"><span class="add-to-cart">Add to cart</span></a></button>
                        </li>
                      </ul>
                    </aside>
  
                    </div>
  
                </article>
                <div :id="`modal`" class="mfp-hide white-popup-block prcing_table-popup">
                    <div class="clearfix">
                      <article class="item">
                        <h3>{{ item.name }}</h3>
                      </article>
                    </div>
                </div>
              </div>

            </article>

            </section>
    </div> -->
</template>

<script>

    import { package_common } from './../mixins/package_common'

    export default {
        mounted(){
          $('.popup-with-form').magnificPopup({
            type: 'inline'
          });
        },
        mixins: [ package_common ],
        data(){
            return {
                // adult_count: this.item.minimum_count,
                adult_count: 1,
                isLeft: !((this.index + 1) % 2 == 0) ,
                in: this.index,
                loading: false,
                package_:this.item
            }
        },
        props: [ 'item', 'index', 'single_url','add_to_cart_url'],
        
    }
</script>

<style scoped>

.add-to-cart{
    font-family: "Circular Std Book", Arial, sans-serif;
    font-size: 18px;
    text-transform: uppercase;
    color: #fff;
    text-decoration: none;
    background:transparent;
}

ul > li:nth-child(2) > button{
    background: #f68000
}
.msg-style{
    font-family: "Circular Std Book", Arial, sans-serif;
    font-size: 30px;
    line-height: 30px;
    margin-left: 30px;
    margin-bottom: 22px;
}

</style>