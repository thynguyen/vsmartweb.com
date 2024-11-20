<template>
	<div class="add-category">
		<div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		        <div class="modal-content">
		        	<div class="modal-body">
		        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		        			<span aria-hidden="true">&times;</span>
				        </button>
				        <div class="error" v-if="errors.length">
				           <!-- <span v-for="(err, index) in errors" :key="index">
				               {{ err }}
				           </span> -->
				           {{errors}}
				           <hr>
				       </div>
				        <div class="formmodal">
					        <div class="form-group">
								<input type="text" v-model="dataCategory.title" @keyup="getSlug" :placeholder="trans('Langcore::global.Title')" class="form-control">
							</div>
							<div class="form-group">
								
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text" id="slug-addon">{{currentUrl}}</span>
									</div>
									<input type="text" v-model="dataCategory.slug" class="form-control" aria-describedby="slug-addon">
								</div>
							</div>
							<div class="form-group">
								<textarea v-model="dataCategory.description" class="form-control" :placeholder="trans('Langcore::global.Description')" rows="3" cols="70"></textarea>
							</div>
							<div class="form-group">
								<select class="form-control" v-model="dataCategory.parentid">
									<option value="0" selected>{{trans('Langcore::global.Choose')}}</option>
									<option v-for="(cat,key) in listCat" :value="cat">{{key}}</option>
								</select>
							</div>
							<div class="form-group">
								<tag-editor-bulma
								    :tags="dataCategory.keyword"
								    :type="'label'"
									:tag-area-class="'tagArea'"
									:tag-content-class="'tagContent'"
									:delete-area-class="'deleteArea'"
									:delete-content-class="'deleteContent'"
									:input-content-class="'form-control mt-3'"
									:placeholder="trans('Langcore::global.Keywords')"
								    @handler-after-click-tag="handlerAfterClickTag"
								    @handler-after-input-tag="handlerAfterInputTag"
								    @handler-after-delete-tag="handlerAfterDeleteTag"
								    v-model="dataCategory.keyword"
								  />
							</div>
							<div class="form-group d-flex align-items-center">
					        	<div class="border p-2 mr-3 rounded" v-if="Object.keys(iconSelected).length !== 0">
					        		<font-awesome-icon :icon="[iconSelected.type, iconSelected.name]" :class="'fa-2x'" />
					        	</div>
					        	<vue-awesome-icon-picker :title="'Icon'" :button="trans('Modlang::interfacepackage.IconChooce')" :icon-preview="false" @selected="oniconSelected"/>
					        	<button type="button" class="btn btn-lg btn-danger ml-2" @click="delSelectIcon">Xoá</button>
				        	</div>
							<button @click="addCategory" class="btn btn-primary">{{trans('Langcore::global.Save')}}</button>
						</div>
		        	</div>
		        </div>
		    </div>
		</div>
	</div>
