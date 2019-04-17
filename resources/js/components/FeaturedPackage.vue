<template>
    <div>
<article class="pckage_wrap clearfix">
              <aside>
                <img :src="main_image">
              </aside>

              <article>
                <h4>Tour Package</h4>

                <div>
                    
                  <ul class="pad-0 listn">
                      <li>
                        <h3>{{ package_.name }}</h3>
                      </li>
                      <li v-html="package_.description">
                        <!-- <h5>Hotel + Tours + transfers</h5> -->
                      </li>
                      <li>
                        <h4>Php {{ package_.rate | formatNum }} <span>per person</span></h4>
                      </li>
                      <li>
                          <br>
                          <h6>Minimum Count: {{ package_.package_details.minimum_count }}</h6>
                        </li>
                      <li>
                        <h6>Adults</h6>
                        <input type="number" v-model="adult_count" :min="package_data.package_details.minimum_count">
                      </li>
                  </ul>
                  <aside>
                       <!-- <div class="text-center" style="margin-top:30px">
                            <p :style="{ color: message_class }" :class="['msg-style']" v-if="message">{{ message }}</p>
                            <div class="loading-dual" v-if="loading"></div>
                        </div> -->
                    <ul class="pad-0 listn">
                      <li>
                        <a :href="`${this.single_url}/${package_.id}`">View Details</a>
                      </li>
                      <li>
                        <a ref="addButton" href="" @click.prevent="addToCart">Add to cart</a>
                      </li>
                    </ul>
                  </aside>

                </div>

              </article>

              <div class="view_all">
                <a :href="view_all_url">View All Packages</a>
              </div>
            </article>
    </div>
</template>

<script>
    import { package_common } from './../mixins/package_common'

    export default {
        mixins: [ package_common ],
        props: {
            package_data: Object,
            add_to_cart_url: String,
            single_url: String,
            view_all_url: String
        },
        data(){
            return {
                package_ : this.package_data,
                adult_count: parseInt(this.package_data.package_details.minimum_count,10),
                modal_container: "",
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