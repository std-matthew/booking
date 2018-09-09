<template>
	<div>

		<div class="col-sm-5 m-auto">
			
			<div class="card">
				<div class="card-body text-center bg-primary text-white">
					<h4 class="card-title font-weight-bold">Booking Details</h4>
					<p class="card-text">
						<div>Booking Date</div>
						<span class="font-weight-bold">
							{{ bookingDate }}
						</span>
						
						<div>Location</div>
						<span class="font-weight-bold">
							{{ location.name }}
						</span>

						<div>Type</div>
						<span class="font-weight-bold">
							{{ type.name }}
						</span>

						<div>Time</div>
						<span class="font-weight-bold">
							{{ time.start_time }} - {{ time.end_time }}
						</span>

						<div>Price</div>
						<span class="font-weight-bold">
							(PHP {{ type.price }} x {{ quantity }})
							<div>
								PHP {{ formatMoney(type.price * quantity) }}
							</div>
						</span>
					</p>
				</div>
			</div>

		</div>

	</div>
</template>

<script type="text/javascript">
export default {
	computed: {
		bookingDate() {
			return moment(this.$store.state.booking.date ? this.$store.state.booking.date : new Date()).format('MMMM DD, YYYY');
		},

		location() {
			return this.$store.state.booking.location;
		},

		type() {
			return this.$store.state.booking.type;
		},

		time() {
			return this.$store.state.booking.time;
		},

		quantity() {
			return this.$store.state.booking.quantity;
		},
	}
}
</script>