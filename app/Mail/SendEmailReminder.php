<?php namespace App\Mail;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailReminder extends Mailable
{
	use Queueable, SerializesModels;
	
    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Smartdoc Notification')
                    ->from(setting_by_code('MAIL_FROM_EMAIL'), setting_by_code('MAIL_FROM_NAME'))
                    ->view('emails.reminder-review')
                    ->with([
                        'notification_action' => $this->details['notification_action'],
                        'body' => $this->details['body'],
                        'button' => $this->details['button'],
                        'url' => $this->details['url'],
                    ]);
    }
}
