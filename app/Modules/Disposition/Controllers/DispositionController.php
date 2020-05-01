<?php namespace App\Modules\Disposition\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Disposition\Repositories\DispositionRepositories;
use Authority, Auth;

class DispositionController extends BaseController 
{
	private $dispositionRepository;
	
	public function __construct(DispositionRepositories $dispositionRepository) 
	{
		$this->dispositionRepositories = $dispositionRepository;
		// Authority::acl_access(Auth::user(), 'dispositions');
	}
	
	public function data(Request $request)
	{
		// Authority::check('read');
		
		return $this->showAll($this->dispositionRepositories->data($request),200);
	}
	
	public function show($id)
	{
		// Authority::check('read');
		
		return $this->successResponse($this->dispositionRepositories->show($id),200);
	}
	
	public function create(Request $request)
	{
		// Authority::check('create');
		
		$results = $this->dispositionRepositories->create($request);
		
		if (!$results['status']) {
			return $this->errorResponse($results['message'], 404);
		}
		
        return $this->successResponse($results, 200);
	}
	
	public function update(Request $request,$id)
    {
		// Authority::check('update');
		
		return $this->successResponse($this->dispositionRepositories->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
		// Authority::check('delete');
		
        return $this->successResponse($this->dispositionRepositories->delete($id), 200); 
	}
	
	public function download_incoming($incoming_mail_id)
    {
		// Authority::check('export');
		
		$path = storage_path('app/public'. $this->dispositionRepositories->download_incoming($incoming_mail_id));

		return response()->download($path, basename($path));
	}
	
	public function download_main($id)
    {
		// Authority::check('export');
		
		$path = storage_path('app/public'. $this->dispositionRepositories->download_main($id));

		return response()->download($path, basename($path));
	}
	
	public function download_follow($follow_up_id)
    {
		// Authority::check('export');
		
		$path = storage_path('app/public'. $this->dispositionRepositories->download_follow($follow_up_id));

		return response()->download($path, basename($path));
	}
}