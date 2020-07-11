<?php namespace App\Mail;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailChangePassword extends Mailable
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
        return $this->subject('Smartdoc - Change Password')
                    ->from(setting_by_code('MAIL_FROM_EMAIL'), setting_by_code('MAIL_FROM_NAME'))
                    ->view('emails.change-password')
                    ->with([
                        'new_confirm_password' => $this->details['new_confirm_password']
                    ]);
    }
}
