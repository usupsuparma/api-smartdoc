<?php namespace App\Jobs;

use App\Mail\SendEmailChangePassword;
use Mail;
use App\Jobs\Job;

class SendEmailChangePasswordJob extends Job
{
	
    protected $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new SendEmailChangePassword($this->details);
        Mail::to($this->details['email'], $this->details['name'])->send($email);
    }
}
