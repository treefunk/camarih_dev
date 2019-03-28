<template>
        <div class="btm_sec">
        <span class="text-center" style="margin-top:30px">
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
                <input type="number" v-model="adult_count" :min="package_data.package_details.minimum_count">
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
        </ul>
    </div>
</template>


<script>
    import axios from 'axios'
    import { package_common } from './../mixins/package_common'

    export default {
        mixins: [ package_common ],
        props: {
            package_data: Object,
            add_to_cart_url: String
        },
        data(){
            return {
                package_ : this.package_data,
                adult_count: parseInt(this.package_data.package_details.minimum_count,10),
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