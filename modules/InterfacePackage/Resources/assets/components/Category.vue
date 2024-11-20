<template>
	<div class="category">
		<ListCategory @addEditCat="getDataCat" :sAddCat="saddCat" :catid="catid"></ListCategory>
		<AddCategory @successAddCat="sAddCat" :getDataCat="dataCat" :catid="catid" :listicon="listicon"></AddCategory>
	</div>
</template>
<script>
	import ListCategory from './ListCategory.vue'
	import AddCategory from './AddCategory.vue'
	export default {
		props: {
	        catid: '',
	        listicon:''
	    },
		components:{
			ListCategory,
			AddCategory
		},
		data(){
			return {
				dataCat:{},
				saddCat:''
			}
		},
		methods: {
			async getDataCat(datacat){
				this.dataCat = datacat
			},
			async sAddCat(msg){
				this.saddCat = msg
			}
		}
	}
</script>
<style lang="scss" scoped>
	
</style>