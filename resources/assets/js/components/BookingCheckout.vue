<template>
	<div>
		<div class="py-3">

			<ul class="list-group">

				<template v-for="item in items" v-if="items.length > 0">

					<li class="list-group-item flex-column align-items-start">
						<div class="d-flex w-100 justify-content-between">
							<h5 class="mb-1 font-weight-bold">{{ item.location.name }} | {{ item.type.name }}</h5>
							<small @click="remove(item.id)" 
								class="btn">
								<i class="fa fa-close"></i>
							</small>
						</div>
						<p>
							Timeslot: <span class="font-weight-bold">{{ item.time.start_time }} - {{ item.time.end_time }}</span>
						</p>
						<p>
							Price: <span class="font-weight-bold">PHP {{ formatMoney(item.price * item.quantity) }} ({{ item.price }} x {{ item.quantity }})</span>
						</p>
					</li>

				</template>

			</ul>

		</div>
		<div>
			<form :id="id" action="#" @submit.prevent="submit()">
				<div class="row">
					<div class="form-group col-sm-6">
						<label class="font-weight-bold">First Name <span class="text-danger">*</span></label>
						<input type="text" name="billing_firstname" class="form-control" placeholder="Please enter your first name" value="John">
					</div>
					<div class="form-group col-sm-6">
						<label class="font-weight-bold">Last Name <span class="text-danger">*</span></label>
						<input type="text" name="billing_lastname" class="form-control" placeholder="Please enter your last name" value="Doe">
					</div>
					<div class="form-group col-sm-12">
						<label class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
						<input type="text" name="billing_email" class="form-control" placeholder="Please enter your email address" value="sample@example.com">
					</div>
					<div class="form-group col-sm-12">
						<label class="font-weight-bold">Remarks <span class="text-black-50">(Optional)</span></label>
						<textarea class="form-control" name="remarks" placeholder="Please enter your remarks here">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fuga est unde quaerat modi odio voluptas blanditiis excepturi non dolorum repellendus officiis, provident eveniet veritatis quam, nulla illum a consequuntur commodi.</textarea>
					</div>
					<div class="col-sm-12 mx-auto">
						<div class="form-check">
							<label class="form-check-label">
								<input class="form-check-input" type="checkbox" value="1" name="terms" checked>
								I've read and agree with the <a href="#">terms and conditions</a>
							</label>
						</div>
					</div>
				</div>
			</form>
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
			invoice: {},
			items: [],

			form: null,
		}
	},

	mounted() {
		this.setup();

		ebi.$on('formsubmit', () => {
			this.submit();
		});
	},

	methods: {
		setup() {
			this.form = $('#' + this.id);
		},

		fetch() {
			this.setLoading(true);

			axios.post(route('fetch.invoice'))
			.then(response => {
				const data = response.data;

				this.invoice = data.invoice;
				this.items = data.items;
				this.setLoading(false);
			}).catch(error => {
				this.setLoading(false);
			});
		},

		remove(id) {
			console.log(id);
			axios.delete(route('invoice_item.destroy', { invoiceItem: id }))
			.then(response => {
				this.fetch();
			}).catch(error => {

			});
		},

		submit() {
			if (this.loading) return;
			
			const data = this.form.serialize();
			this.setLoading(true);

			axios.post(route('invoice.store'), data)
			.then(response => {
				const data = response.data;
				this.fetch();

				ebi.$emit('showModal', {
                    content: data.message,
                    type: data.action,
                    redirectUrl: data.redirectUrl,
                });

                this.setLoading(false);

			}).catch(error => {
				this.showErrors(error);
				this.setLoading(false);
			});
		},
	},
}
</script>