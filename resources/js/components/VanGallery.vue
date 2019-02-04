<template>
  <div>
      <div v-for="(gallery,index) in van_gallery" :key="index" >
            <button type="button" @click="remove(index)" class="btn btn-danger">X</button>
        <input type="file" name="file[index]" id>
      </div>
        <button type="button" @click="addImage" class="btn btn-default">Add Image</button>
  </div>
</template>

<script>
export default {
  props: {
    van_gallery_data: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      van_gallery: this.van_gallery_data
    };
  },
  methods: {
    addImage() {
      this.van_gallery.push({});
    },
    remove(index){
        alert(index)
        this.van_gallery.splice(index,1)
    }
  }
};
</script>

<style scoped>
</style>