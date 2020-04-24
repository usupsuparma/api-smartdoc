<?php namespace App\Modules\IncomingMail\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\IncomingMail\Repositories\IncomingMailRepositories;
use Authority, Auth;

class IncomingMailController extends BaseController 
{
	private $incomingMailRepository;
	
	public function __construct(IncomingMailRepositories $incomingMailRepository) 
	{
		$this->incomingMailRepositories = $incomingMailRepository;
		Authority::acl_access(Auth::user(), 'incoming-mails');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->incomingMailRepositories->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->successResponse($this->incomingMailRepositories->show($id),200);
	}
	
	public function create(Request $request)
	{
		Authority::check('create');
		
		$results = $this->incomingMailRepositories->create($request);
		
		if (!$results['status']) {
			return $this->errorResponse($results, 404);
		}
		
        return $this->successResponse($results, 200);
	}
	
	public function update(Request $request,$id)
    {
		Authority::check('update');
		
		return $this->successResponse($this->incomingMailRepositories->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->incomingMailRepositories->delete($id), 200); 
	}
	
	public function delete_attachment($id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->incomingMailRepositories->delete_attachment($id), 200); 
	}
	
	public function download_attachment($attachment_id)
    {
		$path = storage_path('app/public'. $this->incomingMailRepositories->download_attachment($attachment_id));

		return response()->download($path, basename($path));
	}
}