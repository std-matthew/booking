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

		ebi.$on('fetchEvents', () => {
			this.fetchEvents();
			this.setLoading(true);

			setTimeout(() => {
				this.init();
				this.setLoading(false);
			}, 1000);
		});
	},

	methods: {
		setup() {
			this.calendar = $('#' + this.id);
			this.calendarDay = $('.fc-day');

			if (!this.date) {
				this.date = moment().format('YYYY-MM-DD');
				this.$store.commit('booking/setDate', this.date);
				this.$store.commit('booking/setCalendarDate', this.date);
			}
		},


		init() {
			setTimeout(() => {
				this.calendar.fullCalendar(this.settings());
				this.calendar.fullCalendar('gotoDate', this.$store.state.booking.calendar_date);
			}, 500);
		},

		/**
		 * @Methods
		 */
		fetchEvents() {

			this.setLoading(true);

			axios.post(route('fetch.events'), {
				calendar_date: this.$store.state.booking.calendar_date,
				booking_location_id: this.$store.state.booking.location.id,
			})
			.then(response => {
				const data = response.data;

				this.$store.commit('booking/setEvents', data.events);
				this.events = data.events;
				this.calendar.fullCalendar('destroy');
				this.setLoading(false);

			}).catch(error => {
				this.setLoading(false);
			});
		},

		check(date, dateDom) {

			if (this.loading) return;

			this.setLoading(true);
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

				this.setLoading(false);
                
			}).catch(error => {
				this.setLoading(false);
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
							$this.changeMonth();
						}
					},

					customNext: {
						text: 'Next',
						click() {
							$this.calendar.fullCalendar('next');
							$this.changeMonth();
						}
					},
				},

    			dayClick(date, jsEvent, view) {
    				$this.check(date, $(this));
    			},
			}
		},

		changeMonth() {
			const date = this.calendar.fullCalendar('getDate').format('YYYY-MM-DD');
			this.$store.commit('booking/setCalendarDate', date);

			ebi.$emit('fetchEvents');
		},
	},

}
</script>