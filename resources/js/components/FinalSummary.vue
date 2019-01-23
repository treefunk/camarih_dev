<template>
    <div>
        <div class="item">
    <article class="hldr">
        <ul class="pad-0 listn">
            <li>
                <div class="parent">
                    <div class="children">
                        <label for="destination_from">Origin:</label>
                    </div>
                    <div class="children">
                        <p>
                            {{ selected_data.origin.name }}
                        </p>
                    </div>
                </div>
            </li>
            <li>
                <div class="parent">
                    <div class="children">
                        <label for="departure_to">Destination:</label>
                    </div>
                    <div class="children">
                        <p>
                            {{ selected_data.destination.name }}
                        </p>
                    </div>
                </div>
            </li>
            <li>
                <div class="parent">
                    <div class="children">
                        <label for="departure_from">From:</label>
                    </div>
                    <div class="children">
                        <p>
                            {{ selected_data.from }}
                        </p>
                    </div>
                </div>
            </li>
            <li>
                <div class="parent">
                    <div class="children">
                        <label for="departure_to">To:</label>
                    </div>
                    <div class="children">
                        <p>
                            {{ selected_data.to }}
                        </p>
                    </div>
                </div>
            </li>
            <li>
                <div class="parent">
                    <div class="children"><label for="rate">Rate:</label></div>
                </div>
                <div class="children">
                   <p>{{ final_price }}</p>
                </div>
            </li>
        </ul>
    </article>
</div>
    </div>
</template>

<script>
    export default {
        props: {
            selected_data:{
                type: Object
            },
            selected_seats_data: {
                type: Array
            },
            selected_package_data: {
                type: Object
            },
            final_price: {
                type: Number
            }
        }
        
    }
</script>

<style scoped>

</style>