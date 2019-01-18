import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        packages: []
    },
    mutations : {
        addPackageToCart: (state,payload) => {
            state.packages.push(payload.item)
        }
    }
})