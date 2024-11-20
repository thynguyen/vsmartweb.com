<template>
	<div id="dnsconfig">
		<div class="card">
			<div class="card-body">
				<div class="form-group">
					<label for="cloudflareemail">Email</label>
					<input type="text" class="form-control" id="cloudflareemail" v-model="cloudFlare.email" :placeholder="'user@example.com'">
				</div>
				<div class="form-group">
					<label for="cloudflareapikey">API Key</label>
					<div class="input-group mb-3">
						<input type="text" class="form-control" aria-describedby="showapikey" id="cloudflareapikey" v-model="cloudFlare.apikey">
						<div class="input-group-append" v-if="showapikey">
							<span class="input-group-text" id="showapikey" @click="showApi"><font-awesome-icon :icon="(cloudFlare.apikey === hideapikey)?['far','eye']:['far','eye-slash']" /></span>
						</div>
					</div>
				</div>

				<button type="button" class="btn btn-sm btn-primary" @click="saveConfig" v-if="!showapikey || ((cloudFlare.email && cloudFlare.apikey) && cloudFlare.apikey !== hideapikey)">{{trans('Langcore::global.Save')}}</button>
				<button type="button" class="btn btn-sm btn-warning" @click="showApi" v-if="showapikey && cloudFlare.apikey!==hideapikey">{{trans('Langcore::global.Cancel')}}</button>
			</div>
		</div>
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
		components:{
			'font-awesome-icon': FontAwesomeIcon
		},
		data() {
			return {
				cloudFlare:{
					email:'',
					apikey:''
				},
				hideapikey:'**************************************',
				showapikey:''
			}
		},
		created(){
			this.getEnvConfig();
		},
		methods:{
			getEnvConfig(){
				axios.get(route('dnsmanager.admin.envcfmod'))
				.then(response => {
					this.cloudFlare.email = response.data.cloudflare_email;
					if (response.data.cloudflare_apikey) {
						this.cloudFlare.apikey = this.hideapikey;
					}
					this.showapikey = response.data.cloudflare_apikey;
				})
				.catch(error => {
					console.log(error);
				})
			},
			saveConfig(){
				axios.post(route('dnsmanager.admin.config'),{cloudflare:this.cloudFlare})
				.then(response => {
					this.showapikey = this.cloudFlare.apikey;
					this.cloudFlare.apikey = this.hideapikey;
					toastr.success(this.trans('Langcore::global.SaveSuccess'),this.trans('Langcore::global.Notification'), {timeOut: 5000});
				})
				.catch(error => {
					toastr.error('SAVE ERROR',this.trans('Langcore::global.Notification'), {timeOut: 5000});
				})
			},
			showApi(){
				if (this.cloudFlare.apikey===this.hideapikey) {
					this.cloudFlare.apikey = this.showapikey;
				} else {
					this.cloudFlare.apikey = this.hideapikey;
				}
			}
		}
	}
</script>
<style lang="scss" scoped></style>