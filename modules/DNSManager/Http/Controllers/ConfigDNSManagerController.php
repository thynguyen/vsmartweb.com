<?php

namespace Modules\DNSManager\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use CFglobal;

class ConfigDNSManagerController extends Controller
{
    public function config(){
        $data = [];
        return FileViewTheme('DNSManager','config',$data,'admin');
    }
    public function PostConfig(Request $request){
        $cloudflare = $request->cloudflare;
        $data = [
            'CLOUDFLARE_EMAIL'=>$cloudflare['email'],
            'CLOUDFLARE_APIKEY'=>$cloudflare['apikey']
        ];
        $updateenv = CFglobal::UpdateOrEditENV($data);
        if ($updateenv == true) {
            return response([
                'result' => 'success'
            ], 200);
        } else {
            return response([
                'result' => 'error'
            ], 404);
        }
    }
    public function envcfmod(){
        $data = [
            'cloudflare_email'=>env('CLOUDFLARE_EMAIL'),
            'cloudflare_apikey'=>env('CLOUDFLARE_APIKEY')
        ];
        return $data;
    }
}
