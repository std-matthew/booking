<template>
	<div>
		<template v-for="item in lists" v-if="lists.length > 0">

			<div class="py-3">
				<div class="text-center">
					<h3 class="font-weight-bold">{{ item.name }}</h3>
				</div>

				<ul class="list-group">

					<template v-for="type in item.types">

						<li @click="select(type.id, item.id)" :class="type.id === typeId ? 'active' : ''"
							class="btn list-group-item list-group-item-action flex-column align-items-start">
							<div class="d-flex w-100 justify-content-between">
								<h5 class="mb-1">{{ type.name }}</h5>
								<small class="font-weight-bold">PHP {{ type.price }}</small>
							</div>
							<p class="mb-1">{{ type.description }}</p>
						</li>

					</template>

				</ul>
			</div>

		</template>

	</div>
</template>

<script type="text/javascript">
export default {
	data() {
		return {
			lists: [],

			typeId: null,
		}
	},

	computed: {
		
	},

	mounted() {

	},

	methods: {

		setup() {
			if (!this.typeId) {
				let type = this.lists[0].types[0];
				this.typeId = type.id;
				this.$store.commit('booking/setType', type);
			}
		},

		init() {
			this.fetch();
		},

		/**
		 * Methods
		 */
		
		select(typeId, categoryId) {
			let types, type;
			this.typeId = typeId;

			types = this.lists.filter(obj => { return obj.id === categoryId})[0].types;
			type = types.filter(obj => { return obj.id === typeId})[0];

			this.$store.commit('booking/setType', type);
		},

		/**
		 * Getters
		 */

		fetch() {
			
			this.setLoading(true);

			axios.post(route('fetch.categories'), this.postData())
			.then(response => {
				this.lists = response.data.lists;
				this.setup();
				this.setLoading(false);
			}).catch(error => {
				this.setLoading(false);
			});

		},
	},
}
</script>