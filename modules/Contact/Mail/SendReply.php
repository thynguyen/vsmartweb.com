<?php

namespace Modules\Contact\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use CFglobal;

class SendReply extends Mailable
{
    use Queueable, SerializesModels;
    public $contact;
    public $messenger;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact,$messenger)
    {
        $this->contact = $contact;
        $this->messenger = $messenger;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $messenger = $this->messenger;
        $data = $this->contact;
        return $this->subject(transmod('contact::Feedback').': '.$data['title'])
                ->markdown('contact::emails.sendreply')->with(['data'=>$data,'messenger'=>$messenger]);
    }
}
