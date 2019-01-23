import Vue from 'vue';
import App from './components/app.vue'


// Components
import CartIcon from './components/CartIcon.vue'
import PackageList from './components/PackageList.vue'
import TripAvailabilityForm from './components/TripAvailabilityForm.vue'
import SeatPlanSelection from './components/SeatPlanSelection.vue'
import VanSeatMap from './components/VanSeatMap.vue'
import CreatePackageForm from './components/CreatePackageForm.vue'
import BookSummary from './components/BookSummary.vue'
import PackageSelection from './components/PackageSelection.vue'
import FinalSummary from './components/FinalSummary.vue'
import ShoppingCart from './components/ShoppingCart.vue'


// Vuex
import { store } from './stores/store'



Vue.config.productionTip = false

new Vue({
    el: ".app",
    store,
    data(){
        return {
            message: 'Hi jhondz'
        }
    },
    components: {
        'app' : App,
        'cart-icon': CartIcon,
        'package-list': PackageList,
        'trip-availability-form': TripAvailabilityForm,
        'seat-plan-selection': SeatPlanSelection,
        'van-seat-map': VanSeatMap,
        'create-package-form': CreatePackageForm,
        'book-summary': BookSummary,
        'package-selection': PackageSelection,
        'final-summary': FinalSummary,
        'shopping-cart': ShoppingCart
    }   
})



