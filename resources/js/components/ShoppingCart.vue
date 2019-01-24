<template>
    <div>
        <div class="item" :key="index" v-for="(item,index) in shopping_cart">
            <button type="button" @click="removeItem(index)" class="btn btn-danger">X</button>
            <article class="hldr"> 
                <h2> Item {{ index + 1 }}</h2>
                <ul class="pad-0 listn">
                    <li>
                        <div class="parent">
                            <div class="children">
                                <label for="destination_from">Origin</label>
                            </div>
                            <div class="children" >
                                    {{ item.selected.origin.name }}
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="parent">
                            <div class="children">
                                <label for="destination_from">Destination</label>
                            </div>
                            <div class="children" >
                                    {{ item.selected.destination.name }}
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="parent">
                            <div class="children">
                                <label for="destination_from">From</label>
                            </div>
                            <div class="children" >
                                    {{ item.selected.from }}
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="parent">
                            <div class="children">
                                <label for="destination_from">From</label>
                            </div>
                            <div class="children" >
                                    {{ item.selected.to }}
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="parent">
                                <div v-for="(seat,i) in item.selected_seats" :key="i" style="border: 1px solid black">
                                    Seat {{ seat.seatnum }} <br>
                                    Name {{ seat.name }}
                                </div>
                        </div>
                    </li>
                
                
                </ul>
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