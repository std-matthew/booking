<template>
	<div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group col-sm-3 mx-auto my-3">
					<select @change="select()" v-model="locationId"
						class="form-control">
						<option value="" hidden selected>Please select a Location</option>
						
						<template v-for="location in locations">

							<option :value="location.id">{{ location.name }}</option>
							
						</template>
					</select>
				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">

import { ebi } from '../EventBus.js';

export default {

	data() {
		return {
			locations: [],

			locationId: '',
		}
	},

	mounted() {
		this.init();
	},

	methods: {
		setup() {
			if (!this.locationId) {
				this.locationId = this.locations[0].id;
				this.select();
			}
		},

		init() {
			this.fetch();
		},

		select() {
			this.$store.commit('booking/setLocation', this.locations.filter(obj => {return obj.id === this.locationId})[0]);
			ebi.$emit('fetchEvents');
		},

		fetch() {

			this.setLoading(true);
			
			axios.post(route('fetch.locations'))
			.then(response => {
				this.locations = response.data.lists;
				this.setup();
				this.setLoading(false);
			}).catch(error => {
				this.setLoading(false);
			});
		},
	}
}
</script>