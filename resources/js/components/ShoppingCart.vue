<template>
    <div>
        <div class="item" :key="index" v-for="(item,index) in shopping_cart">
            <button type="button" @click="removeItem(index)" class="btn btn-danger">X</button>

            <article class="hldr">
                <h2> Item {{ index + 1 }}</h2>
                <li>
                    Departure date: {{ item.check_availability.departure_from }}
                    <br>
                </li>
                <li v-if="item.check_availability.departure_to != undefined">
                    Return Date: {{ item.check_availability.departure_to  }}
                </li>

                Seats

                <div>
                    Departure seatplan
                    <li v-for="(seat,i) in item.selected_seats[0]" :key="i">
                        Seat Number: {{ seat.seatnum }} -- 
                        Name: {{ seat.name }}
                    </li>
                </div>

                <div v-if="item.selected_seats.length == 2">
                    Return seatplan
                    <li v-for="(seat,i) in item.selected_seats[1]" :key="i">
                        Seat Number: {{ seat.seatnum }} -- 
                        Name: {{ seat.name }}
                    </li>
                </div>

            </article>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        props: {
            shopping_cart_data : {
                type: Array,
                default: () => []
            },
            item_remove_url: {
                type: String,
            }
        },
        data() {
            return {
                shopping_cart: this.shopping_cart_data
            }
        },
        methods: {
            removeItem(index) {
                // todo run ajax to delete item in session
                let that = this

                axios({
                    method: 'post',
                    url: this.item_remove_url,
                    data: {
                        index: index
                    }
                }).then(function (response) {
                    // if successfully removed in session splice data in vue
                    that.shopping_cart.splice(index, 1)
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });


            }
        }
    }
</script>

<style scoped>

</style>