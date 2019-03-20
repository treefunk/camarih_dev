<template>
    <div >
        <single-package 
        v-for="(singlepackage,index) in packages" :item="singlepackage" 
        :key="index" 
        :index="index"
        :single_url="single_url"
        :add_to_cart_url="add_to_cart_url"
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
            add_to_cart_url: String
        }
    }
</script>

<style scoped>

</style>