<template>
	<div>
		<div class="row">
			<div class="col-sm-12">
				<div :id="id"></div>
				
				<div class="col-sm-12 text-center py-2">
					<h5 class="font-weight-bold">{{ bookingDate }}</h5>
				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">

import { ebi } from '../EventBus.js';

export default {

	props: {
		id: {

		},

		height: {
			type: Number,
			default: 500
		}
	},

	watch: {
		events() {
			this.init();
		}
	},

	computed: {
		bookingDate() {
			return moment(this.date).format('MMMM D, YYYY');
		},
	},

	data() {
		return {
			calendar: null,
			calendarDay: null,

			date: null,

			events: [],
		}
	},

	mounted() {
		this.setup();

		ebi.$on('onFetchEvents', () => {
			this.events = this.$store.state.booking.events;
			setTimeout(() => {
				this.init();
			}, 500);
		});
	},

	methods: {
		setup() {
			this.calendar = $('#' + this.id);
			this.calendarDay = $('.fc-day');

			if (!this.date) {
				this.date = moment().format('YYYY-MM-DD');
				this.$store.commit('booking/setDate', this.date);
			}
		},


		init() {
			this.calendar.fullCalendar(this.settings());
		},

		/**
		 * @Methods
		 */
		check(date, dateDom) {

			const bookingDate = date.format();

			axios.post(route('book.checkdate'), {
				booking_date: bookingDate,
				booking_location_id: this.$store.state.booking.location.id,
			})
			.then(response => {
				const data = response.data;

				if (!data.action) {
					ebi.$emit('showModal', {
	                    content: data.message,
	                    type: data.action,
	                });
				} else {
					this.$store.commit('booking/setDate', date.format());
					this.date = bookingDate;

					$('.fc-day').removeClass('fc-today');
	                dateDom.addClass('fc-today');
				}
                
			}).catch(error => {

			});
		},

		settings() {
			const $this = this;

			return {
				height: this.height,

				showNonCurrentDates: false,

    			header: {
    				left: 'customPrev',
    				center: 'title',
    				right: 'customNext'
    			},

    			buttonText: {
    				today: 'today',
    				month: 'month',
    				week: 'week',
    				day: 'day'
    			},

    			events: this.events,

    			customButtons: {
					customPrev: {
						text: 'Prev',
						click() {
							$this.calendar.fullCalendar('prev');
							console.log($this.calendar.fullCalendar('getDate'));
						}
					},

					customNext: {
						text: 'Next',
						click() {
							$this.calendar.fullCalendar('next');
							console.log($this.calendar.fullCalendar('getDate'));
						}
					},
				},

    			dayClick(date, jsEvent, view) {
    				$this.check(date, $(this));
    			},
			}
		},
	},

}
</script>