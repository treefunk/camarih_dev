<template>
    <div>
        <section :class="{ 'sec-3': isRight ,
         'clearfix':isRight, 'sec-2': !isRight}">
            <article class="pckage_wrap clearfix">
              <div class="clearfix">
                <aside :class="isRight ? 'right' : 'left'">
                  <img :src="item.image_path">
                </aside>
                <article :class="!isRight ? 'right' : 'left'">
                  <div>
                    <ul class="pad-0 listn">
                        <li>
                          <h3>{{ item.name }}</h3>
                        </li>
                        <li>
                          <h5>{{ item.package_details.description }}</h5>
                        </li>
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
    import axios from 'axios'


    export default {
        data(){
            return {
                adult_count: this.item.package_details.minimum_count,
                isRight: ((this.index + 1) % 2 == 0) ,
                in: this.index,
                message: "",
                message_class: "",
                loading: false
            }
        },
        props: [ 'item', 'index', 'single_url','add_to_cart_url'],
        methods: {
            addToCart: function() {
              this.loading = true;
              let new_item = Object.assign({},this.item,{ adult_count: this.adult_count })
              axios.post(this.add_to_cart_url,new_item).then(res => {
                let response = res.data
                console.log(response)
                this.loading = false
                this.message = response.message
                this.message_class = "green"
              })
              this.$store.commit('addPackageToCart',{ item: new_item })
            }
        },
        watch: {
          adult_count(newV){
            let min_count = this.item.package_details.minimum_count
            if(parseInt(newV,10) < parseInt(min_count,10)){
              alert(`Sorry, minimum count for this package is ${min_count}`)
              this.adult_count = min_count
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