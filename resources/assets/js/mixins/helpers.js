import Vue from 'vue';
import { ebi } from '../EventBus.js';

Vue.mixin({

    data()
    {
        return {

        };
    },

    computed:
    {
        loading() {
            return this.$store.state.settings.loading;
        },
    },

    mounted()
    {
        //
    },

    methods:
    {
        showModal(title = null) {
            ebi.$emit('showModal', {
                title: title,
            })
        },

        showErrors(error) {
            const response = error.response;

            switch (response.status) {
                case 422:
                        ebi.$emit('showModal', {
                            content: response.data.errors,
                            type: 'danger'
                        });
                    break;
                default:
                        ebi.$emit('showModal', {
                            content: 'Oops.. Something went wrong.. Please try again later.',
                            hasErrors: true,
                        });
                    break;
            }
        },

        formatMoney(value) {
            return (value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        },

        postData() {
            return {
                booking_type_id: this.$store.state.booking.type.id,
                booking_location_id: this.$store.state.booking.location.id,
                booking_date: this.$store.state.booking.date,
                booking_time_id: this.$store.state.booking.time.id,
                quantity: this.$store.state.booking.quantity,
            };
        },

        setLoading(boolean) {
            this.$store.commit('settings/setLoading', boolean);
        }
    }
});