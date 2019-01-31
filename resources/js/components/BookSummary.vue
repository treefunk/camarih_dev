<template>
        <li>
            <div class="item">
                <div>
                    <label for="destination_from">Origin:</label>
                    <p>{{ bookdata.origin.name }}</p>
                </div>
                <div>
                    <label for="departure_to">Destination:</label>
                    <p>{{ bookdata.destination.name }}</p>
                </div>
                <div>
                    <label for="departure_from">Departure Date:</label>
                    <p>{{ bookdata.from }}</p>
                </div>
                <div>
                    <label for="Price">Total</label>
                     <p>PHP {{ pricePerHead }}</p>
                </div>
            </div>
        </li>
</template>

<script>
    export default {
        props: {
            book_data:{
                type: Object
            },
            current_seats_length: {
                type: Number
            },
            package_data: {
                type: Object
            }
        },
        computed: {
            pricePerHead(){
                let currentSeatsLength = this.current_seats_length || this.$store.getters.currentSeatsLength

                let price = currentSeatsLength * this.bookdata.rate_price

                let package_price = this.$store.getters.currentPackageRate == 1 ? 0 : this.$store.getters.currentPackageRate
        
                let package_total_price = currentSeatsLength * package_price


                price += parseInt(package_total_price,10)

                return price;
            }
        },
        data(){
            return {
                bookdata: this.book_data
            }
        }
    }
</script>

<style scoped>

</style>