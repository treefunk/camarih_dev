import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

//notification


import toastr_options from './toastr_options'

export const store = new Vuex.Store({
    state: {
        packages: [],
        currentSeats: 0,
        currentPackageRate: 1,
        shoppingCartNum: 0
    },
    getters: {
        currentSeatsLength: (state) => state.currentSeats,
        currentPackageRate: (state) => state.currentPackageRate,
        getShoppingCartNum: (state) => state.shoppingCartNum
    },
    mutations : {
        updateCurrentSeats: (state, payload) => {
            state.currentSeats = payload.seatsLength
        },
        addPackageToCart: (state,payload) => {
            state.packages.push(payload.item)
        },
        updatePackageRate: (state,payload) => {
            state.currentPackageRate = payload.package_rate;
        },
        updateCartNum: (state,payload) => {
            state.shoppingCartNum = payload.num
        },
        incrementCartNum: (state) => {
            state.shoppingCartNum++
        },
        decrementCartNum: (state) => {
            state.shoppingCartNum--
        } 
    },
    actions: {
        showToastr(state,payload){
            toastr.options = toastr_options
            toastr[payload.type]("", payload.message)
        }
    }
})