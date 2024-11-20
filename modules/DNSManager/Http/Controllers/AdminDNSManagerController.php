<?php

namespace Modules\DNSManager\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Cloudflare\API\Auth\APIKey;
use Cloudflare\API\Adapter\Guzzle;
use Cloudflare\API\Endpoints\Zones;
use Cloudflare\API\Endpoints\DNS;

class AdminDNSManagerController extends Controller
{
    public function main(){
        $data = [];
        return FileViewTheme('DNSManager','main',$data,'admin');
    }
    public function getlistzones(Request $request){
        $page = $request->page;
        $perpage = $request->perpage;
        $zones = new Zones($this->adapter());
        return json_encode($zones->listZones('','',$page,$perpage));
    }
    public function deletezone(Request $response,$identifier){
        $zone = new Zones($this->adapter());
        $delzone = $zone->deleteZone($identifier);
        if($delzone == true){
            return response([
                'result' => 'success'
            ], 200);
        } else {
            return response([
                'result' => 'error'
            ], 404);
        }
        
    }
    public function managerdomain($zoneid){
        $zone = new Zones($this->adapter());
        $data = [
            'zone'=>json_encode($zone->getZoneById($zoneid))
        ];
        return FileViewTheme('DNSManager','managerdomain',$data,'admin');
    }
    public function createzone(Request $request){
        $name = $request->name;
        $zone = new Zones($this->adapter());
        $createzone = $zone->addZone($name);
        if($createzone->status == 'pending' || $createzone->status == 'active'){
            return response([
                'result' => 'success'
            ], 200);
        } else {
            return response([
                'result' => 'error'
            ], 404);
        }
        
    }
    public function getlistrecord(Request $request){
        $zoneid = $request->zoneid;
        $page = $request->page;
        $perpage = $request->perpage;
        $listrecords = new DNS($this->adapter());
        return json_encode($listrecords->listRecords($zoneid,'','','',$page,$perpage));
    }
    public function createrecord(Request $request,$id='null'){
        $record = new DNS($this->adapter());
        $priority = ($request->priority)?$request->priority:'';
        if ($id=='null') {
            $addrecord = $record->addRecord($request->zoneid,$request->type,$request->name,$request->content,$request->ttl,$request->proxied,$priority,$request->data);
            if($addrecord == true){
                return response([
                    'result' => 'success'
                ], 200);
            } else {
                return response([
                    'result' => 'error'
                ], 404);
            }
        } else {
            $details = [
                'type'=>$request->type,
                'name'=>$request->name,
                'content'=>$request->content,
                'ttl'=>$request->ttl,
                'proxied'=>$request->proxied
            ];
            if (is_numeric($request->priority)) {
                $details['priority'] = (int)$request->priority;
            }
            if ($request->data) {
                $details['data'] = $request->data;
            }
            $addrecord = $record->updateRecordDetails($request->zoneid,$id,$details);
            if ($addrecord->success == true) {
                return response([
                    'result' => 'success'
                ], 200);
            } else {
                return response([
                    'result' => 'error'
                ], 404);
            }
        }
    }
    public function delrecord($zoneid,$id){
        $record = new DNS($this->adapter());
        $delrecord = $record->deleteRecord($zoneid,$id);
        if($delrecord == 1){
            return response([
                'result' => 'success'
            ], 200);
        } else {
            return response([
                'result' => 'error'
            ], 404);
        }
    }

    protected function adapter() {
        $key     = new APIKey(env('CLOUDFLARE_EMAIL'), env('CLOUDFLARE_APIKEY'));
        $adapter = new Guzzle($key);
        return $adapter;
    }
}
