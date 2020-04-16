<template>
	<div>
		<div class="border rounded px-3 pt-3 pb-2">
			<div>
				<p class="text-sm text-gray-dark mb-2"> 
							{{ comment.name }} - il y a {{ diffForHumans }}
				</p>
				{{ comment.body }}
			</div>
			<p>	
				<button type="button" class="text-sm text-gray-600 font-semibold" @click="$emit('respond-to', comment)">
				<svg class="fill-current text-gray-dark h-3 mr-px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M15 17v-2.99A4 4 0 0 0 11 10H8v5L2 9l6-6v5h3a6 6 0 0 1 6 6v3h-2z"/></svg>Répondre</button>
			</p>
		</div>
		<div class="mt-4 border-l-4 pl-4">
			<comment class="mb-4" 
				v-for="child in comment.children"	
				:key="child.id" 
				:comment ="child" 
				:now ="now" 
				@respond-to = "$emit('respond-to', $event)"
			></comment>	
			
		</div>
	</div>
</template>
<script>
	import { formatDistance } from 'date-fns'
	import { fr } from 'date-fns/esm/locale'

	export default{
		name:"comment",

		props: ['comment', "now"], // données props réçues de l'élément parent "comments.vue"
		// Vuejs gère plus facilement les computed que les méthods
		// les computeds n'ont pas accès à des paramètres.
		computed: {
			diffForHumans(){
				return formatDistance(new Date(this.comment.created_at), this.now, {locale: fr})
			}
		}
	}
</script>