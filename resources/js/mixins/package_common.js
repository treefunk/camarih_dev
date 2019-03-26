import axios from 'axios'

export const package_common = {
    methods: {
        addToCart: function() {
            this.loading = true;
            let new_item = Object.assign({},this.package_,{ adult_count: this.adult_count })
            axios.post(this.add_to_cart_url,new_item).then(res => {
              let response = res.data
              console.log(response)
              this.loading = false
              this.message = response.message
              this.message_class = "green"
            })
            this.$store.commit('addPackageToCart',{ item: new_item })
          }
    },
    watch: {
        adult_count(newV){
          let min_count = this.package_.package_details.minimum_count
          if(parseInt(newV,10) < parseInt(min_count,10)){
            alert(`Sorry, minimum count for this package is ${min_count}`)
            this.adult_count = min_count
          }
        }
      }
}