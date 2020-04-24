<template>	
	<form action="" class="flex flex-col" @submit.prevent="submitComment">
		<div class="mb-3">
			<h3 class="font-normal text-gray-600 text-sm">Nouveau commentaire</h3>
			<p v-if="respondTo" class="text-gray-600 text-xs">
				En réponse à <span class="font-semibold">{{ respondTo.name}}</span> : {{respondTo.body}}
			<button type="button" @click="$emit('cancel-respond-to')">Annuler</button>
			</p>
		</div>
		<div class="mb-3 ">
			<input type="text" class="w-full border rounded p-3" :class="{'border-red-600': errors.name }" v-model="form.name" placeholder="Pseudo">
			<p class="text-red-600 px-3 py-1" v-if="errors.name" v-text="errors.name[0]"></p>
		</div>
		<div class="mb-3">
			<textarea class="w-full border rounded p-3" :class="{'border-red-600': errors.body }" v-model="form.body" placeholder="Commentaire"></textarea>
			<p class="text-red-600 px-3 py-1" v-if="errors.body" v-text="errors.body[0]"></p>
		</div>
		<button type="submit" class="px-4 py-2 mb-3 rounded border bg-blue-500">commenter</button>
	</form>
</template>

<script>
	export default{
		props: ['respondTo'],

		data() {
			return {
				form: {
					name: '',
					body: '',
					url: window.location.href,
				},
				errors: {},

			} 
		},
		computed: {
			fullForm(){
				if(this.respondTo){
					return {
						...this.form,
						respond_to_id : this.respondTo.id, 
					}
				}
				return this.form
			}

		},

        methods: {

        	submitComment() {
        		axios.post('/comments',this.fullForm)
	        		.then(({data}) => {
	        			this.$emit('newComment', data)
	        			this.form.body = ""
	        			this.errors = {}
	        		})
	        		.catch(error => {
	        			this.errors = error.response.data.errors
	        		})
        	},
        },

	}

</script>