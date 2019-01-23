<template>
    <div>
            <div @click="selectPackage('')" class="col-lg-12 card">
                <div class="card-holder" :class="{'active': (selected_id == '') }" >
                    <div>
                            <h4 style="text-align: center;">
                                <label for="">No package</label>
                            </h4>
                    </div>
                </div>
            </div>
            <div @click="selectPackage(single_package.id,single_package.rate)"  v-for="(single_package,index) in packages" :key="index" class="col-md-12 card">
                <div class="card-holder" :class="{'active': selected_id == single_package.id }">
                    <h4 style="text-align: center;">
                        <label for="">{{ single_package.name }}</label>
                    </h4>
                </div>
            </div>
            <input type="hidden" name="package_id" :value="selected_id">

            <button class="btn" type="submit">Submit</button> 

    </div>
</template>

<script>
    export default {
        props: {
            packages_data: {
                type: Array
            }
        },
        data(){
            return {
                packages: this.packages_data,
                selected_id: ''
            }
        },
        methods: {
            selectPackage(id,rate){
                if(id != 0){
                    this.$store.commit('updatePackageRate',{package_rate: rate})
                }else{
                    this.$store.commit('updatePackageRate',{package_rate: 1})
                }
                this.selected_id = id
            }
        }
        
    }
</script>

<style scoped>
    .active{
        background: #F8AA77
    }
</style>