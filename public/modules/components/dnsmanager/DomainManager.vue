<template>
	<div id="listrecords">
		<h4 class="mb-3">{{datazone.name}}</h4>
		<div class="mb-3 row">
			<div class="col-sm-6">
				<button type="button" class="btn btn-primary" @click="openModal"  v-if="datazone.status === 'active'">Add Record</button>
				<button type="button" class="btn btn-danger" @click="deleteZone(datazone.id)">Delete Zone</button>
			</div>
			<div class="col-sm-6"  v-if="datazone.status === 'active'">
				<input type="text" v-debounce:400ms="search" v-model="searchRecord" class="form-control">
			</div>
		</div>
		<div v-if="datazone.status === 'pending'">
			<div class="card">
				<div class="card-body">
					Remove these nameservers:
					<div class="border rounded bg-light shadow-sm px-3 py-1 my-3">
						<ul class="list-unstyled mb-0 font-weight-bold">
							<li>{{datazone.original_name_servers[0]}}</li>
							<li>{{datazone.original_name_servers[1]}}</li>
						</ul>
					</div>
					Replace with nameservers:
					<div class="border rounded bg-light shadow-sm px-3 py-1 my-3">
						<ul class="list-unstyled mb-0 font-weight-bold">
							<li>{{datazone.name_servers[0]}}</li>
							<li>{{datazone.name_servers[1]}}</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div v-else>
	        <div class="error" v-if="errors.length">{{errors}}</div>
			<div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
			        <div class="modal-content">
			        	<div class="modal-body">
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			        			<span aria-hidden="true">&times;</span>
					        </button>
							<div class="form-row">
								<div class="form-group col-md-2">
									<label for="typerecord">Type</label>
									<select class="form-control" id="typerecord" v-model="dataRecord.type" v-if="!idrecord">
										<option v-for="type in listType" :key="type" :value="type">{{type}}</option>
									</select>
									<strong class="d-block" v-else>{{dataRecord.type}}</strong>
								</div>
								<div class="form-group col-md-3">
									<label for="namerecord">Name</label>
									<input type="text" class="form-control" id="namerecord" v-model="dataRecord.data.name" :placeholder="'Use @ for root'">
								</div>
								<div class="form-group col-md-2" v-if="dataRecord.type === 'SRV'">
									<label for="servicerecord">Service</label>
									<input type="text" :placeholder="'_servicename'" class="form-control" id="servicerecord" v-model="dataRecord.datasrv.service">
								</div>
								<div class="form-group col-md-1" v-if="dataRecord.type === 'SRV'">
									<label for="protocolrecord">Protocol</label>
									<select class="form-control" id="protocolrecord" v-model="dataRecord.datasrv.protocol">
										<option v-for="(proto,key) in listProtocol" :key="key" :value="key">{{proto}}</option>
									</select>
									
								</div>
								<div class="form-group col-md-3" v-if="dataRecord.type === 'A'||dataRecord.type === 'AAAA'">
									<label for="contentrecord" v-if="dataRecord.type === 'A'">
										IPv4 address
									</label>
									<label for="contentrecord" v-if="dataRecord.type === 'AAAA'">
										IPv6 address
									</label>
									<input type="text" class="form-control" id="contentrecord" v-model="dataRecord.data.content">
								</div>
								<div class="form-group col-md-3" v-if="dataRecord.type === 'CNAME'||dataRecord.type === 'MX'||dataRecord.type === 'NS'||dataRecord.type === 'SPF'">
									<label for="contentrecord" v-if="dataRecord.type === 'CNAME'">Target</label>
									<label for="contentrecord" v-else-if="dataRecord.type === 'MX'">Mail server</label>
									<label for="contentrecord" v-else-if="dataRecord.type === 'NS'">Nameserver</label>
									<label for="contentrecord" v-else-if="dataRecord.type === 'SPF'">Content</label>
									<textarea id="contentrecord" v-model="dataRecord.data.content" class="form-control" rows="1"></textarea>
								</div>
								<!---->

								<div class="form-group col-md-2">
									<label for="ttlrecord">TTL</label>

									<div v-if="dataRecord.data.proxied === true && (dataRecord.type === 'A' || dataRecord.type === 'AAAA' || dataRecord.type === 'CNAME')">Auto</div>
									<select class="form-control" id="ttlrecord" v-model="dataRecord.data.ttl" v-else>
										<option v-for="(ttl,key) in listTTL" :key="key" :value="key">{{ttl}}</option>
									</select>
								</div>
								<div class="form-group col-md-2" v-if="dataRecord.type === 'SRV' || dataRecord.type === 'MX'">
									<label for="priorityrecord">Priority</label>
									<input type="number" class="form-control" id="priorityrecord" aria-describedby="priorityheld" v-model="dataRecord.data.priority">
									<small id="priorityheld" class="form-text text-muted">0 - 65535</small>
								</div>
								<div class="form-group col-md-2" v-if="dataRecord.type === 'A'||dataRecord.type === 'AAAA'||dataRecord.type === 'CNAME'">
									<label for="proxiedrecord">Proxy status</label>
									<div @click="changeProxied" class="changeProxied">
										<span v-if="dataRecord.data.proxied === true" class="d-flex align-items-center">
											<span style="width: 32px;" class="mr-2"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDQgMzkuNSI+PGRlZnM+PHN0eWxlPi5jbHMtMXtmaWxsOiM5OTk7fS5jbHMtMntmaWxsOiNmNjhhMWQ7fS5jbHMtM3tmaWxsOiNmZmY7fTwvc3R5bGU+PC9kZWZzPjx0aXRsZT5Bc3NldCAxPC90aXRsZT48ZyBpZD0iTGF5ZXJfMiIgZGF0YS1uYW1lPSJMYXllciAyIj48ZyBpZD0iTGF5ZXJfMS0yIiBkYXRhLW5hbWU9IkxheWVyIDEiPjxwb2x5Z29uIGNsYXNzPSJjbHMtMSIgcG9pbnRzPSIxMDQgMjAuMTIgOTQgMTAuNjIgOTQgMTYuMTIgMCAxNi4xMiAwIDI0LjEyIDk0IDI0LjEyIDk0IDI5LjYyIDEwNCAyMC4xMiIvPjxwYXRoIGNsYXNzPSJjbHMtMiIgZD0iTTc0LjUsMzljLTIuMDgsMC0xNS40My0uMTMtMjguMzQtLjI1LTEyLjYyLS4xMi0yNS42OC0uMjUtMjcuNjYtLjI1YTgsOCwwLDAsMS0xLTE1LjkzYzAtLjE5LDAtLjM4LDAtLjU3YTkuNDksOS40OSwwLDAsMSwxNC45LTcuODEsMTkuNDgsMTkuNDgsMCwwLDEsMzguMDUsNC42M0ExMC41LDEwLjUsMCwxLDEsNzQuNSwzOVoiLz48cGF0aCBjbGFzcz0iY2xzLTMiIGQ9Ik01MSwxQTE5LDE5LDAsMCwxLDcwLDE5LjU5LDEwLDEwLDAsMSwxLDc0LjUsMzguNWMtNC4xMSwwLTUyLS41LTU2LS41YTcuNSw3LjUsMCwwLDEtLjQ0LTE1QTguNDcsOC40NywwLDAsMSwxOCwyMmE5LDksMCwwLDEsMTQuNjgtN0ExOSwxOSwwLDAsMSw1MSwxbTAtMUEyMCwyMCwwLDAsMCwzMi4xMywxMy40MiwxMCwxMCwwLDAsMCwxNywyMnYuMTRBOC41LDguNSwwLDAsMCwxOC41LDM5YzIsMCwxNSwuMTMsMjcuNjYuMjUsMTIuOTEuMTIsMjYuMjYuMjUsMjguMzQuMjVhMTEsMTEsMCwxLDAtMy42MS0yMS4zOUEyMC4xLDIwLjEsMCwwLDAsNTEsMFoiLz48L2c+PC9nPjwvc3ZnPg==" class="img-fluid"></span> Proxied
										</span>
										<span v-else class="d-flex align-items-center">
											<span style="width: 32px;" class="mr-2"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA5MC41IDU5Ij48ZGVmcz48c3R5bGU+LmNscy0xe2ZpbGw6IzkyOTc5Yjt9PC9zdHlsZT48L2RlZnM+PHRpdGxlPkFzc2V0IDI8L3RpdGxlPjxnIGlkPSJMYXllcl8yIiBkYXRhLW5hbWU9IkxheWVyIDIiPjxnIGlkPSJMYXllcl8xLTIiIGRhdGEtbmFtZT0iTGF5ZXIgMSI+PHBhdGggY2xhc3M9ImNscy0xIiBkPSJNNDksMTMuNVYxOUw1OSw5LjUsNDksMFY1LjVINDAuNzhhMTIuNDMsMTIuNDMsMCwwLDAtOS41LDQuNDJMMTcuNjUsMjcuMTZhOC44Myw4LjgzLDAsMCwxLTYuOTEsMy4zNEg1bC01LDhIMTMuMzlhMTEuMjcsMTEuMjcsMCwwLDAsOS00LjQ4TDM1LjA1LDE3LjE4YTkuODEsOS44MSwwLDAsMSw3LjY2LTMuNjhaIi8+PHBhdGggY2xhc3M9ImNscy0xIiBkPSJNODAuNSwzOUExMCwxMCwwLDAsMCw3Niw0MC4wOWExOSwxOSwwLDAsMC0zNy4zLTQuNTdBOSw5LDAsMCwwLDI0LDQyLjVhOC40Nyw4LjQ3LDAsMCwwLC4wNiwxLDcuNSw3LjUsMCwwLDAsLjQ0LDE1YzQsMCw1MS44OS41LDU2LC41YTEwLDEwLDAsMCwwLDAtMjBaIi8+PC9nPjwvZz48L3N2Zz4=" class="img-fluid"></span> DNS only
										</span>
									</div>
								</div>

								<div class="form-group col-md-12" v-if="dataRecord.type === 'TXT'">
									<label for="contentrecord">Content</label>
									<textarea id="contentrecord" v-model="dataRecord.data.content" class="form-control" rows="3"></textarea>
								</div>
							</div>
							<div class="form-row" v-if="dataRecord.type === 'SRV'">
								<div class="form-group col-md-2">
									<label for="weightrecord">Weight</label>
									<input type="number" class="form-control" id="weightrecord" aria-describedby="weightheld" v-model="dataRecord.datasrv.weight">
									<small id="weightheld" class="form-text text-muted">0 - 65535</small>
								</div>
								<div class="form-group col-md-2">
									<label for="portrecord">Port</label>
									<input type="number" class="form-control" id="portrecord" aria-describedby="portheld" v-model="dataRecord.datasrv.port">
									<small id="portheld" class="form-text text-muted">0 - 65535</small>
								</div>
								<div class="form-group col-md-8">
									<label for="targetrecord">Target</label>
									<textarea id="targetrecord" v-model="dataRecord.datasrv.target" class="form-control" rows="3"></textarea>
								</div>
							</div>

							<div class="form-row" v-if="dataRecord.type === 'HTTPS'">
								<div class="form-group col-md-2">
									<label for="priorityrecord">Priority</label>
									<input type="number" class="form-control" id="priorityrecord" aria-describedby="priorityheld" v-model="dataRecord.data.priority">
									<small id="priorityheld" class="form-text text-muted">0 - 65535</small>
								</div>
								<div class="form-group col-md-5">
									<label for="targetrecord">Target</label>
									<input type="text" class="form-control" id="targetrecord" v-model="dataRecord.datahttps.target">
								</div>
								<div class="form-group col-md-5">
									<label for="valuerecord">Value</label>
									<input type="text" class="form-control" id="valuerecord" v-model="dataRecord.datahttps.value">
								</div>
							</div>
							<div v-if="dataRecord.type === 'LOC'">
								<h5>Set latitude</h5>
								<div class="form-row">
									<div class="form-group col-md-3">
										<label for="degreeslatituderecord">Degrees</label>
										<input type="number" class="form-control" id="degreeslatituderecord" v-model="dataRecord.dataloc.latitude.degrees">
									</div>
									<div class="form-group col-md-3">
										<label for="minuteslatituderecord">Minutes</label>
										<input type="number" class="form-control" id="minuteslatituderecord" v-model="dataRecord.dataloc.latitude.minutes">
									</div>
									<div class="form-group col-md-3" :class="{ 'form-group--error': $v.dataRecord.dataloc.latitude.seconds.$error }">
										<label for="secondslatituderecord">Seconds</label>
										<input type="number" class="form-control" :class="{ 'is-invalid': $v.dataRecord.dataloc.latitude.seconds.$error }" id="secondslatituderecord" v-model.trim.lazy="$v.dataRecord.dataloc.latitude.seconds.$model">
										<div class="invalid-feedback" v-if="!$v.dataRecord.dataloc.latitude.seconds.between">Seconds must be a floating point number between {{$v.dataRecord.dataloc.latitude.seconds.$params.between.min}} and {{$v.dataRecord.dataloc.latitude.seconds.$params.between.max+1}}, including {{$v.dataRecord.dataloc.latitude.seconds.$params.between.min}} but not including {{$v.dataRecord.dataloc.latitude.seconds.$params.between.max+1}}.</div>
									</div>
									<div class="form-group col-md-3">
										<label for="directionlatituderecord">Direction</label>
										<select class="form-control" id="directionlatituderecord" v-model="dataRecord.dataloc.latitude.direction">
											<option v-for="(type,key) in listLatDirec" :key="key" :value="key">{{type}}</option>
										</select>
									</div>
								</div>
								<h5>Set longitude</h5>
								<div class="form-row">
									<div class="form-group col-md-3">
										<label for="degreeslongituderecord">Degrees</label>
										<input type="number" class="form-control" id="degreeslongituderecord" v-model="dataRecord.dataloc.longitude.degrees">
									</div>
									<div class="form-group col-md-3">
										<label for="minuteslongituderecord">Minutes</label>
										<input type="number" class="form-control" id="minuteslongituderecord" v-model="dataRecord.dataloc.longitude.minutes">
									</div>
									<div class="form-group col-md-3" :class="{ 'form-group--error': $v.dataRecord.dataloc.longitude.seconds.$error }">
										<label for="secondslongituderecord">Seconds</label>
										<input type="number" class="form-control" :class="{ 'is-invalid': $v.dataRecord.dataloc.longitude.seconds.$error }" id="secondslongituderecord" v-model.trim.lazy="$v.dataRecord.dataloc.longitude.seconds.$model">
										<div class="invalid-feedback" v-if="!$v.dataRecord.dataloc.longitude.seconds.between">Seconds must be a floating point number between {{$v.dataRecord.dataloc.longitude.seconds.$params.between.min}} and {{$v.dataRecord.dataloc.longitude.seconds.$params.between.max+1}}, including {{$v.dataRecord.dataloc.longitude.seconds.$params.between.min}} but not including {{$v.dataRecord.dataloc.longitude.seconds.$params.between.max+1}}.</div>
									</div>
									<div class="form-group col-md-3">
										<label for="directionlongituderecord">Direction</label>
										<select class="form-control" id="directionlongituderecord" v-model="dataRecord.dataloc.longitude.direction">
											<option v-for="(type,key) in listLonDirec" :key="key" :value="key">{{type}}</option>
										</select>
									</div>
								</div>
								<h5>Precision (in meters)</h5>
								<div class="form-row">
									<div class="form-group col-md-3">
										<label for="horizontalprecisionrecord">Horizontal</label>
										<input type="number" class="form-control" id="horizontalprecisionrecord" v-model="dataRecord.dataloc.precision.horizontal">
									</div>
									<div class="form-group col-md-3">
										<label for="verticalprecisionrecord">Vertical</label>
										<input type="number" class="form-control" id="verticalprecisionrecord" v-model="dataRecord.dataloc.precision.vertical">
									</div>
									<div class="form-group col-md-3">
										<label for="altitudeprecisionrecord">Altitude</label>
										<input type="number" class="form-control" id="altitudeprecisionrecord" v-model="dataRecord.dataloc.precision.altitude">
									</div>
									<div class="form-group col-md-3">
										<label for="sizeprecisionrecord">Size</label>
										<input type="number" class="form-control" id="sizeprecisionrecord" v-model="dataRecord.dataloc.precision.size">
									</div>
								</div>
							</div>
							<div class="form-row" v-if="dataRecord.type === 'CERT'">
								<div class="form-group col-md-1">
									<label for="certtyperecord">Cert. type</label>
									<input type="number" class="form-control" id="certtyperecord" aria-describedby="certtypeheld" v-model="dataRecord.datacert.certtype">
									<small id="certtypeheld" class="form-text text-muted">0 - 65535</small>
								</div>
								<div class="form-group col-md-1">
									<label for="keytagrecord">Key tag</label>
									<input type="number" class="form-control" id="keytagrecord" aria-describedby="keytagheld" v-model="dataRecord.datacert.keytag">
									<small id="keytagheld" class="form-text text-muted">0 - 65535</small>
								</div>
								<div class="form-group col-md-1">
									<label for="algorithmrecord">Algorithm</label>
									<input type="number" class="form-control" id="algorithmrecord" aria-describedby="algorithmheld" v-model="dataRecord.datacert.algorithm">
									<small id="algorithmheld" class="form-text text-muted">0 - 255</small>
								</div>
								<div class="form-group col-md-9">
									<label for="certificaterecord">Certificate</label>
									<textarea id="certificaterecord" v-model="dataRecord.datacert.certificate" class="form-control" rows="3" :placeholder="'-----BEGIN CERTIFICATE-----\n\
			d2abde240d7cd3ee6b4b28c54df034b9a1234a1b16c8d410e4561cb106618e971\n\
			-----END CERTIFICATE-----'"></textarea>
								</div>
							</div>
							<button type="button" class="btn btn-sm" :class="($v.dataRecord.$invalid)?'btn-secondary':'btn-primary'" @click="addRecord" :disabled="isDisabled">{{trans('Langcore::global.Save')}}</button>
						</div>
					</div>
				</div>
			</div>
			<div class="table-responsive" v-if="listRecords.length">
				<table class="table table-striped bg-white">
					<thead class="thead-dark">
						<tr>
							<th>Type</th>
							<th>Name</th>
							<th>Content</th>
							<th>TTL</th>
							<th>Proxy status</th>
							<th></th>
						</tr>
					</thead>
					<transition-group name="slide-fade" tag="tbody">
						<tr v-for="(record,index) in listRecords" :key="record.id">
							<td>{{record.type}}</td>
							<td>{{record.name.replace('.'+record.zone_name, '')}}</td>
							<td>
								<span v-if="record.type === 'CERT'">
									{{(record.data.type+' '+record.data.key_tag+' '+record.data.algorithm+' '+record.data.certificate).substring(0,30)}}...
								</span>
								<span v-else>
									<span v-if="record.type === 'SRV'">{{record.priority}}</span>
									<span v-if="record.type === 'LOC'">IN LOC</span>
									<span v-if="record.content.length > 30">
										{{record.content.substring(0,30)}}...
									</span>
									<span v-else>
										{{record.content}}
									</span>
								</span>
							</td>
							<td>
								<span v-if="record.ttl === 1">Auto</span>
								<span v-else-if="record.ttl >= 86400">
									{{((record.ttl/60)/60)/24}} day
								</span>
								<span v-else-if="record.ttl >= 3600">
									{{(record.ttl/60)/60}} hr
								</span>
								<span v-else>
									{{record.ttl/60}} min
								</span>
							</td>
							<td>
								<span v-if="record.proxied === true">Proxied</span>
								<span v-else>DNS only</span>
							</td>
							<td>
								<button type="button" class="btn btn-sm btn-primary" @click="editRecord(record)"><b-icon icon="pencil"></b-icon></button>
								<button type="button" class="btn btn-sm btn-danger" @click="deleteRecord(record.id,index)"><b-icon icon="trash"></b-icon></button>
							</td>
						</tr>
					</transition-group>
				</table>
			</div>
			<div class="card" v-else>
				<div class="card-body">
					Empty Record
				</div>
			</div>
			<nav aria-label="Page navigation example" v-if="recordPage.total_pages > 1">
				<ul class="pagination justify-content-center">
					<li :class="(recordPage.page === i)?'page-item active':'page-item'" v-for="i in recordPage.total_pages">
						<button type="button" class="page-link" @click="pageRecord(i)" v-if="recordPage.page != i">{{i}}</button>
						<span class="page-link" v-else>{{i}}</span>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</template>
