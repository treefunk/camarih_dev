import axios from 'axios'


export const package_common = {
    props: ['main_image_url'],
    methods: {
        addToCart: function() {
            this.loading = true;

            // if(this.adult_count < this.package_.package_details.minimum_count){
            //   this.adult_count = this.package_.package_details.minimum_count
            // }

            let new_item = Object.assign({},this.package_,{ adult_count: this.adult_count })
            

            axios.post(this.add_to_cart_url,new_item).then(res => {
              let response = res.data
              this.$store.dispatch('showToastr',{
                 message:response.message,
                 type:"success",
                 button: this.$refs['addButton']
              })
              this.$store.commit('incrementCartNum');
              this.loading = false;
            })
          } 
    },
    watch: {
        adult_count(newV){
          let min_count = this.package_.package_details.minimum_count
          if(parseInt(newV,10) < parseInt(min_count,10) || newV.trim() == ""){
            this.$store.dispatch("showToastr", { message: `Minimum count of person for this package is ${min_count}`,type: "error"})
            this.adult_count = min_count
          }
        }
    },
    computed: {
      main_image(){
        if(this.package_.package_image != null){
          return `${this.main_image_url}/${this.package_.package_image.id}_${this.package_.package_image.image_name}`
        }else{
          return  this.package_.image_path
        }
      }
    }
}