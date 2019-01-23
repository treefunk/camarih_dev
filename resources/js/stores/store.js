import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        packages: [],
        currentSeats: 0,
        currentPackageRate: 1,
    },
    getters: {
        currentSeatsLength: (state) => state.currentSeats,
        currentPackageRate: (state) => state.currentPackageRate
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
        }
    }
})