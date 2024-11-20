<template>
	<div class="list-category">
		<transition name="fade">
		    <div class="alert alert-danger alert-dismissible" role="alert" v-if="error">
		        <b>{{ error.errors.name }}</b>
		        <button type="button" class="close" @click="error = null">
		            <span aria-hidden="true">&times;</span>
		        </button>
		    </div>
		</transition>
		<div class="d-flex mb-3">
			<div class="button">
				<button type="button" class="btn btn-sm btn-primary" @click="openmodal()">{{ trans('Modlang::interfacepackage.AddCategory') }}</button>
			</div>
			<div class="search">
			</div>
		</div>
		<table class="table table-responsive-sm table-striped bg-white">
			<thead class="thead-dark">
				<tr>
					<th>ID</th>
					<th>Icon</th>
					<th>{{trans('Langcore::global.Title')}}</th>
					<th>{{trans('Langcore::global.Description')}}</th>
					<th></th>
				</tr>
			</thead>
			<transition-group name="slide-fade" tag="tbody">
				<tr v-for="(cat,index) in listCategory.data" :key="cat.id">
					<td>{{cat.id}}</td>
					<td>
						<span v-if="cat.icon && cat.ic">
							<font-awesome-icon :icon="[cat.ic.type, cat.ic.name]" :class="'fa-2x'" />
						</span>
					</td>
					<td>{{cat.title}}</td>
					<td>{{cat.description}}</td>
                    <td>
                    	<button class="btn btn-sm btn-success" @click="openmodal(cat)"><i class="fas fa-pencil-alt"></i></button>
                    	<button class="btn btn-sm btn-danger" @click="deleteCategory(cat, index)"><i class="fas fa-trash-alt"></i></button>
                    	<a :href="cat.urlcat" class="btn btn-sm btn-info text-white"><i class="fal fa-list-ol fa-lg"></i></a>
                    </td>
				</tr>
			</transition-group>
		</table>
		<pagination :data="listCategory" :limit="2" :align="'center'" @pagination-change-page="getAllCategory">
			<span slot="prev-nav">{{trans('Langcore::global.Previous')}}</span>
			<span slot="next-nav">{{trans('Langcore::global.Next')}}</span>
		</pagination>
	</div>
</template>
<script>
	import { library } from '@fortawesome/fontawesome-svg-core';
	import { fab } from '@fortawesome/free-brands-svg-icons';
	import { fas } from '@fortawesome/free-solid-svg-icons';
	import { far } from '@fortawesome/free-regular-svg-icons';
	import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
	library.add(fab, fas, far);
	export default {
		props: {
			sAddCat:'',
			catid:''
		},
		components:{
			'font-awesome-icon': FontAwesomeIcon
		},
		data(){
			return {
				listCategory: {},
				error:null,
				prevSelectedCat: null,
				selectedCat:{},
				ifcatpage: 1
			}
		},
		watch: {
			sAddCat: {
		        // Run as soon as the component loads
		        immediate: true,
		        handler() {
		        	if (this.sAddCat == true) {
				        this.changePage(this.ifcatpage);
				    }
		        }
		    }
		},
		mounted(){
			this.getAllCategory();
		},
		methods: {
			async getAllCategory(page=1){
				this.ifcatpage = page;
				axios.get(route('interfacepackage.admin.listcategory',{id:this.catid}),{params:{page:page}})
				.then(response=>{
					this.listCategory = response.data;
					var listcat = this.listCategory;
    				listcat.data.forEach(item => {
    					item.keyword = JSON.parse(item.keyword);
    					if (item.icon) {
    						var icon = item.icon.split(" ");
	    					item.ic = {type:icon[0],name:icon[1].replace("fa-","")};
    					}
    					item.urlcat = route('interfacepackage.admin.category',{id:item.id});
                    });
				})
				.catch(error=>{
	    			this.error = error.response.data
				})
			},
    		async deleteCategory(cat,index){
    			if (confirm(this.trans('Langcore::global.warning_delfile')) == true) {
	    			axios.delete(route('interfacepackage.admin.delcategory',{id:cat.id}))
	    			.then(response => {
	    				// this.changePage(this.ifcatpage);
	    				this.listCategory.data.splice(index,1)
	    				toastr.success(this.trans('Langcore::global.DelSuccess'),this.trans('Langcore::global.Notification'), {timeOut: 5000});
	    			})
	    			.catch(error => {
	    				this.error = error.response.data
	    			})
	    		}
    		},
			async openmodal(datacat='null'){ 
				$('#formmodal').modal('show');
				this.$emit('addEditCat',(datacat!=='null')?datacat:{});
			},
    		async changePage(page) {
				this.ifcatpage = page;
	            this.getAllCategory(page);
	        }
		}
	}
</script>
<style lang="scss" scoped>
	.fade-enter-active, .fade-leave-active {
	  transition: opacity .5s;
	}
	.fade-enter, .fade-leave-to {
	  opacity: 0;
	}
	.slide-fade-enter-active {
	  transition: all .3s ease;
	}
	.slide-fade-leave-active {
	  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
	}
	.slide-fade-enter, .slide-fade-leave-to {
	  transform: translateX(10px);
	  opacity: 0;
	}
</style>