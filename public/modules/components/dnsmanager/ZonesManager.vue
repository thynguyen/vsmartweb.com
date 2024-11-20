<template>
	<div id="zonesmanager">
		<div class="mb-3 d-flex justify-content-between">
			<button type="button" class="btn btn-sm btn-primary" @click="openModal">Add Zone</button>
			<button type="button" class="btn btn-sm btn-icon btn-light" @click="configModule"><i class="fas fa-cogs"></i></button>
		</div>
		<div class="row">
			<div class="col-sm-3" v-for="zone in listZones.result">
				<div class="card zone-card" @click="managerDomain(zone)">
					<div class="card-body">
						<span class="d-block font-weight-bold">{{zone.name}}</span>
						<span class="d-block" v-if="zone.status === 'active'">
							<i class="fas fa-check fa-lg text-success"></i> {{trans('Langcore::global.Active')}}
						</span>
						<span class="d-block" v-else-if="zone.status === 'pending'">
							<i class="far fa-clock fa-lg text-warning"></i> Pending
						</span>
					</div>
				</div>
			</div>
		</div>

		<nav aria-label="Page navigation example" v-if="zonePage.total_pages > 1">
			<ul class="pagination justify-content-center">
				<li :class="(zonePage.page === i)?'page-item active':'page-item'" v-for="i in zonePage.total_pages">
					<button type="button" class="page-link" @click="pageZone(i)" v-if="zonePage.page != i">{{i}}</button>
					<span class="page-link" v-else>{{i}}</span>
				</li>
			</ul>
		</nav>
		<div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		        <div class="modal-content">
		        	<div class="modal-body">
		        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		        			<span aria-hidden="true">&times;</span>
				        </button>

						<div class="form-group">
							<label for="zonename">Enter your site (example.com):</label>
							<input type="text" class="form-control" id="zonename" v-model="zonename" :placeholder="'example.com'">
						</div>
						<button @click="createZone" class="btn btn-primary">{{trans('Langcore::global.Save')}}</button>
				    </div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		data(){
			return {
				listZones:{},
				zonename:'',
				zonePage:{}
			}
		},
		mounted(){
			this.getListZones();
		},
		methods:{
			getListZones(page=1,perpage=20){
				axios.get(route('dnsmanager.admin.getlistzones'),{params:{page:page,perpage:perpage}})
				.then(response => {
					this.listZones = response.data;
					this.zonePage = response.data.result_info;
				})
				.catch(error=>{
					this.errors = error.response.data.errors.name
				})
			},
			managerDomain(zone){
				window.location.href = route('dnsmanager.admin.managerdomain',{zoneid:zone.id})
			},
			openModal(){
				$('#formmodal').modal('show');
				// this.resetForm();
			},
			createZone(){
				axios.post(route('dnsmanager.admin.createzone'),{name:this.zonename})
				.then(response =>{
					$('#formmodal').modal('hide');
					this.getListZones();
				})
				.catch(error=>{
    				this.errors = error.response.data.errors.name
    			})
			},
			configModule(){
				window.location.href = route('dnsmanager.admin.config')
			},
			resetForm(){
				this.zonename = '';
			},
			pageZone(page){
				this.getListZones(page);
			}
		}
	}
</script>
<style lang="scss" scoped>
	.zone-card {
		cursor: pointer;
	}
</style>