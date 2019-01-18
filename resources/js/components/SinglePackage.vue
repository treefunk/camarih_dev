<template>
    <div>
        <section class="sec-3 clearfix">
            <article class="pckage_wrap clearfix">

              <div class="clearfix">
                <aside class="left">
                  <img :src="item.image_path">
                </aside>

                <article class="right">
                  <div>
                    <ul class="pad-0 listn">
                        <li>
                          <h3>{{ item.name }}</h3>
                        </li>
                        <li>
                          <h5>{{ item.package_details.description }}</h5>
                        </li>
                        <li>
                          <h4>Php {{ item.price }} <span>per person</span></h4>
                        </li>
                        <li>
                          <h6>Adults</h6>
                          <input type="number" v-model="adult_count">
                        </li>
                    </ul>
                    <aside>
                      <ul class="pad-0 listn">
                        <li>
                          <a href="">View Details</a>
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
    export default {
        data(){
            return {
                adult_count: 0
            }
        },
        props: [ 'item' ],
        methods: {
            addToCart: function() {

                let new_item = Object.assign({},this.item,{ adult_count: this.adult_count })
                this.$store.commit('addPackageToCart',{ item: new_item })
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

</style>