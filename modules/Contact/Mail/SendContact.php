<?php

namespace Modules\Contact\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Contact\Entities\PartsContact;
use CFglobal;

class SendContact extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $part = PartsContact::find($data['partid']);
        $url = route('contact.admin.main');
        return $this->subject(transmod('contact::NewContact').':'.$data['title'])
                ->markdown('contact::emails.sendcontact')->with(['data'=>$data,'part'=>$part,'url'=>$url]);
    }
}
