<template>
    <div>
        <div class="item">
    <article class="hldr">
        <ul class="pad-0 listn">

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
            final_price: {
                type: Number
            }
        }
        
    }
</script>

<style scoped>

</style>