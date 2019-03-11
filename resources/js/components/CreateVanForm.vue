<template>
    <div>
        <div class="panel-body">
            <form @submit.prevent="validateVanForm" role="form" :action="create_van_url" method="POST" enctype="multipart/form-data">

                <div :class="['form-group',{'has-error': !formNotSubmitted && van.name == ''}]">
                    <label for="header">Name</label>
                    <input type="text" name="name" class="form-control" id="header" v-model="van.name"
                        placeholder="Enter Van Name">
                </div>

                <div :class="['form-group',{'has-error': !formNotSubmitted && van.num_of_vans == ''}]">
                    <label for="num_of_vans">Number of Vans</label>
                    <input type="number" name="num_of_vans" id="" class="form-control" v-model="van.num_of_vans">
                </div>

                <div :class="['form-group',{'has-error': !formNotSubmitted && van.description == ''}]">
                    <label for="header">Description</label>
                    <textarea name="description" v-model="van.description" id="description" class="form-control" rows="3"></textarea>
                </div>

                <div :class="['form-group']">
                    <van-seat-map
                    :seats_data="van_seats_data"
                    >
                    </van-seat-map>
                </div>

                <div :class="['form-group']">
                    <van-gallery
                    :van_gallery_existing="van_gallery_existing"
                    :van_gallery_url="van_gallery_url"
                    @updateimagecounter="updateImageCounter"
                    >

                    </van-gallery>
                </div>



                <button type="submit"  class="btn_orange right_btn">Submit</button>

            </form>

        </div>
    </div>
</template>

<script>
    import VanSeatMap from './VanSeatMap.vue'
    import VanGallery from './VanGallery.vue'
    export default {
        props: {
            create_van_url: String,
            van_data: {
                type: Object,
                default: () => {
                    return {
                        name: "",
                        description: "",
                        num_of_vans: "",
                        van_details: {
                            oneway_rate: "",
                            roundtrip_rate: ""
                        }
                    }
                }
            },
            van_seats_data: {
                type: Array,
                default: () => ['1']
            },
            van_gallery_existing: {
                type: Array,
                default: () => []
            },
            van_gallery_url: {
                type: String,
                default: ""
            }
        },
        data(){
            return {
                van: this.van_data,
                gallery_count: this.van_gallery_existing.length,
                van_seats: this.van_seats_data,
                formNotSubmitted: true,
            }  
        },
        components: {
            'van-seat-map' : VanSeatMap,
            'van-gallery' : VanGallery
        },
        methods: {
            validateVanForm(e){
                this.formNotSubmitted = false;
                console.log(Object.values(this.van))

                if(Object.values(this.van).some(val => {
                    if(typeof val == 'object'){ return false }
                        return val == ""
                }) || this.van_seats.some(v => v == "")){
                    alert("Please fill in all the required fields.")
                    return -1;
                }

                if(this.van_seats.length <= 0){
                    alert('Please add a row for the seat plan.')
                    return -1
                }

                if(this.gallery_count <= 0){
                    alert('at least one image is required')
                    return -1
                }
                e.target.submit();

            },
            updateImageCounter(ctr){
                this.gallery_count = ctr
            }
        }
        
    }
</script>

<style scoped>

</style>