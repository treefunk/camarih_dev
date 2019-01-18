import { mapGetters } from 'vuex'
export const mixin = {
    computed: {
        ...mapGetters({
          currentQuestion: 'getCurrentQuestion',
        })
    }
}