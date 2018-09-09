<template>
	<div>
		<div class="row">
			<div class="form-group col-sm-3 m-auto text-center">
				<label class="font-weight-bold">Quantity</label>
				<input @change="set()" v-model="quantity" min="1" :max="available_slots" 
					type="number" class="form-control" placeholder="Quantity">
			</div>
		</div>

		<transition name="fade">
			<div class="row" v-show="price > 0">
				<div class="col-sm-3 mx-auto mt-3 text-center">
					<p class="font-weight-bold">Total</p>
					<p>PHP {{ formatMoney(price) }}</p>
				</div>
			</div>
		</transition>

		<div class="py-3">

			<ul class="list-group">

				<template v-for="item in lists" v-if="lists.length > 0">

					<li @click="select(item.id)" :class="item.id === itemId ? 'active' : ''"
						class="btn list-group-item list-group-item-action flex-column align-items-start">
						<div class="d-flex w-100 justify-content-between">
							<h5 class="mb-1 font-weight-bold">{{ item.start_time }} - {{ item.end_time }}</h5>
							<small>Slot: <span class="font-weight-bold">{{ item.available_slots }}</span></small>
						</div>
					</li>

				</template>

			</ul>

		</div>
	</div>
</template>

<script type="text/javascript">
export default {
	data() {
		return {
			lists: [],

			itemId: null,

			quantity: 0,
		}
	},

	computed: {
		price() {
			let price = 0;
			let bookingPrice = this.$store.state.booking.type.price;

			if (bookingPrice > 0) {
				price = this.$store.state.booking.type.price * this.quantity;
			}

			return price;
		},

		available_slots() {
			return this.$store.state.booking.time.available_slots;
		},
	},

	mounted() {

	},

	methods: {
		setup() {
			if (!this.itemId) {
				this.select(this.lists[0].id);
			}

			if (!this.quantity) {
				this.quantity = 1;
				this.set();
			}
		},

		init() {
			this.fetch();
		},

		select(id) {
			this.itemId = id;
			this.$store.commit('booking/setTime', this.lists.filter(obj => { return obj.id === id })[0]);
		},

		set() {
			if (this.quantity > this.$store.state.booking.time.available_slots) {
				this.quantity = this.$store.state.booking.time.available_slots;
			}

			if (this.quantity < 1) {
				this.quantity = 1;
			}

			this.$store.commit('booking/setQuantity', this.quantity);
		},

		fetch() {
			this.setLoading(true);

			axios.post(route('fetch.times'), this.postData())
			.then(response => {
				this.lists = response.data.lists;
				this.setup();
				this.setLoading(false);
			}).catch(error => {
				this.setLoading(false);
			});
		},
	}
}
</script>