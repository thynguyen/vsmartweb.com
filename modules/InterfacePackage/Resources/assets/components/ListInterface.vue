<template>
	<div class="list-interface">
		<div class="d-flex align-items-center justify-content-between mb-3">
			<div class="button">
				<button type="button" class="btn btn-sm btn-primary" @click="addInterface">{{ trans('Modlang::interfacepackage.AddInterface') }}</button>
			</div>
			<div class="search rounded">
	            <input type="text" v-debounce:400ms="search" v-model="searchInterface" :placeholder="trans('Langcore::global.Search')">
	            <i class="fas fa-search"></i>
			</div>
		</div>
		<transition-group name="slide-fade" tag="div" class="row" v-if="listInterface.total !== 0">
			<div v-for="(item,index) in listInterface.data" class="col-sm-4" :key="item.id">
				<div class="card">
  					<img :src="item.image" class="card-img-top" :alt="item.title">
					<div class="card-body">
						<div class="d-flex justify-content-between mb-2">
							<div>
								<h5 class="card-title mb-0">{{item.title}}</h5>
								<small class="card-subtitle mb-2 text-muted">
									<span v-if="item.servicepack">
										<i class="fas fa-box mr-2"></i>{{item.servicepack.title}}
										|
									</span>
									<span>
										<i class="fas fa-folder mr-2"></i>{{item.cat.title}}
										|
									</span>
									<span>
										<i class="fas fa-thumbs-up mr-2"></i>{{item.sentimentlike.length}}
										|
									</span>
									<span>
										<i class="fas fa-thumbs-down mr-2"></i>{{item.sentimentdislike.length}}
									</span>
								</small>
							</div>
							<div>
								<button type="button" class="btn btn-sm btn-icon btn-link" @click="changeActive(item)" :class="{ 'text-muted': item.active === 0 }"><i class="fas fa-check-circle fa-lg"></i></button>
								<b-dropdown no-caret variant="link" toggle-class="text-decoration-none p-1 text-muted" dropleft>
									<template #button-content>
									<i class="fas fa-ellipsis-v fa-lg"></i>
									</template>
									<b-dropdown-item :href="item.url">
										<i class="fas fa-pencil-alt mr-2"></i>{{trans('Langcore::global.Edit')}}
									</b-dropdown-item>
									<b-dropdown-item @click="deleteInterface(item,index)">
										<i class="far fa-trash-alt mr-2"></i>{{trans('Langcore::global.Delete')}}
									</b-dropdown-item>
								</b-dropdown>
							</div>
						</div>
						<p class="card-text">{{item.description}}</p>
					</div>
				</div>
			</div>
		</transition-group>
		<transition name="slide-fade" tag="div" v-else>
			<div class="card card-body"><span>Dữ liệu rỗng</span></div>
		</transition>
		<pagination :data="listInterface" :limit="2" :align="'center'" @pagination-change-page="paginaSearch">
			<span slot="prev-nav">{{trans('Langcore::global.Previous')}}</span>
			<span slot="next-nav">{{trans('Langcore::global.Next')}}</span>
		</pagination>
	</div>
</template>
<script>
	import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
	import 'bootstrap-vue/dist/bootstrap-vue.css';
	import vueDebounce from 'vue-debounce'
	Vue.use(vueDebounce, {
		listenTo: ['input', 'keyup']
	})
	Vue.use(BootstrapVue)
	Vue.use(IconsPlugin)
	export default {
		data(){
			return {
				listInterface: {},
				searchInterface:''
			}
		},
		created(){
			this.getListInterface()
		},
		methods: {
			async getListInterface(page=1){
				axios.get(route('interfacepackage.admin.listinterfaces'),{params:{page:page}})
				.then(response=>{
					this.listInterface = response.data
					this.listInterface.data.forEach(item => {
						item.url = route('interfacepackage.admin.addinterface',{id:item.id});
					});
				})
				.catch(error=>{
					console.log(error)
				})
			},
			async addInterface(){
				window.location.href = route('interfacepackage.admin.addinterface')
			},
    		async deleteInterface(item,index){
    			if (confirm(this.trans('Langcore::global.warning_delfile')) == true) {
	    			axios.delete(route('interfacepackage.admin.delinterface',{id:item.id}))
	    			.then(response => {
	    				this.listInterface.data.splice(index,1)
	    				toastr.success(this.trans('Langcore::global.DelSuccess'),this.trans('Langcore::global.Notification'), {timeOut: 5000});
	    			})
	    			.catch(error => {
	    				this.error = error.response.data
	    			})
	    		}
    		},
    		async search(val,page=1){
    			this.searchInterface = val;
    			axios.get(route('interfacepackage.admin.searchinterface',{keyword:this.searchInterface}),{params:{page:page}})
    			.then(response=>{
					this.listInterface = response.data
					this.listInterface.data.forEach(item => {
						item.url = route('interfacepackage.admin.addinterface',{id:item.id});
					});
    			})
    			.catch(error=>{
    				this.error = error.response.data
    			})
    		},
    		async paginaSearch(page=1){
    			if (this.searchInterface) {
    				this.search(this.searchInterface,page);
    			} else {
    				this.getListInterface(page);
    			}
    		},
    		async changeActive(item){
    			axios.post(route('interfacepackage.admin.changeactive'),{id:item.id})
    			.then(response=>{
    				if (item.active === 1) {
	    				item.active = 0;
	    			} else {
	    				item.active = 1;
	    			}
    				console.log(response.data);
	    			toastr.success(response.data,this.trans('Langcore::global.Notification'), {timeOut: 5000});
    			})
    			.catch(error=>{
    				this.error = error.response.data
    			})
    		}
		}
	}
</script>
<style lang="scss" scoped>
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
	.search {
	  background-color:#fff;
	  display: flex;
	  align-items: center;
	  border: 1px solid rgba(0, 0, 0, .10);
	}
	.search i, .search svg{
	  margin: 0 10px;
	  color: #6c757d;
	}
	.search input[type="text"]{
	  width: 100%;
	  border: none;
	  height: 30px;
	  padding: 0 10px 0 15px;
	  /*margin-right: 15px;*/
	  -webkit-border-radius: 50px;
	  -moz-border-radius: 50px;
	  border-radius: 50px;
	  background-color: transparent;
	}
</style>