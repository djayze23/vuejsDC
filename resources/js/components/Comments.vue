<template>
	
	<div>
		<div class="border-b pb-4 mb-8">
			<!-- la classe mb-4 va etre fusionnée avec la div de l'élément enfant "comment.vue" -->
				<comment class="mb-4" 
					v-for="comment in comments"	
					:key="comment.id" 
					:comment ="comment" 
					:now ="now" 
					@respond-to ="respondTo = $event" 
					></comment>	
		</div>
		<comment-form 
			@newComment="comments.push($event)" 
			:respond-to="respondTo"
			@cancel-respond-to="respondTo = null"
			></comment-form>
<!-- 		le "@newComment" correspond au données "this.$emit('nexComment', data)" reçues de CommentForm après création d'un commentaire
 -->
	</div>

</template>

<script>

	import CommentForm from './CommentForm.vue' // permet d'inclure le composant uniquement dans ce template en lui donnant son chemin.
	import Comment from './Comment.vue'

	export default {
		//décris à ce composant (comments) qu'il a un ou plusieurs sous composant "commentForm, Comment".
		components: { CommentForm, Comment },
 
		data(){ // les datas sont modifiables, c'est pour cela qu'on utilise comments pour le rafraichissement des données dans la page
			return {
				comments: [],
				respondTo: null,
				now: new Date(),
			}
		},
		
		mounted(){ // fonction executée par vuejs dès que le composant est créé (à l'execution du programme).
			// 1er param, fonction anonyme, 2ème param, temps)
			setInterval(()=>{
				this.now = new Date()
			}, 1000)

			axios.get('/comments/' + btoa(window.location.href)) // le btoa encode en base64 l'url
			.then(({data}) => {
				this.comments = data
			})
		},

		methods: {

			format(date) {
				return formatDistance(new Date(date), this.now, {locale: fr})
			},
		},

	}

</script>