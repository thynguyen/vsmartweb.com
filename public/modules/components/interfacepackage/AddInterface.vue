<template>
	<div class="add-interface">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-sm-8">
						<div class="form-group">
							<input type="text" v-model.trim="$v.interfaceCreate.title.$model" @keyup="getSlug" :placeholder="trans('Langcore::global.Title')" class="form-control" :class="{ 'is-invalid': $v.interfaceCreate.title.$error }">
							<div class="invalid-feedback" v-if="!$v.interfaceCreate.title.required">{{ trans('Lrvlang::validation.required',{attribute:trans('Langcore::global.Title')}) }}</div>
							<div class="invalid-feedback" v-if="!$v.interfaceCreate.title.minLength">{{ trans('Lrvlang::validation.min.string',{attribute:trans('Langcore::global.Title'),min:$v.interfaceCreate.title.$params.minLength.min}) }}</div>
						</div>
						<div class="form-group">
							
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="slug-addon">{{currentUrl}}</span>
								</div>
								<input type="text" v-model.trim="$v.interfaceCreate.slug.$model" class="form-control" aria-describedby="slug-addon" :class="{ 'is-invalid': $v.interfaceCreate.slug.$error }">
								<div class="invalid-feedback" v-if="!$v.interfaceCreate.slug.required">{{ trans('Lrvlang::validation.required',{attribute:'Slug'}) }}</div>
							</div>
						</div>
						<div class="form-group">
							<textarea v-model="interfaceCreate.description" class="form-control" :placeholder="trans('Langcore::global.Description')" rows="3" cols="70"></textarea>
						</div>
						<div class="form-group">
							<ckeditor v-model="$v.interfaceCreate.content.$model" @namespaceloaded="onNamespaceLoaded" :config="editorConfig"></ckeditor>
							<div class="invalid-feedback " :class="{ 'd-block': $v.interfaceCreate.content.$error }" v-if="!$v.interfaceCreate.content.required">{{ trans('Lrvlang::validation.required',{attribute:trans('Langcore::global.Content')}) }}</div>

							<div class="invalid-feedback" :class="{ 'd-block': $v.interfaceCreate.content.$error && !$v.interfaceCreate.content.minLength }" v-if="!$v.interfaceCreate.content.minLength">{{ trans('Lrvlang::validation.min.string',{attribute:trans('Langcore::global.Content'),min:$v.interfaceCreate.content.$params.minLength.min}) }}</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<div class="d-block w-100 text-center border rounded p-2" @click="openPopupManageFile">
								<img :src="(interfaceCreate.image)?interfaceCreate.image:'/Themes/admindefault/assets/img/noimage.png'" class="img-fluid" ref="ValImage" id="showimgpage">
							</div>
							<input type="hidden" v-model="interfaceCreate.image" onchange="uploadimg('#image','#showimgpage')" id="image">
							<button type="button" class="btn btn-primary btn-block mt-2" id="fmimgpage" data-input="img_page" @click="openPopupManageFile"><i class="fas fa-image"></i> {{trans('Langcore::global.Choose')}}</button>
						</div>
						<div class="form-group">
							<label for="svpcode">{{trans('Modlang::servicepack.ServicePack')}}</label>
							<select class="form-control" v-model.trim="$v.interfaceCreate.svp_code.$model" :class="{'is-invalid': $v.interfaceCreate.svp_code.$error}" id="svpcode">
								<option value="" disabled="true" selected>{{trans('Langcore::global.Choose')}}</option>
								<option v-for="(code,key) in listService" :value="code">{{key}}</option>
							</select>
							<div class="invalid-feedback" v-if="!$v.interfaceCreate.svp_code.required">{{ trans('Lrvlang::validation.required',{attribute:trans('Modlang::servicepack.ServicePack')}) }}</div>
						</div>
						<div class="form-group">
							<label for="catid">{{trans('Modlang::interfacepackage.Category')}}</label>
							<select class="form-control" v-model.trim="$v.interfaceCreate.catid.$model" :class="{ 'is-invalid': $v.interfaceCreate.catid.$error }" id="catid">
								<option value="" disabled="true" selected>{{trans('Langcore::global.Choose')}}</option>
								<option v-for="(cat,key) in listCat" :value="cat">{{key}}</option>
							</select>
							<div class="invalid-feedback" v-if="!$v.interfaceCreate.catid.required">{{ trans('Lrvlang::validation.required',{attribute:trans('Modlang::interfacepackage.Category')}) }}</div>
						</div>
						<div class="form-group">
							<tag-editor-bulma
							    :tags="interfaceCreate.keyword"
							    :type="'link'"
								:tag-area-class="'tagArea'"
								:tag-content-class="'tagContent'"
								:delete-area-class="'deleteArea'"
								:delete-content-class="'deleteContent'"
								:input-content-class="'form-control mt-3'"
								:placeholder="trans('Langcore::global.Keywords')"
							    @handler-after-click-tag="handlerAfterClickTag"
							    @handler-after-input-tag="handlerAfterInputTag"
							    @handler-after-delete-tag="handlerAfterDeleteTag"
							    v-model="interfaceCreate.keyword"
							  />
						</div>
					</div>
				</div>
				<div class="d-flex align-items-center">
					<button @click="addInterface" class="btn btn-primary">{{trans('Langcore::global.Save')}}</button>
					<div class="form-group form-check ml-2 mb-0">
						<input type="checkbox" class="form-check-input" id="activeinterface" v-model="interfaceCreate.active">
						<label class="form-check-label" for="activeinterface">{{trans('Langcore::global.Active')}}</label>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import Vue from 'vue';
	import CKEditor from 'ckeditor4-vue';
	import { VueTagEditor, VueTagEditorBulma } from 'vue-tag-editor-set';
	import Vuelidate from "vuelidate";
	Vue.use( CKEditor );
	Vue.use(Vuelidate);
	import { required, minLength, between } from 'vuelidate/lib/validators'
	export default {
		//id  = window.location.pathname.split('/')[4]
		components:{
			'tag-editor':VueTagEditor,
			'tag-editor-bulma': VueTagEditorBulma
		},
		data(){
			return {
				id:window.location.pathname.split('/')[4],
				listCat: {},
				listService:{},
				interfaceCreate:{
					title:'',
					slug:'',
					description:'',
					keyword:[],
					image:'',
					content:'',
					catid:'',
					svp_code:'',
					active:1
				},
				currentUrl:'',
				editorUrl: window.location.protocol+'//'+window.location.hostname+'/editors/ckeditor/ckeditor.js',
				editorConfig: {
					extraPlugins: 'clipboard,justify,autolink,cleanlink,googledocs,youtube,codesnippet,notification,find,yaqr,autoembed,fontawesome5,colordialog',
					removePlugins: 'about',
                    language: langsite,
					filebrowserBrowseUrl: vsw_filemanager+'/dialog.php?&akey='+akeyfilemanager+'&type=2&editor=ckeditor&fldr='+userid,
					filebrowserUploadUrl: vsw_filemanager+'/dialog.php?&akey='+akeyfilemanager+'&type=2&editor=ckeditor&fldr='+userid,
					filebrowserImageBrowseUrl: vsw_filemanager+'/dialog.php?&akey='+akeyfilemanager+'&type=1&editor=ckeditor&fldr='+userid,
					youtube_width: '640',
					youtube_height: '480',
					youtube_related: false,
					youtube_older: false,
					youtube_privacy: false,
					youtube_autoplay: true,
					codeSnippet_theme: 'github',
					fontawesome: {'path':'/css/all.min.css','version':'5.15.0','edition':'pro','element':'i'},
					allowedContent: true,
					extraAllowedContent: 'p(*)[*]{*};div(*)[*]{*};li(*)[*]{*};ul(*)[*]{*}',
                }
			}
		},
		validations: {
			interfaceCreate:{
				title: {
					required,
					minLength: minLength(4)
				},
				slug: {
					required
				},
				content: {
					required,
					minLength: minLength(250)
				},
				catid: {
					required
				},
				svp_code: {
					required
				}
			}
		},
		created() {
			this.currentUrl = window.location.protocol+'//'+window.location.hostname+'/interfacepackage/';
			this.getInterface();
			this.getListCat();
			this.getListService();
		},
		methods:{
			async getInterface(){
				if (this.id) {
					axios.get(route('interfacepackage.admin.getinterface',{id:this.id}))
					.then(response=>{
						response.data.keyword = JSON.parse(response.data.keyword);
						this.interfaceCreate = response.data
					})
					.catch(error=>{
						console.log(error)
					})
				}
			},
			async addInterface(){
				this.$v.interfaceCreate.$touch();
				if (this.$v.interfaceCreate.$invalid) {} else {
					this.interfaceCreate.image = this.$refs.ValImage.src;
					axios.post(route('interfacepackage.admin.addinterface',{id:this.id}),{interface:this.interfaceCreate})
					.then(response=>{
						window.location.href = route('interfacepackage.admin.main')
					})
					.catch(error=>{
						console.log(error)
					})
				}
			},
			async getSlug(){
				var slug;
				var title = this.interfaceCreate.title;
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
			    this.interfaceCreate.slug = slug;
			},
            async onNamespaceLoaded( CKEDITOR ) {
                var linkpath = window.location.protocol+'//'+window.location.hostname+'/editors/ckeditor/plugins/';
                CKEDITOR.dtd.$removeEmpty.span = false; 
				CKEDITOR.dtd.$removeEmpty.i = false;
                CKEDITOR.plugins.addExternal( 'clipboard', linkpath+'clipboard/', 'plugin.js' );
                CKEDITOR.plugins.addExternal( 'justify', linkpath+'justify/', 'plugin.js' );
                CKEDITOR.plugins.addExternal( 'autolink', linkpath+'autolink/', 'plugin.js' );
                CKEDITOR.plugins.addExternal( 'cleanlink', linkpath+'cleanlink/', 'plugin.js' );
                CKEDITOR.plugins.addExternal( 'googledocs', linkpath+'googledocs/', 'plugin.js' );
                CKEDITOR.plugins.addExternal( 'youtube', linkpath+'youtube/', 'plugin.js' );
                CKEDITOR.plugins.addExternal( 'codesnippet', linkpath+'codesnippet/', 'plugin.js' );
                CKEDITOR.plugins.addExternal( 'notification', linkpath+'notification/', 'plugin.js' );
                CKEDITOR.plugins.addExternal( 'find', linkpath+'find/', 'plugin.js' );
                CKEDITOR.plugins.addExternal( 'yaqr', linkpath+'yaqr/', 'plugin.js' );
                CKEDITOR.plugins.addExternal( 'autoembed', linkpath+'autoembed/', 'plugin.js' );
                CKEDITOR.plugins.addExternal( 'fontawesome5', linkpath+'fontawesome5/', 'plugin.js' );
                CKEDITOR.plugins.addExternal( 'colordialog', linkpath+'colordialog/', 'plugin.js' );
            },
            async openPopupManageFile(){
            	open_popup(vsw_filemanager+'/dialog.php?akey='+akeyfilemanager+'&type=0&popup=1&field_id=image');
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
		    	axios.get(route('interfacepackage.admin.listcatall'))
				.then(response=>{
					this.listCat = response.data;
				})
				.catch(error=>{
					if (error.response) {
	    				this.errors = error.response.data.errors.name
	    			}
				})
		    },
		    async getListService(){
		    	axios.get(route('interfacepackage.admin.listservicepack'))
				.then(response=>{
					this.listService = response.data;
				})
				.catch(error=>{
					if (error.response) {
	    				this.errors = error.response.data.errors.name
	    			}
				})
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