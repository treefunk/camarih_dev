<template>

    <form role="form" :action="form_url" method="POST" enctype="multipart/form-data" @submit.prevent="validateFields">
        <div class="form-group">
            <label for="image_name">Image</label>
            <img v-if="image_preview" :src="image_preview" class="img-responsive" alt="Image">
            <input @change="uploadImage" name="image_name" type="file" id="image_name">
            <!-- <p class="help-block">Example block-level help text here.</p> -->
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" v-model="name"
                placeholder="Enter Name">
        </div>

        <div class="form-group">
            <label for="occupation">Occupation</label>
            <input type="text" name="occupation" class="form-control" v-model="occupation"
                id="occupation">
        </div>

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" v-model="title" id="title">
        </div>

        <div class="form-group">
            <label for="testimonial">Testimonial</label>
            <textarea name="testimonial" class="form-control" id="testimonial" v-model="testimonial" placeholder="Enter Testimonial"
                style="height:inherit" rows="5"></textarea>
        </div>

        <button type="submit" class="btn btn-info">Submit</button>
    </form>

</template>

<script>
    export default {
        props: {
            form_url: String,
            image_preview: {
                type: String,
                default: ""
            },
            init_name:String,
            init_occupation: String,
            init_title: String,
            init_testimonial: String
        },
        data(){
            return {
                name: this.init_name,
                occupation: this.init_occupation,
                title: this.init_title,
                testimonial: this.init_testimonial,
                image_data: ""
            }
        },
        methods: {
            validateFields(e){
                let form = e.target

                if(this.image_preview == "" && this.image_data.trim() == ""){
                       this.$store.dispatch("showToastr",{ 
                        type: "error" ,
                        message: `Please upload an image.`
                       })
                       return -1;
                }

                if(this.name.trim() == ""){
                    this.$store.dispatch("showToastr",{ 
                        type: "error" ,
                        message: `Please enter the name of the reviewer.`
                    })
                    return -1
                }

                if(this.occupation.trim() == ""){
                    this.$store.dispatch("showToastr",{ 
                        type: "error" ,
                        message: `Please enter the occupation of the reviewer.`
                    })
                    return -1
                }

                if(this.title.trim() == ""){
                    this.$store.dispatch("showToastr",{ 
                        type: "error" ,
                        message: `Please enter the title of the review.`
                    })
                    return -1
                }

                if(this.testimonial.trim() == ""){
                    this.$store.dispatch("showToastr",{ 
                        type: "error" ,
                        message: `Please enter the testimony of the reviewer.`
                    })
                    return -1
                }

                form.submit()
            },
            uploadImage(e){
                this.image_data = e.target.value
            }
        }
    }
</script>

<style scoped>

</style>