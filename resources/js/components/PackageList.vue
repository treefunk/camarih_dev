<template>
    <div >
        <single-package 
        v-for="(singlepackage,index) in package_formatted" :item="singlepackage" 
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
            default_image_url: String,
            featured_mode: {
                type: Boolean,
                default: false
            }
        },
        computed: {
            package_formatted(){
                let newPackages = []
                newPackages = this.packages.map((v) => {

                    v.package_details = {}
                    v.package_details['description'] = v.package_detail_description
                    v.package_details['id'] = v.package_detail_id
                    v.package_details['minimum_count'] = v.package_detail_minimum_count

                    v.package_image = {}
                    if(v.package_image_name != null){
                        v.package_image['id'] = v.package_image_id
                        v.package_image['image_name'] = v.package_image_name
                        v.package_image['image_title'] = v.package_image_title
                    }else{
                        v.image_path = this.default_image_url
                        v.package_image = null
                    }

                    return v
                })
                return newPackages
            }
        }
    }
</script>

<style scoped>

</style>