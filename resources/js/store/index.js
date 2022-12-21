import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";

const store = createStore({
    state: {
        //define variables
        user: 'null',
        token: 'null'
    },
    mutations: {
        //update variables
        UPDATE_USER(state, payload) {
            state.user = payload.data
            state.token = payload.token
        }
    },
    actions: {
        //actions to be performed
        setUser(contex, payload) {
            contex.commit('UPDATE_USER', payload)
        }
    },
    getters: {
        // get state variable value
        getUser: function (state) {
            return state.user
        },
        getToken: function (state) {
            return state.token
        }
    },

    plugins: [createPersistedState()],
})

export default store;
