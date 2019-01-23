<template>
        <i class="fa fa-shopping-cart" aria-hidden="true">
            <div class="qntity">
                <span>{{ shopping_cart.length }}</span>
            </div>
        </i>
</template>

<script>
    export default {
        props: {
            shopping_cart_data: {
                type: Array,
                default: () => []
            }
        },
        data(){
            return {
                shopping_cart: this.shopping_cart_data || []
            }
        }
    }
</script>

<style scoped>

</style>