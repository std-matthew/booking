<template>
	<div>
		<div class="modal fade" :id="id" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content" :class="bgType">
					<div class="modal-header">
						<h5 class="modal-title">
							<i class="fa" :class="type"></i>
							{{ title }}
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<ul v-show="typeof errors === 'object'">
							<template v-for="error in errors">
								<li v-for="message in error">{{ message }}</li>
							</template>
						</ul>
						<p v-show="typeof errors === 'string'">{{ errors }}</p>
					</div>
					<!-- <div class="modal-footer"> -->
						<!-- <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button> -->
						<!-- <button type="button" class="btn btn-primary btn-sm">Save changes</button> -->
					<!-- </div> -->
				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">

	import { ebi } from '../EventBus.js';

	export default {
		props: [
		'id',
		],

		data() {
			return {
				title: null,
				type: 'info-circle',
				bgType: 'bg-default',

				errors: [],

				hasErrors: false,
			}
		},

		mounted() {
			ebi.$on('showModal', (data) => {
				this.setup(data);
			});
		},

		methods: {

			setup(data) {
				this.title = data.title ? data.title : 'Alert Message';
				this.errors = data.content ? data.content : 'Please try again later.';
				this.hasErrors = data.hasErrors;
				this.redirectUrl = data.redirectUrl;

				switch (data.type) {
					case 'success': case 1: case true:
							this.type = 'fa-check';
							this.bgType = 'bg-primary text-white';
						break;
					case 'danger': case 0: case false: case 'error':
							this.type = 'fa-warning';
							this.bgType = 'bg-danger text-white';
						break;
					default:
							this.type = 'fa-info-circle';
							this.bgType = 'bg-default text-dark';
						break;
				}

				if (typeof data.content === 'object') {
					this.type = 'fa-warning';
					this.hasErrors = true;
				}

				this.show();
			},

			show(errors) {
				$('#' + this.id).modal('show');

				$('#' + this.id).on('hidden.bs.modal', () => {

					if (this.redirectUrl) {
						window.location.href = this.redirectUrl;
					}
				    
				});
			}

		},
	}
</script>