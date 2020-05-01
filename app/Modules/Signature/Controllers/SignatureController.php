<?php namespace App\Modules\Signature\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Signature\Repositories\SignatureRepositories;
use Authority, Auth, Storage;
use App\Modules\Signature\Models\SignatureModel;

class SignatureController extends BaseController 
{
	private $signatureRepository;
	
	public function __construct(SignatureRepositories $signatureRepository) 
	{
		$this->signatureRepository = $signatureRepository;
		Authority::acl_access(Auth::user(), 'digital-signatures');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->signatureRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->showOne($this->signatureRepository->show($id),200);
	}
	
	public function create(Request $request)
	{
		Authority::check('create');
		
        return $this->successResponse($this->signatureRepository->create($request), 200); 
	}
	
	public function update(Request $request, $id)
    {
		Authority::check('update');
		
		return $this->successResponse($this->signatureRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->signatureRepository->delete($id), 200); 
	}
	
	public function download($id)
    {
		$path = storage_path('app/public'. $this->signatureRepository->download($id));

		return response()->download($path);
	}
	
	public function generate(Request $request, $employee_id)
    {
		$results = $this->signatureRepository->generate($request, $employee_id);
		
		if (!$results['status']) {
			return $this->errorResponse($results, 500);
		}
		
		return $this->successResponse($results, 200); 
	}
	
	public function check()
    {	
		return $this->successResponse($this->signatureRepository->check_available_sign(), 200); 
    }
}