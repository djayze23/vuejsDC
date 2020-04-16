<template>
	<form action="" class="flex flex-col" @submit.prevent="submitComment">
		<textarea name="" id="" cols="30" rows="10" class="p-4 rounded border border-gray-600" v-model='comment'></textarea>
		<button type="submit" class="px-4 rounded border border-red-500 bg-blue-500">commenter</button>
	</form>
</template>

<script>
	export default{
		data() {
			return{

				comment:  '',

			}
		},
        methods: {

        	submitComment() {

        		axios.post('/comments',{
        			content: this.comment
        		})
        		console.log(this.comment)
        	}
        },

	}

</script>