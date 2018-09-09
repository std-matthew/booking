import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {

        booking: {
            namespaced: true,
            state: {
                date: null,
                location: {},
                type: {},
                time: {},
                quantity: 1,
                events: [],
            },

            mutations: {
                setDate(state, value) {
                    state.date = value;
                },

                setEvents(state, value) {
                    state.events = value;
                },

                setLocation(state, value) {
                    state.location = value;
                },

                setType(state, value) {
                    state.type = value;
                },

                setTime(state, value) {
                    state.time = value;
                },

                setQuantity(state, value) {
                    state.quantity = value;
                },
            }
        },
    }
});
