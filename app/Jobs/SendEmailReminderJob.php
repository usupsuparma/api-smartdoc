<?php namespace App\Jobs;

use App\Mail\SendEmailReminder;
use Mail;
use App\Jobs\Job;

class SendEmailReminderJob extends Job
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
        $email = new SendEmailReminder([]);
        Mail::to('aelgees.dev@gmail.com', 'Adam Lesmana')->send($email);
    }
}