</template>
<script>

	import { VueTagEditor, VueTagEditorBulma } from 'vue-tag-editor-set';
	import VueAwesomeIconPicker from '@rightbraintechbd/vue-awesome-icon-picker';
	import { library } from '@fortawesome/fontawesome-svg-core';
	import { fab } from '@fortawesome/free-brands-svg-icons';
	import { fas } from '@fortawesome/free-solid-svg-icons';
	import { far } from '@fortawesome/free-regular-svg-icons';
	import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
	library.add(fab, fas, far);
	export default {
		components:{
			'tag-editor':VueTagEditor,
			'tag-editor-bulma': VueTagEditorBulma,
			'vue-awesome-icon-picker': VueAwesomeIconPicker,
			'font-awesome-icon': FontAwesomeIcon
		},
		props: {
			getDataCat:{
				type: Object,
                required: true
			},
			catid:'',
			listicon:''
		},
		data(){
			return {
				listCat: {},
				dataCategory:{
					parentid:0,
					icon:'',
					title:'',
					slug:'',
					description:'',
					keyword:[]
				},
				currentUrl:'',
				errors:[],
				iconSelected:{}
			}
		},
		watch: {
			getDataCat: {
		        // Run as soon as the component loads
		        immediate: true,
		        handler() {
					this.$emit('successAddCat',false);
		        	if (this.getDataCat.id) {
				        this.dataCategory = this.getDataCat;
				        if (this.getDataCat.icon) {
							var icon = this.getDataCat.icon.split(" ");
			            	this.iconSelected = {type:icon[0],name:icon[1].replace("fa-","")};
							console.log(this.iconSelected);
				        } else {
							this.iconSelected = {};
						}
				    } else {
						this.resetForm();
					}
		        }
		    }
		},
		mounted(){
			this.currentUrl = window.location.protocol+'//'+window.location.hostname+'/interfacepackage/cat/';
			this.getListCat();
		},
		methods:{
	        async oniconSelected(icon) {
	            console.log(icon);
	            this.iconSelected = icon;
	        },
			async addCategory(icon){
				this.dataCategory.icon = (Object.keys(this.iconSelected).length !== 0)?this.iconSelected.type+' fa-'+this.iconSelected.name:'';
				axios.post(route('interfacepackage.admin.addcategory',{id:this.getDataCat.id}),{category:this.dataCategory})
				.then(response => {
					$('#formmodal').modal('hide');
					// if (!this.getDataCat.id) {
						this.$emit('successAddCat',true);
					// }
				})
				.catch(error =>{
    				this.errors = error.response.data.errors.name
    				console.log(this.errors);
				})
			},
			async getSlug(){
				var slug;
				var title = this.dataCategory.title;
			    slug = title.toLowerCase();
			    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
			    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
			    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
			    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
			    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
			    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
			    slug = slug.replace(/đ/gi, 'd');
			    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
			    slug = slug.replace(/ /gi, "-");
			    slug = slug.replace(/\-\-\-\-\-/gi, '-');
			    slug = slug.replace(/\-\-\-\-/gi, '-');
			    slug = slug.replace(/\-\-\-/gi, '-');
			    slug = slug.replace(/\-\-/gi, '-');
			    slug = slug.replace(/([^0-9a-z-\s])/gi, '');
			    slug = slug.replace(/(\s+)/gi, '-');
			    slug = slug.replace(/^-+/gi, '');
			    slug = slug.replace(/-+$/gi, '');
			    slug = '@' + slug + '@';
			    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
			    console.log(slug)
			    this.dataCategory.slug = slug;
			},
			async resetForm() {
				this.dataCategory = {
					parentid:0,
					icon:'',
					title:'',
					slug:'',
					description:'',
					keyword:[]
				};
				this.iconSelected = {};
			},
		    async handlerAfterClickTag(tag){
		      alert(tag + ' is click!')
		    },
		    async handlerAfterInputTag(tag, isAddTag){
		      if (isAddTag === true) {
		        console.log(tag + ' is added!')
		      } else {
		        console.log(tag + ' isn\'t added')
		      }
		    },
		    async handlerAfterDeleteTag(tag){
		      console.log(tag + ' is deleted!')
		    },
		    async getListCat(){
		    	axios.get(route('interfacepackage.admin.listcatall',{id:this.catid}))
				.then(response=>{
					this.listCat = response.data;
				})
				.catch(error=>{
					if (error.response) {
	    				this.errors = error.response.data.errors.name
	    			}
				})
		    },
		    async delSelectIcon(){
		    	this.iconSelected = {};
		    }
		}
	}
</script>
<style lang="scss" scoped>
.tagEditor {
  border: 1px solid gray;
  margin: 12px;
  padding: 6px;
}
.inputContent {
  border: none;
  height: 16px;
}
.tagLabelCustom {
}
.tagLinkCustom {
  background-color: gray !important;
  color: white !important;
}
</style>