import moment from 'moment';
export const cart_item = {
    methods: {
        remove(){
            this.$emit('removeMe',this.index)
        }
    },
    filters: {
        formatDate: (value) => {
          if (value) {
              return moment(String(value)).format('MMMM D, YYYY')
          }
        }
    },
    watch: {
        checked(newV){
            this.$emit('addcheckout',Object.assign({},this.$data,{total:this.total}))
        }
    },
}