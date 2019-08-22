import '@babel/polyfill'
import Vue from 'vue';
import App from './components/app.vue'
import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.use( CKEditor );



// Components
import CartIcon from './components/CartIcon.vue'
import PackageList from './components/PackageList.vue'
import TripAvailabilityForm from './components/TripAvailabilityForm.vue'
import SeatPlanSelection from './components/SeatPlanSelection.vue'
import VanSeatMap from './components/VanSeatMap.vue'
import CreatePackageForm from './components/CreatePackageForm.vue'
import BookSummary from './components/BookSummary.vue'
import FinalSummary from './components/FinalSummary.vue'
import ShoppingCart from './components/ShoppingCart.vue'
import BookATrip from './components/BookATrip.vue'
import ScheduleForm from './components/ScheduleForm.vue'
import VanGallery from './components/VanGallery.vue'
import CreateVanForm from './components/CreateVanForm'
import CreateVanRateForm from './components/CreateVanRateForm'
import VanRentForm from './components/VanRentForm'
import SelectedPackageForm from './components/SelectedPackageForm'
import FeaturedPackage from './components/FeaturedPackage'
import ContactForm from './components/ContactForm'
import CreateSliderForm from './components/CreateSliderForm'
import TestimonialForm from './components/TestimonialForm'
import FilterTours from './components/FilterTours'


// Vuex
import { store } from './stores/store'



Vue.config.productionTip = false

Vue.mixin({
    filters: {
        formatNum: (value) => {

          if(isNaN(value)){ return "N/A" }
          if(typeof value == "string"){ value = parseInt(value,10) }
          return value.toLocaleString(undefined,{
             minimumFractionDigits: 2,
          })
          
        }
      }
})

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
        'final-summary': FinalSummary,
        'shopping-cart': ShoppingCart,
        'book-a-trip' : BookATrip,
        'schedule-form': ScheduleForm,
        'van-gallery': VanGallery,
        'create-van-form': CreateVanForm,
        'create-van-rate-form': CreateVanRateForm,
        'van-rent-form': VanRentForm,
        'selected-package-form': SelectedPackageForm,
        'featured-package': FeaturedPackage,
        'contact-form': ContactForm,
        'create-slider-form': CreateSliderForm,
        'testimonial-form': TestimonialForm,
        'filter-tours': FilterTours
    }   
})






