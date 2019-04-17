<template>
    <form role="form" :action="form_url" method="POST" enctype="multipart/form-data" @submit.prevent="validateData">
        <div class="form-group">
				<label for="is_featured">Featured? </label>
				<input type="checkbox" name="is_featured" v-model="is_featured" id="">
				<p style="color:red; font-size: 80%;">NOTE: only 1 featured slider is allowed</p>
			</div>
        
        <div class="form-group">
            <label for="image_name">Image</label>
            <img v-if="image_preview" :src="image_preview" class="img-responsive" alt="Image">
            <input name="image_name" type="file" id="image_name" @change="uploadImage">
            <!-- <p class="help-block">Example block-level help text here.</p> -->
        </div>
        <div class="form-group">
            <label for="header">Header</label>
            <input type="text" name="header" class="form-control" id="header" v-model="header"
                placeholder="Enter Header">
        </div>
        <div class="form-group">
            <label for="sub_header">Sub Header</label>
            <input type="text" name="sub_header" class="form-control" id="sub_header" v-model="sub_header"
                placeholder="Enter Sub Header">
        </div>

        <div class="form-group">
            <label for="button_text_first">First Button Text</label>
            <input type="text" name="button_text_first" class="form-control" v-model="button_text_first"
                id="button_text_first">
        </div>

        <div class="form-group" v-show="button_text_first.trim() != ''">
            <label for="button_link_first">First Button Link</label>
            <input type="text" name="button_link_first" class="form-control" v-model="button_link_first"
                id="button_link_first">
        </div>

        <div class="form-group" v-show="button_text_first.trim() != ''">
            <label for="button_text_second">Second Button Text</label>
            <input type="text" name="button_text_second" class="form-control" v-model="button_text_second"
                id="button_text_second">
        </div>

        <div class="form-group" v-show="button_text_second.trim() != ''">
            <label for="button_link_second">Second Button Link</label>
            <input type="text" name="button_link_second" class="form-control" v-model="button_link_second"
                id="button_link_second">
        </div>

        <button type="submit" class="btn btn-info">Submit</button>
    </form>
</template>

<script>
    export default {
        props: {
            form_url: String,
            init_header: String,
            init_sub_header: String,
            init_button_text_first: String,
            init_button_link_first: String,
            init_button_text_second: String,
            init_button_link_second: String,
            init_is_featured: String,
            image_preview: {
                type: String,
                default: ""
            }
        },
        data(){
            return {
                header: this.init_header,
                sub_header: this.init_sub_header,
                button_text_first: this.init_button_text_first,
                button_link_first: this.init_button_link_first,
                button_text_second: this.init_button_text_second,
                button_link_second: this.init_button_link_second,
                is_featured: this.init_is_featured,
                image_data: ""
            }
        },
        methods: {
            validateData(e){
                let form = e.target

                if(this.image_preview == "" && this.image_data == ""){
                    this.$store.dispatch('showToastr', { type: "error" , message: "Please upload an image."})
                    return -1;
                }
                if(this.header.trim() == ""){
                    this.$store.dispatch('showToastr', { type: "error" , message: "Please enter a header."})
                    return -1;
                }

                if(this.button_text_first.trim() != "" && this.button_link_first.trim() == ""){
                    this.$store.dispatch('showToastr', { type: "error" , message: "Please input a link for the first button."})
                    return -1;
                }

                if(this.button_text_second.trim() != "" && this.button_link_second.trim() == ""){
                    this.$store.dispatch('showToastr', { type: "error" , message: "Please input a link for the second button."})
                    return -1;
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