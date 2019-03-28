<template>
        <i class="fa fa-shopping-cart" aria-hidden="true">
            <div class="qntity">
                <span>{{ cartNum }}</span>
            </div>
        </i>
</template>

<script>
    export default {
        mounted(){
            this.$store.commit("updateCartNum",{ num: this.shopping_cart_num_data } );
        },
        props: {
            shopping_cart_data: {
                type: Array,
                default: () => []
            },
            shopping_cart_num_data: {
                type: Number,
                default: 0
            }
        },
        data(){
            return {
                shopping_cart: this.shopping_cart_data || [],
                shopping_cart_num: this.shopping_cart_num_data
            }
        },
        computed: {
            cartNum(){
                return this.$store.getters.getShoppingCartNum
            }
        }
    }
</script>

<style scoped>

</style>