<?php namespace App\Modules\Test\Controllers;

use Illuminate\Http\Request;
use App\Modules\Test\Models\TestModel;
use App\Library\Bases\BaseController;
use App\Modules\Test\Repositories\TestRepositories;
use App\Jobs\SendEmailReminderJob;
use App\Mail\SendEmailReminder;
use Mail;
use OneSignal;
class TestController extends BaseController
{
	private $testRepository;
	
    public function __construct(TestRepositories $testRepository)
    {
        $this->testRepository = $testRepository;
	}
	
	public function data(Request $request)
	{
		return $this->showAll($this->testRepository->data($request),200);
	}
	
	public function show($id)
	{
		return $this->showOne(TestModel::findOrFail($id),200);
	}
	
	public function create(Request $request)
	{
        return $this->successResponse($this->testRepository->create($request), 200); 
	}
	
	public function update(Request $request,$id)
    {
		return $this->successResponse($this->testRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
        $this->successResponse($this->testRepository->delete($id), 200); 
	}
	
	public function generate(Request $request)
	{
		return $this->testRepository->generate($request);
	}
	
	public function send_email()
	{
		// $template = new SendEmailReminder([]);
		// Mail::to('aelgees.dev@gmail.com', 'Adam Lesmana')->send($template);
		
		$body = config('constans.email.'. 2);
		$origin = ["#category#", "#subject#"];
		$replace   = ["Surat Masuk", "Ini Subject"];
		$newBody = str_replace($origin, $replace, $body);
		
		$data = [
			'email' => 'aelgees.dev@gmail.com',
			'name'  => 'Adam Lesmana',
			'notification_action' => config('constans.notif-email.'. 2),
			'body' => $newBody,
			'button' => true,
			'url' => 'https://google.com',
		];
		
		$this->dispatch(new SendEmailReminderJob($data));
		dd('a');
	}
	
	public function notification_signal()
	{		
		push_notif([
			'device_id' => 'e0aac846-417d-43f6-b236-b70cc2c78c64',
			'data' => null,
			'heading' => 'Title Heading Test',
			'content' => 'Ini Testing Message'
		]);
		
		dd('send');
	}
}
