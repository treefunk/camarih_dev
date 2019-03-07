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
        },
        formatNum: (value) => {
            if(typeof value == "string"){ value = parseInt(value,10) }
            return value.toLocaleString(undefined,{
               minimumFractionDigits: 2,
            })
        }
    },
    watch: {
        checked(newV){
            this.$emit('addcheckout',Object.assign({},this.$data,{total:this.total}))
        }
    },
}