<script>
	import { BootstrapVueIcons } from 'bootstrap-vue'
	import vueDebounce from 'vue-debounce';
	import Vuelidate from "vuelidate";
	import { required, minLength, between } from 'vuelidate/lib/validators';
	Vue.use(Vuelidate);
	Vue.use(vueDebounce, {
		listenTo: ['input', 'keyup']
	});
	Vue.use(BootstrapVueIcons);
	export default {
		props:{
			zone:''
		},
		components:{},
		data(){
			return {
				idrecord:'',
				errors:[],
				listRecords:{},
				recordPage:1,
				datazone:JSON.parse(this.zone).result,
				searchRecord:'',
				listType:['A','AAAA','CNAME','TXT','SRV','MX','NS','HTTPS','LOC','SPF','CERT',],
				listTTL:{1:'Auto',120:'2 min',300:'5 min',600:'10 min',900:'15 min',1800:'30 min',3600:'1 hr',7200:'2 hr',18000:'5 hr',43200:'12 hr',86400:'1 day',},
				listProtocol:{'_tcp':'TCP','_udp':'UDP','_tls':'TLS'},
				listLatDirec:{'N':'North','S':'South'},
				listLonDirec:{'E':'East','W':'West'},
				dataRecord:{
					type:'A',
					data:{name:'',content:'',ttl:1,proxied:false,priority:''},
					datahttps:{target:'',value:''},
					datasrv:{service:'',protocol:'_tcp',weight:'',port:'',target:''},
					dataloc:{
						latitude:{degrees:'',minutes:'',seconds:'',direction:'N'},
						longitude:{degrees:'',minutes:'',seconds:'',direction:'E'},
						precision:{horizontal:'',vertical:'',altitude:'',size:''},
					},
					datacert:{certtype:'',keytag:'',algorithm:'',certificate:''}
				}
			}
		},
		computed: {
			isDisabled: function(){
				return false;
			}
		},
		validations: {
			dataRecord:{
				dataloc:{
					latitude:{
						seconds:{
							between: between(0, 59)
						}
					},
					longitude:{
						seconds:{
							between: between(0, 59)
						}
					}
				}
			}
		},
		created(){
			this.getListRecord();
		},
		methods:{
			getListRecord(page=1,perpage=20){
				axios.get(route('dnsmanager.admin.getlistrecord'),{params:{zoneid:this.datazone.id,page:page,perpage:perpage}})
				.then(response=>{
					this.listRecords = response.data.result;
					this.recordPage = response.data.result_info;
					console.log(response.data.result_info);
				})
				.catch(error=>{
					this.errors = error.response.data.errors.name
				})
			},
			search(val){
				if (!this.searchRecord) {
					this.getListRecord();
				}
				this.listRecords = this.listRecords.filter(d => {
					for (let name in d) {
						if (d.name.toLowerCase().indexOf(val.toLowerCase()) > -1 || d.content.toLowerCase().indexOf(val.toLowerCase()) > -1) {
							return d;
						}
					}
				})
			},
			changeProxied(){
				if (this.dataRecord.data.proxied === true) {
					this.dataRecord.data.proxied = false;
				} else {
					this.dataRecord.data.proxied = true;
				}
			},
			openModal(){
				$('#formmodal').modal('show');
				this.resetForm();
			},
			addRecord(){
				this.$v.dataRecord.$touch();
				if (this.$v.dataRecord.$invalid) {} else {
					var namerecord = this.dataRecord.data.name;
					var contentrecord = this.dataRecord.data.content;
					var datarecord = {};
					if (this.dataRecord.type === 'SRV') {
						namerecord = this.dataRecord.datasrv.service+'.'+this.dataRecord.datasrv.protocol+'.'+this.dataRecord.data.name;
						contentrecord = this.dataRecord.datasrv.weight+' '+this.dataRecord.datasrv.port+' '+this.dataRecord.datasrv.target;
						datarecord = {
							name:this.dataRecord.data.name,
							port:this.dataRecord.datasrv.port,
							priority:this.dataRecord.data.priority,
							proto:this.dataRecord.datasrv.protocol,
							service:this.dataRecord.datasrv.service,
							target:this.dataRecord.datasrv.target,
							weight:this.dataRecord.datasrv.weight
						};
					}
					if (this.dataRecord.type === 'HTTPS') {
						contentrecord = this.dataRecord.data.priority+' '+this.dataRecord.datahttps.target+' '+this.dataRecord.datahttps.value;
						datarecord = {
							priority:this.dataRecord.data.priority,
							target:this.dataRecord.datahttps.target,
							value:this.dataRecord.datahttps.value
						}
					}
					if (this.dataRecord.type === 'LOC') {
						contentrecord = this.dataRecord.dataloc.latitude.degrees+' '+this.dataRecord.dataloc.latitude.minutes+' '+this.dataRecord.dataloc.latitude.seconds+' '+this.dataRecord.dataloc.latitude.direction+' '+this.dataRecord.dataloc.longitude.degrees+' '+this.dataRecord.dataloc.longitude.minutes+' '+this.dataRecord.dataloc.longitude.seconds+' '+this.dataRecord.dataloc.longitude.direction+' '+this.dataRecord.dataloc.precision.altitude+' '+this.dataRecord.dataloc.precision.size+' '+this.dataRecord.dataloc.precision.horizontal+' '+this.dataRecord.dataloc.precision.vertical;
						datarecord = {
							altitude:this.dataRecord.dataloc.precision.altitude,
							lat_degrees:this.dataRecord.dataloc.latitude.degrees,
							lat_direction:this.dataRecord.dataloc.latitude.direction,
							lat_minutes:this.dataRecord.dataloc.latitude.minutes,
							lat_seconds:this.dataRecord.dataloc.latitude.seconds,
							long_degrees:this.dataRecord.dataloc.longitude.degrees,
							long_direction:this.dataRecord.dataloc.longitude.direction,
							long_minutes:this.dataRecord.dataloc.longitude.minutes,
							long_seconds:this.dataRecord.dataloc.longitude.seconds,
							precision_horz:this.dataRecord.dataloc.precision.horizontal,
							precision_vert:this.dataRecord.dataloc.precision.vertical,
							size:this.dataRecord.dataloc.precision.size
						}
					}
					if (this.dataRecord.type === 'CERT') {
						contentrecord = this.dataRecord.datacert.certtype+' '+this.dataRecord.datacert.keytag+' '+this.dataRecord.datacert.algorithm+' '+this.dataRecord.datacert.certificate;
						datarecord = {
							algorithm:this.dataRecord.datacert.algorithm,
							certificate:this.dataRecord.datacert.certificate,
							key_tag:this.dataRecord.datacert.keytag,
							type:this.dataRecord.datacert.certtype
						}
					}
					var content = {
						zoneid:this.datazone.id,
						type:this.dataRecord.type,
						name:namerecord,
						content:contentrecord,
						ttl:this.dataRecord.data.ttl,
						proxied:this.dataRecord.data.proxied,
						priority:this.dataRecord.data.priority,
						data:datarecord
					};
					axios.post(route('dnsmanager.admin.createrecord',{id:this.idrecord}),content)
					.then(response =>{
						this.resetForm();
						this.getListRecord();
						$('#formmodal').modal('hide');
					})
					.catch(error=>{
						this.errors = error.response.data.errors.name
					})
				}
			},
			deleteRecord(id,index){
				if (confirm(this.trans('Langcore::global.warning_delfile')) == true) {
					axios.delete(route('dnsmanager.admin.delrecord',{zoneid:this.datazone.id,id:id}))
					.then(response=>{
	    				this.listRecords.splice(index,1)
	    				toastr.success(this.trans('Langcore::global.DelSuccess'),this.trans('Langcore::global.Notification'), {timeOut: 5000});
					})
					.catch(error=>{
						this.error = error.response.data
					})
				}
			},
			pageRecord(page){
				this.getListRecord(page);
			},
			editRecord(record){
				$('#formmodal').modal('show');
				this.resetForm();
				console.log(record);
				var namerecord = record.name.replace('.'+record.zone_name, '');
				var contentrecord = record.content;
				var priorityrecord = record.priority;
				var datarecord = {};

				this.idrecord = record.id;

				if(record.type == 'SRV'){
					namerecord = (record.name.replace(record.data.service+'.'+record.data.proto+'.', '')).replace('.'+record.zone_name, '');
					this.dataRecord.datasrv.service = record.data.service;
					this.dataRecord.datasrv.protocol = record.data.proto;
					this.dataRecord.datasrv.weight = record.data.weight;
					this.dataRecord.datasrv.port = record.data.port;
					this.dataRecord.datasrv.target = record.data.target;
				}

				if (record.type == 'HTTPS') {
					this.dataRecord.datahttps.target = record.data.target;
					this.dataRecord.datahttps.value = record.data.value;
					priorityrecord = record.data.priority;
				}

				if (record.type === 'LOC') {
					this.dataRecord.dataloc.latitude.degrees = record.data.lat_degrees;
					this.dataRecord.dataloc.latitude.minutes = record.data.lat_minutes;
					this.dataRecord.dataloc.latitude.seconds = record.data.lat_seconds;
					this.dataRecord.dataloc.latitude.direction = record.data.lat_direction;
					this.dataRecord.dataloc.longitude.degrees = record.data.long_degrees;
					this.dataRecord.dataloc.longitude.minutes = record.data.long_minutes;
					this.dataRecord.dataloc.longitude.seconds = record.data.long_seconds;
					this.dataRecord.dataloc.longitude.direction = record.data.long_direction;
					this.dataRecord.dataloc.precision.horizontal = record.data.precision_horz;
					this.dataRecord.dataloc.precision.vertical = record.data.precision_vert;
					this.dataRecord.dataloc.precision.altitude = record.data.altitude;
					this.dataRecord.dataloc.precision.size = record.data.size;
				}

				if (record.type === 'CERT') {
					this.dataRecord.datacert.certtype = record.data.type;
					this.dataRecord.datacert.keytag = record.data.key_tag;
					this.dataRecord.datacert.algorithm = record.data.algorithm;
					this.dataRecord.datacert.certificate = record.data.certificate;
				}

				this.dataRecord.type = record.type;
				this.dataRecord.data.name = namerecord;
				this.dataRecord.data.content = contentrecord;
				this.dataRecord.data.ttl = record.ttl;
				this.dataRecord.data.proxied = record.proxied;
				this.dataRecord.data.priority = priorityrecord;
			},
			resetForm(){
				this.idrecord = '';
				this.dataRecord = {
					type:'A',
					data:{name:'',content:'',ttl:1,proxied:false,priority:''},
					datahttps:{target:'',value:''},
					datasrv:{service:'',protocol:'_tcp',weight:'',port:'',target:''},
					dataloc:{
						latitude:{degrees:'',minutes:'',seconds:'',direction:'N'},
						longitude:{degrees:'',minutes:'',seconds:'',direction:'E'},
						precision:{horizontal:'',vertical:'',altitude:'',size:''},
					},
					datacert:{certtype:'',keytag:'',algorithm:'',certificate:''}
				};
			},
			deleteZone(identifier){
				if (confirm(this.trans('Langcore::global.warning_delfile')) == true) {
					console.log(identifier);
					axios.delete(route('dnsmanager.admin.deletezone',{identifier:identifier}))
					.then(response =>{
						window.location.href = route('dnsmanager.admin.main')
					})
					.catch(error=>{
						this.errors = error.response.data.errors.name
					})
				}
			}
		}
	}
</script>
<style lang="scss" scoped="">
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
	.changeProxied {
		cursor: pointer;
	}
</style>