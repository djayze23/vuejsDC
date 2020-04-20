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
				<div v-if="nextPage" class="flex justify-center">
					<button class="text-gray-600 text-sm" @click="fetchComments(nextPage)">
						charger les {{ numberOfComments - comments.length }} commentaires suivants...
					</button>		
				</div>
		</div>
		<comment-form 
			:respond-to="respondTo"
			@newComment="newComment" 
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
				nextPage: null,
				numberOfComments : 0,
				now: new Date(),
			}
		},
		
		mounted(){ // fonction executée par vuejs dès que le composant est créé (à l'execution du programme).
			// 1er param, fonction anonyme, 2ème param, temps)
			setInterval(()=>{
				this.now = new Date()
			}, 1000)

			this.fetchComments('/comments/' + btoa(window.location.href)) // le btoa encode en base64 l'url
		},

		methods: {

			fetchComments(url){
				axios.get(url)
					.then(({data: pagination}) => {
					this.comments = this.comments.concat(pagination.data)
					this.nextPage = pagination.next_page_url
					this.numberOfComments = pagination.total
			})
			}

			newComment(comment){
				if(!this.respondTo){
					this.comments.push(comment)
					return // arrête l'execution de new comment
				}
				this.respondTo.children.push(comment)
			}
		},

	}

</script>