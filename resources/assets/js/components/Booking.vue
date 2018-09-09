<template>
	<div>
		<div class="row">
			<div class="col-sm-12 text-center p-3">
				
				<button @click="stepBtn(1, true)" :class="step === 1 ? 'btn-primary' : ''"
					type="button" class="btn btn-sm px-3 mx-2">
					<i class="fa fa-calendar"></i> Date
				</button>
			
				<button @click="stepBtn(2, true)" :class="step === 2 ? 'btn-primary' : ''"
					type="button" class="btn btn-sm px-3 mx-2">
					<i class="fa fa-cubes"></i> Type
				</button>
			
				<button @click="stepBtn(3, true)" :class="step === 3 ? 'btn-primary' : ''"
					type="button" class="btn btn-sm px-3 mx-2">
					<i class="fa fa-clock-o"></i> Time
				</button>
			
				<button @click="stepBtn(4, true)" :class="step === 4 ? 'btn-primary' : ''"
					type="button" class="btn btn-sm px-3 mx-2">
					<i class="fa fa-file-text"></i> Details
				</button>
			
				<button @click="stepBtn(5, true)" :class="step === 5 ? 'btn-primary' : ''"
					type="button" class="btn btn-sm px-3 mx-2">
					<i class="fa fa-credit-card-alt"></i> Checkout
				</button>

			</div>
		</div>
		
		<div>
			<div v-show="step === 1">
				<location></location>

				<calendar 
				:id="'calendar'">
				</calendar>
			</div>

			<div v-show="step === 2">
				<bookingtype ref="bookingtype"
				></bookingtype>
			</div>

			<div v-show="step === 3">
				<bookingtime ref="bookingtime"
				></bookingtime>
			</div>

			<div v-show="step === 4">
				<bookingdetail
				></bookingdetail>
			</div>

			<div v-show="step === 5">
				<bookingcheckout ref="bookingcheckout"
				:id="'bookingcheckout'"></bookingcheckout>
			</div>
		</div>

		<div class="row">

			<div class="col-sm-12 text-center py-4">
				
				<button @click="stepBtn(-1)" :disabled="step < 2"
					type="button" class="btn btn-primary px-3 mx-2">
					<i class="fa fa-arrow-left"></i> Back
				</button>

				<button @click="stepBtn(1)"
					type="button" class="btn btn-primary px-3 mx-2">
					{{ step > 4 ? 'Submit' : 'Next' }} 
					<i v-show="step < 5" class="fa fa-arrow-right"></i>
				</button>

			</div>
		</div>

		<modal ref="modal"
		:id="'modal'">
		</modal>

	</div>
</template>

<script type="text/javascript">

import { ebi } from '../EventBus.js';
import location from './BookingLocation';
import calendar from './Calendar';
import bookingtype from './BookingType';
import bookingtime from './BookingTime';
import bookingdetail from './BookingDetail';
import bookingcheckout from './BookingCheckout';
import modal from './Modal';

export default {

	props: [

	],

	data() {
		return {
			step: 1,
		}
	},

	components: {
		location,
		calendar,
		bookingtype,
		bookingtime,
		bookingdetail,
		modal,
		bookingcheckout,
	},

	mounted() {
		this.setup();
		this.init();

		ebi.$on('fetchEvents', () => {
			this.fetchEvents();
		});
	},

	methods: {
		setup() {

		},

		init() {

		},

		/**
		 * @Methods
		 */

		stepBtn(value, goto = false) {

			let step = this.stepChange(value, goto, false);

			switch (step) {
				case 1:
						this.stepChange(value, goto);
					break;
				case 2:
						axios.post(route('book.location'), this.postData())
						.then(response => {
							this.stepChange(value, goto);
							this.$refs.bookingtype.init();
						}).catch(error => {
							this.showErrors(error);
						});
					break;
				case 3:
						axios.post(route('book.type'), this.postData())
						.then(response => {
							this.stepChange(value, goto);
							this.$refs.bookingtime.init();
						}).catch(error => {
							this.showErrors(error);
						});
					break;
				case 4:
						axios.post(route('book.time'), this.postData())
						.then(response => {
							this.stepChange(value, goto);
						}).catch(error => {
							this.showErrors(error);
						});
					break;
				case 5:
						axios.post(route('invoice_item.store'),  this.postData())
						.then(response => {
							this.stepChange(value, goto);
							this.$refs.bookingcheckout.fetch();
						}).catch(error => {
							this.showErrors(error);
						});
						
					break;
				case 6:
						ebi.$emit('formsubmit');
					break;
				default:

					break;
			}

		},

		stepChange(value, goto = false, changeStep = true) {

			let step = this.step + value;

			if (goto) {
				step = value;
			}

			if (changeStep) {
				this.step = step;
			}

			return step;

		},

		fetchEvents() {

			axios.post(route('fetch.events'), this.postData())
			.then(response => {
				const data = response.data;

				this.$store.commit('booking/setEvents', data.events);

				ebi.$emit('onFetchEvents');
			}).catch(error => {

			});
		},
	},

}
</script>