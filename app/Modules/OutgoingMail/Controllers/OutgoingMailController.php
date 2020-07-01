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
			return $this->errorResponse($results, 500);
		}
		
        return $this->successResponse($results, 200);
	}
	
	public function update(Request $request,$id)
    {
		Authority::check('update');
		
		$results = $this->outgoingMailRepository->update($request, $id);
		
		if (!$results['status']) {
			return $this->errorResponse($results, 500);
		}
		
		return $this->successResponse($results, 200); 
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
	
	public function download_attachment($attachment_id)
    {
		$path = storage_path('app/public'. $this->outgoingMailRepository->download_attachment($attachment_id));

		return response()->download($path, basename($path));
	}
	
	public function download_attachment_main($id)
    {
		$path = storage_path('app/public'. $this->outgoingMailRepository->download_attachment_main($id));

		return response()->download($path, basename($path));
	}
}