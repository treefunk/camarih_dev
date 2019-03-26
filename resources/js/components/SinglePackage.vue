<template>
    <div>
        <section :class="{ 'sec-3': isRight ,
         'clearfix':isRight, 'sec-2': !isRight}">
            <article class="pckage_wrap clearfix">
              <div class="clearfix">
                <aside :class="isRight ? 'right' : 'left'">
                  <img :src="main_image">
                </aside>
                <article :class="!isRight ? 'right' : 'left'">
                  <div>
                    <ul class="pad-0 listn">
                        <li>
                          <h3>{{ item.name }}</h3>
                        </li>
                        <!-- <li>
                          <h5>{{ item.package_details.description }}</h5>
                        </li> -->
                        <li>
                          <h4>Php {{ item.rate }} <span>per person</span></h4>
                        </li>
                        <li>
                          <h6>Adults</h6>
                          <input type="number" v-model="adult_count" :min="item.package_details.minimum_count">
                        </li>
                    </ul>
                    <aside>
                        <div class="text-center" style="margin-top:30px">
                            <p :style="{ color: message_class }" :class="['msg-style']" v-if="message">{{ message }}</p>
                            <div class="loading-dual" v-if="loading"></div>
                        </div>
                      <ul class="pad-0 listn">
                        <li>
                          <a :href="`${this.single_url}/${item.id}`">View Details</a>
                        </li>
                        <li>
                          <button @click="addToCart"><span class="add-to-cart">Add to cart</span></button>
                        </li>
                      </ul>
                    </aside>
  
                    </div>
  
                </article>
              </div>

            </article>

            </section>
    </div>
</template>

<script>

    import { package_common } from './../mixins/package_common'

    export default {
        mixins: [ package_common ],
        data(){
            return {
                adult_count: this.item.package_details.minimum_count,
                isRight: ((this.index + 1) % 2 == 0) ,
                in: this.index,
                message: "",
                message_class: "",
                loading: false,
                package_:this.item
            }
        },
        props: [ 'item', 'index', 'single_url','add_to_cart_url', 'main_image_url'],
        computed: {
          main_image(){
            if(this.item.package_image != null){
              return `${this.main_image_url}/${this.item.package_image.id}_${this.item.package_image.image_name}`
            }else{
              return  this.item.image_path
            }
          }
        }
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