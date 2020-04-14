<?php namespace App\Modules\OutgoingMail\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\OutgoingMail\Models\OutgoingMailModel;
use App\Modules\OutgoingMail\Repositories\OutgoingMailRepositories;
use Authority, Auth;

class OutgoingMailController extends BaseController 
{
	private $outgoingMailRepository;
	
	public function __construct(OutgoingMailRepositories $outgoingMailRepository) 
	{
		$this->outgoingMailRepository = $outgoingMailRepository;
		Authority::acl_access(Auth::user(), 'outgoing-mails');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->outgoingMailRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->successResponse($this->outgoingMailRepository->show($id),200);
	}
	
	public function create(Request $request)
	{
		Authority::check('create');
		
		$results = $this->outgoingMailRepository->create($request);
		
		if (!$results['status']) {
			return $this->errorResponse($results, 422);
		}
		
        return $this->successResponse($results, 200);
	}
	
	public function update(Request $request,$id)
    {
		Authority::check('update');
		
		return $this->successResponse($this->outgoingMailRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->outgoingMailRepository->delete($id), 200); 
	}
	
	public function delete_attachment($id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->outgoingMailRepository->delete_attachment($id), 200); 
	}
	
	public function approval(Request $request)
	{
		Authority::check('approve');
		
        return $this->successResponse($this->outgoingMailRepository->approval($request), 200); 
	}
	
	public function publish(Request $request)
	{
		Authority::check('approve');
		
        return $this->successResponse($this->outgoingMailRepository->publish($request), 200); 
	}
}