<template>
    <div >
        <single-package 
        v-for="(singlepackage,index) in packages" :item="singlepackage" 
        :key="index" 
        :index="index"
        :single_url="single_url"
        :add_to_cart_url="add_to_cart_url"
        :main_image_url="main_image_url"
        >
        </single-package>
    </div>
</template>

<script>

    import SinglePackage from './SinglePackage.vue'


    export default {
        components : {
            'single-package' : SinglePackage
        },
        props: {
            packages: Array,
            single_url: String,
            main_image_url: String,
            add_to_cart_url: String,
            featured_mode: {
                type: Boolean,
                default: false
            }
        }
    }
</script>

<style scoped>

</style>