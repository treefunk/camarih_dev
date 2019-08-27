<template>
	<section class="filter-tours">
     <h4>Filter {{service_name}} by </h4>
     <ul :class="{'fdt': is_day_tour == '1', 'fpt' : is_day_tour == '0'}">
       	<li>
         <select name="location" v-model="selected.location">
           <option value="">Location</option>
           <option value="">All Locations</option>
           <option v-for="(destination,index) in destinations"  :key="index" :value="`${destination.id}`">{{ destination.name }}</option>
         </select>
       	</li>
       	<li v-if="is_day_tour != '1'">
            <select name="duration" v-model="selected.duration">
              <option value=""># Nights/Days</option>
              <option value="">All</option>
              <option v-for="(destination,index) in durations"  :key="index" :value="`${destination.id}`">{{ destination.name }}</option>
            </select>
        </li>
        <li v-if="is_day_tour != '1'">
            <select name="pax" v-model="selected.pax">
              <option value=""># Pax</option>
              <option value="">All</option>
              <option v-for="n in 12" :value="n">{{n}} PAX</option>
            </select>
        </li>
        <li>
        	<select name="price_range" v-model="selected.price_range">
        		<option value="">Price Range</option>
        		<option v-for="(price_range,index) in pricing" :key="index" :value="index">{{ price_range }}</option>
        	</select>
        </li>
       	<li><input type="submit" name="" value="FILTER"></li>
     </ul>
   </section>
</template>
<script>
    export default {
        props: {
        	pricing_data: {
                type: Object,
                default:() => { return {
	                0 : "All Prices",
	                1 : "Less than Php 1,000",
	                2 : "Php 1,001 - Php 1,500",
	                3 : "Php 1,501 and Above",
	                }
                }
            },
        	destinations_data: {
                type: Array
            },
            selected_data: {
                type: Object
            },
            durations_data: {
                type: Array
            },
            service_name: String,
            is_day_tour: {
                default: 0
            }
        },
        data(){
            return {
            	destinations: this.destinations_data,
            	selected: this.selected_data,
            	durations: this.durations_data,
            	pricing: this.pricing_data,
            }
        }
    }
</script>
<style scoped>
</style>