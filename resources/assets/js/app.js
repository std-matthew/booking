
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import store from './store';
import settings from './settings';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import { ebi } from './EventBus.js'

Vue.component('booking', require('./components/Booking.vue'));


const app = {
	init()
	{
		this.setupVue();
	},

	setupVue()
	{
		new Vue({
		    el: '#app',
		    store,

		    mounted()
            {
                this.init();
            },

            methods:
            {
                init()
                {

                },
            },
		});
	}
}

app.init();