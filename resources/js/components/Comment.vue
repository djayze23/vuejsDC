<template>
	<div>
		<div class="border rounded px-3 pt-3 pb-2">
			<div class="mb-2">
				<p class="text-sm text-gray-dark mb-2"> 
					{{ comment.name }} - il y a {{ diffForHumans }}
				</p>
				<p v-if="edit">
					<textarea class="w-full border rounded p-3"></textarea>
				</p>
				<p v-else>
					{{ comment.body }}
				</p>
			</div>
			<p v-if="edit" class="flex -mx-2">	
				<button type="button" class="mx-2 flex items-center text-xs text-gray-600 font-semibold" @click="edit = false">
					<svg class="fill-current text-gray-dark h-3 mr-px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
					Annuler
				</button>
				<button type="button" class="mx-2 flex items-center text-xs text-gray-600 font-semibold" @click="update()">
					<svg class="fill-current text-gray-dark h-2 mr-px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 2C0 .9.9 0 2 0h14l4 4v14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm5 0v6h10V2H5zm6 1h3v4h-3V3z"/></svg>
					Sauvegarder
				</button>
			</p>

			<p v-else class="flex -mx-2">	
				<button type="button" class="mx-2 flex items-center text-xs text-gray-600 font-semibold" @click="$emit('respond-to', comment)">
					<svg class="fill-current text-gray-dark h-3 mr-px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M15 17v-2.99A4 4 0 0 0 11 10H8v5L2 9l6-6v5h3a6 6 0 0 1 6 6v3h-2z"/></svg>
					Répondre
				</button>
				<button type="button" class="mx-2 flex items-center text-xs text-gray-600 font-semibold" @click="edit = true">
					<svg class="fill-current text-gray-dark h-2 mr-px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/></svg>
					Modifier
				</button>
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
		name: "comment",

		props: ['comment', "now"], // données props reçues de l'élément parent "comments.vue"
		
		data(){
			return {
				edit:false,
			}
		},

		// Vuejs gère plus facilement les computed que les méthods
		// les computeds n'ont pas accès à des paramètres.
		computed: {
			diffForHumans(){
				return formatDistance(new Date(this.comment.created_at), this.now, {locale: fr})
			}
		},

		methods : {
			update(){
				console.log('updating')
			}
		}
	}
</script>