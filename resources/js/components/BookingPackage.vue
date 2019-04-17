<template>
<div>
    <div class="top clearfix">
        <div class="left">

            <div class="input-hldr">
                <input type="checkbox" v-model="checked">
                <span class="uncheck"></span>
            </div>

            <h4>Item #: {{ booking_num }}</h4>

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
                        <p>Package Name</p>
                    </div>
                    <div class="children">
                        <p>{{ package_.name }}</p>
                    </div>
                </div>
            </li>
            <li>
                <div class="parent">
                    <div class="children">
                        <p>Adult Count</p>
                    </div>
                    <div class="children">
                        <p>{{ package_.adult_count }}</p>
                    </div>
                </div>
            </li>
            <li>
                <div class="parent">
                    <div class="children">
                        <p>Rate</p>
                    </div>
                    <div class="children">
                        <p>{{ package_.rate | formatNum }}</p>
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
import { cart_item } from './../mixins/cart_item'
    export default {
        mixins: [ cart_item ],
        props: {
            package_data: Object
        },
        mounted(){
            this.checked = true;
        },
        data(){
            return {
                booking_num: this.package_data.booking_num,
                package_: this.package_data, // package is reserved word
                checked: false,
                item_type: "booking_package"
            }
        },
        computed: {
            total(){
                return this.package_.adult_count * this.package_.rate
            }
        }
    }
</script>

<style scoped>

</style>