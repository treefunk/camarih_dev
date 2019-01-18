<template>
    <div >
        <single-package v-for="(package,index) in packages" :item="package" :key="package.id">
        </single-package>
    </div>
</template>

<script>

    import SinglePackage from './SinglePackage.vue'


    export default {
        components : {
            'single-package' : SinglePackage
        },
        props: [ 'packages' ]
    }
</script>

<style scoped>

</style>