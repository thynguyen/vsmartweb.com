<?php

namespace Modules\EmailMarketing\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Newsletter,Response,File;
use Illuminate\Support\Str;
use Core\TinyMinify;

class AdminEmailMarketingController extends Controller
{
    public function __construct()
    {
        $this->getapi = Newsletter::getApi();
        //$this->getapi->get('search-members',['query'=>'vsmartweb']) API Tìm kiếm
    }
	public function main(){
        $members = Newsletter::getMembers($string = '');
        $data = ['members'=>$members];
        return FileViewTheme('EmailMarketing','main',$data,'admin');
    }
    public function subscribe(Request $request){
        $email = $request->email;
        $member = Newsletter::getMember($email);
        if ($member['status'] == 'subscribed') {
            Newsletter::unsubscribe($email);
            $mes = 'Unsubscribed successfully';
        } elseif ($member['status'] == 'unsubscribed') {
            Newsletter::subscribeOrUpdate($email);
            $mes = transmod('EmailMarketing::SubscribedSuccessfully');
        }
        
        return $mes;
    }

    public function deleteemail(Request $request){
        $email = $request->email;
        if (Newsletter::hasMember($email) == 1) {
            Newsletter::deletePermanently($email);
            return 'Delete successfully';
        }
        return 'ERROR';
    }

    public function campaign(){
        $campaigns = $this->getapi->get('campaigns');
        $data = ['campaigns'=>$campaigns['campaigns']];
        return FileViewTheme('EmailMarketing','campaign',$data,'admin');
    }
    public function addcampaign(){
        $data = [];
        return FileViewTheme('EmailMarketing','addcampaign',$data,'admin');
    }

    public function postaddcampaign(Request $request){
        $cssstyle = file_get_contents(asset('modules/js/emailmarketing/assets/email-blocks/content.css'));
        $fromName = env('MAIL_FROM_NAME');
        $replyTo = env('MAIL_FROM_ADDRESS');
        $subject = $request->subject;
        // $data = [
        //     'cssstyle'=>$cssstyle,
        //     'subject'=>$subject,
        //     'contents'=>$request->contents
        // ];
        // $contents = FileViewTheme('EmailMarketing','emailtemplate',$data,'admin');
        $contents = $request->contents;
        $listName = '';
        $newcampaign = Newsletter::createCampaign($fromName,$replyTo,$subject, $contents,$listName);
        if ($request->sent == 1) {
            $send = $this->getapi->post('campaigns/'.$newcampaign['id'].'/actions/send');
        }
        return redirect()->route('emailmarketing.admin.campaign') -> with('success', trans('Langcore::global.SaveSuccess'));
    }

    public function editcampaign($id){
        $campaign = $this->getapi->get('campaigns/'.$id.'/content');
        $footer = TinyMinify::html(file_get_contents(module_path('EmailMarketing','/ft_email.html')));
        $html = !empty($campaign['html'])?TinyMinify::html($campaign['html']):'';
        $data = ['id'=>$id,'campaign'=>str_replace($footer,'',$html)];
        return FileViewTheme('EmailMarketing','editcampaign',$data,'admin');
    }
    public function posteditcampaign(Request $request,$id){
        $contents = $request->contents;
        $campaign = $this->getapi->put('campaigns/'.$id.'/content', ['html' => $contents]);
        return redirect()->route('emailmarketing.admin.campaign') -> with('success', trans('Langcore::global.SaveSuccess'));
    }
    public function sentcampaign(Request $request){
        $id = $request->id;
        $send = $this->getapi->post('campaigns/'.$id.'/actions/send');
        return transmod('EmailMarketing::SentSuccessfully');
    }

    public function delcampaign(Request $request){
        $id = $request->id;
        if ($this->getapi->delete('campaigns/'.$id)) {
            return Response::json(trans('Langcore::global.DelSuccess'), 200);
        }
        return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
    }

    public function viewreport($id){
        $campaign = $this->getapi->get('reports/'.$id);
        $campaign_open = $this->getapi->get('reports/'.$id.'/open-details');
        $campaign_unsubscribed = $this->getapi->get('reports/'.$id.'/unsubscribed?fields=unsubscribes.email_address,unsubscribes.timestamp');
        $data = [
            'campaign'=>$campaign,
            'campaign_open'=>$campaign_open,
            'campaign_unsubscribed'=>$campaign_unsubscribed
        ];
        return FileViewTheme('EmailMarketing','viewreport',$data,'admin');
    }
    public function verifieddomains(){
        $verifieddomains = $this->getapi->get('verified-domains');
        $data = ['verifieddomains'=>$verifieddomains];
        return FileViewTheme('EmailMarketing','verifieddomains',$data,'admin');
        // dd($verifieddomains);
    }

    public function adddomain(){
        $data = [];
        return FileViewTheme('EmailMarketing','adddomain',$data,'admin');
    }
    public function postadddomain(Request $request){
        $email = $request->email;
        $verifieddomains = $this->getapi->post('verified-domains',['verification_email'=>$email]);
        return redirect()->back()->with('success', trans('Langcore::global.SaveSuccess'));
    }

    public function entercode($domain){
        $verifieddomains = $this->getapi->get('verified-domains/'.$domain);
        $data = [
            'domain'=>$verifieddomains
        ];
        return FileViewTheme('EmailMarketing','entercode',$data,'admin');
    }
    public function postentercode(Request $request,$domain){
        $code = $request->code;
        $verifieddomains = $this->getapi->post('verified-domains/'.$domain.'/actions/verify',['code'=>$code]);
        if (!empty($verifieddomains['status'])&&($verifieddomains['status']=='404' || $verifieddomains['status']=='400')) {
            return Response::json(transmod('EmailMarketing::InvalidVerificationCode'), 404);
        } else {
            return Response::json(transmod('EmailMarketing::VerificationSuccessful'), 200);
        }
    }

    public function deletedomain(Request $request){
        $domain = $request->domain;
        if ($this->getapi->delete('verified-domains/'.$domain)) {
            return Response::json(trans('Langcore::global.DelSuccess'), 200);
        }
        return Response::json(trans('Langcore::global.CannotBeDeleted'), 404);
    }
}