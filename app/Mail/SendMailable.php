<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $subject;
    public $email;
    public $template;

    public $to_name;
    public $from_email;
    public $to_email;
    public $from_name;
    public $process_name;
    public $show_to_client;
    public $sent;
    public $company_id;
    public $file;
    public $files;
    public $mail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content, $subject = "test subject")
    {
        $this->content =  $content;
        $this->subject = $subject;
        
        $this->to_email = 'info@capital-office.co.uk';
        $this->to_name = 'Capital Office UK';
        $this->mail = 'info@capital-office.co.uk';
        $this->from_email = 'info@capital-office.co.uk';
        $this->from_name = 'Capital Office UK';
        $this->process_name = 'PROCESS NAME';
        $this->show_to_client = 0;
        $this->sent = 0;
        $this->company_id = 0;
        $this->file = '';        
        $this->files = [];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject($this->subject)->view('mail.mail');

        if (!empty($this->file)) {
            $mail->attach($this->file);
        }

        if (!empty($this->files)) {
            foreach($this->files as $f) {
                if (!empty($f)) {
                    $mail->attach($f);
                }
            }
        }

        return $mail;
    }
}

