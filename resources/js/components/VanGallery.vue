<template>
  <div>
    <h4 v-if="(this.existing.length + this.van_gallery.length) > 0">Images:</h4>
    <div v-for="(uploaded,ix) in existing" :key="ix">
      <button type="button" @click="removeExisting(ix,uploaded.id)" class="btn btn-danger">X</button>
      <img :src="`${van_gallery_url}/${uploaded.van_id}_${uploaded.image_name}`" height="250" width="250">
    </div>
      <div v-for="(gallery,index) in van_gallery"  :key="index" >
        <div v-if="gallery.uploadReady">
            <button type="button" @click="remove(index)" class="btn btn-danger">X</button>
              <input @change="uploadImage(index,$event)" :ref="`file_${index}`" type="file" :name="`van_gallery[]`" >
            <img v-if="gallery.preview_image != ''" :src="gallery.preview_image" height="250" width="250">
        </div>

        </div>
      <button type="button" @click="addImage" class="btn btn-default">Add Image</button>
      <div v-for="r in remove_list" >
        <input type="hidden" name="remove_images[]" :value="r">
      </div>
  </div>
</template>


<script>
export default {
  props: {
    van_gallery_data: {
      type: Array,
      default: () => []
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
  data() {
    return {

      van_gallery: this.van_gallery_data,
      existing: this.van_gallery_existing,
      remove_list: []

    };
  },
  methods: {
    addImage() {
      this.van_gallery.push({
        image: "",
        uploadReady: true,
        preview_image: ""
      });
    },
    uploadImage(index,e){
      this.van_gallery[index].image = e.target.value
        let file_elem = e.target;
        let reader = new FileReader();
        reader.onload = (e) => {
          this.van_gallery[index].preview_image = e.target.result;
        }

        reader.readAsDataURL(file_elem.files[0]);
    },
    remove(index){
        this.van_gallery[index].uploadReady = false
        // this.van_gallery = this.van_gallery.filter(v => v.uploadReady == true)
        // this.$refs[`file_${index}`][0].value = ''
        // this.van_gallery.splice(index,1)
        // this.van_gallery[index].image = ""
        // this.$refs[`file_${index}`].
    },
    removeExisting(index,id){
      // console.log({index,id})
      this.remove_list.push(id)
      this.existing.splice(index,1)
    }
  },
  computed: {
    img_count(){
      return this.existing.length + this.van_gallery.filter(v => v.uploadReady != false && v.image != '').length
    }
  },
  watch: {
    img_count(newV){
      this.$emit('updateimagecounter',newV)
    }
  }
};
</script>

<style scoped>
</style>